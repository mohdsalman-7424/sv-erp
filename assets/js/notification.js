/**
 * NOTIFICATION.JS — Samriddhi-Ventures ERP
 * Reusable notification system wrapper for SweetAlert2 and Toastr.
 */

const AppNotification = (() => {
  // Show non-blocking toast notifications (uses Toastr under the hood)
  function toast(message, type = 'info') {
    if (typeof toastr !== 'undefined') {
      if (type === 'success') toastr.success(message);
      else if (type === 'error') toastr.error(message);
      else if (type === 'warning') toastr.warning(message);
      else toastr.info(message);
    } else {
      // Fallback to basic toast in case toastr is not loaded
      if (typeof window.Toast !== 'undefined' && typeof window.Toast.show === 'function') {
        window.Toast.show(message, type);
      } else {
        alert(message);
      }
    }
  }

  // Show SweetAlert2 Success alert
  function success(message, title = 'Success') {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        confirmButtonColor: 'var(--gold, #c8931a)'
      });
    } else {
      toast(message, 'success');
    }
  }

  // Show SweetAlert2 Error alert
  function error(message, title = 'Error') {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: title,
        text: message,
        icon: 'error',
        confirmButtonColor: 'var(--navy, #0e1e38)'
      });
    } else {
      toast(message, 'error');
    }
  }

  // Show SweetAlert2 warning alert
  function warning(message, title = 'Warning') {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        confirmButtonColor: 'var(--gold, #c8931a)'
      });
    } else {
      toast(message, 'warning');
    }
  }

  // Show SweetAlert2 Confirm dialog for deletions or other destructive actions
  function confirm(options, onConfirm, onCancel) {
    if (typeof Swal !== 'undefined') {
      const defaults = {
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--saffron, #ef4444)',
        cancelButtonColor: 'var(--navy, #0e1e38)',
        confirmButtonText: 'Yes, delete it!'
      };

      const settings = $.extend({}, defaults, typeof options === 'string' ? { title: options } : options);

      Swal.fire(settings).then((result) => {
        if (result.isConfirmed) {
          if (typeof onConfirm === 'function') {
            onConfirm();
          }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          if (typeof onCancel === 'function') {
            onCancel();
          }
        }
      });
    } else {
      if (window.confirm(options.title || 'Are you sure?')) {
        if (typeof onConfirm === 'function') onConfirm();
      } else {
        if (typeof onCancel === 'function') onCancel();
      }
    }
  }

  return {
    toast,
    success,
    error,
    warning,
    confirm
  };
})();

// Assign to window for global access
window.AppNotification = AppNotification;
