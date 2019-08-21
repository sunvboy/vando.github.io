<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendVideos_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	
	//-----------------------------------------------------
	// Xem chi tiết bài viết
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0, 'created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->from('videos');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByCondition($param = ''){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? $param['limit'] : 5);
		
		$this->db->select($param['select']);
		$this->db->from('videos');
		$this->db->where('trash', 0);
		$this->db->where($param['where']);
		$this->db->limit($param['limit'], 0);
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	//-----------------------------------------------------
	// Cập nhật lượt xem bài viết
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0){
		$this->db->where(array($field => $value))->set('viewed', 'viewed+1', FALSE)->update('videos');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cùng chủ đề
	//-----------------------------------------------------
	public function ReadByTags($id = 0, $tags = NULL, $limit = 6, $select = 'videos.id, videos.title, videos.slug, videos.canonical, videos.images, videos.description, videos.viewed, videos.created, videos_catalogues.id as cat_id, videos_catalogues.title as cat_title, videos_catalogues.slug as cat_slug, videos_catalogues.canonical as cat_canonical'){
		if(isset($tags) && is_array($tags) && count($tags)){
			// Danh sách tag
			$tagid = '';
			foreach($tags as $key => $val){
				$tagid = $tagid . $val['id'].', ';
			}
			$tagid = substr($tagid, 0, -2);
			$this->db->select($select);
			$this->db->where(array('videos.trash' => 0, 'videos.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
			// Khác bài hiện tại
			$this->db->where(array('videos.id !=' => $id));
			$this->db->where('videos.id IN (SELECT modulesid FROM tags_relationship WHERE modules = \'videos\' AND tagsid IN ('.$tagid.'))');
			$this->db->from('videos');
			$this->db->join('videos_catalogues', 'videos.cataloguesid = videos_catalogues.id');
			$this->db->limit($limit, 0);
			$this->db->order_by('videos.created DESC');
			$result = $this->db->get()->result_array();
			$this->db->flush_cache();
			return $result;
		}
	}

	//-----------------------------------------------------
	// Xem bài viết cho sitemap
	//-----------------------------------------------------
	public function ReadAllForSitemap($cataloguesid = 0, $lft = 0, $rgt = 0, $id = 0, $limit = 5, $select = 'videos.id, videos.title, videos.slug, videos.canonical, videos.images, videos.description, videos.viewed, videos.created, videos_catalogues.id as cat_id, videos_catalogues.title as cat_title, videos_catalogues.slug as cat_slug, videos_catalogues.canonical as cat_canonical'){
		$this->db->select($select);
		$this->db->where(array('videos.trash' => 0, 'videos.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->join('videos_catalogues', 'videos.cataloguesid = videos_catalogues.id');
		if($cataloguesid > 0){
			if($rgt - $lft == 1){
				$this->db->where(array('videos.cataloguesid' => $cataloguesid));
			}
			else{
				$this->db->where('(videos.cataloguesid IN (SELECT id FROM videos_catalogues WHERE lft >= '.$lft.' AND rgt <= '.$rgt.'))');
			}
		}
		$this->db->from('videos');
		$this->db->limit($limit, 0);
		$this->db->order_by('videos.created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Đếm bài viết cho tag
	//-----------------------------------------------------
	public function CountAllTags($id = 0, $modules = 'videos'){
		$this->db->where(array('modules' => $modules, 'tagsid' => $id));
		$this->db->from('tags_relationship');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cho tag
	//-----------------------------------------------------
	public function ReadAllTags($id = 0, $modules = 'videos', $start = 0, $limit = 10, $select = 'videos.id, videos.title, videos.slug, videos.canonical, videos.images, videos.description, videos.viewed, videos.created, videos_catalogues.id as cat_id, videos_catalogues.title as cat_title, videos_catalogues.slug as cat_slug, videos_catalogues.canonical as cat_canonical'){

		$this->db->select($select);
		$this->db->from('tags_relationship');
		$this->db->join('videos', 'tags_relationship.modulesid = videos.id');
		$this->db->join('videos_catalogues', 'videos.cataloguesid = videos_catalogues.id');
		$this->db->where(array('tags_relationship.modules' => $modules, 'tags_relationship.tagsid' => $id));
		$this->db->order_by('videos.order ASC, videos.created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
}
