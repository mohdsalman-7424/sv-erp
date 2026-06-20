<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="page-header">
  <div>
    <div class="page-header-title">💬 Customer Support Tickets</div>
    <div class="page-header-sub">View and respond to support queries raised by seekers and astrologers</div>
  </div>
</div>

<!-- Table Card -->
<div class="card">
  <div class="card-body">
    <div class="table-toolbar">
      <div class="table-search"><span>🔍</span><input type="text" id="ticketSearch" placeholder="Search tickets..."></div>
      <div>
        <select class="filter-select sumo" id="filterTicketStatus">
          <option value="">All Status</option>
          <option value="open">Open</option>
          <option value="in_progress">In Progress</option>
          <option value="resolved">Resolved</option>
          <option value="closed">Closed</option>
        </select>
      </div>
    </div>
    <div style="overflow-x:auto">
      <table class="data-table" id="ticketTable">
        <thead>
          <tr>
            <th data-sortable="true" data-field="ticket_no">Ticket No</th>
            <th data-sortable="true" data-field="user_name">Customer</th>
            <th data-sortable="true" data-field="subject">Subject</th>
            <th data-sortable="true" data-field="status">Status</th>
            <th data-sortable="true" data-field="created_at">Created Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="6" style="text-align:center;padding:24px;color:var(--text-muted)">Loading support tickets...</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pagination" id="ticketPagination"></div>
  </div>
</div>

<!-- Reply Ticket Modal -->
<div class="modal-overlay" id="replyTicketModal">
  <div class="modal" style="max-width: 650px;">
    <div class="modal-header">
      <div class="modal-title">Respond to Ticket</div>
      <button class="modal-close" onclick="closeModal('replyTicketModal')">✕</button>
    </div>
    <div class="modal-body" style="padding: 10px 0;">
      <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:10px;padding:15px;margin-bottom:15px">
        <div style="display:flex;justify-content:space-between;margin-bottom:8px">
          <strong style="color:var(--navy)" id="replyTicketUser">User Name</strong>
          <span style="font-size:11px;color:var(--text-muted)" id="replyTicketNo">TKT-000</span>
        </div>
        <h4 style="margin:0 0 8px 0;font-family:'Playfair Display',serif" id="replyTicketSubject">Subject</h4>
        <p style="margin:0;font-size:13px;color:var(--text)" id="replyTicketMsg">Message details go here.</p>
      </div>

      <form id="replyTicketForm" class="ajax-form" method="POST" action="<?= site_url('api/save?collection=ticket_replies') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="ticket_id" id="replyTicketId">
        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Response Message <span class="req">*</span></label>
          <textarea class="form-input" name="message" rows="5" placeholder="Write your response here..." required></textarea>
        </div>
        <div class="form-group" style="margin-bottom:14px">
          <label class="form-label">Update Ticket Status</label>
          <select class="form-select" name="status" id="replyTicketFormStatus">
            <option value="open">Keep Open</option>
            <option value="in_progress">Mark In Progress</option>
            <option value="resolved">Mark Resolved</option>
            <option value="closed">Close Ticket</option>
          </select>
        </div>
        <button class="btn btn-primary w-100" type="submit">Submit Response ✦</button>
      </form>
    </div>
  </div>
</div>

<script>
let ticketTableInstance;

document.addEventListener('DOMContentLoaded', function() {
  ticketTableInstance = new AppDataTable({
    tableSelector: '#ticketTable',
    ajaxUrl: '<?= site_url("api/get") ?>',
    collection: 'tickets',
    pageSize: 10,
    paginationSelector: '#ticketPagination',
    searchSelector: '#ticketSearch',
    filterSelectors: {
      status: '#filterTicketStatus'
    },
    columns: [
      {
        data: 'ticket_no',
        title: 'Ticket No',
        render: function(val) {
          return `<strong style="color:var(--navy)">${escapeHtml(val)}</strong>`;
        }
      },
      {
        data: 'user_name',
        title: 'Customer',
        render: function(val) { return escapeHtml(val); }
      },
      {
        data: 'subject',
        title: 'Subject',
        render: function(val) { return `<strong>${escapeHtml(val)}</strong>`; }
      },
      {
        data: 'status',
        title: 'Status',
        render: function(val) {
          const status = String(val).toLowerCase();
          if (status === 'resolved') return '<span class="badge badge-success">Resolved</span>';
          if (status === 'closed') return '<span class="badge badge-danger">Closed</span>';
          if (status === 'in_progress') return '<span class="badge badge-warning">In Progress</span>';
          return '<span class="badge badge-navy">Open</span>';
        }
      },
      {
        data: 'created_at',
        title: 'Created Date',
        render: function(val) { return `<span style="font-size:11px;color:var(--text-muted)">${escapeHtml(val)}</span>`; }
      },
      {
        data: 'id',
        title: 'Actions',
        sortable: false,
        render: function(val, row) {
          return `
            <div style="display:flex;gap:4px;flex-wrap:nowrap">
              <button class="btn-navy btn-sm" onclick="respondTicket('${val}')" title="Reply">✉ Respond</button>
              <button class="btn-navy btn-sm" style="background:rgba(239,68,68,0.12);color:#EF4444" onclick="deleteTicket('${val}','${escapeHtml(row.ticket_no)}')" title="Delete">🗑</button>
            </div>
          `;
        }
      }
    ]
  });

  if ($.isFunction($.fn.validate)) {
    $('#replyTicketForm').validate({
      rules: {
        message: { required: true, minlength: 5 }
      }
    });
  }

  $('#replyTicketForm').on('ajax:success', function() {
    ticketTableInstance.reload();
  });
});

function openModal(id) {
  document.getElementById(id).classList.add('open');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function respondTicket(id) {
  if (!ticketTableInstance) return;
  const t = ticketTableInstance.data.find(x => String(x.id) === String(id));
  if (!t) return;

  document.getElementById('replyTicketId').value = t.id;
  document.getElementById('replyTicketUser').textContent = t.user_name;
  document.getElementById('replyTicketNo').textContent = t.ticket_no;
  document.getElementById('replyTicketSubject').textContent = t.subject;
  document.getElementById('replyTicketMsg').textContent = t.message;
  document.getElementById('replyTicketFormStatus').value = t.status;
  document.getElementById('replyTicketForm').reset();
  document.getElementById('replyTicketId').value = t.id; // reset empties hidden values

  openModal('replyTicketModal');
}

function deleteTicket(id, ticketNo) {
  AppNotification.confirm({
    title: 'Delete Support Ticket?',
    text: `Are you sure you want to delete support ticket "${ticketNo}"?`,
    confirmButtonText: 'Yes, delete it!'
  }, function() {
    AppAjax.get('<?= site_url("api/remove?collection=tickets") ?>&id=' + id, function(res) {
      AppNotification.toast('Ticket deleted successfully', 'success');
      ticketTableInstance.reload();
    });
  });
}
</script>
