<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model(['subscription_plan_model', 'user_subscription_model', 'wallet_model']);
$plans = $CI->subscription_plan_model->get_where(['status' => 1]);
$active_sub = $CI->user_subscription_model->get_where(['user_id' => $current_user['id'], 'status' => 1]);
$wallet = $CI->wallet_model->get_where(['user_id' => $current_user['id']]);
$balance = !empty($wallet) ? $wallet[0]['balance'] : 0.00;
?>

<div class="page-header">
  <div>
    <div class="page-header-title">💎 Subscription Plans</div>
    <div class="page-header-sub">Subscribe to get premium daily horoscope readings and consultant discounts</div>
  </div>
  <div class="page-header-actions">
    <div style="background:var(--navy);color:white;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:700">
      Wallet Balance: <span style="color:var(--gold-bright)">₹<?= number_format($balance, 2) ?></span>
    </div>
  </div>
</div>

<!-- Active Subscription Info -->
<div class="card" style="margin-bottom:24px;border-left:4px solid var(--gold)">
  <div class="card-body">
    <div class="card-title" style="margin-bottom:8px">Your Current Subscription</div>
    <?php if (!empty($active_sub)): ?>
      <?php 
        $current_plan = $CI->subscription_plan_model->get_by_id($active_sub[0]['plan_id']); 
      ?>
      <div style="display:flex;justify-content:between;align-items:center;flex-wrap:wrap;gap:12px">
        <div>
          <h3 class="cinzel" style="color:var(--navy);margin:0"><?= html_escape($current_plan['name']) ?></h3>
          <p style="color:var(--text-muted);font-size:12px;margin:4px 0 0 0">
            Enrolled on: <?= date('d M Y', strtotime($active_sub[0]['start_date'])) ?> · Valid till: <strong style="color:var(--navy)"><?= date('d M Y', strtotime($active_sub[0]['end_date'])) ?></strong>
          </p>
        </div>
        <div style="margin-left:auto"><span class="badge badge-success">● Active</span></div>
      </div>
    <?php else: ?>
      <div style="display:flex;justify-content:between;align-items:center;flex-wrap:wrap;gap:12px">
        <div>
          <h3 class="cinzel" style="color:var(--text-muted);margin:0">No Active Subscription</h3>
          <p style="color:var(--text-muted);font-size:12px;margin:4px 0 0 0">Subscribe to any premium package below using your wallet balance.</p>
        </div>
        <div style="margin-left:auto"><span class="badge badge-warning">⚫ Free Tier</span></div>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Plan Catalog Grid -->
<div class="cinzel" style="font-size:18px;color:var(--navy);margin-bottom:14px" data-theme-text>Premium Packages</div>
<div class="grid-3" style="gap:20px">
  <?php if (!empty($plans)): ?>
    <?php foreach ($plans as $p): ?>
      <?php 
        $is_subscribed = !empty($active_sub) && $active_sub[0]['plan_id'] == $p['id'];
        $feats = json_decode($p['features'], true);
      ?>
      <div class="card" style="position:relative; <?= $is_subscribed ? 'border:2px solid var(--gold);box-shadow:0 10px 25px rgba(200,147,26,0.15)' : '' ?>">
        <?php if ($is_subscribed): ?>
          <span style="position:absolute;top:-10px;right:15px;background:var(--gold);color:white;font-size:9px;font-weight:800;padding:3px 8px;border-radius:10px;text-transform:uppercase;letter-spacing:1px">Current Plan</span>
        <?php endif; ?>
        
        <div class="card-body" style="display:flex;flex-direction:column;height:100%;min-height:320px">
          <div class="cinzel" style="font-size:18px;color:var(--navy);font-weight:700"><?= html_escape($p['name']) ?></div>
          <div style="font-size:32px;font-weight:800;color:var(--saffron);margin:14px 0 6px 0">
            ₹<?= number_format($p['price'], 2) ?>
            <span style="font-size:12px;color:var(--text-muted);font-weight:400">/ <?= intval($p['duration']) ?> Days</span>
          </div>

          <div style="margin-top:12px;margin-bottom:24px;flex-grow:1">
            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px">Included Features</div>
            <ul style="padding-left:16px;margin:0;font-size:12px;line-height:1.8;color:var(--text-mid)">
              <?php if (is_array($feats)): ?>
                <?php foreach ($feats as $f): ?>
                  <li><?= html_escape($f) ?></li>
                <?php endforeach; ?>
              <?php else: ?>
                <li><?= html_escape($p['features']) ?></li>
              <?php endif; ?>
            </ul>
          </div>

          <?php if ($is_subscribed): ?>
            <button class="btn btn-secondary w-100" disabled>Active Plan</button>
          <?php else: ?>
            <form method="POST" action="<?= site_url('user/purchase-plan') ?>">
              <?= csrf_field() ?>
              <input type="hidden" name="plan_id" value="<?= $p['id'] ?>">
              <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Subscribe to <?= html_escape($p['name']) ?> for ₹<?= number_format($p['price'], 2) ?>?')">
                Subscribe Now
              </button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="card" style="grid-column: span 3"><div class="card-body" style="text-align:center;color:var(--text-muted)">No plans available.</div></div>
  <?php endif; ?>
</div>
