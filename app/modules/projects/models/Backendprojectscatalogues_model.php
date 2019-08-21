<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendProjectsCatalogues_Model extends FC_Model{

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
		$this->db->from('projects_catalogues');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('projects_catalogues.trash' => 0));
		$this->db->select('projects_catalogues.*, (SELECT fullname  FROM users WHERE users.id = projects_catalogues.userid_created) as user_created, (SELECT fullname  FROM users WHERE users.id = projects_catalogues.userid_updated) as user_updated');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('projects_catalogues');
		$this->db->order_by('lft ASC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('projects_catalogues');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user= NULL){
		$attribute['attribute_catalogue'] = $this->input->post('attribute_group');
		$attribute['attribute'] = $this->input->post('attribute');
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'parentid' => $this->input->post('parentid'),
			'images' => $this->input->post('images'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'attributes' => json_encode($attribute),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'ishome' => $this->input->post('ishome'),
			'isaside' => $this->input->post('isaside'),
			'highlight' => $this->input->post('highlight'),
			'isfooter' => $this->input->post('isfooter'),
			'userid_created' => $user['id'],
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('projects_catalogues', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($data = NULL){
		$id = $data['id'];
		$attribute['attribute_catalogue'] = $this->input->post('attribute_group');
		$attribute['attribute'] = $this->input->post('attribute');
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'parentid' => $this->input->post('parentid'),
			'images' => $this->input->post('images'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'attributes' => json_encode($attribute),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'ishome' => $this->input->post('ishome'),
			'highlight' => $this->input->post('highlight'),
			'isaside' => $this->input->post('isaside'),
			'isfooter' => $this->input->post('isfooter'),
			'userid_updated' => $data['user']['id'],
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array('id' => $id))->update('projects_catalogues', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('projects_catalogues', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('projects_catalogues', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAllByField($field = '', $value = 0, $select = 'id, title, slug, canonical, order'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		$this->db->from('projects_catalogues');
		$this->db->where(array($field => $value));
		$result = $this->db->order_by('order ASC, id DESC')->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Dropdown(){
		$this->db->select('*');
		$this->db->from('projects_catalogues');
		$result = $this->db->get()->result_array();
		$temp = '';
		$temp[0] = '--Chọn danh mục--';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[$val['id']] = $val['title'];
			}
		}
		return $temp;
	}

}
