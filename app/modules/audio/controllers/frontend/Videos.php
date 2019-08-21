<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends FC_Controller{

	public function __construct(){
		parent::__construct();
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
	}

	public function View($id = 0){
		$id = (int)$id;
		$DetailVideos = $this->FrontendVideos_Model->ReadByField('id', $id);
		if(!isset($DetailVideos) && !is_array($DetailVideos) && count($DetailVideos) == 0){
			$this->session->set_flashdata('message-danger', 'videos không tồn tại');
			redirect(base_url());
		}
		
		$DetailCatalogues = $this->FrontendVideosCatalogues_Model->ReadByField('id', $DetailVideos['cataloguesid']);
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục videos không tồn tại');
			redirect(base_url());
		}
		$data['Breadcrumb'] = $this->FrontendVideosCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt']);
		$data['TagsList'] = $this->FrontendTags_Model->ReadByModule($id, 'videos');
		
		$cataloguesid = $this->FrontendVideos_Model->_get_where(array(
			'select' => 'cataloguesid',
			'table' => 'catalogues_relationship',
			'where' => array(
				'modulesid' => $id,
				'modules' => 'videos',
			),
		), TRUE);
		
		if(isset($cataloguesid) && is_array($cataloguesid) && count($cataloguesid)){
			$data['videos_same'] = $this->FrontendVideos_Model->_read_condition(array(
				'modules' => 'videos',
				'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`',
				'where' => '`pr`.`trash` = 0 AND `pr`.`id` != '.$id.'',
				'limit' => 7,
				'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
			), $cataloguesid);
		}
		
		
		
		
		$data['meta_title'] = !empty($DetailVideos['meta_title'])?$DetailVideos['meta_title']:$DetailVideos['title'];
		$data['meta_keyword'] = $DetailVideos['meta_keyword'];
		$data['meta_description'] = !empty($DetailVideos['meta_description'])?$DetailVideos['meta_description']:cutnchar(strip_tags($DetailVideos['description']), 255);
		$data['meta_images'] = !empty($DetailVideos['images'])?base_url($DetailVideos['images']):'';
		$data['DetailVideos'] = $DetailVideos;
		$data['DetailCatalogues'] = $DetailCatalogues;
		$data['canonical'] = rewrite_url($DetailVideos['canonical'], $DetailVideos['slug'], $DetailVideos['id'], 'videos', TRUE, TRUE);
		$data['header'] = 'homepage/frontend/common/header_detail';
		$data['template'] = 'videos/frontend/videos/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
}
