<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendUsers_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function ReadByParam($param = NULL, $select = 'users.id, users.email, users.fullname, users.phone, users.address, users.created, users_groups.title as groups_title, users_groups.group'){
		$this->db->select($select);
		$this->db->from('users');
		$this->db->join('users_groups', 'users.groupsid = users_groups.id');
		$this->db->where($param)->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = 'id', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('users');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create(){
		$salt = random();
		$password = password_encode($this->input->post('password'), $salt);
		$data = array(
			'email' => $this->input->post('email'),
			'password' => $password,
			'salt' => $salt,
			'groupsid' => 1,
			'fullname' => $this->input->post('fullname'),
			'publish' => 1,
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('users', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByField($field = 'id', $value = 0, $param = NULL){
		$this->db->where(array($field => $value))->update('users', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	public function OrderByUsers($userid = 0, $flag = FALSE){
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->where(array('userid' => $userid));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		if($flag  == TRUE){
			if(isset($result) && is_array($result) && count($result)){
				foreach($result as $key => $val){
					$result[$key]['item'] = $this->OrderItemDetails($val['id']);
				}
			}
		}
		
		return $result;
	}
	
	public function OrderItemDetails($paymentsid = 0){
		$this->db->select('*');
		$this->db->from('payments_items');
		$this->db->where(array('paymentsid' => $paymentsid));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

}
