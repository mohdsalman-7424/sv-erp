<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model(['consultation_model', 'wallet_transaction_model']);
$astro = $current_astro;
$astro_id = !empty($astro) ? $astro['id'] : 0;

// Get consultation counts
$total_consults = $CI->consultation_model->count_all(['astrologer_id' => $astro_id]);
$pending_consults = $CI->consultation_model->count_all(['astrologer_id' => $astro_id, 'status' => 'booked']);

// Query last 4 consultations
$CI->db->select('consultations.*, users.name as user_name');
$CI->db->from('consultations');
$CI->db->join('users', 'users.id = consultations.user_id');
$CI->db->where('consultations.astrologer_id', $astro_id);
$CI->db->order_by('consultations.scheduled_at', 'DESC');
$CI->db->limit(4);
$recent_bookings = $CI->db->get()->result_array();

// Calculate total earnings (mock/calculated based on completed sessions)
$completed_sessions = $CI->consultation_model->count_all(['astrologer_id' => $astro_id, 'status' => 'completed']);
$mock_earnings = $completed_sessions * 350.00; // Average ₹350 per consult
?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">Namaste, <?= html_escape($user_name) ?> ✦</div>
    <div class="page-header-sub">Manage your cosmic consultations, clients, and predictions dashboard</div>
  </div>
  <div class="page-header-actions" style="display:flex;align-items:center;gap:12px">
    <!-- Status Toggle Button -->
    <form method="POST" action="<?= site_url('astrologer/toggle-status') ?>">
      <?= csrf_field() ?>
      <?php if (!empty($astro) && $astro['is_online']): ?>
        <button type="submit" class="btn btn-success btn-sm">● Online (Click to go Offline)</button>
      <?php else: ?>
        <button type="submit" class="btn btn-secondary btn-sm">⚫ Offline (Click to go Online)</button>
      <?php endif; ?>
    </form>
  </div>
</div>

<!-- KPI Grid -->
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(34,197,94,0.1)">💰</div>
    <div class="kpi-label">Consultation Earnings</div>
    <div class="kpi-val">₹<?= number_format($mock_earnings, 2) ?></div>
    <div class="kpi-change kpi-up">▲ Dynamic Estimate</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(200,147,26,0.1)">⭐</div>
    <div class="kpi-label">Rating & Reviews</div>
    <div class="kpi-val"><?= !empty($astro) ? $astro['rating'] : '4.50' ?></div>
    <div class="kpi-change kpi-up">▲ From <?= !empty($astro) ? $astro['total_reviews'] : 12 ?> reviews</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(255,107,0,0.1)">💬</div>
    <div class="kpi-label">Total Consultations</div>
    <div class="kpi-val"><?= intval($total_consults) ?></div>
    <div class="kpi-change kpi-up">▲ Lifetime Sessions</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(120,86,168,0.1)">⌛</div>
    <div class="kpi-label">Pending Bookings</div>
    <div class="kpi-val"><?= intval($pending_consults) ?></div>
    <div class="kpi-change kpi-warn">⚠ Action required</div>
  </div>
</div>

<div class="grid-2" style="gap:20px;margin-bottom:20px;align-items:start">
  
  <!-- Active / Upcoming Bookings -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Recent Consultation Orders <a href="<?= site_url('astrologer/orders') ?>">View All →</a></div>
      <?php if (!empty($recent_bookings)): ?>
        <?php foreach ($recent_bookings as $booking): ?>
          <div class="activity-item" style="padding:12px 0;border-bottom:1px solid var(--border)">
            <div class="act-dot" style="background:rgba(200,147,26,0.12)">🧘</div>
            <div style="flex-grow:1">
              <div class="act-text" style="font-weight:600"><?= html_escape($booking['user_name']) ?></div>
              <div class="act-time"><?= date('d M Y, h:i A', strtotime($booking['scheduled_at'])) ?> · <?= ucfirst(html_escape($booking['consultation_type'])) ?></div>
            </div>
            <div>
              <?php if (strtolower($booking['status']) === 'booked'): ?>
                <span class="badge badge-gold">Pending</span>
              <?php elseif (strtolower($booking['status']) === 'completed'): ?>
                <span class="badge badge-success">Completed</span>
              <?php else: ?>
                <span class="badge badge-warning"><?= ucfirst(html_escape($booking['status'])) ?></span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="text-align:center;color:var(--text-muted);padding:30px 10px;">
          No consultation orders recorded yet.
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Cosmic Availability Summary -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">My Availability Schedule <a href="<?= site_url('astrologer/calendar') ?>">Edit →</a></div>
      <?php
      $slots = $CI->db->get_where('astrologer_availability', ['astrologer_id' => $astro_id])->result_array();
      ?>
      <?php if (!empty($slots)): ?>
        <div style="display:flex;flex-direction:column;gap:10px">
          <?php foreach ($slots as $s): ?>
            <div style="display:flex;justify-content:between;align-items:center;background:var(--gold-pale);border:1px solid var(--border);padding:10px 14px;border-radius:8px">
              <span style="font-weight:700;color:var(--navy)"><?= ucfirst(html_escape($s['day_name'])) ?></span>
              <span style="font-size:12px;color:var(--text-muted);margin-left:auto">
                <?= date('h:i A', strtotime($s['start_time'])) ?> - <?= date('h:i A', strtotime($s['end_time'])) ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div style="text-align:center;color:var(--text-muted);padding:30px 10px">
          No availability slots defined. Please configure calendar.
        </div>
      <?php endif; ?>
    </div>
  </div>

</div>
