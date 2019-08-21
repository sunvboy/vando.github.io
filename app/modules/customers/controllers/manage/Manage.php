<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		$this->fcCustomer = $this->config->item('fcCustomer');
		if(!isset($this->fcCustomer) || is_array($this->fcCustomer) == FALSE || count($this->fcCustomer) == 0){
			$this->session->set_flashdata('message-danger', 'Bạn phải đăng nhập để sử dụng tính năng này');
			redirect(base_url());
		}
		$this->load->model(array('FrontendCustomers_Model', 'FrontendQuestions_Model', 'BackendLevel_Model'));
		$this->load->library('configbie');
	}
	
	
	public function Information(){
		$data['DetailCustomers'] = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__Information');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim|required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
			$this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required');
			if ($this->form_validation->run($this)){
//				$affiliate_id = ((!empty($data['DetailCustomers']['affiliate_id'])) ? $data['DetailCustomers']['affiliate_id'] : 'VANDO'.substr(md5(random().time()), 0, 5));
				$flag = $this->FrontendCustomers_Model->UpdateByField('email', $data['DetailCustomers']['email'], array(
					'email' => $this->input->post('email'),
					'fullname' => $this->input->post('fullname'),
//					'description' => $this->input->post('description'),
					'address' => $this->input->post('address'),
					'phone' => $this->input->post('phone'),
					'birthday' => $this->input->post('birthday'),
					'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				));
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật hồ sơ thành công');
					redirect('my-profile');
				}
			}
		}
		$data['city'] = $this->FrontendCustomers_Model->Location();
		$data['active'] = 'my-profile';
		$data['meta_title'] = 'Thông tin tài khoản';
		$data['template'] = 'customers/frontend/account/information';
		// $this->load->view('customers/manage/layouts/home', isset($data)?$data:NULL);
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	
	public function Password(){
		$data['DetailCustomers'] = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('password', 'Mật khẩu hiện tại', 'trim|required|min_length[6]|max_length[12]|callback__Password');
			$this->form_validation->set_rules('newpassword', 'Mật khẩu mới', 'trim|required|min_length[6]|max_length[12]');
			$this->form_validation->set_rules('renewpassword', 'Xác nhận mật khẩu mới', 'trim|required|min_length[6]|max_length[12]|matches[newpassword]');
			if ($this->form_validation->run($this)){
				$salt = random();
				$password = password_encode($this->input->post('newpassword'), $salt);
				$_update = array(
					'salt' => $salt,
					'password' => $password,
				);
				$flag = $this->FrontendCustomers_Model->UpdateByField('id', $this->fcCustomer['id'], $_update);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật thông tin thành công');
					redirect('thay-doi-mat-khau');
				}
			}
		}
		$data['meta_title'] = 'Thay đổi mật khẩu';
		$data['template'] = 'customers/frontend/account/password';
		// $this->load->view('customers/manage/layouts/home', isset($data)?$data:NULL);
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
//	public function Affiliate($page = 1){
//		$data['DetailCustomers'] = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
//
//		$page = (int)$page;
//		$config['total_rows'] = $this->FrontendQuestions_Model->CountAll(array('affiliate_id' => $data['DetailCustomers']['affiliate_id']));
//		if($config['total_rows'] > 0){
//			$this->load->library('pagination');
//			$config['base_url'] = 'quan-ly-don-hang';
//			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
//			$config['prefix'] = 'trang-';
//			$config['first_url'] = $config['base_url'].$config['suffix'];
//			$config['per_page'] = 10;
//			$config['cur_page'] = $page;
//			$config['uri_segment'] = 5;
//			$config['use_page_numbers'] = TRUE;
//			$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
//			$config['full_tag_close'] = '</ul>';
//			$config['first_tag_open'] = '<li>';
//			$config['first_tag_close'] = '</li>';
//			$config['last_tag_open'] = '<li>';
//			$config['last_tag_close'] = '</li>';
//			$config['cur_tag_open'] = '<li class="active"><a>';
//			$config['cur_tag_close'] = '</a></li>';
//			$config['next_tag_open'] = '<li>';
//			$config['next_tag_close'] = '</li>';
//			$config['prev_tag_open'] = '<li>';
//			$config['prev_tag_close'] = '</li>';
//			$config['num_tag_open'] = '<li>';
//			$config['num_tag_close'] = '</li>';
//			$this->pagination->initialize($config);
//			$data['ListPagination'] = $this->pagination->create_links();
//			$totalPage = ceil($config['total_rows']/$config['per_page']);
//			$page = ($page <= 0)?1:$page;
//			$page = ($page > $totalPage)?$totalPage:$page;
//			$page = $page - 1;
//			$data['ListPayment'] = $this->FrontendQuestions_Model->ReadAll(($page * $config['per_page']), $config['per_page'], array('affiliate_id' => $data['DetailCustomers']['affiliate_id']));
//		}
//
//		$data['meta_title'] = 'Lịch sử giới thiệu sản phẩm';
//		$data['template'] = 'customers/frontend/account/affiliate';
//		// $this->load->view('customers/manage/layouts/home', isset($data)?$data:NULL);
//		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
//	}

	public function Order($page = 1){
		$data['DetailCustomers'] = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);

		$page = (int)$page;
		$config['total_rows'] = $this->FrontendQuestions_Model->CountAll(array('customersid' => $this->fcCustomer['id']));
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = 'my-order';
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 20;
			$config['cur_page'] = $page;
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
			$data['ListPayment'] = $this->FrontendQuestions_Model->ReadAll(($page * $config['per_page']), $config['per_page'], array('customersid' => $this->fcCustomer['id']));
		}
		
		
		$data['meta_title'] = 'Quản lý mua hàng';
		$data['template'] = 'customers/frontend/account/order';
		// $this->load->view('customers/manage/layouts/home', isset($data)?$data:NULL);
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	public function Order_detail(){
		$this->load->model('BackendCustomers_Model');
		$id = (int)$this->input->get('id');
		$data['DetailCustomers'] = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		$_payment = $this->Autoload_Model->_read(array(
			'table' => 'payments',
			'where' => array(
				'id' => $id,
				'customersid' => $this->fcCustomer['id'],
			),
		));

		if(!isset($_payment) || is_array($_payment) == FALSE || count($_payment) == 0){
			$this->session->set_flashdata('message-danger', 'Đơn hàng không tồn tại');
			redirect('my-order');
		}

		$data['payment'] = $_payment;
		$data['meta_title'] = 'Chi tiết đơn hàng';
		$data['template'] = 'customers/frontend/account/order_detail';
		// $this->load->view('customers/manage/layouts/home', isset($data)?$data:NULL);
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	public function Coint($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->FrontendQuestions_Model->CountAllCoint(array('customers_id' => $this->fcCustomer['id']));
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = 'my-coint';
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['cur_page'] = $page;
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
			$data['ListCoint'] = $this->FrontendQuestions_Model->ReadAllCoint(($page * $config['per_page']), $config['per_page'], array('customers_id' => $this->fcCustomer['id']));
		}
		
		
		$data['meta_title'] = 'Quản lý xu';
		$data['template'] = 'customers/frontend/account/coint';
		// $this->load->view('customers/manage/layouts/home', isset($data)?$data:NULL);
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}

	public function _Password(){
		$password = $this->input->post('password');
		$customer = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);

		$password_encode = password_encode($password, $customer['salt']);
		if($customer['password'] != $password_encode){
			$this->form_validation->set_message('_Password', 'Mật khẩu hiện tại không đúng');
			return FALSE;
		}
		return TRUE;
	}
	
	public function _Information(){
		$email = $this->input->post('email');
		$old_email = $this->input->post('old_email');
		if($old_email != $email){
			$user = $this->FrontendCustomers_Model->ReadByField('email', $email);
			if(isset($user) && is_array($user) && count($user)){
				$this->form_validation->set_message('_Information', 'Email đã tồn tại');
				return FALSE;
			}
			return TRUE;
		}
		return TRUE;
	}

}
