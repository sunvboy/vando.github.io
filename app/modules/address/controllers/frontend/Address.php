<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends FC_Controller{

	public function __construct(){
		parent::__construct();
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		$this->fc_lang = $this->config->item('fc_lang');
		$this->fcCustomer = $this->config->item('fcCustomer');
		/* -------------------------- */
	}
	public function Index($page = 0){
		$page = (int)$page;

		$config['total_rows'] = $this->Frontendaddress_Model->Count($this->fc_lang);
		$config['base_url'] = rewrite_url('documents', '', '', '', FALSE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['uri_segment'] = 1;
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
			$data['AddressList'] = $this->Frontendaddress_Model->Viewall($page * $config['per_page'], $config['per_page'], $this->fc_lang);
		}
		$data['link'] = 'documents.html';
		$data['meta_title'] = 'Documents';
		$data['canonical'] = 'documents.html';
		$data['template'] = 'address/frontend/address/index';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}

	public function View($id = 0){
		$id = (int)$id;
		$DetailAddress = $this->Frontendaddress_Model->ReadByField('id', $id, $this->fc_lang);
		if(!isset($DetailAddress) && !is_array($DetailAddress) && count($DetailAddress) == 0){
			$this->session->set_flashdata('message-danger', 'Bản ghi không tồn tại');
			redirect(base_url());
		}
		
		
		$data['meta_title'] = !empty($DetailAddress['meta_title'])?$DetailAddress['meta_title']:$DetailAddress['title'];
		$data['DetailAddress'] = $DetailAddress;
		$data['canonical'] = rewrite_url($DetailAddress['canonical'], $DetailAddress['slug'], $DetailAddress['id'], 'address', TRUE, TRUE);
		$data['link'] = 'documents.html';
		$data['template'] = 'address/frontend/address/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
}
