<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:960px">
    
    <div class="text-center" style="margin-bottom:40px">
      <div class="sec-label">✦ Kundli Milan</div>
      <h1 class="cinzel" style="color:var(--navy);font-size:clamp(28px,5vw,44px);margin-bottom:12px">Kundali Matching for Marriage</h1>
      <p style="color:var(--text-mid);font-size:16px;max-width:600px;margin:0 auto">Vedic horoscope compatibility analyzer calculating Ashtakoot Guna matching and Manglik matching.</p>
    </div>

    <!-- Matchmaking Form -->
    <div class="card" style="border:1px solid var(--border);margin-bottom:34px">
      <div class="card-body">
        <form id="matchForm" onsubmit="calculateMatch(); return false;">
          <div class="grid-2" style="gap:24px">
            <!-- Boy Details -->
            <div style="background:var(--gold-pale);border:1px solid var(--border);padding:18px;border-radius:12px">
              <h3 class="cinzel" style="color:var(--navy);font-size:15px;margin-bottom:14px;border-bottom:1px solid var(--border);padding-bottom:8px">👦 Boy's Birth Details</h3>
              <div class="form-group" style="margin-bottom:10px">
                <label class="form-label">Name</label>
                <input class="form-input" type="text" id="bName" value="Rahul Sharma" required>
              </div>
              <div class="form-grid-2" style="margin-bottom:10px">
                <div class="form-group">
                  <label class="form-label">Date of Birth</label>
                  <input class="form-input" type="date" id="bDOB" value="1994-08-20" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Time of Birth</label>
                  <input class="form-input" type="time" id="bTOB" value="09:15" required>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Place of Birth</label>
                <input class="form-input" type="text" id="bCity" value="Delhi" required>
              </div>
            </div>

            <!-- Girl Details -->
            <div style="background:var(--gold-pale);border:1px solid var(--border);padding:18px;border-radius:12px">
              <h3 class="cinzel" style="color:var(--navy);font-size:15px;margin-bottom:14px;border-bottom:1px solid var(--border);padding-bottom:8px">👧 Girl's Birth Details</h3>
              <div class="form-group" style="margin-bottom:10px">
                <label class="form-label">Name</label>
                <input class="form-input" type="text" id="gName" value="Priya Nair" required>
              </div>
              <div class="form-grid-2" style="margin-bottom:10px">
                <div class="form-group">
                  <label class="form-label">Date of Birth</label>
                  <input class="form-input" type="date" id="gDOB" value="1995-11-12" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Time of Birth</label>
                  <input class="form-input" type="time" id="gTOB" value="14:30" required>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Place of Birth</label>
                <input class="form-input" type="text" id="gCity" value="Mumbai" required>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100" style="margin-top:20px">✦ Match Compatibility Now</button>
        </form>
      </div>
    </div>

    <!-- Match Result Box -->
    <div class="card" id="matchResult" style="border:1px solid var(--border);background:white;display:none;margin-bottom:34px">
      <div class="card-body">
        <h3 class="cinzel" style="color:var(--navy);font-size:18px;margin-bottom:18px;text-align:center">Vedic Matchmaking Compatibility Results</h3>
        
        <!-- Score Circular representation -->
        <div style="text-align:center;margin-bottom:24px">
          <div style="display:inline-flex;flex-direction:column;justify-content:center;align-items:center;width:120px;height:120px;border-radius:50%;background:rgba(200,147,26,0.1);border:4px solid var(--gold)">
            <span style="font-size:32px;font-weight:800;color:var(--saffron)">28.5</span>
            <span style="font-size:11px;color:var(--text-muted)">out of 36 Gunas</span>
          </div>
          <div style="font-size:14px;font-weight:700;color:var(--navy);margin-top:10px">Auspicious Compatibility Match ✓</div>
        </div>

        <div class="grid-3" style="gap:14px;margin-bottom:20px">
          <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:10px;text-align:center">
            <strong style="color:var(--navy);font-size:12px">Ashtakoot Guna Match</strong>
            <div style="font-size:18px;font-weight:700;color:var(--gold);margin-top:4px">28.5 / 36</div>
          </div>
          <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:10px;text-align:center">
            <strong style="color:var(--navy);font-size:12px">Boy Manglik Status</strong>
            <div style="font-size:14px;font-weight:700;color:rgb(34,197,94);margin-top:6px">Non-Manglik</div>
          </div>
          <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:10px;text-align:center">
            <strong style="color:var(--navy);font-size:12px">Girl Manglik Status</strong>
            <div style="font-size:14px;font-weight:700;color:rgb(34,197,94);margin-top:6px">Non-Manglik</div>
          </div>
        </div>

        <p style="font-size:12px;color:var(--text-mid);line-height:1.6;margin-bottom:18px;text-align:center">
          The Ashtakoot score of 28.5 indicates strong psychological, mental, and physical compatibility. Friendship (Maitri) and harmony levels are excellent. Yoni and Nadi compatibility match parameters are positive. Ideal for marital harmony.
        </p>

        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:14px;display:flex;gap:10px;align-items:center">
          <span style="font-size:24px">🔱</span>
          <div style="flex-grow:1;font-size:11px;color:var(--text-muted)">For checking specific Kundali Doshas (like Bhakoot or Nadi Doshas) and remedies consult our verified experts.</div>
          <a href="<?= site_url('astrologers') ?>" class="btn btn-primary btn-sm" style="font-size:11px;padding:6px 12px">Talk to Astrologer</a>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
function calculateMatch() {
  document.getElementById('matchResult').style.display = 'block';
  document.getElementById('matchResult').scrollIntoView({behavior:'smooth', block:'start'});
}
</script>
