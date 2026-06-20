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
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[128]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[user,astrologer,admin]');

        if ($this->form_validation->run() === FALSE) {
            $error = strip_tags(validation_errors(' ', ' '));
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('auth/login');
        }

        $email = strtolower(trim($this->input->post('email', TRUE)));
        $password = $this->input->post('password');
        $role = $this->input->post('role', TRUE);

        // Map role string to role_id
        $expected_role_id = 3;
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
                    $this->session->sess_regenerate(TRUE);
                    $this->session->set_userdata([
                        'user_id'   => $user['id'],
                        'role_id'   => $user['role_id'],
                        'name'      => $user['name'],
                        'email'     => $user['email'],
                        'logged_in' => TRUE
                    ]);

                    $redirect = 'user';
                    if ($user['role_id'] == 1) {
                        $redirect = 'admin';
                    } elseif ($user['role_id'] == 2) {
                        $redirect = 'astrologer';
                    }

                    if ($this->input->is_ajax_request()) {
                        $this->output->set_content_type('application/json')->set_output(json_encode([
                            'status' => true, 
                            'message' => 'Login successful! Redirecting...', 
                            'redirect' => site_url($redirect)
                        ]));
                        return;
                    }
                    redirect($redirect);
                } else {
                    $error = 'Invalid role selection for this user.';
                }
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'User not found.';
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
            return;
        }
        $this->session->set_flashdata('error', $error);
        redirect('auth/login');
    }

    public function do_register() {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]|is_unique[users.email]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|regex_match[/^[0-9+\-\s]{10,15}$/]|is_unique[users.mobile]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[128]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[user,astrologer]');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim');
        $this->form_validation->set_rules('birth_time', 'Birth Time', 'trim');
        $this->form_validation->set_rules('birth_place', 'Birth Place', 'trim|max_length[255]');
        $this->form_validation->set_rules('rashi', 'Rashi', 'trim|max_length[50]');
        $this->form_validation->set_rules('language', 'Language', 'trim|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $error = strip_tags(validation_errors(' ', ' '));
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('auth/register');
        }

        $name = trim(strip_tags($this->input->post('name', TRUE)));
        $email = strtolower(trim($this->input->post('email', TRUE)));
        $mobile = preg_replace('/[^0-9+]/', '', $this->input->post('mobile', TRUE));
        $password = $this->input->post('password');
        $role = $this->input->post('role', TRUE);
        
        $dob = $this->input->post('dob', TRUE);
        $birth_time = $this->input->post('birth_time', TRUE);
        $birth_place = trim(strip_tags($this->input->post('birth_place', TRUE)));
        $rashi = trim(strip_tags($this->input->post('rashi', TRUE)));
        $language = trim(strip_tags($this->input->post('language', TRUE)));
		
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

            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'status' => true, 
                    'message' => 'Account created successfully! Please Sign In.', 
                    'redirect' => site_url('auth/login')
                ]));
                return;
            }

            $this->session->set_flashdata('success', 'Account created successfully! Please Sign In.');
            redirect('auth/login');
        } else {
            $error = 'Registration failed. Please try again.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('auth/register');
        }
    }

    public function do_forgot_password() {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]');

        if ($this->form_validation->run() === FALSE) {
            $error = strip_tags(validation_errors(' ', ' '));
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
            redirect('auth/forgot-password');
        }

        $email = strtolower(trim($this->input->post('email', TRUE)));
        $user = $this->user_model->get_where(['email' => $email]);

        if (!empty($user)) {
            $msg = 'Password recovery link has been sent to your email.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => true, 'message' => $msg]));
                return;
            }
            $this->session->set_flashdata('success', $msg);
        } else {
            $error = 'Email address not found.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['status' => false, 'error' => $error]));
                return;
            }
            $this->session->set_flashdata('error', $error);
        }
        redirect('auth/forgot-password');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
