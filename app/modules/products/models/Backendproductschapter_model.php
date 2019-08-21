<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendProductsChapter_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function Create($array = ''){
		
		// print_r($array);die;
		
		if(isset($array) && is_array($array) && count($array)){
			foreach ($array as $keyc => $valc) {
				// Insert Chapter cho khóa học
				$data = array(
					'productsid' => $valc['productsid'],
					'title' => $valc['title'],
					'page' => json_encode($valc['page']),
					'publish' => 1,
				);
				$this->db->insert('products_chapter', $data);
				$resultid = $this->db->affected_rows();
				if($resultid > 0){
					$resultid = $this->db->insert_id();
					// Insert page cho khóa học
					if (isset($valc['page']) && is_array($valc['page']) && count($valc['page'])) {
						foreach ($valc['page'] as $keypp => $valp) {
							$data2 = array(
								'chapterid' => $resultid,
								'productsid' => $valc['productsid'],
								'title' => $valp['title'],
								'time' => $valp['time'],
								'description' => $valp['description'],
								'source' => $valp['source'],
								'publish' => 1,
							);
							$this->db->insert('products_page', $data2);
							$result = $this->db->affected_rows();
							$this->db->flush_cache();
						}
					}
				}
			}
		}
	}


	public function Update($array = ''){
		
		// print_r($array);die;
		
		if(isset($array) && is_array($array) && count($array)){
			foreach ($array as $keyc => $valc) {
				// Insert Chapter cho khóa học
				$data = array(
					'productsid' => $valc['productsid'],
					'title' => $valc['title'],
					'page' => json_encode($valc['page']),
					'publish' => 1,
					'trash' => 0,
				);
				
				if (!empty($valc['id'])) {
					$this->db->where(array('id' => $valc['id']))->update('products_chapter', $data);
				}else{
					$this->db->insert('products_chapter', $data);
				}
				
				$resultid = $this->db->affected_rows();
				if($resultid > 0){
					if (!empty($valc['id'])) {
						$resultid = $valc['id'];
					}else{
						$resultid = $this->db->insert_id();
					}
					// Insert page cho khóa học
					if (isset($valc['page']) && is_array($valc['page']) && count($valc['page'])) {
						foreach ($valc['page'] as $keypp => $valp) {
							$data2 = array(
								'chapterid' => $resultid,
								'productsid' => $valc['productsid'],
								'title' => $valp['title'],
								'time' => $valp['time'],
								'description' => $valp['description'],
								'source' => $valp['source'],
								'publish' => 1,
								'trash' => 0,
							);
							if (!empty($valp['id'])) {
								$this->db->where(array('id' => $valp['id']))->update('products_page', $data2);
							}else{
								$this->db->insert('products_page', $data2);
							}
							$result = $this->db->affected_rows();
							$this->db->flush_cache();
						}
					}
				}
			}
		}
	}

	public function Update_trash($id = 0){
		$this->db->select('id, title');
		$this->db->from('products_chapter');
		$this->db->where(array('productsid' => $id));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();

		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$this->db->where(array('id' => $val['id']))->update('products_chapter', array('trash' => 1));
				$this->db->affected_rows();
				$this->db->where(array('chapterid' => $val['id']))->update('products_page', array('trash' => 1));
				$this->db->flush_cache();
			}
		}

		return $result;
	}


	public function Delete($field = '', $value = ''){
		$this->db->select('id, title');
		$this->db->from('products_chapter');
		$this->db->where(array($field => $value));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();

		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				// $this->db->where(array('id' => $val['id']))->update('products_chapter', array('trash' => 1));
				$this->db->where(array('id' => $val['id']))->delete('products_chapter');
				$this->db->affected_rows();
				// $this->db->where(array('chapterid' => $val['id']))->update('products_page', array('trash' => 1));
				$this->db->where(array('chapterid' => $val['id']))->delete('products_page');
				$this->db->flush_cache();
			}
		}

		return $result;
	}


	public function ReadByFieldArrChapter($field = '', $value = 0){
		$this->db->where(array('trash' => 0, 'publish' => 1));
		$this->db->from('products_chapter');
		$this->db->where(array($field => $value));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByFieldArrPage($field = '', $value = 0){
		$this->db->where(array('trash' => 0, 'publish' => 1));
		$this->db->from('products_page');
		$this->db->where(array($field => $value));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
}