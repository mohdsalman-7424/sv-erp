<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Enforce role check: only standard users (role_id 3)
        if ($this->session->userdata('role_id') != 3) {
            if ($this->session->userdata('role_id') == 1) {
                redirect('admin');
            } elseif ($this->session->userdata('role_id') == 2) {
                redirect('astrologer');
            }
        }
    }

    private function _base() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model(['user_model', 'user_profile_model', 'user_address_model', 'wallet_model']);
        $user = $this->user_model->get_by_id($user_id);
        
        $name = !empty($user) ? $user['name'] : 'User';
        $initial = strtoupper(substr($name, 0, 1));
        
        return [
            'dashboard_role' => 'user',
            'user_initial'   => $initial,
            'user_name'      => $name,
            'user_email'     => !empty($user) ? $user['email'] : '',
            'current_user'   => $user
        ];
    }

    private function _render($view, $data = []) {
        $this->load->view('layouts/dashboard_header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/dashboard_footer', $data);
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model(['wallet_model', 'kundali_model', 'consultation_model', 'user_subscription_model', 'subscription_plan_model']);
        
        $wallet = $this->wallet_model->get_where(['user_id' => $user_id]);
        $balance = !empty($wallet) ? $wallet[0]['balance'] : 0.00;
        
        $kundalis_count = $this->kundali_model->count_all(['user_id' => $user_id]);
        $consultations_count = $this->consultation_model->count_all(['user_id' => $user_id]);
        
        $sub = $this->user_subscription_model->get_where(['user_id' => $user_id, 'status' => 1]);
        $plan_name = 'Free Seekers';
        $valid_till = 'Lifetime';
        if (!empty($sub)) {
            $plan = $this->subscription_plan_model->get_by_id($sub[0]['plan_id']);
            if (!empty($plan)) {
                $plan_name = $plan['name'];
            }
            $valid_till = date('d M Y', strtotime($sub[0]['end_date']));
        }

        $data = array_merge($this->_base(), [
            'page_title'          => 'My Dashboard',
            'active_sidebar'      => 'dashboard',
            'wallet_balance'      => $balance,
            'kundalis_count'      => $kundalis_count,
            'consultations_count' => $consultations_count,
            'active_plan'         => $plan_name,
            'plan_expiry'         => $valid_till
        ]);
        $this->_render('user/dashboard', $data);
    }

    public function profile() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'My Profile',
            'active_sidebar' => 'profile',
        ]);
        $this->_render('user/profile', $data);
    }

    public function save_profile() {
        $user_id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|regex_match[/^[0-9+\-\s]{10,15}$/]');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim');
        $this->form_validation->set_rules('birth_time', 'Birth Time', 'trim');
        $this->form_validation->set_rules('birth_place', 'Birth Place', 'trim|max_length[255]');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|max_length[20]');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|max_length[20]');
        $this->form_validation->set_rules('bio', 'Bio', 'trim|max_length[1000]');
        $this->form_validation->set_rules('address', 'Address', 'trim|max_length[500]');
        $this->form_validation->set_rules('city', 'City', 'trim|max_length[100]');
        $this->form_validation->set_rules('state', 'State', 'trim|max_length[100]');
        $this->form_validation->set_rules('country', 'Country', 'trim|max_length[100]');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|regex_match[/^[0-9A-Za-z\- ]{0,10}$/]');

        if ($this->form_validation->run() === FALSE) {
            $error = strip_tags(validation_errors(' ', ' '));
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('user/profile');
        }

        $this->load->model(['user_model', 'user_profile_model', 'user_address_model']);

        $name = trim(strip_tags($this->input->post('name', TRUE)));
        $mobile = preg_replace('/[^0-9+]/', '', $this->input->post('mobile', TRUE));
        
        $dob = $this->input->post('dob', TRUE);
        $birth_time = $this->input->post('birth_time', TRUE);
        $birth_place = trim(strip_tags($this->input->post('birth_place', TRUE)));
        $gender = trim(strip_tags($this->input->post('gender', TRUE)));
        $marital_status = trim(strip_tags($this->input->post('marital_status', TRUE)));
        $bio = trim(strip_tags($this->input->post('bio', TRUE)));

        $address = trim(strip_tags($this->input->post('address', TRUE)));
        $city = trim(strip_tags($this->input->post('city', TRUE)));
        $state = trim(strip_tags($this->input->post('state', TRUE)));
        $country = trim(strip_tags($this->input->post('country', TRUE)));
        $pincode = trim(strip_tags($this->input->post('pincode', TRUE)));

        // Update basic user details
        $this->user_model->update($user_id, [
            'name'   => $name,
            'mobile' => $mobile
        ]);

        // Update/Insert profile
        $prof = $this->user_profile_model->get_where(['user_id' => $user_id]);
        $profile_data = [
            'user_id'        => $user_id,
            'gender'         => $gender,
            'dob'            => !empty($dob) ? $dob : NULL,
            'birth_time'     => !empty($birth_time) ? $birth_time : NULL,
            'birth_place'    => $birth_place,
            'marital_status' => $marital_status,
            'bio'            => $bio
        ];
        if (!empty($prof)) {
            $this->user_profile_model->update($prof[0]['id'], $profile_data);
        } else {
            $this->user_profile_model->insert($profile_data);
        }

        // Update/Insert address
        $addr = $this->user_address_model->get_where(['user_id' => $user_id]);
        $address_data = [
            'user_id' => $user_id,
            'address' => $address,
            'city'    => $city,
            'state'   => $state,
            'country' => $country,
            'pincode' => $pincode
        ];
        if (!empty($addr)) {
            $this->user_address_model->update($addr[0]['id'], $address_data);
        } else {
            $this->user_address_model->insert($address_data);
        }

        $msg = 'Profile updated successfully!';
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => $msg
            ]));
            return;
        }

        $this->session->set_flashdata('success', $msg);
        redirect('user/profile');
    }

    public function subscriptions() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'My Subscriptions',
            'active_sidebar' => 'subscriptions',
        ]);
        $this->_render('user/subscriptions', $data);
    }

    public function purchase_plan() {
        $user_id = $this->session->userdata('user_id');
        $plan_id = intval($this->input->post('plan_id'));

        $this->load->model(['subscription_plan_model', 'user_subscription_model', 'wallet_model', 'wallet_transaction_model', 'invoice_model']);
        $plan = $this->subscription_plan_model->get_by_id($plan_id);

        if (!$plan) {
            $error = 'Plan not found.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('user/subscriptions');
        }

        $wallet = $this->wallet_model->get_where(['user_id' => $user_id]);
        $balance = !empty($wallet) ? $wallet[0]['balance'] : 0.00;

        if ($balance < $plan['price']) {
            $error = 'Insufficient wallet balance. Please recharge.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('user/wallet');
        }

        // Deduct balance
        $new_balance = $balance - $plan['price'];
        $this->wallet_model->update($wallet[0]['id'], ['balance' => $new_balance]);

        // Deactivate old subscriptions
        $this->db->where('user_id', $user_id)->update('user_subscriptions', ['status' => 0]);

        // Insert new subscription
        $start_date = date('Y-m-d H:i:s');
        $end_date = date('Y-m-d H:i:s', strtotime('+' . $plan['duration'] . ' days'));
        $this->user_subscription_model->insert([
            'user_id'    => $user_id,
            'plan_id'    => $plan_id,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'status'     => 1
        ]);

        // Create transaction log
        $this->wallet_transaction_model->insert([
            'wallet_id'    => $wallet[0]['id'],
            'type'         => 'debit',
            'credit_debit' => 'debit',
            'amount'       => $plan['price'],
            'remark'       => 'Subscribed to plan: ' . $plan['name']
        ]);

        // Generate invoice
        $invoice_no = 'INV-' . strtoupper(uniqid());
        $amount_base = $plan['price'] / 1.18;
        $gst = $plan['price'] - $amount_base;
        $this->invoice_model->insert([
            'invoice_no'     => $invoice_no,
            'order_id'       => 1, // dummy order id
            'user_id'        => $user_id,
            'amount'         => $amount_base,
            'gst'            => $gst,
            'total'          => $plan['price'],
            'payment_status' => 'Paid'
        ]);

        $msg = 'Successfully subscribed to ' . $plan['name'] . '!';
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => $msg,
                'redirect' => site_url('user/subscriptions')
            ]));
            return;
        }

        $this->session->set_flashdata('success', $msg);
        redirect('user/subscriptions');
    }

    public function invoices() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Invoices',
            'active_sidebar' => 'invoices',
        ]);
        $this->_render('user/invoices', $data);
    }

    public function kundali_reports() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Kundali Reports',
            'active_sidebar' => 'kundali',
        ]);
        $this->_render('user/kundali_reports', $data);
    }

    public function save_kundali() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('kundali_model');

        $name = $this->input->post('name');
        $dob = $this->input->post('dob');
        $birth_time = $this->input->post('birth_time');
        $birth_place = $this->input->post('birth_place');
        $latitude = $this->input->post('latitude') ?: '19.0760';
        $longitude = $this->input->post('longitude') ?: '72.8777';

        $this->kundali_model->insert([
            'user_id'     => $user_id,
            'name'        => $name,
            'dob'         => $dob,
            'birth_time'  => $birth_time,
            'birth_place' => $birth_place,
            'latitude'    => $latitude,
            'longitude'   => $longitude
        ]);

        $msg = 'Janam Kundali generated successfully!';
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => $msg,
                'redirect' => site_url('user/kundali-reports')
            ]));
            return;
        }

        $this->session->set_flashdata('success', $msg);
        redirect('user/kundali-reports');
    }

    public function kundali_matching() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Kundali Matching',
            'active_sidebar' => 'matching',
        ]);
        $this->_render('user/kundali_matching', $data);
    }

    public function save_match() {
        $this->load->model('kundali_match_model');
        $male_id = intval($this->input->post('male_kundali_id'));
        $female_id = intval($this->input->post('female_kundali_id'));

        // Generate dynamic mock Guna score (out of 36)
        $guna_score = rand(15, 32);

        $this->kundali_match_model->insert([
            'male_kundali_id'   => $male_id,
            'female_kundali_id' => $female_id,
            'guna_score'        => $guna_score,
            'report'            => 'Gun Milan score calculated at ' . $guna_score . '. Compatibility report completed.'
        ]);

        $msg = 'Compatibility match computed successfully!';
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => $msg,
                'redirect' => site_url('user/kundali-matching')
            ]));
            return;
        }

        $this->session->set_flashdata('success', $msg);
        redirect('user/kundali-matching');
    }

    public function horoscope_reports() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Horoscope Reports',
            'active_sidebar' => 'horoscope',
        ]);
        $this->_render('user/horoscope_reports', $data);
    }

    public function consultations() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'My Consultations',
            'active_sidebar' => 'consultations',
        ]);
        $this->_render('user/consultations', $data);
    }

    public function book_consultation() {
        $user_id = $this->session->userdata('user_id');
        $astrologer_id = intval($this->input->post('astrologer_id'));
        $type = $this->input->post('consultation_type');
        $scheduled_at = $this->input->post('scheduled_at');

        $this->load->model('consultation_model');
        $this->consultation_model->insert([
            'user_id'           => $user_id,
            'astrologer_id'     => $astrologer_id,
            'consultation_type' => $type,
            'scheduled_at'      => $scheduled_at,
            'status'            => 'booked'
        ]);

        $msg = 'Consultation scheduled successfully!';
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => $msg,
                'redirect' => site_url('user/consultations')
            ]));
            return;
        }

        $this->session->set_flashdata('success', $msg);
        redirect('user/consultations');
    }

    public function wallet() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'My Wallet',
            'active_sidebar' => 'wallet',
        ]);
        $this->_render('user/wallet', $data);
    }

    public function recharge_wallet() {
        $error = 'Wallet recharge requires a verified payment gateway. Direct balance credits are disabled for security.';
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
            return;
        }
        $this->session->set_flashdata('error', $error);
        redirect('user/wallet');
    }

    public function notifications() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Notifications',
            'active_sidebar' => 'notifications',
        ]);
        $this->_render('user/notifications', $data);
    }

    public function support() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Support',
            'active_sidebar' => 'support',
        ]);
        $this->_render('user/support', $data);
    }

    public function save_ticket() {
        $user_id = $this->session->userdata('user_id');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $this->load->model('support_ticket_model');
        $ticket_no = 'TK-' . strtoupper(uniqid());

        $this->support_ticket_model->insert([
            'ticket_no' => $ticket_no,
            'user_id'   => $user_id,
            'subject'   => $subject,
            'message'   => $message,
            'status'    => 'open'
        ]);

        $msg = 'Support ticket ' . $ticket_no . ' created successfully!';
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => $msg,
                'redirect' => site_url('user/support')
            ]));
            return;
        }

        $this->session->set_flashdata('success', $msg);
        redirect('user/support');
    }

    public function referrals() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Referral Program',
            'active_sidebar' => 'referrals',
        ]);
        $this->_render('user/referrals', $data);
    }

    public function transactions() {
        $data = array_merge($this->_base(), [
            'page_title'     => 'Transaction History',
            'active_sidebar' => 'transactions',
        ]);
        $this->_render('user/transactions', $data);
    }
}
