<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('user_model');
    }

    private function _check_session() {
        if ($this->session->userdata('logged_in')) {
            $role_id = $this->session->userdata('role_id');
            if ($role_id == 1) {
                redirect('admin');
            } elseif ($role_id == 2) {
                redirect('astrologer');
            } else {
                redirect('user');
            }
        }
    }

    public function login() {
        $this->_check_session();
        $data = [
            'page_title' => 'Login — Samriddhi-Ventures',
            'meta_desc'  => 'Login to your Samriddhi-Ventures account.',
        ];
        $this->load->view('auth/login', $data);
    }

    public function register() {
        $this->_check_session();
        $data = [
            'page_title' => 'Register Free — Samriddhi-Ventures',
            'meta_desc'  => 'Create your free Samriddhi-Ventures account.',
        ];
        $this->load->view('auth/register', $data);
    }

    public function forgot_password() {
        $this->_check_session();
        $data = [
            'page_title' => 'Forgot Password — Samriddhi-Ventures',
            'meta_desc'  => 'Recover your Samriddhi-Ventures account password.',
        ];
        $this->load->view('auth/forgot_password', $data);
    }

    public function do_login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $role = $this->input->post('role'); // 'user', 'astrologer', 'admin'

        // Map role string to role_id
        $expected_role_id = 3; // default user
        if ($role === 'admin') {
            $expected_role_id = 1;
        } elseif ($role === 'astrologer') {
            $expected_role_id = 2;
        }

        // Find user by email or mobile
        $user = $this->user_model->get_where(['email' => $email]);
        if (empty($user)) {
            $user = $this->user_model->get_where(['mobile' => $email]);
        }

        if (!empty($user)) {
            $user = $user[0];
            if (password_verify($password, $user['password'])) {
                if ($user['role_id'] == $expected_role_id) {
                    // Success!
                    $this->session->set_userdata([
                        'user_id'   => $user['id'],
                        'role_id'   => $user['role_id'],
                        'name'      => $user['name'],
                        'email'     => $user['email'],
                        'logged_in' => TRUE
                    ]);

                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } elseif ($user['role_id'] == 2) {
                        redirect('astrologer');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Invalid role selection for this user.');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid password.');
            }
        } else {
            $this->session->set_flashdata('error', 'User not found.');
        }

        redirect('auth/login');
    }

    public function do_register() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('password');
        $role = $this->input->post('role');
        
        $dob = $this->input->post('dob');
        $birth_time = $this->input->post('birth_time');
        $birth_place = $this->input->post('birth_place');
        $rashi = $this->input->post('rashi');
        $language = $this->input->post('language');

        // Check if user exists
        $exist = $this->user_model->get_where(['email' => $email]);
        if (!empty($exist)) {
            $this->session->set_flashdata('error', 'Email is already registered.');
            redirect('auth/register');
        }

        $exist_mobile = $this->user_model->get_where(['mobile' => $mobile]);
        if (!empty($exist_mobile)) {
            $this->session->set_flashdata('error', 'Mobile number is already registered.');
            redirect('auth/register');
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $role_id = ($role === 'astrologer') ? 2 : 3;

        // Insert user
        $user_id = $this->user_model->insert([
            'role_id' => $role_id,
            'name'    => $name,
            'email'   => $email,
            'mobile'  => $mobile,
            'password'=> $hashed_password,
            'status'  => 1
        ]);

        if ($user_id) {
            // Insert Profile
            $this->load->model('user_profile_model');
            $this->user_profile_model->insert([
                'user_id'     => $user_id,
                'dob'         => !empty($dob) ? $dob : NULL,
                'birth_time'  => !empty($birth_time) ? $birth_time : NULL,
                'birth_place' => !empty($birth_place) ? $birth_place : NULL,
                'bio'         => 'Preferred language: ' . $language . '. Zodiac: ' . $rashi
            ]);

            // If Astrologer, insert astrologers record
            if ($role_id == 2) {
                $this->load->model('astrologer_model');
                $this->astrologer_model->insert([
                    'user_id'          => $user_id,
                    'experience_years' => 1,
                    'approval_status'  => 'pending',
                    'is_online'        => 0,
                    'languages'        => $language,
                    'expertise'        => 'Vedic'
                ]);
            }

            // Insert Wallet (100 welcome bonus)
            $this->load->model('wallet_model');
            $this->wallet_model->insert([
                'user_id' => $user_id,
                'balance' => 100.00
            ]);

            $this->session->set_flashdata('success', 'Account created successfully! Please Sign In.');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', 'Registration failed. Please try again.');
            redirect('auth/register');
        }
    }

    public function do_forgot_password() {
        $email = $this->input->post('email');
        $user = $this->user_model->get_where(['email' => $email]);

        if (!empty($user)) {
            $this->session->set_flashdata('success', 'Password recovery link has been sent to your email.');
        } else {
            $this->session->set_flashdata('error', 'Email address not found.');
        }
        redirect('auth/forgot-password');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
