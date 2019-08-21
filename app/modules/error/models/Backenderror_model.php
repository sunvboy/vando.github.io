<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendError_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function countall(){
		$this->db->select('*');
		$this->db->from('error_video');
		$this->db->where(array('trash' => 0));
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}

	public function view($start = 0, $limit = 0){
		$this->db->select('*');
		$this->db->from('error_video');
		$this->db->limit($limit, $start);
		$this->db->where(array('trash' => 0));
		$this->db->order_by('id desc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	
	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('error_video');
		$this->db->where(array('id' => $id))->delete('error_video');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadByField($field = '', $value = 0){
		$this->db->where($field, $value);
		$this->db->from('error_video');
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

}