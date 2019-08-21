<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendQuestions_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(documents_catalogues.title LIKE \'%'.$keyword.'%\' OR customers.fullname LIKE \'%'.$keyword.'%\' OR customers.email LIKE \'%'.$keyword.'%\')');
		}
		$day_start = $this->input->get('day_start');
		$day_end = $this->input->get('day_end');
	
		if(!empty($day_start) && !empty($day_end)){
			$day_start = convert_time($this->input->get('day_start'));
			$day_end = convert_time($this->input->get('day_end'));
			$this->db->where(array(
				'customers_testpapers_log.created >=' => $day_start,
				'customers_testpapers_log.created <=' => $day_end,
			));
		}

		$this->db->where(array('customers_testpapers_log.trash' => 0));
		$this->db->from('customers_testpapers_log');
		$this->db->join('customers', 'customers.id = customers_testpapers_log.customersid');
		$this->db->join('documents_catalogues', 'documents_catalogues.id = customers_testpapers_log.questionsid');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->select('customers_testpapers_log.*, documents_catalogues.title, customers.fullname, customers.email');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(documents_catalogues.title LIKE \'%'.$keyword.'%\' OR customers.fullname LIKE \'%'.$keyword.'%\' OR customers.email LIKE \'%'.$keyword.'%\')');
		}
		$day_start = $this->input->get('day_start');
		$day_end = $this->input->get('day_end');
	
		if(!empty($day_start) && !empty($day_end)){
			$day_start = convert_time($this->input->get('day_start'));
			$day_end = convert_time($this->input->get('day_end'));
			$this->db->where(array(
				'customers_testpapers_log.created >=' => $day_start,
				'customers_testpapers_log.created <=' => $day_end,
			));
		}
		$this->db->where(array('customers_testpapers_log.trash' => 0));
		$this->db->from('customers_testpapers_log');
		$this->db->join('customers', 'customers.id = customers_testpapers_log.customersid');
		$this->db->join('documents_catalogues', 'documents_catalogues.id = customers_testpapers_log.questionsid');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadByField($field = '', $value = 0){
		$this->db->select('customers_testpapers_log.*, documents_catalogues.title, customers.fullname');
		$this->db->where(array('customers_testpapers_log.trash' => 0));
		$this->db->from('customers_testpapers_log');
		$this->db->join('customers', 'customers.id = customers_testpapers_log.customersid');
		$this->db->join('documents_catalogues', 'documents_catalogues.id = customers_testpapers_log.questionsid');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('customers_testpapers_log', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
}
