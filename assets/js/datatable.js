/**
 * DATATABLE.JS — Samriddhi-Ventures ERP
 * Custom AJAX-powered DataTable component.
 * Implements Search, Sort, Pagination, Filtering, CSV Export, and Bulk Actions.
 */

class AppDataTable {
  constructor(options) {
    const defaults = {
      tableSelector: null,
      ajaxUrl: null, // Endpoint to load data
      collection: null, // Collection name for Api.php (if applicable)
      columns: [], // [{ data: 'name', sortable: true, render: (val, row) => val }]
      pageSize: 10,
      paginationSelector: null,
      searchSelector: null,
      filterSelectors: {}, // { key: selector }
      exportSelector: null,
      bulkCheckAllSelector: null,
      bulkActionCallback: null, // function(selectedIds, actionName)
      onDraw: null // callback when table redraws
    };

    this.settings = $.extend({}, defaults, options);
    this.$table = $(this.settings.tableSelector);
    this.$tbody = this.$table.find('tbody');
    if (!this.$tbody.length) {
      this.$tbody = $('<tbody></tbody>').appendTo(this.$table);
    }

    this.data = []; // Loaded data
    this.filteredData = []; // Data after filters/search
    this.currentPage = 1;
    this.sortField = null;
    this.sortOrder = 'asc'; // 'asc' or 'desc'
    this.selectedIds = new Set();

    this.init();
  }

  init() {
    if (!this.$table.length) return;

    // Build header if columns are provided and header is empty
    this.buildHeader();

    // Bind Search Input
    if (this.settings.searchSelector) {
      const self = this;
      $(this.settings.searchSelector).on('input', function() {
        self.currentPage = 1;
        self.applyFiltersAndDraw();
      });
    }

    // Bind Filter Selects
    if (this.settings.filterSelectors) {
      const self = this;
      Object.keys(this.settings.filterSelectors).forEach(key => {
        const selector = this.settings.filterSelectors[key];
        $(selector).on('change', function() {
          self.currentPage = 1;
          self.applyFiltersAndDraw();
        });
      });
    }

    // Bind Sorting Headers
    const self = this;
    this.$table.find('thead th[data-sortable="true"]').css('cursor', 'pointer').on('click', function() {
      const field = $(this).data('field');
      if (self.sortField === field) {
        self.sortOrder = self.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        self.sortField = field;
        self.sortOrder = 'asc';
      }
      
      // Update header indicators
      self.$table.find('thead th[data-sortable="true"]').removeClass('sorting-asc sorting-desc');
      $(this).addClass(self.sortOrder === 'asc' ? 'sorting-asc' : 'sorting-desc');

      self.applyFiltersAndDraw();
    });

    // Bind Bulk Checkbox
    if (this.settings.bulkCheckAllSelector) {
      $(this.settings.bulkCheckAllSelector).on('change', function() {
        const isChecked = $(this).is(':checked');
        self.$tbody.find('.bulk-checkbox').prop('checked', isChecked).trigger('change');
      });

      // Delegate row checkboxes to gather selected IDs
      this.$tbody.on('change', '.bulk-checkbox', function() {
        const id = $(this).val();
        if ($(this).is(':checked')) {
          self.selectedIds.add(id);
        } else {
          self.selectedIds.delete(id);
        }
        
        // Update check-all status
        const totalRows = self.$tbody.find('.bulk-checkbox').length;
        const checkedRows = self.$tbody.find('.bulk-checkbox:checked').length;
        $(self.settings.bulkCheckAllSelector).prop('checked', totalRows > 0 && totalRows === checkedRows);
      });
    }

    // Bind Export Button
    if (this.settings.exportSelector) {
      $(this.settings.exportSelector).on('click', (e) => {
        e.preventDefault();
        this.exportToCSV();
      });
    }

    // CSS inject for sorting icons
    this.injectSortingStyles();

    // Initial Load
    this.reload();
  }

  injectSortingStyles() {
    if ($('#sv-dt-styles').length) return;
    $('head').append(`
      <style id="sv-dt-styles">
        th[data-sortable="true"] { position: relative; padding-right: 20px !important; }
        th[data-sortable="true"]::after { content: ' ⇅'; opacity: 0.3; position: absolute; right: 6px; }
        th.sorting-asc::after { content: ' ▲'; opacity: 0.8; color: var(--gold, #c8931a); }
        th.sorting-desc::after { content: ' ▼'; opacity: 0.8; color: var(--gold, #c8931a); }
        .dt-pag-btn {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 6px 12px;
          margin: 0 3px;
          border: 1px solid var(--border, rgba(200,147,26,0.15));
          background: transparent;
          color: var(--text, #333);
          border-radius: 6px;
          font-size: 12px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
        }
        [data-theme="dark"] .dt-pag-btn {
          color: rgba(255,255,255,0.8);
        }
        .dt-pag-btn:hover:not(:disabled) {
          background: var(--gold-pale, rgba(200,147,26,0.08));
          border-color: var(--gold, #c8931a);
        }
        .dt-pag-btn.active {
          background: linear-gradient(135deg, var(--gold, #c8931a), var(--saffron, #ef4444));
          color: white !important;
          border-color: transparent;
        }
        .dt-pag-btn:disabled {
          opacity: 0.4;
          cursor: not-allowed;
        }
      </style>
    `);
  }

  buildHeader() {
    const $thead = this.$table.find('thead');
    if ($thead.find('tr').length) return; // Header already exists
    
    let trHtml = '<tr>';
    
    // Add bulk checkbox column if needed
    if (this.settings.bulkCheckAllSelector) {
      trHtml += `<th style="width: 40px"><input type="checkbox" id="${this.settings.bulkCheckAllSelector.replace('#','')}" class="dt-check-all"></th>`;
    }

    this.settings.columns.forEach(col => {
      const sortableAttr = col.sortable !== false ? 'data-sortable="true" data-field="' + (col.data || '') + '"' : '';
      trHtml += `<th ${sortableAttr}>${col.title || ''}</th>`;
    });
    
    trHtml += '</tr>';
    $thead.html(trHtml);
  }

  reload() {
    if (!this.settings.ajaxUrl) return;

    let url = this.settings.ajaxUrl;
    if (this.settings.collection) {
      url += (url.includes('?') ? '&' : '?') + 'collection=' + this.settings.collection;
    }

    if (typeof AppAjax !== 'undefined') {
      AppAjax.get(url, (res) => {
        this.data = Array.isArray(res) ? res : (res.data || []);
        this.selectedIds.clear();
        if (this.settings.bulkCheckAllSelector) {
          $(this.settings.bulkCheckAllSelector).prop('checked', false);
        }
        this.applyFiltersAndDraw();
      }, (xhr, status, error) => {
        this.$tbody.html(`<tr><td colspan="${this.settings.columns.length + (this.settings.bulkCheckAllSelector ? 1 : 0)}" style="text-align:center;padding:24px;color:#EF4444">Failed to load data: ${error}</td></tr>`);
      });
    } else {
      $.getJSON(url, (res) => {
        this.data = Array.isArray(res) ? res : (res.data || []);
        this.applyFiltersAndDraw();
      });
    }
  }

  setData(newData) {
    this.data = Array.isArray(newData) ? newData : [];
    this.selectedIds.clear();
    this.applyFiltersAndDraw();
  }

  applyFiltersAndDraw() {
    let result = [...this.data];

    // 1. Apply Global/Local Search
    if (this.settings.searchSelector) {
      const q = $(this.settings.searchSelector).val().toLowerCase().trim();
      if (q) {
        result = result.filter(row => {
          return this.settings.columns.some(col => {
            if (!col.data) return false;
            const val = row[col.data];
            return val !== null && val !== undefined && String(val).toLowerCase().includes(q);
          });
        });
      }
    }

    // 2. Apply Custom Select Filters
    if (this.settings.filterSelectors) {
      Object.keys(this.settings.filterSelectors).forEach(key => {
        const selector = this.settings.filterSelectors[key];
        const val = $(selector).val();
        if (val && val !== 'All' && val !== 'All Plans' && val !== 'All Status') {
          result = result.filter(row => {
            const rowVal = row[key];
            if (rowVal === null || rowVal === undefined) return false;
            // Case insensitive/approximate match
            return String(rowVal).toLowerCase() === String(val).toLowerCase();
          });
        }
      });
    }

    // 3. Apply Sorting
    if (this.sortField) {
      const field = this.sortField;
      const order = this.sortOrder === 'asc' ? 1 : -1;
      result.sort((a, b) => {
        const valA = a[field] ?? '';
        const valB = b[field] ?? '';
        if (typeof valA === 'number' && typeof valB === 'number') {
          return (valA - valB) * order;
        }
        return String(valA).localeCompare(String(valB)) * order;
      });
    }

    this.filteredData = result;
    this.draw();
  }

  draw() {
    this.$tbody.empty();
    const totalRecords = this.filteredData.length;

    if (totalRecords === 0) {
      const colSpan = this.settings.columns.length + (this.settings.bulkCheckAllSelector ? 1 : 0);
      this.$tbody.append(`<tr><td colspan="${colSpan}" style="text-align:center;padding:24px;color:var(--text-muted)">No matching records found.</td></tr>`);
      this.drawPagination(0);
      if (this.settings.onDraw) this.settings.onDraw(this.filteredData);
      return;
    }

    const startIndex = (this.currentPage - 1) * this.settings.pageSize;
    const endIndex = Math.min(startIndex + this.settings.pageSize, totalRecords);
    const pageData = this.filteredData.slice(startIndex, endIndex);

    pageData.forEach(row => {
      let trHtml = '<tr>';

      // Bulk Action Checkbox
      if (this.settings.bulkCheckAllSelector) {
        const isChecked = this.selectedIds.has(String(row.id)) ? 'checked' : '';
        trHtml += `<td><input type="checkbox" class="bulk-checkbox" value="${row.id}" ${isChecked}></td>`;
      }

      this.settings.columns.forEach(col => {
        const val = col.data ? row[col.data] : null;
        let cellContent = val;
        
        if (col.render) {
          cellContent = col.render(val, row);
        } else if (val === null || val === undefined) {
          cellContent = '';
        }

        trHtml += `<td>${cellContent}</td>`;
      });

      trHtml += '</tr>';
      this.$tbody.append(trHtml);
    });

    this.drawPagination(totalRecords);
    if (this.settings.onDraw) this.settings.onDraw(pageData);
  }

  drawPagination(totalRecords) {
    if (!this.settings.paginationSelector) return;
    const $container = $(this.settings.paginationSelector);
    $container.empty();

    const totalPages = Math.ceil(totalRecords / this.settings.pageSize);
    if (totalPages <= 1) return; // No pagination needed

    // Prev Button
    const $prevBtn = $(`<button class="dt-pag-btn" ${this.currentPage === 1 ? 'disabled' : ''}>◀ Prev</button>`);
    $prevBtn.on('click', () => {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.draw();
      }
    });
    $container.append($prevBtn);

    // Page Numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, this.currentPage - 2);
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage < maxVisiblePages - 1) {
      startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
      const $pageBtn = $(`<button class="dt-pag-btn ${i === this.currentPage ? 'active' : ''}">${i}</button>`);
      $pageBtn.on('click', () => {
        this.currentPage = i;
        this.draw();
      });
      $container.append($pageBtn);
    }

    // Next Button
    const $nextBtn = $(`<button class="dt-pag-btn" ${this.currentPage === totalPages ? 'disabled' : ''}>Next ▶</button>`);
    $nextBtn.on('click', () => {
      if (this.currentPage < totalPages) {
        this.currentPage++;
        this.draw();
      }
    });
    $container.append($nextBtn);
  }

  exportToCSV() {
    if (this.filteredData.length === 0) {
      if (typeof AppNotification !== 'undefined') {
        AppNotification.toast('No data available to export', 'warning');
      }
      return;
    }

    const headers = this.settings.columns.map(col => `"${col.title || ''}"`).join(',');
    const rows = this.filteredData.map(row => {
      return this.settings.columns.map(col => {
        let val = '';
        if (col.data) {
          val = row[col.data];
          if (val === null || val === undefined) val = '';
          // Strip HTML tag helper if value is HTML
          val = String(val).replace(/<[^>]*>/g, '');
          // Escape quotes
          val = val.replace(/"/g, '""');
        }
        return `"${val}"`;
      }).join(',');
    });

    const csvContent = "data:text/csv;charset=utf-8,\uFEFF" + [headers, ...rows].join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `${this.settings.collection || 'export'}_data_${Date.now()}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }
  
  getSelectedIds() {
    return Array.from(this.selectedIds);
  }
}

window.AppDataTable = AppDataTable;
