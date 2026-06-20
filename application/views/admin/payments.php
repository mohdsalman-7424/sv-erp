<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">💳 Payments & Transactions</div>
    <div class="page-header-sub">View and reconcile customer system transactions and payments</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" id="btnExportPayments">⬇ Export CSV</button>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="paymentSearch" placeholder="Search payments..."></div>
      <div>
        <select class="filter-select sumo" id="filterPaymentStatus">
          <option value="">All Status</option>
          <option value="Success">Success</option>
          <option value="Failed">Failed</option>
          <option value="Pending">Pending</option>
        </select>
      </div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="paymentTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="payment_id">Payment ID</th>
            <th data-sortable="true" data-field="user_name">Customer</th>
            <th data-sortable="true" data-field="amount">Amount</th>
            <th data-sortable="true" data-field="payment_mode">Method</th>
            <th data-sortable="true" data-field="status">Status</th>
            <th data-sortable="true" data-field="created_at">Transaction Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="7" style="text-align:center;padding:24px;color:var(--text-muted)">Loading payments...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="paymentPagination"></div>
  </div>
</div>

<script>
let paymentTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  paymentTableInstance = new AppDataTable({
    tableSelector: '#paymentTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'payments',
    pageSize: 10,
    paginationSelector: '#paymentPagination',
    searchSelector: '#paymentSearch',
    filterSelectors: {
      status: '#filterPaymentStatus'
    },
    exportSelector: '#btnExportPayments',
    columns: [
      {
        data: 'payment_id',
        title: 'Payment ID',
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
        title: 'Amount',
        render: function(val) { return `<strong style="color:var(--saffron)">₹${Number(val).toFixed(2)}</strong>`; }
      },
      {
        data: 'payment_mode',
        title: 'Method',
        render: function(val) { return `<span class="tag" style="text-transform:uppercase">${escapeHtml(val || 'Wallet')}</span>`; }
      },
      {
        data: 'status',
        title: 'Status',
        render: function(val) {
          const status = String(val).toLowerCase();
          if (status === 'success' || status === 'completed') return '<span class="badge badge-success">● Success</span>';
          if (status === 'pending') return '<span class="badge badge-warning">● Pending</span>';
          return '<span class="badge badge-danger">● Failed</span>';
        }
      },
      {
        data: 'created_at',
        title: 'Transaction Date',
        render: function(val) { return `<span style="font-size:11px;color:var(--text-muted)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deletePayment('${val}')" title="Delete Log">🗑</button>
            </div>
          `;
        }
      }
    ]
  });
});

function deletePayment(id) {
  AppNotification.confirm({
    title: 'Delete Payment Record?',
    text: `Are you sure you want to delete payment log #${id}?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=payments") ?>&id=' + id, function(res) {
      AppNotification.toast('Payment record deleted successfully', 'success');
      paymentTableInstance.reload();
    });
  });
}
</script>
