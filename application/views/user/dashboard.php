<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model(['wallet_model', 'wallet_transaction_model', 'consultation_model', 'kundali_model']);
$wallet = $CI->wallet_model->get_where(['user_id' => $current_user['id']]);
$recent_activities = [];
if (!empty($wallet)) {
    $recent_activities = $CI->wallet_transaction_model->get_where(['wallet_id' => $wallet[0]['id']]);
    usort($recent_activities, function($a, $b) {
        return $b['id'] - $a['id'];
    });
    $recent_activities = array_slice($recent_activities, 0, 4);
}

// Get upcoming consultation
$CI->db->select('consultations.*, users.name as astrologer_name');
$CI->db->from('consultations');
$CI->db->join('astrologers', 'astrologers.id = consultations.astrologer_id', 'left');
$CI->db->join('users', 'users.id = astrologers.user_id', 'left');
$CI->db->where('consultations.user_id', $current_user['id']);
$CI->db->where('consultations.scheduled_at >=', date('Y-m-d H:i:s'));
$CI->db->order_by('consultations.scheduled_at', 'ASC');
$CI->db->limit(1);
$upcoming = $CI->db->get()->result_array();

// Get latest kundali
$latest_k_res = $CI->kundali_model->get_where(['user_id' => $current_user['id']]);
$latest_k = null;
if (!empty($latest_k_res)) {
    usort($latest_k_res, function($a, $b) {
        return $b['id'] - $a['id'];
    });
    $latest_k = $latest_k_res[0];
}

$rashi_map = [
    'Mesh' => 'Aries lagna',
    'Vrishab' => 'Taurus lagna',
    'Mithun' => 'Gemini lagna',
    'Kark' => 'Cancer lagna',
    'Simha' => 'Leo lagna',
    'Kanya' => 'Virgo lagna',
    'Tula' => 'Libra lagna',
    'Vrishchik' => 'Scorpio lagna',
    'Dhanu' => 'Sagittarius lagna',
    'Makar' => 'Capricorn lagna',
    'Kumbh' => 'Aquarius lagna',
    'Meen' => 'Pisces lagna'
];
?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">Welcome back, <?= html_escape($user_name) ?> ✦</div>
    <div class="page-header-sub">Your cosmic journey continues · <?= html_escape($active_plan) ?> Active</div>
  </div>
  <div class="page-header-actions">
    <a href="<?= site_url('user/kundali-reports') ?>" class="btn btn-primary btn-sm">✦ New Kundali</a>
    <a href="<?= site_url('user/consultations') ?>" class="btn btn-secondary btn-sm">Talk to Astrologer</a>
  </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(255,107,0,0.1)">💎</div>
    <div class="kpi-label">Active Plan</div>
    <div class="kpi-val" style="font-size:18px"><?= html_escape($active_plan) ?></div>
    <div class="kpi-change kpi-up">▲ Valid till <?= html_escape($plan_expiry) ?></div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(200,147,26,0.1)">👛</div>
    <div class="kpi-label">Wallet Balance</div>
    <div class="kpi-val">₹<?= number_format($wallet_balance, 2) ?></div>
    <div class="kpi-change <?= $wallet_balance < 150 ? 'kpi-warn' : 'kpi-up' ?>">
      <?= $wallet_balance < 150 ? '⚠ Low Balance' : '▲ Wallet Active' ?>
    </div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(34,197,94,0.1)">🔭</div>
    <div class="kpi-label">Kundali Reports</div>
    <div class="kpi-val"><?= intval($kundalis_count) ?></div>
    <div class="kpi-change kpi-up">▲ Dynamic Count</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(120,86,168,0.1)">💬</div>
    <div class="kpi-label">Consultations</div>
    <div class="kpi-val"><?= intval($consultations_count) ?></div>
    <div class="kpi-change kpi-up">▲ Scheduled/Booked</div>
  </div>
</div>

<!-- Main Grid -->
<div class="grid-2" style="gap:20px;margin-bottom:20px">

  <!-- Recent Activity -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Recent Activity <a href="<?= site_url('user/transactions') ?>">View All →</a></div>
      <?php if (!empty($recent_activities)): ?>
        <?php foreach ($recent_activities as $act): ?>
          <div class="activity-item">
            <div class="act-dot" style="background: <?= strtolower($act['credit_debit']) === 'credit' ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)' ?>">
              <?= strtolower($act['credit_debit']) === 'credit' ? '✅' : '📤' ?>
            </div>
            <div>
              <div class="act-text"><?= html_escape($act['remark']) ?></div>
              <div class="act-time"><?= date('d M Y, h:i A', strtotime($act['created_at'])) ?> · ₹<?= number_format($act['amount'], 2) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="text-align:center;color:var(--text-muted);padding:30px 10px;">
          No transactions or activities logged yet.
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Today's Horoscope -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Today's Cosmic Guidance <a href="<?= site_url('user/horoscope-reports') ?>">Details →</a></div>
      <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));border-radius:12px;padding:18px;text-align:center;margin-bottom:14px">
        <div style="font-size:36px;margin-bottom:6px">♈</div>
        <div class="cinzel" style="color:var(--gold-bright);font-size:16px">Aries — Mesh Rashi</div>
        <div style="color:rgba(255,255,255,0.45);font-size:11px;margin-bottom:12px">मेष राशि</div>
        <div style="display:flex;justify-content:center;gap:16px">
          <div><div class="cinzel" style="font-size:22px;color:var(--gold-bright)">8.2</div><div style="font-size:10px;color:rgba(255,255,255,0.4)">Overall</div></div>
          <div style="width:1px;background:rgba(255,255,255,0.1)"></div>
          <div><div style="color:var(--gold-bright);font-size:14px">★★★★☆</div><div style="font-size:10px;color:rgba(255,255,255,0.4)">Rating</div></div>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:10px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">💼 Career</div><div style="color:var(--gold);font-size:11px">★★★★★ Excellent</div></div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:10px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">💑 Love</div><div style="color:var(--gold);font-size:11px">★★¼☆☆ Good</div></div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:10px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">💰 Finance</div><div style="color:var(--gold);font-size:11px">★★★☆☆ Moderate</div></div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:10px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">🏥 Health</div><div style="color:var(--gold);font-size:11px">★★★★☆ Good</div></div>
      </div>
    </div>
  </div>
</div>

<!-- Second Row -->
<div class="grid-3" style="gap:20px">
  <!-- Upcoming Consultations -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Upcoming <a href="<?= site_url('user/consultations') ?>">View All →</a></div>
      <?php if (!empty($upcoming)): ?>
        <div class="activity-item">
          <div class="act-dot" style="background:rgba(200,147,26,0.12)">🧘</div>
          <div><div class="act-text" style="font-weight:600"><?= html_escape($upcoming[0]['astrologer_name']) ?></div><div class="act-time"><?= date('d M Y · h:i A', strtotime($upcoming[0]['scheduled_at'])) ?> · <?= ucfirst($upcoming[0]['consultation_type']) ?></div></div>
          <span class="badge badge-gold">Booked</span>
        </div>
      <?php else: ?>
        <div style="text-align:center;padding:14px;color:var(--text-muted);font-size:12px;">No upcoming bookings</div>
      <?php endif; ?>
      <div style="margin-top:14px"><a href="<?= site_url('user/consultations') ?>" class="btn btn-secondary w-100 btn-sm">Book New Consultation</a></div>
    </div>
  </div>

  <!-- Quick Kundali -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">My Kundali <a href="<?= site_url('user/kundali-reports') ?>">View All →</a></div>
      <div style="text-align:center;padding:16px 0">
        <svg viewBox="0 0 160 160" style="width:130px;height:130px" xmlns="http://www.w3.org/2000/svg">
          <rect width="160" height="160" fill="var(--gold-pale)" stroke="var(--gold)" stroke-width="1.5" rx="3"/>
          <line x1="0" y1="0" x2="160" y2="160" stroke="var(--gold)" stroke-width="1" opacity="0.4"/>
          <line x1="160" y1="0" x2="0" y2="160" stroke="var(--gold)" stroke-width="1" opacity="0.4"/>
          <line x1="80" y1="0" x2="80" y2="160" stroke="var(--gold)" stroke-width="0.8" opacity="0.3"/>
          <line x1="0" y1="80" x2="160" y2="80" stroke="var(--gold)" stroke-width="0.8" opacity="0.3"/>
          <polygon points="80,0 160,80 80,160 0,80" fill="none" stroke="var(--gold)" stroke-width="1.5"/>
          <text x="80" y="95" text-anchor="middle" fill="rgba(200,147,26,0.2)" font-size="30" font-family="serif">ॐ</text>
          <text x="80" y="36" text-anchor="middle" fill="var(--navy)" font-size="8" font-weight="bold">Asc</text>
          <text x="80" y="46" text-anchor="middle" fill="var(--text-muted)" font-size="7">Kumbha</text>
        </svg>
        <div style="font-size:11px;color:var(--text-muted);margin-top:8px">
          <?= !empty($latest_k) ? html_escape($latest_k['name']) . ' · ' . date('d M Y', strtotime($latest_k['dob'])) : 'No Kundali generated yet' ?>
        </div>
      </div>
      <a href="<?= site_url('user/kundali-reports') ?>" class="btn btn-primary w-100 btn-sm">View Full Kundali</a>
    </div>
  </div>

  <!-- Wallet -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">My Wallet <a href="<?= site_url('user/wallet') ?>">Recharge →</a></div>
      <div class="wallet-card" style="margin-bottom:14px">
        <div style="font-size:11px;color:rgba(255,255,255,0.45);letter-spacing:1px;text-transform:uppercase;margin-bottom:6px">Available Balance</div>
        <div class="wallet-balance">₹<?= number_format($wallet_balance, 2) ?></div>
        <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:4px">≈ <?= intval($wallet_balance / 40) ?> min consultation</div>
      </div>
      <a href="<?= site_url('user/wallet') ?>" class="btn btn-gold w-100 btn-sm">+ Recharge Wallet</a>
    </div>
  </div>
</div>
