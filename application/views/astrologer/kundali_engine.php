<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->db->select('kundalis.*, users.name as user_name');
$CI->db->from('kundalis');
$CI->db->join('users', 'users.id = kundalis.user_id');
$CI->db->order_by('kundalis.created_at', 'DESC');
$kundalis = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🔭 Janam Kundali Engine</div>
    <div class="page-header-sub">Search and view generated birth charts and planetary coordinates of clients</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">User Birth Charts</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Profile Name</th>
            <th>Associated User</th>
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
                <td><?= html_escape($k['user_name']) ?></td>
                <td><?= date('d M Y', strtotime($k['dob'])) ?></td>
                <td><?= date('h:i A', strtotime($k['birth_time'])) ?></td>
                <td><?= html_escape($k['birth_place']) ?></td>
                <td><span style="font-size:11px;color:var(--text-muted)"><?= $k['latitude'] ?>° N, <?= $k['longitude'] ?>° E</span></td>
                <td>
                  <button class="btn btn-primary btn-sm" onclick="alert('Calculating planetary lagna chart positions for <?= html_escape($k['name']) ?>...')">Analyze Chart</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No customer Kundalis found in system.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
