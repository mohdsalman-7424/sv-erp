<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$CI->db->select('referrals.*, users.name as referred_name, users.email as referred_email');
$CI->db->from('referrals');
$CI->db->join('users', 'users.id = referrals.referred_user_id', 'left');
$CI->db->where('referrals.referrer_id', $current_user['id']);
$referrals = $CI->db->get()->result_array();

$total_rewards = 0.00;
foreach ($referrals as $ref) {
    if (strtolower($ref['status']) === 'success' || strtolower($ref['status']) === 'completed') {
        $total_rewards += $ref['reward_amount'];
    }
}
?>

<div class="page-header">
  <div>
    <div class="page-header-title">🎁 Referral Program</div>
    <div class="page-header-sub">Invite your friends to Samriddhi-Ventures and earn ₹50 wallet cash per signup!</div>
  </div>
</div>

<div class="grid-2" style="gap:20px;margin-bottom:20px;align-items:start">
  <!-- Referral Stats -->
  <div class="card">
    <div class="card-body" style="text-align:center;padding:30px 20px">
      <div style="font-size:48px;margin-bottom:12px">🎉</div>
      <div class="cinzel" style="font-size:20px;color:var(--navy);font-weight:700">Invite & Earn</div>
      <p style="color:var(--text-muted);font-size:12px;margin:8px 0 20px 0">Share your unique code. Once they sign up, both of you receive bonus wallet cash.</p>
      
      <div style="background:var(--gold-pale);border:1px dashed var(--gold);padding:14px;border-radius:12px;display:inline-block;margin-bottom:18px">
        <div style="font-size:10px;text-transform:uppercase;color:var(--text-muted);font-weight:700;letter-spacing:1px;margin-bottom:4px">Your Referral Code</div>
        <strong style="font-size:22px;color:var(--navy);font-family:monospace;letter-spacing:2px">SV-REF-<?= $current_user['id'] ?></strong>
      </div>

      <div style="display:flex;justify-content:center;gap:30px;border-top:1px solid var(--border);padding-top:18px">
        <div>
          <div style="font-size:20px;font-weight:800;color:var(--navy)"><?= count($referrals) ?></div>
          <div style="font-size:10px;color:var(--text-muted)">Total Referrals</div>
        </div>
        <div style="width:1px;background:var(--border)"></div>
        <div>
          <div style="font-size:20px;font-weight:800;color:var(--saffron)">₹<?= number_format($total_rewards, 2) ?></div>
          <div style="font-size:10px;color:var(--text-muted)">Rewards Earned</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Referral List -->
  <div class="card">
    <div class="card-body">
      <div class="card-title">My Referrals</div>
      <div class="table-responsive">
        <table class="data-table">
          <thead>
            <tr>
              <th>Friend Name</th>
              <th>Date</th>
              <th>Reward</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($referrals)): ?>
              <?php foreach ($referrals as $ref): ?>
                <tr>
                  <td>
                    <strong style="color:var(--navy)"><?= html_escape($ref['referred_name'] ?: 'N/A') ?></strong>
                    <div style="font-size:9px;color:var(--text-muted)"><?= html_escape($ref['referred_email']) ?></div>
                  </td>
                  <td><?= date('d M Y', strtotime($ref['created_at'])) ?></td>
                  <td><strong>₹<?= number_format($ref['reward_amount'], 2) ?></strong></td>
                  <td>
                    <?php if (strtolower($ref['status']) === 'success' || strtolower($ref['status']) === 'completed'): ?>
                      <span class="badge badge-success">Completed</span>
                    <?php else: ?>
                      <span class="badge badge-warning"><?= ucfirst(html_escape($ref['status'])) ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="text-align:center;color:var(--text-muted);padding:30px 10px;">
                  No referrals yet. Start sharing your code to earn rewards!
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
