<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendTagsCatalogues_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('tags_catalogues');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('tags_catalogues.trash' => 0));
		$this->db->select('tags_catalogues.*, (SELECT COUNT(tags.id) FROM tags WHERE tags.cataloguesid = tags_catalogues.id AND trash = 0) as count_tags, (SELECT fullname FROM users WHERE users.id = tags_catalogues.userid_created) as fullname');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('tags_catalogues');
		$this->db->order_by('title ASC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('tags_catalogues');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'modules' => $this->input->post('modules'),
			'slug' => slug($this->input->post('title')),
			'description' => $this->input->post('description'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('tags_catalogues', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0, $user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'modules' => $this->input->post('modules'),
			'slug' => slug($this->input->post('title')),
			'description' => $this->input->post('description'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('tags_catalogues', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('tags_catalogues', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('tags_catalogues', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->where(array('cataloguesid' => $id))->update('tags', array('trash' => 1));
		$this->db->flush_cache();
		return $result;
	}

	public function Dropdown(){
		$this->db->where(array('trash' => 0));
		$result = $this->db->select('id, title')->from('tags_catalogues')->order_by('title ASC')->get()->result_array();

		$this->db->flush_cache();
		$dropdown[] = '- Chọn Danh Mục -';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}

}
