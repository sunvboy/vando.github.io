<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendUsers_Model'));
	}

	public function Information(){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/account/information'
		));
		$data['DetailUsers'] = $this->BackendUsers_Model->ReadByField('users.id', $this->fcUser['id']);
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__Information');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendUsers_Model->UpdateByField('email', $data['DetailUsers']['email'], array(
					'email' => $this->input->post('email'),
					'fullname' => $this->input->post('fullname'),
					'description' => $this->input->post('description'),
					'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				));
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật hồ sơ thành công');
					redirect('users/backend/account/information');
				}
			}
		}
		$data['template'] = 'users/backend/account/information';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Password(){
		$this->commonbie->Permissions(array(
			'uri' => 'users/backend/account/password'
		));
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('newpassword', 'Mật khẩu mới', 'trim|required');
			$this->form_validation->set_rules('renewpassword', 'Xác nhận mật khẩu mới', 'trim|required|matches[newpassword]');			
			if ($this->form_validation->run($this)){
				$salt = random();
				$password = password_encode($this->input->post('newpassword'), $salt);
				$flag = $this->BackendUsers_Model->UpdateByField('email', $this->fcUser['email'], array(
					'password' => $password,
					'salt' => $salt,
					'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				));
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thay đổi mật khẩu thành công, bạn cần đăng nhập lại');
					redirect('admin/login');
				}
			}
		}
		$data['template'] = 'users/backend/account/password';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function _Information(){
		$email = $this->input->post('email');
		$old_email = $this->input->post('old_email');
		if($old_email != $email){
			$user = $this->BackendUsers_Model->ReadByField('users.email', $email);
			if(isset($user) && is_array($user) && count($user)){
				$this->form_validation->set_message('_Information', 'Email đã tồn tại');
				return FALSE;
			}
			return TRUE;
		}
		return TRUE;
	}

}
