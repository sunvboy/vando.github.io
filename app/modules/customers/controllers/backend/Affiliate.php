<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliate extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendCustomers_Model',
			'BackendAffiliate_Model',
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/affiliate/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendAffiliate_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('customers/backend/affiliate/view');
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
			$data['Listcustomers'] = $this->BackendAffiliate_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'customers/backend/affiliate/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/affiliate/delete'
		));
		$id = (int)$id;
		$data['DetailAffiliate'] = $this->BackendAffiliate_Model->ReadByField('id', $id);
		if(!isset($data['DetailAffiliate']) && !is_array($data['DetailAffiliate']) && count($data['DetailAffiliate']) == 0){
			$this->session->set_flashdata('message-danger', 'Lịch sử nhận hoa hồng không tồn tại');
			redirect_custom('customers/backend/affiliate/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendAffiliate_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa lịch sử nhận hoa hồng thành công');
				redirect('customers/backend/affiliate/view');
			}
		}
		$data['template'] = 'customers/backend/affiliate/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
