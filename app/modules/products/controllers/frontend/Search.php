<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
		$this->load->model('FrontendSaleDG_Model');
	}

	public function View($page = 1){

		$page = (int)$page;
		$seoPage = '';
		if( $this->input->get('key') ){
			$data['keys'] = $this->input->get('key');
		}
		$categories = (int)$this->input->get('categories');
		if(!empty($categories) && $categories != 0){
			$DetailCatalogues = $this->FrontendProductsCatalogues_Model->ReadByField('id', $categories, $this->fc_lang );
		}else{
			$DetailCatalogues = '';
		}

		$config['total_rows'] = $this->FrontendProductsCatalogues_Model->Countsearch(array(
			'select' => '`pr`.`id`',
		), $DetailCatalogues, $this->fc_lang);

		// echo $this->db->last_query();die;

		$config['base_url'] = rewrite_url('tim-kiem', '','', '', FALSE, TRUE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 12;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="list-next-tab-bottom mb20"><ul class="mt-flex mt-flex-middle">';
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
			$data['result'] = $this->FrontendProductsCatalogues_Model->search(array(
				'select' => '`pr`.`tmp_active_phamtramgiamgia`,`pr`.`active_phamtramgiamgia`,`pr`.`albums`,`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`, `pr`.`highlight`, `pr`.`psale`',
				'order_by' => '`pr`.`order` asc ,`pr`.`id` desc',
				'start' => ($page * $config['per_page']),
				'limit' => $config['per_page'],
			), $DetailCatalogues, $this->fc_lang );
		}
		
		$data['DetailCatalogues'] = $DetailCatalogues;
		$data['meta_title'] = 'Tìm kiếm '.$this->input->post('key');
		$data['meta_keywords'] = $this->input->post('key');
		$data['meta_description'] = $this->input->post('key');
		$data['total_rows'] = $config['total_rows'];

		$data['template'] = 'products/frontend/search/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}
