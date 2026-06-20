<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Output a hidden CSRF token field for POST forms.
 */
function csrf_field() {
    $CI =& get_instance();
    if (!$CI->config->item('csrf_protection')) {
        return '';
    }
    return '<input type="hidden" name="' . $CI->security->get_csrf_token_name() . '" value="' . $CI->security->get_csrf_hash() . '">';
}

/**
 * Encode data for safe embedding inside a JavaScript string context.
 */
function safe_json_for_js($data) {
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}

/**
 * Generate a random temporary password for admin-created accounts.
 */
function generate_temp_password($length = 12) {
    $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789!@#$';
    $password = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $max)];
    }
    return $password;
}

/**
 * Whitelist consultation status values.
 */
function allowed_consultation_statuses() {
    return ['booked', 'confirmed', 'completed', 'cancelled', 'in_progress'];
}
