<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendCustomers_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	/* Log làm bài thi */

	public function create_log($data = ''){
		$this->db->insert('customers_testpapers_log', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	/* Log Tích điểm */
	public function CountAllLog($customerid = 0){
		$this->db->where(array('userid' => $customerid));
		$this->db->select('id');
		$this->db->from('customers_payment_log');
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}

	public function ReadAllLog($start = 0, $limit = 0, $customerid = 0){
		$this->db->select('customers_payment_log.*,  (SELECT code  FROM payments WHERE payments.id = customers_payment_log.paymentid) as id_payment, (SELECT fullname  FROM customers WHERE customers.id = customers_payment_log.userid) as customer_buy');
		$this->db->where(array('userid' => $customerid));
		$this->db->from('customers_payment_log');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	/* END Log Tích điểm */

	public function ReadByCustomersParam($param = NULL, $select = 'customers.id, customers.email, customers.fullname, customers.phone, customers.images, customers.address, customers.created, customers.level, customers.affiliate_id'){
		$this->db->select($select);
		$this->db->from('customers');
		$this->db->join('customers_groups', 'customers.groupsid = customers_groups.id');
		$this->db->where(array('customers.trash' => 0));
		$this->db->where($param)->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function CheckFieldByCondition($field = '', $value = ''){
		$this->db->select('id');
		$this->db->from('customers');
		$this->db->where(array(
			$field => $value,
			'trash' => 0,
			'publish' => 1,
		));
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}
	
	public function Create(){
		$salt = random();
		$password = password_encode($this->input->post('password'), $salt);
		$data = array(
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'fullname' => $this->input->post('fullname'),
			'address' => $this->input->post('address'),
			'lock' => 1,
			'password' => $password,
			'salt' => $salt,
			'groupsid' => 5,
			'publish' => 1,
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('customers', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByField($field = 'id', $value = 0){
		$this->db->select('*, (SELECT title FROM customers_groups WHERE customers_groups.id = customers.groupsid) as groups_title');
		$this->db->from('customers');
		$this->db->where(array($field => $value))->limit(1, 0);
		$this->db->where(array('trash' => 0));
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function UpdateByField($field = 'id', $value = 0, $param = NULL){
		$this->db->where(array($field => $value))->update('customers', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function Location(){
		$this->db->select('id, title');
		$this->db->from('province');
		$this->db->where('parentid', 0);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function district($cityid = 0){
		$this->db->select('id, title');
		$this->db->from('province');
		$this->db->where('parentid', $cityid);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function CountOrder($customerid = 0){
		$this->db->select('id');
		$this->db->from('payments');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(address LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')');
		}
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		
		if(!empty($start_date) && !empty($end_date)){
			$start_date = explode('/',$start_date);
			$start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0].' 00:00:00';
			$end_date = explode('/',$end_date);
			$end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0].' 23:59:00';
			
			$this->db->where(array(
				'created >=' => $start_date,
				'created <=' => $end_date,
			));
		}
		$this->db->where(array(
			'trash' => 0,
			'userid_created' => $customerid,
		));
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}
	
	public function ReadAllOrder($start = 0, $limit = 0, $customerid = 0){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		
		if(!empty($start_date) && !empty($end_date)){
			$start_date = explode('/',$start_date);
			$start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0].' 00:00:00';
			$end_date = explode('/',$end_date);
			$end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0].' 23:59:00';
			
			$this->db->where(array(
				'created >=' => $start_date,
				'created <=' => $end_date,
			));
		}
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(address LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('payments');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadDetailOrder($paymentsid = 0, $customer = 0){
		$this->db->select('payments.*, payments_items.productsid, payments_items.quantity, payments_items.price');
		$this->db->where(array('payments.trash' => 0, 'payments.userid_created' => $customer['id'],'payments_items.paymentsid' => $paymentsid));
		$this->db->from('payments');
		$this->db->join('payments_items', 'payments.id = payments_items.paymentsid');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

}
