<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendAttributesCatalogues_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}


	//-----------------------------------------------------
	// Xem chi tiết danh mục
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('attributes_catalogues');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	
	public function ReadByFieldArr($field = '', $limit = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('attributes_catalogues');
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
		$this->db->where(array($field => $value))->set('viewed', 'viewed+1', FALSE)->update('attributes_catalogues');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Hiển thị danh mục theo field
	//-----------------------------------------------------
	public function ReadAllByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('attributes_catalogues');
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
		$this->db->from('attributes_catalogues');
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
		$this->db->from('attributes_catalogues');
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
		$this->db->from('attributes_catalogues');
		$this->db->order_by('created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}



}
