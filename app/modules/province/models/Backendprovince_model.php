<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendProvince_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function countall(){
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->where('parentid',0);
		$this->db->from('province');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->select('province.*');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\)');
		}
		$this->db->where('parentid',0);
		$this->db->from('province');
		$this->db->order_by('order DESC, title asc');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function readF($id = 0){
		$this->db->select('province.title');
		$this->db->from('province');
		$this->db->where(array('id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result['title'];
	}
	public function read($id = 0){
		$this->db->from('province');
		$this->db->where(array('id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}


	public function dropdown(){
		$this->db->where(array('trash' => 0));
		$result = $this->db->select('id, title')->from('province')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = '- Chọn nhóm hỗ trợ trực tuyến -';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}


	

}
