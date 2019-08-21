<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendCustomers_Model',
			'BackendLevel_Model',
			'BackendCustomersGroups_Model'
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/customers/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendCustomers_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('customers/backend/customers/view');
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
			$data['Listcustomers'] = $this->BackendCustomers_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'customers/backend/customers/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/customers/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__Email');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required|callback__Phone');
			$this->form_validation->set_rules('code', 'Mã khách hàng', 'trim|callback__Code');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim');
			$this->form_validation->set_rules('groupsid', 'Nhóm thành viên', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendCustomers_Model->Create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm thành viên mới thành công');
					redirect('customers/backend/customers/view');
				}
			}
		}
		$data['template'] = 'customers/backend/customers/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/customers/read'
		));
		$id = (int)$id;
		$data['DetailCustomers'] = $this->BackendCustomers_Model->ReadByField('customers.id', $id);
		if(!isset($data['DetailCustomers']) && !is_array($data['DetailCustomers']) && count($data['DetailCustomers']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('customers/backend/customers/view');
		}
		$data['template'] = 'customers/backend/customers/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/customers/update'
		));
		$id = (int)$id;
		$data['DetailCustomers'] = $this->BackendCustomers_Model->ReadByField('customers.id', $id);
		if(!isset($data['DetailCustomers']) && !is_array($data['DetailCustomers']) && count($data['DetailCustomers']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('customers/backend/customers/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('affiliate_id', 'Mã affiliate', 'trim|callback__Code');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim');
			$this->form_validation->set_rules('groupsid', 'Nhóm thành viên', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendCustomers_Model->UpdateByPost('id', $id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật thành viên thành công');
					redirect_custom('customers/backend/customers/view');
				}
			}
		}
		$data['template'] = 'customers/backend/customers/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'customers/backend/customers/delete'
		));
		$id = (int)$id;
		$data['DetailCustomers'] = $this->BackendCustomers_Model->ReadByField('customers.id', $id);
		if(!isset($data['DetailCustomers']) && !is_array($data['DetailCustomers']) && count($data['DetailCustomers']) == 0){
			$this->session->set_flashdata('message-danger', 'Thành viên không tồn tại');
			redirect_custom('customers/backend/customers/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendCustomers_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa thành viên thành công');
				redirect('customers/backend/customers/view');
			}
		}
		$data['template'] = 'customers/backend/customers/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	
	// public function _Nickname(){
		// $nickname = $this->input->post('nickname');
		// $count = $this->BackendCustomers_Model->CheckFieldByCondition('nickname', $nickname);
		// if($count > 0){
			// $this->form_validation->set_message('_Nickname', 'Nickname đã tồn tài, hãy chọn một nickname khác');
			// return FALSE;
		// }
		// return TRUE;
	// }
	
	public function _Email(){
		$email = $this->input->post('email');
		$count = $this->BackendCustomers_Model->CheckFieldByCondition('email', $email);
		if($count > 0){
			$this->form_validation->set_message('_Email', 'Email đã tồn tài, hãy chọn một email khác');
			return FALSE;
		}
		return TRUE;
	}
	
	public function _Phone(){
		$phone = $this->input->post('phone');
		$count = $this->BackendCustomers_Model->CheckFieldByCondition('phone', $phone);
		if($count > 0){
			$this->form_validation->set_message('_Phone', 'Số điện thoại đã tồn tài, hãy chọn một số điện thoại khác');
			return FALSE;
		}
		return TRUE;
	}
	
	public function _Code(){
		$affiliate_id = $this->input->post('affiliate_id');
		$original_affiliate_id = $this->input->post('original_affiliate_id');
		if(empty($affiliate_id)){
			$this->form_validation->set_message('_Code', 'Mã Affiliate không được trống!');
			return FALSE;
		}
		if($affiliate_id != $original_affiliate_id){
			$count = $this->BackendCustomers_Model->CheckFieldByConditionAffiliate('affiliate_id', $affiliate_id);
			if($count > 0){
				$this->form_validation->set_message('_Code', 'Mã Affiliate đã tồn tại');
				return FALSE;
			}
		}
		return TRUE;
	}
	
	
	public function Verify($id = 0){
		$id = (int)$id;
		$data['DetailCustomers'] = $this->BackendCustomers_Model->ReadByField('customers.id', $id);
		
		if($data['DetailCustomers']['email'] == ''){
			$this->session->set_flashdata('message-danger', 'Bạn phải cập nhật Email trước khi kích hoạt tài khoản');
			redirect_custom('customers/backend/customers/view');
		}
		$temp['lock'] = ($data['DetailCustomers']['lock'] == 1) ? 0 : 1;
		$this->db->where(array('id' => $id));
		$this->db->update('customers', $temp);
		
		$this->load->library(array('mailbie'));
		$this->mailbie->sent(array(
			'to' => $data['DetailCustomers']['email'],
			'cc' => '',
			'subject' => 'Bạn nhận được email từ hệ thống website '.$this->fcSystem['contact_web'].'',
			'message' => mail_html(array(
				'header' => 'Kích hoạt tài khỏan',
				'description' => 'Bạn có một liên hệ với nội dung:',
				'content' => 'Tài khoản của bạn đã được kích hoạt. Mật khẩu đăng nhập của bạn là : CPV********** (Trong đó *** là số điện thoại của bạn)'.'<br>'.'<strong>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi, mọi thông tin chi tiết vui lòng liên hệ hotline: '.$this->fcSystem['contact_hotline'].'</strong>',
				
			)),
		));
		$this->session->set_flashdata('message-success', 'Kích hoạt tài khoản và gửi email thành công');
		redirect_custom('customers/backend/customers/view');
	}
}
