<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">🔗 Referral Log</div>
    <div class="page-header-sub">Monitor user referral invites, reward balances, and registration conversions</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" id="btnExportReferrals">⬇ Export CSV</button>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="referralSearch" placeholder="Search referrals..."></div>
      <div>
        <select class="filter-select sumo" id="filterReferralStatus">
          <option value="">All Status</option>
          <option value="Completed">Completed</option>
          <option value="Pending">Pending</option>
        </select>
      </div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="referralTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="referrer">Referrer (Invited By)</th>
            <th data-sortable="true" data-field="referred">Referred (New User)</th>
            <th data-sortable="true" data-field="reward">Reward Amount</th>
            <th data-sortable="true" data-field="status">Status</th>
            <th data-sortable="true" data-field="created_at">Date Joined</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" style="text-align:center;padding:24px;color:var(--text-muted)">Loading referrals...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="referralPagination"></div>
  </div>
</div>

<script>
let referralTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  referralTableInstance = new AppDataTable({
    tableSelector: '#referralTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'referrals',
    pageSize: 10,
    paginationSelector: '#referralPagination',
    searchSelector: '#referralSearch',
    filterSelectors: {
      status: '#filterReferralStatus'
    },
    exportSelector: '#btnExportReferrals',
    columns: [
      {
        data: 'referrer',
        title: 'Referrer (Invited By)',
        render: function(val) { return `<strong>${escapeHtml(val)}</strong>`; }
      },
      {
        data: 'referred',
        title: 'Referred (New User)',
        render: function(val) { return escapeHtml(val); }
      },
      {
        data: 'reward',
        title: 'Reward Amount',
        render: function(val) { return `<span style="font-weight:700;color:var(--saffron)">₹${Number(val).toFixed(2)}</span>`; }
      },
      {
        data: 'status',
        title: 'Status',
        render: function(val) {
          const status = String(val).toLowerCase();
          if (status === 'completed' || status === 'active') return '<span class="badge badge-success">Completed</span>';
          return '<span class="badge badge-warning">Pending</span>';
        }
      },
      {
        data: 'created_at',
        title: 'Date Joined',
        render: function(val) { return `<span style="font-size:11px;color:var(--text-muted)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteReferral('${val}')" title="Delete Log">🗑</button>
            </div>
          `;
        }
      }
    ]
  });
});

function deleteReferral(id) {
  AppNotification.confirm({
    title: 'Delete Referral Log?',
    text: `Are you sure you want to delete referral log #${id}?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=referrals") ?>&id=' + id, function(res) {
      AppNotification.toast('Referral log deleted successfully', 'success');
      referralTableInstance.reload();
    });
  });
}
</script>
