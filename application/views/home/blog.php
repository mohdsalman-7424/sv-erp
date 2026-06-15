<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:960px">
    
    <div class="text-center" style="margin-bottom:40px">
      <div class="sec-label">✦ Knowledge Center</div>
      <h1 class="cinzel" style="color:var(--navy);font-size:clamp(28px,5vw,44px);margin-bottom:12px">Sacred Wisdom & Articles</h1>
      <p style="color:var(--text-mid);font-size:16px;max-width:600px;margin:0 auto">Read articles written by Vedic astrologers detailing horoscopes, transit impacts, and yogas.</p>
    </div>

    <!-- Articles Grid -->
    <div style="display:grid;grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));gap:24px;margin-bottom:40px">
      
      <!-- Article 1 -->
      <div class="card" style="border:1px solid var(--border);border-radius:12px;overflow:hidden;cursor:pointer" onclick="location.href='<?= site_url('home/blog-detail/understanding-janam-kundli') ?>'">
        <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));color:white;padding:50px 20px;text-align:center;font-size:36px;position:relative">
          🔭
          <span style="position:absolute;bottom:10px;right:10px;font-size:10px;background:var(--saffron);color:white;padding:2px 8px;border-radius:4px;font-weight:700">GUIDE</span>
        </div>
        <div class="card-body">
          <h3 class="cinzel" style="color:var(--navy);font-size:15px;margin-bottom:8px">Understanding Your Janam Kundli: A Complete Guide for Beginners</h3>
          <p style="font-size:12px;color:var(--text-muted);line-height:1.6;margin-bottom:14px">Learn how to read houses (Bhavas), planet placements, and rising ascendants (Lagna) in Vedic charts...</p>
          <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;color:var(--text-muted)">
            <span>Pt. Rajesh Sharma</span>
            <span>June 3, 2026</span>
          </div>
        </div>
      </div>

      <!-- Article 2 -->
      <div class="card" style="border:1px solid var(--border);border-radius:12px;overflow:hidden;cursor:pointer" onclick="location.href='<?= site_url('home/blog-detail/saturn-return-remedies') ?>'">
        <div style="background:linear-gradient(135deg,#7C3AED,#A855F7);color:white;padding:50px 20px;text-align:center;font-size:36px;position:relative">
          🪐
          <span style="position:absolute;bottom:10px;right:10px;font-size:10px;background:var(--saffron);color:white;padding:2px 8px;border-radius:4px;font-weight:700">PLANETS</span>
        </div>
        <div class="card-body">
          <h3 class="cinzel" style="color:var(--navy);font-size:15px;margin-bottom:8px">Saturn's Return & Sade Sati: Mitigate Adverse Transit Effects</h3>
          <p style="font-size:12px;color:var(--text-muted);line-height:1.6;margin-bottom:14px">Discover traditional remedies, mantras, and charity options to appease Lord Shani during testing transits...</p>
          <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;color:var(--text-muted)">
            <span>Dr. Deepa Verma</span>
            <span>May 28, 2026</span>
          </div>
        </div>
      </div>

      <!-- Article 3 -->
      <div class="card" style="border:1px solid var(--border);border-radius:12px;overflow:hidden;cursor:pointer" onclick="location.href='<?= site_url('home/blog-detail/best-marriage-muhurats-2026') ?>'">
        <div style="background:linear-gradient(135deg,#B45309,#D97706);color:white;padding:50px 20px;text-align:center;font-size:36px;position:relative">
          💍
          <span style="position:absolute;bottom:10px;right:10px;font-size:10px;background:var(--saffron);color:white;padding:2px 8px;border-radius:4px;font-weight:700">MUHURAT</span>
        </div>
        <div class="card-body">
          <h3 class="cinzel" style="color:var(--navy);font-size:15px;margin-bottom:8px">Best Auspicious Vivah Muhurats in the Year 2026</h3>
          <p style="font-size:12px;color:var(--text-muted);line-height:1.6;margin-bottom:14px">A comprehensive calendar analyzing Guru and Shukra Tara timings for wedding dates...</p>
          <div style="display:flex;justify-content:space-between;align-items:center;font-size:11px;color:var(--text-muted)">
            <span>AstroVeda Team</span>
            <span>May 15, 2026</span>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
