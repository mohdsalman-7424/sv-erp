<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">📊 Admin Dashboard</div>
    <div class="page-header-sub">Platform overview — <?= date('l, d M Y') ?></div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" onclick="Toast.show('Report exported!','success')">⬇ Export Report</button>
    <a href="<?= site_url('admin/settings') ?>" class="btn btn-primary btn-sm">⚙ Settings</a>
  </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid" style="margin-bottom:24px">
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(200,147,26,0.1)">👥</div><div class="kpi-label">Total Users</div><div class="kpi-val" id="kTotalUsers"><?= $total_users ?></div><div class="kpi-change kpi-up">▲ Live Users</div></div>
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(34,197,94,0.1)">🧘</div><div class="kpi-label">Astrologers</div><div class="kpi-val" id="kTotalAstro"><?= $total_astros ?></div><div class="kpi-change kpi-up">▲ Active Gurus</div></div>
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(255,107,0,0.1)">💰</div><div class="kpi-label">Total Revenue</div><div class="kpi-val" id="kRevenue">₹2,47,850</div><div class="kpi-change kpi-up">▲ Combined</div></div>
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(120,86,168,0.1)">💎</div><div class="kpi-label">Active Subs</div><div class="kpi-val" id="kActiveSubs"><?= $total_plans ?></div><div class="kpi-change kpi-warn">● Total Plans</div></div>
</div>

<!-- Charts Row -->
<div class="grid-2" style="gap:20px;margin-bottom:20px">
  <div class="chart-card">
    <div class="chart-title">Revenue — Last 6 Months <span class="badge badge-gold">Monthly</span></div>
    <div class="chart-container" style="height:220px"><canvas id="revenueChart"></canvas></div>
  </div>
  <div class="chart-card">
    <div class="chart-title">Plan Distribution <span class="badge badge-gold">Current</span></div>
    <div class="chart-container" style="height:220px"><canvas id="planChart"></canvas></div>
  </div>
</div>

<!-- Tables Row -->
<div class="grid-2" style="gap:20px">

  <!-- Recent Users -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Recent Users <a href="<?= site_url('admin_dashboard/users') ?>">View All →</a></div>
      <table class="data-table" id="recentUsersTable">
        <thead><tr><th>User</th><th>City</th><th>Plan</th><th>Status</th></tr></thead>
        <tbody>
          <?php if (!empty($recent_users)): ?>
            <?php foreach ($recent_users as $ru): ?>
              <?php 
                $CI =& get_instance();
                $address = $CI->user_address_model->get_where(['user_id' => $ru['id']]);
                $city = !empty($address) ? $address[0]['city'] : 'Mumbai';
              ?>
              <tr>
                <td><strong><?= html_escape($ru['name']) ?></strong><br><span style="font-size:10px;color:var(--text-muted)"><?= html_escape($ru['email']) ?></span></td>
                <td><?= html_escape($city) ?></td>
                <td><span class="badge badge-navy">Seeker</span></td>
                <td><span class="badge badge-success">Active</span></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" style="text-align:center;color:var(--text-muted)">No recent users</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Astrologers -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Top Astrologers <a href="<?= site_url('admin_dashboard/astrologers') ?>">View All →</a></div>
      <table class="data-table">
        <thead><tr><th>Name</th><th>Rating</th><th>Earnings</th><th>Status</th></tr></thead>
        <tbody>
          <?php if (!empty($top_astros)): ?>
            <?php foreach ($top_astros as $ta): ?>
              <?php 
                $CI =& get_instance();
                $user = $CI->user_model->get_by_id($ta['user_id']);
                $name = !empty($user) ? $user['name'] : 'Astrologer';
              ?>
              <tr>
                <td><strong><?= html_escape($name) ?></strong></td>
                <td>⭐ <?= floatval($ta['rating']) ?></td>
                <td style="color:var(--saffron);font-weight:700">₹15,000</td>
                <td><?= $ta['is_online'] ? '<span class="badge badge-success">Online</span>' : '<span class="badge badge-warning">Offline</span>' ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" style="text-align:center;color:var(--text-muted)">No top astrologers</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Revenue Chart
  new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun'],
      datasets: [{
        label: 'Revenue (₹)',
        data: [28000,34000,42000,38000,51000,55000],
        backgroundColor: 'rgba(200,147,26,0.7)',
        borderColor: 'rgba(200,147,26,1)',
        borderWidth: 1,
        borderRadius: 6,
      }]
    },
    options: { responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, grid:{color:'rgba(0,0,0,0.05)'}}, x:{grid:{display:false}}} }
  });

  // Plan Doughnut
  new Chart(document.getElementById('planChart'), {
    type: 'doughnut',
    data: {
      labels: ['Seeker','Devotee','Gold Yogi','Brahma'],
      datasets: [{
        data: [35,40,18,7],
        backgroundColor: ['rgba(200,147,26,0.5)','rgba(255,107,0,0.7)','rgba(34,197,94,0.6)','rgba(120,86,168,0.6)'],
        borderWidth: 0,
      }]
    },
    options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'bottom', labels:{font:{size:11}, color:'var(--text-muted)' }} } }
  });
});
</script>
