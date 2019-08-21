<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontendaddress_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function Count($lang = 'vietnamese', $type = 0){
		$this->db->where(array('trash' => 0, 'publish' => 1, 'alanguage' => $lang, 'typeoff' => $type));
		$keyword = $this->input->get('keyword');
		$this->db->from('address');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function Viewall($start = 0, $limit = 0, $lang = 'vietnamese', $type = 0){
		$this->db->where(array('trash' => 0, 'publish' => 1, 'alanguage' => $lang, 'typeoff' => $type));
		$keyword = $this->input->get('keyword');
		$this->db->from('address');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByFieldArr($array = ''){
		$this->db->where($array);
		$this->db->from('address');
		$this->db->order_by('created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem chi tiết bài viết
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0, $lang = ''){
		$this->db->where(array('trash' => 0, 'publish' => 1, 'alanguage' => $lang));
		$this->db->from('address');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Cập nhật lượt xem bài viết
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0){
		$this->db->where(array($field => $value))->set('viewed', 'viewed+1', FALSE)->update('address');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cùng chủ đề
	//-----------------------------------------------------
	public function ReadByTags($id = 0, $tags = NULL, $limit = 6, $select = 'address.id, address.title, address.slug, address.canonical, address.images, address.description, address.viewed, address.created, address_catalogues.id as cat_id, address_catalogues.title as cat_title, address_catalogues.slug as cat_slug, address_catalogues.canonical as cat_canonical'){
		if(isset($tags) && is_array($tags) && count($tags)){
			// Danh sách tag
			$tagid = '';
			foreach($tags as $key => $val){
				$tagid = $tagid . $val['id'].', ';
			}
			$tagid = substr($tagid, 0, -2);
			$this->db->select($select);
			$this->db->where(array('address.trash' => 0, 'address.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
			// Khác bài hiện tại
			$this->db->where(array('address.id !=' => $id));
			$this->db->where('address.id IN (SELECT modulesid FROM tags_relationship WHERE modules = \'address\' AND tagsid IN ('.$tagid.'))');
			$this->db->from('address');
			$this->db->join('address_catalogues', 'address.cataloguesid = address_catalogues.id');
			$this->db->limit($limit, 0);
			$this->db->order_by('address.created DESC');
			$result = $this->db->get()->result_array();
			$this->db->flush_cache();
			return $result;
		}
	}

	//-----------------------------------------------------
	// Xem bài viết cho sitemap
	//-----------------------------------------------------
	public function ReadAllForSitemap($cataloguesid = 0, $lft = 0, $rgt = 0, $id = 0, $limit = 5, $select = 'address.id, address.title, address.slug, address.canonical, address.images, address.description, address.viewed, address.created, address_catalogues.id as cat_id, address_catalogues.title as cat_title, address_catalogues.slug as cat_slug, address_catalogues.canonical as cat_canonical'){
		$this->db->select($select);
		$this->db->where(array('address.trash' => 0, 'address.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->join('address_catalogues', 'address.cataloguesid = address_catalogues.id');
		if($cataloguesid > 0){
			if($rgt - $lft == 1){
				$this->db->where(array('address.cataloguesid' => $cataloguesid));
			}
			else{
				$this->db->where('(address.cataloguesid IN (SELECT id FROM address_catalogues WHERE lft >= '.$lft.' AND rgt <= '.$rgt.'))');
			}
		}
		$this->db->from('address');
		$this->db->limit($limit, 0);
		$this->db->order_by('address.created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Đếm bài viết cho tag
	//-----------------------------------------------------
	public function CountAllTags($id = 0, $modules = 'address'){
		$this->db->where(array('modules' => $modules, 'tagsid' => $id));
		$this->db->from('tags_relationship');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cho tag
	//-----------------------------------------------------
	public function ReadAllTags($id = 0, $modules = 'address', $start = 0, $limit = 10, $select = 'address.id, address.title, address.slug, address.canonical, address.images, address.description, address.viewed, address.created, address_catalogues.id as cat_id, address_catalogues.title as cat_title, address_catalogues.slug as cat_slug, address_catalogues.canonical as cat_canonical'){

		$this->db->select($select);
		$this->db->from('tags_relationship');
		$this->db->join('address', 'tags_relationship.modulesid = address.id');
		$this->db->join('address_catalogues', 'address.cataloguesid = address_catalogues.id');
		$this->db->where(array('tags_relationship.modules' => $modules, 'tags_relationship.tagsid' => $id));
		$this->db->order_by('address.order ASC, address.created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByCondition($param = ''){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? $param['limit'] : 5);
		$param['lft'] = ((isset($param['lft'])) ? $param['lft'] : 0);
		$param['rgt'] = ((isset($param['rgt'])) ? $param['rgt'] : 0);
		
		$this->db->select($param['select']);
		$this->db->from('address');
		$this->db->where('trash', 0);
		$this->db->where($param['where']);
		if($param['lft'] > 0 && $param['rgt'] > 0){
			$this->db->where('(address.cataloguesid IN (SELECT id FROM address_catalogues WHERE lft >= '.$param['lft'].' AND rgt <= '.$param['rgt'].'))');
		}
		$this->db->limit($param['limit'], 0);
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
}
