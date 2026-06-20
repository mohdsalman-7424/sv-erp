<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-header">
  <div>
    <div class="page-header-title">🧘 Manage Astrologers</div>
    <div class="page-header-sub">All registered astrologers — verified & pending</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" onclick="exportCSV()">⬇ Export</button>
    <button class="btn btn-primary btn-sm" onclick="openModal('addAstroModal')">+ Add Astrologer</button>
  </div>
</div>

<div class="kpi-grid" style="margin-bottom:20px">
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(34,197,94,0.1)">✅</div><div class="kpi-label">Verified</div><div class="kpi-val" id="kVerified">—</div></div>
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(245,200,66,0.1)">⏳</div><div class="kpi-label">Online Now</div><div class="kpi-val" id="kOnline">—</div></div>
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(200,147,26,0.1)">💰</div><div class="kpi-label">Total Earnings</div><div class="kpi-val" id="kEarnings">—</div></div>
  <div class="kpi-card"><div class="kpi-icon" style="background:rgba(120,86,168,0.1)">⭐</div><div class="kpi-label">Avg Rating</div><div class="kpi-val" id="kRating">—</div></div>
</div>

<!-- Filter Bar -->
<div class="card" style="margin-bottom:16px">
  <div class="card-body" style="padding:14px 18px">
    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
      <div class="table-search" style="flex:1;min-width:200px">
        <span>🔍</span>
        <input type="text" id="astroSearch" placeholder="Search name, email, city..." oninput="filterAstros(this.value)">
      </div>
      <select id="statusFilter" class="filter-select sumo" onchange="filterAstros()">
        <option value="">All Status</option>
        <option value="online">🟢 Online</option>
        <option value="offline">⚫ Offline</option>
      </select>
      <select id="expertiseFilter" class="filter-select sumo" onchange="filterAstros()">
        <option value="">All Expertise</option>
        <option value="Vedic">Vedic Jyotish</option>
        <option value="KP">KP System</option>
        <option value="Tarot">Tarot</option>
        <option value="Vastu">Vastu</option>
        <option value="Nadi">Nadi Jyotish</option>
      </select>
      <button class="btn btn-secondary btn-sm" onclick="clearFilters()">✕ Clear</button>
    </div>
  </div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-body" style="padding:0">
    <div style="overflow-x:auto">
      <table class="data-table" id="astroTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Astrologer</th>
            <th>Expertise</th>
            <th>Languages</th>
            <th>Experience</th>
            <th>Rating</th>
            <th>Chat Rate</th>
            <th>Earnings</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="astroBody"></tbody>
      </table>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px">
      <div style="font-size:12px;color:var(--text-muted)" id="astroCount">Showing all records</div>
      <div class="pagination" id="astroPagination"></div>
    </div>
  </div>
</div>

<!-- ADD MODAL -->
<div class="modal-overlay" id="addAstroModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <div class="modal-title">✦ Add New Astrologer</div>
      <button class="modal-close" onclick="closeModal('addAstroModal')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('admin/save-astrologer') ?>">
      <?= csrf_field() ?>
      <div class="form-grid-2">
        <div class="form-group"><label class="form-label">Full Name <span class="req">*</span></label><input class="form-input" name="name" type="text" placeholder="Pt. Rajesh Sharma" required></div>
        <div class="form-group"><label class="form-label">Email <span class="req">*</span></label><input class="form-input" name="email" type="email" placeholder="rajesh@example.com" required></div>
        <div class="form-group"><label class="form-label">Phone <span class="req">*</span></label><input class="form-input" name="phone" type="tel" placeholder="+91 98765 43210" required></div>
        <div class="form-group"><label class="form-label">City</label><input class="form-input" name="city" type="text" placeholder="Varanasi"></div>
        <div class="form-group"><label class="form-label">Experience (Years)</label><input class="form-input" name="exp" type="number" placeholder="15" min="1" max="60"></div>
        <div class="form-group"><label class="form-label">Rating</label><input class="form-input" name="rating" type="number" step="0.1" value="4.8"></div>
        <div class="form-group"><label class="form-label">Reviews</label><input class="form-input" name="reviews" type="number" value="120"></div>
        <div class="form-group"><label class="form-label">Online Status</label>
          <select class="form-select" name="online"><option value="1">🟢 Online</option><option value="0">⚫ Offline</option></select>
        </div>
        <input type="hidden" name="languages" value="Hindi,English">
        <input type="hidden" name="expertise" value="Vedic Jyotish,KP System">
      </div>
      <div style="display:flex;gap:10px;margin-top:20px">
        <button class="btn btn-secondary" type="button" onclick="closeModal('addAstroModal')">Cancel</button>
        <button class="btn btn-primary" type="submit">✦ Save Astrologer</button>
      </div>
    </form>
  </div>
</div>

<!-- VIEW MODAL -->
<div class="modal-overlay" id="viewAstroModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <div class="modal-title">Astrologer Details</div>
      <button class="modal-close" onclick="closeModal('viewAstroModal')">✕</button>
    </div>
    <div id="viewAstroBody"></div>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal-overlay" id="editAstroModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <div class="modal-title">✎ Edit Astrologer</div>
      <button class="modal-close" onclick="closeModal('editAstroModal')">✕</button>
    </div>
    <form method="POST" action="<?= site_url('admin/save-astrologer') ?>">
      <?= csrf_field() ?>
      <div class="form-grid-2" id="editAstroForm">
        <div class="form-group"><label class="form-label">Full Name</label><input class="form-input" name="name" type="text" id="editName"></div>
        <div class="form-group"><label class="form-label">City</label><input class="form-input" name="city" type="text" id="editCity"></div>
        <div class="form-group"><label class="form-label">Experience (Yrs)</label><input class="form-input" name="exp" type="number" id="editExp"></div>
        <div class="form-group"><label class="form-label">Rating</label><input class="form-input" name="rating" type="number" step="0.1" id="editRating"></div>
        <div class="form-group"><label class="form-label">Reviews</label><input class="form-input" name="reviews" type="number" id="editReviews"></div>
        <div class="form-group"><label class="form-label">Status</label>
          <select class="form-select" name="online" id="editOnline"><option value="1">🟢 Online</option><option value="0">⚫ Offline</option></select>
        </div>
        <input type="hidden" name="languages" value="Hindi,English">
        <input type="hidden" name="expertise" value="Vedic Jyotish,KP System">
      </div>
      <input type="hidden" name="id" id="editAstroId">
      <div style="display:flex;gap:10px;margin-top:20px">
        <button class="btn btn-secondary" type="button" onclick="closeModal('editAstroModal')">Cancel</button>
        <button class="btn btn-primary" type="submit">✦ Update</button>
      </div>
    </form>
  </div>
</div>

<!-- DELETE MODAL -->
<div class="modal-overlay" id="deleteAstroModal">
  <div class="modal" style="max-width:420px;text-align:center">
    <div style="font-size:48px;margin-bottom:12px">⚠️</div>
    <div class="modal-title" style="margin-bottom:8px">Delete Astrologer?</div>
    <p style="font-size:13px;color:var(--text-muted);margin-bottom:22px">This will permanently remove <strong id="deleteAstroName"></strong> from the platform. This action cannot be undone.</p>
    <input type="hidden" id="deleteAstroId">
    <div style="display:flex;gap:10px">
      <button class="btn btn-secondary" style="flex:1" onclick="closeModal('deleteAstroModal')">Cancel</button>
      <button class="btn" style="flex:1;background:#EF4444;color:white" onclick="confirmDeleteAstro()">🗑 Delete</button>
    </div>
  </div>
</div>

<script>
<?php
$formatted_astros = [];
if (!empty($astrologers_db)) {
    $CI =& get_instance();
    $CI->load->model(['user_model', 'user_address_model']);
    foreach ($astrologers_db as $a) {
        $name = 'Astrologer';
        $email = '';
        $phone = '';
        $city = 'Mumbai';
        
        $user = $CI->user_model->get_by_id($a['user_id']);
        if (!empty($user)) {
            $name = $user['name'];
            $email = $user['email'];
            $phone = $user['mobile'];
        }
        
        $address = $CI->user_address_model->get_where(['user_id' => $a['user_id']]);
        if (!empty($address)) $city = $address[0]['city'];

        $formatted_astros[] = [
            'id' => $a['id'],
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'city' => $city,
            'exp' => intval($a['experience_years']),
            'rating' => floatval($a['rating']),
            'reviews' => intval($a['total_reviews']),
            'online' => $a['is_online'] ? true : false,
            'languages' => explode(',', $a['languages']),
            'expertise' => explode(',', $a['expertise']),
            'verified' => $a['approval_status'] === 'approved',
            'chatRate' => 40,
            'videoRate' => 60,
            'earnings' => 15000,
            'avatar' => strtoupper(substr($name, 0, 1))
        ];
    }
}
?>
let allAstros = <?php echo safe_json_for_js($formatted_astros); ?>;

function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

// KPIs
document.getElementById('kVerified').textContent = allAstros.filter(a=>a.verified).length;
document.getElementById('kOnline').textContent   = allAstros.filter(a=>a.online).length;
document.getElementById('kEarnings').textContent = '₹' + allAstros.reduce((s,a)=>s+(a.earnings||0),0).toLocaleString('en-IN');
const avgRating = allAstros.length ? (allAstros.reduce((s,a)=>s+(a.rating||0),0)/allAstros.length).toFixed(2) : '0.00';
document.getElementById('kRating').textContent   = avgRating + ' ⭐';

function renderAstros(list) {
    list = list || allAstros;
    document.getElementById('astroCount').textContent = `Showing ${list.length} of ${allAstros.length} astrologers`;
    document.getElementById('astroBody').innerHTML = list.map((a,i) => `
      <tr data-id="${a.id}">
        <td style="font-size:11px;color:var(--text-muted)">${i+1}</td>
        <td>
          <div style="display:flex;align-items:center;gap:9px">
            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0">${escapeHtml(a.avatar||a.name[0])}</div>
            <div>
              <div style="font-weight:700;font-size:13px">${escapeHtml(a.name)}</div>
              <div style="font-size:10px;color:var(--text-muted)">${escapeHtml(a.city||'—')}</div>
            </div>
          </div>
        </td>
        <td style="max-width:160px">
          <div style="display:flex;flex-wrap:wrap;gap:3px">
            ${(a.expertise||[]).slice(0,2).map(e=>`<span class="tag" style="font-size:9px">${escapeHtml(e)}</span>`).join('')}
            ${(a.expertise||[]).length>2?`<span class="tag" style="font-size:9px">+${(a.expertise||[]).length-2}</span>`:''}
          </div>
        </td>
        <td style="font-size:11px">${escapeHtml((a.languages||[]).join(', '))}</td>
        <td><span class="badge badge-navy">${a.exp} Yrs</span></td>
        <td><span style="color:var(--gold);font-weight:700">⭐ ${a.rating}</span><br><span style="font-size:10px;color:var(--text-muted)">${(a.reviews||0).toLocaleString('en-IN')} reviews</span></td>
        <td style="font-weight:700;color:var(--saffron)">₹${a.chatRate}/min</td>
        <td style="font-weight:700;color:var(--saffron)">₹${(a.earnings||0).toLocaleString('en-IN')}</td>
        <td>${a.online ? '<span class="badge badge-success">● Online</span>' : '<span class="badge badge-warning">⚫ Offline</span>'}</td>
        <td>
          <div style="display:flex;gap:4px;flex-wrap:nowrap">
            <button class="btn-navy btn-sm" onclick="viewAstro('${escapeHtml(a.id)}')" title="View">👁</button>
            <button class="btn-navy btn-sm" style="background:rgba(200,147,26,0.15);color:var(--gold)" onclick="editAstro('${escapeHtml(a.id)}')" title="Edit">✎</button>
            <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteAstro('${escapeHtml(a.id)}','${escapeHtml(a.name)}')" title="Delete">🗑</button>
          </div>
        </td>
      </tr>
    `).join('') || '<tr><td colspan="10" style="text-align:center;padding:24px;color:var(--text-muted)">No astrologers found</td></tr>';
}

function filterAstros(searchVal) {
    const q = (searchVal !== undefined ? searchVal : document.getElementById('astroSearch').value).toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const exp = document.getElementById('expertiseFilter').value;
    let filtered = allAstros.filter(a => {
        const matchQ = !q || a.name.toLowerCase().includes(q) || (a.city||'').toLowerCase().includes(q);
        const matchS = !status || (status==='online'?a.online:!a.online);
        const matchE = !exp || (a.expertise||[]).some(e=>e.includes(exp));
        return matchQ && matchS && matchE;
    });
    renderAstros(filtered);
}

function clearFilters() {
    document.getElementById('astroSearch').value='';
    document.getElementById('statusFilter').value='';
    document.getElementById('expertiseFilter').value='';
    renderAstros();
}

function viewAstro(id) {
    const a = allAstros.find(x => String(x.id) === String(id));
    if (!a) return;
    document.getElementById('viewAstroBody').innerHTML = `
      <div style="display:grid;grid-template-columns:auto 1fr;gap:20px;margin-bottom:22px;align-items:start">
        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-family:'Cinzel',serif;font-size:30px;font-weight:700;border:3px solid var(--gold);box-shadow:0 0 0 4px rgba(200,147,26,0.2)">${a.avatar}</div>
        <div>
          <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;margin-bottom:2px">${a.name}</div>
          <div style="color:var(--text-muted);font-size:12px;margin-bottom:8px">${a.city} · ${a.exp} Years Experience</div>
          <div style="display:flex;gap:8px;flex-wrap:wrap">
            ${a.verified?'<span class="badge badge-success">✅ Verified</span>':'<span class="badge badge-warning">⏳ Pending</span>'}
            ${a.online?'<span class="badge badge-success">● Online</span>':'<span class="badge badge-warning">⚫ Offline</span>'}
            <span class="badge badge-gold">⭐ ${a.rating} (${(a.reviews||0).toLocaleString('en-IN')} reviews)</span>
          </div>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:18px">
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:10px;padding:14px;text-align:center">
          <div style="font-size:10px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Chat Rate</div>
          <div style="font-family:'Cinzel',serif;font-size:20px;font-weight:700;color:var(--saffron)">₹${a.chatRate}/min</div>
        </div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:10px;padding:14px;text-align:center">
          <div style="font-size:10px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Video Rate</div>
          <div style="font-family:'Cinzel',serif;font-size:20px;font-weight:700;color:var(--saffron)">₹${a.videoRate}/min</div>
        </div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:10px;padding:14px;text-align:center">
          <div style="font-size:10px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Total Earnings</div>
          <div style="font-family:'Cinzel',serif;font-size:20px;font-weight:700;color:var(--saffron)">₹${(a.earnings||0).toLocaleString('en-IN')}</div>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:18px">
        <div><div style="font-size:11px;font-weight:700;color:var(--text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Expertise</div>
          <div style="display:flex;flex-wrap:wrap;gap:5px">${(a.expertise||[]).map(e=>`<span class="tag">${e}</span>`).join('')}</div></div>
        <div><div style="font-size:11px;font-weight:700;color:var(--text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Languages</div>
          <div style="display:flex;flex-wrap:wrap;gap:5px">${(a.languages||[]).map(l=>`<span class="tag tag-saf">${l}</span>`).join('')}</div></div>
      </div>
      <div style="display:flex;gap:10px">
        <button class="btn btn-secondary" style="flex:1" onclick="closeModal('viewAstroModal');editAstro('${a.id}')">✎ Edit</button>
        <button class="btn btn-primary" style="flex:1" onclick="toggleOnline('${a.id}',${!a.online})">${a.online?'⚫ Set Offline':'🟢 Set Online'}</button>
        <button class="btn" style="flex:1;background:#EF4444;color:white" onclick="closeModal('viewAstroModal');deleteAstro('${a.id}','${a.name}')">🗑 Delete</button>
      </div>
    `;
    openModal('viewAstroModal');
}

function editAstro(id) {
    const a = allAstros.find(x => String(x.id) === String(id));
    if (!a) return;
    document.getElementById('editAstroId').value   = id;
    document.getElementById('editName').value      = a.name;
    document.getElementById('editCity').value      = a.city||'';
    document.getElementById('editExp').value       = a.exp||0;
    document.getElementById('editRating').value    = a.rating||4.5;
    document.getElementById('editReviews').value   = a.reviews||0;
    document.getElementById('editOnline').value    = a.online ? '1' : '0';
    openModal('editAstroModal');
}

function deleteAstro(id, name) {
    document.getElementById('deleteAstroId').value = id;
    document.getElementById('deleteAstroName').textContent = name;
    openModal('deleteAstroModal');
}

function confirmDeleteAstro() {
    const id = document.getElementById('deleteAstroId').value;
    window.location.href = '<?= site_url("admin/delete-astrologer/") ?>' + id;
}

function toggleOnline(id, status) {
    // MVC action or basic redirect can trigger it. For mock online status toggle, we redirect:
    window.location.href = '<?= site_url("admin/save-astrologer") ?>?id=' + id + '&online=' + (status ? 1 : 0);
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function exportCSV() {
    const rows = [['Name','City','Exp','Rating','Chat Rate','Online']];
    allAstros.forEach(a => rows.push([a.name, a.city, a.exp, a.rating, a.chatRate, a.online?'Yes':'No']));
    const csv = rows.map(r => r.join(',')).join('\n');
    const blob = new Blob([csv], {type:'text/csv'});
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
    a.download = 'astrologers.csv'; a.click();
    toastr.success('CSV exported!');
}

renderAstros();
</script>
