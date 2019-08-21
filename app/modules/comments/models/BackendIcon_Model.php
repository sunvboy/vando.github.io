<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendIcon_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	

	public function countall(){
		$this->db->select('*');
		$this->db->from('comments_icons');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR keyword LIKE \'%'.$keyword.'%\' OR url LIKE \'%'.$keyword.'%\')');
		}
		$this->db->where(array('trash' => 0));
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}

	public function view($start = 0, $limit = 0){
		$this->db->select('*');
		$this->db->from('comments_icons');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR keyword LIKE \'%'.$keyword.'%\' OR url LIKE \'%'.$keyword.'%\')');
		}
		$this->db->limit($limit, $start);
		$this->db->where(array('trash' => 0));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function create($user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'keyword' => $this->input->post('keyword'),
			'url' => $this->input->post('url'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('comments_icons', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($field = '', $value = 0, $user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'keyword' => $this->input->post('keyword'),
			'url' => $this->input->post('url'),
			'publish' => $this->input->post('publish'),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('comments_icons', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('comments');
		$this->db->where(array('id' => $id))->delete('comments_icons');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadByField($field = '', $value = 0){
		$this->db->where($field, $value);
		$this->db->from('comments_icons');
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function read($id = 0){
		$this->db->where(array('comments_icons.trash' => 0));
		$this->db->select('comments_icons.*');
		$this->db->from('comments_icons');
		$this->db->where(array('comments_icons.id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

}