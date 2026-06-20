<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">⚙ Global System Settings</div>
    <div class="page-header-sub">Manage system configuration keys and settings values</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-primary btn-sm" onclick="openAddSettingModal()">+ Add Key</button>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="settingSearch" placeholder="Search settings..."></div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="settingTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="key">Configuration Key</th>
            <th data-sortable="true" data-field="value">Configuration Value</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="3" style="text-align:center;padding:24px;color:var(--text-muted)">Loading system settings...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="settingPagination"></div>
  </div>
</div>

<!-- Add Setting Modal -->
<div class="modal-overlay" id="addSettingModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Add System Configuration Key</div>
      <button class="modal-close" onclick="closeModal('addSettingModal')">✕</button>
    </div>
    <form id="addSettingForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=settings') ?>">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Configuration Key <span class="req">*</span></label>
        <input class="form-input" name="key" type="text" placeholder="site_name / currency / support_email" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Configuration Value <span class="req">*</span></label>
        <input class="form-input" name="value" type="text" placeholder="Samriddhi Ventures ERP" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Create Setting Key ✦</button>
    </form>
  </div>
</div>

<!-- Edit Setting Modal -->
<div class="modal-overlay" id="editSettingModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit System Setting</div>
      <button class="modal-close" onclick="closeModal('editSettingModal')">✕</button>
    </div>
    <form id="editSettingForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=settings') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="editSettingId">
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Configuration Key <span class="req">*</span></label>
        <input class="form-input" name="key" id="editSettingKey" type="text" readonly required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Configuration Value <span class="req">*</span></label>
        <input class="form-input" name="value" id="editSettingValue" type="text" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Update System Setting ✦</button>
    </form>
  </div>
</div>

<script>
let settingTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  settingTableInstance = new AppDataTable({
    tableSelector: '#settingTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'settings',
    pageSize: 10,
    paginationSelector: '#settingPagination',
    searchSelector: '#settingSearch',
    columns: [
      {
        data: 'key',
        title: 'Configuration Key',
        render: function(val) {
          return `<strong style="color:var(--navy);font-family:monospace;font-size:12px">${escapeHtml(val)}</strong>`;
        }
      },
      {
        data: 'value',
        title: 'Configuration Value',
        render: function(val) { return escapeHtml(val); }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" style="background:rgba(200,147,26,0.15);color:var(--gold)" onclick="editSetting('${val}')" title="Edit">✎</button>
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteSetting('${val}','${escapeHtml(row.key)}')" title="Delete">🗑</button>
            </div>
          `;
        }
      }
    ]
  });

  if ($.isFunction($.fn.validate)) {
    $('#addSettingForm').validate({
      rules: {
        key: { required: true, minlength: 2 },
        value: { required: true }
      }
    });
    $('#editSettingForm').validate({
      rules: {
        value: { required: true }
      }
    });
  }

  $('#addSettingForm').on('ajax:success', function() {
    settingTableInstance.reload();
  });

  $('#editSettingForm').on('ajax:success', function() {
    settingTableInstance.reload();
  });
});

function openAddSettingModal() {
  document.getElementById('addSettingForm').reset();
  openModal('addSettingModal');
}

function openModal(id) {
  document.getElementById(id).classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function editSetting(id) {
  if (!settingTableInstance) return;
  const s = settingTableInstance.data.find(x => String(x.id) === String(id));
  if (!s) return;

  document.getElementById('editSettingId').value = s.id;
  document.getElementById('editSettingKey').value = s.key;
  document.getElementById('editSettingValue').value = s.value;

  openModal('editSettingModal');
}

function deleteSetting(id, key) {
  AppNotification.confirm({
    title: 'Delete System Key?',
    text: `Are you sure you want to delete setting key "${key}"?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=settings") ?>&id=' + id, function(res) {
      AppNotification.toast('Setting key deleted successfully', 'success');
      settingTableInstance.reload();
    });
  });
}
</script>
