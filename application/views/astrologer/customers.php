<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;

$CI->db->select('distinct(users.id) as user_id, users.name, users.email, users.mobile, user_profiles.dob, user_profiles.birth_place');
$CI->db->from('consultations');
$CI->db->join('users', 'users.id = consultations.user_id');
$CI->db->join('user_profiles', 'user_profiles.user_id = users.id', 'left');
$CI->db->where('consultations.astrologer_id', $astro_id);
$customers = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">👥 My Customers</div>
    <div class="page-header-sub">View and contact clients who have consulted with you previously</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Client Registry</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Date of Birth</th>
            <th>Birth Place</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $c): ?>
              <tr>
                <td><strong style="color:var(--navy)"><?= html_escape($c['name']) ?></strong></td>
                <td><?= html_escape($c['email']) ?></td>
                <td><?= html_escape($c['mobile'] ?: 'N/A') ?></td>
                <td><?= !empty($c['dob']) ? date('d M Y', strtotime($c['dob'])) : 'N/A' ?></td>
                <td><?= html_escape($c['birth_place'] ?: 'N/A') ?></td>
                <td>
                  <button class="btn btn-secondary btn-sm" onclick="alert('Opening consultation notes for <?= html_escape($c['name']) ?>')">Notes</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No registered customers found in your session history.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
