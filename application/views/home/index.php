<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-stars" id="starField"></div>
  <div class="hero-inner">
    <div>
      <div class="hero-badge">🇮🇳 India's Most Trusted Vedic Platform</div>
      <h1 class="hero-title">Unlock Your<br><span class="gold">Sacred</span> <span class="saf">Destiny</span><br>Through Stars</h1>
      <p class="hero-shloka">"यथा पिण्डे तथा ब्रह्माण्डे"<br>As is the individual, so is the universe</p>
      <p class="hero-desc">Get authentic Janam Kundli, expert Vedic astrologer consultations,<br>and personalized cosmic guidance trusted by 2.5 million seekers.</p>
      <div class="hero-btns">
        <a href="<?= site_url('tools/kundali-generator') ?>" class="btn btn-primary">✦ Generate Free Kundli</a>
        <a href="<?= site_url('astrologers') ?>" class="btn btn-secondary">Talk to Astrologer</a>
      </div>
      <div class="hero-stats">
        <div><span class="hero-stat-n">2.5M+</span><span class="hero-stat-l">Happy Seekers</span></div>
        <div><span class="hero-stat-n">1,200+</span><span class="hero-stat-l">Expert Astrologers</span></div>
        <div><span class="hero-stat-n">98%</span><span class="hero-stat-l">Satisfaction</span></div>
        <div><span class="hero-stat-n">18Yr+</span><span class="hero-stat-l">Combined Exp</span></div>
      </div>
    </div>
        <div class="hero-visual" style="display:flex;justify-content:center">
      <div class="kundli-card" style="width:100%;max-width:400px">
        <div class="kundli-head"><h3>✦ Janam Kundli</h3><p>LAGNA CHART • NORTH INDIAN STYLE</p></div>
        <div class="kundli-chart">
          <svg viewBox="0 0 260 260" style="width:100%;aspect-ratio:1" xmlns="http://www.w3.org/2000/svg">
            <rect width="260" height="260" fill="none" stroke="rgba(200,147,26,0.4)" stroke-width="1.5" rx="3"/>
            <line x1="0" y1="0" x2="260" y2="260" stroke="rgba(200,147,26,0.35)" stroke-width="1"/>
            <line x1="260" y1="0" x2="0" y2="260" stroke="rgba(200,147,26,0.35)" stroke-width="1"/>
            <line x1="130" y1="0" x2="130" y2="260" stroke="rgba(200,147,26,0.2)" stroke-width="1"/>
            <line x1="0" y1="130" x2="260" y2="130" stroke="rgba(200,147,26,0.2)" stroke-width="1"/>
            <polygon points="130,0 260,130 130,260 0,130" fill="none" stroke="rgba(200,147,26,0.5)" stroke-width="1.5"/>
            <text x="130" y="58" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">मेष</text>
            <text x="130" y="70" text-anchor="middle" fill="rgba(255,255,255,0.5)" font-size="8">Su Me</text>
            <text x="60" y="132" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">वृष</text>
            <text x="200" y="132" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">मिथुन</text>
            <text x="200" y="144" text-anchor="middle" fill="rgba(255,255,255,0.5)" font-size="8">Ma</text>
            <text x="130" y="206" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">कर्क</text>
            <text x="130" y="218" text-anchor="middle" fill="rgba(255,255,255,0.5)" font-size="8">Mo</text>
            <text x="38" y="58" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">धनु</text>
            <text x="222" y="58" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">मकर</text>
            <text x="38" y="208" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">तुला</text>
            <text x="222" y="208" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">सिंह</text>
            <text x="130" y="140" text-anchor="middle" fill="rgba(200,147,26,0.25)" font-size="34" font-family="serif">ॐ</text>
          </svg>
        </div>
        <div class="k-planets">
          <div class="k-planet"><div class="k-dot" style="background:rgba(255,200,0,0.15);color:#FFD700">☀</div><div><div class="k-pname">Sun</div><div class="k-ppos">Aries 15°12'</div></div></div>
          <div class="k-planet"><div class="k-dot" style="background:rgba(180,180,255,0.15);color:#C0C0FF">☽</div><div><div class="k-pname">Moon</div><div class="k-ppos">Cancer 8°44'</div></div></div>
          <div class="k-planet"><div class="k-dot" style="background:rgba(255,80,80,0.15);color:#FF9999">♂</div><div><div class="k-pname">Mars</div><div class="k-ppos">Gemini 22°31'</div></div></div>
          <div class="k-planet"><div class="k-dot" style="background:rgba(100,200,100,0.15);color:#90EE90">☿</div><div><div class="k-pname">Mercury</div><div class="k-ppos">Aries 3°18'</div></div></div>
        </div>
      </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker"><div class="ticker-wrap" id="tickerWrap"></div></div>

<!-- FEATURE STRIP -->
<div class="feat-strip">
  <div class="feat-strip-inner">
    <div class="feat-item"><div class="feat-icon" style="background:rgba(255,107,0,0.1)">🔭</div><div class="feat-text"><h4>Authentic Vedic Kundli</h4><p>North & South Indian charts</p></div></div>
    <div class="feat-item"><div class="feat-icon" style="background:rgba(200,147,26,0.1)">🎙</div><div class="feat-text"><h4>Live Consultation</h4><p>Chat, Audio & Video calls</p></div></div>
    <div class="feat-item"><div class="feat-icon" style="background:rgba(11,28,58,0.08)">🏅</div><div class="feat-text"><h4>Verified Experts</h4><p>1,200+ certified astrologers</p></div></div>
    <div class="feat-item"><div class="feat-icon" style="background:rgba(34,197,94,0.1)">🔒</div><div class="feat-text"><h4>100% Secure</h4><p>SSL + OTP protected</p></div></div>
  </div>
</div>

<!-- PANCHANG -->
<section class="section-sm" style="background:var(--navy)">
  <div class="container">
    <div class="text-center" style="margin-bottom:22px">
      <div class="sec-label sec-label-dark">✦ Aaj Ka Panchang</div>
      <h2 class="cinzel" style="color:white;font-size:clamp(18px,3vw,26px)">Today's Sacred Calendar</h2>
      <p style="color:rgba(255,255,255,0.35);font-size:12px;margin-top:4px" id="todayDate"></p>
    </div>
    <div class="panchang-grid">
      <div class="panch-item"><div class="panch-label">Tithi</div><div class="panch-val">Dashami</div><div class="panch-sub">Until 4:18 PM</div></div>
      <div class="panch-item"><div class="panch-label">Nakshatra</div><div class="panch-val">Rohini</div><div class="panch-sub">Until 8:44 PM</div></div>
      <div class="panch-item"><div class="panch-label">Yoga</div><div class="panch-val">Siddhi</div><div class="panch-sub">Auspicious</div></div>
      <div class="panch-item"><div class="panch-label">Karana</div><div class="panch-val">Bava</div><div class="panch-sub">Until 5:02 PM</div></div>
      <div class="panch-item"><div class="panch-label">Shubh Muhurat</div><div class="panch-val">10:30–12:15</div><div class="panch-sub">Abhijit Muhurat</div></div>
      <div class="panch-item"><div class="panch-label">Rahu Kaal</div><div class="panch-val">9:00–10:30</div><div class="panch-sub">Avoid work</div></div>
    </div>
  </div>
</section>

<!-- RASHIS -->
<section class="section" style="background:var(--bg-card)">
  <div class="container">
    <div class="text-center" style="margin-bottom:34px">
      <div class="sec-label">✦ Daily Horoscope</div>
      <h2 class="sec-title">Choose Your <em>Rashi</em></h2>
      <p class="sec-sub" style="margin:0 auto">Select your zodiac sign for today's personalized cosmic guidance</p>
    </div>
    <div class="rashi-grid" id="rashiGrid"></div>
  </div>
</section>

<!-- ASTROLOGERS -->
<section class="section" style="background:var(--bg-primary)">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:32px;flex-wrap:wrap;gap:12px">
      <div><div class="sec-label">✦ Our Experts</div><h2 class="sec-title">Meet Our <em>Certified</em> Astrologers</h2></div>
      <a href="<?= site_url('astrologers') ?>" class="btn btn-secondary btn-sm">View All Experts →</a>
    </div>
    <div class="astro-grid">
      <?php if (!empty($astrologers)): ?>
        <?php foreach ($astrologers as $astro): ?>
          <div class="astro-card" onclick="location.href='<?= site_url('astrologers/detail/'.$astro['id']) ?>'">
            <div class="astro-img" style="background:linear-gradient(135deg,var(--navy),var(--navy-mid))">
              <div class="astro-ava" style="background:rgba(200,147,26,0.15);color:var(--gold)"><?= strtoupper(substr($astro['name'], 0, 1)) ?></div>
              <?php if ($astro['is_online']): ?>
                <span class="astro-online">● Online</span>
              <?php endif; ?>
              <span class="astro-exp"><?= intval($astro['experience_years']) ?> Yrs Exp</span>
            </div>
            <div class="astro-body">
              <div class="astro-name"><?= html_escape($astro['name']) ?></div>
              <div class="astro-spec"><?= html_escape($astro['expertise']) ?></div>
              <div class="astro-footer">
                <div><span class="astro-stars">★★★★★</span><br><span style="font-size:11px;color:var(--text-muted)">Verified</span></div>
                <div><span class="price-tag">₹<?= number_format($astro['per_minute_charge'], 2) ?>/min</span></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="text-align:center;color:var(--text-muted);grid-column:1/-1">No certified astrologers available.</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- PLANS -->
<section class="section plans-section">
  <div class="container">
    <div class="text-center" style="margin-bottom:40px">
      <div class="sec-label sec-label-dark">✦ Premium Plans</div>
      <h2 class="sec-title sec-title-white">Choose Your <em>Sacred</em> Journey</h2>
      <p class="sec-sub" style="color:rgba(255,255,255,0.5);margin:0 auto">Unlock unlimited cosmic guidance with our curated subscription plans</p>
    </div>
    <div class="plans-grid" id="homePlansGrid"></div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section" style="background:var(--bg-card)">
  <div class="container">
    <div class="text-center" style="margin-bottom:32px">
      <div class="sec-label">✦ Real Stories</div>
      <h2 class="sec-title">What Our <em>Seekers</em> Say</h2>
      <div class="trust-badges" style="justify-content:center;margin-top:12px">
        <div class="trust-badge">🔒 SSL Secured</div>
        <div class="trust-badge">✅ Verified Astrologers</div>
        <div class="trust-badge">⭐ 4.9/5 Rated</div>
        <div class="trust-badge">🇮🇳 Made in India</div>
      </div>
    </div>
    <div class="testi-grid">
      <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">I was skeptical at first, but Pt. Rajesh Sharma's predictions about my career change were remarkably accurate. The Kundli report gave me clarity I had never experienced before.</p><div class="testi-author"><div class="testi-ava">A</div><div><div class="testi-name">Arjun Mehta</div><div class="testi-loc">★★★★★ &nbsp;Mumbai, Maharashtra</div></div></div></div>
      <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">Dr. Deepa Verma's guidance on my marriage helped me make the most important decision of my life. Her reading of our compatibility was spot-on and very detailed.</p><div class="testi-author"><div class="testi-ava" style="background:linear-gradient(135deg,#7C3AED,#A855F7)">P</div><div><div class="testi-name">Priya Nair</div><div class="testi-loc">★★★★★ &nbsp;Chennai, Tamil Nadu</div></div></div></div>
      <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">The Panchang and Muhurat service is exceptional. We planned our business launch as per the suggested Muhurat and the results have been beyond our expectations!</p><div class="testi-author"><div class="testi-ava" style="background:linear-gradient(135deg,#059669,#10B981)">R</div><div><div class="testi-name">Ramesh Gupta</div><div class="testi-loc">★★★★★ &nbsp;Ahmedabad, Gujarat</div></div></div></div>
    </div>
  </div>
</section>

<!-- BLOG -->
<section class="section" style="background:var(--bg-primary)">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:32px;flex-wrap:wrap;gap:12px">
      <div><div class="sec-label">✦ Knowledge Center</div><h2 class="sec-title">Sacred <em>Wisdom</em> & Articles</h2></div>
      <a href="<?= site_url('blog') ?>" class="btn btn-secondary btn-sm">All Articles →</a>
    </div>
    <div class="blog-grid">
      <div class="blog-card featured" onclick="location.href='<?= site_url('blog') ?>'"><div class="blog-img blog-img-lg" style="background:linear-gradient(135deg,#0B1C3A,#162B52)">🌙<span class="blog-tag-badge">Featured</span></div><div class="blog-body"><div class="blog-title">Understanding Your Janam Kundli: A Complete Guide for Beginners</div><div class="blog-meta"><span>Pt. Rajesh Sharma</span><span>•</span><span>8 min read</span><span>•</span><span>June 3, 2026</span></div></div></div>
      <div class="blog-card" onclick="location.href='<?= site_url('blog') ?>'"><div class="blog-img" style="background:linear-gradient(135deg,#7C3AED,#A855F7)">🪐<span class="blog-tag-badge">Planets</span></div><div class="blog-body"><div class="blog-title">Saturn's Return and What It Means for You</div><div class="blog-meta"><span>Dr. Deepa Verma</span><span>•</span><span>5 min read</span></div></div></div>
      <div class="blog-card" onclick="location.href='<?= site_url('blog') ?>'"><div class="blog-img" style="background:linear-gradient(135deg,#B45309,#D97706)">💍<span class="blog-tag-badge">Marriage</span></div><div class="blog-body"><div class="blog-title">Best Muhurats for Marriage in 2026</div><div class="blog-meta"><span>AstroVeda Team</span><span>•</span><span>4 min read</span></div></div></div>
    </div>
  </div>
</section>

<!-- FAQ SNIPPET -->
<section class="section" style="background:var(--bg-card)">
  <div class="container" style="max-width:760px">
    <div class="text-center" style="margin-bottom:32px">
      <div class="sec-label">✦ FAQ</div>
      <h2 class="sec-title">Common <em>Questions</em></h2>
    </div>
    <div class="faq-item"><div class="faq-q">Is Vedic astrology scientifically accurate? <span class="faq-arrow">▾</span></div><div class="faq-a">Vedic Jyotish is an ancient knowledge system refined over thousands of years. While it operates on a different paradigm than modern science, millions of practitioners and seekers worldwide find it deeply meaningful and accurate for life guidance.</div></div>
    <div class="faq-item"><div class="faq-q">How is the Kundli generated? <span class="faq-arrow">▾</span></div><div class="faq-a">Our Kundli engine uses precise astronomical algorithms (Lahiri Ayanamsha) to calculate planetary positions at your birth time and place, generating North/South Indian style charts with planet positions, Dasha timelines and Yoga analysis.</div></div>
    <div class="faq-item"><div class="faq-q">Can I consult astrologers in Hindi? <span class="faq-arrow">▾</span></div><div class="faq-a">Yes! Our platform supports consultations in Hindi, English, Tamil, Telugu, Bengali, Gujarati and many other Indian languages. Filter by language when searching for astrologers.</div></div>
    <div class="faq-item"><div class="faq-q">Is my personal data secure? <span class="faq-arrow">▾</span></div><div class="faq-a">Absolutely. We use industry-standard 256-bit SSL encryption. Your birth data and personal information are never shared with third parties and are used solely for generating your astrological reports.</div></div>
  </div>
</section>

<script>
// Render date
document.getElementById('todayDate').textContent = new Date().toLocaleDateString('en-IN', {weekday:'long', day:'numeric', month:'long', year:'numeric'}) + ' · Jyeshtha Shukla Dashami';

// Rashis
const rashis = [
  {sym:'♈',hi:'मेष',en:'Aries'},{sym:'♉',hi:'वृष',en:'Taurus'},{sym:'♊',hi:'मिथुन',en:'Gemini'},
  {sym:'♋',hi:'कर्क',en:'Cancer'},{sym:'♌',hi:'सिंह',en:'Leo'},{sym:'♍',hi:'कन्या',en:'Virgo'},
  {sym:'♎',hi:'तुला',en:'Libra'},{sym:'♏',hi:'वृश्चिक',en:'Scorpio'},{sym:'♐',hi:'धनु',en:'Sagittarius'},
  {sym:'♑',hi:'मकर',en:'Capricorn'},{sym:'♒',hi:'कुम्भ',en:'Aquarius'},{sym:'♓',hi:'मीन',en:'Pisces'}
];
document.getElementById('rashiGrid').innerHTML = rashis.map(r =>
  `<div class="rashi-card" onclick="location.href='<?= site_url('tools/daily-horoscope') ?>'">
    <span class="rashi-sym">${r.sym}</span>
    <div class="rashi-hi">${r.hi}</div>
    <div class="rashi-en">${r.en}</div>
  </div>`
).join('');



// Plans
const plans = [
  {name:'Seeker',icon:'🌙',tag:'For beginners',price:'299',popular:false,feats:['5 Kundli Reports','2 Chats (10 min)','Daily Horoscope','₹100 Wallet Credit']},
  {name:'Devotee',icon:'⭐',tag:'Most Popular',price:'599',popular:true,feats:['15 Kundli Reports','5 Chats (15 min)','Weekly Horoscope','Kundli Matching','₹300 Credit']},
  {name:'Gold Yogi',icon:'🌟',tag:'Best Value',price:'999',popular:false,feats:['Unlimited Kundli','Unlimited Chats','All Features','₹600 Credit','Free Video/mo']},
  {name:'Brahma',icon:'🔱',tag:'Ultimate',price:'1,999',popular:false,feats:['Everything in Gold','Unlimited Video','24/7 Astrologer','₹1500 Credit']},
];
document.getElementById('homePlansGrid').innerHTML = plans.map(p =>
  `<div class="plan-card ${p.popular?'popular':''}">
    ${p.popular ? '<div class="plan-popular-badge">✦ Most Popular</div>' : ''}
    <div class="plan-icon">${p.icon}</div>
    <div class="plan-name">${p.name}</div>
    <div class="plan-tag">${p.tag}</div>
    <div class="plan-price-row"><span class="plan-curr">₹</span><span class="plan-amt">${p.price}</span></div>
    <div class="plan-period">/month · Cancel anytime</div>
    <ul class="plan-feats">${p.feats.map(f=>`<li>${f}</li>`).join('')}</ul>
    <a href="<?= site_url('plans') ?>" class="btn btn-${p.popular?'primary':'secondary'} w-100">Get Started</a>
  </div>`
).join('');
</script>
