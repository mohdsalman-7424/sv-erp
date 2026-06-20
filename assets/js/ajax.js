/**
 * AJAX.JS — Samriddhi-Ventures ERP
 * Reusable AJAX helper functions and form interceptors.
 * Integrates jQuery Validation and AppNotification.
 */

const AppAjax = (() => {
  // Inject CSS for loading spinner and upload progress bar
  const css = `
    .sv-ajax-loader {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(14, 30, 56, 0.45);
      backdrop-filter: blur(4px);
      z-index: 99999;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
    .sv-ajax-loader.show {
      opacity: 1;
      pointer-events: auto;
    }
    .sv-spinner-wrap {
      background: rgba(255, 255, 255, 0.95);
      border: 1px solid rgba(200, 147, 26, 0.25);
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }
    [data-theme="dark"] .sv-spinner-wrap {
      background: #14213d;
      border-color: rgba(200, 147, 26, 0.4);
    }
    .sv-spinner {
      width: 45px;
      height: 45px;
      border: 3px solid rgba(200, 147, 26, 0.2);
      border-top-color: var(--gold, #c8931a);
      border-radius: 50%;
      animation: sv-spin 0.8s linear infinite;
    }
    .sv-loader-text {
      font-family: 'Mulish', sans-serif;
      font-size: 13px;
      font-weight: 600;
      color: var(--navy, #0e1e38);
    }
    [data-theme="dark"] .sv-loader-text {
      color: rgba(255, 255, 255, 0.9);
    }
    @keyframes sv-spin {
      to { transform: rotate(360deg); }
    }
    
    /* Upload Progress Bar */
    .sv-progress-container {
      width: 200px;
      background: rgba(0, 0, 0, 0.1);
      border-radius: 4px;
      height: 6px;
      overflow: hidden;
      margin-top: 5px;
      display: none;
    }
    .sv-progress-bar {
      width: 0%;
      height: 100%;
      background: var(--gold, #c8931a);
      transition: width 0.1s ease;
    }
    
    /* Inline error messages beside validation fields */
    .validation-error {
      color: #EF4444;
      font-size: 11px;
      font-weight: 500;
      margin-top: 4px;
      display: block;
    }
    .form-group.has-error input, 
    .form-group.has-error select, 
    .form-group.has-error textarea {
      border-color: #EF4444 !important;
      box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.15) !important;
    }
  `;

  let activeRequests = 0;

  function init() {
    // Append styles to head
    const styleEl = document.createElement('style');
    styleEl.innerHTML = css;
    document.head.appendChild(styleEl);

    // Create and append loader HTML if not exists
    if (!$('#sv-ajax-loader').length) {
      $('body').append(`
        <div id="sv-ajax-loader" class="sv-ajax-loader">
          <div class="sv-spinner-wrap">
            <div class="sv-spinner"></div>
            <div class="sv-loader-text" id="sv-loader-text">Loading...</div>
            <div class="sv-progress-container" id="sv-loader-progress-container">
              <div class="sv-progress-bar" id="sv-loader-progress-bar"></div>
            </div>
          </div>
        </div>
      `);
    }

    // Set up jQuery Validation defaults if available
    if (typeof $.validator !== 'undefined') {
      $.validator.setDefaults({
        errorClass: 'validation-error',
        errorElement: 'span',
        highlight: function(element) {
          $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
          $(element).closest('.form-group').removeClass('has-error');
        },
        errorPlacement: function(error, element) {
          error.insertAfter(element);
        }
      });
    }
  }

  // Show/Hide Spinner based on active AJAX calls
  function showLoader(text = 'Processing...', showProgress = false) {
    activeRequests++;
    $('#sv-loader-text').text(text);
    if (showProgress) {
      $('#sv-loader-progress-container').show();
      $('#sv-loader-progress-bar').css('width', '0%');
    } else {
      $('#sv-loader-progress-container').hide();
    }
    $('#sv-ajax-loader').addClass('show');
  }

  function hideLoader() {
    activeRequests = Math.max(0, activeRequests - 1);
    if (activeRequests === 0) {
      $('#sv-ajax-loader').removeClass('show');
    }
  }

  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
  }

  // Generic Request Helper
  function request(options) {
    const defaults = {
      type: 'GET',
      dataType: 'json',
      showSpinner: true,
      spinnerText: 'Loading...',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    };

    const settings = $.extend({}, defaults, options);

    // Auto-inject CSRF for POST/PUT/DELETE
    if (settings.type && settings.type.toUpperCase() !== 'GET') {
      const csrfValue = getCookie('sv_csrf_cookie');
      if (csrfValue) {
        if (typeof settings.data === 'object' && !(settings.data instanceof FormData)) {
          settings.data['sv_csrf_token'] = csrfValue;
        } else if (settings.data instanceof FormData) {
          if (!settings.data.has('sv_csrf_token')) {
            settings.data.append('sv_csrf_token', csrfValue);
          }
        } else if (typeof settings.data === 'string') {
          if (!settings.data.includes('sv_csrf_token=')) {
            settings.data += (settings.data ? '&' : '') + 'sv_csrf_token=' + encodeURIComponent(csrfValue);
          }
        }
      }
    }

    if (settings.showSpinner) {
      showLoader(settings.spinnerText);
    }

    // Capture original callback
    const originalSuccess = settings.success;
    const originalError = settings.error;

    settings.success = function(res, status, xhr) {
      if (settings.showSpinner) hideLoader();
      
      // Update CSRF token on success
      if (typeof window.updateCSRFTokens === 'function') {
        setTimeout(window.updateCSRFTokens, 100);
      }

      if (originalSuccess) originalSuccess(res, status, xhr);
    };

    settings.error = function(xhr, status, error) {
      if (settings.showSpinner) hideLoader();

      // Update CSRF token on error
      if (typeof window.updateCSRFTokens === 'function') {
        setTimeout(window.updateCSRFTokens, 100);
      }

      let errorMsg = 'An error occurred during your request. Please try again.';
      if (xhr.responseJSON) {
        errorMsg = xhr.responseJSON.message || xhr.responseJSON.error || errorMsg;
      }

      if (originalError) {
        originalError(xhr, status, errorMsg);
      } else {
        if (typeof AppNotification !== 'undefined') {
          AppNotification.error(errorMsg, 'Error');
        } else {
          alert(errorMsg);
        }
      }
    };

    return $.ajax(settings);
  }

  // HTTP GET Wrapper
  function get(url, data, successCallback, errorCallback, options = {}) {
    if (typeof data === 'function') {
      errorCallback = successCallback;
      successCallback = data;
      data = {};
    }

    return request($.extend({
      url: url,
      type: 'GET',
      data: data,
      success: successCallback,
      error: errorCallback
    }, options));
  }

  // HTTP POST Wrapper
  function post(url, data, successCallback, errorCallback, options = {}) {
    return request($.extend({
      url: url,
      type: 'POST',
      data: data,
      success: successCallback,
      error: errorCallback
    }, options));
  }

  // HTTP DELETE / Remove Wrapper
  function remove(url, successCallback, errorCallback, options = {}) {
    return request($.extend({
      url: url,
      type: 'DELETE',
      success: successCallback,
      error: errorCallback
    }, options));
  }

  // Function to display validation errors on a form from server response
  function displayServerErrors(form, errors) {
    const $form = $(form);
    // Clear previous errors
    $form.find('.form-group').removeClass('has-error');
    $form.find('.validation-error').remove();

    if (!errors) return;

    // Loop through field errors
    Object.keys(errors).forEach(key => {
      const errorMsg = errors[key];
      const $field = $form.find(`[name="${key}"], [id="${key}"]`);
      if ($field.length) {
        const $group = $field.closest('.form-group');
        $group.addClass('has-error');
        
        let $errEl = $group.find('.validation-error');
        if (!$errEl.length) {
          $errEl = $('<span class="validation-error"></span>');
          $errEl.insertAfter($field);
        }
        $errEl.text(errorMsg);
      }
    });
  }

  // AJAX Form Handler function
  function submitForm(form, successCallback, errorCallback) {
    const $form = $(form);
    const action = $form.attr('action') || window.location.href;
    const method = ($form.attr('method') || 'POST').toUpperCase();
    
    // Check if form contains file inputs
    const hasFiles = $form.find('input[type="file"]').length > 0;
    let requestData;
    let contentType;
    let processData;

    if (hasFiles) {
      requestData = new FormData(form);
      contentType = false;
      processData = false;
    } else {
      // Check if we need to send JSON or URL encoded
      requestData = $form.serialize();
      contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
      processData = true;
    }

    const $submitBtn = $form.find('[type="submit"], button:not([type="button"])');
    const originalBtnText = $submitBtn.html();

    // Disable submit button & show loading state to prevent double clicks
    $submitBtn.prop('disabled', true);
    $submitBtn.addClass('btn-processing');
    $submitBtn.html('<span>⏳ Processing...</span>');

    showLoader('Saving details...', hasFiles);

    const ajaxOptions = {
      url: action,
      type: method,
      data: requestData,
      contentType: contentType,
      processData: processData,
      success: function(res) {
        hideLoader();
        $submitBtn.prop('disabled', false);
        $submitBtn.removeClass('btn-processing');
        $submitBtn.html(originalBtnText);

        if (res.status || res.success) {
          const msg = res.message || res.success || 'Record saved successfully';
          
          if (typeof AppNotification !== 'undefined') {
            AppNotification.toast(msg, 'success');
          }

          // Reset form if requested
          if ($form.attr('data-reset') !== 'false') {
            form.reset();
            // Clear Selects if using SumoSelect
            if ($.isFunction($.fn.SumoSelect)) {
              $form.find('select.sumo').each(function() {
                this.sumo.reload();
              });
            }
          }

          // Close modal if form was inside one
          const $modal = $form.closest('.modal-overlay');
          if ($modal.length) {
            $modal.removeClass('open');
          }

          if (successCallback) {
            successCallback(res);
          } else {
            // Default behavior: Redirect or Reload if specified in response
            if (res.redirect) {
              setTimeout(() => { window.location.href = res.redirect; }, 1000);
            } else if (res.reload) {
              setTimeout(() => { window.location.reload(); }, 1000);
            }
          }
        } else {
          // If status is false, handle display of error messages
          const msg = res.message || res.error || 'Validation failed';
          if (typeof AppNotification !== 'undefined') {
            AppNotification.toast(msg, 'error');
          }

          // Display validation errors beside fields
          if (res.errors) {
            displayServerErrors(form, res.errors);
          }

          if (errorCallback) {
            errorCallback(res);
          }
        }
      },
      error: function(xhr, status, errorText) {
        hideLoader();
        $submitBtn.prop('disabled', false);
        $submitBtn.removeClass('btn-processing');
        $submitBtn.html(originalBtnText);

        let errorMsg = 'An error occurred during submission. Please try again.';
        let serverErrors = null;
        
        if (xhr.responseJSON) {
          errorMsg = xhr.responseJSON.message || xhr.responseJSON.error || errorMsg;
          serverErrors = xhr.responseJSON.errors || null;
        }

        if (typeof AppNotification !== 'undefined') {
          AppNotification.error(errorMsg, 'Error');
        }

        if (serverErrors) {
          displayServerErrors(form, serverErrors);
        }

        if (errorCallback) {
          errorCallback(xhr, status, errorMsg);
        }
      }
    };

    // If uploading files, hook upload progress event
    if (hasFiles) {
      ajaxOptions.xhr = function() {
        const myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) {
          myXhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
              const max = e.total;
              const current = e.loaded;
              const Percentage = Math.round((current * 100) / max);
              $('#sv-loader-progress-bar').css('width', Percentage + '%');
            }
          }, false);
        }
        return myXhr;
      };
    }

    return $.ajax(ajaxOptions);
  }

  return {
    init,
    request,
    get,
    post,
    remove,
    submitForm,
    showLoader,
    hideLoader,
    displayServerErrors
  };
})();

// Init on script load
$(document).ready(function() {
  AppAjax.init();

  // Re-bind form interceptor using class-based event delegation
  $(document).on('submit', 'form.ajax-form', function(e) {
    e.preventDefault();
    const form = this;

    // Run client-side validation if plugin is active
    if ($.isFunction($.fn.valid)) {
      if (!$(form).valid()) {
        if (typeof AppNotification !== 'undefined') {
          AppNotification.toast('Please correct the validation errors in the form.', 'warning');
        }
        return false;
      }
    }

    // Call submit helper
    AppAjax.submitForm(form, function(res) {
      // Trigger a custom event on successful submission so parent pages can reload tables or grids
      $(form).trigger('ajax:success', [res]);
      
      // If we have custom action callbacks on the form, trigger them
      const successAction = $(form).data('on-success');
      if (successAction && typeof window[successAction] === 'function') {
        window[successAction](res);
      }
    });
  });
});
