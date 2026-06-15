    <?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('core_url')) {

    function core_url($atRoot = FALSE, $atCore = FALSE, $parse = FALSE)
    {
        
        if ($_SERVER['SERVER_PORT'] == '443') {

            return 'http://' . $_SERVER['HTTP_HOST'] . '/sv_erp';
        } else {
         
            return "http://" . $_SERVER['HTTP_HOST'] . '/sv_erp/';
        }

        if (isset($_SERVER['HTTP_HOST'])) {

            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';

            $hostname = $_SERVER['HTTP_HOST'];

            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);



            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);

            $core = $core[0];



            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");

            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);

            $base_url = sprintf($tmplt, $http, $hostname, $end);
           
        } else {

            // $base_url = 'https://localhost/g-m/';

            $base_url =  "http://" . $_SERVER['HTTP_HOST'] . '/sv_erp/';

            exit;
        }



        if ($parse) {

            $base_url = parse_url($base_url);

            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }



        return $base_url;
    }
}



$BASE_URL = core_url();



function cdn_url()

{

    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {

     
        return "http://" . $_SERVER['HTTP_HOST'] . 'sv_erp/';
    } else {

        return "http://" . $_SERVER['HTTP_HOST'] . '/sv_erp/';
    }
}



//function cdn_path()

// {



//     // return FCPATH.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;

//     return "/home/pinkqr/cdn/assets/";

// }


function cdn_path()

{


    // return FCPATH.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR;

    # return "/home/pinkqr/cdn/assets/";
    // return "C:/Xampp5/htdocs/pinkqr-online/assets";
    // return "D:/xampp/htdocs/g-m/assets/";
    return "C:/xampp/htdocs/sv_erp/assets/";
}



/*

|--------------------------------------------------------------------------

| File and Directory Modes

|--------------------------------------------------------------------------

|

| These prefs are used when checking and setting modes when working

| with the file system.  The defaults are fine on servers with proper

| security, but you may wish (or even need) to change the values in

| certain environments (Apache running a separate process for each

| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should

| always be used to set the mode correctly.

|

*/

define('FILE_READ_MODE', 0644);

define('FILE_WRITE_MODE', 0666);

define('DIR_READ_MODE', 0755);

define('DIR_WRITE_MODE', 0755);



/*

|--------------------------------------------------------------------------

| File Stream Modes

|--------------------------------------------------------------------------

|

| These modes are used when working with fopen()/popen()

|

*/



define('FOPEN_READ', 'rb');

define('FOPEN_READ_WRITE', 'r+b');

define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care

define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care

define('FOPEN_WRITE_CREATE', 'ab');

define('FOPEN_READ_WRITE_CREATE', 'a+b');

define('FOPEN_WRITE_CREATE_STRICT', 'xb');

define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');



/*

|--------------------------------------------------------------------------

| Display Debug backtrace

|--------------------------------------------------------------------------

|

| If set to TRUE, a backtrace will be displayed along with php errors. If

| error_reporting is disabled, the backtrace will not display, regardless

| of this setting

|

*/

define('SHOW_DEBUG_BACKTRACE', TRUE);



/*

|--------------------------------------------------------------------------

| Exit Status Codes

|--------------------------------------------------------------------------

|

| Used to indicate the conditions under which the script is exit()ing.

| While there is no universal standard for error codes, there are some

| broad conventions.  Three such conventions are mentioned below, for

| those who wish to make use of them.  The CodeIgniter defaults were

| chosen for the least overlap with these conventions, while still

| leaving room for others to be defined in future versions and user

| applications.

|

| The three main conventions used for determining exit status codes

| are as follows:

|

|    Standard C/C++ Library (stdlibc):

|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html

|       (This link also contains other GNU-specific conventions)

|    BSD sysexits.h:

|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits

|    Bash scripting:

|       http://tldp.org/LDP/abs/html/exitcodes.html

|

*/

define('EXIT_SUCCESS', 0); // no errors

define('EXIT_ERROR', 1); // generic error

define('EXIT_CONFIG', 3); // configuration error

define('EXIT_UNKNOWN_FILE', 4); // file not found

define('EXIT_UNKNOWN_CLASS', 5); // unknown class

define('EXIT_UNKNOWN_METHOD', 6); // unknown class member

define('EXIT_USER_INPUT', 7); // invalid user input

define('EXIT_DATABASE', 8); // database error

define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code

define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



/******************************/

define('API_KEY', '');

define('WEBSITE_URL', $BASE_URL);
define('PINKQR_ASSETS', $BASE_URL);

define('SYSADMIN_URL', $BASE_URL . 'sysadmin/');

define('WEBSITE_ASSETS', $BASE_URL . 'assets/');

define('ASSETS_URL', cdn_url() . 'assets/');

define('SYSADMIN_ASSETS', WEBSITE_ASSETS . 'sysadmin/');

define('PRODUCT_IMAGE_URL', WEBSITE_ASSETS . 'uploads/product/');

define('ASSETS_PATH', cdn_path());



define('MAP_API', ""); 

define('DISTANCE_MATRIX_MAP_API', "");

define('PRODUCT_IMAGE_PATH', cdn_path() . 'uploads' . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR);

define('BRAND_IMAGE_PATH', cdn_path() . 'uploads' . DIRECTORY_SEPARATOR . 'brand' . DIRECTORY_SEPARATOR);

/******************************/
define('SELLER_ID', 7);
define('SUPERADMIN_ID', 1);
define('MAINSITE_URL', $BASE_URL);

define('DIR_FS_CATALOG', $BASE_URL);

define('DIR_WS_CATALOG', FCPATH);

define('MAINSITE_IMAGES_PATH', $BASE_URL . 'assets/images/');

define('MAINSITE_CSS_PATH', $BASE_URL . 'assets/css/');

define('MAINSITE_SCRIPTS_PATH', $BASE_URL . 'assets/js/');

define('MAINSITE_ASSETS_PATH', $BASE_URL . 'assets/');

define('MAINSITE_MADMIN_URL', $BASE_URL . 'sysadmin/');

define('UPLOAD_BANNER_IMAGES', DIR_WS_CATALOG . 'assets/uploads/banner/');

define('UPLOAD_FS_BANNER_IMAGES', DIR_FS_CATALOG . 'assets/uploads/banner/');

define('BANNER_IMAGE_WIDTH',        '1088');

define('BANNER_IMAGE_HEIGHT',       '514');



define('BANNER_IOS_IMAGE_WIDTH',        '720');

define('BANNER_IOS_IMAGE_HEIGHT',       '350');



define('BANNER_FREE_IMAGE_WIDTH',       '700');

define('BANNER_FREE_IMAGE_HEIGHT',      '425');

define('BANNER_IMAGE_MAX_WIDTH',        '2000');

define('UPLOAD_CATEGORY_IMAGES', DIR_WS_CATALOG . 'assets/uploads/category/');

define('UPLOAD_OFFER_BANNER_IMAGES', DIR_WS_CATALOG . 'assets/uploads/offerbanner/');

define('UPLOAD_FS_CATEGORY_IMAGES', DIR_FS_CATALOG . 'assets/uploads/category/');

define('CATEGORY_IMAGE_WIDTH',      '181');

define('CATEGORY_IMAGE_HEIGHT',     '135');

define('UPLOAD_PRODUCT_IMAGE_PATH', DIR_WS_CATALOG . 'assets/uploads/product/');

define('UPLOAD_FS_PRODUCT_IMAGE_PATH', DIR_FS_CATALOG . 'assets/uploads/product/');

define('PRODUCT_IMAGE_WIDTH',       '2500');

define('PRODUCT_IMAGE_HEIGHT',      '1668');

define('UPLOAD_PRODUCT_SMALL_IMAGE_PATH', DIR_WS_CATALOG . 'assets/uploads/product/small/');

define('UPLOAD_FS_PRODUCT_SMALL_IMAGE_PATH', DIR_FS_CATALOG . 'assets/uploads/product/small/');

define('PRODUCT_SMALL_IMAGE_WIDTH',     '667');

define('PRODUCT_SMALL_IMAGE_HEIGHT',        '446');

define('UPLOAD_PRODUCT_THUMB_IMAGE_PATH', DIR_WS_CATALOG . 'assets/uploads/product/thumb/');

define('UPLOAD_FS_PRODUCT_THUMB_IMAGE_PATH', DIR_FS_CATALOG . 'assets/uploads/product/thumb/');

define('PRODUCT_THUMB_IMAGE_WIDTH',     '220');

define('PRODUCT_THUMB_IMAGE_HEIGHT',        '220');

define('UPLOAD_BLOG_CATEGORY_IMAGE_PATH', DIR_WS_CATALOG . 'assets/uploads/blogCategory/');

define('UPLOAD_FS_BLOG_CATEGORY_IMAGE_PATH', DIR_FS_CATALOG . 'assets/uploads/blogCategory/');

define('BLOG_CATEGORY_IMAGE_WIDTH', '181');

define('BLOG_CATEGORY_IMAGE_HEIGHT', '135');

//relative path------------

define('UPLOAD_BLOG_IMAGE_RELPATH', './assets/uploads/blog/');

define('UPLOAD_BASKET_IMAGE_RELPATH', './assets/uploads/basket/');

define('UPLOAD_FS_BLOG_IMAGE_RELPATH', './assets/uploads/blog/');

define('UPLOAD_BRAND_FILE_RELPATH', './assets/uploads/brand/');

define('FOLDER_BRAND_FILE_RELPATH', './assets/uploads/brand/');

define('UPLOAD_OFFERS_FILE_RELPATH', './assets/uploads/offers/');

define('UPLOAD_PRODUCT_IMAGE_RELPATH', './assets/uploads/product/');

//-----------------------

define('UPLOAD_BLOG_IMAGE_PATH', DIR_WS_CATALOG . 'assets/uploads/blog/');

define('UPLOAD_BASKET_IMAGE_PATH', DIR_WS_CATALOG . 'assets/uploads/basket/');

define('UPLOAD_FS_BLOG_IMAGE_PATH', DIR_FS_CATALOG . 'assets/uploads/blog/');

define('UPLOAD_FS_BASKET_IMAGE_PATH', DIR_FS_CATALOG . 'assets/uploads/basket/');

define('UPLOAD_BRAND_FILE_PATH', DIR_WS_CATALOG . 'assets/uploads/brand/');

define('FOLDER_BRAND_FILE_PATH', DIR_FS_CATALOG . 'assets/uploads/brand/');

//--------------------



define('FOLDER_RECIPE_FILE_PATH', DIR_FS_CATALOG . 'assets/uploads/trending_recipe/');

//------------------------------

define('BRAND_WIDTH', '185');

define('BRAND_HEIGHT', '130');

define('UPLOAD_OFFERS_FILE_PATH', DIR_WS_CATALOG . 'assets/uploads/offers/');

define('FOLDER_OFFERS_FILE_PATH', DIR_FS_CATALOG . 'assets/uploads/offers/');

define('OFFERS_WIDTH', '365');

define('OFFERS_HEIGHT', '255');





define('OFFER_BANNER_WIDTH', '385');

define('OFFER_BANNER_HEIGHT', '269');

//-----------ios/android-------------

define('OFFER_BANNER_WIDTH_IOS', '720');

define('OFFER_BANNER_HEIGHT_IOS', '350');

//---------------

define('UPLOAD_CATEGORY_FILE_PATH', DIR_WS_CATALOG . 'assets/uploads/category/');

define('FOLDER_CATEGORY_FILE_PATH', DIR_FS_CATALOG . 'assets/uploads/category/');

define('UPLOAD_IOS_BANNER_FILE_PATH', DIR_WS_CATALOG . 'admin/');

define('FOLDER_IOS_BANNER_FILE_PATH', DIR_FS_CATALOG . 'admin/');

$browser_id = session_id();

$hash1 = hash('sha256', 'sham@#$%123' . $browser_id);

$login_ip = '127.0.0.1';

define('HASH_VALUE', $hash1);

define('LOGIN_IP', $login_ip);

define('ENCRYPTION_KEY_MOD', 'smno1');

define('CACHE_EXPIRE', '2592000');

define('MailChimp_API_KEY', "");

define('MailChimp_LIST_ID', "");

define('Gofrugal_items_url', "");

define('Gofrugal_Auth_Token', "");



define('ADMIN_STORE_LOGO', ASSETS_URL . 'images/logo/');

define('EMAIL_SMTP_HOST', '');//vmi834958.contaboserver.net

define('EMAIL_SMTP_PORT', '25');

define('EMAIL_SMTP_USER', '');//connect@pinkqr.com

define('EMAIL_SMTP_PASS', '');//RXTiKtuBE7tj

define('ORDER_SMTP_USER', '');//order@pinkqr.com

define('ORDER_SMTP_PASS', 'JioUhVN');

define('DASHBOARD_ASSETS', WEBSITE_ASSETS . 'dashboard/');

if ($_SERVER['HTTP_HOST'] == 'localhost') {

    define('CACHE_PATH', FCPATH . 'cache\\');
}

define('RECAPCHA_SITE_KEY', '');
define('RECAPCHA_SECRET_KEY', '');
