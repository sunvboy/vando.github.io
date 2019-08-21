<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendContactsReceiver_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function countall(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(name LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('contacts_receiver');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->where(array('contacts_receiver.trash' => 0));
		$this->db->select('contacts_receiver.*, (SELECT COUNT(contacts.id) FROM contacts WHERE contacts.receiverid = contacts_receiver.id) as count_contacts');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(name LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('contacts_receiver');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('contacts_receiver');
		$this->db->where(array('id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function create(){
		$data = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('contacts_receiver', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0){
		$data = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array('id' => $id))->update('contacts_receiver', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function dropdown(){
		$this->db->where(array('trash' => 0));
		$result = $this->db->select('id, name')->from('contacts_receiver')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = '- Chọn nơi nhận -';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['name'];
			}
		}
		return $dropdown;
	}

	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('contacts_receiver');
		$this->db->where(array('id' => $id))->update('contacts_receiver', array('trash' => 1));
		$result = $this->db->affected_rows();
		// $this->db->where(array('receiverid' => $id))->delete('contacts');
		$this->db->where(array('receiverid' => $id))->update('contacts', array('trash' => 1));
		$this->db->flush_cache();
		return $result;
	}

}
