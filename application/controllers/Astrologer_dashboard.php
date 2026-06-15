<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Astrologer_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Enforce astrologer check (role_id 2)
        if ($this->session->userdata('role_id') != 2) {
            if ($this->session->userdata('role_id') == 1) {
                redirect('admin');
            } else {
                redirect('user');
            }
        }
    }

    private function _base() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model(['user_model', 'astrologer_model']);
        $user = $this->user_model->get_by_id($user_id);
        $astro = $this->astrologer_model->get_where(['user_id' => $user_id]);
        
        $name = !empty($user) ? $user['name'] : 'Astrologer';
        $initial = strtoupper(substr($name, 0, 1));
        
        return [
            'dashboard_role' => 'astrologer',
            'user_initial'   => $initial,
            'user_name'      => $name,
            'current_user'   => $user,
            'current_astro'  => !empty($astro) ? $astro[0] : null
        ];
    }

    private function _render($view, $data = []) {
        $this->load->view('layouts/dashboard_header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/dashboard_footer', $data);
    }

    public function index() {
        $data = array_merge($this->_base(), ['page_title' => 'Astrologer Dashboard', 'active_sidebar' => 'dashboard']);
        $this->_render('astrologer/dashboard', $data);
    }

    public function toggle_status() {
        $base = $this->_base();
        $astro = $base['current_astro'];

        if (!empty($astro)) {
            $this->load->model('astrologer_model');
            $new_status = $astro['is_online'] ? 0 : 1;
            $this->astrologer_model->update($astro['id'], ['is_online' => $new_status]);
            $this->session->set_flashdata('success', $new_status ? 'You are now Online!' : 'You are now Offline.');
        }

        redirect('astrologer');
    }

    public function profile() {
        $data = array_merge($this->_base(), ['page_title' => 'My Profile', 'active_sidebar' => 'profile']);
        $this->_render('astrologer/profile', $data);
    }

    public function save_profile() {
        $base = $this->_base();
        $user_id = $this->session->userdata('user_id');
        $astro = $base['current_astro'];

        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        
        $experience = intval($this->input->post('experience_years'));
        $expertise = $this->input->post('expertise');
        $languages = $this->input->post('languages');
        $bio = $this->input->post('bio');

        // Update users table
        $this->load->model('user_model');
        $this->user_model->update($user_id, [
            'name'   => $name,
            'mobile' => $mobile
        ]);

        // Update astrologers table
        if (!empty($astro)) {
            $this->load->model('astrologer_model');
            $this->astrologer_model->update($astro['id'], [
                'experience_years' => $experience,
                'expertise'        => $expertise,
                'languages'        => $languages,
                'bio'              => $bio
            ]);
        }

        $this->session->set_flashdata('success', 'Profile settings saved successfully!');
        redirect('astrologer/profile');
    }

    public function service_plans() {
        $data = array_merge($this->_base(), ['page_title' => 'Service Plans', 'active_sidebar' => 'plans']);
        $this->_render('astrologer/service_plans', $data);
    }

    public function save_plan() {
        $base = $this->_base();
        $astro = $base['current_astro'];
        $astro_id = !empty($astro) ? $astro['id'] : 0;

        $title = $this->input->post('title');
        $desc = $this->input->post('description');
        $price = floatval($this->input->post('price'));
        $duration = intval($this->input->post('duration_days')) ?: 1;
        $delivery = $this->input->post('delivery_time') ?: 'Immediate';

        $this->load->model('astrologer_plan_model');
        $this->astrologer_plan_model->insert([
            'astrologer_id' => $astro_id,
            'category_id'   => 1, // default
            'title'         => $title,
            'description'   => $desc,
            'price'         => $price,
            'duration_days' => $duration,
            'delivery_time' => $delivery,
            'status'        => 1
        ]);

        $this->session->set_flashdata('success', 'New service plan published successfully!');
        redirect('astrologer/service-plans');
    }

    public function delete_plan($id) {
        $base = $this->_base();
        $astro = $base['current_astro'];
        $astro_id = !empty($astro) ? $astro['id'] : 0;

        $this->db->delete('astrologer_plans', ['id' => intval($id), 'astrologer_id' => $astro_id]);
        $this->session->set_flashdata('success', 'Service plan removed.');
        redirect('astrologer/service-plans');
    }

    public function customers() {
        $data = array_merge($this->_base(), ['page_title' => 'My Customers', 'active_sidebar' => 'customers']);
        $this->_render('astrologer/customers', $data);
    }

    public function orders() {
        $data = array_merge($this->_base(), ['page_title' => 'Orders', 'active_sidebar' => 'orders']);
        $this->_render('astrologer/orders', $data);
    }

    public function update_consultation($id, $status) {
        $base = $this->_base();
        $astro = $base['current_astro'];
        $astro_id = !empty($astro) ? $astro['id'] : 0;

        $this->load->model('consultation_model');
        $this->consultation_model->update(intval($id), ['status' => $status]);

        $this->session->set_flashdata('success', 'Consultation status updated to ' . ucfirst($status) . '.');
        redirect('astrologer/orders');
    }

    public function predictions() {
        $data = array_merge($this->_base(), ['page_title' => 'Predictions', 'active_sidebar' => 'predictions']);
        $this->_render('astrologer/predictions', $data);
    }

    public function save_prediction($id) {
        $base = $this->_base();
        $astro = $base['current_astro'];
        $astro_id = !empty($astro) ? $astro['id'] : 0;

        $prediction = $this->input->post('prediction');
        $this->load->model('prediction_model');
        
        $this->prediction_model->update(intval($id), ['prediction' => $prediction]);
        $this->session->set_flashdata('success', 'Prediction reply sent to seeker.');
        redirect('astrologer/predictions');
    }

    public function kundali_engine() {
        $data = array_merge($this->_base(), ['page_title' => 'Kundali Engine', 'active_sidebar' => 'kundali']);
        $this->_render('astrologer/kundali_engine', $data);
    }

    public function earnings() {
        $data = array_merge($this->_base(), ['page_title' => 'Earnings', 'active_sidebar' => 'earnings']);
        $this->_render('astrologer/earnings', $data);
    }

    public function withdrawals() {
        $data = array_merge($this->_base(), ['page_title' => 'Withdrawals', 'active_sidebar' => 'withdrawals']);
        $this->_render('astrologer/withdrawals', $data);
    }

    public function request_withdrawal() {
        $this->session->set_flashdata('success', 'Withdrawal request submitted successfully! Funds will credit in 48 working hours.');
        redirect('astrologer/withdrawals');
    }

    public function calendar() {
        $data = array_merge($this->_base(), ['page_title' => 'Consultation Calendar', 'active_sidebar' => 'calendar']);
        $this->_render('astrologer/calendar', $data);
    }

    public function save_slot() {
        $base = $this->_base();
        $astro = $base['current_astro'];
        $astro_id = !empty($astro) ? $astro['id'] : 0;

        $day_name = $this->input->post('day_name');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');

        $this->load->model('astrologer_availability_model');
        $this->astrologer_availability_model->insert([
            'astrologer_id' => $astro_id,
            'day_name'      => $day_name,
            'start_time'    => $start_time,
            'end_time'      => $end_time
        ]);

        $this->session->set_flashdata('success', 'Weekly availability slot added successfully.');
        redirect('astrologer/calendar');
    }

    public function delete_slot($id) {
        $base = $this->_base();
        $astro = $base['current_astro'];
        $astro_id = !empty($astro) ? $astro['id'] : 0;

        $this->db->delete('astrologer_availability', ['id' => intval($id), 'astrologer_id' => $astro_id]);
        $this->session->set_flashdata('success', 'Availability slot removed.');
        redirect('astrologer/calendar');
    }

    public function live_chat() {
        $data = array_merge($this->_base(), ['page_title' => 'Live Chat', 'active_sidebar' => 'chat']);
        $this->_render('astrologer/live_chat', $data);
    }

    public function video_consultations() {
        $data = array_merge($this->_base(), ['page_title' => 'Video Consultations', 'active_sidebar' => 'video']);
        $this->_render('astrologer/video_consultations', $data);
    }

    public function notifications() {
        $data = array_merge($this->_base(), ['page_title' => 'Notifications', 'active_sidebar' => 'notifications']);
        $this->_render('astrologer/notifications', $data);
    }

    public function support() {
        $data = array_merge($this->_base(), ['page_title' => 'Support', 'active_sidebar' => 'support']);
        $this->_render('astrologer/support', $data);
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

        $this->session->set_flashdata('success', 'Support ticket ' . $ticket_no . ' created successfully!');
        redirect('astrologer/support');
    }
}
