<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $page_title ?></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cinzel:wght@400;600;700&family=Mulish:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/design-system.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/nav.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>
<body>

<nav id="top-nav">
  <a class="nav-brand" href="<?= site_url('/') ?>">
    <div class="nav-logo">ॐ</div>
    <div>
      <div class="nav-brand-name">Samriddhi-Ventures</div>
      <div class="nav-brand-sub">Sacred ERP Platform</div>
    </div>
  </a>
  <ul class="nav-links">
    <li><a href="<?= site_url('/') ?>">Home</a></li>
    <li><a href="<?= site_url('tools/kundali-generator') ?>">Kundli</a></li>
    <li><a href="<?= site_url('tools/daily-horoscope') ?>">Horoscope</a></li>
    <li><a href="<?= site_url('astrologers') ?>">Astrologers</a></li>
    <li><a href="<?= site_url('tools/panchang') ?>">Panchang</a></li>
    <li><a href="<?= site_url('tools/kundali-matching') ?>">Kundli Milan</a></li>
    <li><a href="<?= site_url('plans') ?>">Plans</a></li>
    <li><a href="<?= site_url('tools/shop') ?>">Shop</a></li>
    <li><a href="<?= site_url('about') ?>">About</a></li>
  </ul>
  <div class="nav-ctas">
    <button class="theme-toggle" data-action="toggle-theme"><span class="theme-icon">🌙</span></button>
    <?php if ($this->session->userdata('logged_in')): ?>
      <?php 
        $role_id = intval($this->session->userdata('role_id'));
        $dashboard_url = site_url('user');
        if ($role_id === 1) {
            $dashboard_url = site_url('admin');
        } elseif ($role_id === 2) {
            $dashboard_url = site_url('astrologer');
        }
      ?>
      <a href="<?= $dashboard_url ?>" class="btn-nav-solid">👤 Profile</a>
    <?php else: ?>
      <a href="<?= site_url('auth/login') ?>" class="btn-nav-outline">Login</a>
      <a href="<?= site_url('auth/register') ?>" class="btn-nav-solid active">Register Free</a>
    <?php endif; ?>
  </div>
  <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
</nav>

<!-- MOBILE MENU -->
<div class="mob-menu" id="mobMenu">
  <a class="mob-link" href="<?= site_url('/') ?>">🏠 Home</a>
  <a class="mob-link" href="<?= site_url('tools/kundali-generator') ?>">🔭 Kundli Generator</a>
  <a class="mob-link" href="<?= site_url('tools/daily-horoscope') ?>">⭐ Daily Horoscope</a>
  <a class="mob-link" href="<?= site_url('astrologers') ?>">🧘 Astrologers</a>
  <a class="mob-link" href="<?= site_url('tools/panchang') ?>">📅 Panchang</a>
  <a class="mob-link" href="<?= site_url('tools/kundali-matching') ?>">💑 Kundli Milan</a>
  <a class="mob-link" href="<?= site_url('plans') ?>">💎 Plans</a>
  <a class="mob-link" href="<?= site_url('tools/shop') ?>">🛍 Shop</a>
  <a class="mob-link" href="<?= site_url('about') ?>">ℹ About</a>
  <div class="mob-ctas">
    <?php if ($this->session->userdata('logged_in')): ?>
      <?php 
        $role_id = intval($this->session->userdata('role_id'));
        $dashboard_url = site_url('user');
        if ($role_id === 1) {
            $dashboard_url = site_url('admin');
        } elseif ($role_id === 2) {
            $dashboard_url = site_url('astrologer');
        }
      ?>
      <a href="<?= $dashboard_url ?>" class="btn-nav-solid" style="flex:1;text-align:center;padding:10px">👤 Profile</a>
    <?php else: ?>
      <a href="<?= site_url('auth/login') ?>" class="btn-nav-outline" style="flex:1;text-align:center;padding:10px">Login</a>
      <a href="<?= site_url('auth/register') ?>" class="btn-nav-solid" style="flex:1;text-align:center;padding:10px">Register</a>
    <?php endif; ?>
  </div>
</div>

<div class="auth-page">
<div class="auth-split">
  <div class="auth-left">
    <div class="auth-left-content">
      <div style="font-size:48px;margin-bottom:16px">ॐ</div>
      <h2>Join <span>Samriddhi-Ventures</span></h2>
      <p style="margin-bottom:22px">Start your sacred cosmic journey with India's most trusted Vedic astrology platform.</p>
      <div class="auth-feature">Free Kundali generation immediately</div>
      <div class="auth-feature">Access to 1,200+ verified astrologers</div>
      <div class="auth-feature">Daily horoscope & Panchang updates</div>
      <div class="auth-feature">₹100 welcome bonus in wallet</div>
      <div class="auth-feature">Join 2.5 million seekers</div>
      <div style="margin-top:28px;padding:16px;background:rgba(200,147,26,0.08);border:1px solid rgba(200,147,26,0.2);border-radius:12px;font-size:12px;color:rgba(255,255,255,0.5)">
        🔒 Your data is secured with 256-bit SSL encryption
      </div>
    </div>
  </div>

  <div class="auth-right">
    <div class="auth-card">
      <div class="auth-logo">
        <span class="om">ॐ</span>
        <h3>Create Account</h3>
      </div>

      <div class="role-tabs" id="regRoleTabs">
        <button type="button" class="role-tab active" onclick="setRegRole('user',this)">👤 User</button>
        <button type="button" class="role-tab" onclick="setRegRole('astrologer',this)">🧘 Astrologer</button>
      </div>

      <!-- Step Indicator -->
      <div style="display:flex;align-items:center;gap:6px;margin-bottom:20px">
        <div style="width:28px;height:28px;border-radius:50%;background:var(--saffron);color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800" id="step1dot">1</div>
        <div style="flex:1;height:2px;background:var(--border-strong)" id="stepLine1"></div>
        <div style="width:28px;height:28px;border-radius:50%;background:var(--border-strong);color:var(--text-muted);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800" id="step2dot">2</div>
        <div style="flex:1;height:2px;background:var(--border-strong)" id="stepLine2"></div>
        <div style="width:28px;height:28px;border-radius:50%;background:var(--border-strong);color:var(--text-muted);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800" id="step3dot">3</div>
      </div>

      <form id="regForm" method="POST" action="<?= site_url('auth/do-register') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="role" id="regRole" value="user">
        <input type="hidden" name="language" id="regLanguage" value="English">

        <!-- Step 1 -->
        <div id="regStep1">
          <div class="auth-title" style="font-size:17px">Personal Details</div>
          <div class="auth-sub">Tell us about yourself</div>
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label">Full Name <span class="req">*</span></label>
            <div class="input-wrap"><span class="input-icon">👤</span><input class="form-input" type="text" name="name" id="regName" placeholder="Arjun Kumar Mehta" required></div>
          </div>
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label">Email <span class="req">*</span></label>
            <div class="input-wrap"><span class="input-icon">📧</span><input class="form-input" type="email" name="email" id="regEmail" placeholder="arjun@example.com" required></div>
          </div>
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label">Mobile <span class="req">*</span></label>
            <div class="input-wrap"><span class="input-icon">📱</span><input class="form-input" type="tel" name="mobile" id="regPhone" placeholder="+91 98765 43210" required></div>
          </div>
          <div class="form-group" style="margin-bottom:16px">
            <label class="form-label">Password <span class="req">*</span></label>
            <div class="input-wrap"><span class="input-icon">🔒</span><input class="form-input" type="password" name="password" id="regPass" placeholder="Min 8 characters" required></div>
          </div>
          <button type="button" class="btn btn-primary w-100" onclick="nextStep(2)">Continue →</button>
        </div>

        <!-- Step 2 -->
        <div id="regStep2" style="display:none">
          <div class="auth-title" style="font-size:17px">Birth Details</div>
          <div class="auth-sub">For personalized Kundali generation</div>
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label">Date of Birth</label>
            <div class="input-wrap"><span class="input-icon">📅</span><input class="form-input" type="date" name="dob"></div>
          </div>
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label">Time of Birth</label>
            <div class="input-wrap"><span class="input-icon">🕐</span><input class="form-input" type="time" name="birth_time"></div>
          </div>
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label">City of Birth</label>
            <div class="input-wrap"><span class="input-icon">📍</span><input class="form-input" type="text" name="birth_place" placeholder="Varanasi, Mumbai..."></div>
          </div>
          <div class="form-group" style="margin-bottom:16px">
            <label class="form-label">Your Rashi (Zodiac)</label>
            <select class="form-select" name="rashi">
              <option value="">Select Rashi</option>
              <option value="Mesh">Mesh (Aries)</option><option value="Vrishab">Vrishab (Taurus)</option><option value="Mithun">Mithun (Gemini)</option>
              <option value="Kark">Kark (Cancer)</option><option value="Simha">Simha (Leo)</option><option value="Kanya">Kanya (Virgo)</option>
              <option value="Tula">Tula (Libra)</option><option value="Vrishchik">Vrishchik (Scorpio)</option><option value="Dhanu">Dhanu (Sagittarius)</option>
              <option value="Makar">Makar (Capricorn)</option><option value="Kumbh">Kumbh (Aquarius)</option><option value="Meen">Meen (Pisces)</option>
            </select>
          </div>
          <div style="display:flex;gap:10px">
            <button type="button" class="btn btn-secondary" style="flex:1" onclick="nextStep(1)">← Back</button>
            <button type="button" class="btn btn-primary" style="flex:2" onclick="nextStep(3)">Continue →</button>
          </div>
        </div>

        <!-- Step 3 -->
        <div id="regStep3" style="display:none">
          <div class="auth-title" style="font-size:17px">Almost Done!</div>
          <div class="auth-sub">Final preferences</div>
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label">Referral Code (optional)</label>
            <div class="input-wrap"><span class="input-icon">🎁</span><input class="form-input" type="text" name="referral_code" placeholder="Enter referral code"></div>
          </div>
          <div style="padding:14px;background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;margin-bottom:14px">
            <div style="font-size:11px;font-weight:700;color:var(--navy);margin-bottom:8px">Select Preferred Language</div>
            <div style="display:flex;gap:7px;flex-wrap:wrap">
              <button type="button" class="filter-chip active" style="font-size:11px;padding:5px 10px" onclick="setLang('English')">English</button>
              <button type="button" class="filter-chip" style="font-size:11px;padding:5px 10px" onclick="setLang('Hindi')">हिंदी</button>
              <button type="button" class="filter-chip" style="font-size:11px;padding:5px 10px" onclick="setLang('Tamil')">தமிழ்</button>
              <button type="button" class="filter-chip" style="font-size:11px;padding:5px 10px" onclick="setLang('Telugu')">తెలుగు</button>
            </div>
          </div>
          <div style="display:flex;align-items:flex-start;gap:8px;margin-bottom:16px">
            <input type="checkbox" name="terms" id="termsCheck" value="1" style="margin-top:2px">
            <label for="termsCheck" style="font-size:11px;color:var(--text-muted);line-height:1.5">I agree to the <a href="<?= site_url('terms') ?>" style="color:var(--saffron)">Terms of Service</a> and <a href="<?= site_url('privacy-policy') ?>" style="color:var(--saffron)">Privacy Policy</a></label>
          </div>
          <div style="display:flex;gap:10px">
            <button type="button" class="btn btn-secondary" style="flex:1" onclick="nextStep(2)">← Back</button>
            <button type="button" class="btn btn-primary" style="flex:2" onclick="doRegister()">Create Account ✦</button>
          </div>
        </div>
      </form>

      <div class="auth-footer">Already have an account? <a href="<?= site_url('auth/login') ?>">Sign In</a></div>
    </div>
  </div>
</div>
</div>

<div id="toast-container"></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<script src="<?= base_url('assets/js/store.js') ?>"></script>
<script src="<?= base_url('assets/js/core.js') ?>"></script>
<script>
let regRole = 'user';

function setRegRole(role, btn) {
  regRole = role;
  document.querySelectorAll('#regRoleTabs .role-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('regRole').value = role;
}

function setLang(lang) {
  document.getElementById('regLanguage').value = lang;
}

function showNotification(msg, type) {
  if (typeof toastr !== 'undefined') {
    toastr[type](msg);
  } else if (typeof Toast !== 'undefined' && typeof Toast.show === 'function') {
    Toast.show(msg, type);
  } else {
    alert(msg);
  }
}

function nextStep(n) {
  // Validate step 1 fields when moving to step 2
  if (n === 2) {
    const $form = $('#regForm');
    let step1Valid = true;
    
    // Simple custom validation checks for step 1
    if (!$('#regName').val() || !$('#regEmail').val() || !$('#regPhone').val() || !$('#regPass').val()) {
      showNotification('Please fill all required fields in Step 1', 'error');
      return;
    }
    
    if ($('#regPass').val().length < 8) {
      showNotification('Password must be at least 8 characters long', 'error');
      return;
    }
  }
  
  [1,2,3].forEach(i => document.getElementById('regStep'+i).style.display = 'none');
  document.getElementById('regStep'+n).style.display = 'block';
  ['step1dot','step2dot','step3dot'].forEach((id,i) => {
    const el = document.getElementById(id);
    el.style.background = (i+1) <= n ? 'var(--saffron)' : 'var(--border-strong)';
    el.style.color = (i+1) <= n ? 'white' : 'var(--text-muted)';
  });
}

function doRegister() {
  if (!document.getElementById('termsCheck').checked) {
    showNotification('Please accept terms to continue', 'error');
    return;
  }
  
  const $form = $('#regForm');
  
  // Trigger jQuery Validate
  if ($.isFunction($.fn.validate) && !$form.valid()) {
    return;
  }
  
  const $btn = $('button[onclick="doRegister()"]');
  const originalText = $btn.text();
  $btn.prop('disabled', true).text('Creating Account...');
  
  $.ajax({
    url: $form.attr('action'),
    type: 'POST',
    data: $form.serialize(),
    dataType: 'json',
    success: function(res) {
      if (res.status) {
        showNotification(res.message, 'success');
        setTimeout(() => {
          window.location.href = res.redirect;
        }, 1500);
      } else {
        showNotification(res.error || 'Registration failed', 'error');
        $btn.prop('disabled', false).text(originalText);
      }
    },
    error: function(xhr) {
      let errorMsg = 'An error occurred during registration. Please try again.';
      if (xhr.responseJSON && xhr.responseJSON.error) {
        errorMsg = xhr.responseJSON.error;
      }
      showNotification(errorMsg, 'error');
      $btn.prop('disabled', false).text(originalText);
    }
  });
}

document.querySelectorAll('.filter-chip').forEach(c => {
  c.addEventListener('click', function() {
    this.closest('div').querySelectorAll('.filter-chip').forEach(x => x.classList.remove('active'));
    this.classList.add('active');
  });
});

$(document).ready(function() {
  $('#regForm').validate({
    rules: {
      name: { required: true, minlength: 2 },
      email: { required: true, email: true },
      mobile: { required: true },
      password: { required: true, minlength: 8 }
    },
    messages: {
      name: { required: "Please enter your name" },
      email: { required: "Please enter your email address", email: "Please enter a valid email address" },
      mobile: { required: "Please enter your mobile number" },
      password: { required: "Please enter a password", minlength: "Password must be at least 8 characters" }
    },
    errorPlacement: function(error, element) {
      showNotification(error.text(), 'error');
    }
  });
});

<?php if ($this->session->flashdata('error')): ?>
document.addEventListener('DOMContentLoaded', () => {
  showNotification('<?= html_escape($this->session->flashdata('error')) ?>', 'error');
});
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
document.addEventListener('DOMContentLoaded', () => {
  showNotification('<?= html_escape($this->session->flashdata('success')) ?>', 'success');
});
<?php endif; ?>
</script>
</body>
</html>
