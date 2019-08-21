<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendGallerys_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang));
		$this->db->from('gallerys');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByALL($start = '', $limit = '', $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang));
		$this->db->from('gallerys');
		$this->db->limit( $limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem chi tiết bài viết
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0, 'created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->from('gallerys');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Cập nhật lượt xem bài viết
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0){
		$this->db->where(array($field => $value))->set('viewed', 'viewed+1', FALSE)->update('gallerys');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}


	public function ReadByCondition($param = '', $flag = FALSE){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? (int)$param['limit'] : 0);
		
		
		$this->db->select($param['select']);
		$this->db->from('gallerys');
		$this->db->where($param['where']);
		if($param['limit'] > 0){
			$this->db->limit($param['limit'], 0);
		}
		
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		if($flag == TRUE){
			if(isset($result) && is_array($result) && count($result)){
				foreach($result as $key => $val){
					$result[$key]['post'] = $this->ReadArticles($val['id']);
				}
			}
		}
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cùng chủ đề
	//-----------------------------------------------------
	public function ReadByTags($id = 0, $tags = NULL, $limit = 6, $select = 'gallerys.id, gallerys.title, gallerys.slug, gallerys.canonical, gallerys.images, gallerys.description, gallerys.viewed, gallerys.created, gallerys_catalogues.id as cat_id, gallerys_catalogues.title as cat_title, gallerys_catalogues.slug as cat_slug, gallerys_catalogues.canonical as cat_canonical'){
		if(isset($tags) && is_array($tags) && count($tags)){
			// Danh sách tag
			$tagid = '';
			foreach($tags as $key => $val){
				$tagid = $tagid . $val['id'].', ';
			}
			$tagid = substr($tagid, 0, -2);
			$this->db->select($select);
			$this->db->where(array('gallerys.trash' => 0, 'gallerys.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
			// Khác bài hiện tại
			$this->db->where(array('gallerys.id !=' => $id));
			$this->db->where('gallerys.id IN (SELECT modulesid FROM tags_relationship WHERE modules = \'gallerys\' AND tagsid IN ('.$tagid.'))');
			$this->db->from('gallerys');
			$this->db->join('gallerys_catalogues', 'gallerys.cataloguesid = gallerys_catalogues.id');
			$this->db->limit($limit, 0);
			$this->db->order_by('gallerys.created DESC');
			$result = $this->db->get()->result_array();
			$this->db->flush_cache();
			return $result;
		}
	}

	//-----------------------------------------------------
	// Xem bài viết cho sitemap
	//-----------------------------------------------------
	public function ReadAllForSitemap($cataloguesid = 0, $lft = 0, $rgt = 0, $id = 0, $limit = 5, $select = 'gallerys.id, gallerys.title, gallerys.slug, gallerys.canonical, gallerys.images, gallerys.description, gallerys.viewed, gallerys.created, gallerys_catalogues.id as cat_id, gallerys_catalogues.title as cat_title, gallerys_catalogues.slug as cat_slug, gallerys_catalogues.canonical as cat_canonical'){
		$this->db->select($select);
		$this->db->where(array('gallerys.trash' => 0, 'gallerys.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->join('gallerys_catalogues', 'gallerys.cataloguesid = gallerys_catalogues.id');
		if($cataloguesid > 0){
			if($rgt - $lft == 1){
				$this->db->where(array('gallerys.cataloguesid' => $cataloguesid));
			}
			else{
				$this->db->where('(gallerys.cataloguesid IN (SELECT id FROM gallerys_catalogues WHERE lft >= '.$lft.' AND rgt <= '.$rgt.'))');
			}
		}
		$this->db->from('gallerys');
		$this->db->limit($limit, 0);
		$this->db->order_by('gallerys.created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Đếm bài viết cho tag
	//-----------------------------------------------------
	public function CountAllTags($id = 0, $modules = 'gallerys'){
		$this->db->where(array('modules' => $modules, 'tagsid' => $id));
		$this->db->from('tags_relationship');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cho tag
	//-----------------------------------------------------
	public function ReadAllTags($id = 0, $modules = 'gallerys', $start = 0, $limit = 10, $select = 'gallerys.id, gallerys.title, gallerys.slug, gallerys.canonical, gallerys.images, gallerys.description, gallerys.viewed, gallerys.created, gallerys_catalogues.id as cat_id, gallerys_catalogues.title as cat_title, gallerys_catalogues.slug as cat_slug, gallerys_catalogues.canonical as cat_canonical'){

		$this->db->select($select);
		$this->db->from('tags_relationship');
		$this->db->join('gallerys', 'tags_relationship.modulesid = gallerys.id');
		$this->db->join('gallerys_catalogues', 'gallerys.cataloguesid = gallerys_catalogues.id');
		$this->db->where(array('tags_relationship.modules' => $modules, 'tags_relationship.tagsid' => $id));
		$this->db->order_by('gallerys.order ASC, gallerys.created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
}
