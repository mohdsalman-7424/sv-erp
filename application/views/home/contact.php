<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="section" style="background:var(--bg-primary)">
  <div class="container" style="max-width:960px">
    
    <div class="text-center" style="margin-bottom:50px">
      <div class="sec-label">✦ Contact Us</div>
      <h1 class="cinzel" style="color:var(--navy);font-size:clamp(28px,5vw,44px);margin-bottom:12px">Get in Touch</h1>
      <p style="color:var(--text-mid);font-size:16px;max-width:600px;margin:0 auto">Have questions about subscription plans, custom horoscopes, or enterprise integrations? Drop us a message.</p>
    </div>

    <div style="display:grid;grid-template-columns: 1fr 1.2fr;gap:40px;align-items:start" class="grid-2">
      <!-- Contact details -->
      <div style="display:flex;flex-direction:column;gap:20px">
        <div class="card" style="background:var(--gold-pale);border:1px solid var(--border)">
          <div class="card-body">
            <h3 class="cinzel" style="color:var(--navy);margin-bottom:12px;font-size:16px">📍 Corporate Head Office</h3>
            <p style="font-size:13px;color:var(--text-mid);line-height:1.6">
              Samriddhi-Ventures Private Limited<br>
              702, Cosmic Tower, Bandra Kurla Complex (BKC)<br>
              Mumbai, Maharashtra - 400051<br>
              India
            </p>
          </div>
        </div>

        <div class="card" style="background:var(--gold-pale);border:1px solid var(--border)">
          <div class="card-body">
            <h3 class="cinzel" style="color:var(--navy);margin-bottom:12px;font-size:16px">📧 Email Support</h3>
            <p style="font-size:13px;color:var(--text-mid);line-height:1.6">
              General Inquiries: <a href="mailto:info@astroveda.in" style="color:var(--gold)">info@astroveda.in</a><br>
              Technical Helpdesk: <a href="mailto:support@astroveda.in" style="color:var(--gold)">support@astroveda.in</a>
            </p>
          </div>
        </div>

        <div class="card" style="background:var(--gold-pale);border:1px solid var(--border)">
          <div class="card-body">
            <h3 class="cinzel" style="color:var(--navy);margin-bottom:12px;font-size:16px">📞 Telephone Hotlines</h3>
            <p style="font-size:13px;color:var(--text-mid);line-height:1.6">
              Toll-Free (India): +91 1800-419-8800<br>
              Support Hours: 9:00 AM - 6:00 PM (IST), Mon - Sat
            </p>
          </div>
        </div>
      </div>

      <!-- Message Form -->
      <div class="card">
        <div class="card-body">
          <h3 class="cinzel" style="color:var(--navy);margin-bottom:18px;font-size:18px">Send Us a Message</h3>
          
          <form method="POST" action="#" onsubmit="alert('Thank you for contacting us! Our team will get back to you within 24 hours.'); return false;">
            <div class="form-group" style="margin-bottom:14px">
              <label class="form-label">Full Name <span class="req">*</span></label>
              <input class="form-input" type="text" placeholder="Enter your name" required>
            </div>

            <div class="form-group" style="margin-bottom:14px">
              <label class="form-label">Email Address <span class="req">*</span></label>
              <input class="form-input" type="email" placeholder="you@example.com" required>
            </div>

            <div class="form-group" style="margin-bottom:14px">
              <label class="form-label">Query Subject</label>
              <input class="form-input" type="text" placeholder="e.g. Plan Upgrade Issue">
            </div>

            <div class="form-group" style="margin-bottom:18px">
              <label class="form-label">Message Details <span class="req">*</span></label>
              <textarea class="form-input" rows="5" placeholder="Write your comments or questions..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Message ✦</button>
          </form>
        </div>
      </div>
    </div>

  </div>
</section>
