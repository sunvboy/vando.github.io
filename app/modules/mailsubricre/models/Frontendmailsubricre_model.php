<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontendmailsubricre_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function create($data = ''){
		$this->db->insert('mailsubricre', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function Create_arr($data = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'fullname' => $this->input->post('fullname'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'cityid' => $this->input->post('cityid'),
			'birthday' => $this->input->post('birthday'),
			'school' => $this->input->post('school'),
			'facebook' => $this->input->post('facebook'),
			'register' => $this->input->post('register'),
			'register-1' => $this->input->post('register-1'),
			'register-2' => $this->input->post('register-2'),
			'publish' => 0,
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('mailsubricre', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByCondition($param = ''){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, fullname, phone');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? $param['limit'] : 5);
		
		$this->db->select($param['select']);
		$this->db->from('mailsubricre');
		$this->db->where('trash', 0);
		$this->db->limit($param['limit'], 0);
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
}
