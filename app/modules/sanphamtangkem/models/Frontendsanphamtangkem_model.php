<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendSanphamtangkem_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('publish' => 1));
		$this->db->from('products_sanphamtangkem');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	
}