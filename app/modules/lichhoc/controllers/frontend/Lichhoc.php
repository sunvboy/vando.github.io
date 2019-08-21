<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lichhoc extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
	}

	public function View($id = 0){
		$id = (int)$id;
		$DetailArticles = $this->FrontendLichhoc_Model->ReadByField('id', $id, $this->fc_lang);

		if(!isset($DetailArticles) && !is_array($DetailArticles) && count($DetailArticles) == 0){
			$this->session->set_flashdata('message-danger', $this->lang->line('error_articles_detial'));
			redirect(base_url());
		}
		

		$DetailCatalogues = $this->FrontendLichhocCatalogues_Model->ReadByField('id', $DetailArticles['cataloguesid'], $this->fc_lang);

		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', $this->lang->line('error_articles_catalogues'));
			redirect(base_url());
		}

		
		$data['meta_title'] = $DetailArticles['title'];
		$data['meta_keyword'] = '';
		$data['meta_description'] = '';

		$data['DetailArticles'] = $DetailArticles;
		$data['DetailCatalogues'] = $DetailCatalogues;
		$data['canonical'] = rewrite_url($DetailArticles['canonical'], $DetailArticles['slug'], $DetailArticles['id'], 'lichhoc_time', TRUE, TRUE);

		$data['template'] = 'lichhoc/frontend/lichhoc/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
}
