<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    </div><!-- /.dash-main -->
  </div><!-- /.dash-layout -->
</div><!-- /.dash-page -->

<div id="toast-container"></div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- SumoSelect -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.3/jquery.sumoselect.min.js"></script>
<!-- App JS -->
<script src="<?= base_url('assets/js/store.js') ?>"></script>
<script src="<?= base_url('assets/js/core.js') ?>"></script>
<script src="<?= base_url('assets/js/notification.js') ?>"></script>
<script src="<?= base_url('assets/js/ajax.js') ?>"></script>
<script src="<?= base_url('assets/js/datatable.js') ?>"></script>
<script>
// Toastr global defaults
toastr.options = {
    positionClass: 'toast-bottom-right',
    timeOut: 3500,
    progressBar: true,
    closeButton: true,
    newestOnTop: true
};
// Override app Toast to use Toastr
window.Toast = {
    show: function(msg, type) {
        type = type || 'info';
        if (type === 'success') toastr.success(msg);
        else if (type === 'error') toastr.error(msg);
        else if (type === 'warning') toastr.warning(msg);
        else toastr.info(msg);
    }
};
$(document).ready(function() {
    // SumoSelect for all selects with .sumo class
    $('select.sumo').SumoSelect({ placeholder: 'Select...', search: true, searchText: 'Search...' });
    // Flatpickr - auto init by class
    flatpickr('.datepicker',     { dateFormat: 'd M Y', allowInput: true });
    flatpickr('.datetimepicker', { enableTime: true, dateFormat: 'd M Y H:i', allowInput: true });
    flatpickr('.timepicker',     { enableTime: true, noCalendar: true, dateFormat: 'H:i', allowInput: true });
});
</script>
<?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html>
