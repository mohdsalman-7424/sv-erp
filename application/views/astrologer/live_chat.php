<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$CI =& get_instance();
$astro_id = !empty($current_astro) ? $current_astro['id'] : 0;

$CI->db->select('consultations.*, users.name as user_name');
$CI->db->from('consultations');
$CI->db->join('users', 'users.id = consultations.user_id');
$CI->db->where('consultations.astrologer_id', $astro_id);
$CI->db->where('consultations.consultation_type', 'chat');
$chats = $CI->db->get()->result_array();
?>

<div class="page-header">
  <div>
    <div class="page-header-title">💬 Live Consultation Chat</div>
    <div class="page-header-sub">Engage in spiritual and astrological counseling with active seekers</div>
  </div>
</div>

<div class="card" style="padding:0;overflow:hidden">
  <div style="display:grid;grid-template-columns: 280px 1fr;min-height:500px">
    
    <!-- Left Sidebar: Active Seekers -->
    <div style="border-right:1px solid var(--border);background:var(--gold-pale);padding:14px">
      <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px">Active Seekers</div>
      <?php if (!empty($chats)): ?>
        <div style="display:flex;flex-direction:column;gap:8px">
          <?php foreach ($chats as $idx => $c): ?>
            <div onclick="selectChat(<?= $idx ?>, '<?= html_escape($c['user_name']) ?>')" style="padding:10px 12px;border:1px solid var(--border);background:white;border-radius:8px;cursor:pointer;transition:all .2s;" class="chat-selector-item" id="chat-item-<?= $idx ?>">
              <strong style="color:var(--navy);font-size:13px"><?= html_escape($c['user_name']) ?></strong>
              <div style="font-size:10px;color:var(--text-muted);margin-top:2px">Scheduled: <?= date('d M, h:i A', strtotime($c['scheduled_at'])) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div style="text-align:center;color:var(--text-muted);font-size:12px;padding:30px 10px;">No scheduled chat consultations.</div>
      <?php endif; ?>
    </div>

    <!-- Right Window: Chat Feed -->
    <div style="display:flex;flex-direction:column;background:white">
      <!-- Header -->
      <div style="padding:14px 20px;border-bottom:1px solid var(--border);background:var(--navy);color:white;display:flex;align-items:center;justify-content:between">
        <div>
          <strong style="font-size:14px" id="activeChatUser">Select a Seeker</strong>
          <div style="font-size:10px;color:rgba(255,255,255,0.4)">Cosmic Chat Connection Active</div>
        </div>
      </div>

      <!-- Feed -->
      <div style="flex-grow:1;padding:20px;overflow-y:auto;background:#fcfbf9;display:flex;flex-direction:column;gap:12px;" id="chatFeed">
        <div style="margin:auto;text-align:center;color:var(--text-muted);font-size:13px">
          🧘 Select an active seeker from the left sidebar to start consultation.
        </div>
      </div>

      <!-- Footer Input -->
      <div style="padding:14px;border-top:1px solid var(--border);display:flex;gap:10px;background:white">
        <input type="text" id="chatInput" placeholder="Analyze charts, type remedies here..." style="flex-grow:1;padding:10px 14px;border:1px solid var(--border);border-radius:8px;outline:none;font-size:13px" disabled>
        <button class="btn btn-primary" id="chatSendBtn" onclick="sendMessage()" disabled style="padding:10px 20px">Send ✦</button>
      </div>
    </div>

  </div>
</div>

<script>
let activeSelectorIdx = null;

function selectChat(idx, userName) {
  activeSelectorIdx = idx;
  document.querySelectorAll('.chat-selector-item').forEach(el => el.classList.remove('active'));
  document.getElementById('chat-item-' + idx).classList.add('active');
  
  document.getElementById('activeChatUser').textContent = userName;
  document.getElementById('chatInput').removeAttribute('disabled');
  document.getElementById('chatSendBtn').removeAttribute('disabled');

  // Load chat simulation
  const feed = document.getElementById('chatFeed');
  feed.innerHTML = '';
  const startBanner = document.createElement('div');
  startBanner.style.cssText = 'background:rgba(200,147,26,0.08);border:1px solid rgba(200,147,26,0.1);border-radius:8px;padding:10px 14px;font-size:12px;color:var(--gold);text-align:center;';
  startBanner.textContent = '✨ Consultation started with ' + userName + ' at ' + new Date().toLocaleTimeString() + ' ✨';
  feed.appendChild(startBanner);

  const userMsg = document.createElement('div');
  userMsg.style.cssText = 'align-self:flex-start;background:#fff;border:1px solid var(--border);padding:10px 14px;border-radius:12px;max-width:70%;font-size:13px;line-height:1.5;color:var(--text-mid)';
  const userLabel = document.createElement('strong');
  userLabel.style.cssText = 'color:var(--navy);font-size:11px;display:block;margin-bottom:2px';
  userLabel.textContent = userName;
  userMsg.appendChild(userLabel);
  userMsg.appendChild(document.createTextNode('Pranam Guru ji. I wanted to ask about my career progression. Am undergoing Rahu Mahadasha right now.'));
  feed.appendChild(userMsg);
}

function sendMessage() {
  const inp = document.getElementById('chatInput');
  const msg = inp.value.trim();
  if (!msg) return;

  const feed = document.getElementById('chatFeed');
  
  // Add my message
  const myMsg = document.createElement('div');
  myMsg.style.alignSelf = 'flex-end';
  myMsg.style.background = 'var(--navy)';
  myMsg.style.color = 'white';
  myMsg.style.padding = '10px 14px';
  myMsg.style.borderRadius = '12px';
  myMsg.style.maxWidth = '70%';
  myMsg.style.fontSize = '13px';
  myMsg.style.lineHeight = '1.5';
  const label = document.createElement('strong');
  label.style.color = 'var(--gold-bright)';
  label.style.fontSize = '11px';
  label.style.display = 'block';
  label.style.marginBottom = '2px';
  label.textContent = 'You';
  myMsg.appendChild(label);
  myMsg.appendChild(document.createTextNode(msg));
  feed.appendChild(myMsg);
  
  inp.value = '';
  feed.scrollTop = feed.scrollHeight;

  // Simulate response after 1.5s
  setTimeout(() => {
    const resMsg = document.createElement('div');
    resMsg.style.alignSelf = 'flex-start';
    resMsg.style.background = '#fff';
    resMsg.style.border = '1px solid var(--border)';
    resMsg.style.padding = '10px 14px';
    resMsg.style.borderRadius = '12px';
    resMsg.style.maxWidth = '70%';
    resMsg.style.fontSize = '13px';
    resMsg.style.lineHeight = '1.5';
    resMsg.style.color = 'var(--text-mid)';
    resMsg.innerHTML = `<strong style="color:var(--navy);font-size:11px;display:block;margin-bottom:2px">${document.getElementById('activeChatUser').textContent}</strong> Dhanyawad for this remedy, Guru ji! I will practice it starting Saturday.`;
    feed.appendChild(resMsg);
    feed.scrollTop = feed.scrollHeight;
  }, 1500);
}
</script>
