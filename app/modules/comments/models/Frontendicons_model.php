<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontendicons_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function view(){
		$this->db->select('*');
		$this->db->from('comments_icons');
		$this->db->where(array(
			'trash' => 0,
			'publish' => 1,
		));
		$this->db->where(array('trash' => 0));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}


}