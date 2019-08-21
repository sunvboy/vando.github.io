<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendArticlesCatalogues_Model',
			'FrontendArticlesCatalogues_Model'
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'articles_catalogues'));
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
		$flag = $this->BackendArticlesCatalogues_Model->UpdateBatchByField($data, 'id');
		if($flag > 0){
			$this->nestedsetbie->Get('level ASC, order ASC');
			$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
			$this->nestedsetbie->Action();
		}
	}

	public function viewed(){
		$id = $this->input->post('id');
		if(!isset($_COOKIE['articles_catalogues_viewed_'.$id])){
			$flag = $this->FrontendArticlesCatalogues_Model->UpdateViewed('id', $id);
			setcookie('articles_catalogues_viewed_'.$id, 1, NULL, '/');
		}
	}
}
