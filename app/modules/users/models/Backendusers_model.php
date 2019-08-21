<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendUsers_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$this->db->where(array('users.email !=' => 'root@gmail.com'));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(username LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR fullname LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		$groupsid = $this->input->get('groupsid');
		if($groupsid > 0){
			$this->db->where(array('groupsid' => $groupsid));
		}
		$this->db->from('users');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('users.trash' => 0));
		$this->db->where(array('users.email !=' => 'root@gmail.com'));
		$this->db->select('users.*, (SELECT title FROM users_groups WHERE users_groups.id = users.groupsid AND trash = 0) as group_title, ');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(username LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR fullname LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		$groupsid = $this->input->get('groupsid');
		if($groupsid > 0){
			$this->db->where(array('groupsid' => $groupsid));
		}
		$this->db->from('users');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = 'id', $value = 0, $user = ''){
		$this->db->select('users.*, users_groups.title, users_groups.group');
		$this->db->where(array('users.trash' => 0));
		if (!empty($user) && $user['email'] != 'root@gmail.com') {
			$this->db->where(array('users.email !=' => 'root@gmail.com'));
		}
		$this->db->from('users');
		$this->db->join('users_groups', 'users.groupsid = users_groups.id');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function Read($userid = 0){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('trash', 0);
		$this->db->where('id', $userid);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = ''){
		$salt = random();
		$password = password_encode($this->input->post('password'), $salt);
		$data = array(
			'email' => $this->input->post('email'),
			'password' => $password,
			'salt' => $salt,
			'groupsid' => $this->input->post('groupsid'),
			'fullname' => $this->input->post('fullname'),
			'description' => $this->input->post('description'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('users', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = 'id', $value = 0, $user = ''){
		$data = array(
			'email' => $this->input->post('email'),
			'groupsid' => $this->input->post('groupsid'),
			'fullname' => $this->input->post('fullname'),
			'description' => $this->input->post('description'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('users', $data);
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

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('users', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = 'id', $value = 0){
		$this->db->where(array($field => $value))->update('users', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

}
