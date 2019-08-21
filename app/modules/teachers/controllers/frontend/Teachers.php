<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends FC_Controller{

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

	public function View($id = 0, $page = 1){
		$id = (int)$id;
		$page = (int)$page;
		
		$DetailTeachers = $this->FrontendTeachers_Model->ReadByField('id', $id);
		if(!isset($$DetailTeachers['id']) && !is_array($DetailTeachers) && count($DetailTeachers) == 0){
			$this->session->set_flashdata('message-danger', 'Giảng viên không tồn tại');
			redirect(base_url());
		}

		$config['total_rows'] = $this->FrontendTeachers_Model->Count($this->fc_lang, $DetailTeachers['id']);
		// echo $this->db->last_query();die;
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = rewrite_url($DetailTeachers['canonical'], $DetailTeachers['slug'], $DetailTeachers['id'], 'teachers', FALSE, TRUE);
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
			$config['full_tag_close'] = '</ul>';
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
			$data['ListPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['Listproducts'] = $this->FrontendTeachers_Model->All(($page * $config['per_page']), $config['per_page'], $this->fc_lang, $DetailTeachers['id']);	
		}
		
		
		$data['meta_title'] = $DetailTeachers['title'];
		$data['DetailTeachers'] = $DetailTeachers;
		$data['canonical'] = rewrite_url($DetailTeachers['canonical'], $DetailTeachers['slug'], $DetailTeachers['id'], 'teachers', TRUE, TRUE);
		$data['template'] = 'teachers/frontend/teachers/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
}
