<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($page_title) ? $page_title . ' — Samriddhi-Ventures' : 'Samriddhi-Ventures — Sacred Vedic Astrology Platform' ?></title>
<meta name="description" content="<?= isset($meta_desc) ? $meta_desc : 'India\'s most trusted Vedic astrology platform.' ?>">
<script>
  window.SV_BASE_URL = "<?= base_url() ?>";
  window.SV_SITE_URL = "<?= site_url() ?>";
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cinzel:wght@400;600;700&family=Mulish:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Flatpickr DateTimePicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- SumoSelect -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.3/sumoselect.min.css">
<!-- App CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/design-system.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/nav.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/landing.css') ?>">
<?php if (isset($extra_css)) echo $extra_css; ?>
</head>
<body>
<?php //echo base_url();die; ?>
<nav id="top-nav">
  <a class="nav-brand" href="<?= site_url('/') ?>">
    <div class="nav-logo">ॐ</div>
    <div>
      <div class="nav-brand-name">Samriddhi-Ventures</div>
      <div class="nav-brand-sub">Sacred ERP Platform</div>
    </div>
  </a>
  <ul class="nav-links">
    <li><a href="<?= site_url('/') ?>" class="<?= ($active_nav??'')==='home'?'active':'' ?>">Home</a></li>
    <li><a href="<?= site_url('tools/kundali-generator') ?>" class="<?= ($active_nav??'')==='kundli'?'active':'' ?>">Kundli</a></li>
    <li><a href="<?= site_url('tools/daily-horoscope') ?>" class="<?= ($active_nav??'')==='horoscope'?'active':'' ?>">Horoscope</a></li>
    <li><a href="<?= site_url('astrologers') ?>" class="<?= ($active_nav??'')==='astrologers'?'active':'' ?>">Astrologers</a></li>
    <li><a href="<?= site_url('tools/panchang') ?>" class="<?= ($active_nav??'')==='panchang'?'active':'' ?>">Panchang</a></li>
    <li><a href="<?= site_url('tools/kundali-matching') ?>" class="<?= ($active_nav??'')==='match'?'active':'' ?>">Kundli Milan</a></li>
    <li><a href="<?= site_url('plans') ?>" class="<?= ($active_nav??'')==='plans'?'active':'' ?>">Plans</a></li>
    <li><a href="<?= site_url('tools/shop') ?>" class="<?= ($active_nav??'')==='shop'?'active':'' ?>">Shop</a></li>
    <li><a href="<?= site_url('about') ?>" class="<?= ($active_nav??'')==='about'?'active':'' ?>">About</a></li>
  </ul>
  <div class="nav-ctas">
    <button class="theme-toggle" data-action="toggle-theme"><span class="theme-icon">🌙</span></button>
    <a href="<?= site_url('auth/login') ?>" class="btn-nav-outline">Login</a>
    <a href="<?= site_url('auth/register') ?>" class="btn-nav-solid">Register Free</a>
  </div>
  <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
</nav>

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
    <a href="<?= site_url('auth/login') ?>" class="btn-nav-outline" style="flex:1;text-align:center;padding:10px">Login</a>
    <a href="<?= site_url('auth/register') ?>" class="btn-nav-solid" style="flex:1;text-align:center;padding:10px">Register</a>
  </div>
</div>

<main class="page-pt">
