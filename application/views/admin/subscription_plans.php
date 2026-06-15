<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">💎 Subscription Plans</div>
    <div class="page-header-sub">Manage platform subscription packages and pricing</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-primary btn-sm" onclick="openModal('addPlanModal')">+ Add Plan</button>
  </div>
</div>

<!-- Stats Strip -->
<div class="kpi-grid" style="margin-bottom:20px">
  <div class="kpi-card"><div class="kpi-label">Total Plans</div><div class="kpi-val"><?= count($plans_db) ?></div><div class="kpi-change kpi-up">● Active</div></div>
  <div class="kpi-card">
    <div class="kpi-label">Average Price</div>
    <div class="kpi-val">
      ₹<?php 
        $prices = array_column($plans_db, 'price'); 
        echo count($prices) ? number_format(array_sum($prices) / count($prices), 2) : '0.00'; 
      ?>
    </div>
    <div class="kpi-change kpi-up">▲ Competitive</div>
  </div>
  <div class="kpi-card"><div class="kpi-label">Billing Currency</div><div class="kpi-val">INR (₹)</div><div class="kpi-change kpi-up">● Standard</div></div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-body">
    <div style="overflow-x:auto">
      <table class="data-table">
        <thead>
          <tr>
            <th>Plan Name</th>
            <th>Price</th>
            <th>Duration (Days)</th>
            <th>Features</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($plans_db)): ?>
            <?php foreach ($plans_db as $p): ?>
              <tr>
                <td><strong style="color:var(--navy)"><?= html_escape($p['name']) ?></strong></td>
                <td style="font-weight:700;color:var(--saffron)">₹<?= number_format($p['price'], 2) ?></td>
                <td><span class="badge badge-navy"><?= intval($p['duration']) ?> Days</span></td>
                <td>
                  <div style="display:flex;flex-wrap:wrap;gap:4px">
                    <?php 
                      $feats = json_decode($p['features'], true);
                      if (is_array($feats)) {
                          foreach ($feats as $f) {
                              echo '<span class="tag" style="font-size:10px">' . html_escape(trim($f)) . '</span>';
                          }
                      } else {
                          echo '<span class="tag" style="font-size:10px">' . html_escape($p['features']) . '</span>';
                      }
                    ?>
                  </div>
                </td>
                <td>
                  <?php if ($p['status'] == 1): ?>
                    <span class="badge badge-success">● Active</span>
                  <?php else: ?>
                    <span class="badge badge-warning">⚫ Inactive</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div style="display:flex;gap:5px">
                    <button class="btn-navy btn-sm" onclick="editPlan(<?= html_escape(json_encode($p)) ?>)">Edit</button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;padding:24px;color:var(--text-muted)">No subscription plans found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Plan Modal -->
<div class="modal-overlay" id="addPlanModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Add New Plan</div>
      <button class="modal-close" onclick="closeModal('addPlanModal')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('admin/save-plan') ?>">
      <div class="form-grid-2" style="grid-template-columns:1fr">
        <div class="form-group"><label class="form-label">Plan Name <span class="req">*</span></label><input class="form-input" name="name" type="text" placeholder="Gold Plan" required></div>
        <div class="form-group"><label class="form-label">Price (₹) <span class="req">*</span></label><input class="form-input" name="price" type="number" step="0.01" placeholder="999.00" required></div>
        <div class="form-group"><label class="form-label">Duration (Days) <span class="req">*</span></label><input class="form-input" name="duration" type="number" placeholder="30" required></div>
        <div class="form-group"><label class="form-label">Features (Comma separated) <span class="req">*</span></label><input class="form-input" name="features" type="text" placeholder="Daily Horoscope, Ask 2 Questions, Chat with Guru" required></div>
      </div>
      <button class="btn btn-primary w-100" style="margin-top:18px" type="submit">Save Plan</button>
    </form>
  </div>
</div>

<!-- Edit Plan Modal -->
<div class="modal-overlay" id="editPlanModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Plan</div>
      <button class="modal-close" onclick="closeModal('editPlanModal')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('admin/save-plan') ?>">
      <input type="hidden" name="id" id="editPlanId">
      <div class="form-grid-2" style="grid-template-columns:1fr">
        <div class="form-group"><label class="form-label">Plan Name <span class="req">*</span></label><input class="form-input" name="name" id="editPlanName" type="text" required></div>
        <div class="form-group"><label class="form-label">Price (₹) <span class="req">*</span></label><input class="form-input" name="price" id="editPlanPrice" type="number" step="0.01" required></div>
        <div class="form-group"><label class="form-label">Duration (Days) <span class="req">*</span></label><input class="form-input" name="duration" id="editPlanDuration" type="number" required></div>
        <div class="form-group"><label class="form-label">Features (Comma separated) <span class="req">*</span></label><input class="form-input" name="features" id="editPlanFeatures" type="text" required></div>
      </div>
      <button class="btn btn-primary w-100" style="margin-top:18px" type="submit">Update Plan</button>
    </form>
  </div>
</div>

<script>
function openModal(id) {
  document.getElementById(id).classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function editPlan(plan) {
  document.getElementById('editPlanId').value = plan.id;
  document.getElementById('editPlanName').value = plan.name;
  document.getElementById('editPlanPrice').value = plan.price;
  document.getElementById('editPlanDuration').value = plan.duration;
  
  let featuresArray = [];
  try {
    featuresArray = JSON.parse(plan.features);
  } catch(e) {
    featuresArray = [plan.features];
  }
  document.getElementById('editPlanFeatures').value = Array.isArray(featuresArray) ? featuresArray.join(', ') : plan.features;
  
  openModal('editPlanModal');
}
</script>
