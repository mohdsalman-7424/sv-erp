<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model('kundali_model');
$kundalis = $CI->kundali_model->get_where(['user_id' => $current_user['id']]);
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🔭 Kundali Reports</div>
    <div class="page-header-sub">Generate and view your personal Janam Kundali (Birth Charts)</div>
  </div>
  <div class="page-header-actions">
    <button onclick="document.getElementById('kundaliModal').classList.add('open')" class="btn btn-primary btn-sm">✦ Generate Kundali</button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Generated Birth Charts</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>DOB</th>
            <th>Time of Birth</th>
            <th>Birth Place</th>
            <th>Coordinates</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($kundalis)): ?>
            <?php foreach ($kundalis as $k): ?>
              <tr>
                <td><strong style="color:var(--navy)"><?= html_escape($k['name']) ?></strong></td>
                <td><?= date('d M Y', strtotime($k['dob'])) ?></td>
                <td><?= date('h:i A', strtotime($k['birth_time'])) ?></td>
                <td><?= html_escape($k['birth_place']) ?></td>
                <td><span style="font-size:11px;color:var(--text-muted)"><?= $k['latitude'] ?>° N, <?= $k['longitude'] ?>° E</span></td>
                <td>
                  <a href="#" class="btn btn-secondary btn-sm" onclick="alert('Viewing detailed Vedic analysis report for <?= html_escape($k['name']) ?>...'); return false;">View Report</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No Kundali charts generated. Click "Generate Kundali" to create one.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Kundali Modal -->
<div class="modal-overlay" id="kundaliModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Generate Janam Kundali</div>
      <button class="modal-close" onclick="document.getElementById('kundaliModal').classList.remove('open')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('user/save-kundali') ?>">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom:12px">
        <label class="form-label">Name <span class="req">*</span></label>
        <input class="form-input" type="text" name="name" placeholder="Arjun Mehta" required>
      </div>

      <div class="form-grid-2" style="margin-bottom:12px">
        <div class="form-group">
          <label class="form-label">Date of Birth <span class="req">*</span></label>
          <input class="form-input" type="date" name="dob" required>
        </div>
        <div class="form-group">
          <label class="form-label">Time of Birth <span class="req">*</span></label>
          <input class="form-input" type="time" name="birth_time" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Birth Place <span class="req">*</span></label>
        <input class="form-input" type="text" name="birth_place" placeholder="Mumbai, Maharashtra" required>
      </div>

      <div class="form-grid-2" style="margin-bottom:18px">
        <div class="form-group">
          <label class="form-label">Latitude</label>
          <input class="form-input" type="number" step="any" name="latitude" value="19.0760">
        </div>
        <div class="form-group">
          <label class="form-label">Longitude</label>
          <input class="form-input" type="number" step="any" name="longitude" value="72.8777">
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Calculate & Generate ✦</button>
    </form>
  </div>
</div>
