<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$astro = $current_astro;
?>

<div class="page-header">
  <div>
    <div class="page-header-title">👤 Astrologer Profile</div>
    <div class="page-header-sub">Manage your public information, languages, expertise, and biography</div>
  </div>
</div>

<form method="POST" action="<?= site_url('astrologer/save-profile') ?>">
  <div class="grid-2" style="gap:20px;align-items:start">

    <!-- Basic & Expert Info -->
    <div class="card">
      <div class="card-body">
        <div class="card-title">✦ Basic Profile Information</div>

        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Full Name <span class="req">*</span></label>
          <input class="form-input" type="text" name="name" value="<?= html_escape($current_user['name']) ?>" required>
        </div>

        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Mobile Number</label>
          <input class="form-input" type="tel" name="mobile" value="<?= html_escape($current_user['mobile']) ?>">
        </div>

        <div class="form-grid-2" style="margin-bottom:14px">
          <div class="form-group">
            <label class="form-label">Experience (Years) <span class="req">*</span></label>
            <input class="form-input" type="number" name="experience_years" min="0" value="<?= !empty($astro) ? intval($astro['experience_years']) : 1 ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Main Expertise <span class="req">*</span></label>
            <input class="form-input" type="text" name="expertise" placeholder="Vedic Astrology, Palmistry" value="<?= !empty($astro) ? html_escape($astro['expertise']) : 'Vedic' ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Languages spoken (Comma-separated) <span class="req">*</span></label>
          <input class="form-input" type="text" name="languages" placeholder="English, Hindi, Sanskrit" value="<?= !empty($astro) ? html_escape($astro['languages']) : 'English' ?>" required>
        </div>

      </div>
    </div>

    <!-- Biography & Account Status -->
    <div class="card">
      <div class="card-body">
        <div class="card-title">✦ Professional Biography</div>

        <div class="form-group" style="margin-bottom:18px">
          <label class="form-label">Public Bio / Introduction</label>
          <textarea class="form-input" name="bio" rows="6" placeholder="Describe your cosmic journey, expertise and lineage..." required><?= !empty($astro) ? html_escape($astro['bio']) : '' ?></textarea>
        </div>

        <!-- Approval Badge -->
        <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:8px;margin-bottom:18px;display:flex;justify-content:between;align-items:center;">
          <span style="font-size:12px;color:var(--text-muted)">Approval Status</span>
          <span class="badge <?= (!empty($astro) && $astro['approval_status'] === 'approved') ? 'badge-success' : 'badge-warning' ?>" style="font-size:11px">
            <?= !empty($astro) ? strtoupper($astro['approval_status']) : 'PENDING' ?>
          </span>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Profile ✦</button>
      </div>
    </div>

  </div>
</form>
