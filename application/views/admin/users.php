<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">👥 Manage Users</div>
    <div class="page-header-sub">All registered users on the platform</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" id="btnExportUsers">⬇ Export CSV</button>
    <button class="btn btn-primary btn-sm" onclick="openAddUserModal()">+ Add User</button>
  </div>
</div>

<!-- Stats Strip -->
<div class="kpi-grid" style="margin-bottom:20px">
  <div class="kpi-card"><div class="kpi-label">Total Users</div><div class="kpi-val" id="statsTotalUsers"><?= count($users_db) ?></div><div class="kpi-change kpi-up">▲ Live Users</div></div>
  <div class="kpi-card"><div class="kpi-label">Active Plans</div><div class="kpi-val">0</div><div class="kpi-change kpi-up">● Standard</div></div>
  <div class="kpi-card">
    <div class="kpi-label">Wallet Total</div>
    <div class="kpi-val" id="statsWalletTotal">
      ₹<?php 
        $CI =& get_instance();
        $total_wallet = 0;
        if (!empty($users_db)) {
            foreach ($users_db as $u) {
                $wallet = $CI->wallet_model->get_where(['user_id' => $u['id']]);
                if (!empty($wallet)) $total_wallet += $wallet[0]['balance'];
            }
        }
        echo number_format($total_wallet, 2);
      ?>
    </div>
    <div class="kpi-change kpi-up">▲ Combined</div>
  </div>
  <div class="kpi-card"><div class="kpi-label">New This Month</div><div class="kpi-val" id="statsNewUsers"><?= count($users_db) ?></div><div class="kpi-change kpi-up">▲ Growing</div></div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="userSearch" placeholder="Search users..."></div>
      <div style="display:flex;gap:8px">
        <select class="filter-select sumo" id="filterPlan">
          <option value="">All Plans</option>
          <option value="Devotee">Devotee</option>
          <option value="Gold Yogi">Gold Yogi</option>
          <option value="Seeker">Seeker</option>
          <option value="None">None</option>
        </select>
        <select class="filter-select sumo" id="filterCity">
          <option value="">All Cities</option>
          <option value="Mumbai">Mumbai</option>
          <option value="Varanasi">Varanasi</option>
          <option value="Delhi">Delhi</option>
        </select>
      </div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="userTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="name">User</th>
            <th data-sortable="true" data-field="phone">Phone</th>
            <th data-sortable="true" data-field="city">City</th>
            <th data-sortable="true" data-field="rashi">Rashi</th>
            <th data-sortable="true" data-field="wallet">Wallet</th>
            <th data-sortable="true" data-field="plan">Plan</th>
            <th data-sortable="true" data-field="joined">Joined</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="8" style="text-align:center;padding:24px;color:var(--text-muted)">Loading users...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="userPagination"></div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal-overlay" id="addUserModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Add New User</div>
      <button class="modal-close" onclick="closeModal('addUserModal')">✕</button>
    </div>
    <form id="addUserForm" class="ajax-form" method="POST" action="<?= site_url('admin/save-user') ?>">
      <?= csrf_field() ?>
      <div class="form-grid-2" style="grid-template-columns:1fr">
        <div class="form-group">
          <label class="form-label">Full Name <span class="req">*</span></label>
          <input class="form-input" name="name" type="text" placeholder="Rahul Kumar" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email <span class="req">*</span></label>
          <input class="form-input" name="email" type="email" placeholder="rahul@example.com" required>
        </div>
        <div class="form-group">
          <label class="form-label">Phone</label>
          <input class="form-input" name="phone" type="tel" placeholder="9876543210">
        </div>
        <div class="form-group">
          <label class="form-label">City</label>
          <input class="form-input" name="city" type="text" placeholder="Mumbai">
        </div>
        <div class="form-group">
          <label class="form-label">Rashi</label>
          <select class="form-select" name="rashi">
            <option value="Mesh">Mesh</option>
            <option value="Vrishab">Vrishab</option>
            <option value="Mithun">Mithun</option>
            <option value="Kark">Kark</option>
            <option value="Kanya">Kanya</option>
          </select>
        </div>
      </div>
      <button class="btn btn-primary w-100" style="margin-top:18px" type="submit">Save User</button>
    </form>
  </div>
</div>

<!-- View User Modal -->
<div class="modal-overlay" id="viewUserModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">User Details</div>
      <button class="modal-close" onclick="closeModal('viewUserModal')">✕</button>
    </div>
    <div id="viewUserBody"></div>
  </div>
</div>

<script>
let userTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  // Initialize Custom AJAX DataTable
  userTableInstance = new AppDataTable({
    tableSelector: '#userTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'users',
    pageSize: 10,
    paginationSelector: '#userPagination',
    searchSelector: '#userSearch',
    filterSelectors: {
      city: '#filterCity'
    },
    exportSelector: '#btnExportUsers',
    columns: [
      { 
        data: 'name', 
        title: 'User',
        render: function(val, row) {
          const avatar = row.avatar || (val ? val.substring(0, 1).toUpperCase() : 'U');
          const email = row.email || '';
          return `
            <div style="display:flex;align-items:center;gap:9px">
              <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:12px;flex-shrink:0">${escapeHtml(avatar)}</div>
              <div>
                <div style="font-weight:700;font-size:13px">${escapeHtml(val)}</div>
                <div style="font-size:10px;color:var(--text-muted)">${escapeHtml(email)}</div>
              </div>
            </div>
          `;
        }
      },
      { data: 'phone', title: 'Phone' },
      { data: 'city', title: 'City' },
      { 
        data: 'rashi', 
        title: 'Rashi',
        render: function(val) {
          return `<span class="tag">${escapeHtml(val || 'Mesh')}</span>`;
        }
      },
      { 
        data: 'wallet', 
        title: 'Wallet',
        render: function(val) {
          return `<span style="font-weight:700;color:var(--saffron)">₹${Number(val || 0).toFixed(2)}</span>`;
        }
      },
      { 
        data: 'plan', 
        title: 'Plan',
        render: function(val) {
          return `<span class="badge badge-navy">${escapeHtml(val || 'None')}</span>`;
        }
      },
      { 
        data: 'joined', 
        title: 'Joined',
        render: function(val) {
          return `<span style="font-size:11px;color:var(--text-muted)">${escapeHtml(val)}</span>`;
        }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:5px">
              <button class="btn-navy btn-sm" onclick="viewUser('${val}')">View</button>
              <button class="btn btn-danger btn-sm" style="width:auto;padding:6px 10px" onclick="deleteUser('${val}', '${escapeHtml(row.name)}')">🚫</button>
            </div>
          `;
        }
      }
    ],
    onDraw: function(data) {
      // Callback after drawing to update stats
      if (userTableInstance) {
        updateStatsStrip(userTableInstance.data);
      }
    }
  });

  // Client-side form validation
  if ($.isFunction($.fn.validate)) {
    $('#addUserForm').validate({
      rules: {
        name: {
          required: true,
          minlength: 2
        },
        email: {
          required: true,
          email: true
        },
        phone: {
          digits: true,
          minlength: 10,
          maxlength: 12
        }
      },
      messages: {
        name: {
          required: "Please enter the user's name",
          minlength: "Name must be at least 2 characters"
        },
        email: {
          required: "Email address is required",
          email: "Please enter a valid email address"
        }
      }
    });
  }

  // Handle successful form submission via event listener
  $('#addUserForm').on('ajax:success', function(e, res) {
    userTableInstance.reload();
  });
});

function openAddUserModal() {
  document.getElementById('addUserModal').classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function updateStatsStrip(users) {
  if (!users) return;
  $('#statsTotalUsers').text(users.length);
  $('#statsNewUsers').text(users.length);
  
  let totalWallet = 0;
  users.forEach(u => {
    totalWallet += parseFloat(u.wallet || 0);
  });
  $('#statsWalletTotal').text('₹' + totalWallet.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
}

function viewUser(id) {
  if (!userTableInstance) return;
  const u = userTableInstance.data.find(x => String(x.id) === String(id));
  if (!u) return;

  const avatar = u.avatar || u.name.substring(0, 1).toUpperCase();
  
  document.getElementById('viewUserBody').innerHTML = `
    <div style="text-align:center;padding:16px 0 24px">
      <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-family:'Cinzel',serif;font-size:24px;font-weight:700;margin:0 auto 12px;box-shadow:0 0 0 3px rgba(200,147,26,0.3)">${escapeHtml(avatar)}</div>
      <div style="font-family:'Playfair Display',serif;font-size:19px;font-weight:700">${escapeHtml(u.name)}</div>
      <div style="font-size:11px;color:var(--text-muted)">${escapeHtml(u.email || 'No email')}</div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">Phone</div><div style="font-weight:700">${escapeHtml(u.phone || '—')}</div></div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">City</div><div style="font-weight:700">${escapeHtml(u.city || '—')}</div></div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">Rashi</div><div style="font-weight:700">${escapeHtml(u.rashi || 'Mesh')}</div></div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">Wallet</div><div style="font-weight:700;color:var(--saffron)">₹${Number(u.wallet || 0).toFixed(2)}</div></div>
    </div>
    <div style="display:flex;gap:10px;margin-top:18px">
      <button class="btn btn-primary" style="flex:1" onclick="AppNotification.toast('Email sent to user','success')">📧 Email User</button>
      <button class="btn btn-secondary" style="flex:1" onclick="suspendUser('${u.id}')">🚫 Suspend</button>
    </div>
  `;
  document.getElementById('viewUserModal').classList.add('open');
}

function suspendUser(id) {
  closeModal('viewUserModal');
  AppNotification.confirm({
    title: 'Suspend User?',
    text: 'Are you sure you want to suspend this user account?',
    confirmButtonText: 'Yes, suspend'
  }, function() {
    AppAjax.get('<?= site_url("api/remove") ?>?collection=users&id=' + id, function(res) {
      AppNotification.toast('User suspended successfully', 'success');
      userTableInstance.reload();
    });
  });
}

function deleteUser(id, name) {
  AppNotification.confirm({
    title: 'Deactivate User?',
    text: `Are you sure you want to deactivate ${name}?`,
    confirmButtonText: 'Yes, deactivate'
  }, function() {
    AppAjax.get('<?= site_url("api/remove") ?>?collection=users&id=' + id, function(res) {
      AppNotification.toast('User deactivated successfully', 'success');
      userTableInstance.reload();
    });
  });
}

function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}
</script>
