<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:960px">
    
    <div class="text-center" style="margin-bottom:40px">
      <div class="sec-label">✦ Daily Rashifal</div>
      <h1 class="cinzel" style="color:var(--navy);font-size:clamp(28px,5vw,44px);margin-bottom:12px">Today's Daily Horoscope</h1>
      <p style="color:var(--text-mid);font-size:16px;max-width:600px;margin:0 auto">Select your moon sign or sun sign for today's personalized planetary predictions.</p>
    </div>

    <!-- Sign Select Grid -->
    <div style="display:grid;grid-template-columns:repeat(6, 1fr);gap:12px;margin-bottom:34px" class="grid-3" id="horoSignGrid">
      <!-- Generated via JS for cleaner look -->
    </div>

    <!-- Active Horoscope Box -->
    <div class="card" id="horoDisplayBox" style="border:1px solid var(--border);background:white;display:none">
      <div class="card-body">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;border-bottom:1px solid var(--border);padding-bottom:14px">
          <span style="font-size:36px" id="activeHoroSym">♈</span>
          <div>
            <h2 class="cinzel" style="color:var(--navy);margin:0;font-size:20px" id="activeHoroName">Aries Horoscope</h2>
            <div style="font-size:11px;color:var(--text-muted)">Predictions for Today · Jyeshtha Shukla Dashami</div>
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px" class="grid-2">
          <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:10px">
            <strong style="color:var(--navy);font-size:13px;display:block;margin-bottom:4px">💼 Career & Business</strong>
            <p style="font-size:12px;color:var(--text-mid);line-height:1.5">Planetary transit positions in your 10th house indicate a highly favorable day for team collaborations and new contracts. Avoid arguments with seniors.</p>
          </div>
          <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:10px">
            <strong style="color:var(--navy);font-size:13px;display:block;margin-bottom:4px">💑 Love & Relationships</strong>
            <p style="font-size:12px;color:var(--text-mid);line-height:1.5">Moon in Leo coordinates with your relationship zone. Great time to clear up old misunderstandings with your partner. Single natives might receive a proposal.</p>
          </div>
          <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:10px">
            <strong style="color:var(--navy);font-size:13px;display:block;margin-bottom:4px">💰 Money & Finance</strong>
            <p style="font-size:12px;color:var(--text-mid);line-height:1.5">Moderate financial day. Avoid speculative trading or loan distributions today. Focus on savings and budget cuts.</p>
          </div>
          <div style="background:var(--gold-pale);border:1px solid var(--border);padding:14px;border-radius:10px">
            <strong style="color:var(--navy);font-size:13px;display:block;margin-bottom:4px">🏥 Health & Energy</strong>
            <p style="font-size:12px;color:var(--text-mid);line-height:1.5">Energy levels are high. Be mindful of minor digestion issues. Stay hydrated and practice yoga in the morning.</p>
          </div>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;background:var(--gold-pale);padding:12px 18px;border-radius:8px;border:1px solid var(--border);flex-wrap:wrap;gap:12px">
          <div><strong style="color:var(--navy);font-size:12px">Auspicious Color:</strong> <span style="font-size:12px;color:var(--text-muted)">Yellow</span></div>
          <div><strong style="color:var(--navy);font-size:12px">Lucky Number:</strong> <span style="font-size:12px;color:var(--text-muted)">9</span></div>
          <div><strong style="color:var(--navy);font-size:12px">Auspicious Time:</strong> <span style="font-size:12px;color:var(--text-muted)">11:30 AM – 1:00 PM</span></div>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
const signs = [
  {sym:'♈',hi:'मेष',en:'Aries'},{sym:'♉',hi:'वृष',en:'Taurus'},{sym:'♊',hi:'मिथुन',en:'Gemini'},
  {sym:'♋',hi:'कर्क',en:'Cancer'},{sym:'♌',hi:'सिंह',en:'Leo'},{sym:'♍',hi:'कन्या',en:'Virgo'},
  {sym:'♎',hi:'तुला',en:'Libra'},{sym:'♏',hi:'वृश्चिक',en:'Scorpio'},{sym:'♐',hi:'धनु',en:'Sagittarius'},
  {sym:'♑',hi:'मकर',en:'Capricorn'},{sym:'♒',hi:'कुम्भ',en:'Aquarius'},{sym:'♓',hi:'मीन',en:'Pisces'}
];

document.getElementById('horoSignGrid').innerHTML = signs.map((s, idx) =>
  `<div onclick="showHoro(${idx})" style="text-align:center;padding:12px;border:1px solid var(--border);background:white;border-radius:10px;cursor:pointer;transition:all .2s" class="sign-card" id="sign-${idx}">
    <div style="font-size:28px">${s.sym}</div>
    <strong style="font-size:13px;color:var(--navy);display:block;margin-top:4px">${s.en}</strong>
    <span style="font-size:10px;color:var(--text-muted)">${s.hi}</span>
  </div>`
).join('');

function showHoro(idx) {
  document.querySelectorAll('.sign-card').forEach(el => {
    el.style.background = 'white';
    el.style.borderColor = 'var(--border)';
  });
  const card = document.getElementById('sign-' + idx);
  card.style.background = 'var(--gold-pale)';
  card.style.borderColor = 'var(--gold)';

  const active = signs[idx];
  document.getElementById('activeHoroSym').textContent = active.sym;
  document.getElementById('activeHoroName').textContent = active.en + ' Daily Horoscope';
  document.getElementById('horoDisplayBox').style.display = 'block';
  document.getElementById('horoDisplayBox').scrollIntoView({behavior:'smooth', block:'nearest'});
}

// Auto open Aries
showHoro(0);
</script>
