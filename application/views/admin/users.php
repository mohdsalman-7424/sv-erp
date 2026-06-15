<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">👥 Manage Users</div>
    <div class="page-header-sub">All registered users on the platform</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" onclick="Toast.show('CSV Exported!','success')">⬇ Export CSV</button>
    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addUserModal').classList.add('open')">+ Add User</button>
  </div>
</div>

<!-- Stats Strip -->
<div class="kpi-grid" style="margin-bottom:20px">
  <div class="kpi-card"><div class="kpi-label">Total Users</div><div class="kpi-val"><?= count($users_db) ?></div><div class="kpi-change kpi-up">▲ Live Users</div></div>
  <div class="kpi-card"><div class="kpi-label">Active Plans</div><div class="kpi-val">0</div><div class="kpi-change kpi-up">● Standard</div></div>
  <div class="kpi-card">
    <div class="kpi-label">Wallet Total</div>
    <div class="kpi-val">
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
  <div class="kpi-card"><div class="kpi-label">New This Month</div><div class="kpi-val"><?= count($users_db) ?></div><div class="kpi-change kpi-up">▲ Growing</div></div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="userSearch" placeholder="Search users..." oninput="filterTable(this,'usersBody')"></div>
      <div style="display:flex;gap:8px">
        <select class="filter-select"><option>All Plans</option><option>Devotee</option><option>Gold Yogi</option><option>Seeker</option></select>
        <select class="filter-select"><option>All Status</option><option>Active</option><option>Expired</option></select>
      </div>
    </div>
    <div style="overflow-x:auto">
    <table class="data-table">
      <thead><tr><th>User</th><th>Phone</th><th>City</th><th>Rashi</th><th>Wallet</th><th>Plan</th><th>Joined</th><th>Actions</th></tr></thead>
      <tbody id="usersBody"></tbody>
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
      <button class="modal-close">✕</button>
    </div>
    <form method="POST" action="<?= site_url('admin/save-user') ?>">
      <div class="form-grid-2">
        <div class="form-group"><label class="form-label">Full Name <span class="req">*</span></label><input class="form-input" name="name" type="text" placeholder="Rahul Kumar" required></div>
        <div class="form-group"><label class="form-label">Email <span class="req">*</span></label><input class="form-input" name="email" type="email" placeholder="rahul@example.com" required></div>
        <div class="form-group"><label class="form-label">Phone</label><input class="form-input" name="phone" type="tel" placeholder="9876543210"></div>
        <div class="form-group"><label class="form-label">City</label><input class="form-input" name="city" type="text" placeholder="Mumbai"></div>
        <div class="form-group"><label class="form-label">Rashi</label><select class="form-select" name="rashi"><option>Mesh</option><option>Vrishab</option><option>Mithun</option><option>Kark</option><option>Kanya</option></select></div>
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
      <button class="modal-close">✕</button>
    </div>
    <div id="viewUserBody"></div>
  </div>
</div>

<script>
<?php
$formatted_users = [];
if (!empty($users_db)) {
    $CI =& get_instance();
    foreach ($users_db as $u) {
        $rashi = 'Mesh';
        $city = 'Mumbai';
        $wallet_balance = 0.00;
        
        $profile = $CI->user_profile_model->get_where(['user_id' => $u['id']]);
        if (!empty($profile)) $rashi = $profile[0]['bio'];
        
        $address = $CI->user_address_model->get_where(['user_id' => $u['id']]);
        if (!empty($address)) $city = $address[0]['city'];
        
        $wallet = $CI->wallet_model->get_where(['user_id' => $u['id']]);
        if (!empty($wallet)) $wallet_balance = $wallet[0]['balance'];
        
        $formatted_users[] = [
            'id' => $u['id'],
            'name' => $u['name'],
            'email' => $u['email'],
            'phone' => $u['mobile'],
            'city' => $city,
            'rashi' => $rashi,
            'wallet' => $wallet_balance,
            'joined' => date('Y-m-d', strtotime($u['created_at'])),
            'avatar' => strtoupper(substr($u['name'], 0, 1))
        ];
    }
}
?>
const users = <?php echo json_encode($formatted_users); ?>;
const plans = {U001:'Devotee',U002:'Gold Yogi',U003:'None'};

function renderUsers() {
  document.getElementById('usersBody').innerHTML = users.map(u => `
    <tr>
      <td><div style="display:flex;align-items:center;gap:9px">
        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:12px;flex-shrink:0">${u.avatar}</div>
        <div><div style="font-weight:700;font-size:13px">${u.name}</div><div style="font-size:10px;color:var(--text-muted)">${u.email}</div></div>
      </div></td>
      <td>${u.phone}</td>
      <td>${u.city}</td>
      <td><span class="tag">${u.rashi}</span></td>
      <td style="font-weight:700;color:var(--saffron)">₹${u.wallet}</td>
      <td><span class="badge badge-navy">None</span></td>
      <td style="font-size:11px;color:var(--text-muted)">${u.joined}</td>
      <td>
        <div style="display:flex;gap:5px">
          <button class="btn-navy btn-sm" onclick="viewUser('${u.id}')">View</button>
          <button class="btn btn-danger btn-sm" style="width:auto;padding:6px 10px" onclick="Toast.show('User deactivated','info')">🚫</button>
        </div>
      </td>
    </tr>
  `).join('');
}

function viewUser(id) {
  const u = users.find(x => String(x.id) === String(id));
  if (!u) return;
  document.getElementById('viewUserBody').innerHTML = `
    <div style="text-align:center;padding:16px 0 24px">
      <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-family:'Cinzel',serif;font-size:24px;font-weight:700;margin:0 auto 12px;box-shadow:0 0 0 3px rgba(200,147,26,0.3)">${u.avatar}</div>
      <div style="font-family:'Playfair Display',serif;font-size:19px;font-weight:700">${u.name}</div>
      <div style="font-size:11px;color:var(--text-muted)">${u.email}</div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">Phone</div><div style="font-weight:700">${u.phone}</div></div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">City</div><div style="font-weight:700">${u.city}</div></div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">Rashi</div><div style="font-weight:700">${u.rashi}</div></div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px"><div style="font-size:10px;color:var(--text-muted);margin-bottom:3px">Wallet</div><div style="font-weight:700;color:var(--saffron)">₹${u.wallet}</div></div>
    </div>
    <div style="display:flex;gap:10px;margin-top:18px">
      <button class="btn btn-primary" style="flex:1" onclick="Toast.show('Email sent to user','success')">📧 Email User</button>
      <button class="btn btn-secondary" style="flex:1" onclick="Toast.show('User suspended','warning')">🚫 Suspend</button>
    </div>
  `;
  document.getElementById('viewUserModal').classList.add('open');
}

function filterTable(input, bodyId) {
  const q = input.value.toLowerCase();
  document.querySelectorAll('#'+bodyId+' tr').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}

renderUsers();
</script>
