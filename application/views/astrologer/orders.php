<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;

$CI->db->select('consultations.*, users.name as user_name');
$CI->db->from('consultations');
$CI->db->join('users', 'users.id = consultations.user_id');
$CI->db->where('consultations.astrologer_id', $astro_id);
$CI->db->order_by('consultations.scheduled_at', 'DESC');
$orders = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">📦 Consultation Orders</div>
    <div class="page-header-sub">Manage your booked slots and update consultation statuses</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">All Bookings</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Client Name</th>
            <th>Consultation Type</th>
            <th>Scheduled Time</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $ord): ?>
              <tr>
                <td>#CON-<?= $ord['id'] ?></td>
                <td><strong style="color:var(--navy)"><?= html_escape($ord['user_name']) ?></strong></td>
                <td>
                  <span class="badge" style="background:rgba(200,147,26,0.1);color:var(--gold)">
                    <?= strtoupper(html_escape($ord['consultation_type'])) ?>
                  </span>
                </td>
                <td><?= date('d M Y, h:i A', strtotime($ord['scheduled_at'])) ?></td>
                <td>
                  <?php if (strtolower($ord['status']) === 'completed'): ?>
                    <span class="badge badge-success">Completed</span>
                  <?php elseif (strtolower($ord['status']) === 'booked'): ?>
                    <span class="badge badge-gold">Booked</span>
                  <?php else: ?>
                    <span class="badge badge-warning"><?= ucfirst(html_escape($ord['status'])) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (strtolower($ord['status']) === 'booked'): ?>
                    <div style="display:flex;gap:6px">
                      <a href="<?= site_url('astrologer/update-consultation/'.$ord['id'].'/completed') ?>" class="btn btn-primary btn-sm" style="padding:2px 8px;font-size:11px">Complete</a>
                      <a href="<?= site_url('astrologer/update-consultation/'.$ord['id'].'/cancelled') ?>" class="btn btn-secondary btn-sm" style="padding:2px 8px;font-size:11px" onclick="return confirm('Cancel this consultation?')">Cancel</a>
                    </div>
                  <?php else: ?>
                    <span style="color:var(--text-muted);font-size:11px">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No bookings or consultation orders found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
