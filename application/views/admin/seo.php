<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">🔍 SEO & Page Meta Settings</div>
    <div class="page-header-sub">Manage meta titles, descriptions, and keywords for search engine indexing</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-primary btn-sm" onclick="openAddSeoModal()">+ Create SEO Page</button>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="seoSearch" placeholder="Search page settings..."></div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="seoTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="page">Page Name</th>
            <th data-sortable="true" data-field="title">Meta Title</th>
            <th data-sortable="true" data-field="desc">Meta Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="4" style="text-align:center;padding:24px;color:var(--text-muted)">Loading SEO settings...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="seoPagination"></div>
  </div>
</div>

<!-- Add SEO Modal -->
<div class="modal-overlay" id="addSeoModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Create Page SEO Settings</div>
      <button class="modal-close" onclick="closeModal('addSeoModal')">✕</button>
    </div>
    <form id="addSeoForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=seo') ?>">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Page Name <span class="req">*</span></label>
        <input class="form-input" name="page" type="text" placeholder="home / consultations / blogs" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Meta Title <span class="req">*</span></label>
        <input class="form-input" name="title" type="text" placeholder="Vedic Astrology & Predictions | AstroVeda" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Meta Description <span class="req">*</span></label>
        <textarea class="form-input" name="desc" rows="4" placeholder="Get live consultations with certified Vedic astrologers..." required></textarea>
      </div>
      <button class="btn btn-primary w-100" type="submit">Create Page SEO ✦</button>
    </form>
  </div>
</div>

<!-- Edit SEO Modal -->
<div class="modal-overlay" id="editSeoModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit SEO Settings</div>
      <button class="modal-close" onclick="closeModal('editSeoModal')">✕</button>
    </div>
    <form id="editSeoForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=seo') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="editSeoId">
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Page Name <span class="req">*</span></label>
        <input class="form-input" name="page" id="editSeoPage" type="text" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Meta Title <span class="req">*</span></label>
        <input class="form-input" name="title" id="editSeoTitle" type="text" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Meta Description <span class="req">*</span></label>
        <textarea class="form-input" name="desc" id="editSeoDesc" rows="4" required></textarea>
      </div>
      <button class="btn btn-primary w-100" type="submit">Update Page SEO ✦</button>
    </form>
  </div>
</div>

<script>
let seoTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  seoTableInstance = new AppDataTable({
    tableSelector: '#seoTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'seo',
    pageSize: 10,
    paginationSelector: '#seoPagination',
    searchSelector: '#seoSearch',
    columns: [
      {
        data: 'page',
        title: 'Page Name',
        render: function(val) {
          return `<strong style="color:var(--navy)">${escapeHtml(val)}</strong>`;
        }
      },
      {
        data: 'title',
        title: 'Meta Title',
        render: function(val) { return escapeHtml(val); }
      },
      {
        data: 'desc',
        title: 'Meta Description',
        render: function(val) { return `<span style="font-size:12px;color:var(--text-muted)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" style="background:rgba(200,147,26,0.15);color:var(--gold)" onclick="editSeo('${val}')" title="Edit">✎</button>
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteSeo('${val}','${escapeHtml(row.page)}')" title="Delete">🗑</button>
            </div>
          `;
        }
      }
    ]
  });

  if ($.isFunction($.fn.validate)) {
    $('#addSeoForm').validate({
      rules: {
        page: { required: true },
        title: { required: true, minlength: 5 },
        desc: { required: true, minlength: 10 }
      }
    });
    $('#editSeoForm').validate({
      rules: {
        page: { required: true },
        title: { required: true, minlength: 5 },
        desc: { required: true, minlength: 10 }
      }
    });
  }

  $('#addSeoForm').on('ajax:success', function() {
    seoTableInstance.reload();
  });

  $('#editSeoForm').on('ajax:success', function() {
    seoTableInstance.reload();
  });
});

function openAddSeoModal() {
  document.getElementById('addSeoForm').reset();
  openModal('addSeoModal');
}

function openModal(id) {
  document.getElementById(id).classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function editSeo(id) {
  if (!seoTableInstance) return;
  const s = seoTableInstance.data.find(x => String(x.id) === String(id));
  if (!s) return;

  document.getElementById('editSeoId').value = s.id;
  document.getElementById('editSeoPage').value = s.page;
  document.getElementById('editSeoTitle').value = s.title;
  document.getElementById('editSeoDesc').value = s.desc;

  openModal('editSeoModal');
}

function deleteSeo(id, page) {
  AppNotification.confirm({
    title: 'Delete Page SEO?',
    text: `Are you sure you want to delete SEO settings for page "${page}"?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=seo") ?>&id=' + id, function(res) {
      AppNotification.toast('SEO settings deleted successfully', 'success');
      seoTableInstance.reload();
    });
  });
}
</script>
