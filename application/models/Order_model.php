<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
    
    public function add_order($data) {
        $this->db->insert('orders', $data);
    }

    public function get_orders() {
        return $this->db->get('orders')->result();
    }
}
