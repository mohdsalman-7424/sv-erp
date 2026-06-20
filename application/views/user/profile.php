<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model(['user_profile_model', 'user_address_model']);
$profile = $CI->user_profile_model->get_where(['user_id' => $current_user['id']]);
$address = $CI->user_address_model->get_where(['user_id' => $current_user['id']]);

$p_data = !empty($profile) ? $profile[0] : [];
$a_data = !empty($address) ? $address[0] : [];
?>

<div class="page-header">
  <div>
    <div class="page-header-title">👤 My Profile</div>
    <div class="page-header-sub">Manage your personal settings, birth chart inputs, and address</div>
  </div>
</div>

<form method="POST" action="<?= site_url('user/save-profile') ?>">
  <?= csrf_field() ?>
  <div class="grid-2" style="gap:20px;align-items:start">
    
    <!-- Account & Birth Details -->
    <div class="card">
      <div class="card-body">
        <div class="card-title">✦ Basic & Birth Details</div>
        
        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Full Name <span class="req">*</span></label>
          <input class="form-input" type="text" name="name" value="<?= html_escape($current_user['name']) ?>" required>
        </div>
        
        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Email Address <span class="req">*</span></label>
          <input class="form-input" type="email" value="<?= html_escape($current_user['email']) ?>" disabled style="background:#f5f5f5">
        </div>

        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Mobile Number</label>
          <input class="form-input" type="tel" name="mobile" value="<?= html_escape($current_user['mobile']) ?>">
        </div>

        <div class="form-grid-2" style="margin-bottom:14px">
          <div class="form-group">
            <label class="form-label">Date of Birth</label>
            <input class="form-input" type="date" name="dob" value="<?= isset($p_data['dob']) ? $p_data['dob'] : '' ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Time of Birth</label>
            <input class="form-input" type="time" name="birth_time" value="<?= isset($p_data['birth_time']) ? $p_data['birth_time'] : '' ?>">
          </div>
        </div>

        <div class="form-grid-2" style="margin-bottom:14px">
          <div class="form-group">
            <label class="form-label">Birth Place</label>
            <input class="form-input" type="text" name="birth_place" placeholder="Mumbai, India" value="<?= isset($p_data['birth_place']) ? html_escape($p_data['birth_place']) : '' ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Gender</label>
            <select class="form-select" name="gender">
              <option value="">Select Gender</option>
              <option value="Male" <?= (isset($p_data['gender']) && $p_data['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= (isset($p_data['gender']) && $p_data['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
              <option value="Other" <?= (isset($p_data['gender']) && $p_data['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Marital Status</label>
          <select class="form-select" name="marital_status">
            <option value="">Select Status</option>
            <option value="Single" <?= (isset($p_data['marital_status']) && $p_data['marital_status'] == 'Single') ? 'selected' : '' ?>>Single</option>
            <option value="Married" <?= (isset($p_data['marital_status']) && $p_data['marital_status'] == 'Married') ? 'selected' : '' ?>>Married</option>
            <option value="Divorced" <?= (isset($p_data['marital_status']) && $p_data['marital_status'] == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Address & Bio -->
    <div class="card">
      <div class="card-body">
        <div class="card-title">✦ Address & Contact Details</div>

        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Street Address</label>
          <input class="form-input" type="text" name="address" placeholder="102, Shanti Kunj" value="<?= isset($a_data['address']) ? html_escape($a_data['address']) : '' ?>">
        </div>

        <div class="form-grid-2" style="margin-bottom:14px">
          <div class="form-group">
            <label class="form-label">City</label>
            <input class="form-input" type="text" name="city" placeholder="Mumbai" value="<?= isset($a_data['city']) ? html_escape($a_data['city']) : '' ?>">
          </div>
          <div class="form-group">
            <label class="form-label">State</label>
            <input class="form-input" type="text" name="state" placeholder="Maharashtra" value="<?= isset($a_data['state']) ? html_escape($a_data['state']) : '' ?>">
          </div>
        </div>

        <div class="form-grid-2" style="margin-bottom:14px">
          <div class="form-group">
            <label class="form-label">Country</label>
            <input class="form-input" type="text" name="country" placeholder="India" value="<?= isset($a_data['country']) ? html_escape($a_data['country']) : '' ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Pincode</label>
            <input class="form-input" type="text" name="pincode" placeholder="400001" value="<?= isset($a_data['pincode']) ? html_escape($a_data['pincode']) : '' ?>">
          </div>
        </div>

        <div class="form-group" style="margin-bottom:18px">
          <label class="form-label">Bio / Notes</label>
          <textarea class="form-input" name="bio" rows="4" placeholder="Write something about your preferences..."><?= isset($p_data['bio']) ? html_escape($p_data['bio']) : '' ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Changes ✦</button>
      </div>
    </div>

  </div>
</form>
