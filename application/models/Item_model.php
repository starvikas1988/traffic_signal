<?php
class Item_model extends CI_Model{
 
 public function __construct(){
 	parent::__construct();

 	$this->load->database();
 }

 public function get_items(){
 	return $this->db->get('items')->result_array();
 }

 public function add_item($data){
 	$this->db->insert('items',$data);

 	return $this->db->insert_id();
 }

 public function update_item($id,$data){
 	$this->db->where('id',$id);

 	return $this->db->update('items',$data);
 }

 public function delete_item($id){
 	return $this->db->delete('items',array('id'=>$id));
 }

 }

 ?>
