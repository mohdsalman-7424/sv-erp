<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    private function _render($view, $data = []) {
        $this->load->view('layouts/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer', $data);
    }

    public function kundali_generator() {
        $this->_render('tools/kundali_generator', [
            'page_title' => 'Free Kundali Generator', 'active_nav' => 'kundli',
            'meta_desc'  => 'Generate your Janam Kundali free with our authentic Vedic astrology engine.',
        ]);
    }

    public function kundali_matching() {
        $this->_render('tools/kundali_matching', [
            'page_title' => 'Kundali Matching — Kundli Milan', 'active_nav' => 'match',
            'meta_desc'  => 'Check marriage compatibility with Vedic Kundli Milan (Guna Milan).',
        ]);
    }

    public function daily_horoscope() {
        $this->_render('tools/daily_horoscope', [
            'page_title' => 'Daily Horoscope — Aaj Ka Rashifal', 'active_nav' => 'horoscope',
            'meta_desc'  => 'Read today\'s personalized horoscope for all 12 zodiac signs.',
        ]);
    }

    public function yearly_horoscope() {
        $this->_render('tools/yearly_horoscope', [
            'page_title' => 'Yearly Horoscope 2026', 'active_nav' => 'horoscope',
        ]);
    }

    public function panchang() {
        $this->_render('tools/panchang', [
            'page_title' => 'Today\'s Panchang — Aaj Ka Panchang', 'active_nav' => 'panchang',
            'meta_desc'  => 'Today\'s Vedic Panchang with Tithi, Nakshatra, Yoga, Karana and Muhurat.',
        ]);
    }

    public function muhurat() {
        $this->_render('tools/muhurat', [
            'page_title' => 'Shubh Muhurat Calendar', 'active_nav' => '',
        ]);
    }

    public function festival_calendar() {
        $this->_render('tools/festival_calendar', [
            'page_title' => 'Hindu Festival Calendar 2026', 'active_nav' => '',
        ]);
    }

    public function shop() {
        $this->_render('tools/shop', [
            'page_title' => 'Sacred Gemstone Shop', 'active_nav' => 'shop',
            'meta_desc'  => 'Buy authentic astrologer-recommended gemstones, Rudraksha and Yantras.',
        ]);
    }
}
