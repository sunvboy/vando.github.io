<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function View($id = 0, $page = 1){
		$id = (int)$id;
		$page = (int)$page;
		$seoPage = '';
		$DetailCatalogues = $this->FrontendArticlesCatalogues_Model->ReadByField('id', $id);
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục bài viết không tồn tại');
			redirect(base_url());
		}
		$data['Breadcrumb'] = $this->FrontendArticlesCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt']);
		$config['total_rows'] = $this->FrontendArticles_Model->CountAll($id, $DetailCatalogues['lft'], $DetailCatalogues['rgt']);
		$config['base_url'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'articles_catalogues', FALSE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 12;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="fc-pagination uk-text-center margin-top-25px"><ul class="uk-pagination uk-display-inline-block uk-margin-remove">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="uk-active"><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['PaginationList'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$seoPage = ($page >= 2)?(' - Trang '.$page):'';
			if($page >= 2){
				$data['canonical'] = $config['base_url'].'/trang-'.$page.$this->config->item('url_suffix');
			}
			$page = $page - 1;
			$data['ArticlesList'] = $this->FrontendArticles_Model->ReadAll(array('cataloguesid' => $id, 'lft' => $DetailCatalogues['lft'], 'rgt' => $DetailCatalogues['rgt'], 'start' => ($page * $config['per_page']), 'limit' => $config['per_page']));	
		}
		if($DetailCatalogues['level'] == 1 && $DetailCatalogues['rgt'] - $DetailCatalogues['lft'] == 1){
			$data['ArticlesNew'] = $this->FrontendArticles_Model->ReadAll(array('limit' => 5, 'order' => 'articles.created DESC'));
			$data['ArticlesViewed'] = $this->FrontendArticles_Model->ReadAll(array('limit' => 5, 'order' => 'articles.viewed DESC'));
		}
		else{
			$data['ArticlesCataloguesAside'] = $this->FrontendArticlesCatalogues_Model->ReadAllByAutoSub($DetailCatalogues);
			if(isset($data['ArticlesCataloguesAside']) && is_array($data['ArticlesCataloguesAside']) && count($data['ArticlesCataloguesAside'])){
				foreach($data['ArticlesCataloguesAside'] as $key => $val){
					$data['ArticlesCataloguesAside'][$key]['articles'] = $this->FrontendArticles_Model->ReadAll(array('cataloguesid' => $val['id'], 'lft' => $val['lft'], 'rgt' => $val['rgt'], 'limit' => 5));
				}
			}
		}
		$data['ArticlesCataloguesRand'] = $this->FrontendArticles_Model->ReadAll(array('cataloguesid' => $id, 'lft' => $DetailCatalogues['lft'], 'rgt' => $DetailCatalogues['rgt'], 'limit' => 3, 'order' => 'RAND()'));
		$data['ArticlesCataloguesViewed'] = $this->FrontendArticles_Model->ReadAll(array('cataloguesid' => $id, 'lft' => $DetailCatalogues['lft'], 'rgt' => $DetailCatalogues['rgt'], 'limit' => 3, 'order' => 'articles.viewed DESC'));
		$data['ArticlesCataloguesHighlight'] = $this->FrontendArticles_Model->ReadAll(array('cataloguesid' => $id, 'lft' => $DetailCatalogues['lft'], 'rgt' => $DetailCatalogues['rgt'], 'where' => array('highlight' => 1), 'limit' => 3, 'order' => 'articles.created DESC'));
		$data['meta_title'] = (!empty($DetailCatalogues['meta_title'])?$DetailCatalogues['meta_title']:$DetailCatalogues['title']).$seoPage;
		$data['meta_keyword'] = $DetailCatalogues['meta_keyword'];
		$data['meta_description'] = (!empty($DetailCatalogues['meta_description'])?$DetailCatalogues['meta_description']:cutnchar(strip_tags($DetailCatalogues['description']), 255)).$seoPage;
		$data['meta_images'] = !empty($DetailCatalogues['images'])?base_url($DetailCatalogues['images']):'';
		$data['DetailCatalogues'] = $DetailCatalogues;
		if(!isset($data['canonical']) || empty($data['canonical'])){
			$data['canonical'] = $config['base_url'].$this->config->item('url_suffix');
		}
		$data['template'] = 'articles/frontend/catalogues/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}
