<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model(['kundali_model', 'kundali_match_model']);
$kundalis = $CI->kundali_model->get_where(['user_id' => $current_user['id']]);

$CI->db->select('kundali_matches.*, k1.name as male_name, k2.name as female_name');
$CI->db->from('kundali_matches');
$CI->db->join('kundalis k1', 'k1.id = kundali_matches.male_kundali_id');
$CI->db->join('kundalis k2', 'k2.id = kundali_matches.female_kundali_id');
$CI->db->where('k1.user_id', $current_user['id']);
$matches = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">💑 Kundali Matching (Gun Milan)</div>
    <div class="page-header-sub">Verify compatibility between bride and groom charts using Ashtakoota system</div>
  </div>
  <div class="page-header-actions">
    <button onclick="document.getElementById('matchModal').classList.add('open')" class="btn btn-primary btn-sm">✦ Match New Charts</button>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Matchmaking History</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Groom Profile</th>
            <th>Bride Profile</th>
            <th>Guna Score</th>
            <th>Compatibility</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($matches)): ?>
            <?php foreach ($matches as $m): ?>
              <tr>
                <td>#MATCH-<?= $m['id'] ?></td>
                <td><strong style="color:var(--navy)"><?= html_escape($m['male_name']) ?></strong></td>
                <td><strong style="color:var(--navy)"><?= html_escape($m['female_name']) ?></strong></td>
                <td><strong style="color:var(--saffron)"><?= $m['guna_score'] ?> / 36</strong></td>
                <td>
                  <?php if ($m['guna_score'] >= 25): ?>
                    <span class="badge badge-success">Excellent</span>
                  <?php elseif ($m['guna_score'] >= 18): ?>
                    <span class="badge badge-gold">Compatible</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Low (Nadi Dosha)</span>
                  <?php endif; ?>
                </td>
                <td><?= date('d M Y', strtotime($m['created_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No matches computed yet. Click "Match New Charts" to perform Gun Milan.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Match Modal -->
<div class="modal-overlay" id="matchModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Gun Milan Compatibility Check</div>
      <button class="modal-close" onclick="document.getElementById('matchModal').classList.remove('open')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('user/save-match') ?>">
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Select Groom's Chart (Male) <span class="req">*</span></label>
        <select class="form-select" name="male_kundali_id" required>
          <option value="">Select Groom Chart</option>
          <?php foreach ($kundalis as $k): ?>
            <option value="<?= $k['id'] ?>"><?= html_escape($k['name']) ?> (<?= date('d M Y', strtotime($k['dob'])) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom:18px">
        <label class="form-label">Select Bride's Chart (Female) <span class="req">*</span></label>
        <select class="form-select" name="female_kundali_id" required>
          <option value="">Select Bride Chart</option>
          <?php foreach ($kundalis as $k): ?>
            <option value="<?= $k['id'] ?>"><?= html_escape($k['name']) ?> (<?= date('d M Y', strtotime($k['dob'])) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary w-100">Perform Gun Milan ✦</button>
    </form>
  </div>
</div>
