<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-header">
  <div>
    <div class="page-header-title">🧘 Manage Astrologers</div>
    <div class="page-header-sub">All registered astrologers — verified & pending</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-secondary btn-sm" id="btnExportAstros">⬇ Export</button>
    <button class="btn btn-primary btn-sm" onclick="openAddAstroModal()">+ Add Astrologer</button>
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
        <input type="text" id="astroSearch" placeholder="Search name, email, city...">
      </div>
      <select id="statusFilter" class="filter-select sumo">
        <option value="">All Status</option>
        <option value="online">🟢 Online</option>
        <option value="offline">⚫ Offline</option>
      </select>
      <select id="expertiseFilter" class="filter-select sumo">
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
            <th data-sortable="true" data-field="name">Astrologer</th>
            <th data-sortable="true" data-field="expertise">Expertise</th>
            <th data-sortable="true" data-field="languages">Languages</th>
            <th data-sortable="true" data-field="exp">Experience</th>
            <th data-sortable="true" data-field="rating">Rating</th>
            <th data-sortable="true" data-field="chatRate">Chat Rate</th>
            <th data-sortable="true" data-field="earnings">Earnings</th>
            <th data-sortable="true" data-field="online">Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="astroBody">
          <tr>
            <td colspan="10" style="text-align:center;padding:24px;color:var(--text-muted)">Loading astrologers...</td>
          </tr>
        </tbody>
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
    <form id="addAstroForm" class="ajax-form" method="POST" action="<?= site_url('admin/save-astrologer') ?>">
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
    <form id="editAstroForm" class="ajax-form" method="POST" action="<?= site_url('admin/save-astrologer') ?>">
      <?= csrf_field() ?>
      <div class="form-grid-2" id="editAstroFields">
        <div class="form-group"><label class="form-label">Full Name</label><input class="form-input" name="name" type="text" id="editName" required></div>
        <div class="form-group"><label class="form-label">City</label><input class="form-input" name="city" type="text" id="editCity"></div>
        <div class="form-group"><label class="form-label">Experience (Yrs)</label><input class="form-input" name="exp" type="number" id="editExp" min="0" max="80"></div>
        <div class="form-group"><label class="form-label">Rating</label><input class="form-input" name="rating" type="number" step="0.1" id="editRating" min="0" max="5"></div>
        <div class="form-group"><label class="form-label">Reviews</label><input class="form-input" name="reviews" type="number" id="editReviews" min="0"></div>
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

<script>
let astroTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  // Initialize Custom AJAX DataTable
  astroTableInstance = new AppDataTable({
    tableSelector: '#astroTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'astrologers',
    pageSize: 10,
    paginationSelector: '#astroPagination',
    searchSelector: '#astroSearch',
    filterSelectors: {
      online: '#statusFilter'
    },
    exportSelector: '#btnExportAstros',
    columns: [
      {
        data: 'id',
        title: '#',
        sortable: false,
        render: function(val, row, index, total, idx) {
          return `<span style="font-size:11px;color:var(--text-muted)">${idx + 1}</span>`;
        }
      },
      {
        data: 'name',
        title: 'Astrologer',
        render: function(val, row) {
          const avatar = row.avatar || (val ? val.substring(0, 1).toUpperCase() : 'A');
          return `
            <div style="display:flex;align-items:center;gap:9px">
              <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0">${escapeHtml(avatar)}</div>
              <div>
                <div style="font-weight:700;font-size:13px">${escapeHtml(val)}</div>
                <div style="font-size:10px;color:var(--text-muted)">${escapeHtml(row.city || '—')}</div>
              </div>
            </div>
          `;
        }
      },
      {
        data: 'expertise',
        title: 'Expertise',
        render: function(val) {
          const list = Array.isArray(val) ? val : (val ? val.split(',') : []);
          return `
            <div style="display:flex;flex-wrap:wrap;gap:3px">
              ${list.slice(0, 2).map(e => `<span class="tag" style="font-size:9px">${escapeHtml(e)}</span>`).join('')}
              ${list.length > 2 ? `<span class="tag" style="font-size:9px">+${list.length - 2}</span>` : ''}
            </div>
          `;
        }
      },
      {
        data: 'languages',
        title: 'Languages',
        render: function(val) {
          const list = Array.isArray(val) ? val : (val ? val.split(',') : []);
          return `<span style="font-size:11px">${escapeHtml(list.join(', '))}</span>`;
        }
      },
      {
        data: 'exp',
        title: 'Experience',
        render: function(val) {
          return `<span class="badge badge-navy">${val} Yrs</span>`;
        }
      },
      {
        data: 'rating',
        title: 'Rating',
        render: function(val, row) {
          const reviews = row.reviews || 0;
          return `
            <span style="color:var(--gold);font-weight:700">⭐ ${val}</span>
            <br>
            <span style="font-size:10px;color:var(--text-muted)">${reviews.toLocaleString('en-IN')} reviews</span>
          `;
        }
      },
      {
        data: 'chatRate',
        title: 'Chat Rate',
        render: function(val) {
          return `<span style="font-weight:700;color:var(--saffron)">₹${val || 40}/min</span>`;
        }
      },
      {
        data: 'earnings',
        title: 'Earnings',
        render: function(val) {
          return `<span style="font-weight:700;color:var(--saffron)">₹${Number(val || 0).toLocaleString('en-IN')}</span>`;
        }
      },
      {
        data: 'online',
        title: 'Status',
        render: function(val) {
          return val ? '<span class="badge badge-success">● Online</span>' : '<span class="badge badge-warning">⚫ Offline</span>';
        }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" onclick="viewAstro('${val}')" title="View">👁</button>
              <button class="btn-navy btn-sm" style="background:rgba(200,147,26,0.15);color:var(--gold)" onclick="editAstro('${val}')" title="Edit">✎</button>
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteAstro('${val}','${escapeHtml(row.name)}')" title="Delete">🗑</button>
            </div>
          `;
        }
      }
    ],
    onDraw: function(data) {
      if (astroTableInstance) {
        updateStatsStrip(astroTableInstance.data);
        document.getElementById('astroCount').textContent = `Showing ${astroTableInstance.filteredData.length} of ${astroTableInstance.data.length} astrologers`;
      }
    }
  });

  // Client-side Validation
  if ($.isFunction($.fn.validate)) {
    $('#addAstroForm').validate({
      rules: {
        name: { required: true, minlength: 2 },
        email: { required: true, email: true },
        phone: { required: true, minlength: 10 }
      }
    });

    $('#editAstroForm').validate({
      rules: {
        name: { required: true, minlength: 2 }
      }
    });
  }

  // Handle Form Success Listeners
  $('#addAstroForm').on('ajax:success', function() {
    astroTableInstance.reload();
  });

  $('#editAstroForm').on('ajax:success', function() {
    astroTableInstance.reload();
  });
});

function openAddAstroModal() {
  document.getElementById('addAstroForm').reset();
  openModal('addAstroModal');
}

function updateStatsStrip(astros) {
  if (!astros) return;
  const verifiedCount = astros.filter(a => a.verified).length;
  const onlineCount = astros.filter(a => a.online).length;
  const totalEarnings = astros.reduce((s, a) => s + (parseFloat(a.earnings) || 0), 0);
  const avgRating = astros.length ? (astros.reduce((s, a) => s + (parseFloat(a.rating) || 0), 0) / astros.length).toFixed(2) : '0.00';

  document.getElementById('kVerified').textContent = verifiedCount;
  document.getElementById('kOnline').textContent   = onlineCount;
  document.getElementById('kEarnings').textContent = '₹' + totalEarnings.toLocaleString('en-IN');
  document.getElementById('kRating').textContent   = avgRating + ' ⭐';
}

function clearFilters() {
  document.getElementById('astroSearch').value = '';
  document.getElementById('statusFilter').value = '';
  document.getElementById('expertiseFilter').value = '';
  if (typeof $.isFunction($.fn.SumoSelect)) {
    $('#statusFilter')[0].sumo.reload();
    $('#expertiseFilter')[0].sumo.reload();
  }
  astroTableInstance.currentPage = 1;
  astroTableInstance.applyFiltersAndDraw();
}

function viewAstro(id) {
  if (!astroTableInstance) return;
  const a = astroTableInstance.data.find(x => String(x.id) === String(id));
  if (!a) return;
  
  const avatar = a.avatar || a.name.substring(0, 1).toUpperCase();
  const exp = a.exp || 0;
  const rating = a.rating || 0;
  const reviews = a.reviews || 0;
  const verifiedBadge = a.verified ? '<span class="badge badge-success">✅ Verified</span>' : '<span class="badge badge-warning">⏳ Pending</span>';
  const onlineBadge = a.online ? '<span class="badge badge-success">● Online</span>' : '<span class="badge badge-warning">⚫ Offline</span>';
  const chatRate = a.chatRate || 40;
  const videoRate = a.videoRate || 60;
  const earnings = a.earnings || 0;
  
  const expList = Array.isArray(a.expertise) ? a.expertise : (a.expertise ? a.expertise.split(',') : []);
  const langList = Array.isArray(a.languages) ? a.languages : (a.languages ? a.languages.split(',') : []);

  document.getElementById('viewAstroBody').innerHTML = `
    <div style="display:grid;grid-template-columns:auto 1fr;gap:20px;margin-bottom:22px;align-items:start">
      <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--saffron));display:flex;align-items:center;justify-content:center;color:white;font-family:'Cinzel',serif;font-size:30px;font-weight:700;border:3px solid var(--gold);box-shadow:0 0 0 4px rgba(200,147,26,0.2)">${escapeHtml(avatar)}</div>
      <div>
        <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;margin-bottom:2px">${escapeHtml(a.name)}</div>
        <div style="color:var(--text-muted);font-size:12px;margin-bottom:8px">${escapeHtml(a.city || '—')} · ${exp} Years Experience</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
          ${verifiedBadge}
          ${onlineBadge}
          <span class="badge badge-gold">⭐ ${rating} (${reviews.toLocaleString('en-IN')} reviews)</span>
        </div>
      </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:18px">
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:10px;padding:14px;text-align:center">
        <div style="font-size:10px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Chat Rate</div>
        <div style="font-family:'Cinzel',serif;font-size:20px;font-weight:700;color:var(--saffron)">₹${chatRate}/min</div>
      </div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:10px;padding:14px;text-align:center">
        <div style="font-size:10px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Video Rate</div>
        <div style="font-family:'Cinzel',serif;font-size:20px;font-weight:700;color:var(--saffron)">₹${videoRate}/min</div>
      </div>
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:10px;padding:14px;text-align:center">
        <div style="font-size:10px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Total Earnings</div>
        <div style="font-family:'Cinzel',serif;font-size:20px;font-weight:700;color:var(--saffron)">₹${earnings.toLocaleString('en-IN')}</div>
      </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:18px">
      <div>
        <div style="font-size:11px;font-weight:700;color:var(--text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Expertise</div>
        <div style="display:flex;flex-wrap:wrap;gap:5px">${expList.map(e => `<span class="tag">${escapeHtml(e)}</span>`).join('')}</div>
      </div>
      <div>
        <div style="font-size:11px;font-weight:700;color:var(--text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Languages</div>
        <div style="display:flex;flex-wrap:wrap;gap:5px">${langList.map(l => `<span class="tag tag-saf">${escapeHtml(l)}</span>`).join('')}</div>
      </div>
    </div>
    <div style="display:flex;gap:10px">
      <button class="btn btn-secondary" style="flex:1" onclick="closeModal('viewAstroModal');editAstro('${a.id}')">✎ Edit Details</button>
      <button class="btn btn-primary" style="flex:1" onclick="toggleOnline('${a.id}', ${!a.online})">${a.online ? '⚫ Set Offline' : '🟢 Set Online'}</button>
      <button class="btn" style="flex:1;background:#EF4444;color:white" onclick="closeModal('viewAstroModal');deleteAstro('${a.id}','${escapeHtml(a.name)}')">🗑 Delete</button>
    </div>
  `;
  openModal('viewAstroModal');
}

function editAstro(id) {
  if (!astroTableInstance) return;
  const a = astroTableInstance.data.find(x => String(x.id) === String(id));
  if (!a) return;

  document.getElementById('editAstroId').value   = id;
  document.getElementById('editName').value      = a.name;
  document.getElementById('editCity').value      = a.city || '';
  document.getElementById('editExp').value       = a.exp || 0;
  document.getElementById('editRating').value    = a.rating || 4.8;
  document.getElementById('editReviews').value   = a.reviews || 0;
  document.getElementById('editOnline').value    = a.online ? '1' : '0';

  openModal('editAstroModal');
}

function deleteAstro(id, name) {
  AppNotification.confirm({
    title: 'Delete Astrologer?',
    text: `Are you sure you want to permanently remove ${name} from the platform?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove") ?>?collection=astrologers&id=' + id, function(res) {
      AppNotification.toast('Astrologer removed successfully', 'success');
      astroTableInstance.reload();
    });
  });
}

function toggleOnline(id, status) {
  closeModal('viewAstroModal');
  AppAjax.post('<?= site_url("admin/save-astrologer") ?>', { id: id, online: status ? 1 : 0 }, function(res) {
    AppNotification.toast('Online status updated successfully', 'success');
    astroTableInstance.reload();
  });
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}
</script>
