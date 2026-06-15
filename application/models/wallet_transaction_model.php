<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet_transaction_model extends CI_Model {

    protected $table = 'wallet_transactions';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all records from the table.
     * 
     * @param string $order_by Column to order by
     * @param string $order Order direction (ASC/DESC)
     * @param int $limit Limit the number of records
     * @param int $offset Query offset
     * @return array
     */
    public function get_all($order_by = 'id', $order = 'ASC', $limit = NULL, $offset = NULL) {
        $this->db->order_by($order_by, $order);
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Find a record by ID.
     * 
     * @param int $id
     * @return array|null
     */
    public function get_by_id($id) {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->row_array();
    }

    /**
     * Find records by custom where conditions.
     * 
     * @param array $conditions
     * @param string $order_by
     * @param string $order
     * @return array
     */
    public function get_where($conditions, $order_by = 'id', $order = 'ASC') {
        $this->db->order_by($order_by, $order);
        return $this->db->get_where($this->table, $conditions)->result_array();
    }

    /**
     * Insert a new record.
     * 
     * @param array $data
     * @return int Inserted record ID
     */
    public function insert($data) {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update an existing record by ID.
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete a record by ID.
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Get count of all records.
     * 
     * @param array $conditions Optional filters
     * @return int
     */
    public function count_all($conditions = array()) {
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        return $this->db->count_all_results($this->table);
    }
}
