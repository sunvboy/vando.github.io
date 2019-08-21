<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trafix extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'customers/BackendCustomers_Model',
			'BackendTrafix_Model',
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'statistics/backend/trafix/view'
		));
		$customersid = (int)$this->input->get('customersid');
		if (!empty($customersid)) {
			$page = (int)$page;
			$config['total_rows'] = $this->BackendTrafix_Model->CountAll();
			
			if($config['total_rows'] > 0){
				$this->load->library('pagination');
				$config['base_url'] = base_url('statistics/backend/trafix/view');
				$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
				$config['first_url'] = $config['base_url'].$config['suffix'];
				$config['per_page'] = 20;
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
				$data['Listcustomers'] = $this->BackendTrafix_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
			}
		}
		$data['template'] = 'statistics/backend/trafix/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
