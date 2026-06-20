<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">⭐ Testimonials & Reviews</div>
    <div class="page-header-sub">Moderate customer feedback and featured platform reviews</div>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="reviewSearch" placeholder="Search reviews..."></div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="reviewTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="user_name">Customer</th>
            <th data-sortable="true" data-field="rating">Rating</th>
            <th data-sortable="true" data-field="comment">Review Comment</th>
            <th data-sortable="true" data-field="status">Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" style="text-align:center;padding:24px;color:var(--text-muted)">Loading reviews...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="reviewPagination"></div>
  </div>
</div>

<script>
let reviewTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  reviewTableInstance = new AppDataTable({
    tableSelector: '#reviewTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'testimonials',
    pageSize: 10,
    paginationSelector: '#reviewPagination',
    searchSelector: '#reviewSearch',
    columns: [
      {
        data: 'user_name',
        title: 'Customer',
        render: function(val) { return `<strong>${escapeHtml(val)}</strong>`; }
      },
      {
        data: 'rating',
        title: 'Rating',
        render: function(val) {
          const stars = '⭐'.repeat(val || 5);
          return `<span style="color:var(--gold);font-weight:700">${stars}</span>`;
        }
      },
      {
        data: 'comment',
        title: 'Review Comment',
        render: function(val) { return `<span style="font-size:12px;color:var(--text)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'status',
        title: 'Status',
        render: function(val) {
          return '<span class="badge badge-success">Approved</span>';
        }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteReview('${val}')" title="Delete Review">🗑 Delete</button>
            </div>
          `;
        }
      }
    ]
  });
});

function deleteReview(id) {
  AppNotification.confirm({
    title: 'Delete Review?',
    text: `Are you sure you want to delete this review?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=testimonials") ?>&id=' + id, function(res) {
      AppNotification.toast('Review deleted successfully', 'success');
      reviewTableInstance.reload();
    });
  });
}
</script>
