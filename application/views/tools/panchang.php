<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:960px">
    
    <div class="text-center" style="margin-bottom:40px">
      <div class="sec-label">✦ Vedic Calendar</div>
      <h1 class="cinzel" style="color:var(--navy);font-size:clamp(28px,5vw,44px);margin-bottom:12px">Aaj Ka Panchang</h1>
      <p style="color:var(--text-mid);font-size:16px;max-width:600px;margin:0 auto">Retrieve exact Hindu daily calendar calculations, Shubh Muhurats, and Rahu Kaal coordinates.</p>
    </div>

    <!-- Date selector -->
    <div class="card" style="border:1px solid var(--border);margin-bottom:34px;background:var(--gold-pale)">
      <div class="card-body" style="display:flex;align-items:center;justify-content:between;flex-wrap:wrap;gap:12px">
        <div>
          <strong style="color:var(--navy);font-size:15px;display:block">Select Calendar Date</strong>
          <span style="font-size:11px;color:var(--text-muted)">Calculated using Lahiri coordinates (UTC +5:30)</span>
        </div>
        <div style="display:flex;gap:10px">
          <input type="date" id="panchDate" value="<?= date('Y-m-d') ?>" class="form-input" style="width:160px" onchange="updatePanchang()">
          <button class="btn btn-primary btn-sm" onclick="updatePanchang()">Get Panchang ✦</button>
        </div>
      </div>
    </div>

    <!-- Main Grid -->
    <div style="display:grid;grid-template-columns: 1fr 1.2fr;gap:24px;margin-bottom:34px" class="grid-2">
      
      <!-- Sun/Moon positions -->
      <div style="display:flex;flex-direction:column;gap:14px">
        <div class="card" style="border:1px solid var(--border)">
          <div class="card-body">
            <h3 class="cinzel" style="color:var(--navy);font-size:15px;margin-bottom:14px;border-bottom:1px solid var(--border);padding-bottom:8px">☀ Sun & Moon Coordinates</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
              <div style="background:var(--gold-pale);padding:10px;border-radius:6px;font-size:12px">
                <span style="color:var(--text-muted)">Sunrise</span>
                <strong style="display:block;font-size:14px;color:var(--navy);margin-top:2px">05:44 AM</strong>
              </div>
              <div style="background:var(--gold-pale);padding:10px;border-radius:6px;font-size:12px">
                <span style="color:var(--text-muted)">Sunset</span>
                <strong style="display:block;font-size:14px;color:var(--navy);margin-top:2px">07:02 PM</strong>
              </div>
              <div style="background:var(--gold-pale);padding:10px;border-radius:6px;font-size:12px">
                <span style="color:var(--text-muted)">Moonrise</span>
                <strong style="display:block;font-size:14px;color:var(--navy);margin-top:2px">02:30 PM</strong>
              </div>
              <div style="background:var(--gold-pale);padding:10px;border-radius:6px;font-size:12px">
                <span style="color:var(--text-muted)">Moonset</span>
                <strong style="display:block;font-size:14px;color:var(--navy);margin-top:2px">02:18 AM</strong>
              </div>
            </div>
          </div>
        </div>

        <div class="card" style="border:1px solid var(--border)">
          <div class="card-body">
            <h3 class="cinzel" style="color:var(--navy);font-size:15px;margin-bottom:14px;border-bottom:1px solid var(--border);padding-bottom:8px">⏳ Inauspicious Rahu Kaal</h3>
            <div style="background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.15);padding:14px;border-radius:8px">
              <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px">
                <strong>Rahu Kaal:</strong>
                <span style="color:var(--saffron)">09:00 AM – 10:30 AM</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:12px">
                <strong>Yamaganda:</strong>
                <span style="color:var(--text-muted)">01:30 PM – 03:00 PM</span>
              </div>
              <p style="font-size:10px;color:var(--text-muted);margin-top:8px;line-height:1.4">
                * Note: It is advised to avoid initiating new business projects or travel during Rahu Kaal.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Core 5 Elements (Panch-ang) -->
      <div class="card" style="border:1px solid var(--border)">
        <div class="card-body">
          <h3 class="cinzel" style="color:var(--navy);font-size:16px;margin-bottom:18px;border-bottom:1px solid var(--border);padding-bottom:10px">✦ Core Panchang Elements</h3>
          
          <div style="display:flex;flex-direction:column;gap:14px">
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-light);padding-bottom:8px">
              <div><strong style="color:var(--navy);font-size:13px;display:block">Tithi</strong><span style="font-size:11px;color:var(--text-muted)">Moon Phase</span></div>
              <div style="text-align:right"><span style="font-size:13px;font-weight:700;color:var(--saffron)">Dashami</span><span style="font-size:10px;color:var(--text-muted);display:block">Until 04:18 PM</span></div>
            </div>
            
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-light);padding-bottom:8px">
              <div><strong style="color:var(--navy);font-size:13px;display:block">Nakshatra</strong><span style="font-size:11px;color:var(--text-muted)">Constellation</span></div>
              <div style="text-align:right"><span style="font-size:13px;font-weight:700;color:var(--saffron)">Rohini</span><span style="font-size:10px;color:var(--text-muted);display:block">Until 08:44 PM</span></div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-light);padding-bottom:8px">
              <div><strong style="color:var(--navy);font-size:13px;display:block">Yoga</strong><span style="font-size:11px;color:var(--text-muted)">Solar/Lunar angle</span></div>
              <div style="text-align:right"><span style="font-size:13px;font-weight:700;color:var(--saffron)">Siddhi</span><span style="font-size:10px;color:var(--text-muted);display:block">Auspicious</span></div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border-light);padding-bottom:8px">
              <div><strong style="color:var(--navy);font-size:13px;display:block">Karana</strong><span style="font-size:11px;color:var(--text-muted)">Half-Tithi</span></div>
              <div style="text-align:right"><span style="font-size:13px;font-weight:700;color:var(--saffron)">Bava</span><span style="font-size:10px;color:var(--text-muted);display:block">Until 05:02 PM</span></div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:8px">
              <div><strong style="color:var(--navy);font-size:13px;display:block">Abhijit Muhurat</strong><span style="font-size:11px;color:var(--text-muted)">Best time of day</span></div>
              <div style="text-align:right"><span style="font-size:13px;font-weight:700;color:rgb(34,197,94)">11:30 AM – 12:15 PM</span><span style="font-size:10px;color:var(--text-muted);display:block">Auspicious</span></div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<script>
function updatePanchang() {
  alert('Calculating Panchang coordinates for selected date...');
}
</script>
