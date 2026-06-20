<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;

$completed_count = $CI->db->where(['astrologer_id' => $astro_id, 'status' => 'completed'])->count_all_results('consultations');
$unpaid_balance = $completed_count * 350.00;
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🏦 Bank Withdrawals</div>
    <div class="page-header-sub">Request settlements and transfer your consultation earnings to your bank account</div>
  </div>
  <div class="page-header-actions">
    <div style="background:var(--navy);color:white;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:700">
      Available Balance: <span style="color:var(--gold-bright)">₹<?= number_format($unpaid_balance, 2) ?></span>
    </div>
  </div>
</div>

<div class="grid-2" style="gap:20px;align-items:start">
  
  <!-- Withdrawal Form -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Request Withdrawal</div>
      
      <form id="withdrawalForm" class="ajax-form" method="POST" action="<?= site_url('astrologer/request-withdrawal') ?>">
        <?= csrf_field() ?>
        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Withdrawal Amount (₹) <span class="req">*</span></label>
          <input class="form-input" type="number" name="amount" min="100" max="<?= $unpaid_balance ?>" placeholder="Enter amount to withdraw" required>
          <small style="color:var(--text-muted)">Minimum withdrawal amount is ₹100.00.</small>
        </div>

        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Beneficiary Account Name <span class="req">*</span></label>
          <input class="form-input" type="text" name="account_name" placeholder="Pt. Rajesh Sharma" required>
        </div>

        <div class="form-grid-2" style="margin-bottom:18px">
          <div class="form-group">
            <label class="form-label">Bank Account Number <span class="req">*</span></label>
            <input class="form-input" type="text" name="account_no" placeholder="50100239485" required>
          </div>
          <div class="form-group">
            <label class="form-label">IFSC Code <span class="req">*</span></label>
            <input class="form-input" type="text" name="ifsc_code" placeholder="HDFC0000123" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100" <?= $unpaid_balance < 100 ? 'disabled' : '' ?>>
          Request Settlement Payout ✦
        </button>
      </form>
    </div>
  </div>

  <!-- Payout Ledger (Mock details) -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Withdrawal Requests Status</div>
      <table class="data-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Account</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="4" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
              No recent withdrawal requests logged.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if ($.isFunction($.fn.validate)) {
    $('#withdrawalForm').validate({
      rules: {
        amount: { required: true, number: true, min: 100, max: <?= floatval($unpaid_balance) ?> },
        account_name: { required: true, minlength: 3 },
        account_no: { required: true, minlength: 9 },
        ifsc_code: { required: true, minlength: 11 }
      }
    });
  }
});
</script>
