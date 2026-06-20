<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">✍ Blog Management</div>
    <div class="page-header-sub">Create, edit, and publish cosmic wisdom and articles</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-primary btn-sm" onclick="openAddBlogModal()">+ Create Blog</button>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="blogSearch" placeholder="Search blog posts..."></div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="blogTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="title">Title</th>
            <th data-sortable="true" data-field="author">Author</th>
            <th data-sortable="true" data-field="category">Category</th>
            <th data-sortable="true" data-field="date">Date Published</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" style="text-align:center;padding:24px;color:var(--text-muted)">Loading blog posts...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="blogPagination"></div>
  </div>
</div>

<!-- Add Blog Modal -->
<div class="modal-overlay" id="addBlogModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Create Blog Post</div>
      <button class="modal-close" onclick="closeModal('addBlogModal')">✕</button>
    </div>
    <form id="addBlogForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=blogs') ?>">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Blog Title <span class="req">*</span></label>
        <input class="form-input" name="title" type="text" placeholder="Understanding Saturn Transit in Aquarius..." required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Content <span class="req">*</span></label>
        <textarea class="form-input" name="content" rows="6" placeholder="Write the cosmic details..." required></textarea>
      </div>
      <button class="btn btn-primary w-100" type="submit">Publish Blog Post ✦</button>
    </form>
  </div>
</div>

<!-- Edit Blog Modal -->
<div class="modal-overlay" id="editBlogModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Blog Post</div>
      <button class="modal-close" onclick="closeModal('editBlogModal')">✕</button>
    </div>
    <form id="editBlogForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=blogs') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="editBlogId">
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Blog Title <span class="req">*</span></label>
        <input class="form-input" name="title" id="editBlogTitle" type="text" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Content <span class="req">*</span></label>
        <textarea class="form-input" name="content" id="editBlogContent" rows="6" required></textarea>
      </div>
      <button class="btn btn-primary w-100" type="submit">Update Blog Post ✦</button>
    </form>
  </div>
</div>

<script>
let blogTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  // Initialize Custom AJAX DataTable
  blogTableInstance = new AppDataTable({
    tableSelector: '#blogTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'blogs',
    pageSize: 10,
    paginationSelector: '#blogPagination',
    searchSelector: '#blogSearch',
    columns: [
      {
        data: 'title',
        title: 'Title',
        render: function(val, row) {
          return `<strong style="color:var(--navy)">${escapeHtml(val)}</strong>`;
        }
      },
      {
        data: 'author',
        title: 'Author',
        render: function(val) { return escapeHtml(val || 'Pt. Rajesh Sharma'); }
      },
      {
        data: 'category',
        title: 'Category',
        render: function(val) { return escapeHtml(val || 'Vedic Astrology'); }
      },
      {
        data: 'date',
        title: 'Date Published',
        render: function(val) { return `<span style="font-size:11px;color:var(--text-muted)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" style="background:rgba(200,147,26,0.15);color:var(--gold)" onclick="editBlog('${val}')" title="Edit">✎</button>
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteBlog('${val}','${escapeHtml(row.title)}')" title="Delete">🗑</button>
            </div>
          `;
        }
      }
    ]
  });

  // Validation
  if ($.isFunction($.fn.validate)) {
    $('#addBlogForm').validate({
      rules: {
        title: { required: true, minlength: 5 },
        content: { required: true, minlength: 10 }
      }
    });
    $('#editBlogForm').validate({
      rules: {
        title: { required: true, minlength: 5 },
        content: { required: true, minlength: 10 }
      }
    });
  }

  // Reload table on form successes
  $('#addBlogForm').on('ajax:success', function() {
    blogTableInstance.reload();
  });

  $('#editBlogForm').on('ajax:success', function() {
    blogTableInstance.reload();
  });
});

function openAddBlogModal() {
  document.getElementById('addBlogForm').reset();
  openModal('addBlogModal');
}

function openModal(id) {
  document.getElementById(id).classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function editBlog(id) {
  if (!blogTableInstance) return;
  const b = blogTableInstance.data.find(x => String(x.id) === String(id));
  if (!b) return;

  document.getElementById('editBlogId').value = b.id;
  document.getElementById('editBlogTitle').value = b.title;
  
  // Fetch full details if needed or use table data
  AppAjax.get('<?= site_url("api/get?collection=blogs") ?>', function(res) {
    const fullBlog = res.find(x => String(x.id) === String(id));
    document.getElementById('editBlogContent').value = fullBlog ? (fullBlog.content || fullBlog.title) : b.title;
    openModal('editBlogModal');
  });
}

function deleteBlog(id, title) {
  AppNotification.confirm({
    title: 'Delete Blog Post?',
    text: `Are you sure you want to delete "${title}"?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=blogs") ?>&id=' + id, function(res) {
      AppNotification.toast('Blog post deleted successfully', 'success');
      blogTableInstance.reload();
    });
  });
}
</script>
