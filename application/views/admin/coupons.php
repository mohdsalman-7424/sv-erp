<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">🏷 Coupon Management</div>
    <div class="page-header-sub">Create and manage discount codes for subscriptions and reports</div>
  </div>
  <div class="page-header-actions">
    <button class="btn btn-primary btn-sm" onclick="openAddCouponModal()">+ Create Coupon</button>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="couponSearch" placeholder="Search coupon codes..."></div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="couponTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="code">Coupon Code</th>
            <th data-sortable="true" data-field="discount_type">Type</th>
            <th data-sortable="true" data-field="value">Discount Value</th>
            <th data-sortable="true" data-field="expiry">Expiry Date</th>
            <th data-sortable="true" data-field="status">Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" style="text-align:center;padding:24px;color:var(--text-muted)">Loading coupons...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="couponPagination"></div>
  </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal-overlay" id="addCouponModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Create Coupon</div>
      <button class="modal-close" onclick="closeModal('addCouponModal')">✕</button>
    </div>
    <form id="addCouponForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=coupons') ?>">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Coupon Code <span class="req">*</span></label>
        <input class="form-input" name="code" type="text" placeholder="FESTIVE50" style="text-transform:uppercase" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Discount Type <span class="req">*</span></label>
        <select class="form-select" name="discount_type">
          <option value="percentage">Percentage (%)</option>
          <option value="fixed">Fixed Amount (₹)</option>
        </select>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Discount Value <span class="req">*</span></label>
        <input class="form-input" name="value" type="number" step="0.01" placeholder="10.00" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Expiry Date <span class="req">*</span></label>
        <input class="form-input" name="expiry" type="date" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Status</label>
        <select class="form-select" name="status">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>
      <button class="btn btn-primary w-100" type="submit">Create Coupon ✦</button>
    </form>
  </div>
</div>

<!-- Edit Coupon Modal -->
<div class="modal-overlay" id="editCouponModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Edit Coupon</div>
      <button class="modal-close" onclick="closeModal('editCouponModal')">✕</button>
    </div>
    <form id="editCouponForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=coupons') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="editCouponId">
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Coupon Code <span class="req">*</span></label>
        <input class="form-input" name="code" id="editCouponCode" type="text" style="text-transform:uppercase" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Discount Type <span class="req">*</span></label>
        <select class="form-select" name="discount_type" id="editCouponType">
          <option value="percentage">Percentage (%)</option>
          <option value="fixed">Fixed Amount (₹)</option>
        </select>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Discount Value <span class="req">*</span></label>
        <input class="form-input" name="value" id="editCouponValue" type="number" step="0.01" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Expiry Date <span class="req">*</span></label>
        <input class="form-input" name="expiry" id="editCouponExpiry" type="date" required>
      </div>
      <div class="form-group" style="margin-bottom:14px">
        <label class="form-label">Status</label>
        <select class="form-select" name="status" id="editCouponStatus">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>
      <button class="btn btn-primary w-100" type="submit">Update Coupon ✦</button>
    </form>
  </div>
</div>

<script>
let couponTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  couponTableInstance = new AppDataTable({
    tableSelector: '#couponTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'coupons',
    pageSize: 10,
    paginationSelector: '#couponPagination',
    searchSelector: '#couponSearch',
    columns: [
      {
        data: 'code',
        title: 'Coupon Code',
        render: function(val) {
          return `<strong style="color:var(--navy);letter-spacing:1px">${escapeHtml(val)}</strong>`;
        }
      },
      {
        data: 'discount_type',
        title: 'Type',
        render: function(val) {
          return val === 'percentage' ? '<span class="tag">Percentage %</span>' : '<span class="tag">Fixed Amount ₹</span>';
        }
      },
      {
        data: 'value',
        title: 'Discount Value',
        render: function(val, row) {
          return row.discount_type === 'percentage' ? `${val}%` : `₹${Number(val).toFixed(2)}`;
        }
      },
      {
        data: 'expiry',
        title: 'Expiry Date',
        render: function(val) { return `<span style="font-size:11px;color:var(--text-muted)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'status',
        title: 'Status',
        render: function(val) {
          return val ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Expired/Inactive</span>';
        }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" style="background:rgba(200,147,26,0.15);color:var(--gold)" onclick="editCoupon('${val}')" title="Edit">✎</button>
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteCoupon('${val}','${escapeHtml(row.code)}')" title="Delete">🗑</button>
            </div>
          `;
        }
      }
    ]
  });

  if ($.isFunction($.fn.validate)) {
    $('#addCouponForm').validate({
      rules: {
        code: { required: true, minlength: 3 },
        value: { required: true, min: 0.01 },
        expiry: { required: true }
      }
    });
    $('#editCouponForm').validate({
      rules: {
        code: { required: true, minlength: 3 },
        value: { required: true, min: 0.01 },
        expiry: { required: true }
      }
    });
  }

  $('#addCouponForm').on('ajax:success', function() {
    couponTableInstance.reload();
  });

  $('#editCouponForm').on('ajax:success', function() {
    couponTableInstance.reload();
  });
});

function openAddCouponModal() {
  document.getElementById('addCouponForm').reset();
  openModal('addCouponModal');
}

function openModal(id) {
  document.getElementById(id).classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function editCoupon(id) {
  if (!couponTableInstance) return;
  const c = couponTableInstance.data.find(x => String(x.id) === String(id));
  if (!c) return;

  document.getElementById('editCouponId').value = c.id;
  document.getElementById('editCouponCode').value = c.code;
  document.getElementById('editCouponType').value = c.discount_type;
  document.getElementById('editCouponValue').value = c.value;
  document.getElementById('editCouponExpiry').value = c.expiry;
  document.getElementById('editCouponStatus').value = c.status;

  openModal('editCouponModal');
}

function deleteCoupon(id, code) {
  AppNotification.confirm({
    title: 'Delete Coupon?',
    text: `Are you sure you want to delete coupon code "${code}"?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=coupons") ?>&id=' + id, function(res) {
      AppNotification.toast('Coupon deleted successfully', 'success');
      couponTableInstance.reload();
    });
  });
}
</script>
