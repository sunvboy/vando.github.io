<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendLevel_Model',
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/level/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendLevel_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('customers/backend/level/view');
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
			$data['Listcustomers'] = $this->BackendLevel_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'customers/backend/level/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/level/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Cấp độ level', 'trim|required');
			$this->form_validation->set_rules('discounted', 'Giảm giá', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('range_price', 'Giới hạn tăng cấp', 'trim|required');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendLevel_Model->Create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm cấp độ mới thành công');
					redirect('customers/backend/level/view');
				}
			}
		}
		$data['template'] = 'customers/backend/level/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/level/update'
		));
		$id = (int)$id;
		$data['DetailLevel'] = $this->BackendLevel_Model->ReadByField('id', $id);
		if(!isset($data['DetailLevel']) && !is_array($data['DetailLevel']) && count($data['DetailLevel']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('customers/backend/level/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Cấp độ level', 'trim|required');
			$this->form_validation->set_rules('discounted', 'Giảm giá', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('range_price', 'Giới hạn tăng cấp', 'trim|required');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendLevel_Model->UpdateByPost('id', $id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật thành viên thành công');
					redirect_custom('customers/backend/level/view');
				}
			}
		}
		$data['template'] = 'customers/backend/level/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/level/delete'
		));
		$id = (int)$id;
		$data['DetailLevel'] = $this->BackendLevel_Model->ReadByField('id', $id);
		if(!isset($data['DetailLevel']) && !is_array($data['DetailLevel']) && count($data['DetailLevel']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('customers/backend/level/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendLevel_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa thành viên thành công');
				redirect('customers/backend/level/view');
			}
		}
		$data['template'] = 'customers/backend/level/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
