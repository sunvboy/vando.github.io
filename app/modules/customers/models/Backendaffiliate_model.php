<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendAffiliate_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$customersid = (int)$this->input->get('customersid');
		if(!empty($customersid)){
			$this->db->where(array('customers_log_affiliate.customersid' => $customersid));
		}
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(customers.email LIKE \'%'.$keyword.'%\' OR customers.fullname LIKE \'%'.$keyword.'%\' OR customers.phone LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('customers_log_affiliate');
		$this->db->join('customers', 'customers.id = customers_log_affiliate.customersid');
		$this->db->join('payments', 'payments.id = customers_log_affiliate.paymentsid');

		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$customersid = (int)$this->input->get('customersid');
		if(!empty($customersid)){
			$this->db->where(array('customers_log_affiliate.customersid' => $customersid));
		}
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(customers.email LIKE \'%'.$keyword.'%\' OR customers.fullname LIKE \'%'.$keyword.'%\' OR customers.phone LIKE \'%'.$keyword.'%\')');
		}
		$this->db->select('customers_log_affiliate.*, customers.fullname, customers.email');
		$this->db->from('customers_log_affiliate');
		$this->db->join('customers', 'customers.id = customers_log_affiliate.customersid');
		$this->db->join('payments', 'payments.id = customers_log_affiliate.paymentsid');
		$this->db->order_by('customers_log_affiliate.id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = 'id', $value = 0){
		$this->db->from('customers_log_affiliate');
		$this->db->where(array($field => $value, 'trash' => 0))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
}
