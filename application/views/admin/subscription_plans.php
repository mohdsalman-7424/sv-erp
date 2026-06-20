<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">💎 Subscription Plans</div>
    <div class="page-header-sub">Manage platform subscription packages and pricing</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-primary btn-sm" onclick="openAddPlanModal()">+ Add Plan</button>
  </div>
</div>

<!-- Stats Strip -->
<div class="kpi-grid" style="margin-bottom:20px">
  <div class="kpi-card"><div class="kpi-label">Total Plans</div><div class="kpi-val" id="statsTotalPlans"><?= count($plans_db) ?></div><div class="kpi-change kpi-up">● Active</div></div>
  <div class="kpi-card">
    <div class="kpi-label">Average Price</div>
    <div class="kpi-val" id="statsAvgPrice">
      ₹<?php 
        $prices = array_column($plans_db, 'price'); 
        echo count($prices) ? number_format(array_sum($prices) / count($prices), 2) : '0.00'; 
      ?>
    </div>
    <div class="kpi-change kpi-up">▲ Competitive</div>
  </div>
  <div class="kpi-card"><div class="kpi-label">Billing Currency</div><div class="kpi-val">INR (₹)</div><div class="kpi-change kpi-up">● Standard</div></div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-body">
    <div style="overflow-x:auto">
      <table class="data-table" id="plansTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="name">Plan Name</th>
            <th data-sortable="true" data-field="price">Price</th>
            <th data-sortable="true" data-field="duration">Duration (Days)</th>
            <th>Features</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" style="text-align:center;padding:24px;color:var(--text-muted)">Loading subscription plans...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="plansPagination"></div>
  </div>
</div>

<!-- Add Plan Modal -->
<div class="modal-overlay" id="addPlanModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Add New Plan</div>
      <button class="modal-close" onclick="closeModal('addPlanModal')">✕</button>
    </div>
    <form id="addPlanForm" class="ajax-form" method="POST" action="<?= site_url('admin/save-plan') ?>">
      <?= csrf_field() ?>
      <div class="form-grid-2" style="grid-template-columns:1fr">
        <div class="form-group"><label class="form-label">Plan Name <span class="req">*</span></label><input class="form-input" name="name" type="text" placeholder="Gold Plan" required></div>
        <div class="form-group"><label class="form-label">Price (₹) <span class="req">*</span></label><input class="form-input" name="price" type="number" step="0.01" placeholder="999.00" required></div>
        <div class="form-group"><label class="form-label">Duration (Days) <span class="req">*</span></label><input class="form-input" name="duration" type="number" placeholder="30" required></div>
        <div class="form-group"><label class="form-label">Features (Comma separated) <span class="req">*</span></label><input class="form-input" name="features" type="text" placeholder="Daily Horoscope, Ask 2 Questions, Chat with Guru" required></div>
      </div>
      <button class="btn btn-primary w-100" style="margin-top:18px" type="submit">Save Plan</button>
    </form>
  </div>
</div>

<!-- Edit Plan Modal -->
<div class="modal-overlay" id="editPlanModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Plan</div>
      <button class="modal-close" onclick="closeModal('editPlanModal')">✕</button>
    </div>
    <form id="editPlanForm" class="ajax-form" method="POST" action="<?= site_url('admin/save-plan') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="editPlanId">
      <div class="form-grid-2" style="grid-template-columns:1fr">
        <div class="form-group"><label class="form-label">Plan Name <span class="req">*</span></label><input class="form-input" name="name" id="editPlanName" type="text" required></div>
        <div class="form-group"><label class="form-label">Price (₹) <span class="req">*</span></label><input class="form-input" name="price" id="editPlanPrice" type="number" step="0.01" required></div>
        <div class="form-group"><label class="form-label">Duration (Days) <span class="req">*</span></label><input class="form-input" name="duration" id="editPlanDuration" type="number" required></div>
        <div class="form-group"><label class="form-label">Features (Comma separated) <span class="req">*</span></label><input class="form-input" name="features" id="editPlanFeatures" type="text" required></div>
      </div>
      <button class="btn btn-primary w-100" style="margin-top:18px" type="submit">Update Plan</button>
    </form>
  </div>
</div>

<script>
let plansTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  // Initialize Custom AJAX DataTable
  plansTableInstance = new AppDataTable({
    tableSelector: '#plansTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'plans',
    pageSize: 10,
    paginationSelector: '#plansPagination',
    columns: [
      {
        data: 'name',
        title: 'Plan Name',
        render: function(val) {
          return `<strong style="color:var(--navy)">${escapeHtml(val)}</strong>`;
        }
      },
      {
        data: 'price',
        title: 'Price',
        render: function(val) {
          return `<span style="font-weight:700;color:var(--saffron)">₹${Number(val || 0).toFixed(2)}</span>`;
        }
      },
      {
        data: 'duration',
        title: 'Duration (Days)',
        render: function(val) {
          return `<span class="badge badge-navy">${val} Days</span>`;
        }
      },
      {
        data: 'features',
        title: 'Features',
        render: function(val) {
          const list = Array.isArray(val) ? val : (val ? val.split(',') : []);
          return `
            <div style="display:flex;flex-wrap:wrap;gap:4px">
              ${list.map(f => `<span class="tag" style="font-size:10px">${escapeHtml(trim(f))}</span>`).join('')}
            </div>
          `;
        }
      },
      {
        data: 'status',
        title: 'Status',
        render: function(val) {
          return parseInt(val) === 1 
            ? '<span class="badge badge-success">● Active</span>' 
            : '<span class="badge badge-warning">⚫ Inactive</span>';
        }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:5px">
              <button class="btn-navy btn-sm" onclick="editPlan('${val}')">Edit</button>
              <button class="btn btn-danger btn-sm" style="width:auto;padding:6px 10px" onclick="deletePlan('${val}', '${escapeHtml(row.name)}')">🗑</button>
            </div>
          `;
        }
      }
    ],
    onDraw: function(data) {
      if (plansTableInstance) {
        updateStatsStrip(plansTableInstance.data);
      }
    }
  });

  // Client-side Validation
  if ($.isFunction($.fn.validate)) {
    $('#addPlanForm').validate({
      rules: {
        name: { required: true, minlength: 2 },
        price: { required: true, number: true, min: 0 },
        duration: { required: true, digits: true, min: 1 },
        features: { required: true }
      }
    });

    $('#editPlanForm').validate({
      rules: {
        name: { required: true, minlength: 2 },
        price: { required: true, number: true, min: 0 },
        duration: { required: true, digits: true, min: 1 },
        features: { required: true }
      }
    });
  }

  // Handle Form Success Listeners
  $('#addPlanForm').on('ajax:success', function() {
    plansTableInstance.reload();
  });

  $('#editPlanForm').on('ajax:success', function() {
    plansTableInstance.reload();
  });
});

function openAddPlanModal() {
  document.getElementById('addPlanForm').reset();
  openModal('addPlanModal');
}

function updateStatsStrip(plans) {
  if (!plans) return;
  document.getElementById('statsTotalPlans').textContent = plans.length;
  
  const prices = plans.map(p => parseFloat(p.price || 0));
  const avgPrice = prices.length ? (prices.reduce((s, p) => s + p, 0) / prices.length) : 0;
  document.getElementById('statsAvgPrice').textContent = '₹' + avgPrice.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function editPlan(id) {
  if (!plansTableInstance) return;
  const p = plansTableInstance.data.find(x => String(x.id) === String(id));
  if (!p) return;

  document.getElementById('editPlanId').value = p.id;
  document.getElementById('editPlanName').value = p.name;
  document.getElementById('editPlanPrice').value = p.price;
  document.getElementById('editPlanDuration').value = p.duration;
  
  const featuresArray = Array.isArray(p.features) ? p.features : [p.features];
  document.getElementById('editPlanFeatures').value = featuresArray.join(', ');
  
  openModal('editPlanModal');
}

function deletePlan(id, name) {
  AppNotification.confirm({
    title: 'Delete Subscription Plan?',
    text: `Are you sure you want to permanently delete plan "${name}"?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove") ?>?collection=plans&id=' + id, function(res) {
      AppNotification.toast('Plan deleted successfully', 'success');
      plansTableInstance.reload();
    });
  });
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function trim(str) {
  return str ? str.trim() : '';
}

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
