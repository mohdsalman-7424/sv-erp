<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model(['wallet_model', 'wallet_transaction_model']);
$wallet = $CI->wallet_model->get_where(['user_id' => $current_user['id']]);
$transactions = [];
$balance = 0.00;
if (!empty($wallet)) {
    $balance = $wallet[0]['balance'];
    $transactions = $CI->wallet_transaction_model->get_where(['wallet_id' => $wallet[0]['id']]);
    usort($transactions, function($a, $b) {
        return $b['id'] - $a['id'];
    });
}
?>

<div class="page-header">
  <div>
    <div class="page-header-title">💸 Wallet Ledger</div>
    <div class="page-header-sub">Track all credits and debits to your platform wallet balance</div>
  </div>
  <div class="page-header-actions">
    <div style="background:var(--navy);color:white;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:700">
      Current Balance: <span style="color:var(--gold-bright)">₹<?= number_format($balance, 2) ?></span>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="card-title">Transaction History</div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Txn ID</th>
            <th>Date & Time</th>
            <th>Type</th>
            <th>Remark</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($transactions)): ?>
            <?php foreach ($transactions as $txn): ?>
              <tr>
                <td><strong style="color:var(--text-muted)">#TXN-<?= $txn['id'] ?></strong></td>
                <td><?= date('d M Y, h:i A', strtotime($txn['created_at'])) ?></td>
                <td>
                  <?php if (strtolower($txn['credit_debit']) === 'credit'): ?>
                    <span class="badge badge-success" style="background:rgba(34,197,94,0.1);color:rgb(34,197,94);">CREDIT</span>
                  <?php else: ?>
                    <span class="badge badge-danger" style="background:rgba(239,68,68,0.1);color:rgb(239,68,68);">DEBIT</span>
                  <?php endif; ?>
                </td>
                <td><?= html_escape($txn['remark']) ?></td>
                <td>
                  <strong style="color: <?= strtolower($txn['credit_debit']) === 'credit' ? 'rgb(34,197,94)' : 'rgb(239,68,68)' ?>">
                    <?= strtolower($txn['credit_debit']) === 'credit' ? '+' : '-' ?> ₹<?= number_format($txn['amount'], 2) ?>
                  </strong>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                No wallet transactions found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
