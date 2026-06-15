<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ─── PUBLIC ROUTES ───────────────────────────────────────────────
$route['default_controller'] = 'Home';
$route['404_override']        = 'Errors/page_404';
$route['translate_uri_dashes'] = TRUE;

// Home
$route['']              = 'Home/index';
$route['about']         = 'Home/about';
$route['contact']       = 'Home/contact';
$route['plans']         = 'Home/plans';
$route['blog']          = 'Home/blog';
$route['blog/(:any)']   = 'Home/blog_detail/$1';
$route['careers']       = 'Home/careers';
$route['privacy-policy']  = 'Home/privacy_policy';
$route['terms']           = 'Home/terms';
$route['refund-policy']   = 'Home/refund_policy';

// Astrologers (public)
$route['astrologers']           = 'Astrologers_ctrl/index';
$route['astrologers/(:any)']    = 'Astrologers_ctrl/detail/$1';

// Tools (public)
$route['tools/kundali-generator']  = 'Tools/kundali_generator';
$route['tools/kundali-matching']   = 'Tools/kundali_matching';
$route['tools/daily-horoscope']    = 'Tools/daily_horoscope';
$route['tools/yearly-horoscope']   = 'Tools/yearly_horoscope';
$route['tools/panchang']           = 'Tools/panchang';
$route['tools/muhurat']            = 'Tools/muhurat';
$route['tools/festival-calendar']  = 'Tools/festival_calendar';
$route['tools/shop']               = 'Tools/shop';

// Auth
$route['auth/login']    = 'Auth/login';
$route['auth/register'] = 'Auth/register';
$route['auth/logout']   = 'Auth/logout';
$route['auth/do-login'] = 'Auth/do_login';
$route['auth/do-register'] = 'Auth/do_register';
$route['auth/forgot-password'] = 'Auth/forgot_password';
$route['auth/do-forgot-password'] = 'Auth/do_forgot_password';


// ─── USER DASHBOARD ──────────────────────────────────────────────
$route['user']                      = 'User_dashboard/index';
$route['user/profile']              = 'User_dashboard/profile';
$route['user/subscriptions']        = 'User_dashboard/subscriptions';
$route['user/invoices']             = 'User_dashboard/invoices';
$route['user/kundali-reports']      = 'User_dashboard/kundali_reports';
$route['user/kundali-matching']     = 'User_dashboard/kundali_matching';
$route['user/horoscope-reports']    = 'User_dashboard/horoscope_reports';
$route['user/consultations']        = 'User_dashboard/consultations';
$route['user/wallet']               = 'User_dashboard/wallet';
$route['user/notifications']        = 'User_dashboard/notifications';
$route['user/support']              = 'User_dashboard/support';
$route['user/referrals']            = 'User_dashboard/referrals';
$route['user/transactions']         = 'User_dashboard/transactions';

// ─── ASTROLOGER DASHBOARD ────────────────────────────────────────
$route['astrologer']                          = 'Astrologer_dashboard/index';
$route['astrologer/profile']                  = 'Astrologer_dashboard/profile';
$route['astrologer/service-plans']            = 'Astrologer_dashboard/service_plans';
$route['astrologer/customers']                = 'Astrologer_dashboard/customers';
$route['astrologer/orders']                   = 'Astrologer_dashboard/orders';
$route['astrologer/predictions']              = 'Astrologer_dashboard/predictions';
$route['astrologer/kundali-engine']           = 'Astrologer_dashboard/kundali_engine';
$route['astrologer/earnings']                 = 'Astrologer_dashboard/earnings';
$route['astrologer/withdrawals']              = 'Astrologer_dashboard/withdrawals';
$route['astrologer/calendar']                 = 'Astrologer_dashboard/calendar';
$route['astrologer/live-chat']                = 'Astrologer_dashboard/live_chat';
$route['astrologer/video-consultations']      = 'Astrologer_dashboard/video_consultations';
$route['astrologer/notifications']            = 'Astrologer_dashboard/notifications';
$route['astrologer/support']                  = 'Astrologer_dashboard/support';

// ─── ADMIN DASHBOARD ─────────────────────────────────────────────
$route['admin']                       = 'Admin_dashboard/index';
$route['admin/profile']               = 'Admin_dashboard/profile';
$route['admin/users']                 = 'Admin_dashboard/users';
$route['admin/astrologers']           = 'Admin_dashboard/astrologers';
$route['admin/subscription-plans']    = 'Admin_dashboard/subscription_plans';
$route['admin/invoices']              = 'Admin_dashboard/invoices';
$route['admin/payments']              = 'Admin_dashboard/payments';
$route['admin/revenue-reports']       = 'Admin_dashboard/revenue_reports';
$route['admin/support']               = 'Admin_dashboard/support';
$route['admin/cms-pages']             = 'Admin_dashboard/cms_pages';
$route['admin/blogs']                 = 'Admin_dashboard/blogs';
$route['admin/testimonials']          = 'Admin_dashboard/testimonials';
$route['admin/notifications']         = 'Admin_dashboard/notifications';
$route['admin/referrals']             = 'Admin_dashboard/referrals';
$route['admin/wallet']                = 'Admin_dashboard/wallet';
$route['admin/coupons']               = 'Admin_dashboard/coupons';
$route['admin/gst']                   = 'Admin_dashboard/gst';
$route['admin/seo']                   = 'Admin_dashboard/seo';
$route['admin/email-templates']       = 'Admin_dashboard/email_templates';
$route['admin/sms-templates']         = 'Admin_dashboard/sms_templates';
$route['admin/push-notifications']    = 'Admin_dashboard/push_notifications';
$route['admin/settings']              = 'Admin_dashboard/settings';

$route['admin/save-user']             = 'Admin_dashboard/save_user';
$route['admin/save-astrologer']       = 'Admin_dashboard/save_astrologer';
$route['admin/delete-astrologer/(:any)'] = 'Admin_dashboard/delete_astrologer/$1';
$route['admin/save-plan']             = 'Admin_dashboard/save_plan';

$route['user/save-profile']           = 'User_dashboard/save_profile';
$route['user/purchase-plan']          = 'User_dashboard/purchase_plan';
$route['user/save-kundali']           = 'User_dashboard/save_kundali';
$route['user/save-match']             = 'User_dashboard/save_match';
$route['user/book-consultation']      = 'User_dashboard/book_consultation';
$route['user/recharge-wallet']        = 'User_dashboard/recharge_wallet';
$route['user/save-ticket']            = 'User_dashboard/save_ticket';

$route['astrologer/toggle-status']    = 'Astrologer_dashboard/toggle_status';
$route['astrologer/save-profile']     = 'Astrologer_dashboard/save_profile';
$route['astrologer/save-plan']        = 'Astrologer_dashboard/save_plan';
$route['astrologer/delete-plan/(:num)'] = 'Astrologer_dashboard/delete_plan/$1';
$route['astrologer/update-consultation/(:num)/(:any)'] = 'Astrologer_dashboard/update_consultation/$1/$2';
$route['astrologer/save-prediction/(:num)'] = 'Astrologer_dashboard/save_prediction/$1';
$route['astrologer/save-slot']        = 'Astrologer_dashboard/save_slot';
$route['astrologer/delete-slot/(:num)'] = 'Astrologer_dashboard/delete_slot/$1';
$route['astrologer/request-withdrawal'] = 'Astrologer_dashboard/request_withdrawal';
$route['astrologer/save-ticket']      = 'Astrologer_dashboard/save_ticket';

