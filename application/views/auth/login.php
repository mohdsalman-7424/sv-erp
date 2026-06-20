<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= html_escape($page_title) ?></title>
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
    <a href="<?= site_url('/') ?>" class="btn-nav-outline">← Back to Home</a>
  </div>
</nav>

<div class="auth-page">
<div class="auth-split">
  <!-- LEFT PANEL -->
  <div class="auth-left">
    <div class="auth-left-content">
      <div style="font-size:48px;margin-bottom:16px">ॐ</div>
      <h2>Welcome to<br><span>Samriddhi-Ventures</span></h2>
      <p style="margin-bottom:22px">India's most trusted Vedic astrology platform connecting seekers with certified experts.</p>
      <div class="auth-feature">Authentic Vedic Kundli generation</div>
      <div class="auth-feature">1,200+ verified expert astrologers</div>
      <div class="auth-feature">Live chat, audio & video consultations</div>
      <div class="auth-feature">Personalized horoscope & predictions</div>
      <div class="auth-feature">Secure payments & wallet system</div>
      <div style="margin-top:32px;padding:20px;background:rgba(200,147,26,0.08);border:1px solid rgba(200,147,26,0.2);border-radius:12px">
        <div style="font-size:13px;color:rgba(255,255,255,0.5);font-style:italic;line-height:1.8">"यथा पिण्डे तथा ब्रह्माण्डे"<br><span style="font-size:11px">As is the individual, so is the universe</span></div>
      </div>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="auth-right">
    <div class="auth-card">
      <div class="auth-logo">
        <span class="om">ॐ</span>
        <h3>Samriddhi-Ventures</h3>
      </div>

      <!-- Role Tabs -->
      <div class="role-tabs" id="roleTabs">
        <button type="button" class="role-tab active" onclick="setRole('user',this)">👤 User</button>
        <button type="button" class="role-tab" onclick="setRole('astrologer',this)">🧘 Astrologer</button>
        <button type="button" class="role-tab" onclick="setRole('admin',this)">⚙ Admin</button>
      </div>

      <div class="auth-title">Sign In</div>
      <div class="auth-sub">Enter your credentials to access your account</div>

      <!-- Login Method Tabs -->
      <div class="login-tabs">
        <button type="button" class="login-tab active" onclick="switchTab('email',this)">📧 Email</button>
        <!-- <button type="button" class="login-tab" onclick="switchTab('otp',this)">📱 OTP</button>
        <button type="button" class="login-tab" onclick="switchTab('social',this)">🌐 Social</button> -->
      </div>

      <!-- Email Tab -->
      <div class="tab-panel active" id="tab-email">
        <form method="POST" action="<?= site_url('auth/do-login') ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="role" id="loginRole" value="user">
          <div class="form-group" style="margin-bottom:14px">
            <label class="form-label">Email Address</label>
            <div class="input-wrap">
              <span class="input-icon">📧</span>
              <input class="form-input" type="email" name="email" id="loginEmail" placeholder="arjun@example.com" required>
            </div>
          </div>
          <div class="form-group" style="margin-bottom:8px">
            <label class="form-label">Password</label>
            <div class="input-wrap">
              <span class="input-icon">🔒</span>
              <input class="form-input" type="password" name="password" id="loginPass" placeholder="••••••••" required minlength="8">
            </div>
          </div>
          <div style="display:flex;justify-content:flex-end;margin-bottom:18px">
            <a href="<?= site_url('auth/forgot-password') ?>" class="forgot-link">Forgot Password?</a>
          </div>
          <button type="submit" class="btn btn-primary w-100">Sign In →</button>
        </form>
      </div>

      <!-- OTP Tab -->
      <div class="tab-panel" id="tab-otp">
        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Mobile Number</label>
          <div class="input-wrap">
            <span class="input-icon">📱</span>
            <input class="form-input" type="tel" placeholder="+91 98765 43210">
          </div>
        </div>
        <button class="btn btn-primary w-100" onclick="Toast.show('OTP sent to your mobile!','success')">Send OTP</button>
      </div>

      <!-- Social Tab -->
      <div class="tab-panel" id="tab-social">
        <button class="social-btn" onclick="doSocialLogin('google')"><span>🔵</span> Continue with Google</button>
        <button class="social-btn" onclick="doSocialLogin('facebook')"><span>🔷</span> Continue with Facebook</button>
      </div>

      <!-- Demo Credentials -->
      <div style="margin-top:16px;padding:10px 12px;background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;font-size:11px;color:var(--text-mid)">
        Use your registered email and password (minimum 8 characters).
      </div>

      <div class="auth-footer">
        Don't have an account? <a href="<?= site_url('auth/register') ?>">Register Free</a>
      </div>
    </div>
  </div>
</div>
</div>

<div id="toast-container"></div>
<script src="<?= base_url('assets/js/store.js') ?>"></script>
<script src="<?= base_url('assets/js/core.js') ?>"></script>
<script>
let currentRole = 'user';

function setRole(role, btn) {
  currentRole = role;
  document.querySelectorAll('#roleTabs .role-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  const roleInput = document.getElementById('loginRole');
  if (roleInput) {
    roleInput.value = role;
  }
}

function switchTab(tab, btn) {
  document.querySelectorAll('.login-tab').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('tab-' + tab).classList.add('active');
}

function doSocialLogin(provider) {
  Toast.show('Social login demo — redirecting...', 'info');
  setTimeout(() => window.location.href = '<?= site_url('user') ?>', 1200);
}

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
