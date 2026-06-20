<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
</main>

<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-logo">ॐ Samriddhi-Ventures</div>
        <p class="footer-desc">India's most trusted Vedic astrology platform, connecting seekers with certified experts for authentic cosmic guidance since 2015.</p>
        <div class="footer-social">
          <button class="footer-soc-btn" onclick="toastr.info('Follow us on Facebook!')">f</button>
          <button class="footer-soc-btn" onclick="toastr.info('Follow us on Twitter!')">𝕏</button>
          <button class="footer-soc-btn" onclick="toastr.info('Connect on LinkedIn!')">in</button>
          <button class="footer-soc-btn" onclick="toastr.info('Subscribe on YouTube!')">▶</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Services</div>
        <ul class="footer-links">
          <li><a href="<?= site_url('tools/kundali-generator') ?>">Janam Kundli</a></li>
          <li><a href="<?= site_url('tools/daily-horoscope') ?>">Daily Horoscope</a></li>
          <li><a href="<?= site_url('tools/kundali-matching') ?>">Match Making</a></li>
          <li><a href="<?= site_url('tools/panchang') ?>">Panchang</a></li>
          <li><a href="<?= site_url('tools/muhurat') ?>">Muhurat</a></li>
          <li><a href="<?= site_url('tools/shop') ?>">Gemstone Shop</a></li>
        </ul>
      </div>
      <div>
        <div class="footer-col-title">Company</div>
        <ul class="footer-links">
          <li><a href="<?= site_url('about') ?>">About Us</a></li>
          <li><a href="<?= site_url('contact') ?>">Contact Us</a></li>
          <li><a href="<?= site_url('blog') ?>">Blog</a></li>
          <li><a href="<?= site_url('careers') ?>">Careers</a></li>
          <li><a href="<?= site_url('astrologers') ?>">Our Astrologers</a></li>
          <li><a href="<?= site_url('plans') ?>">Pricing Plans</a></li>
        </ul>
      </div>
      <div>
        <div class="footer-col-title">Legal</div>
        <ul class="footer-links">
          <li><a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a></li>
          <li><a href="<?= site_url('terms') ?>">Terms of Service</a></li>
          <li><a href="<?= site_url('refund-policy') ?>">Refund Policy</a></li>
        </ul>
        <div style="margin-top:16px">
          <div class="footer-col-title">Contact</div>
          <ul class="footer-links">
            <li><span>support@samriddhi-ventures.in</span></li>
            <li><span>+91 98765 43210</span></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <?= date('Y') ?> Samriddhi-Ventures Pvt. Ltd. All rights reserved.</p>
      <p>🔒 SSL Secured · Razorpay · UPI · Paytm</p>
    </div>
  </div>
</footer>

<div id="toast-container"></div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- SumoSelect -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.3/jquery.sumoselect.min.js"></script>
<!-- App JS -->
<script src="<?= base_url('assets/js/store.js') ?>"></script>
<script src="<?= base_url('assets/js/core.js') ?>"></script>
<script src="<?= base_url('assets/js/notification.js') ?>"></script>
<script src="<?= base_url('assets/js/ajax.js') ?>"></script>
<script src="<?= base_url('assets/js/datatable.js') ?>"></script>
<script>
// Toastr defaults
toastr.options = { positionClass:'toast-bottom-right', timeOut:3500, progressBar:true, closeButton:true };
// Init SumoSelect
$(document).ready(function(){ $('select.sumo').SumoSelect({ placeholder:'Select option...', search:true }); });
// Init Flatpickr date inputs
flatpickr('.datepicker', { dateFormat:'d M Y', allowInput:true });
flatpickr('.datetimepicker', { enableTime:true, dateFormat:'d M Y H:i', allowInput:true });
flatpickr('.timepicker', { enableTime:true, noCalendar:true, dateFormat:'H:i', allowInput:true });
</script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
