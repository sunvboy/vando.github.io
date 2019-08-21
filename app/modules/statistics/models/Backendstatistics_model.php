<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendStatistics_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$customersid = (int)$this->input->get('customersid');
		$process = $this->input->get('process');
		if(!empty($customersid)){
			$this->db->where(array('customers.id' => $customersid));
		}
		if(isset($process) && $process != -1){
			$this->db->where(array('payments.process' => $process));
		}
		$this->db->from('payments');
		$this->db->join('customers', 'customers.affiliate_id = payments.affiliate_id');
		$this->db->where(array('payments.trash' => 0));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$customersid = (int)$this->input->get('customersid');
		$process = $this->input->get('process');
		if(!empty($customersid)){
			$this->db->where(array('customers.id' => $customersid));
		}
		if(isset($process) && $process != -1){
			$this->db->where(array('payments.process' => $process));
		}
		$this->db->select('payments.*, customers.fullname, customers.email, customers.affiliate_id as affiliate_customers');
		$this->db->from('payments');
		$this->db->join('customers', 'customers.affiliate_id = payments.affiliate_id');
		$this->db->where(array('payments.trash' => 0));
		$this->db->order_by('payments.id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
}
