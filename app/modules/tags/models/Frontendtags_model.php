<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendTags_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function ReadByModule($modulesid = 0, $modules = 'articles', $select = 'id, slug, title, canonical', $table = 'tags'){
		$this->db->where(array(''.$table.'.trash' => 0, ''.$table.'.publish' => 1));
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where('(id IN (SELECT tagsid FROM tags_relationship WHERE modules = \''.$modules.'\' AND modulesid = '.$modulesid.'))');
		$this->db->order_by('order ASC, id desc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByModules($modules = 'articles'){
		$this->db->where(array('tags.trash' => 0));
		$this->db->select('id, slug, title, canonical');
		$this->db->from('tags');
		$this->db->where('(id IN (SELECT tagsid FROM tags_relationship))');
		$this->db->order_by('order ASC, title ASC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->select('tags.*, tags_catalogues.modules');
		$this->db->where(array('tags.trash' => 0, 'tags.publish' => 1));
		$this->db->from('tags');
		$this->db->join('tags_catalogues', 'tags.cataloguesid = tags_catalogues.id');
		$this->db->where(array('tags.'.$field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Đếm bài viết cho tag
	//-----------------------------------------------------
	public function CountAllTags($id = 0, $modules = 'products'){
		$this->db->where(array('modules' => $modules, 'tagsid' => $id));
		$this->db->from('tags_relationship');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cho tag
	//-----------------------------------------------------
	public function ReadAllTags($id = 0, $modules = 'products', $start = 0, $limit = 10, $select = 'products.*'){
		$this->db->select($modules.'.*');
		$this->db->from('tags_relationship');
		$this->db->join(''.$modules.'', 'tags_relationship.modulesid = '.$modules.'.id');
		$this->db->join(''.$modules.'_catalogues', ''.$modules.'.cataloguesid = '.$modules.'_catalogues.id');
		$this->db->where(array('tags_relationship.modules' => $modules, 'tags_relationship.tagsid' => $id));
		$this->db->order_by(''.$modules.'.order ASC, '.$modules.'.created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAllByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('tags');
		$this->db->where(array($field => $value));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadTagsCondition($param = '', $limit = 0){
		$this->db->select('*');
		$this->db->from('tags');
		$this->db->where(array('trash' => 0,'publish' => 1));
		$this->db->where($param);
		if (!empty($limit)) {
			$this->db->limit($limit, 0);
		}
		$result = $this->db->get()->result_array();
		// $this->db->flush_cache();
		return $result;
	}

}
