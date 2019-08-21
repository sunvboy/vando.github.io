<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commonbie{
	
	function __construct($params = NULL){
		$this->CI =& get_instance();
	}


	public function CheckLang(){
		$auth = isset($_COOKIE[CODE.'auth'])?$_COOKIE[CODE.'auth']:NULL;
		if(!isset($auth) || empty($auth)) return NULL;
		$auth = json_decode($auth, TRUE);
		
		if(!isset($auth['lang']) && !empty($auth['lang'])){
			$lang = 'vietnamese';
		}
		else{
			$lang = $auth['lang'];
		}
		return $lang;
	}

	public function CheckCustomerAuth(){
		$customer = isset($_COOKIE[CODE.'customer'])?$_COOKIE[CODE.'customer']:NULL;
		$customer = isset($customer)?$customer:NULL;
		if(!isset($customer) || empty($customer)) return NULL;
		$customer = json_decode($customer, TRUE);
		$customer_auth = $this->CI->FrontendCustomers_Model->ReadByCustomersParam(array(
			'email' => $customer['email'],
			'password' => $customer['password'],
		));
		if(!isset($customer_auth) || is_array($customer_auth) == FALSE || count($customer_auth) == 0){
			// $this->session->sess_destroy();
			return NULL;
		}
		return $customer_auth;
	}
	
	public function CheckAuth(){
		$auth = isset($_COOKIE[CODE.'auth'])?$_COOKIE[CODE.'auth']:NULL;
		
		if(!isset($auth) || empty($auth)) return NULL;
		$auth = json_decode($auth, TRUE);
		$user = $this->CI->FrontendUsers_Model->ReadByParam(array(
			'email' => $auth['email'],
			'password' => $auth['password'],
		));
		if(isset($user) && is_array($user) && count($user)){
			$user['group'] = json_decode($user['group'], TRUE);
		}
		if(!isset($user) || is_array($user) == FALSE || count($user) == 0){
			setcookie(CODE.'auth', '', time() - 86400, '/');
			return NULL;
		}
		return $user;
	}
	

	// Kiểm tra cho phép truy cập hàm chức năng
	public function Permissions($param = NULL){
		if(!isset($param['redirect']) || empty($param['redirect'])){
			$param['redirect'] = site_url('admin');
		}
		if(is_array($param) && count($param)){
			$user = $this->CI->config->item('fcUser');
			if(isset($param['uri']) && !empty($param['uri']) && isset($user['group']) && is_array($user['group']) && count($user['group']) && in_array($param['uri'], $user['group']) == FALSE){
				$this->CI->session->set_flashdata('message-danger', 'Bạn không có quyền vào khu vực này! => "'.$param['uri'].'"');
				redirect($param['redirect']);
			}
		}
		else{
			$this->CI->session->set_flashdata('message-danger', 'Bạn không có quyền vào khu vực này!');
			redirect($param['redirect']);
		}
	}


}
