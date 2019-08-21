<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		$this->load->model(array('slides/FrontendSlides_Model', 'address/Frontendaddress_Model'));
		$this->load->library(array('projects/configbie'));
		$this->fcCustomer = $this->config->item('fcCustomer');

	}

	public function Index($page = 1){
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */

		$data['products'] = $this->FrontendProducts_Model->ReadByCondition(array(
			'select' => 'id, title, slug, canonical, images, description, created',
			'table' => 'products',
			'where' => array('publish' => 1, 'trash' => 0, 'highlight' => 1, 'alanguage' => $this->fc_lang),
			'limit' => 4,
			'order_by' => 'id desc',
		));

		$data['abouts'] = $this->FrontendArticles_Model->ReadByCondition(array(
			'select' => 'id, title, slug, canonical, images, description, content',
			'table' => 'articles',
			'where' => array('publish' => 1, 'trash' => 0, 'cataloguesid'=> 14, 'alanguage' => $this->fc_lang),
			'limit' => 1,
			'order_by' => 'id desc',
		));


		$data['danhmuchome'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, albums, attributes, lft, rgt','where' => array('trash' => 0,'publish' => 1, 'ishome' => 1, 'parentid' => 0, 'alanguage' => ''.$this->fc_lang.''), 'limit' => 10,'order_by' => 'order asc, id desc'));
		if(isset($data['danhmuchome']) && is_array($data['danhmuchome']) && count($data['danhmuchome'])){
			foreach($data['danhmuchome'] as $key => $val){
				$data['danhmuchome'][$key]['post'] = $this->FrontendProducts_Model->_read_condition(array(
					'modules' => 'products',
					'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`',
					'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1 AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 5,
					'order_by' => '`pr`.`order` asc, `pr`.`id` asc',
					'cataloguesid' => $val['id'],
				));
				$data['danhmuchome'][$key]['parent'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
					'select' => 'id, title, slug, canonical, description, lft, rgt',
					'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''), 
					'limit' => 10,
					'order_by' => 'order asc, id desc'
				));
			}
		}


		$data['features'] = $this->FrontendArticlesCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, images, lft, rgt','where' => array('trash' => 0,'publish' => 1, 'id' => 16, 'alanguage' => ''.$this->fc_lang.''),'limit' => 1,'order_by' => 'order asc, id desc'));
		if(isset($data['features']) && is_array($data['features']) && count($data['features'])){
			foreach($data['features'] as $key => $val){
				$data['features'][$key]['post'] = $this->FrontendArticles_Model->_read_condition(array(
					'modules' => 'articles',
					'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`viewed`, `pr`.`created`',
					'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1 AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 2,
					'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
					'cataloguesid' => $val['id'],
				));
			}
		}

		// $data['tintuc'] = $this->FrontendArticlesCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, images, lft, rgt','where' => array('trash' => 0,'publish' => 1, 'id' => 17, 'alanguage' => ''.$this->fc_lang.''),'limit' => 1,'order_by' => 'order asc, id desc'));
		// if(isset($data['tintuc']) && is_array($data['tintuc']) && count($data['tintuc'])){
		// 	foreach($data['tintuc'] as $key => $val){
		// 		$data['tintuc'][$key]['post'] = $this->FrontendArticles_Model->_read_condition(array(
		// 			'modules' => 'articles',
		// 			'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`viewed`, `pr`.`created`',
		// 			'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
		// 			'limit' => 10,
		// 			'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
		// 			'cataloguesid' => $val['id'],
		// 		));
		// 	}
		// }	
		
		$data['home'] = 'home';
		
		$data['active'] = 1;
		$data['meta_title'] = $this->fcSystem['seo_meta_title'];
		$data['meta_keywords'] = $this->fcSystem['seo_meta_keywords'];
		$data['meta_description'] = $this->fcSystem['seo_meta_description'];
		$data['template'] = 'homepage/frontend/home/index';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}

	
	public function Sitemap($type = 'html'){
		$data['ArticlesNews'] = $this->FrontendArticles_Model->ReadAllForSitemap(0, 0, 100);
		$data['ArticlesCatalogues'] = $this->FrontendArticlesCatalogues_Model->ReadAllForSitemap();
		$this->load->view('homepage/frontend/home/sitemap_'.$type, isset($data)?$data:NULL);
	}
	public function email(){
		$data['email'] = $this->input->post('email');
		$data['message'] = 'Đăng ký nhận phiếu giảm giá'; 
		if(isset($data) && is_array($data) && count($data)){
			$this->db->insert('contacts', $data);
			$result = $this->db->affected_rows();
			$this->db->flush_cache();
		}
		if($result > 0){
			echo 'Gửi đăng kí thành công, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất';die();
		}
	}
	
	public function chungchi($page = 1){
		$page = (int)$page;
		$data['meta_title'] = 'Chỉ chỉ';
		$data['meta_keywords'] = '';
		$data['meta_description'] = '';

		$config['total_rows'] = $this->FrontendLichhoc_Model->count();
		$config['base_url'] = rewrite_url('chung-chi', '','', '', FALSE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 16;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination mb30"><ul class="uk-pagination uk-pagination-right">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="uk-active"><a>';
			$config['cur_tag_close'] = '</a></li>';
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
			$data['Listchungchi'] = $this->FrontendLichhoc_Model->AllFeild(($page * $config['per_page']), $config['per_page']);
		}
		if(!isset($data['canonical']) || empty($data['canonical'])){
			$data['canonical'] = $config['base_url'].$this->config->item('url_suffix');
		}
		$data['template'] = 'homepage/frontend/home/chungchi';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}

	
}
