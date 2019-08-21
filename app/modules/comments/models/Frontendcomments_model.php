<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendComments_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function Countall($module = '', $moduleid = 0){
		$this->db->where(array('comments.type' => 'danhgia','comments.trash' => 0, 'comments.publish' => 1, 'comments.module' => $module, 'comments.moduleid' => $moduleid));
		$this->db->from('comments');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function View($start = 0, $limit = 0, $module = '', $moduleid = 0){
		$this->db->select('comments.*, (SELECT images FROM customers WHERE customers.id = comments.customersid ) as avatar');
		$this->db->where(array('comments.type' => 'danhgia','comments.trash' => 0, 'comments.publish' => 1, 'comments.module' => $module, 'comments.moduleid' => $moduleid));
		$this->db->from('comments');
		$this->db->order_by('comments.id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	
//	public function ViewQuestions($module = '', $moduleid = 0, $customersid = 0){
//		$this->db->select('questions.*, customers.fullname, customers.images');
//		$this->db->where(array('questions.trash' => 0, 'questions.publish' => 1, 'questions.module' => $module, 'questions.moduleid' => $moduleid, 'questions.customersid' => $customersid));
//		$this->db->from('questions');
//		$this->db->join('customers', 'customers.id = questions.customersid');
//		$this->db->order_by('questions.id ASC');
//		$result = $this->db->get()->result_array();
//		$this->db->flush_cache();
//		return $result;
//	}


	public function CountallQuestions($module = '', $moduleid = 0){
		$this->db->where(array('comments.type' => 'cauhoi','comments.trash' => 0, 'comments.publish' => 1, 'comments.module' => $module, 'comments.moduleid' => $moduleid));
		$this->db->from('comments');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ViewQuestions($start = 0, $limit = 0, $module = '', $moduleid = 0){
		$this->db->select('comments.*, (SELECT images FROM customers WHERE customers.id = comments.customersid ) as avatar');
		$this->db->where(array('comments.type' => 'cauhoi','comments.trash' => 0, 'comments.publish' => 1, 'comments.module' => $module, 'comments.moduleid' => $moduleid));
		$this->db->from('comments');
		$this->db->order_by('comments.id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

}