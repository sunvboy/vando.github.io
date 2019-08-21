<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendNavigationsMenus_Model'
		));
		$this->load->library(array('configbie'));
	}

	public function sort(){
		$data = NULL;
		$post = $this->input->post();
		foreach($post['order'] as $key => $val){
			$data[] = array(
				'id' => $key,
				'order' => $val,
			);
		}
		$flag = $this->BackendNavigationsMenus_Model->UpdateBatchByField($data, 'id');
	}
}
