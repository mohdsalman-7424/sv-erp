<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-header">
  <div>
    <div class="page-header-title">🔭 Kundali Generator</div>
    <div class="page-header-sub">Generate authentic Vedic birth chart with Dasha & Yoga analysis</div>
  </div>
</div>

<div class="form-card" style="max-width:860px;margin:0 auto 32px">
  <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px;padding-bottom:18px;border-bottom:1px solid var(--border)">
    <span style="font-size:26px">🔭</span>
    <div><h3 class="cinzel" style="font-size:18px;color:var(--navy)" data-theme-text>Birth Information</h3><p style="font-size:12px;color:var(--text-muted)">All fields required for accurate Kundali generation</p></div>
  </div>
  <div class="form-grid-2">
    <div class="form-group"><label class="form-label">Full Name <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">👤</span><input class="form-input" type="text" id="kName" placeholder="e.g. Rahul Kumar Sharma" value="Arjun Kumar Mehta"></div></div>
    <div class="form-group"><label class="form-label">Gender <span class="req">*</span></label><select class="form-select" id="kGender"><option>Male</option><option>Female</option><option>Other</option></select></div>
    <div class="form-group"><label class="form-label">Date of Birth <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">📅</span><input class="form-input" type="date" id="kDOB" value="1995-05-15"></div></div>
    <div class="form-group"><label class="form-label">Time of Birth <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">🕐</span><input class="form-input" type="time" id="kTOB" value="06:30"></div></div>
    <div class="form-group"><label class="form-label">Country</label><select class="form-select"><option>India</option><option>USA</option><option>UK</option><option>UAE</option></select></div>
    <div class="form-group"><label class="form-label">State</label><select class="form-select"><option>Uttar Pradesh</option><option>Maharashtra</option><option>Delhi</option><option>Gujarat</option><option>Tamil Nadu</option></select></div>
    <div class="form-group full"><label class="form-label">City of Birth <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">📍</span><input class="form-input" type="text" id="kCity" placeholder="e.g. Varanasi, Mumbai, Delhi..." value="Varanasi"></div></div>
    <div class="form-group"><label class="form-label">Chart Style</label><select class="form-select"><option>North Indian</option><option>South Indian</option></select></div>
    <div class="form-group"><label class="form-label">Language</label><select class="form-select"><option>English</option><option>Hindi</option><option>Tamil</option></select></div>
  </div>
  <div style="display:flex;gap:12px;margin-top:22px;flex-wrap:wrap">
    <button class="btn btn-primary" style="flex:1;min-width:180px" onclick="generateKundali()">✦ Generate Kundali Now</button>
    <button class="btn btn-secondary" onclick="Toast.show('Upload feature coming soon','info')">📤 Upload Existing PDF</button>
  </div>
</div>

<!-- RESULT -->
<div id="kundliResult" style="display:none;max-width:860px;margin:0 auto">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px">
    <div><h3 class="playfair" style="font-size:22px;color:var(--navy)" data-theme-text>Kundali of <em id="rName"></em></h3><p style="font-size:12px;color:var(--text-muted)" id="rSub"></p></div>
    <div style="display:flex;gap:9px;flex-wrap:wrap">
      <button class="btn btn-secondary btn-sm" onclick="window.print()">⬇ Download PDF</button>
      <a href="<?= site_url('astrologers') ?>" class="btn btn-primary btn-sm">Get Expert Prediction</a>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:18px" id="kundliResGrid">
    <!-- Chart -->
    <div class="form-card" style="padding:18px">
      <div class="card-title" style="text-align:center;display:block;padding-bottom:12px;border-bottom:1px solid var(--border);margin-bottom:14px">✦ Lagna Chart (D1)</div>
      <svg viewBox="0 0 300 300" style="width:100%" xmlns="http://www.w3.org/2000/svg">
        <rect width="300" height="300" fill="var(--gold-pale)" stroke="#C8931A" stroke-width="1.5" rx="3"/>
        <line x1="0" y1="0" x2="300" y2="300" stroke="#C8931A" stroke-width="1.2" opacity="0.4"/>
        <line x1="300" y1="0" x2="0" y2="300" stroke="#C8931A" stroke-width="1.2" opacity="0.4"/>
        <line x1="150" y1="0" x2="150" y2="300" stroke="#C8931A" stroke-width="0.8" opacity="0.3"/>
        <line x1="0" y1="150" x2="300" y2="150" stroke="#C8931A" stroke-width="0.8" opacity="0.3"/>
        <polygon points="150,0 300,150 150,300 0,150" fill="none" stroke="#C8931A" stroke-width="1.5"/>
        <text x="150" y="60" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">1 – Asc</text>
        <text x="150" y="73" text-anchor="middle" fill="#7A6A52" font-size="9">Kumbha</text>
        <text x="150" y="84" text-anchor="middle" fill="#7B1C1C" font-size="9">Su Me</text>
        <text x="68" y="148" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">12</text>
        <text x="68" y="160" text-anchor="middle" fill="#7A6A52" font-size="9">Makara • Ve</text>
        <text x="232" y="148" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">2</text>
        <text x="232" y="160" text-anchor="middle" fill="#7A6A52" font-size="9">Meena</text>
        <text x="232" y="172" text-anchor="middle" fill="#7B1C1C" font-size="8">Ma Ju</text>
        <text x="150" y="236" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">7</text>
        <text x="150" y="249" text-anchor="middle" fill="#7A6A52" font-size="9">Simha • Mo</text>
        <text x="44" y="60" text-anchor="middle" fill="#9A8A72" font-size="8">11</text>
        <text x="256" y="60" text-anchor="middle" fill="#9A8A72" font-size="8">3</text>
        <text x="44" y="240" text-anchor="middle" fill="#9A8A72" font-size="8">9</text>
        <text x="256" y="240" text-anchor="middle" fill="#9A8A72" font-size="8">5</text>
        <text x="150" y="158" text-anchor="middle" fill="rgba(200,147,26,0.2)" font-size="40" font-family="serif">ॐ</text>
      </svg>
    </div>

    <!-- Planet Table + Dasha -->
    <div>
      <div class="form-card" style="padding:18px;margin-bottom:18px">
        <div class="card-title" style="text-align:center;display:block;padding-bottom:10px;border-bottom:1px solid var(--border);margin-bottom:12px">✦ Planet Positions</div>
        <table class="planet-table">
          <thead><tr><th>Planet</th><th>Rashi</th><th>Degree</th><th>House</th></tr></thead>
          <tbody>
            <tr><td>☀ Sun</td><td>Aries</td><td>15°12'</td><td>1st</td></tr>
            <tr><td>☽ Moon</td><td>Leo</td><td>8°44'</td><td>7th</td></tr>
            <tr><td>♂ Mars</td><td>Pisces</td><td>22°31'</td><td>2nd</td></tr>
            <tr><td>☿ Mercury</td><td>Aries</td><td>3°18'</td><td>1st</td></tr>
            <tr><td>♃ Jupiter</td><td>Pisces</td><td>18°55'</td><td>2nd</td></tr>
            <tr><td>♀ Venus</td><td>Capricorn</td><td>27°40'</td><td>12th</td></tr>
            <tr><td>♄ Saturn</td><td>Aquarius</td><td>1°22'</td><td>1st</td></tr>
            <tr><td>☊ Rahu</td><td>Scorpio</td><td>14°08'</td><td>10th</td></tr>
            <tr><td>☋ Ketu</td><td>Taurus</td><td>14°08'</td><td>4th</td></tr>
          </tbody>
        </table>
      </div>
      <div class="form-card" style="padding:18px">
        <div class="card-title" style="padding-bottom:10px;border-bottom:1px solid var(--border);margin-bottom:12px">✦ Vimshottari Dasha</div>
        <div class="dasha-row"><div class="dasha-dot" style="background:rgba(255,200,0,0.15);color:#FFD700">Su</div><div style="flex:1"><div style="font-size:12px;font-weight:700;color:var(--navy)">Sun Mahadasha (Current)</div><div style="font-size:11px;color:var(--text-muted)">Jun 2024 – Jun 2030</div></div><div class="dasha-bar-wrap"><div class="dasha-bar" style="width:30%"></div></div></div>
        <div class="dasha-row"><div class="dasha-dot" style="background:rgba(180,180,255,0.15);color:#C0C0FF">Mo</div><div style="flex:1"><div style="font-size:12px;font-weight:700;color:var(--navy)">Moon Mahadasha</div><div style="font-size:11px;color:var(--text-muted)">Jun 2030 – Jun 2040</div></div><div class="dasha-bar-wrap"><div class="dasha-bar" style="width:0%"></div></div></div>
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
          <div style="font-size:10px;color:var(--text-muted);margin-bottom:7px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">Key Yogas Detected</div>
          <div style="display:flex;flex-wrap:wrap;gap:6px"><span class="tag">Gajakesari Yoga</span><span class="tag tag-saf">Budha-Aditya Yoga</span><span class="tag">Pancha Mahapurusha</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Predictions -->
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:18px">
    <div class="form-card" style="padding:16px"><div style="font-size:24px;margin-bottom:8px">💼</div><div class="cinzel" style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px">Career Outlook</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">Strong 2nd house Jupiter indicates wealth through knowledge. Teaching, consulting, or law are favorable paths.</p></div>
    <div class="form-card" style="padding:16px"><div style="font-size:24px;margin-bottom:8px">💑</div><div class="cinzel" style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px">Marriage Prospects</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">7th house Moon in Leo suggests a passionate partner. Marriage likely 28–32. Not Manglik. ✓</p></div>
    <div class="form-card" style="padding:16px"><div style="font-size:24px;margin-bottom:8px">💊</div><div class="cinzel" style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px">Health Guidance</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">Saturn in 1st house — attention to bones and joints. Regular yoga and pranayama are recommended.</p></div>
  </div>

  <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:var(--r);padding:16px;display:flex;gap:13px;align-items:flex-start;flex-wrap:wrap">
    <span style="font-size:24px">⚠️</span>
    <div style="flex:1;min-width:180px"><div style="font-weight:700;color:var(--navy);margin-bottom:4px;font-size:13px">AI-Generated Draft — Professional Review Recommended</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">These are AI-assisted preliminary observations. For accurate, personalized predictions consult a verified Vedic astrologer.</p><a href="<?= site_url('astrologers') ?>" class="btn btn-primary btn-sm" style="margin-top:10px;display:inline-flex">Book Expert Consultation →</a></div>
  </div>
</div>

<script>
function generateKundali() {
  const name = document.getElementById('kName').value || 'Arjun Kumar';
  const dob  = document.getElementById('kDOB').value || '1995-05-15';
  const tob  = document.getElementById('kTOB').value || '06:30';
  const city = document.getElementById('kCity').value || 'Varanasi';

  document.getElementById('rName').textContent = name;
  document.getElementById('rSub').textContent = `Born: ${dob} | ${tob} | ${city} | Aries Lagna`;
  document.getElementById('kundliResult').style.display = 'block';
  document.getElementById('kundliResult').scrollIntoView({behavior:'smooth', block:'start'});
  Toast.show('Kundali generated successfully!', 'success');
}
</script>
