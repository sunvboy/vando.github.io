<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendNavigationsMenus_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function ReadAllByField($canonical = 'main-menu', $lang = 'vietnamese'){
		$this->db->select('navigations_menus.*');
		$this->db->from('navigations_menus');
		$this->db->join('navigations_positions', 'navigations_positions.id = navigations_menus.positionsid');
		$this->db->where(array('navigations_positions.canonical' => $canonical, 'navigations_menus.publish' => 1, 'navigations_menus.alanguage' => $lang));
		$this->db->order_by('navigations_menus.order ASC');
		$result = $this->db->get()->result_array();
		
		$this->db->flush_cache();
		return $result;
	}


	public function ReadAllItemsByField($menusid = NULL){
		$this->db->from('navigations_menus_items');
		$this->db->where_in('menusid', $menusid);
		$this->db->order_by('order ASC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
}
