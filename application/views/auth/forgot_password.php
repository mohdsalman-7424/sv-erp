<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password — Samriddhi-Ventures</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700&family=Cinzel:wght@400;600;700&family=Mulish:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/design-system.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/nav.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>
<body>

<!-- TOP NAV -->
<nav id="top-nav">
  <a class="nav-brand" href="<?= site_url('/') ?>">
    <div class="nav-logo">ॐ</div>
    <div><div class="nav-brand-name">Samriddhi-Ventures</div><div class="nav-brand-sub">Sacred ERP Platform</div></div>
  </a>
  <div style="margin-left:auto;display:flex;align-items:center;gap:12px">
    <button class="theme-toggle" data-action="toggle-theme"><span class="theme-icon">🌙</span></button>
    <a href="<?= site_url('auth/login') ?>" class="btn-nav-outline">← Back to Login</a>
  </div>
</nav>

<div class="auth-page">
<div class="auth-split">
  <!-- LEFT PANEL -->
  <div class="auth-left">
    <div class="auth-left-content">
      <div style="font-size:48px;margin-bottom:16px">ॐ</div>
      <h2>Recover your<br><span>Credentials</span></h2>
      <p style="margin-bottom:22px">Reset your password to resume connecting with certified experts and accessing platform features.</p>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="auth-right">
    <div class="auth-card">
      <div class="auth-logo">
        <span class="om">ॐ</span>
        <h3>Samriddhi-Ventures</h3>
      </div>

      <div class="auth-title">Reset Password</div>
      <div class="auth-sub">Enter your email and we'll send recovery details</div>

      <div class="tab-panel active">
        <form method="POST" action="<?= site_url('auth/do-forgot-password') ?>">
          <div class="form-group" style="margin-bottom:18px">
            <label class="form-label">Email Address</label>
            <div class="input-wrap">
              <span class="input-icon">📧</span>
              <input class="form-input" type="email" name="email" placeholder="arjun@example.com" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100">Send Recovery Link →</button>
        </form>
      </div>

      <div class="auth-footer">
        Remembered your password? <a href="<?= site_url('auth/login') ?>">Sign In</a>
      </div>
    </div>
  </div>
</div>
</div>

<div id="toast-container"></div>
<script src="<?= base_url('assets/js/store.js') ?>"></script>
<script src="<?= base_url('assets/js/core.js') ?>"></script>
<script>
<?php if ($this->session->flashdata('error')): ?>
document.addEventListener('DOMContentLoaded', () => {
  Toast.show('<?= html_escape($this->session->flashdata('error')) ?>', 'error');
});
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
document.addEventListener('DOMContentLoaded', () => {
  Toast.show('<?= html_escape($this->session->flashdata('success')) ?>', 'success');
});
<?php endif; ?>
</script>
</body>
</html>
