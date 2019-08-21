<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendCustomers_Model',
		));
		$this->fcCustomer = $this->config->item('fcCustomer');
		$this->load->library(array('configbie'));
	}

	
	public function avatar(){
		sleep(1);
		$image = $this->input->post('post');
		$data = array(
			'images' => $image,
		);
		
		$this->db->where('id', $this->fcCustomer['id']);
		$this->db->update('customers', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		echo $result;
	}
}
