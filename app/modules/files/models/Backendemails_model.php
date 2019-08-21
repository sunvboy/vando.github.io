<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendEmails_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function create(){
		$data = array(
			'email' => $this->input->post('email'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('emails', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0){
		$data = array(
			'email' => $this->input->post('email'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array('id' => $id))->update('emails', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update_field($param = NULL, $id = 0){
		$this->db->where(array('id' => $id))->update('emails', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function countall(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(email LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('emails');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(email LIKE \'%'.$keyword.'%\'');
		}
		$this->db->from('emails');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0){
		$this->db->where(array('trash' => 0));
		$this->db->select('*');
		$this->db->from('emails');
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('emails');
		$this->db->where(array('id' => $id))->update('emails', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

}