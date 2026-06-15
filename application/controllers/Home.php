<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller — public landing pages
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'html']);
    }

    private function _render($view, $data = []) {
        $this->load->view('layouts/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer', $data);
    }

    public function index() {
        $this->db->select('astrologers.*, users.name, users.profile_image');
        $this->db->from('astrologers');
        $this->db->join('users', 'users.id = astrologers.user_id');
        $this->db->limit(4);
        $astrologers = $this->db->get()->result_array();

        $data = [
            'page_title'  => 'Unlock Your Sacred Destiny Through Stars',
            'meta_desc'   => 'India\'s most trusted Vedic astrology platform. Get authentic Kundli, expert consultations and cosmic guidance.',
            'active_nav'  => 'home',
            'astrologers' => $astrologers
        ];
        $this->_render('home/index', $data);
    }

    public function about() {
        $data = [
            'page_title' => 'About Us',
            'meta_desc'  => 'Learn about Samriddhi-Ventures — India\'s leading Vedic astrology ERP platform.',
            'active_nav' => 'about',
        ];
        $this->_render('home/about', $data);
    }

    public function contact() {
        $data = [
            'page_title' => 'Contact Us',
            'meta_desc'  => 'Get in touch with Samriddhi-Ventures support team.',
            'active_nav' => 'contact',
        ];
        $this->_render('home/contact', $data);
    }

    public function plans() {
        $this->load->model('subscription_plan_model');
        $plans = $this->subscription_plan_model->get_where(['status' => 1]);
        $data = [
            'page_title' => 'Subscription Plans',
            'meta_desc'  => 'Choose your sacred plan and unlock unlimited Vedic astrology guidance.',
            'active_nav' => 'plans',
            'plans'      => $plans
        ];
        $this->_render('home/plans', $data);
    }

    public function blog() {
        $data = [
            'page_title' => 'Sacred Wisdom & Articles',
            'meta_desc'  => 'Read articles about Vedic astrology, planets, Kundli, and sacred guidance.',
            'active_nav' => 'blog',
        ];
        $this->_render('home/blog', $data);
    }

    public function blog_detail($slug = '') {
        $data = [
            'page_title' => 'Blog Article',
            'active_nav' => 'blog',
            'slug'       => $slug,
        ];
        $this->_render('home/blog_detail', $data);
    }

    public function careers() {
        $data = [
            'page_title' => 'Careers at Samriddhi-Ventures',
            'active_nav' => '',
        ];
        $this->_render('home/careers', $data);
    }

    public function privacy_policy() {
        $data = ['page_title' => 'Privacy Policy', 'active_nav' => ''];
        $this->_render('home/privacy_policy', $data);
    }

    public function terms() {
        $data = ['page_title' => 'Terms of Service', 'active_nav' => ''];
        $this->_render('home/terms', $data);
    }

    public function refund_policy() {
        $data = ['page_title' => 'Refund Policy', 'active_nav' => ''];
        $this->_render('home/refund_policy', $data);
    }
}
