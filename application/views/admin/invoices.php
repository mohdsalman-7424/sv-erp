<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">🧾 Invoices</div>
    <div class="page-header-sub">Manage and view customer billing invoices</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" id="btnExportInvoices">⬇ Export CSV</button>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="invoiceSearch" placeholder="Search invoices..."></div>
      <div>
        <select class="filter-select sumo" id="filterStatus">
          <option value="">All Status</option>
          <option value="Paid">Paid</option>
          <option value="Pending">Pending</option>
          <option value="Unpaid">Unpaid</option>
        </select>
      </div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="invoiceTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="invoice_no">Invoice No</th>
            <th data-sortable="true" data-field="user_name">Customer</th>
            <th data-sortable="true" data-field="amount">Subtotal</th>
            <th data-sortable="true" data-field="gst">GST</th>
            <th data-sortable="true" data-field="total">Total Amount</th>
            <th data-sortable="true" data-field="payment_status">Status</th>
            <th data-sortable="true" data-field="created_at">Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="8" style="text-align:center;padding:24px;color:var(--text-muted)">Loading invoices...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="invoicePagination"></div>
  </div>
</div>

<!-- View Invoice Modal -->
<div class="modal-overlay" id="viewInvoiceModal">
  <div class="modal" style="max-width: 600px;">
    <div class="modal-header">
      <div class="modal-title">Invoice Detail</div>
      <button class="modal-close" onclick="closeModal('viewInvoiceModal')">✕</button>
    </div>
    <div id="viewInvoiceBody" style="padding: 10px 0;">
      <!-- Dynamic content -->
    </div>
  </div>
</div>

<script>
let invoiceTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  invoiceTableInstance = new AppDataTable({
    tableSelector: '#invoiceTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'invoices',
    pageSize: 10,
    paginationSelector: '#invoicePagination',
    searchSelector: '#invoiceSearch',
    filterSelectors: {
      payment_status: '#filterStatus'
    },
    exportSelector: '#btnExportInvoices',
    columns: [
      {
        data: 'invoice_no',
        title: 'Invoice No',
        render: function(val) {
          return `<strong style="color:var(--navy)">${escapeHtml(val)}</strong>`;
        }
      },
      {
        data: 'user_name',
        title: 'Customer',
        render: function(val) { return escapeHtml(val); }
      },
      {
        data: 'amount',
        title: 'Subtotal',
        render: function(val) { return `₹${Number(val).toFixed(2)}`; }
      },
      {
        data: 'gst',
        title: 'GST (18%)',
        render: function(val) { return `₹${Number(val).toFixed(2)}`; }
      },
      {
        data: 'total',
        title: 'Total Amount',
        render: function(val) { return `<strong style="color:var(--saffron)">₹${Number(val).toFixed(2)}</strong>`; }
      },
      {
        data: 'payment_status',
        title: 'Status',
        render: function(val) {
          const status = String(val).toLowerCase();
          if (status === 'paid') return '<span class="badge badge-success">Paid</span>';
          if (status === 'pending') return '<span class="badge badge-warning">Pending</span>';
          return '<span class="badge badge-danger">Unpaid</span>';
        }
      },
      {
        data: 'created_at',
        title: 'Date',
        render: function(val) { return `<span style="font-size:11px;color:var(--text-muted)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" onclick="viewInvoice('${val}')" title="View Detail">👁</button>
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteInvoice('${val}', '${escapeHtml(row.invoice_no)}')" title="Delete">🗑</button>
            </div>
          `;
        }
      }
    ]
  });
});

function openModal(id) {
  document.getElementById(id).classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function viewInvoice(id) {
  if (!invoiceTableInstance) return;
  const inv = invoiceTableInstance.data.find(x => String(x.id) === String(id));
  if (!inv) return;

  const html = `
    <div style="border: 1px solid var(--border); border-radius: 8px; padding: 20px; font-family: 'Mulish', sans-serif;">
      <div style="display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center;">
        <div>
          <h3 style="margin: 0; font-family: 'Cinzel', serif; color: var(--navy);">SAMRIDDHI VENTURES</h3>
          <span style="font-size: 11px; color: var(--text-muted);">Vedic Astrology & Guidance ERP</span>
        </div>
        <div style="text-align: right;">
          <h4 style="margin: 0; color: var(--saffron);">${escapeHtml(inv.invoice_no)}</h4>
          <span style="font-size: 11px; color: var(--text-muted);">${escapeHtml(inv.created_at)}</span>
        </div>
      </div>
      
      <div style="margin-bottom: 20px; border-top: 1px solid var(--border); padding-top: 15px;">
        <strong style="font-size: 12px; text-transform: uppercase; color: var(--text-muted);">Billed To:</strong>
        <div style="font-weight: 700; margin-top: 5px; font-size: 14px;">${escapeHtml(inv.user_name)}</div>
      </div>

      <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
          <tr style="border-bottom: 2px solid var(--border); text-align: left; font-size: 12px; color: var(--text-muted);">
            <th style="padding: 8px 0;">Description</th>
            <th style="padding: 8px 0; text-align: right;">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr style="border-bottom: 1px solid var(--border);">
            <td style="padding: 10px 0; font-size: 13px;">Astrology Consultation Services & Report Purchases</td>
            <td style="padding: 10px 0; text-align: right; font-size: 13px;">₹${Number(inv.amount).toFixed(2)}</td>
          </tr>
        </tbody>
      </table>

      <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 8px; border-top: 1px solid var(--border); padding-top: 15px;">
        <div style="display: flex; width: 200px; justify-content: space-between; font-size: 13px;">
          <span>Subtotal:</span>
          <span>₹${Number(inv.amount).toFixed(2)}</span>
        </div>
        <div style="display: flex; width: 200px; justify-content: space-between; font-size: 13px; color: var(--text-muted);">
          <span>GST (18%):</span>
          <span>₹${Number(inv.gst).toFixed(2)}</span>
        </div>
        <div style="display: flex; width: 200px; justify-content: space-between; font-weight: 700; font-size: 16px; border-top: 2px solid var(--border); padding-top: 8px; margin-top: 4px;">
          <span>Total:</span>
          <span style="color: var(--saffron);">₹${Number(inv.total).toFixed(2)}</span>
        </div>
      </div>

      <div style="margin-top: 30px; text-align: center; font-size: 11px; color: var(--text-muted); border-top: 1px solid var(--border); padding-top: 15px;">
        Status: <strong style="color: ${inv.payment_status.toLowerCase() === 'paid' ? '#10B981' : '#EF4444'}">${inv.payment_status.toUpperCase()}</strong>
      </div>
    </div>
  `;

  document.getElementById('viewInvoiceBody').innerHTML = html;
  openModal('viewInvoiceModal');
}

function deleteInvoice(id, code) {
  AppNotification.confirm({
    title: 'Delete Invoice?',
    text: `Are you sure you want to delete invoice "${code}"?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=invoices") ?>&id=' + id, function(res) {
      AppNotification.toast('Invoice deleted successfully', 'success');
      invoiceTableInstance.reload();
    });
  });
}
</script>
