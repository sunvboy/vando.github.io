<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallerys extends FC_Controller{

	public function __construct(){
		parent::__construct();
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		$this->fc_lang = $this->config->item('fc_lang');
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
	}

	public function View($id = 0){
		$id = (int)$id;
		$DetailGallerys = $this->FrontendGallerys_Model->ReadByField('id', $id, $this->fc_lang);
		if(!isset($DetailGallerys) && !is_array($DetailGallerys) && count($DetailGallerys) == 0){
			$this->session->set_flashdata('message-danger', 'hình ảnh không tồn tại');
			redirect(base_url());
		}
		$DetailCatalogues = $this->FrontendGallerysCatalogues_Model->ReadByField('id', $DetailGallerys['cataloguesid'], $this->fc_lang);
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục hình ảnh không tồn tại');
			redirect(base_url());
		}
		$data['Breadcrumb'] = $this->FrontendGallerysCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt']);
		$data['TagsList'] = $this->FrontendTags_Model->ReadByModule($id, 'gallerys');

		$data['idgoc'] = showcatidgoc($DetailCatalogues['id'], $DetailCatalogues['parentid'], 'gallerys');
		$data['parentid_cat'] = $this->FrontendGallerysCatalogues_Model->ReadAllByField('parentid', $data['idgoc'], $this->fc_lang);
		
		$cataloguesid = $this->FrontendGallerys_Model->_get_where(array(
			'select' => 'cataloguesid',
			'table' => 'catalogues_relationship',
			'where' => array(
				'modulesid' => $id,
				'modules' => 'gallerys',
			),
		), TRUE);
		
		$this->FrontendGallerys_Model->UpdateViewed('id', $DetailGallerys['id']);
		
		$data['gallerys_same'] = $this->FrontendGallerys_Model->_read_condition(array(
			'modules' => 'gallerys',
			'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`',
			'where' => '`pr`.`trash` = 0 AND `pr`.`id` != '.$id.' AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
			'limit' => 6,
			'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
		), $cataloguesid);
		
		
		$data['danhmuchome'] = $this->FrontendGallerys_Model->_read_condition(array(
			'modules' => 'gallerys',
			'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`created`, `pr`.`description`',
			'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1 AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
			'limit' => 10,
			'order_by' => '`pr`.`id` asc',
			'cataloguesid' => $DetailCatalogues['id'],
		));

		$data['tagall'] = $this->FrontendTags_Model->ReadByModules();
		
		$data['meta_title'] = !empty($DetailGallerys['meta_title'])?$DetailGallerys['meta_title']:$DetailGallerys['title'];
		$data['meta_keyword'] = $DetailGallerys['meta_keyword'];
		$data['meta_description'] = !empty($DetailGallerys['meta_description'])?$DetailGallerys['meta_description']:cutnchar(strip_tags($DetailGallerys['description']), 255);
		$data['meta_images'] = !empty($DetailGallerys['images'])?base_url($DetailGallerys['images']):'';
		$data['DetailGallerys'] = $DetailGallerys;
		$data['DetailCatalogues'] = $DetailCatalogues;
		$data['canonical'] = rewrite_url($DetailGallerys['canonical'], $DetailGallerys['slug'], $DetailGallerys['id'], 'gallerys', TRUE, TRUE);
		$data['template'] = 'gallerys/frontend/gallerys/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
}
