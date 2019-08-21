<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendContacts_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function create(){
		$data = array(
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'message' => $this->input->post('message'),
			'receiverid' => $this->input->post('receiverid'),
			'process' => $this->input->post('process'),
			'publish' => $this->input->post('publish'),
			'notes' => $this->input->post('notes'),
			'level' => $this->input->post('level'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('contacts', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0){
		$data = array(
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'message' => $this->input->post('message'),
			'receiverid' => $this->input->post('receiverid'),
			'process' => $this->input->post('process'),
			'publish' => $this->input->post('publish'),
			'notes' => $this->input->post('notes'),
			'level' => $this->input->post('level'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array('id' => $id))->update('contacts', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update_field($param = NULL, $id = 0){
		$this->db->where(array('id' => $id))->update('contacts', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function countall(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(fullname LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR message LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('contacts');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(fullname LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR message LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('contacts');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0){
		$this->db->where(array('contacts.trash' => 0));
		$this->db->select('contacts.*, (SELECT 	contacts_receiver.name FROM contacts_receiver WHERE contacts_receiver.id = contacts.receiverid) as receiver_name');
		$this->db->from('contacts');
		$this->db->where(array('contacts.id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('contacts');
		$this->db->where(array('id' => $id))->update('contacts', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function CountMessage($param = NULL){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('contacts');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByField($param = NULL, $limit = 5){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('contacts');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	

}