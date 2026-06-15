<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:960px">
    
    <div class="text-center" style="margin-bottom:40px">
      <div class="sec-label">✦ Varshphal 2026</div>
      <h1 class="cinzel" style="color:var(--navy);font-size:clamp(28px,5vw,44px);margin-bottom:12px">Yearly Horoscope 2026</h1>
      <p style="color:var(--text-mid);font-size:16px;max-width:600px;margin:0 auto">A comprehensive planetary transit projection for the year 2026 covering Jupiter, Saturn, and Rahu/Ketu transits.</p>
    </div>

    <!-- Active Sign Selector -->
    <div style="display:grid;grid-template-columns:repeat(6, 1fr);gap:12px;margin-bottom:34px" class="grid-3" id="ySignGrid"></div>

    <div class="card" id="yDisplayBox" style="border:1px solid var(--border);background:white;display:none">
      <div class="card-body">
        <h2 class="cinzel" style="color:var(--navy);border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:18px" id="ySignTitle">Aries Yearly Projection</h2>
        
        <div style="display:flex;flex-direction:column;gap:18px;font-size:13px;color:var(--text-mid);line-height:1.7">
          <p>
            🌟 <strong>Jupiter Transit Impact:</strong> Jupiter transits through Gemini and Cancer this year, indicating major developments in education and family harmony. Wealth accumulation is indicated in the second half of 2026.
          </p>
          <p>
            🪐 <strong>Saturn's Influence:</strong> Saturn continues its transit in Pisces. Saturn's aspect on your rising sign encourages patience. Establish a stable daily routine to handle minor career pressure.
          </p>
          <p>
            🔮 <strong>General Remedy:</strong> Chanting the Hanuman Chalisa on Tuesdays and donating green pulses to students will help mitigate transit delays.
          </p>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
const ySigns = [
  {sym:'♈',en:'Aries'},{sym:'♉',en:'Taurus'},{sym:'♊',en:'Gemini'},
  {sym:'♋',en:'Cancer'},{sym:'♌',en:'Leo'},{sym:'♍',en:'Virgo'},
  {sym:'♎',en:'Libra'},{sym:'♏',en:'Scorpio'},{sym:'♐',en:'Sagittarius'},
  {sym:'♑',en:'Capricorn'},{sym:'♒',en:'Aquarius'},{sym:'♓',en:'Pisces'}
];

document.getElementById('ySignGrid').innerHTML = ySigns.map((s, idx) =>
  `<div onclick="showYearly(${idx})" style="text-align:center;padding:12px;border:1px solid var(--border);background:white;border-radius:10px;cursor:pointer;transition:all .2s" class="y-sign-card" id="y-sign-${idx}">
    <div style="font-size:28px">${s.sym}</div>
    <strong style="font-size:13px;color:var(--navy);display:block;margin-top:4px">${s.en}</strong>
  </div>`
).join('');

function showYearly(idx) {
  document.querySelectorAll('.y-sign-card').forEach(el => {
    el.style.background = 'white';
    el.style.borderColor = 'var(--border)';
  });
  const card = document.getElementById('y-sign-' + idx);
  card.style.background = 'var(--gold-pale)';
  card.style.borderColor = 'var(--gold)';

  const active = ySigns[idx];
  document.getElementById('ySignTitle').textContent = active.en + ' 2026 Yearly Projection';
  document.getElementById('yDisplayBox').style.display = 'block';
}

showYearly(0);
</script>
