<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Advancedsearch extends FC_Controller{

	public function __construct(){
		parent::__construct();
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
	}

	public function View($page = 1){

		$page = (int)$page;
		$seoPage = '';
		if( $this->input->get('key') ){
			$data['keys'] = $this->input->get('key');
			// $data['result'] = $this->FrontendProductsCatalogues_Model->search();
		}

		$config['total_rows'] = $this->FrontendProductsCatalogues_Model->countsearch();
		// echo $config['total_rows'];
		
		$config['base_url'] = rewrite_url('tim-kiem-nang-cao', '','', '', FALSE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 24;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination"><ul class="uk-pagination uk-pagination-left">';
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
			$data['result'] = $this->FrontendProductsCatalogues_Model->search( ($page * $config['per_page']), $config['per_page']);
		}
		
		
		$data['meta_title'] = 'Tim kiếm nâng cao'.$this->input->post('key');
		$data['meta_keywords'] = $this->input->post('key');
		$data['meta_description'] = $this->input->post('key');
		$data['total_rows'] = $config['total_rows'];

		$data['template'] = 'products/frontend/advancedsearch/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}
