<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendVideos_Model',
			'FrontendVideos_Model',
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
		$flag = $this->BackendVideos_Model->UpdateBatchByField($data, 'id');
	}

	public function viewed(){
		$id = $this->input->post('id');
		if(!isset($_COOKIE['videos_viewed_'.$id])){
			$flag = $this->FrontendVideos_Model->UpdateViewed('id', $id);
			setcookie('videos_viewed_'.$id, 1, NULL, '/');
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
			$this->BackendVideos_Model->_update_sort_order($table, $id, $data);
		}
	}
	
	public function delete(){
		$error = true;
		$message = '';
		$id = $this->input->post('post');
		if(isset($id) && is_array($id) && count($id)){
			foreach($id as $key => $val){
				$DetailVideos = $this->BackendVideos_Model->ReadByField('id', $val);
				$flag = $this->BackendVideos_Model->DeleteByField('id', $val);
				if($flag > 0){
					if(!empty($DetailVideos['canonical'])){
						$this->BackendRouters_Model->Delete($DetailVideos['canonical'], 'videos/frontend/videos/view', $DetailVideos['id'], 'number');
					}
					$this->BackendVideos_Model->_delete_relationship('videos', $val);
					$this->BackendTags_Model->DeleteByModule($val, 'videos');
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
