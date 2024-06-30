<?php 
//defined('BASEPATH') or exit("No direct script access allowed");

class Employee_model extends CI_Model{
	public function __construct(){
 	parent::__construct();

 	$this->load->database();
 }

    public function get_employees()
	{
		// return $this->db->get('employee')->result_array();
		return $this->db->get('employee')->result();
	}
	public function get_item_by_id($id) {
        return $this->db->get_where('employee', array('id' => $id))->row();
    }

	public function add_item($data) {
        $this->db->insert('employee', $data);
    }

    public function update_item($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('employee', $data);
    }

    public function delete_item($id) {
        $this->db->where('id', $id);
        $this->db->delete('employee');
    }
}
?>