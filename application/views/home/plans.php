<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--navy);color:white;padding:50px 0">
  <div class="container" style="max-width:960px;text-align:center">
    <div class="sec-label sec-label-dark">✦ Premium Service Plans</div>
    <h1 class="cinzel" style="color:var(--gold-bright);font-size:clamp(28px,5vw,44px);margin-bottom:12px">Choose Your Sacred Journey</h1>
    <p style="color:rgba(255,255,255,0.6);font-size:16px;max-width:600px;margin:0 auto">Unlock unlimited charts, live consultation minutes, and customized transit reports.</p>
  </div>
</section>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:1100px">
    
    <!-- Dynamic Cards Grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:24px;margin-bottom:50px">
      <?php if (!empty($plans)): ?>
        <?php foreach ($plans as $p): ?>
          <div class="card" style="border: 1px solid var(--border);border-radius:16px;overflow:hidden;display:flex;flex-direction:column;min-height:360px">
            <div style="padding:24px;background:var(--gold-pale);text-align:center;border-bottom:1px solid var(--border)">
              <h3 class="cinzel" style="color:var(--navy);margin:0;font-size:18px"><?= html_escape($p['name']) ?></h3>
              <div style="font-size:32px;font-weight:800;color:var(--saffron);margin:12px 0 4px 0">
                ₹<?= number_format($p['price'], 2) ?>
              </div>
              <span style="font-size:11px;color:var(--text-muted)">Valid for <?= intval($p['validity_days']) ?> Days</span>
            </div>
            
            <div style="padding:24px;flex-grow:1;display:flex;flex-direction:column;justify-content:between">
              <ul style="list-style:none;padding:0;margin:0 0 20px 0;font-size:13px;color:var(--text-mid);display:flex;flex-direction:column;gap:12px">
                <li>✨ <?= intval($p['free_kundali_count']) ?> Janam Kundali Reports</li>
                <li>💬 <?= intval($p['free_chat_minutes']) ?> Minutes Free Consultations</li>
                <li>⭐ Personalized daily/weekly guidance</li>
                <li>🎁 18% GST invoice receipt included</li>
              </ul>
              
              <a href="<?= site_url('auth/register') ?>" class="btn btn-primary w-100" style="text-align:center;margin-top:auto">Get Started ✦</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="text-align:center;grid-column:1/-1;color:var(--text-muted)">No plans available.</div>
      <?php endif; ?>
    </div>

    <!-- Trust Seals Matrix -->
    <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:12px;padding:30px;text-align:center;">
      <h3 class="cinzel" style="color:var(--navy);margin-bottom:20px;font-size:18px">🛡 Why Millions Trust AstroVeda ERP</h3>
      <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px" class="grid-2">
        <div>
          <div style="font-size:28px;margin-bottom:8px">🔒</div>
          <strong style="font-size:13px;color:var(--navy)">256-Bit SSL Security</strong>
          <p style="font-size:11px;color:var(--text-muted);margin-top:4px">All payment gateways and transactions are completely secure and PCI-DSS compliant.</p>
        </div>
        <div>
          <div style="font-size:28px;margin-bottom:8px">🤝</div>
          <strong style="font-size:13px;color:var(--navy)">100% Satisfaction Guarantee</strong>
          <p style="font-size:11px;color:var(--text-muted);margin-top:4px">Not satisfied with your session? Contact support for immediate ticket resolution.</p>
        </div>
        <div>
          <div style="font-size:28px;margin-bottom:8px">📜</div>
          <strong style="font-size:13px;color:var(--navy)">Verified Vedic Scholars</strong>
          <p style="font-size:11px;color:var(--text-muted);margin-top:4px">Our counselors hold certificates from recognized astronomical and Sanskrit universities.</p>
        </div>
      </div>
    </div>

  </div>
</section>
