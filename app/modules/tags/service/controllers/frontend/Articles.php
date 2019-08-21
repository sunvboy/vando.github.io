<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		$this->fcCustomer = $this->config->item('fcCustomer');
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
	}

	public function View($id = 0){
		$id = (int)$id;
		$DetailArticles = $this->FrontendArticles_Model->ReadByField('id', $id, $this->fc_lang);
		if(!isset($DetailArticles) && !is_array($DetailArticles) && count($DetailArticles) == 0){
			$this->session->set_flashdata('message-danger', $this->lang->line('error_articles_detial'));
			redirect(base_url());
		}
		

		$DetailCatalogues = $this->FrontendArticlesCatalogues_Model->ReadByField('id', $DetailArticles['cataloguesid'], $this->fc_lang);

		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', $this->lang->line('error_articles_catalogues'));
			redirect(base_url());
		}

		$idgoc = showcatidgoc($DetailCatalogues['id'], $DetailCatalogues['parentid'], 'articles');
		$Catalog_goc = $this->FrontendArticlesCatalogues_Model->ReadByField('id', $idgoc, $this->fc_lang );
		$Catalog_ar = $this->FrontendArticlesCatalogues_Model->ReadByField('id', $DetailCatalogues['id'], $this->fc_lang, FALSE );
		if($Catalog_goc['rgt'] - $Catalog_goc['lft'] > 1){
			$list_child = $this->FrontendArticlesCatalogues_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, parentid, level',
				'table' => 'articles_catalogues',
				'where' => array('publish' => 1, 'alanguage' => $this->fc_lang, 'trash' => 0,'lft >' => $Catalog_goc['lft'],'rgt <' => $Catalog_goc['rgt']),
				'order_by' => 'order asc, id desc',
			), TRUE);
			$data['list_child'] = recursive($list_child, $idgoc, 'child');
		}
		$data['Catalog_goc'] = $Catalog_goc;
		$data['canonicalcata'] = show_url_level($Catalog_ar, 'articles_catalogues', 2);
		// $data['Cataloguesgoc'] = $this->FrontendArticlesCatalogues_Model->ReadByField('id', $idgoc, $this->fc_lang);
		// if (isset($data['Cataloguesgoc']) && is_array($data['Cataloguesgoc']) && count($data['Cataloguesgoc'])) {
		// 	$data['list'] = $this->FrontendArticlesCatalogues_Model->ReadByFieldRow('id, title, slug, canonical', array('parentid' => $idgoc), $this->fc_lang );
		// }

		$data['articles_cat'] = $this->FrontendArticlesCatalogues_Model->ReadByCondition(array(
            'select' => 'id, title, slug, canonical, description, lft, rgt',
            'where' => array('trash' => 0,'publish' => 1, 'parentid' => 0, 'alanguage' => ''.$this->fc_lang.''),
            'order_by' => 'order asc, id desc',
        ));
        
		$data['Breadcrumb'] = $this->FrontendArticlesCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt'], $this->fc_lang);

		$data['TagsList'] = $this->FrontendTags_Model->ReadByModule($id, 'articles');


		// Lấy ds Slide danh mục
		if (isset($data['Breadcrumb']) && is_array($data['Breadcrumb']) && count($data['Breadcrumb'])) {
			foreach ($data['Breadcrumb'] as $key => $val) {
				if ($val['level'] != 2) continue;
					$att['id'] = $val['id'];
			}
		}
		
		$cataloguesid = $this->FrontendArticles_Model->_get_where(array(
			'select' => 'cataloguesid',
			'table' => 'catalogues_relationship',
			'where' => array(
				'modulesid' => $id,
				'modules' => 'articles',
			),
		), TRUE);
		
		$data['articles_same'] = $this->FrontendArticles_Model->_read_condition(array(
			'modules' => 'articles',
			'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`created`, `pr`.`viewed`',
			'where' => '`pr`.`trash` = 0 AND `pr`.`id` != '.$id.' AND `pr`.`alanguage` = \''.$this->fc_lang.'\' ',
			'limit' => 4,
			'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
		), $cataloguesid);
		
		$data['articles_cauhoi'] = $this->FrontendArticlesCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, images, description, lft, rgt','where' => array('trash' => 0,'publish' => 1, 'id' => 16, 'alanguage' => ''.$this->fc_lang.''),'limit' => 1,'order_by' => 'order asc, id desc'));
		if(isset($data['articles_cauhoi']) && is_array($data['articles_cauhoi']) && count($data['articles_cauhoi'])){
			foreach($data['articles_cauhoi'] as $key => $val){
				$data['articles_cauhoi'][$key]['post'] = $this->FrontendArticles_Model->_read_condition(array(
					'modules' => 'articles',
					'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`content2`, `pr`.`viewed`, `pr`.`created`',
					'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 5,
					'order_by' => '`pr`.`order` asc, `pr`.`id` asc',
					'cataloguesid' => $val['id'],
				));
			}
		}	

		$data['khachhang_'] = $this->FrontendArticlesCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, images, lft, rgt','where' => array('trash' => 0,'publish' => 1, 'id' => 46, 'alanguage' => ''.$this->fc_lang.''),'limit' => 1,'order_by' => 'order asc, id desc'));
		if(isset($data['khachhang_']) && is_array($data['khachhang_']) && count($data['khachhang_'])){
			foreach($data['khachhang_'] as $key => $val){
				$data['khachhang_'][$key]['post'] = $this->FrontendArticles_Model->_read_condition(array(
					'modules' => 'articles',
					'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`cataloguesid`, `pr`.`viewed`, `pr`.`created`',
					'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 15,
					'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
					'cataloguesid' => $val['id'],
				));
			}
		}
		
		
		$data['meta_title'] = !empty($DetailArticles['meta_title'])?$DetailArticles['meta_title']:$DetailArticles['title'];
		$data['meta_keyword'] = $DetailArticles['meta_keyword'];
		$data['meta_description'] = !empty($DetailArticles['meta_description'])?$DetailArticles['meta_description']:cutnchar(strip_tags($DetailArticles['description']), 255);
		$data['meta_images'] = !empty($DetailArticles['images'])?base_url($DetailArticles['images']):'';
		$data['DetailArticles'] = $DetailArticles;
		$data['DetailCatalogues'] = $DetailCatalogues;
		$data['canonical'] = rewrite_url($DetailArticles['canonical'], $DetailArticles['slug'], $DetailArticles['id'], 'articles', TRUE, TRUE);
		$data['canonicalcata'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'articles_catalogues');
		$data['created'] = show_time($DetailArticles['created'], 'd/m/Y');
		$data['view'] = $DetailArticles['viewed'];

		$this->FrontendArticles_Model->UpdateViewed('id', $DetailArticles['id'], $this->fc_lang);

		$data['header'] = 'homepage/frontend/common/header_detail';
		if ($DetailCatalogues['isfooter'] == 10 && $Catalog_goc['isfooter'] == 9) {
			$data['template'] = 'articles/frontend/articles/view2';
		}else{
			$data['template'] = 'articles/frontend/articles/view';
		}
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
}
