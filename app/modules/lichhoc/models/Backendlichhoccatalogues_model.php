<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendLichhocCatalogues_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($lang = 'vietnamese'){
		$this->db->where(array('alanguage' => $lang));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('lichhoc_date');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $lang = 'vietnamese'){
		$this->db->where(array('lichhoc_date.alanguage' => $lang));
		$this->db->select('lichhoc_date.*, (SELECT fullname  FROM users WHERE users.id = lichhoc_date.userid_created) as user_created, (SELECT fullname  FROM users WHERE users.id = lichhoc_date.userid_updated) as user_updated');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('lichhoc_date');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('alanguage' => $lang));
		$this->db->from('lichhoc_date');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByFieldALL($lang = 'vietnamese'){
		$this->db->where(array('alanguage' => $lang));
		$this->db->from('lichhoc_date');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user= NULL, $lang = 'vietnamese'){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => $this->input->post('canonical'),
			'publish' => $this->input->post('publish'),
			'ishome' => $this->input->post('ishome'),
			'userid_created' => $user['id'],
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'alanguage' => $lang,
		);
		$this->db->insert('lichhoc_date', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($data = NULL){
		$id = $data['id'];
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => $this->input->post('canonical'),
			'publish' => $this->input->post('publish'),
			'ishome' => $this->input->post('ishome'),
			'userid_updated' => $data['user']['id'],
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array('id' => $id))->update('lichhoc_date', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('lichhoc_date', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		// $this->db->where(array($field => $value))->update('lichhoc_date', array('trash' => 1));
		$this->db->where(array('id' => $id))->delete('lichhoc_date');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAllByField($field = '', $value = 0, $select = 'id, title, slug, canonical, order'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		$this->db->from('lichhoc_date');
		$this->db->where(array($field => $value));
		$result = $this->db->order_by('order ASC, id DESC')->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Dropdown(){
		$this->db->where(array('trash' => 0));
		$this->db->select('*');
		$this->db->from('lichhoc_date');
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
