<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model('invoice_model');
$invoices = $CI->invoice_model->get_where(['user_id' => $current_user['id']]);
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🧾 My Invoices</div>
    <div class="page-header-sub">View and download your invoices for subscription renewals and consultations</div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Billing History</div>
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Date</th>
            <th>Base Amount</th>
            <th>GST (18%)</th>
            <th>Total Paid</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($invoices)): ?>
            <?php foreach ($invoices as $inv): ?>
              <tr>
                <td><strong style="color:var(--navy)"><?= html_escape($inv['invoice_no']) ?></strong></td>
                <td><?= date('d M Y', strtotime($inv['created_at'])) ?></td>
                <td>₹<?= number_format($inv['amount'], 2) ?></td>
                <td>₹<?= number_format($inv['gst'], 2) ?></td>
                <td><strong style="color:var(--saffron)">₹<?= number_format($inv['total'], 2) ?></strong></td>
                <td>
                  <?php if (strtolower($inv['payment_status']) === 'paid' || strtolower($inv['payment_status']) === 'success'): ?>
                    <span class="badge badge-success">Paid</span>
                  <?php else: ?>
                    <span class="badge badge-warning"><?= html_escape($inv['payment_status']) ?></span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No invoices found in your billing history.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
