<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model('support_ticket_model');
$tickets = $CI->support_ticket_model->get_where(['user_id' => $current_user['id']]);
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🎧 Support Tickets</div>
    <div class="page-header-sub">Submit tickets and get help regarding consultations, payouts, or profile approval status</div>
  </div>
  <div class="page-header-actions">
    <button onclick="document.getElementById('ticketModal').classList.add('open')" class="btn btn-primary btn-sm">✦ Create Ticket</button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Support History</div>
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Ticket No.</th>
            <th>Subject</th>
            <th>Message Summary</th>
            <th>Status</th>
            <th>Date Created</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($tickets)): ?>
            <?php foreach ($tickets as $t): ?>
              <tr>
                <td><strong style="color:var(--navy)"><?= html_escape($t['ticket_no']) ?></strong></td>
                <td><strong style="color:var(--text-mid)"><?= html_escape($t['subject']) ?></strong></td>
                <td style="max-width:250px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  <?= html_escape($t['message']) ?>
                </td>
                <td>
                  <?php if (strtolower($t['status']) === 'open'): ?>
                    <span class="badge badge-gold">Open</span>
                  <?php elseif (strtolower($t['status']) === 'closed'): ?>
                    <span class="badge badge-success">Closed</span>
                  <?php else: ?>
                    <span class="badge badge-warning"><?= ucfirst(html_escape($t['status'])) ?></span>
                  <?php endif; ?>
                </td>
                <td><?= date('d M Y', strtotime($t['created_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No support tickets created yet. Click "Create Ticket" to submit a request.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Ticket Modal -->
<div class="modal-overlay" id="ticketModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Create Support Ticket</div>
      <button class="modal-close" onclick="document.getElementById('ticketModal').classList.remove('open')">✕</button>
    </div>
    <form id="ticketForm" class="ajax-form" method="POST" action="<?= site_url('astrologer/save-ticket') ?>">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Subject <span class="req">*</span></label>
        <input class="form-input" type="text" name="subject" placeholder="Profile details not updating / payout delay" required>
      </div>

      <div class="form-group" style="margin-bottom:18px">
        <label class="form-label">Describe your issue <span class="req">*</span></label>
        <textarea class="form-input" name="message" rows="5" placeholder="Include payout txn id or other details..." required></textarea>
      </div>

      <button type="submit" class="btn btn-primary w-100">Submit Ticket ✦</button>
    </form>
  </div>
</div>
