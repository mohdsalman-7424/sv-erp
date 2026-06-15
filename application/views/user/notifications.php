<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model('notification_model');
$notifications = $CI->notification_model->get_where(['user_id' => $current_user['id']]);
// Sort by id desc
usort($notifications, function($a, $b) {
    return $b['id'] - $a['id'];
});
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🔔 Notifications</div>
    <div class="page-header-sub">View recent system updates, transaction alerts, and consultation reminders</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Recent Alerts</div>
    <?php if (!empty($notifications)): ?>
      <div style="display:flex;flex-direction:column;gap:12px">
        <?php foreach ($notifications as $note): ?>
          <div style="display:flex;align-items:start;gap:14px;padding:12px 14px;background: <?= $note['is_read'] ? 'transparent' : 'var(--gold-pale)' ?>;border:1px solid var(--border);border-radius:10px">
            <div style="font-size:20px;padding:6px;background:rgba(200,147,26,0.1);border-radius:50%">🔔</div>
            <div style="flex-grow:1">
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                <strong style="color:var(--navy);font-size:13px;"><?= html_escape($note['title']) ?></strong>
                <span style="font-size:10px;color:var(--text-muted)"><?= date('d M Y, h:i A', strtotime($note['created_at'])) ?></span>
              </div>
              <div style="font-size:12px;color:var(--text-mid);line-height:1.6"><?= html_escape($note['message']) ?></div>
            </div>
            <?php if (!$note['is_read']): ?>
              <span class="badge badge-gold" style="font-size:8px;padding:2px 6px;">New</span>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div style="text-align:center;color:var(--text-muted);padding:30px 10px;">
        No notifications yet.
      </div>
    <?php endif; ?>
  </div>
</div>
