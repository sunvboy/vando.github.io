<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendSupportsCatalogues_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function ReadByCondition($param = '', $flag = FALSE){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? (int)$param['limit'] : 0);
		
		
		$this->db->select($param['select']);
		$this->db->from('supports_catalogues');
		$this->db->where('trash', 0);
		$this->db->where($param['where']);
		$this->db->limit($param['limit'], 0);
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	

}
