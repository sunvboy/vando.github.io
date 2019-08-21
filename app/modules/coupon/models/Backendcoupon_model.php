<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendCoupon_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$this->db->from('coupon');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('coupon');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = ''){
		$data = array(
			'couponCode' => $this->input->post('couponCode'),
			'couponType' => $this->input->post('couponType'),
			'couponTypeValue' => $this->input->post('couponTypeValue'),
			'requiresMinimumPurchase' => ((!empty($this->input->post('requiresMinimumPurchase'))) ? $this->input->post('requiresMinimumPurchase') : 0),
			'minimumPurchase' => $this->input->post('minimumPurchase'),
			'appliesTo' => $this->input->post('appliesTo'),
			'CollectionId' => $this->input->post('CollectionId'),
			'ProductsId' => $this->input->post('ProductsId'),
			'limitTotalUse' => ((!empty($this->input->post('limitTotalUse'))) ? $this->input->post('limitTotalUse') : 0),
			'limitedUseTotal' => $this->input->post('limitedUseTotal'),
			'date_start' => convert_time_2($this->input->post('date_start')),
			'scheduleEndDate' => ((!empty($this->input->post('scheduleEndDate'))) ? $this->input->post('scheduleEndDate') : 0),
			'date_end' => ((!empty($this->input->post('scheduleEndDate'))) ? convert_time_2($this->input->post('date_end')) : '0000-00-00 00:00:00'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('coupon', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function Update($id = 0, $user = ''){
		$data = array(
			'couponCode' => $this->input->post('couponCode'),
			'couponType' => $this->input->post('couponType'),
			'couponTypeValue' => $this->input->post('couponTypeValue'),
			'requiresMinimumPurchase' => ((!empty($this->input->post('requiresMinimumPurchase'))) ? $this->input->post('requiresMinimumPurchase') : 0),
			'minimumPurchase' => $this->input->post('minimumPurchase'),
			'appliesTo' => $this->input->post('appliesTo'),
			'CollectionId' => $this->input->post('CollectionId'),
			'ProductsId' => $this->input->post('ProductsId'),
			'limitTotalUse' => ((!empty($this->input->post('limitTotalUse'))) ? $this->input->post('limitTotalUse') : 0),
			'limitedUseTotal' => $this->input->post('limitedUseTotal'),
			'date_start' => convert_time_2($this->input->post('date_start')),
			'scheduleEndDate' => ((!empty($this->input->post('scheduleEndDate'))) ? $this->input->post('scheduleEndDate') : 0),
			'date_end' => convert_time_2($this->input->post('date_end')),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array('id' => $id))->update('coupon', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function CheckField($field = '', $value = ''){
		$this->db->select('id');
		$this->db->from('coupon');
		$this->db->where(array(
			$field => $value,
			'trash' => 0,
		));
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}
	public function ReadByFeild($id = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('coupon');
		$this->db->where(array('id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
}