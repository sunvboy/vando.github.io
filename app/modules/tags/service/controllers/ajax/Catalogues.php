<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendArticlesCatalogues_Model',
			'FrontendArticlesCatalogues_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
		$this->fclang = $this->config->item('fclang');
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

	public function delete(){
		$error = true;
		$message = '';
		$id = $this->input->post('post');
		if(isset($id) && is_array($id) && count($id)){
			foreach($id as $key => $val){
				$DetailArticlesCatalogues = $this->BackendArticlesCatalogues_Model->ReadByField('id', $val, $this->fclang);
				$flag = $this->BackendArticlesCatalogues_Model->DeleteByField('id', $val);
				if($flag > 0){
					/*Xóa những bài viết chỉ nhận danh mục này làm cha*/
					// $articles_id = catalogues_relationship($DetailArticlesCatalogues['id'], 'articles', array('BackendArticles','BackendArticlesCatalogues'), 'articles_catalogues');
					// $_delete_ = check_delete($articles_id, 'articles');
					/* ------------------------------------------------*/
					/* Xóa đường dẫn trong routers */
					$this->BackendRouters_Model->Delete($DetailArticlesCatalogues['canonical'], 'articles/frontend/catalogues/view', $DetailArticlesCatalogues['id'], 'number');	
					/* -----------------------------*/
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$error = false;
					$message = 'Bản ghi đã được xóa thành công';
				}
			}
		}else{
			$message = 'Có lỗi trong quá trình xóa bản ghi, vui lòng kiểm tra lại';
		}
		echo json_encode(array(
			'error' => $error,
			'message' => $message,
		)); die();
	}

	public function viewed(){
		$id = $this->input->post('id');
		if(!isset($_COOKIE['articles_catalogues_viewed_'.$id])){
			$flag = $this->FrontendArticlesCatalogues_Model->UpdateViewed('id', $id);
			setcookie('articles_catalogues_viewed_'.$id, 1, NULL, '/');
		}
	}
	public function createLink() {
		$link = $this->input->post('canonical');
		$link = slug($link);
		echo $link;
	}
	public function createWeek() {
		$date = $this->input->post('date');
		echo date('W', strtotime($date));
	}
}
