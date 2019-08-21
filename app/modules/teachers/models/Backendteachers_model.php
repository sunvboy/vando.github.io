<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendTeachers_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function create($user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'description' => $this->input->post('description'),
			'chucvu' => $this->input->post('chucvu'),
			'facebook' => $this->input->post('facebook'),
			'messenger' => $this->input->post('messenger'),
			'video' => $this->input->post('video'),
			'images' => $this->input->post('images'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('teachers', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0, $user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'description' => $this->input->post('description'),
			'chucvu' => $this->input->post('chucvu'),
			'facebook' => $this->input->post('facebook'),
			'messenger' => $this->input->post('messenger'),
			'video' => $this->input->post('video'),
			'images' => $this->input->post('images'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id']
		);
		$this->db->where(array('id' => $id))->update('teachers', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update_field($param = NULL, $id = 0){
		$this->db->where(array('id' => $id))->update('teachers', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function countall(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('teachers');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('teachers');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0){
		$this->db->where(array('teachers.trash' => 0));
		$this->db->select('teachers.*');
		$this->db->from('teachers');
		$this->db->where(array('teachers.id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function delete($id = 0){
		$this->db->where(array('id' => $id))->delete('teachers');
		// $this->db->where(array('id' => $id))->update('teachers', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($param = NULL, $limit = 5){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('teachers');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function Dropdown($type = 0){
		$this->db->where(array('trash' => 0,'publish'=>1));
		$result = $this->db->select('id, title')->from('teachers')->order_by('title ASC')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = '-- [ Chọn giảng viên ] --';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}
	
}