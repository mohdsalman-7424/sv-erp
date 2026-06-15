<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;

$CI->db->select('predictions.*, users.name as user_name');
$CI->db->from('predictions');
$CI->db->join('users', 'users.id = predictions.user_id');
$CI->db->where('predictions.astrologer_id', $astro_id);
$CI->db->order_by('predictions.created_at', 'DESC');
$predictions = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🔮 Kundali Predictions & Ask Astro</div>
    <div class="page-header-sub">Provide sacred answers and planetary predictions to questions raised by seekers</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">User Queries</div>
    <?php if (!empty($predictions)): ?>
      <div style="display:flex;flex-direction:column;gap:20px">
        <?php foreach ($predictions as $p): ?>
          <div style="border:1px solid var(--border);border-radius:12px;padding:18px;background:var(--gold-pale)">
            <div style="display:flex;justify-content:between;align-items:center;margin-bottom:8px">
              <strong style="color:var(--navy)"><?= html_escape($p['user_name']) ?></strong>
              <small style="color:var(--text-muted);margin-left:auto"><?= date('d M Y, h:i A', strtotime($p['created_at'])) ?></small>
            </div>
            
            <div style="font-size:13px;color:var(--text-mid);line-height:1.6;margin-bottom:14px;background:white;padding:10px 14px;border-radius:8px;border:1px solid var(--border)">
              <strong>Question:</strong> <?= html_escape($p['question']) ?>
            </div>

            <?php if (!empty($p['prediction'])): ?>
              <div style="font-size:13px;color:var(--navy);line-height:1.6;background:rgba(200,147,26,0.08);padding:10px 14px;border-radius:8px;border:1px solid rgba(200,147,26,0.15)">
                <strong>Your Answer:</strong> <?= html_escape($p['prediction']) ?>
              </div>
            <?php else: ?>
              <form method="POST" action="<?= site_url('astrologer/save-prediction/'.$p['id']) ?>">
                <div class="form-group" style="margin-bottom:10px">
                  <label class="form-label" style="font-size:11px">Write your prediction / reply:</label>
                  <textarea class="form-input" name="prediction" rows="3" placeholder="Analyze charts, planetary transit positions, and write your sacred advice..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Submit Answer ✦</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div style="text-align:center;color:var(--text-muted);padding:30px 10px;">
        No predictions or queries assigned to you yet.
      </div>
    <?php endif; ?>
  </div>
</div>
