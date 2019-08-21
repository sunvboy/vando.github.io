<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendUsersGroups_Model'));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/groups/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendUsersGroups_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('users/backend/groups/view');
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
			$data['ListUsers'] = $this->BackendUsersGroups_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'users/backend/groups/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/groups/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Nhóm thành viên', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendUsersGroups_Model->Create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm nhóm thành viên mới thành công');
					redirect('users/backend/groups/view');
				}
			}
		}
		$data['template'] = 'users/backend/groups/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/groups/read'
		));
		$id = (int)$id;
		$data['DetailUsersGroups'] = $this->BackendUsersGroups_Model->ReadByField('id', $id, $this->fcUser);
		if(!isset($data['DetailUsersGroups']) && !is_array($data['DetailUsersGroups']) && count($data['DetailUsersGroups']) == 0){
			$this->session->set_flashdata('message-danger', 'Nhóm thành viên không tồn tại');
			redirect_custom('users/backend/groups/view');
		}
		$data['template'] = 'users/backend/groups/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/groups/update'
		));
		$id = (int)$id;
		$data['DetailUsersGroups'] = $this->BackendUsersGroups_Model->ReadByField('id', $id, $this->fcUser);
		if(!isset($data['DetailUsersGroups']) && !is_array($data['DetailUsersGroups']) && count($data['DetailUsersGroups']) == 0){
			$this->session->set_flashdata('message-danger', 'Nhóm thành viên không tồn tại');
			redirect_custom('users/backend/groups/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Nhóm thành viên', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendUsersGroups_Model->UpdateByPost('id', $id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật nhóm thành viên thành công');
					redirect_custom('users/backend/groups/view');
				}
			}
		}
		$data['template'] = 'users/backend/groups/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/groups/delete'
		));
		$id = (int)$id;
		$data['DetailUsersGroups'] = $this->BackendUsersGroups_Model->ReadByField('id', $id, $this->fcUser);
		if(!isset($data['DetailUsersGroups']) && !is_array($data['DetailUsersGroups']) && count($data['DetailUsersGroups']) == 0){
			$this->session->set_flashdata('message-danger', 'Nhóm thành viên không tồn tại');
			redirect_custom('users/backend/groups/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendUsersGroups_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa nhóm thành viên thành công');
				redirect('users/backend/groups/view');
			}
		}
		$data['template'] = 'users/backend/groups/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
