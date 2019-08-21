<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendSaleDG_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}
	public function ReadByField($field = '', $value = 0){
		$time = date('Y/m/d H:i:s');
		$this->db->where(array(
			'time_end >=' => $time,
			'time_start <=' => $time,
		));
		$this->db->where(array('trash' => 0,'publish'=>1));
		$this->db->from('products_sale');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByFieldSoLuong($id){
		$time = date('Y/m/d H:i:s');
		$this->db->where(array(
			'time_end >=' => $time,
			'time_start <=' => $time,
		));
		$this->db->where(array('id' => $id,'publish'=>1))->limit(1, 0);
		$this->db->from('products_sale_soluong');
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByFieldTungSanPham($field = '', $value = 0){
		$this->db->from('products_sale_tungsanpham');
		$time = date('Y/m/d H:i:s');
		$this->db->where(array(
			'time_end >=' => $time,
			'time_start <=' => $time,
		));
		$this->db->where(array($field => $value,'publish'=>1))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByFieldProductsColors($field = '', $value = 0){
		$this->db->where(array($field => $value));
		$this->db->from('products_color');
		$this->db->order_by('id DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
}
