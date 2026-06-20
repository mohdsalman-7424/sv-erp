<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Enforce admin check (role_id 1)
        if ($this->session->userdata('role_id') != 1) {
            if ($this->session->userdata('role_id') == 2) {
                redirect('astrologer');
            } else {
                redirect('user');
            }
        }
    }

    private function _base() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('user_model');
        $user = $this->user_model->get_by_id($user_id);
        
        $name = !empty($user) ? $user['name'] : 'Admin';
        $initial = strtoupper(substr($name, 0, 1));
        
        return [
            'dashboard_role' => 'admin',
            'user_initial'   => $initial,
            'user_name'      => $name,
            'current_user'   => $user
        ];
    }

    private function _render($view, $data = []) {
        $this->load->view('layouts/dashboard_header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/dashboard_footer', $data);
    }

    public function index() {
        $this->load->model(['user_model', 'astrologer_model', 'subscription_plan_model', 'user_address_model']);
        $total_users = $this->user_model->count_all();
        $total_astros = $this->astrologer_model->count_all();
        $total_plans = $this->subscription_plan_model->count_all();

        $recent_users = $this->user_model->get_all('id', 'DESC', 3);
        $top_astros = $this->astrologer_model->get_all('rating', 'DESC', 3);

        $data = array_merge($this->_base(), [
            'page_title' => 'Admin Dashboard',
            'active_sidebar' => 'dashboard',
            'total_users' => $total_users,
            'total_astros' => $total_astros,
            'total_plans' => $total_plans,
            'recent_users' => $recent_users,
            'top_astros' => $top_astros
        ]);
        $this->_render('admin/dashboard', $data);
    }
    public function profile() {
        $data = array_merge($this->_base(), ['page_title' => 'Admin Profile', 'active_sidebar' => 'profile']);
        $this->_render('admin/profile', $data);
    }
    public function users() {
        $this->load->model(['user_model', 'user_profile_model', 'user_address_model', 'wallet_model']);
        $users_db = $this->user_model->get_all();
        
        $data = array_merge($this->_base(), [
            'page_title' => 'Manage Users',
            'active_sidebar' => 'users',
            'users_db' => $users_db
        ]);
        $this->_render('admin/users', $data);
    }

    public function save_user() {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|regex_match[/^[0-9+\-\s]{0,15}$/]');
        $this->form_validation->set_rules('city', 'City', 'trim|max_length[100]');
        $this->form_validation->set_rules('rashi', 'Rashi', 'trim|max_length[50]');

        if ($this->form_validation->run() === FALSE) {
            $error = strip_tags(validation_errors(' ', ' '));
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('admin_dashboard/users');
        }

        $this->load->model(['user_model', 'user_profile_model', 'user_address_model', 'wallet_model']);
        $id = $this->input->post('id', TRUE);
        $name = trim(strip_tags($this->input->post('name', TRUE)));
        $email = strtolower(trim($this->input->post('email', TRUE)));
        $phone = preg_replace('/[^0-9+]/', '', $this->input->post('phone', TRUE));
        $city = trim(strip_tags($this->input->post('city', TRUE)));
        $rashi = trim(strip_tags($this->input->post('rashi', TRUE)));
        
        $db_data = [
            'name' => $name,
            'email' => $email,
            'mobile' => $phone,
            'role_id' => 3
        ];

        $msg = '';
        if ($id && is_numeric($id)) {
            $this->user_model->update($id, $db_data);
            $user_id = $id;
            $msg = 'User updated successfully.';
            $this->session->set_flashdata('success', $msg);
        } else {
            $temp_password = generate_temp_password();
            $db_data['password'] = password_hash($temp_password, PASSWORD_BCRYPT);
            $db_data['status'] = 1;
            $user_id = $this->user_model->insert($db_data);
            $msg = 'User created. Temporary password: ' . $temp_password;
            $this->session->set_flashdata('success', $msg);
        }

        // Save address
        $address = $this->user_address_model->get_where(['user_id' => $user_id]);
        if (!empty($address)) {
            $this->user_address_model->update($address[0]['id'], ['city' => $city]);
        } else {
            $this->user_address_model->insert(['user_id' => $user_id, 'city' => $city]);
        }

        // Save profile
        $profile = $this->user_profile_model->get_where(['user_id' => $user_id]);
        if (!empty($profile)) {
            $this->user_profile_model->update($profile[0]['id'], ['bio' => $rashi]);
        } else {
            $this->user_profile_model->insert(['user_id' => $user_id, 'bio' => $rashi]);
        }

        // Save wallet
        $wallet = $this->wallet_model->get_where(['user_id' => $user_id]);
        if (empty($wallet)) {
            $this->wallet_model->insert(['user_id' => $user_id, 'balance' => 0.00]);
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true, 
                'message' => $msg
            ]));
            return;
        }

        redirect('admin_dashboard/users');
    }

    public function astrologers() {
        $this->load->model(['astrologer_model', 'user_model', 'user_address_model']);
        $astrologers_db = $this->astrologer_model->get_all();
        
        $data = array_merge($this->_base(), [
            'page_title' => 'Manage Astrologers',
            'active_sidebar' => 'astrologers',
            'astrologers_db' => $astrologers_db
        ]);
        $this->_render('admin/astrologers', $data);
    }

    public function save_astrologer() {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('exp', 'Experience', 'trim|integer|greater_than_equal_to[0]|less_than_equal_to[80]');
        $this->form_validation->set_rules('rating', 'Rating', 'trim|numeric|greater_than_equal_to[0]|less_than_equal_to[5]');
        $this->form_validation->set_rules('reviews', 'Reviews', 'trim|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('city', 'City', 'trim|max_length[100]');
        $this->form_validation->set_rules('languages', 'Languages', 'trim|max_length[255]');
        $this->form_validation->set_rules('expertise', 'Expertise', 'trim|max_length[255]');

        if ($this->form_validation->run() === FALSE) {
            $error = strip_tags(validation_errors(' ', ' '));
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('admin_dashboard/astrologers');
        }

        $this->load->model(['astrologer_model', 'user_model', 'user_address_model']);
        $id = $this->input->post('id', TRUE);
        $name = trim(strip_tags($this->input->post('name', TRUE)));
        $exp = $this->input->post('exp', TRUE);
        $rating = $this->input->post('rating', TRUE);
        $reviews = $this->input->post('reviews', TRUE);
        $online = $this->input->post('online') ? 1 : 0;
        $city = trim(strip_tags($this->input->post('city', TRUE)));
        $languages = trim(strip_tags($this->input->post('languages', TRUE)));
        $expertise = trim(strip_tags($this->input->post('expertise', TRUE)));

        $user_id = null;
        if ($id && is_numeric($id)) {
            $astro = $this->astrologer_model->get_by_id($id);
            if ($astro) $user_id = $astro['user_id'];
        }

        $msg = '';
        if ($user_id) {
            $this->user_model->update($user_id, ['name' => $name]);
            $msg = 'Astrologer details updated.';
            $this->session->set_flashdata('success', $msg);
        } else {
            $temp_password = generate_temp_password();
            $user_id = $this->user_model->insert([
                'name' => $name,
                'email' => strtolower(url_title($name)) . '@astroveda.in',
                'password' => password_hash($temp_password, PASSWORD_BCRYPT),
                'role_id' => 2,
                'status' => 1
            ]);
            $msg = 'Astrologer created. Temporary password: ' . $temp_password;
            $this->session->set_flashdata('success', $msg);
        }

        $astro_data = [
            'user_id' => $user_id,
            'experience_years' => intval($exp),
            'rating' => floatval($rating),
            'total_reviews' => intval($reviews),
            'is_online' => $online,
            'languages' => $languages,
            'expertise' => $expertise,
            'approval_status' => 'approved'
        ];

        if ($id && is_numeric($id)) {
            $this->astrologer_model->update($id, $astro_data);
        } else {
            $this->astrologer_model->insert($astro_data);
        }

        // Save address
        $address = $this->user_address_model->get_where(['user_id' => $user_id]);
        if (!empty($address)) {
            $this->user_address_model->update($address[0]['id'], ['city' => $city]);
        } else {
            $this->user_address_model->insert(['user_id' => $user_id, 'city' => $city]);
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true, 
                'message' => $msg
            ]));
            return;
        }

        redirect('admin_dashboard/astrologers');
    }

    public function delete_astrologer($id) {
        $this->load->model('astrologer_model');
        $this->astrologer_model->delete($id);
        redirect('admin_dashboard/astrologers');
    }

    public function subscription_plans() {
        $this->load->model(['subscription_plan_model']);
        $plans_db = $this->subscription_plan_model->get_all();
        
        $data = array_merge($this->_base(), [
            'page_title' => 'Subscription Plans',
            'active_sidebar' => 'plans',
            'plans_db' => $plans_db
        ]);
        $this->_render('admin/subscription_plans', $data);
    }

    public function save_plan() {
        $this->form_validation->set_rules('name', 'Plan Name', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('duration', 'Duration', 'required|integer|greater_than[0]|less_than_equal_to[3650]');
        $this->form_validation->set_rules('features', 'Features', 'trim|max_length[1000]');

        if ($this->form_validation->run() === FALSE) {
            $error = strip_tags(validation_errors(' ', ' '));
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('admin_dashboard/subscription_plans');
        }

        $this->load->model(['subscription_plan_model']);
        $id = $this->input->post('id', TRUE);
        $name = trim(strip_tags($this->input->post('name', TRUE)));
        $price = $this->input->post('price', TRUE);
        $duration = $this->input->post('duration', TRUE);
        $features = trim(strip_tags($this->input->post('features', TRUE)));

        $db_data = [
            'name' => $name,
            'price' => floatval($price),
            'duration' => intval($duration),
            'features' => json_encode(explode(',', $features)),
            'status' => 1
        ];

        $msg = '';
        if ($id && is_numeric($id)) {
            $this->subscription_plan_model->update($id, $db_data);
            $msg = 'Subscription plan updated successfully.';
            $this->session->set_flashdata('success', $msg);
        } else {
            $this->subscription_plan_model->insert($db_data);
            $msg = 'Subscription plan created successfully.';
            $this->session->set_flashdata('success', $msg);
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => $msg
            ]));
            return;
        }

        redirect('admin_dashboard/subscription_plans');
    }
    public function invoices() {
        $data = array_merge($this->_base(), ['page_title' => 'Invoices', 'active_sidebar' => 'invoices']);
        $this->_render('admin/invoices', $data);
    }
    public function payments() {
        $data = array_merge($this->_base(), ['page_title' => 'Payments', 'active_sidebar' => 'payments']);
        $this->_render('admin/payments', $data);
    }
    public function revenue_reports() {
        $data = array_merge($this->_base(), ['page_title' => 'Revenue Reports', 'active_sidebar' => 'revenue']);
        $this->_render('admin/revenue_reports', $data);
    }
    public function support() {
        $data = array_merge($this->_base(), ['page_title' => 'Support Tickets', 'active_sidebar' => 'support']);
        $this->_render('admin/support', $data);
    }
    public function cms_pages() {
        $data = array_merge($this->_base(), ['page_title' => 'CMS Pages', 'active_sidebar' => 'cms']);
        $this->_render('admin/cms_pages', $data);
    }
    public function blogs() {
        $data = array_merge($this->_base(), ['page_title' => 'Blog Management', 'active_sidebar' => 'blogs']);
        $this->_render('admin/blogs', $data);
    }
    public function testimonials() {
        $data = array_merge($this->_base(), ['page_title' => 'Testimonials', 'active_sidebar' => 'testimonials']);
        $this->_render('admin/testimonials', $data);
    }
    public function notifications() {
        $data = array_merge($this->_base(), ['page_title' => 'Notifications', 'active_sidebar' => 'notifications']);
        $this->_render('admin/notifications', $data);
    }
    public function referrals() {
        $data = array_merge($this->_base(), ['page_title' => 'Referral Program', 'active_sidebar' => 'referrals']);
        $this->_render('admin/referrals', $data);
    }
    public function wallet() {
        $data = array_merge($this->_base(), ['page_title' => 'Wallet Management', 'active_sidebar' => 'wallet']);
        $this->_render('admin/wallet', $data);
    }
    public function coupons() {
        $data = array_merge($this->_base(), ['page_title' => 'Coupon Manager', 'active_sidebar' => 'coupons']);
        $this->_render('admin/coupons', $data);
    }
    public function gst() {
        $data = array_merge($this->_base(), ['page_title' => 'GST Reports', 'active_sidebar' => 'gst']);
        $this->_render('admin/gst', $data);
    }
    public function seo() {
        $data = array_merge($this->_base(), ['page_title' => 'SEO Manager', 'active_sidebar' => 'seo']);
        $this->_render('admin/seo', $data);
    }
    public function email_templates() {
        $data = array_merge($this->_base(), ['page_title' => 'Email Templates', 'active_sidebar' => 'emails']);
        $this->_render('admin/email_templates', $data);
    }
    public function sms_templates() {
        $data = array_merge($this->_base(), ['page_title' => 'SMS Templates', 'active_sidebar' => 'sms']);
        $this->_render('admin/sms_templates', $data);
    }
    public function push_notifications() {
        $data = array_merge($this->_base(), ['page_title' => 'Push Notifications', 'active_sidebar' => 'push']);
        $this->_render('admin/push_notifications', $data);
    }
    public function settings() {
        $data = array_merge($this->_base(), ['page_title' => 'System Settings', 'active_sidebar' => 'settings']);
        $this->_render('admin/settings', $data);
    }
}
