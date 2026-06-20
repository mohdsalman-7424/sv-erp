<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->db->select('consultations.*, users.name as astrologer_name');
$CI->db->from('consultations');
$CI->db->join('astrologers', 'astrologers.id = consultations.astrologer_id', 'left');
$CI->db->join('users', 'users.id = astrologers.user_id', 'left');
$CI->db->where('consultations.user_id', $current_user['id']);
$CI->db->order_by('consultations.scheduled_at', 'DESC');
$consultations = $CI->db->get()->result_array();

// Get list of available astrologers to book
$CI->db->select('astrologers.id, users.name, astrologers.expertise, astrologers.experience_years');
$CI->db->from('astrologers');
$CI->db->join('users', 'users.id = astrologers.user_id');
$CI->db->where('astrologers.approval_status', 'approved');
$astrologers = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">💬 My Consultations</div>
    <div class="page-header-sub">View and book live chat, audio, or video sessions with certified astrologers</div>
  </div>
  <div class="page-header-actions">
    <button onclick="document.getElementById('bookingModal').classList.add('open')" class="btn btn-primary btn-sm">✦ Book Consultation</button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Consultation History</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Astrologer</th>
            <th>Type</th>
            <th>Scheduled Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($consultations)): ?>
            <?php foreach ($consultations as $con): ?>
              <tr>
                <td>#CON-<?= $con['id'] ?></td>
                <td><strong style="color:var(--navy)"><?= html_escape($con['astrologer_name'] ?: 'N/A') ?></strong></td>
                <td>
                  <span class="badge" style="background:rgba(200,147,26,0.1);color:var(--gold)">
                    <?= strtoupper(html_escape($con['consultation_type'])) ?>
                  </span>
                </td>
                <td><?= date('d M Y, h:i A', strtotime($con['scheduled_at'])) ?></td>
                <td>
                  <?php if (strtolower($con['status']) === 'approved' || strtolower($con['status']) === 'booked' || strtolower($con['status']) === 'completed'): ?>
                    <span class="badge badge-success"><?= ucfirst(html_escape($con['status'])) ?></span>
                  <?php else: ?>
                    <span class="badge badge-warning"><?= ucfirst(html_escape($con['status'])) ?></span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No consultations found. Click "Book Consultation" to schedule one.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Booking Modal -->
<div class="modal-overlay" id="bookingModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Book a Consultation</div>
      <button class="modal-close" onclick="document.getElementById('bookingModal').classList.remove('open')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('user/book-consultation') ?>">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Select Astrologer <span class="req">*</span></label>
        <select class="form-select" name="astrologer_id" required>
          <option value="">Select Astrologer</option>
          <?php foreach ($astrologers as $ast): ?>
            <option value="<?= $ast['id'] ?>"><?= html_escape($ast['name']) ?> (<?= html_escape($ast['expertise']) ?> - <?= $ast['experience_years'] ?> yrs exp)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Consultation Type <span class="req">*</span></label>
        <select class="form-select" name="consultation_type" required>
          <option value="chat">Chat</option>
          <option value="audio">Audio Call</option>
          <option value="video">Video Call</option>
        </select>
      </div>

      <div class="form-group" style="margin-bottom:18px">
        <label class="form-label">Scheduled Date & Time <span class="req">*</span></label>
        <input class="form-input" type="datetime-local" name="scheduled_at" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Schedule & Book ✦</button>
    </form>
  </div>
</div>
