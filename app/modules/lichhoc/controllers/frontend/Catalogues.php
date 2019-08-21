<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
	}

	public function View($page = 1){
		$page = (int)$page;

		$config['total_rows'] = $this->FrontendLichhocCatalogues_Model->Count($this->fc_lang);

		
		$config['base_url'] = rewrite_url('lich-hoc', '','', '', FALSE, TRUE);

		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 7;
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
			$data['ArticlesList'] = $this->FrontendLichhocCatalogues_Model->AllFeild(($page * $config['per_page']), $config['per_page'], $this->fc_lang);
			if(isset($data['ArticlesList']) && is_array($data['ArticlesList']) && count($data['ArticlesList'])){
				foreach($data['ArticlesList'] as $key => $val){
					$data['ArticlesList'][$key]['post'] = $this->FrontendLichhocCatalogues_Model->ReadByFieldArr(array('cataloguesid ' => $val['id']), $this->fc_lang);
				}
			}
			
		}

		if(!isset($data['canonical']) || empty($data['canonical'])){
			$data['canonical'] = $config['base_url'].$this->config->item('url_suffix');
		}
		
		$data['meta_title'] = 'Lịch học';
		$data['meta_keyword'] = '';
		$data['meta_description'] = '';
		
		$data['template'] = 'lichhoc/frontend/catalogues/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}
