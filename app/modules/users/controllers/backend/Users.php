<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendUsers_Model',
			'BackendUsersGroups_Model'
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/users/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendUsers_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('users/backend/users/view');
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
			$data['ListUsers'] = $this->BackendUsers_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'users/backend/users/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/users/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim');
			$this->form_validation->set_rules('groupsid', 'Nhóm thành viên', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendUsers_Model->Create($this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm thành viên mới thành công');
					redirect('users/backend/users/view');
				}
			}
		}
		$data['template'] = 'users/backend/users/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/users/read'
		));
		$id = (int)$id;
		$data['DetailUsers'] = $this->BackendUsers_Model->ReadByField('users.id', $id, $this->fcUser);
		if(!isset($data['DetailUsers']) && !is_array($data['DetailUsers']) && count($data['DetailUsers']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('users/backend/users/view');
		}
		$data['template'] = 'users/backend/users/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/users/update'
		));
		$id = (int)$id;
		$data['DetailUsers'] = $this->BackendUsers_Model->ReadByField('users.id', $id, $this->fcUser);
		if(!isset($data['DetailUsers']) && !is_array($data['DetailUsers']) && count($data['DetailUsers']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('users/backend/users/view');
		}
		if($this->input->post('update')){
			$password = $this->input->post('password');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim');
			$this->form_validation->set_rules('groupsid', 'Nhóm thành viên', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run($this)){
				if (isset($password) && !empty($password)) {
					if(in_array('users/backend/users/limit', $this->fcUser['group']) == TRUE){
						$salt = random();
						$password = password_encode($password, $salt);
						$flag = $this->BackendUsers_Model->UpdateByField('id', $id, array(
							'password' => $password,
							'salt' => $salt,
						));
					}
				}
				$flag = $this->BackendUsers_Model->UpdateByPost('id', $id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật thành viên thành công');
					redirect_custom('users/backend/users/view');
				}
			}
		}
		$data['template'] = 'users/backend/users/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/users/delete'
		));
		$id = (int)$id;
		$data['DetailUsers'] = $this->BackendUsers_Model->ReadByField('users.id', $id, $this->fcUser);
		if(!isset($data['DetailUsers']) && !is_array($data['DetailUsers']) && count($data['DetailUsers']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('users/backend/users/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendUsers_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa thành viên thành công');
				redirect('users/backend/users/view');
			}
		}
		$data['template'] = 'users/backend/users/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
