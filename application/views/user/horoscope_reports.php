<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model('user_profile_model');
$profile = $CI->user_profile_model->get_where(['user_id' => $current_user['id']]);
$user_rashi = 'Mesh';
if (!empty($profile)) {
    // Attempt to parse rashi from bio
    if (preg_match('/Zodiac:\s*([A-Za-z]+)/', $profile[0]['bio'], $matches)) {
        $user_rashi = $matches[1];
    }
}

$rashis = [
    'Mesh' => ['name' => 'Mesh (Aries)', 'symbol' => '♈', 'sanskrit' => 'मेष', 'score' => '8.2', 'rating' => '★★★★☆', 'career' => '★★★★★ Excellent opportunities ahead. Be bold.', 'love' => '★★★★☆ Harmony prevails. Communicate clearly.', 'finance' => '★★★☆☆ Moderate. Avoid impulse purchases.', 'health' => '★★★★☆ Energy levels are high. Focus on fitness.'],
    'Vrishab' => ['name' => 'Vrishab (Taurus)', 'symbol' => '♉', 'sanskrit' => 'वृषभ', 'score' => '7.8', 'rating' => '★★★☆☆', 'career' => '★★★★☆ Professional recognition is near.', 'love' => '★★★☆☆ A minor misunderstanding may occur.', 'finance' => '★★★★★ Financial gains from unexpected sources.', 'health' => '★★★☆☆ Take rest. Guard against fatigue.'],
    'Mithun' => ['name' => 'Mithun (Gemini)', 'symbol' => '♊', 'sanskrit' => 'मिथुन', 'score' => '8.5', 'rating' => '★★★★★', 'career' => '★★★★★ Creativity is at its peak. Start new projects.', 'love' => '★★★★★ Romance is in the air. Enjoy.', 'finance' => '★★★★☆ Solid investments yield good results.', 'health' => '★★★★☆ Excellent vital energy today.'],
    'Kark' => ['name' => 'Kark (Cancer)', 'symbol' => '♋', 'sanskrit' => 'कर्क', 'score' => '7.2', 'rating' => '★★★☆☆', 'career' => '★★★☆☆ Work pressure will increase. Stay calm.', 'love' => '★★★★☆ Emotional connection grows stronger.', 'finance' => '★★★☆☆ Keep a strict budget.', 'health' => '★★★☆☆ Focus on mental peace and meditation.'],
    'Simha' => ['name' => 'Simha (Leo)', 'symbol' => '♌', 'sanskrit' => 'सिंह', 'score' => '8.9', 'rating' => '★★★★★', 'career' => '★★★★★ Leadership qualities shine. Major breakthrough.', 'love' => '★★★★☆ Passionate times ahead.', 'finance' => '★★★★★ Wealth stars are aligned. Good day.', 'health' => '★★★★★ High energy and health vigor.'],
    'Kanya' => ['name' => 'Kanya (Virgo)', 'symbol' => '♍', 'sanskrit' => 'कन्या', 'score' => '8.0', 'rating' => '★★★★☆', 'career' => '★★★★☆ Accuracy and detail yield great results.', 'love' => '★★★☆☆ Focus on listening to your partner.', 'finance' => '★★★★☆ Good financial planning pays off.', 'health' => '★★★★☆ Digestion is good. Keep a clean diet.'],
    'Tula' => ['name' => 'Tula (Libra)', 'symbol' => '♎', 'sanskrit' => 'तुला', 'score' => '8.3', 'rating' => '★★★★☆', 'career' => '★★★★☆ Great teamwork and collaboration.', 'love' => '★★★★★ Wonderful day for romantic excursions.', 'finance' => '★★★☆☆ Balance your expenses.', 'health' => '★★★★☆ Peaceful mind, healthy body.'],
    'Vrishchik' => ['name' => 'Vrishchik (Scorpio)', 'symbol' => '♏', 'sanskrit' => 'वृश्चिक', 'score' => '7.9', 'rating' => '★★★☆☆', 'career' => '★★★★☆ Trust your intuition in business dealings.', 'love' => '★★★☆☆ Allow space in relationships.', 'finance' => '★★★★☆ Stable gains from previous assets.', 'health' => '★★★☆☆ Take care of minor allergies.'],
    'Dhanu' => ['name' => 'Dhanu (Sagittarius)', 'symbol' => '♐', 'sanskrit' => 'धनु', 'score' => '8.6', 'rating' => '★★★★★', 'career' => '★★★★★ Expansion and foreign opportunities.', 'love' => '★★★★☆ Growth and adventure in relationship.', 'finance' => '★★★★★ Excellent day for transactions.', 'health' => '★★★★☆ Optimistic mindset improves physical well-being.'],
    'Makar' => ['name' => 'Makar (Capricorn)', 'symbol' => '♑', 'sanskrit' => 'मकर', 'score' => '8.1', 'rating' => '★★★★☆', 'career' => '★★★★★ Hard work is rewarded. Success is assured.', 'love' => '★★★☆☆ Be patient and supportive.', 'finance' => '★★★★☆ Gradual financial progress.', 'health' => '★★★★☆ Focus on posture and bone health.'],
    'Kumbh' => ['name' => 'Kumbh (Aquarius)', 'symbol' => '♒', 'sanskrit' => 'कुंभ', 'score' => '8.4', 'rating' => '★★★★☆', 'career' => '★★★★☆ Innovative ideas receive backing.', 'love' => '★★★★★ Great understanding with spouse.', 'finance' => '★★★★☆ Gains through digital commerce.', 'health' => '★★★★☆ Good day for active exercises.'],
    'Meen' => ['name' => 'Meen (Pisces)', 'symbol' => '♓', 'sanskrit' => 'मीन', 'score' => '7.7', 'rating' => '★★★☆☆', 'career' => '★★★☆☆ Dreamy day. Focus on keeping focus.', 'love' => '★★★★☆ Deep empathetic connection.', 'finance' => '★★★☆☆ Guard against overspending on luxuries.', 'health' => '★★★★☆ Good spiritual vibes boost health.']
];

$selected = isset($rashis[$user_rashi]) ? $rashis[$user_rashi] : $rashis['Mesh'];
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🔮 Horoscope Reports</div>
    <div class="page-header-sub">Daily, weekly, and monthly Vedic planetary guidance for your Rashi</div>
  </div>
</div>

<div class="grid-2" style="gap:20px">
  <!-- Interactive Selector -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Select Zodiac Sign</div>
      <div style="display:grid;grid-template-columns: repeat(4, 1fr);gap:10px;margin-bottom:20px">
        <?php foreach ($rashis as $key => $val): ?>
          <button class="filter-chip <?= ($key === $user_rashi) ? 'active' : '' ?>" style="display:flex;flex-direction:column;align-items:center;padding:12px;font-size:11px" onclick="loadHoroscope('<?= $key ?>')">
            <span style="font-size:24px;margin-bottom:4px"><?= $val['symbol'] ?></span>
            <span><?= html_escape($key) ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Horoscope Display Card -->
  <div class="card">
    <div class="card-body" id="horoscopeDisplay">
      <div class="card-title">Today's Cosmic Guidance</div>
      
      <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));border-radius:12px;padding:24px;text-align:center;margin-bottom:20px;color:white">
        <div style="font-size:48px;margin-bottom:8px" id="h-symbol"><?= $selected['symbol'] ?></div>
        <div class="cinzel" style="color:var(--gold-bright);font-size:20px" id="h-name"><?= html_escape($selected['name']) ?></div>
        <div style="color:rgba(255,255,255,0.45);font-size:12px;margin-bottom:14px" id="h-sanskrit"><?= html_escape($selected['sanskrit']) ?> Rashi</div>
        <div style="display:flex;justify-content:center;gap:30px">
          <div><div class="cinzel" style="font-size:24px;color:var(--gold-bright)" id="h-score"><?= $selected['score'] ?></div><div style="font-size:10px;color:rgba(255,255,255,0.4)">Overall Score</div></div>
          <div style="width:1px;background:rgba(255,255,255,0.1)"></div>
          <div><div style="color:var(--gold-bright);font-size:18px" id="h-rating"><?= $selected['rating'] ?></div><div style="font-size:10px;color:rgba(255,255,255,0.4)">Rating</div></div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr;gap:12px">
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px">
          <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">💼 Career & Business</div>
          <div style="color:var(--navy);font-size:13px;" id="h-career"><?= html_escape($selected['career']) ?></div>
        </div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px">
          <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">💑 Love & Family</div>
          <div style="color:var(--navy);font-size:13px;" id="h-love"><?= html_escape($selected['love']) ?></div>
        </div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px">
          <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">💰 Finance & Wealth</div>
          <div style="color:var(--navy);font-size:13px;" id="h-finance"><?= html_escape($selected['finance']) ?></div>
        </div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:8px;padding:12px">
          <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">🏥 Health & Energy</div>
          <div style="color:var(--navy);font-size:13px;" id="h-health"><?= html_escape($selected['health']) ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const horoscopeData = <?= json_encode($rashis) ?>;

function loadHoroscope(rashiKey) {
  const data = horoscopeData[rashiKey];
  if (!data) return;

  // Highlight selected chip
  document.querySelectorAll('.filter-chip').forEach(c => {
    if (c.textContent.toLowerCase().includes(rashiKey.toLowerCase())) {
      c.classList.add('active');
    } else {
      c.classList.remove('active');
    }
  });

  // Update Display
  document.getElementById('h-symbol').textContent = data.symbol;
  document.getElementById('h-name').textContent = data.name;
  document.getElementById('h-sanskrit').textContent = data.sanskrit + ' Rashi';
  document.getElementById('h-score').textContent = data.score;
  document.getElementById('h-rating').textContent = data.rating;
  document.getElementById('h-career').textContent = data.career;
  document.getElementById('h-love').textContent = data.love;
  document.getElementById('h-finance').textContent = data.finance;
  document.getElementById('h-health').textContent = data.health;
}
</script>
