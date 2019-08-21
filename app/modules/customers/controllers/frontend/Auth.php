<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcCustomer = $this->config->item('fcCustomer');
		if(isset($this->fcCustomer) || is_array($this->fcCustomer) || count($this->fcCustomer)){
			$this->session->set_flashdata('message-danger', 'Bạn đã đăng nhập rồi');
			redirect(base_url());
		}
		$this->load->library('google');
		$this->load->library('facebook');
	}
	public function Register(){

		$data['meta_title'] = 'Trang đăng ký thành viên';
		$data['template'] = 'customers/frontend/account/register';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}

	public function Login(){
		$data['meta_title'] = 'Trang đăng nhập thành viên';
		$data['template'] = 'customers/frontend/account/login';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}