<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendArticles_Model',
			'FrontendArticles_Model',
			'tags/BackendTags_Model',
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
	public function createLink() {
		$link = $this->input->post('canonical');
		$link = slug($link);
	}
	public function sort_order() {
		sleep(0.5);
		$id = $this->input->post('id');
		$table = $this->input->post('table');
		$data = $this->input->post('number');
		if(isset($table) && !empty($table) && $id > 0) {
			$this->BackendArticles_Model->_update_sort_order($table, $id, $data);
		}
	}
	
	public function delete(){
		$error = true;
		$message = '';
		$id = $this->input->post('post');
		if(isset($id) && is_array($id) && count($id)){
			foreach($id as $key => $val){
				$DetailArticles = $this->BackendArticles_Model->ReadByField('id', $val);
				$flag = $this->BackendArticles_Model->DeleteByField('id', $val);
				if($flag > 0){
					if(!empty($DetailArticles['canonical'])){
						$this->BackendRouters_Model->Delete($DetailArticles['canonical'], 'articles/frontend/articles/view', $DetailArticles['id'], 'number');
					}
					$this->BackendArticles_Model->_delete_relationship('articles', $val);
					$this->BackendTags_Model->DeleteByModule($val, 'articles');
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
	
}
