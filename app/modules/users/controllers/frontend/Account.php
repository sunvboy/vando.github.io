<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('login');
		$this->load->model(array('FrontendUsers_Model'));
	}

	public function Information(){
		$data['DetailUsers'] = $this->FrontendUsers_Model->ReadByField('id', $this->fcUser['id']);
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__Information');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim|required');
			if ($this->form_validation->run($this)){
				$flag = $this->FrontendUsers_Model->UpdateByField('email', $data['DetailUsers']['email'], array(
					'email' => $this->input->post('email'),
					'fullname' => $this->input->post('fullname'),
					'address' => $this->input->post('address'),
					'phone' => $this->input->post('phone'),
					'description' => $this->input->post('description'),
					'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				));
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật hồ sơ thành công');
					redirect('information');
				}
			}
		}
		$data['template'] = 'users/frontend/account/information';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}

	public function Password(){
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('newpassword', 'Mật khẩu mới', 'trim|required');
			$this->form_validation->set_rules('renewpassword', 'Xác nhận mật khẩu mới', 'trim|required|matches[newpassword]');			
			if ($this->form_validation->run($this)){
				$salt = random();
				$password = password_encode($this->input->post('newpassword'), $salt);
				$flag = $this->FrontendUsers_Model->UpdateByField('email', $this->fcUser['email'], array(
					'password' => $password,
					'salt' => $salt,
					'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				));
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thay đổi mật khẩu thành công, bạn cần đăng nhập lại');
					redirect('login');
				}
			}
		}
		$data['template'] = 'users/frontend/account/password';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	
	public function orderlist(){
		$userid = $this->fcUser['id'];
		$data['OrderList'] = $this->FrontendUsers_Model->OrderByUsers($userid, TRUE);$data['template'] = 'users/frontend/account/orderlist';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
	
	
	public function _Information(){
		$email = $this->input->post('email');
		$old_email = $this->input->post('old_email');
		if($old_email != $email){
			$user = $this->FrontendUsers_Model->ReadByField('email', $email);
			if(isset($user) && is_array($user) && count($user)){
				$this->form_validation->set_message('_Information', 'Email đã tồn tại');
				return FALSE;
			}
			return TRUE;
		}
		return TRUE;
	}

}
