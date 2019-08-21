<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendSlidesGroups_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function Nav(){
		$this->db->select('id, title, slug, parentid, lft, rgt, level, ishome, isaside');
		$this->db->where(array('trash' => 0));
		$this->db->from('articles_catalogues');
		$result = $this->db->get()->result_array('id');
		$this->db->flush_cache();
		return $result;
	}

	public function IsField($param = NULL, $select = 'id, title, slug, lft, rgt, ishome, isaside'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('articles_catalogues');
		$this->db->order_by('lft ASC, order ASC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Read($id = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('articles_catalogues');
		$this->db->where(array('id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Breadcrumb($lft = 0, $rgt = 0, $select = 'id, title, slug, lft, rgt'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		$this->db->where(array(
			'lft <=' => $lft,
			'rgt >=' => $rgt,
		));
		$this->db->from('articles_catalogues');
		$this->db->order_by('lft ASC, order ASC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

}
