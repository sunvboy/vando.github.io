<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendUsers_Model',
			'BackendUsersGroups_Model'
		));
	}

	public function Login(){
		$this->fcUser = $this->config->item('fcUser');
		if($this->fcUser) redirect('admin');
		if($this->input->post('login')){
			$lang = $this->input->post('lang');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|callback__AuthLogin');
			if($this->form_validation->run($this)){
				$user = $this->BackendUsers_Model->ReadByField('email', $this->input->post('email'));
				$upload_permission = json_decode($user['group'], TRUE);
				$temp_permission = '';
				if(isset($upload_permission) && is_array($upload_permission) && count($upload_permission)){
					foreach($upload_permission as $key => $val){
						$explode = explode('/', $val);
						if($explode[2] == 'files' || $explode[2] == 'dirs'){
							$temp_permission[] = $val;
						}
					}
				}
			
				$flag = $this->BackendUsers_Model->UpdateByField('email', $user['email'], array(
					'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
					'remote_addr' => $_SERVER['REMOTE_ADDR']
				));
				
				if($flag > 0){
					$remember = 1;
					if($remember == 1){
						setcookie(CODE.'auth', json_encode(array(
							'id' => $user['id'],
							'email' => $user['email'],
							'password' => $user['password'],
							'permission' => $temp_permission,
							'lang' => $lang,
							'folder_upload' => ($user['id'] * 168) * 168 + 168,
						)), time() + (86400 * 30), '/');
					}
					$this->session->set_flashdata('message-success', 'Đăng nhập thành công');
					redirect('admin');
				}
			}
		}
		$data['template'] = 'users/backend/auth/login';
		$this->load->view('dashboard/backend/layouts/auth', isset($data)?$data:NULL);
	}

	public function Logout(){
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		setcookie(CODE.'auth', '', time() - 86400, '/');
		redirect('admin/login');
	}

	public function Recovery(){
		$this->fcUser = $this->config->item('fcUser');
		if($this->fcUser) redirect('admin');
		$email = $this->input->get('email');
		$verify = $this->input->get('verify');
		if(isset($email) && !empty($email) && isset($verify) && !empty($verify)){
			$user = $this->BackendUsers_Model->ReadByField('email', $email);
			if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
				$this->session->set_flashdata('message-success', 'Tài khoản không tồn tại');
				redirect('admin/login');
			}
			if($user['verify'] != $verify){
				$this->session->set_flashdata('message-success', 'Mã xác nhận không hợp lệ');
				redirect('admin/login');
			}
			$salt = random();
			$newpassword = random(5, TRUE);
			$password = password_encode($newpassword, $salt);
			$flag = $this->BackendUsers_Model->UpdateByField('email', $user['email'], array(
				'verify' => '',
				'salt' => $salt,
				'password' => $password,
			));
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Mật khẩu mới: <strong>'.$newpassword.'</strong>');
				redirect('admin/login');
			}
		}
		if($this->input->post('recovery')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__AuthForgot');
			if ($this->form_validation->run($this)){
				$this->load->library(array('MailBie'));
				$user = $this->BackendUsers_Model->ReadByField('email', $this->input->post('email'));
				$verify = random(68, TRUE);
				$this->mailbie->sent(array(
					'to' => $user['email'],
					'cc' => '',
					'subject' => 'FinalCMS - Xác nhận quên mật khẩu',
					'message' => mail_html(array(
						'header' => 'FinalCMS',
						'description' => 'FinalCMS nhận được yêu cầu lấy lại mật khẩu của bạn',
						'content' => 'Click link dưới để lấy mật khẩu mới cho tài khoản của bạn:',
						'link' => '<a href="'.(site_url('admin/recovery').'?email='.$user['email'].'&verify='.$verify).'" style="color:#3b5998;text-decoration:none;font-size:11px" target="_blank">'.(site_url('admin/recovery').'?email='.$user['email'].'&verify='.$verify).'</a>'
					))
				));
				$flag = $this->BackendUsers_Model->UpdateByField('email', $user['email'], array(
					'verify' => $verify,
				));
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Mở Email để xác nhận');
					redirect('admin/login');
				}
			}
		}
		$data['template'] = 'users/backend/auth/recovery';
		$this->load->view('dashboard/backend/layouts/auth', isset($data)?$data:NULL);
	}

	public function _AuthForgot(){
		$email = $this->input->post('email');
		$user = $this->BackendUsers_Model->ReadByField('email', $email);
		if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
			$this->form_validation->set_message('_AuthForgot', 'Tài khoản không tồn tại');
			return FALSE;
		}
		return TRUE;
	}

	public function _AuthLogin(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$user = $this->BackendUsers_Model->ReadByField('email', $email);
		if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
			$this->form_validation->set_message('_AuthLogin', 'Tài khoản không tồn tại');
			return FALSE;
		}
		$password_encode = password_encode($password, $user['salt']);
		if($user['password'] != $password_encode){
			$this->form_validation->set_message('_AuthLogin', 'Mật khẩu không đúng');
			return FALSE;
		}
		$user['group'] = json_decode($user['group'], TRUE);
		if(isset($user['group']) && is_array($user['group']) && count($user['group']) && in_array('users/backend/account/blocked', $user['group'])){
			$this->form_validation->set_message('_AuthLogin', 'Tài khoản của bạn đã bị khóa');
			return FALSE;
		}
		return TRUE;
	}

}
