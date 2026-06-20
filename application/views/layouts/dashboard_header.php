<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($page_title) ? $page_title . ' — Samriddhi-Ventures' : 'Dashboard — Samriddhi-Ventures' ?></title>
<meta name="description" content="<?= isset($meta_desc) ? $meta_desc : 'Samriddhi-Ventures Dashboard' ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cinzel:wght@400;600;700&family=Mulish:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- SumoSelect -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.3/sumoselect.min.css">
<!-- App CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/design-system.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/nav.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
<?php if (isset($extra_css)) echo $extra_css; ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>

<!-- TOP NAV -->
<nav id="top-nav">
  <a class="nav-brand" href="<?= site_url('/') ?>">
    <div class="nav-logo">ॐ</div>
    <div>
      <div class="nav-brand-name">Samriddhi-Ventures</div>
      <div class="nav-brand-sub"><?= isset($dashboard_role) ? ucfirst($dashboard_role).' Dashboard' : 'ERP Platform' ?></div>
    </div>
  </a>

  <div style="display:flex;align-items:center;gap:12px;margin-left:auto">
    <!-- Search -->
    <div style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(200,147,26,0.2);border-radius:8px;padding:7px 13px;min-width:200px" class="nav-search-wrap">
      <span style="color:rgba(255,255,255,0.35);font-size:13px">🔍</span>
      <input type="text" placeholder="Search..." style="background:transparent;border:none;outline:none;font-size:12px;color:rgba(255,255,255,0.8);font-family:'Mulish',sans-serif;width:100%" id="dashSearchInput">
    </div>

    <!-- Notifications -->
    <div style="position:relative">
      <button onclick="window.location.href='<?= site_url(isset($dashboard_role)?$dashboard_role.'/notifications':'user/notifications') ?>'" style="width:36px;height:36px;border-radius:50%;border:1px solid rgba(200,147,26,0.3);background:transparent;color:rgba(255,255,255,0.7);font-size:16px;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center">🔔</button>
      <span style="position:absolute;top:-2px;right:-2px;width:16px;height:16px;background:var(--saffron);border-radius:50%;font-size:9px;font-weight:800;color:white;display:flex;align-items:center;justify-content:center">3</span>
    </div>

    <!-- Theme Toggle -->
    <button class="theme-toggle" data-action="toggle-theme" aria-label="Toggle theme">
      <span class="theme-icon">🌙</span>
    </button>

    <!-- User Avatar -->
    <div style="display:flex;align-items:center;gap:8px;cursor:pointer" onclick="window.location.href='<?= site_url(isset($dashboard_role)?$dashboard_role.'/profile':'user/profile') ?>'">
      <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:14px;font-weight:700;color:white;box-shadow:0 0 0 2px rgba(200,147,26,0.4)"><?= isset($user_initial) ? $user_initial : 'U' ?></div>
      <div class="nav-links" style="display:flex">
        <span style="font-size:12px;color:rgba(255,255,255,0.8);font-weight:600"><?= isset($user_name) ? $user_name : 'User' ?></span>
      </div>
    </div>

    <!-- Logout -->
    <a href="<?= site_url('auth/logout') ?>" style="color:rgba(255,255,255,0.45);font-size:11px;text-decoration:none;border:1px solid rgba(255,255,255,0.1);padding:6px 10px;border-radius:6px;transition:all .2s" onmouseover="this.style.borderColor='rgba(239,68,68,0.4)';this.style.color='#EF4444'" onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='rgba(255,255,255,0.45)'">Logout</a>
  </div>

  <button class="hamburger" id="hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="dash-page">
  <div class="dash-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar" id="mainSidebar">
      <div class="sidebar-profile">
        <div class="sidebar-avatar"><?= isset($user_initial) ? $user_initial : 'U' ?></div>
        <div>
          <div class="sidebar-profile-name"><?= isset($user_name) ? $user_name : 'User' ?></div>
          <div class="sidebar-profile-role"><?= isset($dashboard_role) ? ucfirst($dashboard_role) : 'User' ?></div>
        </div>
      </div>

      <?php $role = isset($dashboard_role) ? $dashboard_role : 'user'; ?>

      <?php if ($role === 'user'): ?>
      <div class="sidebar-sec">Overview</div>
      <a href="<?= site_url('user') ?>" class="sidebar-item <?= ($active_sidebar=='dashboard')?'active':'' ?>"><span class="sidebar-icon">🏠</span><span class="sidebar-label">Dashboard</span></a>
      <div class="sidebar-sec">Services</div>
      <a href="<?= site_url('user/subscriptions') ?>" class="sidebar-item <?= ($active_sidebar=='subscriptions')?'active':'' ?>"><span class="sidebar-icon">💎</span><span class="sidebar-label">Subscriptions</span></a>
      <a href="<?= site_url('user/kundali-reports') ?>" class="sidebar-item <?= ($active_sidebar=='kundali')?'active':'' ?>"><span class="sidebar-icon">🔭</span><span class="sidebar-label">Kundali Reports</span></a>
      <a href="<?= site_url('user/kundali-matching') ?>" class="sidebar-item <?= ($active_sidebar=='matching')?'active':'' ?>"><span class="sidebar-icon">💑</span><span class="sidebar-label">Kundali Matching</span></a>
      <a href="<?= site_url('user/horoscope-reports') ?>" class="sidebar-item <?= ($active_sidebar=='horoscope')?'active':'' ?>"><span class="sidebar-icon">⭐</span><span class="sidebar-label">Horoscope Reports</span></a>
      <a href="<?= site_url('user/consultations') ?>" class="sidebar-item <?= ($active_sidebar=='consultations')?'active':'' ?>"><span class="sidebar-icon">💬</span><span class="sidebar-label">Consultations</span></a>
      <div class="sidebar-sec">Finance</div>
      <a href="<?= site_url('user/wallet') ?>" class="sidebar-item <?= ($active_sidebar=='wallet')?'active':'' ?>"><span class="sidebar-icon">👛</span><span class="sidebar-label">Wallet</span></a>
      <a href="<?= site_url('user/invoices') ?>" class="sidebar-item <?= ($active_sidebar=='invoices')?'active':'' ?>"><span class="sidebar-icon">🧾</span><span class="sidebar-label">Invoices</span></a>
      <a href="<?= site_url('user/transactions') ?>" class="sidebar-item <?= ($active_sidebar=='transactions')?'active':'' ?>"><span class="sidebar-icon">💳</span><span class="sidebar-label">Transactions</span></a>
      <div class="sidebar-sec">Account</div>
      <a href="<?= site_url('user/profile') ?>" class="sidebar-item <?= ($active_sidebar=='profile')?'active':'' ?>"><span class="sidebar-icon">👤</span><span class="sidebar-label">My Profile</span></a>
      <a href="<?= site_url('user/referrals') ?>" class="sidebar-item <?= ($active_sidebar=='referrals')?'active':'' ?>"><span class="sidebar-icon">🎁</span><span class="sidebar-label">Referrals</span></a>
      <a href="<?= site_url('user/notifications') ?>" class="sidebar-item <?= ($active_sidebar=='notifications')?'active':'' ?>"><span class="sidebar-icon">🔔</span><span class="sidebar-label">Notifications</span><span class="sidebar-badge">3</span></a>
      <a href="<?= site_url('user/support') ?>" class="sidebar-item <?= ($active_sidebar=='support')?'active':'' ?>"><span class="sidebar-icon">🎧</span><span class="sidebar-label">Support</span></a>

      <?php elseif ($role === 'astrologer'): ?>
      <div class="sidebar-sec">Overview</div>
      <a href="<?= site_url('astrologer') ?>" class="sidebar-item <?= ($active_sidebar=='dashboard')?'active':'' ?>"><span class="sidebar-icon">🏠</span><span class="sidebar-label">Dashboard</span></a>
      <div class="sidebar-sec">Business</div>
      <a href="<?= site_url('astrologer/service-plans') ?>" class="sidebar-item <?= ($active_sidebar=='plans')?'active':'' ?>"><span class="sidebar-icon">📋</span><span class="sidebar-label">Service Plans</span></a>
      <a href="<?= site_url('astrologer/customers') ?>" class="sidebar-item <?= ($active_sidebar=='customers')?'active':'' ?>"><span class="sidebar-icon">👥</span><span class="sidebar-label">Customers</span></a>
      <a href="<?= site_url('astrologer/orders') ?>" class="sidebar-item <?= ($active_sidebar=='orders')?'active':'' ?>"><span class="sidebar-icon">📦</span><span class="sidebar-label">Orders</span></a>
      <a href="<?= site_url('astrologer/predictions') ?>" class="sidebar-item <?= ($active_sidebar=='predictions')?'active':'' ?>"><span class="sidebar-icon">🔮</span><span class="sidebar-label">Predictions</span></a>
      <a href="<?= site_url('astrologer/kundali-engine') ?>" class="sidebar-item <?= ($active_sidebar=='kundali')?'active':'' ?>"><span class="sidebar-icon">🔭</span><span class="sidebar-label">Kundali Engine</span></a>
      <div class="sidebar-sec">Finance</div>
      <a href="<?= site_url('astrologer/earnings') ?>" class="sidebar-item <?= ($active_sidebar=='earnings')?'active':'' ?>"><span class="sidebar-icon">💰</span><span class="sidebar-label">Earnings</span></a>
      <a href="<?= site_url('astrologer/withdrawals') ?>" class="sidebar-item <?= ($active_sidebar=='withdrawals')?'active':'' ?>"><span class="sidebar-icon">🏦</span><span class="sidebar-label">Withdrawals</span></a>
      <div class="sidebar-sec">Consultations</div>
      <a href="<?= site_url('astrologer/calendar') ?>" class="sidebar-item <?= ($active_sidebar=='calendar')?'active':'' ?>"><span class="sidebar-icon">📅</span><span class="sidebar-label">Calendar</span></a>
      <a href="<?= site_url('astrologer/live-chat') ?>" class="sidebar-item <?= ($active_sidebar=='chat')?'active':'' ?>"><span class="sidebar-icon">💬</span><span class="sidebar-label">Live Chat</span><span class="sidebar-badge">2</span></a>
      <a href="<?= site_url('astrologer/video-consultations') ?>" class="sidebar-item <?= ($active_sidebar=='video')?'active':'' ?>"><span class="sidebar-icon">🎥</span><span class="sidebar-label">Video Calls</span></a>
      <div class="sidebar-sec">Account</div>
      <a href="<?= site_url('astrologer/profile') ?>" class="sidebar-item <?= ($active_sidebar=='profile')?'active':'' ?>"><span class="sidebar-icon">👤</span><span class="sidebar-label">My Profile</span></a>
      <a href="<?= site_url('astrologer/notifications') ?>" class="sidebar-item <?= ($active_sidebar=='notifications')?'active':'' ?>"><span class="sidebar-icon">🔔</span><span class="sidebar-label">Notifications</span></a>
      <a href="<?= site_url('astrologer/support') ?>" class="sidebar-item <?= ($active_sidebar=='support')?'active':'' ?>"><span class="sidebar-icon">🎧</span><span class="sidebar-label">Support</span></a>

      <?php elseif ($role === 'admin'): ?>
      <div class="sidebar-sec">Overview</div>
      <a href="<?= site_url('admin') ?>" class="sidebar-item <?= ($active_sidebar=='dashboard')?'active':'' ?>"><span class="sidebar-icon">🏠</span><span class="sidebar-label">Dashboard</span></a>
      <div class="sidebar-sec">Users</div>
      <a href="<?= site_url('admin/users') ?>" class="sidebar-item <?= ($active_sidebar=='users')?'active':'' ?>"><span class="sidebar-icon">👥</span><span class="sidebar-label">All Users</span></a>
      <a href="<?= site_url('admin/astrologers') ?>" class="sidebar-item <?= ($active_sidebar=='astrologers')?'active':'' ?>"><span class="sidebar-icon">🧘</span><span class="sidebar-label">Astrologers</span></a>
      <div class="sidebar-sec">Finance</div>
      <a href="<?= site_url('admin/subscription-plans') ?>" class="sidebar-item <?= ($active_sidebar=='plans')?'active':'' ?>"><span class="sidebar-icon">💎</span><span class="sidebar-label">Subscription Plans</span></a>
      <a href="<?= site_url('admin/invoices') ?>" class="sidebar-item <?= ($active_sidebar=='invoices')?'active':'' ?>"><span class="sidebar-icon">🧾</span><span class="sidebar-label">Invoices</span></a>
      <a href="<?= site_url('admin/payments') ?>" class="sidebar-item <?= ($active_sidebar=='payments')?'active':'' ?>"><span class="sidebar-icon">💳</span><span class="sidebar-label">Payments</span></a>
      <a href="<?= site_url('admin/revenue-reports') ?>" class="sidebar-item <?= ($active_sidebar=='revenue')?'active':'' ?>"><span class="sidebar-icon">📊</span><span class="sidebar-label">Revenue Reports</span></a>
      <a href="<?= site_url('admin/wallet') ?>" class="sidebar-item <?= ($active_sidebar=='wallet')?'active':'' ?>"><span class="sidebar-icon">👛</span><span class="sidebar-label">Wallet</span></a>
      <a href="<?= site_url('admin/coupons') ?>" class="sidebar-item <?= ($active_sidebar=='coupons')?'active':'' ?>"><span class="sidebar-icon">🎟</span><span class="sidebar-label">Coupons</span></a>
      <a href="<?= site_url('admin/gst') ?>" class="sidebar-item <?= ($active_sidebar=='gst')?'active':'' ?>"><span class="sidebar-icon">🏛</span><span class="sidebar-label">GST Reports</span></a>
      <div class="sidebar-sec">CMS</div>
      <a href="<?= site_url('admin/cms-pages') ?>" class="sidebar-item <?= ($active_sidebar=='cms')?'active':'' ?>"><span class="sidebar-icon">📄</span><span class="sidebar-label">CMS Pages</span></a>
      <a href="<?= site_url('admin/blogs') ?>" class="sidebar-item <?= ($active_sidebar=='blogs')?'active':'' ?>"><span class="sidebar-icon">✍</span><span class="sidebar-label">Blogs</span></a>
      <a href="<?= site_url('admin/testimonials') ?>" class="sidebar-item <?= ($active_sidebar=='testimonials')?'active':'' ?>"><span class="sidebar-icon">⭐</span><span class="sidebar-label">Testimonials</span></a>
      <a href="<?= site_url('admin/seo') ?>" class="sidebar-item <?= ($active_sidebar=='seo')?'active':'' ?>"><span class="sidebar-icon">🔍</span><span class="sidebar-label">SEO Manager</span></a>
      <div class="sidebar-sec">Marketing</div>
      <a href="<?= site_url('admin/referrals') ?>" class="sidebar-item <?= ($active_sidebar=='referrals')?'active':'' ?>"><span class="sidebar-icon">🎁</span><span class="sidebar-label">Referrals</span></a>
      <a href="<?= site_url('admin/notifications') ?>" class="sidebar-item <?= ($active_sidebar=='notifications')?'active':'' ?>"><span class="sidebar-icon">🔔</span><span class="sidebar-label">Notifications</span></a>
      <a href="<?= site_url('admin/email-templates') ?>" class="sidebar-item <?= ($active_sidebar=='emails')?'active':'' ?>"><span class="sidebar-icon">📧</span><span class="sidebar-label">Email Templates</span></a>
      <a href="<?= site_url('admin/sms-templates') ?>" class="sidebar-item <?= ($active_sidebar=='sms')?'active':'' ?>"><span class="sidebar-icon">💬</span><span class="sidebar-label">SMS Templates</span></a>
      <a href="<?= site_url('admin/push-notifications') ?>" class="sidebar-item <?= ($active_sidebar=='push')?'active':'' ?>"><span class="sidebar-icon">📱</span><span class="sidebar-label">Push Notifications</span></a>
      <div class="sidebar-sec">System</div>
      <a href="<?= site_url('admin/support') ?>" class="sidebar-item <?= ($active_sidebar=='support')?'active':'' ?>"><span class="sidebar-icon">🎧</span><span class="sidebar-label">Support Tickets</span></a>
      <a href="<?= site_url('admin/profile') ?>" class="sidebar-item <?= ($active_sidebar=='profile')?'active':'' ?>"><span class="sidebar-icon">👤</span><span class="sidebar-label">Admin Profile</span></a>
      <a href="<?= site_url('admin/settings') ?>" class="sidebar-item <?= ($active_sidebar=='settings')?'active':'' ?>"><span class="sidebar-icon">⚙</span><span class="sidebar-label">Settings</span></a>
      <?php endif; ?>

      <!-- Bottom Logout -->
      <div style="padding:14px 18px;margin-top:auto;border-top:1px solid rgba(200,147,26,0.1)">
        <a href="<?= site_url('auth/logout') ?>" style="display:flex;align-items:center;gap:10px;color:rgba(255,100,100,0.7);font-size:13px;font-weight:500;text-decoration:none;padding:8px 0;transition:all .2s" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='rgba(255,100,100,0.7)'">
          <span>🚪</span><span>Logout</span>
        </a>
      </div>
    </aside>

    <!-- Sidebar overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <!-- Sidebar mobile toggle -->
    <button class="sidebar-toggle-btn" id="sidebarToggle">☰</button>

    <!-- MAIN CONTENT -->
    <div class="dash-main">
