<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;

$CI->db->select('consultations.*, users.name as user_name');
$CI->db->from('consultations');
$CI->db->join('users', 'users.id = consultations.user_id');
$CI->db->where('consultations.astrologer_id', $astro_id);
$CI->db->where_in('consultations.consultation_type', ['video', 'audio']);
$video_consults = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🎥 Audio & Video Consultations</div>
    <div class="page-header-sub">Launch call links and conduct direct spiritual conversations with clients</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Virtual Meeting Schedule</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Session ID</th>
            <th>Client Name</th>
            <th>Call Type</th>
            <th>Scheduled Time</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($video_consults)): ?>
            <?php foreach ($video_consults as $vc): ?>
              <tr>
                <td>#CON-<?= $vc['id'] ?></td>
                <td><strong style="color:var(--navy)"><?= html_escape($vc['user_name']) ?></strong></td>
                <td>
                  <span class="badge" style="background:rgba(200,147,26,0.1);color:var(--gold)">
                    <?= strtoupper(html_escape($vc['consultation_type'])) ?> CALL
                  </span>
                </td>
                <td><?= date('d M Y, h:i A', strtotime($vc['scheduled_at'])) ?></td>
                <td>
                  <?php if (strtolower($vc['status']) === 'completed'): ?>
                    <span class="badge badge-success">Completed</span>
                  <?php else: ?>
                    <span class="badge badge-gold">Booked</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (strtolower($vc['status']) !== 'completed'): ?>
                    <button class="btn btn-primary btn-sm" onclick="alert('Launching virtual meeting workspace for <?= html_escape($vc['user_name']) ?>. Connecting audio/video stream...')">Start Call 🎥</button>
                  <?php else: ?>
                    <span style="color:var(--text-muted);font-size:11px">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No scheduled audio or video consultations found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
