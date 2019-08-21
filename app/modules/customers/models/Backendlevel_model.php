<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendLevel_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('customers_level');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('customers_level');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = 'id', $value = 0){
		$this->db->from('customers_level');
		$this->db->where(array($field => $value, 'trash' => 0))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create(){
		$price = (int)str_replace('.','', $this->input->post('range_price'));
		$data = array(
			'title' => $this->input->post('title'),
			'discounted' => $this->input->post('discounted'),
			'range_price' => $price,
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('customers_level', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = 'id', $value = 0){
		$price = (int)str_replace('.','', $this->input->post('range_price'));
		$data = array(
			'title' => $this->input->post('title'),
			'discounted' => $this->input->post('discounted'),
			'range_price' => $price,
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array($field => $value))->update('customers_level', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	public function Dropdown(){
		$this->db->select('id, title');
		$this->db->from('customers_level');
		$this->db->where(array(
			'publish' => 1,
			'trash' => 0,
		));
		$this->db->order_by('id desc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		$temp = '';
		$temp[0] = '[Gói cơ bản]';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[$val['id']] = $val['title'];
			}
		}
		return $temp;
	}
}
