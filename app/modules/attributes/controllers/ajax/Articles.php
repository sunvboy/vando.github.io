<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendArticles_Model',
			'FrontendArticles_Model'
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
		$flag = $this->BackendArticles_Model->UpdateBatchByField($data, 'id');
	}

	public function viewed(){
		$id = $this->input->post('id');
		if(!isset($_COOKIE['articles_viewed_'.$id])){
			$flag = $this->FrontendArticles_Model->UpdateViewed('id', $id);
			setcookie('articles_viewed_'.$id, 1, NULL, '/');
		}
	}
}
