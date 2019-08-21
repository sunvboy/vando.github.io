<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendNavigationsMenusItems_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function InsertBatchByMenusid($menusid = 0){
		$data = NULL;
		for($i = 1; $i <= 15; $i++){
			$title = $this->input->post('title'.$i);
			$href = $this->input->post('href'.$i);
			if(empty($title) || empty($href)) continue;
			$temp = array(
				'title' => $title,
				'href' => $href,
				'order' => $this->input->post('order'.$i),
				'modules' => $this->input->post('modules'),
				'modulesid' => $this->input->post('modulesid'.$i),
				'menusid' => $menusid,
			);
			if(isset($temp) && is_array($temp) && count($temp)){
				$data[] = $temp;	
			}
		}
		if(isset($data) && is_array($data) && count($data)){
			$result = $this->db->insert_batch('navigations_menus_items', $data); 
			$this->db->flush_cache();
			return $result;
		}
	}

	public function DeleteByMenusid($menusid = 0){
		$this->db->where(array('menusid' => $menusid))->delete('navigations_menus_items');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByMenusid($menusid = 0){
		$data = NULL;
		$this->db->select('*');
		$this->db->from('navigations_menus_items');
		$this->db->where(array('menusid' => $menusid));
		$this->db->order_by('order ASC');
		$result = $this->db->get()->result_array();
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$data[] = $val;
			}
		}
		$this->db->flush_cache();
		return $data;
	}

}
