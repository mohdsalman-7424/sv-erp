<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($astrologer) ? $astrologer['id'] : 0;

// Fetch service plans published by this astrologer
$plans = [];
if ($astro_id) {
    $plans = $CI->db->get_where('astrologer_plans', ['astrologer_id' => $astro_id, 'status' => 1])->result_array();
}
?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:900px">
    
    <!-- Breadcrumb -->
    <div style="font-size:12px;color:var(--text-muted);margin-bottom:20px">
      <a href="<?= site_url('/') ?>" style="color:var(--text-muted)">Home</a> &nbsp;»&nbsp; 
      <a href="<?= site_url('astrologers') ?>" style="color:var(--text-muted)">Astrologers</a> &nbsp;»&nbsp; 
      <span>Profile Details</span>
    </div>

    <?php if (!empty($astrologer)): ?>
      <div style="display:grid;grid-template-columns: 1fr 2fr;gap:30px;align-items:start" class="grid-2">
        
        <!-- Left details card -->
        <div style="display:flex;flex-direction:column;gap:20px">
          <div class="card" style="border:1px solid var(--border);text-align:center">
            <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));color:white;padding:30px 20px;">
              <div style="width:72px;height:72px;border-radius:50%;background:rgba(200,147,26,0.15);border:2px solid var(--gold);color:white;font-size:32px;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
                <?= strtoupper(substr($astrologer['name'], 0, 1)) ?>
              </div>
              <h2 class="cinzel" style="color:var(--gold-bright);font-size:18px;margin:0"><?= html_escape($astrologer['name']) ?></h2>
              <span style="font-size:11px;color:rgba(255,255,255,0.6)"><?= html_escape($astrologer['expertise']) ?></span>
            </div>
            <div class="card-body" style="padding:18px">
              <div style="display:flex;flex-direction:column;gap:10px;font-size:12px;color:var(--text-mid);text-align:left">
                <div><strong>Experience:</strong> <?= intval($astrologer['experience_years']) ?> Years</div>
                <div><strong>Languages:</strong> <?= html_escape($astrologer['languages']) ?></div>
                <div><strong>Consultation Fee:</strong> <span style="color:var(--saffron);font-weight:700">₹<?= number_format($astrologer['per_minute_charge'], 2) ?>/min</span></div>
              </div>
              <a href="<?= site_url('auth/login') ?>" class="btn btn-primary w-100" style="margin-top:14px;font-size:12px">Schedule Call / Chat</a>
            </div>
          </div>
        </div>

        <!-- Right bio / plans -->
        <div style="display:flex;flex-direction:column;gap:20px">
          <!-- Bio -->
          <div class="card" style="border:1px solid var(--border)">
            <div class="card-body">
              <h3 class="cinzel" style="color:var(--navy);font-size:16px;margin-bottom:12px;border-bottom:1px solid var(--border);padding-bottom:6px">About Astrologer</h3>
              <p style="font-size:13px;color:var(--text-mid);line-height:1.7">
                <?= nl2br(html_escape($astrologer['bio'])) ?: 'Verified Vedic Scholar with years of experience helping seekers resolve career path nodes, compatibility queries, and health obstacles.' ?>
              </p>
            </div>
          </div>

          <!-- Service plans -->
          <div class="card" style="border:1px solid var(--border)">
            <div class="card-body">
              <h3 class="cinzel" style="color:var(--navy);font-size:16px;margin-bottom:14px;border-bottom:1px solid var(--border);padding-bottom:6px">Custom Service Reports</h3>
              
              <?php if (!empty($plans)): ?>
                <div style="display:flex;flex-direction:column;gap:12px">
                  <?php foreach ($plans as $plan): ?>
                    <div style="border:1px solid var(--border);border-radius:8px;padding:12px 14px;background:var(--gold-pale);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px">
                      <div>
                        <strong style="color:var(--navy);font-size:13px;display:block"><?= html_escape($plan['title']) ?></strong>
                        <span style="font-size:11px;color:var(--text-muted)"><?= html_escape($plan['description']) ?> · Delivery: <?= html_escape($plan['delivery_time']) ?></span>
                      </div>
                      <div style="text-align:right">
                        <strong style="color:var(--saffron);font-size:14px;display:block;margin-bottom:4px">₹<?= number_format($plan['price'], 2) ?></strong>
                        <a href="<?= site_url('auth/login') ?>" class="btn btn-primary btn-sm" style="font-size:10px;padding:4px 10px">Purchase</a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <p style="font-size:12px;color:var(--text-muted);text-align:center;padding:10px 0;">No active service reports or plans cataloged right now.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    <?php else: ?>
      <div style="text-align:center;color:var(--text-muted)">Astrologer profile not found.</div>
    <?php endif; ?>

  </div>
</section>
