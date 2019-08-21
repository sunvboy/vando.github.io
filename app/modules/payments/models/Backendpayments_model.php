<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendPayments_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($userid = 0){
//		if($this->input->get('id') == (string)'cod'){
//			$this->db->where(array('trash' => 0,'payments' => 'cod'));
//
//		}else if($this->input->get('id') == (string)'online'){
//			$this->db->where(array('trash' => 0,'payments' => 'online'));
//
//		}else{
//			$this->db->where(array('trash' => 0,'payments' => 'cod'));
//
//		}
		$this->db->where(array('trash' => 0));

		$keyword = $this->input->get('keyword');
		$status = $this->input->get('status');
		
		
		$day_start = $this->input->get('day_start');
		$day_end = $this->input->get('day_end');
	
		if(!empty($day_start) && !empty($day_end)){
			$day_start = $this->input->get('day_start');
			$day_end = $this->input->get('day_end');
			$this->db->where(array(
				'created >=' => $day_start,
				'created <=' => $day_end,
			));
		}
		if($userid > 0){
			$this->db->where('userid', $userid);
		}
		
		if(!empty($status)){
			$this->db->where('status', $status);
		}
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(email LIKE \'%'.$keyword.'%\' OR fullname LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')');
		}
		
		$this->db->from('payments');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();

		return $result;
	}

	public function ReadAll($userid = 0, $start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$this->db->select('payments.*');
		$keyword = $this->input->get('keyword');
		$status = $this->input->get('status');
		
		$day_start = $this->input->get('day_start');
		$day_end = $this->input->get('day_end');
	
		if(!empty($day_start) && !empty($day_end)){
			$day_start = $this->input->get('day_start');
			$day_end = $this->input->get('day_end');
			$this->db->where(array(
				'created >=' => $day_start,
				'created <=' => $day_end,
			));
		}
		
		if($userid > 0){
			$this->db->where('userid', $userid);
		}
		if(!empty($status)){
			$this->db->where('status', $status);
		}
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(email LIKE \'%'.$keyword.'%\' OR fullname LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')');
		}
	
		$this->db->from('payments');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('payments');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('payments', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	/* ------------------DATABASE ------------------  */
	public function ReadDataByTime($param = ''){
		$this->db->select('*');
		$this->db->from('payments');
		if(isset($param['keyword']) &&  $param['keyword'] != ''){
			$keyword = $this->db->escape_like_str($param['keyword']);
			$this->db->where('(fullname LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR message LIKE \'%'.$keyword.'%\')');
		}
		if(isset($param['status']) && !empty($param['status'])){
			$this->db->where('status', $param['status']);
		}
		
		$this->db->where(array(
			'trash' => 0,
			'created >=' => $param['from'],
			'created <=' => $param['to'],
		));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function ReadDataRelationShip($param = ''){
		if(isset($param['where']) && $param['where'] != ''){
			$str_where = $param['where'];
		}
		$data = $this->db->query('
			SELECT `pr`.`id`, `pr`.`email`, `pr`.`images`, `pt`.`fullname`, `pt`.`address`, `pt`.`id` as paymentsid, `pt`.`gender`, `pt`.`phone`, `pt`.`email`, `pt`.`cityid`, `pt`.`districtid`, `pt`.`total_price`, `pt`.`message`, `pt`.`status`, `pt`.`send`, `pt`.`created`
			FROM `payments_items` as `pti`
			INNER JOIN `products` as `pr`
			INNER JOIN `payments` as `pt`
			WHERE `pr`.`trash` = 0 AND `pt`.`trash` = 0 AND `pr`.`publish` = 1 AND `pti`.`paymentsid` = `pt`.`id` AND `pti`.`productsid` = `pr`.`id` '.(!empty($str_where) ? ' AND '.$str_where:'').'
			ORDER BY `pt`.`id` asc
		')->result_array();
		$this->db->flush_cache();
		return $data;
	}
	
	/* Thống kê */
	public function Statistic($param = ''){
		$year = (int)$this->input->get('year');
		$year = (!empty($year) && $year > 0 ) ? $year : date("Y");
		
		$this->db->select_sum('total_price');
		// $this->db->select('total, fullname');
		$this->db->from('payments');
		if(isset($param['month'])){
			$this->db->where(array(
				'created >=' => $year.'-'.$param['month'].'-'.'01',
				'created <=' => $year.'-'.($param['month']+1).'-'.'01',
			));
		}
		$this->db->where(array('trash' => 0,'publish' => 1,'status' => 'success',));
		// $this->db->where(array('process' => $param['process']));
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return (int)$result['total_price'];
	}
	
}
