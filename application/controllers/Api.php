<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load all database models
        $this->load->model([
            'user_model',
            'user_profile_model',
            'user_address_model',
            'wallet_model',
            'astrologer_model',
            'subscription_plan_model',
            'user_subscription_model',
            'product_model',
            'wallet_transaction_model',
            'notification_model',
            'blog_model'
        ]);
        $this->load->helper('url');
    }

    /**
     * Set JSON content type and return response.
     */
    private function _json($data) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * Map database user record to expected frontend schema.
     */
    private function _map_user($db_user) {
        if (!$db_user) return null;
        
        $profile = $this->user_profile_model->get_where(['user_id' => $db_user['id']]);
        $profile = !empty($profile) ? $profile[0] : null;
        
        $address = $this->user_address_model->get_where(['user_id' => $db_user['id']]);
        $address = !empty($address) ? $address[0] : null;
        
        $wallet = $this->wallet_model->get_where(['user_id' => $db_user['id']]);
        if (empty($wallet)) {
            $wallet_id = $this->wallet_model->insert([
                'user_id' => $db_user['id'],
                'balance' => 0.00
            ]);
            $wallet = $this->wallet_model->get_by_id($wallet_id);
        } else {
            $wallet = $wallet[0];
        }

        return [
            'id' => $db_user['id'],
            'name' => $db_user['name'],
            'email' => $db_user['email'],
            'phone' => $db_user['mobile'] ? $db_user['mobile'] : '',
            'city' => $address ? $address['city'] : 'Mumbai',
            'rashi' => ($profile && $profile['bio']) ? $profile['bio'] : 'Mesh',
            'wallet' => floatval($wallet['balance']),
            'joined' => date('Y-m-d', strtotime($db_user['created_at'])),
            'avatar' => strtoupper(substr($db_user['name'], 0, 1)),
            'role' => intval($db_user['role_id']) === 1 ? 'admin' : (intval($db_user['role_id']) === 2 ? 'astrologer' : 'user')
        ];
    }

    /**
     * Map database astrologer record to expected frontend schema.
     */
    private function _map_astrologer($db_astro) {
        if (!$db_astro) return null;
        $user = $this->user_model->get_by_id($db_astro['user_id']);
        if (!$user) return null;
        
        $address = $this->user_address_model->get_where(['user_id' => $user['id']]);
        $address = !empty($address) ? $address[0] : null;

        return [
            'id' => $db_astro['id'],
            'name' => $user['name'],
            'slug' => strtolower(url_title($user['name'])),
            'exp' => intval($db_astro['experience_years']),
            'rating' => floatval($db_astro['rating']),
            'reviews' => intval($db_astro['total_reviews']),
            'online' => intval($db_astro['is_online']) === 1,
            'chatRate' => 40,
            'videoRate' => 60,
            'languages' => $db_astro['languages'] ? explode(',', $db_astro['languages']) : ['Hindi','English'],
            'expertise' => $db_astro['expertise'] ? explode(',', $db_astro['expertise']) : ['Vedic Jyotish'],
            'city' => $address ? $address['city'] : 'Varanasi',
            'avatar' => strtoupper(substr($user['name'], 0, 1)),
            'verified' => $db_astro['approval_status'] === 'approved',
            'earnings' => 120000,
            'joined' => date('Y-m-d', strtotime($db_astro['created_at']))
        ];
    }

    private function _map_plan($db_plan) {
        return [
            'id' => $db_plan['id'],
            'name' => $db_plan['name'],
            'price' => floatval($db_plan['price']),
            'duration' => intval($db_plan['duration']),
            'features' => $db_plan['features'] ? json_decode($db_plan['features'], true) : [],
            'status' => intval($db_plan['status'])
        ];
    }

    private function _map_subscription($db_sub) {
        $user = $this->user_model->get_by_id($db_sub['user_id']);
        $plan = $this->subscription_plan_model->get_by_id($db_sub['plan_id']);
        return [
            'id' => $db_sub['id'],
            'userId' => $db_sub['user_id'],
            'userName' => $user ? $user['name'] : 'Unknown',
            'planId' => $db_sub['plan_id'],
            'plan' => $plan ? $plan['name'] : 'Plan',
            'status' => $db_sub['status'],
            'startDate' => $db_sub['start_date'],
            'endDate' => $db_sub['end_date'],
            'amount' => $plan ? floatval($plan['price']) : 0.00
        ];
    }

    private function _map_product($db_prod) {
        return [
            'id' => $db_prod['id'],
            'name' => $db_prod['name'],
            'price' => floatval($db_prod['price']),
            'mrp' => floatval($db_prod['price']) * 1.3,
            'stock' => intval($db_prod['stock']),
            'icon' => '💎',
            'desc' => $db_prod['description'],
            'badge' => 'Bestseller'
        ];
    }

    private function _map_transaction($db_txn) {
        $wallet = $this->wallet_model->get_by_id($db_txn['wallet_id']);
        return [
            'id' => $db_txn['id'],
            'userId' => $wallet ? $wallet['user_id'] : 'Unknown',
            'type' => $db_txn['credit_debit'],
            'desc' => $db_txn['remark'],
            'amount' => floatval($db_txn['amount']),
            'date' => date('Y-m-d', strtotime($db_txn['created_at'])),
            'status' => 'success'
        ];
    }

    private function _map_notification($db_notif) {
        return [
            'id' => $db_notif['id'],
            'userId' => $db_notif['user_id'],
            'title' => $db_notif['title'],
            'desc' => $db_notif['message'],
            'icon' => '🔔',
            'type' => 'info',
            'unread' => intval($db_notif['is_read']) === 0,
            'time' => '1 hour ago'
        ];
    }

    private function _map_blog($db_blog) {
        return [
            'id' => $db_blog['id'],
            'title' => $db_blog['title'],
            'author' => 'Pt. Rajesh Sharma',
            'category' => 'Vedic Astrology',
            'readTime' => '6 min',
            'date' => date('Y-m-d', strtotime($db_blog['created_at'])),
            'emoji' => '🌙',
            'tag' => 'Featured'
        ];
    }

    /**
     * Get all items in a collection.
     */
    public function get() {
        $collection = $this->input->get('collection');
        if (!$collection) {
            $this->_json([]);
            return;
        }

        $result = [];

        switch ($collection) {
            case 'users':
                $users = $this->user_model->get_all();
                foreach ($users as $u) {
                    $result[] = $this->_map_user($u);
                }
                break;
            case 'astrologers':
                $astros = $this->astrologer_model->get_all();
                foreach ($astros as $a) {
                    $item = $this->_map_astrologer($a);
                    if ($item) $result[] = $item;
                }
                break;
            case 'plans':
                $plans = $this->subscription_plan_model->get_all();
                foreach ($plans as $p) {
                    $result[] = $this->_map_plan($p);
                }
                break;
            case 'subscriptions':
                $subs = $this->user_subscription_model->get_all();
                foreach ($subs as $s) {
                    $result[] = $this->_map_subscription($s);
                }
                break;
            case 'products':
                $prods = $this->product_model->get_all();
                foreach ($prods as $p) {
                    $result[] = $this->_map_product($p);
                }
                break;
            case 'transactions':
                $txns = $this->wallet_transaction_model->get_all();
                foreach ($txns as $t) {
                    $result[] = $this->_map_transaction($t);
                }
                break;
            case 'notifications':
                $notifs = $this->notification_model->get_all();
                foreach ($notifs as $n) {
                    $result[] = $this->_map_notification($n);
                }
                break;
            case 'blogs':
                $blogs = $this->blog_model->get_all();
                foreach ($blogs as $b) {
                    $result[] = $this->_map_blog($b);
                }
                break;
        }

        $this->_json($result);
    }

    /**
     * Save/Update an item in a collection.
     */
    public function save() {
        $collection = $this->input->get('collection');
        if (!$collection) {
            $this->_json(['status' => false]);
            return;
        }

        switch ($collection) {
            case 'users':
                $this->save_user();
                break;
            case 'astrologers':
                $this->save_astrologer();
                break;
            case 'plans':
                $this->save_plan();
                break;
            case 'subscriptions':
                $this->save_subscription();
                break;
            case 'products':
                $this->save_product();
                break;
            case 'transactions':
                $this->save_transaction();
                break;
            case 'notifications':
                $this->save_notification();
                break;
            case 'blogs':
                $this->save_blog();
                break;
            default:
                $this->_json(['status' => false]);
                break;
        }
    }

    private function save_user() {
        $input = json_decode($this->input->raw_input_stream, true);
        if (!$input) {
            $this->_json(['status' => false]);
            return;
        }

        $id = isset($input['id']) ? $input['id'] : null;
        $db_data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'mobile' => isset($input['phone']) ? $input['phone'] : '',
            'role_id' => (isset($input['role']) && $input['role'] === 'admin') ? 1 : ((isset($input['role']) && $input['role'] === 'astrologer') ? 2 : 3)
        ];

        // If it starts with non-numeric (like U001 demo placeholder), we treat it as insert
        if ($id && is_numeric($id)) {
            $this->user_model->update($id, $db_data);
            $user_id = $id;
        } else {
            $db_data['password'] = password_hash('password123', PASSWORD_BCRYPT);
            $db_data['status'] = 1;
            $user_id = $this->user_model->insert($db_data);
        }

        // Save address
        $address = $this->user_address_model->get_where(['user_id' => $user_id]);
        $addr_data = [
            'user_id' => $user_id,
            'city' => isset($input['city']) ? $input['city'] : 'Mumbai',
        ];
        if (!empty($address)) {
            $this->user_address_model->update($address[0]['id'], $addr_data);
        } else {
            $this->user_address_model->insert($addr_data);
        }

        // Save profile
        $profile = $this->user_profile_model->get_where(['user_id' => $user_id]);
        $prof_data = [
            'user_id' => $user_id,
            'bio' => isset($input['rashi']) ? $input['rashi'] : 'Mesh',
        ];
        if (!empty($profile)) {
            $this->user_profile_model->update($profile[0]['id'], $prof_data);
        } else {
            $this->user_profile_model->insert($prof_data);
        }

        // Save wallet
        $wallet = $this->wallet_model->get_where(['user_id' => $user_id]);
        $wallet_data = [
            'user_id' => $user_id,
            'balance' => isset($input['wallet']) ? floatval($input['wallet']) : 0.00
        ];
        if (!empty($wallet)) {
            $this->wallet_model->update($wallet[0]['id'], $wallet_data);
        } else {
            $this->wallet_model->insert($wallet_data);
        }

        $new_user = $this->user_model->get_by_id($user_id);
        $this->_json($this->_map_user($new_user));
    }

    private function save_astrologer() {
        $input = json_decode($this->input->raw_input_stream, true);
        if (!$input) {
            $this->_json(['status' => false]);
            return;
        }

        $id = isset($input['id']) ? $input['id'] : null;
        
        $user_id = null;
        if ($id && is_numeric($id)) {
            $astro = $this->astrologer_model->get_by_id($id);
            if ($astro) $user_id = $astro['user_id'];
        }

        $user_data = [
            'name' => $input['name'],
            'role_id' => 2
        ];

        if ($user_id) {
            $this->user_model->update($user_id, $user_data);
        } else {
            $user_data['email'] = strtolower(url_title($input['name'])) . '@astroveda.in';
            $user_data['password'] = password_hash('password123', PASSWORD_BCRYPT);
            $user_data['status'] = 1;
            $user_id = $this->user_model->insert($user_data);
        }

        $astro_data = [
            'user_id' => $user_id,
            'experience_years' => isset($input['exp']) ? intval($input['exp']) : 0,
            'rating' => isset($input['rating']) ? floatval($input['rating']) : 4.5,
            'total_reviews' => isset($input['reviews']) ? intval($input['reviews']) : 0,
            'is_online' => (isset($input['online']) && $input['online']) ? 1 : 0,
            'languages' => isset($input['languages']) ? (is_array($input['languages']) ? implode(',', $input['languages']) : $input['languages']) : 'Hindi,English',
            'expertise' => isset($input['expertise']) ? (is_array($input['expertise']) ? implode(',', $input['expertise']) : $input['expertise']) : 'Vedic Jyotish',
            'approval_status' => (isset($input['verified']) && $input['verified']) ? 'approved' : 'pending'
        ];

        if ($id && is_numeric($id)) {
            $this->astrologer_model->update($id, $astro_data);
            $astro_id = $id;
        } else {
            $astro_id = $this->astrologer_model->insert($astro_data);
        }

        // Save address
        $address = $this->user_address_model->get_where(['user_id' => $user_id]);
        $addr_data = [
            'user_id' => $user_id,
            'city' => isset($input['city']) ? $input['city'] : 'Varanasi',
        ];
        if (!empty($address)) {
            $this->user_address_model->update($address[0]['id'], $addr_data);
        } else {
            $this->user_address_model->insert($addr_data);
        }

        $new_astro = $this->astrologer_model->get_by_id($astro_id);
        $this->_json($this->_map_astrologer($new_astro));
    }

    private function save_plan() {
        $input = json_decode($this->input->raw_input_stream, true);
        $id = isset($input['id']) ? $input['id'] : null;
        $db_data = [
            'name' => $input['name'],
            'price' => floatval($input['price']),
            'duration' => isset($input['duration']) ? intval($input['duration']) : 30,
            'features' => isset($input['features']) ? json_encode($input['features']) : null,
            'status' => isset($input['status']) ? intval($input['status']) : 1
        ];
        if ($id && is_numeric($id)) {
            $this->subscription_plan_model->update($id, $db_data);
        } else {
            $id = $this->subscription_plan_model->insert($db_data);
        }
        $this->_json($this->_map_plan($this->subscription_plan_model->get_by_id($id)));
    }

    private function save_subscription() {
        $input = json_decode($this->input->raw_input_stream, true);
        $id = isset($input['id']) ? $input['id'] : null;
        $db_data = [
            'user_id' => $input['userId'],
            'plan_id' => $input['planId'],
            'status' => $input['status'],
            'start_date' => $input['startDate'],
            'end_date' => $input['endDate']
        ];
        if ($id && is_numeric($id)) {
            $this->user_subscription_model->update($id, $db_data);
        } else {
            $id = $this->user_subscription_model->insert($db_data);
        }
        $this->_json($this->_map_subscription($this->user_subscription_model->get_by_id($id)));
    }

    private function save_product() {
        $input = json_decode($this->input->raw_input_stream, true);
        $id = isset($input['id']) ? $input['id'] : null;
        $db_data = [
            'name' => $input['name'],
            'price' => floatval($input['price']),
            'stock' => isset($input['stock']) ? intval($input['stock']) : 10,
            'description' => isset($input['desc']) ? $input['desc'] : '',
            'category_id' => 1
        ];
        if ($id && is_numeric($id)) {
            $this->product_model->update($id, $db_data);
        } else {
            $id = $this->product_model->insert($db_data);
        }
        $this->_json($this->_map_product($this->product_model->get_by_id($id)));
    }

    private function save_transaction() {
        $input = json_decode($this->input->raw_input_stream, true);
        $id = isset($input['id']) ? $input['id'] : null;
        
        $wallet = $this->wallet_model->get_where(['user_id' => $input['userId']]);
        if (empty($wallet)) {
            $wallet_id = $this->wallet_model->insert(['user_id' => $input['userId'], 'balance' => 0.00]);
        } else {
            $wallet_id = $wallet[0]['id'];
        }

        $db_data = [
            'wallet_id' => $wallet_id,
            'credit_debit' => $input['type'],
            'remark' => $input['desc'],
            'amount' => floatval($input['amount'])
        ];
        if ($id && is_numeric($id)) {
            $this->wallet_transaction_model->update($id, $db_data);
        } else {
            $id = $this->wallet_transaction_model->insert($db_data);
            
            $w = $this->wallet_model->get_by_id($wallet_id);
            $new_balance = floatval($w['balance']);
            if ($input['type'] === 'credit') {
                $new_balance += floatval($input['amount']);
            } else {
                $new_balance -= floatval($input['amount']);
            }
            $this->wallet_model->update($wallet_id, ['balance' => $new_balance]);
        }
        $this->_json($this->_map_transaction($this->wallet_transaction_model->get_by_id($id)));
    }

    private function save_notification() {
        $input = json_decode($this->input->raw_input_stream, true);
        $id = isset($input['id']) ? $input['id'] : null;
        $db_data = [
            'user_id' => isset($input['userId']) ? $input['userId'] : 1,
            'title' => $input['title'],
            'message' => $input['desc'],
            'is_read' => (isset($input['unread']) && !$input['unread']) ? 1 : 0
        ];
        if ($id && is_numeric($id)) {
            $this->notification_model->update($id, $db_data);
        } else {
            $id = $this->notification_model->insert($db_data);
        }
        $this->_json($this->_map_notification($this->notification_model->get_by_id($id)));
    }

    private function save_blog() {
        $input = json_decode($this->input->raw_input_stream, true);
        $id = isset($input['id']) ? $input['id'] : null;
        $db_data = [
            'title' => $input['title'],
            'slug' => strtolower(url_title($input['title'])),
            'content' => isset($input['content']) ? $input['content'] : $input['title'],
            'status' => 1
        ];
        if ($id && is_numeric($id)) {
            $this->blog_model->update($id, $db_data);
        } else {
            $id = $this->blog_model->insert($db_data);
        }
        $this->_json($this->_map_blog($this->blog_model->get_by_id($id)));
    }

    /**
     * Delete an item in a collection.
     */
    public function remove() {
        $collection = $this->input->get('collection');
        $id = $this->input->get('id');
        if (!$collection || !$id) {
            $this->_json(['status' => false]);
            return;
        }

        $status = false;
        
        if (!is_numeric($id)) {
            // Demo data removal (not in DB yet)
            $this->_json(['status' => true]);
            return;
        }

        switch ($collection) {
            case 'users':
                $status = $this->user_model->delete($id);
                break;
            case 'astrologers':
                $status = $this->astrologer_model->delete($id);
                break;
            case 'plans':
                $status = $this->subscription_plan_model->delete($id);
                break;
            case 'subscriptions':
                $status = $this->user_subscription_model->delete($id);
                break;
            case 'products':
                $status = $this->product_model->delete($id);
                break;
            case 'transactions':
                $status = $this->wallet_transaction_model->delete($id);
                break;
            case 'notifications':
                $status = $this->notification_model->delete($id);
                break;
            case 'blogs':
                $status = $this->blog_model->delete($id);
                break;
        }

        $this->_json(['status' => $status]);
    }

    /**
     * Return live analytics metrics.
     */
    public function admin_stats() {
        $totalUsers = $this->user_model->count_all(['role_id' => 3]);
        $totalAstros = $this->astrologer_model->count_all();
        $subs = $this->user_subscription_model->get_where(['status' => 'active']);
        $totalRevenue = 0;
        foreach ($subs as $sub) {
            $plan = $this->subscription_plan_model->get_by_id($sub['plan_id']);
            if ($plan) $totalRevenue += floatval($plan['price']);
        }
        
        $this->_json([
            'totalUsers' => $totalUsers,
            'totalAstrologers' => $totalAstros,
            'totalRevenue' => $totalRevenue,
            'activeSubscriptions' => count($subs)
        ]);
    }

    /**
     * Authenticate or retrieve session credentials.
     */
    public function login() {
        $input = json_decode($this->input->raw_input_stream, true);
        if (!$input) {
            $this->_json(null);
            return;
        }

        $email = $input['email'];
        $user = $this->user_model->get_where(['email' => $email]);
        if (!empty($user)) {
            $u = $this->_map_user($user[0]);
            $this->_json($u);
            return;
        }

        // Default admin demo login fallback
        if ($email === 'admin@astroveda.in') {
            $this->_json([
                'id' => 'ADMIN',
                'name' => 'Admin User',
                'email' => $email,
                'role' => 'admin',
                'avatar' => 'A'
            ]);
            return;
        }

        $this->_json(null);
    }
}
