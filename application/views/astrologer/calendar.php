<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;
$slots = $CI->db->get_where('astrologer_availability', ['astrologer_id' => $astro_id])->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">📅 Consultation Calendar</div>
    <div class="page-header-sub">Manage your weekly availability slots for user booking appointments</div>
  </div>
  <div class="page-header-actions">
    <button onclick="document.getElementById('slotModal').classList.add('open')" class="btn btn-primary btn-sm">✦ Add Availability Slot</button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Weekly Schedule Slots</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Day Name</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($slots)): ?>
            <?php foreach ($slots as $s): ?>
              <tr>
                <td><strong style="color:var(--navy)"><?= ucfirst(html_escape($s['day_name'])) ?></strong></td>
                <td><?= date('h:i A', strtotime($s['start_time'])) ?></td>
                <td><?= date('h:i A', strtotime($s['end_time'])) ?></td>
                <td>
                  <a href="<?= site_url('astrologer/delete-slot/'.$s['id']) ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Remove this slot?')">Remove</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No availability slots added yet. Click "Add Availability Slot" to publish schedule.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Slot Modal -->
<div class="modal-overlay" id="slotModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Create Availability Slot</div>
      <button class="modal-close" onclick="document.getElementById('slotModal').classList.remove('open')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('astrologer/save-slot') ?>">
      <div class="form-group" style="margin-bottom:12px">
        <label class="form-label">Day of Week <span class="req">*</span></label>
        <select class="form-select" name="day_name" required>
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          <option value="Saturday">Saturday</option>
          <option value="Sunday">Sunday</option>
        </select>
      </div>

      <div class="form-grid-2" style="margin-bottom:18px">
        <div class="form-group">
          <label class="form-label">Start Time <span class="req">*</span></label>
          <input class="form-input" type="time" name="start_time" required>
        </div>
        <div class="form-group">
          <label class="form-label">End Time <span class="req">*</span></label>
          <input class="form-input" type="time" name="end_time" required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Add Slot ✦</button>
    </form>
  </div>
</div>
