<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model('astrologer_plan_model');
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;
$plans = $CI->astrologer_plan_model->get_where(['astrologer_id' => $astro_id]);
?>

<div class="page-header">
  <div>
    <div class="page-header-title">📋 Service Plans</div>
    <div class="page-header-sub">Configure your consultation price catalogs, reports, and digital service packages</div>
  </div>
  <div class="page-header-actions">
    <button onclick="document.getElementById('planModal').classList.add('open')" class="btn btn-primary btn-sm">✦ Add Service Plan</button>
  </div>
</div>

<div class="grid-3" style="gap:20px">
  <?php if (!empty($plans)): ?>
    <?php foreach ($plans as $p): ?>
      <div class="card">
        <div class="card-body" style="display:flex;flex-direction:column;height:100%;min-height:240px">
          <div style="display:flex;justify-content:between;align-items:start">
            <h3 class="cinzel" style="margin:0;color:var(--navy);font-size:16px"><?= html_escape($p['title']) ?></h3>
            <span class="badge <?= $p['status'] ? 'badge-success' : 'badge-warning' ?>" style="margin-left:auto">
              <?= $p['status'] ? 'Active' : 'Inactive' ?>
            </span>
          </div>

          <div style="font-size:24px;font-weight:800;color:var(--saffron);margin:14px 0 6px 0">
            ₹<?= number_format($p['price'], 2) ?>
            <span style="font-size:11px;color:var(--text-muted);font-weight:400">/ <?= intval($p['duration_days']) ?> Days</span>
          </div>

          <p style="font-size:12px;color:var(--text-mid);line-height:1.6;flex-grow:1;margin:8px 0 16px 0">
            <?= html_escape($p['description']) ?>
            <br>
            <small style="color:var(--text-muted)">Delivery: <?= html_escape($p['delivery_time']) ?></small>
          </p>

          <div style="display:flex;gap:10px;margin-top:auto">
            <a href="<?= site_url('astrologer/delete-plan/'.$p['id']) ?>" class="btn btn-secondary btn-sm" style="flex:1;text-align:center;" onclick="return confirm('Delete this service plan?')">Delete</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="card" style="grid-column: span 3;text-align:center;padding:30px 10px;color:var(--text-muted)">
      No service plans created yet. Click "Add Service Plan" to publish your pricing.
    </div>
  <?php endif; ?>
</div>

<!-- Plan Modal -->
<div class="modal-overlay" id="planModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Create Service Plan</div>
      <button class="modal-close" onclick="document.getElementById('planModal').classList.remove('open')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('astrologer/save-plan') ?>">
      <div class="form-group" style="margin-bottom:12px">
        <label class="form-label">Plan Title <span class="req">*</span></label>
        <input class="form-input" type="text" name="title" placeholder="Detailed Kundali Match report / 30 Min Video chat" required>
      </div>

      <div class="form-group" style="margin-bottom:12px">
        <label class="form-label">Description</label>
        <textarea class="form-input" name="description" rows="3" placeholder="Provide details on what this service entails..."></textarea>
      </div>

      <div class="form-grid-3" style="margin-bottom:18px">
        <div class="form-group">
          <label class="form-label">Price (₹) <span class="req">*</span></label>
          <input class="form-input" type="number" name="price" min="0" required>
        </div>
        <div class="form-group">
          <label class="form-label">Duration (Days)</label>
          <input class="form-input" type="number" name="duration_days" value="1">
        </div>
        <div class="form-group">
          <label class="form-label">Delivery Time</label>
          <input class="form-input" type="text" name="delivery_time" placeholder="Immediate / 24 hours" value="Immediate">
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Publish Service Plan ✦</button>
    </form>
  </div>
</div>
