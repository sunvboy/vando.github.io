<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendComments_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	

	public function countall(){
		$this->db->select('*');
		$this->db->from('comments');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(fullname LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\' OR message LIKE \'%'.$keyword.'%\')');
		}
		$this->db->where(array('trash' => 0));
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}

	public function view($start = 0, $limit = 0){
		$this->db->select('*');
		$this->db->from('comments');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(fullname LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\' OR message LIKE \'%'.$keyword.'%\')');
		}
		$this->db->limit($limit, $start);
		$this->db->where(array('trash' => 0));
		$this->db->order_by('id desc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	
	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('comments');
		$this->db->where(array('id' => $id))->delete('comments');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadByField($field = '', $value = 0){
		$this->db->where($field, $value);
		$this->db->from('comments');
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function UpdateByPost($field = '', $value = 0, $data = ''){
		$this->db->where(array($field => $value))->update('comments', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function Create($data = ''){
		$this->db->insert('comments', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}
}