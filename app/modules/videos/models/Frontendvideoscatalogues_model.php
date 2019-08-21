<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendVideosCatalogues_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}


	//-----------------------------------------------------
	// Xem chi tiết danh mục
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('videos_catalogues');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	
	public function ReadByFieldArr($field = '', $limit = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('videos_catalogues');
		$this->db->where($field);
		if($limit > 0){
			$this->db->limit($limit, 0);
		}
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	//-----------------------------------------------------
	// Cập nhật lượt xem danh mục
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0){
		$this->db->where(array($field => $value))->set('viewed', 'viewed+1', FALSE)->update('videos_catalogues');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Hiển thị danh mục theo field
	//-----------------------------------------------------
	public function ReadAllByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('videos_catalogues');
		$this->db->where(array($field => $value));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Hiển thị cấu trúc Breadcrumb
	//-----------------------------------------------------
	public function Breadcrumb($lft = 0, $rgt = 0, $select = 'id, title, slug, canonical, lft, rgt'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		$this->db->where(array(
			'lft <=' => $lft,
			'rgt >=' => $rgt,
		));
		$this->db->from('videos_catalogues');
		$this->db->order_by('lft ASC, order ASC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Hiển thị danh mục theo cấp con
	//-----------------------------------------------------
	public function ReadAllByAutoSub($catalogues = NULL){
		$this->db->where(array('trash' => 0));
		$this->db->from('videos_catalogues');
		if($catalogues['rgt'] - $catalogues['lft'] == 1){
			$this->db->where(array('parentid' => $catalogues['parentid']));
		}
		else{
			$this->db->where(array('parentid' => $catalogues['id']));
		}
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}


	//-----------------------------------------------------
	// Xem danh mục cho sitemap
	//-----------------------------------------------------
	public function ReadAllForSitemap($select = 'id, title, slug, canonical, images, description, created'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		$this->db->from('videos_catalogues');
		$this->db->order_by('created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByCondition($param = '', $flag = FALSE){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? (int)$param['limit'] : 0);
		
		
		$this->db->select($param['select']);
		$this->db->from('videos_catalogues');
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
	
	public function ReadArticles($cataloguesid = 0){
		$this->db->select('id, title, slug, canonical, images, description, created');
		$this->db->where(array('trash' => 0,'cataloguesid' => $cataloguesid));
		$this->db->from('articles');
		$this->db->limit(4, 0);
		$this->db->order_by('order asc, id desc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	

}
