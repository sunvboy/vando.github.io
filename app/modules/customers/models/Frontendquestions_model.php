<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendQuestions_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($param = ''){
		if (isset($param) && is_array($param) && count($param)) {
			$this->db->where($param);
		}
		$this->db->from('payments');
		$this->db->where(array('trash' => 0));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $param = ''){
		if(!empty($customersid)){
			$this->db->where(array('customersid' => $customersid));
		}
		if (isset($param) && is_array($param) && count($param)) {
			$this->db->where($param);
		}
		$this->db->from('payments');
		$this->db->where(array('trash' => 0));
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	
	public function CountAllDailyOrder($customerid = 0){
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(code LIKE \'%'.$keyword.'%\')');
		}
		
		$this->db->select('*');
		$this->db->where(array('trash' => 0,'customerid' => $customerid));
		$this->db->from('daily');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function ReadAllDailyOrder($start = 0, $limit = 0, $customerid = ''){
		$this->db->select('*, (SELECT title FROM tours WHERE daily.tourid = tours.id) as tour_title, (SELECT real_place FROM tours WHERE daily.tourid = tours.id) as total_place');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(code LIKE \'%'.$keyword.'%\')');
		}
		
		$this->db->where(array('trash' => 0,'customerid' => $customerid));
		$this->db->from('daily');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function CountAllCoint($param = ''){
		if (isset($param) && is_array($param) && count($param)) {
			$this->db->where($param);
		}
		$this->db->from('customers_coint');
		$this->db->where(array('trash' => 0));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAllCoint($start = 0, $limit = 0, $param = ''){
		if (isset($param) && is_array($param) && count($param)) {
			$this->db->where($param);
		}
		$this->db->from('customers_coint');
		$this->db->where(array('trash' => 0));
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

}
