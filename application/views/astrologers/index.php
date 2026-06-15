<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:1100px">
    
    <!-- Directory Header -->
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:34px;flex-wrap:wrap;gap:16px">
      <div>
        <div class="sec-label">✦ Verified Panel</div>
        <h1 class="cinzel" style="color:var(--navy);font-size:clamp(24px,4vw,34px);margin:0">Consult Our Expert Astrologers</h1>
        <p style="color:var(--text-muted);font-size:12px;margin-top:4px">Talk/Chat instantly with verified counselors and Vedic scholars</p>
      </div>
      
      <!-- Quick Info badges -->
      <div style="display:flex;gap:10px;font-size:11px;font-weight:700">
        <span style="background:var(--gold-pale);padding:6px 12px;border:1px solid var(--border);border-radius:6px;color:var(--navy)">🟢 100% Privacy Guaranteed</span>
        <span style="background:var(--gold-pale);padding:6px 12px;border:1px solid var(--border);border-radius:6px;color:var(--navy)">🏅 Verified Scholars</span>
      </div>
    </div>

    <!-- Main Grid -->
    <div style="display:grid;grid-template-columns: 240px 1fr;gap:24px;align-items:start" class="grid-1">
      
      <!-- Filters Sidebar -->
      <div class="card" style="border:1px solid var(--border);background:var(--gold-pale)">
        <div class="card-body" style="padding:18px">
          <h3 class="cinzel" style="font-size:14px;color:var(--navy);margin-bottom:14px;border-bottom:1px solid var(--border);padding-bottom:6px">Filter Experts</h3>
          
          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label" style="font-size:11px">Expertise</label>
            <select class="form-select" style="font-size:12px" onchange="alert('Filtering by specialty...')">
              <option>All Specialties</option>
              <option>Vedic Jyotish</option>
              <option>KP System</option>
              <option>Lal Kitab</option>
              <option>Vastu Shastra</option>
            </select>
          </div>

          <div class="form-group" style="margin-bottom:12px">
            <label class="form-label" style="font-size:11px">Language</label>
            <select class="form-select" style="font-size:12px" onchange="alert('Filtering by language...')">
              <option>All Languages</option>
              <option>Hindi</option>
              <option>English</option>
              <option>Tamil</option>
              <option>Telugu</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" style="font-size:11px">Sort By</label>
            <select class="form-select" style="font-size:12px" onchange="alert('Sorting experts...')">
              <option>Popularity</option>
              <option>Experience: High to Low</option>
              <option>Price: Low to High</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Astrologers Cards List -->
      <div style="display:grid;grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));gap:20px" class="grid-2">
        <?php if (!empty($astrologers)): ?>
          <?php foreach ($astrologers as $astro): ?>
            <div class="card" style="border:1px solid var(--border);border-radius:12px;overflow:hidden;cursor:pointer" onclick="location.href='<?= site_url('astrologers/detail/'.$astro['id']) ?>'">
              <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));color:white;padding:24px;text-align:center;position:relative">
                <div style="width:64px;height:64px;border-radius:50%;background:rgba(200,147,26,0.15);border:2px solid var(--gold);color:white;font-size:28px;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 8px">
                  <?= strtoupper(substr($astro['name'], 0, 1)) ?>
                </div>
                <strong style="font-size:14px;color:var(--gold-bright);display:block"><?= html_escape($astro['name']) ?></strong>
                <span style="font-size:10px;color:rgba(255,255,255,0.6)"><?= html_escape($astro['expertise']) ?></span>
                
                <span style="position:absolute;top:10px;right:10px;font-size:9px;background:rgba(34,197,94,0.15);color:rgb(34,197,94);padding:2px 8px;border-radius:20px;border:1px solid rgb(34,197,94)">
                  <?= $astro['is_online'] ? '● Online' : '○ Busy' ?>
                </span>
              </div>
              
              <div class="card-body" style="padding:14px">
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;color:var(--text-muted);margin-bottom:12px">
                  <span>💼 <?= intval($astro['experience_years']) ?> Yrs Exp</span>
                  <span>🗣 <?= html_escape($astro['languages']) ?></span>
                </div>
                
                <div style="display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--border-light);padding-top:10px">
                  <div>
                    <span style="font-size:14px;font-weight:700;color:var(--saffron)">₹<?= number_format($astro['per_minute_charge'], 2) ?></span>
                    <span style="font-size:10px;color:var(--text-muted)">/ min</span>
                  </div>
                  <a href="<?= site_url('auth/login') ?>" class="btn btn-primary btn-sm" style="font-size:10px;padding:6px 12px">Consult Now</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div style="text-align:center;grid-column:1/-1;color:var(--text-muted);padding:40px 10px;">
            No verified astrologers found matching selected parameters.
          </div>
        <?php endif; ?>
      </div>

    </div>

  </div>
</section>
