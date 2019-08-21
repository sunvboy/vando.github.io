<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendTags_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		$cataloguesid = $this->input->get('cataloguesid');
		if($cataloguesid > 0){
			$this->db->where(array('cataloguesid' => $cataloguesid));
		}
		$this->db->from('tags');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('tags.trash' => 0));
		$this->db->select('tags.*, (SELECT title FROM tags_catalogues WHERE tags_catalogues.id = tags.cataloguesid) as group_title');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		$cataloguesid = $this->input->get('cataloguesid');
		if($cataloguesid > 0){
			$this->db->where(array('cataloguesid' => $cataloguesid));
		}
		$this->db->from('tags');
		$this->db->order_by('order ASC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('tags');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create(){
		$canonical = slug($this->input->post('canonical'));
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => $canonical,
			'crc32' => sprintf("%u", crc32($canonical)),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'highlight' => $this->input->post('highlight'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('tags', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0){
		$canonical = slug($this->input->post('canonical'));
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => $canonical,
			'crc32' => sprintf("%u", crc32($canonical)),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'highlight' => $this->input->post('highlight'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array($field => $value))->update('tags', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('tags', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function InsertByModule($modulesid = NULL, $modules = 'articles', $post = 'tagsid'){
		$tagsid = $this->input->post($post);
		if(isset($tagsid) && is_array($tagsid) && count($tagsid)){
			$data = NULL;
			foreach($tagsid as $key => $val){
				$data[] = array(
					'modules' => $modules,
					'modulesid' => $modulesid,
					'tagsid' => $val,
					'publish' => 1,
					'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				);
			}
			$result = $this->db->insert_batch('tags_relationship', $data); 
			$this->db->flush_cache();
			return $result;
		}
	}

	public function ReadByModule($modulesid = NULL, $modules = 'articles'){
		$data = NULL;
		$this->db->where(array('trash' => 0));
		$this->db->select('tagsid');
		$this->db->from('tags_relationship');
		$this->db->where(array('modules' => $modules, 'modulesid' => $modulesid));
		$result = $this->db->get()->result_array();
		// print_r($result);die;
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$data[] = $val['tagsid'];
			}
		}
		$this->db->flush_cache();
		return $data;
	}

	public function DeleteByModule($modulesid = NULL, $modules = 'articles'){
		$this->db->where(array('modules' => $modules, 'modulesid' => $modulesid))->delete('tags_relationship');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function Dropdown($modules = 'articles'){
		$this->db->where(array('tags.trash' => 0, 'tags_catalogues.modules' => $modules));
		$result = $this->db->select('tags.id, tags.title');
		$this->db->from('tags');
		$this->db->join('tags_catalogues', 'tags_catalogues.id = tags.cataloguesid');
		$this->db->order_by('tags.id DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = NULL;
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('tags', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
}