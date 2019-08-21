<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		$this->load->library(array('configbie'));
		$this->load->model('FrontendSaleDG_Model');
		/* -------------------------- */
	}

	public function View($id = 0, $page = 1){
		$id = (int)$id;
		$page = (int)$page;
		$seoPage = '';

		$DetailCatalogues = $this->FrontendProductsCatalogues_Model->ReadByField('id', $id, $this->fc_lang );
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger',  $this->lang->line('error_products_catalogues'));
			redirect(base_url());
		}

		$data['Breadcrumb'] = $this->FrontendProductsCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt'], $this->fc_lang);
		$data['idgoc'] = showcatidgoc($DetailCatalogues['id'], $DetailCatalogues['parentid'], 'products');
		$data['DetailCatalogues_goc'] = $this->FrontendProductsCatalogues_Model->ReadByField('id', $data['idgoc'], $this->fc_lang);
		
		// $data['parentid_cat'] =  $this->FrontendProductsCatalogues_Model->ReadAllByField('parentid', $DetailCatalogues['id'], $this->fc_lang );

		// $data['products_cat'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
	    //           'select' => 'id, title, slug, canonical, description, lft, rgt, parentid',
	    //           'where' => array('trash' => 0,'publish' => 1, 'alanguage' => ''.$this->fc_lang.''),
	    //           'order_by' => 'order asc, id desc',
    	//       ));

		// $data['maxprice'] = $this->FrontendProducts_Model->_vieworder(array(
		// 	'select' => 'MIN(`pr`.`saleoff`) as max',
		// 	'modules' => 'products',
		// 	'start' => 0,
		// 	'limit' => 1,
		// ), $DetailCatalogues);


		$config['total_rows'] = $this->FrontendProducts_Model->_count(array(
			'select' => '`pr`.`id`',
			'modules' => 'products',
		), $DetailCatalogues, $this->fc_lang);

		$config['base_url'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'products_catalogues', FALSE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 24;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="phantrang text-center"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
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
			if($this->input->get('price')=='asc'){
				$order_by = '`pr`.`saleoff` asc';
			}else if($this->input->get('price')=='desc'){
				$order_by = '`pr`.`saleoff` desc';

			}else{
				$order_by = '`pr`.`order` asc ,`pr`.`id` desc';

			}
			$page = $page - 1;
			$data['productsList'] = $this->FrontendProducts_Model->_view(array(
				'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`, `pr`.`highlight`, `pr`.`albums`, `pr`.`psale`, `pr`.`active_phamtramgiamgia`, `pr`.`tmp_active_phamtramgiamgia`',
				'modules' => 'products',
				'order_by' => $order_by,
				'start' => ($page * $config['per_page']),
				'limit' => $config['per_page'],
			), $DetailCatalogues, $this->fc_lang);
			if(!isset($data['canonical']) || empty($data['canonical'])){
				$data['canonical'] = $config['base_url'].$this->config->item('url_suffix');
			}
		}

		$data['module'] = 'products_catalogues';
		$data['moduleid'] = $DetailCatalogues['id'];

		$data['link'] = 'products.html';
		$data['meta_title'] = (!empty($DetailCatalogues['meta_title'])?$DetailCatalogues['meta_title']:$DetailCatalogues['title']).$seoPage;
		$data['meta_keyword'] = $DetailCatalogues['meta_keyword'];
		$data['meta_description'] = (!empty($DetailCatalogues['meta_description'])?$DetailCatalogues['meta_description']:cutnchar(strip_tags($DetailCatalogues['description']), 255)).$seoPage;
		$data['meta_images'] = !empty($DetailCatalogues['images'])?base_url($DetailCatalogues['images']):'';
		$data['canonical'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'products', TRUE, TRUE);
		$data['DetailCatalogues'] = $DetailCatalogues;
		// if (($DetailCatalogues['rgt'] - $DetailCatalogues['lft']) > 1) {
		// 	$data['list_cat'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
		// 		'select' => 'id, title, description, images, slug, canonical, parentid',
		// 		'where' => array('trash' => 0, 'publish' => 1, 'parentid' => $DetailCatalogues['id'], 'alanguage' => ''.$this->fc_lang.''), 
		// 		'order_by' => 'order asc, id desc'
		// 	));

		// 	$data['tintuc_home'] = $this->FrontendArticlesCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, images, lft, rgt','where' => array('trash' => 0,'publish' => 1, 'isaside' => 1, 'alanguage' => ''.$this->fc_lang.''),'limit' => 1,'order_by' => 'order asc, id desc'));
		// 	if(isset($data['tintuc_home']) && is_array($data['tintuc_home']) && count($data['tintuc_home'])){
		// 		foreach($data['tintuc_home'] as $key => $val){
		// 			$data['tintuc_home'][$key]['post'] = $this->FrontendArticles_Model->_read_condition(array(
		// 				'modules' => 'articles',
		// 				'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`cataloguesid`, `pr`.`viewed`, `pr`.`created`',
		// 				'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
		// 				'limit' => 3,
		// 				'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
		// 				'cataloguesid' => $val['id'],
		// 			));
		// 		}
		// 	}
		// 	$data['template'] = 'products/frontend/catalogues/view2';
		// }else{
			$data['template'] = 'products/frontend/catalogues/view';
		// }
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}
