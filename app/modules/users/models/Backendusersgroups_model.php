<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendUsersGroups_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0, 'id !=' => 1));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('users_groups');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('users_groups.trash' => 0, 'users_groups.id !=' => 1));
		$this->db->select('users_groups.*, (SELECT COUNT(users.id) FROM users WHERE users.groupsid = users_groups.id AND trash = 0 AND users.email != \'tamphat@gmail.com\') as count_users');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('users_groups');
		$this->db->order_by('title ASC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0, $user = ''){
		$this->db->where(array('trash' => 0));
		if (!empty($user) && $user['email'] != 'root@gmail.com') {
			$this->db->where(array('id !=' => 1));
		}
		$this->db->from('users_groups');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create(){
		$group = '';
		$permissions = $this->input->post('permissions');
		if(isset($permissions) && is_array($permissions) && count($permissions)){
			$group = json_encode($permissions);
		}
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'description' => $this->input->post('description'),
			'group' => $group,
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('users_groups', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0){
		$group = '';
		$permissions = $this->input->post('permissions');
		if(isset($permissions) && is_array($permissions) && count($permissions)){
			$group = json_encode($permissions);
		}
		
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'description' => $this->input->post('description'),
			'group' => $group,
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array($field => $value))->update('users_groups', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('users_groups', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('users_groups', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->where(array('groupsid' => $id))->update('users', array('trash' => 1));
		$this->db->flush_cache();
		return $result;
	}

	public function dropdown(){
		$this->db->where(array('trash' => 0, 'id !=' => 1));
		$result = $this->db->select('id, title')->from('users_groups')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = '- Chọn Nhóm -';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}

}
