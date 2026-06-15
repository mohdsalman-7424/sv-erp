<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$title = "Understanding Your Janam Kundli: A Complete Guide";
$author = "Pt. Rajesh Sharma";
$date = "June 3, 2026";
$content = "A Janam Kundli, or birth chart, is a map of the heavens at the precise moment of your birth. In Vedic Astrology, it acts as a cosmic blueprint of your life's journey, mapping out karmic lessons, strengths, and challenges. To read a basic Kundli, you need to look at three primary variables: the rising sign or Ascendant (Lagna), the placement of the nine major planets in the twelve Houses (Bhavas), and the current active planetary periods (Dashas). Understading how these forces interact provides unmatched clarity.";

if ($slug === 'saturn-return-remedies') {
    $title = "Saturn's Return & Sade Sati: Mitigate Adverse Transit Effects";
    $author = "Dr. Deepa Verma";
    $date = "May 28, 2026";
    $content = "Lord Shani or Saturn represents discipline, labor, and cosmic justice. When Saturn transits over the 12th, 1st, and 2nd houses from your natal Moon, it initiates the 7.5-year cycle known as Sade Sati. While often feared, this transit is meant to purify past karma and teach valuable lifepaths. Traditional remedies include reciting the Shani Gayatri Mantra, lighting mustard oil lamps on Saturdays under a Peepal tree, and volunteering service to support marginalized sections of society.";
} elseif ($slug === 'best-marriage-muhurats-2026') {
    $title = "Best Auspicious Vivah Muhurats in the Year 2026";
    $author = "AstroVeda Team";
    $date = "May 15, 2026";
    $content = "Vivah Muhurat is calculated based on Panchang parameters to ensure that couples marry during a time when beneficial planetary energies are maximized. For 2026, major auspicious marriage dates fall in the months of January, February, May, November, and December. It is vital to ensure that neither Venus (Shukra) nor Jupiter (Guru) are in combustion (Tara Asta) during the ceremony, as they rule marital harmony and wisdom respectively.";
}
?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:760px">
    
    <!-- Breadcrumb -->
    <div style="font-size:12px;color:var(--text-muted);margin-bottom:20px">
      <a href="<?= site_url('/') ?>" style="color:var(--text-muted)">Home</a> &nbsp;»&nbsp; 
      <a href="<?= site_url('blog') ?>" style="color:var(--text-muted)">Blog</a> &nbsp;»&nbsp; 
      <span>Article Details</span>
    </div>

    <!-- Article Header -->
    <h1 class="cinzel" style="color:var(--navy);font-size:clamp(24px,4.5vw,36px);line-height:1.3;margin-bottom:14px">
      <?= html_escape($title) ?>
    </h1>

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;border-bottom:1px solid var(--border);padding-bottom:14px">
      <div style="width:36px;height:36px;border-radius:50%;background:var(--gold);color:white;display:flex;align-items:center;justify-content:center;font-weight:700">
        <?= strtoupper(substr($author, 0, 1)) ?>
      </div>
      <div>
        <div style="font-size:12px;font-weight:700;color:var(--navy)"><?= html_escape($author) ?></div>
        <div style="font-size:10px;color:var(--text-muted)">Published on <?= html_escape($date) ?> · 6 Min Read</div>
      </div>
    </div>

    <!-- Article Body -->
    <div style="font-size:15px;color:var(--text-mid);line-height:1.8;margin-bottom:34px">
      <p style="margin-bottom:20px"><?= html_escape($content) ?></p>
      
      <blockquote style="border-left:4px solid var(--gold);padding-left:18px;margin:30px 0;font-style:italic;color:var(--navy);font-family:'Playfair Display',serif;font-size:17px">
        "The stars govern our tendencies, but a wise soul governs the stars."
      </blockquote>

      <p style="margin-bottom:20px">
        For a deep and personalized reading of these transits in your own chart, consider generating a detailed Kundli report or scheduling a live consultation session with our verified experts.
      </p>
    </div>

    <!-- Call to action card -->
    <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:12px;padding:24px;text-align:center">
      <h3 class="cinzel" style="color:var(--navy);font-size:16px;margin-bottom:8px">Get Your Detailed Astro Report</h3>
      <p style="font-size:12px;color:var(--text-mid);margin-bottom:18px">Generate a premium 50+ page Janam Kundli report mapping your lifetime transits and dosha analysis.</p>
      <a href="<?= site_url('auth/register') ?>" class="btn btn-primary btn-sm">Get Free Kundli ✦</a>
    </div>

  </div>
</section>
