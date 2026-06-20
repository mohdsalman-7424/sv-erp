<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;

// Get completed sessions
$CI->db->select('consultations.*, users.name as user_name');
$CI->db->from('consultations');
$CI->db->join('users', 'users.id = consultations.user_id');
$CI->db->where('consultations.astrologer_id', $astro_id);
$CI->db->where('consultations.status', 'completed');
$CI->db->order_by('consultations.scheduled_at', 'DESC');
$earnings = $CI->db->get()->result_array();

$total_earned = count($earnings) * 350.00;
?>

<div class="page-header">
  <div>
    <div class="page-header-title">💰 Earning History</div>
    <div class="page-header-sub">Track your consultation earnings and payouts</div>
  </div>
  <div class="page-header-actions">
    <div style="background:var(--navy);color:white;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:700">
      Unpaid Balance: <span style="color:var(--gold-bright)">₹<?= number_format($total_earned, 2) ?></span>
    </div>
  </div>
</div>

<div class="grid-3" style="gap:20px;margin-bottom:20px">
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(34,197,94,0.1)">📈</div>
    <div class="kpi-label">Total Completed Sessions</div>
    <div class="kpi-val"><?= count($earnings) ?></div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(200,147,26,0.1)">👛</div>
    <div class="kpi-label">Gross Earnings</div>
    <div class="kpi-val">₹<?= number_format($total_earned, 2) ?></div>
  </div>
  <div class="kpi-card">
    <div class="kpi-icon" style="background:rgba(120,86,168,0.1)">🏛</div>
    <div class="kpi-label">Avg Payout Per Session</div>
    <div class="kpi-val">₹350.00</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Completed Consultations Ledger</div>
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Session ID</th>
            <th>Client Name</th>
            <th>Consultation Type</th>
            <th>Scheduled Time</th>
            <th>Amount Earned</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($earnings)): ?>
            <?php foreach ($earnings as $earn): ?>
              <tr>
                <td>#CON-<?= $earn['id'] ?></td>
                <td><strong style="color:var(--navy)"><?= html_escape($earn['user_name']) ?></strong></td>
                <td>
                  <span class="badge" style="background:rgba(200,147,26,0.1);color:var(--gold)">
                    <?= strtoupper(html_escape($earn['consultation_type'])) ?>
                  </span>
                </td>
                <td><?= date('d M Y, h:i A', strtotime($earn['scheduled_at'])) ?></td>
                <td><strong style="color:rgb(34,197,94)">+ ₹350.00</strong></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No completed sessions or earnings logged yet.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
