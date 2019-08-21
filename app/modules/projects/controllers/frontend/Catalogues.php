<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		$this->fcCustomer = $this->config->item('fcCustomer');
		$this->fc_lang = $this->config->item('fc_lang');
		$this->load->library(array('configbie'));
		/* -------------------------- */
	}

	public function View($id = 0, $page = 1){
		$id = (int)$id;
		$page = (int)$page;
		$seoPage = '';
		$DetailCatalogues = $this->FrontendProjectsCatalogues_Model->ReadByField('id', $id);
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục sản phẩm không tồn tại');
			redirect(base_url());
		}
		$data['Breadcrumb'] = $this->FrontendProjectsCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt']);

		
		$config['total_rows'] = $this->FrontendProjects_Model->_count(array(
			'select' => '`pr`.`id`',
			'modules' => 'projects',
		), $DetailCatalogues, $this->fc_lang);
		
		
		
		if($DetailCatalogues['rgt'] - $DetailCatalogues['lft'] > 1){
			$data['child'] = $this->Autoload_Model->_get_where(array(
				'select' => 'id, title, slug, canonical',
				'table' => 'projects_catalogues',
				'where' => array(
					'publish' => 1,
					'trash' => 0,
					'parentid' => $DetailCatalogues['id']
				),
				'limit' => 100,
				'order_by' => 'order desc, id desc'
			), TRUE);
			if(isset($data['child']) && is_array($data['child']) && count($data['child'])){
				foreach($data['child'] as $keyChild => $valChild){
					$data['child'][$keyChild]['post'] = $this->FrontendProjects_Model->_read_condition(array(
						'modules' => 'projects',
						'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`price`',
						'where' => '`pr`.`trash` = 0',
						'limit' => 100,
						'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
						'cataloguesid' => $valChild['id']
					));
				}
			}
		}
		
	
		$config['base_url'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'projects_catalogues', FALSE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 20;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination" itemscope itemtype="http://schema.org/SiteNavigationElement/Pagination"><ul class="uk-pagination uk-pagination-left">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="uk-active"><a itemprop="relatedLink/pagination">';
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
			$data['projectsList'] = $this->FrontendProjects_Model->_view(array(
				'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`content`, `pr`.`price`, `pr`.`created`, `pr`.`measure`, `pr`.`cataloguesid`, `pr`.`area`, `pr`.`projectid`, `pr`.`wardid`, `pr`.`districtid`, `pr`.`isaside`',
				'modules' => 'projects',
				'order_by' => '`pr`.`isaside` desc, `pr`.`order` asc, `pr`.`id` desc ',
				'start' => ($page * $config['per_page']),
				'limit' => $config['per_page'],
			), $DetailCatalogues);
		}
		if(isset($data['projectsList']) && is_array($data['projectsList']) && count($data['projectsList'])){
			foreach($data['projectsList'] as $key => $val){
				$data['projectsList'][$key]['attribute'] =  $this->FrontendProducts_Model->AttributesAllTheTime($val['id']);
			}
		}
		$data['prd_arr'] = isset($_COOKIE['fc_prd'])?json_decode($_COOKIE['fc_prd']):NULL;
		$data['meta_title'] = (!empty($DetailCatalogues['meta_title'])?$DetailCatalogues['meta_title']:$DetailCatalogues['title']).$seoPage;
		$data['meta_keyword'] = $DetailCatalogues['meta_keyword'];
		$data['meta_description'] = (!empty($DetailCatalogues['meta_description'])?$DetailCatalogues['meta_description']:cutnchar(strip_tags($DetailCatalogues['description']), 255)).$seoPage;
		$data['meta_images'] = !empty($DetailCatalogues['images'])?base_url($DetailCatalogues['images']):'';
		$data['DetailCatalogues'] = $DetailCatalogues;
		if(!isset($data['canonical']) || empty($data['canonical'])){
			$data['canonical'] = $config['base_url'].$this->config->item('url_suffix');
		}
		$data['template'] = 'projects/frontend/catalogues/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}
