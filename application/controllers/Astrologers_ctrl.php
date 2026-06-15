<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Astrologers_ctrl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
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
        $astrologers = $this->db->get()->result_array();

        $data = [
            'page_title' => 'Expert Astrologers — Samriddhi-Ventures',
            'meta_desc'  => '1,200+ Verified Vedic astrologers available for consultation.',
            'active_nav' => 'astrologers',
            'astrologers'=> $astrologers
        ];
        $this->_render('astrologers/index', $data);
    }

    public function detail($slug = '') {
        $this->db->select('astrologers.*, users.name, users.profile_image');
        $this->db->from('astrologers');
        $this->db->join('users', 'users.id = astrologers.user_id');
        $this->db->where('astrologers.id', intval($slug) ?: 1);
        $astrologer = $this->db->get()->row_array();

        $data = [
            'page_title' => 'Astrologer Profile — Samriddhi-Ventures',
            'active_nav' => 'astrologers',
            'astrologer' => $astrologer,
        ];
        $this->_render('astrologers/detail', $data);
    }
}
