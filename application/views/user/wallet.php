<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->load->model(['wallet_model', 'wallet_transaction_model']);
$wallet = $CI->wallet_model->get_where(['user_id' => $current_user['id']]);
$balance = !empty($wallet) ? $wallet[0]['balance'] : 0.00;
$transactions = [];
if (!empty($wallet)) {
    $transactions = $CI->wallet_transaction_model->get_where(['wallet_id' => $wallet[0]['id']]);
    usort($transactions, function($a, $b) {
        return $b['id'] - $a['id'];
    });
    // Slice first 5
    $transactions = array_slice($transactions, 0, 5);
}
?>

<div class="page-header">
  <div>
    <div class="page-header-title">👛 My Wallet</div>
    <div class="page-header-sub">Add money and manage your consultant credits</div>
  </div>
</div>

<div class="grid-2" style="gap:20px;margin-bottom:20px;align-items:start">
  <!-- Wallet Balance & Recharge Card -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Wallet Recharge</div>
      
      <div class="wallet-card" style="margin-bottom:20px">
        <div style="font-size:11px;color:rgba(255,255,255,0.45);letter-spacing:1px;text-transform:uppercase;margin-bottom:6px">Available Balance</div>
        <div class="wallet-balance">₹<?= number_format($balance, 2) ?></div>
        <div style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:4px">Use for chats, calls, or matching reports</div>
      </div>

      <form method="POST" action="<?= site_url('user/recharge-wallet') ?>">
        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Select Amount (₹)</label>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:14px">
            <button type="button" class="filter-chip" onclick="setAmountInput(200)">₹200</button>
            <button type="button" class="filter-chip active" onclick="setAmountInput(500)">₹500</button>
            <button type="button" class="filter-chip" onclick="setAmountInput(1000)">₹1,000</button>
          </div>
        </div>

        <div class="form-group" style="margin-bottom:18px">
          <label class="form-label">Custom Amount (₹)</label>
          <input class="form-input" type="number" name="amount" id="mainRechargeAmt" value="500" min="50" required>
        </div>

        <div class="form-group" style="margin-bottom:18px">
          <label class="form-label">Payment Mode</label>
          <div style="display:flex;gap:10px">
            <label class="filter-chip active" style="flex:1;text-align:center;cursor:pointer">
              <input type="radio" name="payment_mode" value="upi" checked style="display:none"> UPI
            </label>
            <label class="filter-chip" style="flex:1;text-align:center;cursor:pointer">
              <input type="radio" name="payment_mode" value="card" style="display:none"> Card
            </label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Money to Wallet ✦</button>
      </form>
    </div>
  </div>

  <!-- Recent Wallet Transactions -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">Recent Wallet Txns <a href="<?= site_url('user/transactions') ?>">View All →</a></div>
      <?php if (!empty($transactions)): ?>
        <?php foreach ($transactions as $txn): ?>
          <div class="activity-item" style="padding:10px 0;border-bottom:1px solid var(--border)">
            <div class="act-dot" style="background: <?= strtolower($txn['credit_debit']) === 'credit' ? 'rgba(34,197,94,0.1)' : 'rgba(239,68,68,0.1)' ?>">
              <?= strtolower($txn['credit_debit']) === 'credit' ? '📥' : '📤' ?>
            </div>
            <div style="flex-grow:1">
              <div class="act-text" style="font-weight:600"><?= html_escape($txn['remark']) ?></div>
              <div class="act-time"><?= date('d M Y, h:i A', strtotime($txn['created_at'])) ?></div>
            </div>
            <div>
              <strong style="color: <?= strtolower($txn['credit_debit']) === 'credit' ? 'rgb(34,197,94)' : 'rgb(239,68,68)' ?>">
                <?= strtolower($txn['credit_debit']) === 'credit' ? '+' : '-' ?> ₹<?= number_format($txn['amount'], 2) ?>
              </strong>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="text-align:center;color:var(--text-muted);padding:30px 10px;">
          No transactions yet.
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function setAmountInput(amt) {
  document.getElementById('mainRechargeAmt').value = amt;
  // highlight chip
  document.querySelectorAll('.filter-chip').forEach(c => {
    if (c.textContent.includes(amt.toLocaleString())) {
      c.classList.add('active');
    } else {
      c.classList.remove('active');
    }
  });
}
</script>
