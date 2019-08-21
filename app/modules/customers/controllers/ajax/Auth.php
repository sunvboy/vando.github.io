<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcCustomer = $this->config->item('fcCustomer');
		$this->load->model(array('FrontendCustomers_Model'));
		$this->load->library('google');
		$this->load->library('facebook');
		// $this->config->load('config_google');
		$this->config->load('config_facebook');

	}
	public function Active_code(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		if(isset($this->fcCustomer) || is_array($this->fcCustomer) || count($this->fcCustomer)){
			$code = $this->input->post('code');
			if (!empty($code)) {
				$code_active = $this->Autoload_Model->_get_where(array(
					'select' => 'products_code.*, (SELECT title FROM products WHERE products.id = products_code.productsid ) as products_title',
		            'table' => 'products_code',
		            'where' => array('code' => $code),
		            'limit' => 1,
		            'order_by' => 'id desc',
				));
				if (isset($code_active) && is_array($code_active) && count($code_active)) {
					if (!empty($code_active['publish'])) {
						$alert['error'] = 'Error:';
						$alert['message'] = 'Mã kích hoạt đã được sử dụng.';
					}else{
						if ($code_active['customersid'] == $this->fcCustomer['id']) {
							// Query update sử dụng code
							$flag = $this->Autoload_Model->_update(array(
								'table' => 'products_code',
								'where' => array('customersid' => $this->fcCustomer['id'], 'code' => $code),
								'data' => array('publish' => 1, 'status' => 1, 'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600)),
							));
							if ($flag > 0) {
								$alert['message'] = 'Chúc mừng bạn kích hoạt thành công khóa học '.$code_active['products_title'].'. Click <a href="'.site_url('my-lesson').'">vào đây</a> đê vào học ngay bây giờ';
							}else{
								$alert['error'] = 'Error:';
								$alert['message'] = 'Truy vấn gặp lỗi, vui lòng liên hệ với chúng tôi để nhận được sự trợ giúp';
							}
						}else{
							$alert['error'] = 'Error:';
							$alert['message'] = 'Mã kích hoạt này không thuộc sự sở hữu của bạn.';
						}
					}
				}else{
					$alert['error'] = 'Error:';
					$alert['message'] = 'Mã kích hoạt không tồn tại, vui lòng thử lại.';
				}
			}else{
				$alert['error'] = 'Error:';
				$alert['message'] = 'Vui lòng nhập mã để kích hoạt khóa học.';
			}
		}else{
			$alert['error'] = 'Error:';
			$alert['message'] = 'Vui lòng đăng nhập để kích hoạt khóa học.';
		}
		echo json_encode($alert);die;
	}

	public function Login_google(){
		$user = $this->google->validate();
		$customer = $this->FrontendCustomers_Model->ReadByField('email', $user['email']);
		if (isset($customer) && is_array($customer) && count($customer)) {
			if ($customer['nickname'] == 'google') {
				$customer = $this->FrontendCustomers_Model->ReadByField('email', $user['email']);
				if (isset($customer) && is_array($customer) && count($customer)) {
					$flag = $this->FrontendCustomers_Model->UpdateByField('email', $customer['email'], array(
						'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						'user_agent' => $_SERVER['HTTP_USER_AGENT'],
						'remote_addr' => $_SERVER['REMOTE_ADDR']
					));
					if($flag > 0){
						setcookie(CODE.'customer', json_encode(array(
							'id' => $customer['id'],
							'email' => $customer['email'],
							'password' => $customer['password'],
							'folder_upload' => ($customer['id'] * 1010) * 1010 + 1010,
						)), time() + (86400 * 30), '/');
						$this->session->set_flashdata('message-success', 'Đăng nhập thành công');
						redirect(base_url());
					}
				}
			}else{
				$this->session->set_flashdata('message-danger', 'Địa chỉ Email đã sử dụng cho thành phần khác');
				redirect(base_url());
			}
		}else{
			$salt = random();
			$password = password_encode($user['id'], $salt);
			$affiliate_id = 'VANDO'.substr(md5(random().time()), 0, 10);
			$affiliate = (isset($_COOKIE['affiliate'])) ? $_COOKIE['affiliate'] : '';// Người giới thiệu
			$id_customers_gt = 0;
			if (!empty($affiliate)) {
				$check_affiliate = $this->FrontendProducts_Model->_read(array(
					'select' => 'id',
					'table' => 'customers',
					'where' => array('publish' => 1, 'trash' => 0, 'affiliate_id' => $affiliate),
				));
				if (isset($check_affiliate) && is_array($check_affiliate) && count($check_affiliate)) {
					$id_customers_gt = ((!empty($check_affiliate['id'])) ? $check_affiliate['id'] : 0);
				}
			}
			$_insert = array(
				'email' => $user['email'],
				'password' => $password,
				'salt' => $salt,
				'fullname' => $user['name'],
				'parentid' => $id_customers_gt,
				'affiliate_id' => $affiliate_id,
				'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				'phone' => '',
				'publish' => 1,
				'groupsid' => 1, // THÀNH VIÊN
				'level' => 5,
				'images' => $user['profile_pic'],
				'nickname' => 'google',
			);
			$this->db->insert('customers', $_insert);
			$resultid = $this->db->insert_id();
			if($resultid > 0){
				$customer = $this->FrontendCustomers_Model->ReadByField('email', $user['email']);
				if (isset($customer) && is_array($customer) && count($customer)) {
					$flag = $this->FrontendCustomers_Model->UpdateByField('email', $customer['email'], array(
						'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						'user_agent' => $_SERVER['HTTP_USER_AGENT'],
						'remote_addr' => $_SERVER['REMOTE_ADDR']
					));
					if($flag > 0){
						setcookie(CODE.'customer', json_encode(array(
							'id' => $customer['id'],
							'email' => $customer['email'],
							'password' => $customer['password'],
							'folder_upload' => ($customer['id'] * 1010) * 1010 + 1010,
						)), time() + (86400 * 30), '/');
						$this->session->set_flashdata('message-success', 'Đăng nhập thành công');
						redirect(base_url());
					}
				}
			}
		}	
	}

	public function fbcallback(){
		$user = $this->facebook->validate();
 
  		$customer = $this->FrontendCustomers_Model->ReadByField('email', $user['email']);
		// Nếu đã tồn tại facebook_id thì lấy ra thông tin và setcookie
  		if(isset($customer) && is_array($customer) && count($customer)){
  			if ($customer['nickname'] == 'facebook') {
	   			$flag = $this->FrontendCustomers_Model->UpdateByField('email', $customer['email'], array(
					'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
					'remote_addr' => $_SERVER['REMOTE_ADDR']
				));
				if($flag > 0){
					setcookie(CODE.'customer', json_encode(array(
						'id' => $customer['id'],
						'email' => $customer['email'],
						'password' => $customer['password'],
						'folder_upload' => ($customer['id'] * 1010) * 1010 + 1010,
					)), time() + (86400 * 30), '/');
					$this->session->set_flashdata('message-success', 'Đăng nhập thành công');
					redirect(base_url());
				}
			}else{
				$this->session->set_flashdata('message-danger', 'Địa chỉ Email đã sử dụng cho thành phần khác');
				redirect(base_url());
			}
  		}else{
		   	$salt = random();
			$password = password_encode($user['facebook_id'], $salt);
			$affiliate_id = 'VANDO'.substr(md5(random().time()), 0, 10);
			$affiliate = (isset($_COOKIE['affiliate'])) ? $_COOKIE['affiliate'] : '';// Người giới thiệu
			$id_customers_gt = 0;
			if (!empty($affiliate)) {
				$check_affiliate = $this->FrontendProducts_Model->_read(array(
					'select' => 'id',
					'table' => 'customers',
					'where' => array('publish' => 1, 'trash' => 0, 'affiliate_id' => $affiliate),
				));
				if (isset($check_affiliate) && is_array($check_affiliate) && count($check_affiliate)) {
					$id_customers_gt = ((!empty($check_affiliate['id'])) ? $check_affiliate['id'] : 0);
				}
			}
			$_insert = array(
				'email' => $user['email'],
				'password' => $password,
				'salt' => $salt,
				'fullname' => $user['fullname'],
				'parentid' => $id_customers_gt,
				'affiliate_id' => $affiliate_id,
				'publish' => 1,
				'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				'phone' => '',
				'groupsid' => 1, // THÀNH VIÊN
				'level' => 5,
				'images' => $user['avatar'],
				'nickname' => 'facebook',
			);
			$this->db->insert('customers', $_insert);
			$resultid = $this->db->insert_id();
			if($resultid > 0){
				$customer = $this->FrontendCustomers_Model->ReadByField('email', $user['email']);
				if (isset($customer) && is_array($customer) && count($customer)) {
					$flag = $this->FrontendCustomers_Model->UpdateByField('email', $customer['email'], array(
						'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						'user_agent' => $_SERVER['HTTP_USER_AGENT'],
						'remote_addr' => $_SERVER['REMOTE_ADDR']
					));
					if($flag > 0){
						setcookie(CODE.'customer', json_encode(array(
							'id' => $customer['id'],
							'email' => $customer['email'],
							'password' => $customer['password'],
							'folder_upload' => ($customer['id'] * 1010) * 1010 + 1010,
						)), time() + (86400 * 30), '/');
						$this->session->set_flashdata('message-success', 'Đăng nhập thành công');
						redirect(base_url());
					}
				}
			}
  		}
 	}
	
	public function Login(){
		$email = $this->input->post('email');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		$this->form_validation->set_rules('email', 'Tên tài khoản', 'trim|required');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|callback__AuthLogin');
		if($this->form_validation->run($this)){
			$customer = $this->FrontendCustomers_Model->ReadByField('email', $this->input->post('email'));
			$flag = $this->FrontendCustomers_Model->UpdateByField('email', $customer['email'], array(
				'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				'user_agent' => $_SERVER['HTTP_USER_AGENT'],
				'remote_addr' => $_SERVER['REMOTE_ADDR']
			));
			if($flag > 0){
				$remember = 1;
				if($remember == 1){
					setcookie(CODE.'customer', json_encode(array(
						'id' => $customer['id'],
						'email' => $customer['email'],
						'password' => $customer['password'],
						'folder_upload' => ($customer['id'] * 1010) * 1010 + 1010,
					)), time() + (86400 * 30), '/');
				}
				echo json_encode(array(
					'message' => 'Đăng nhập thành công',
					'flag' => true,
					'redirect' => 'my-profile.html',
				));die();
			}
		}else{
			$error = validation_errors();
			echo json_encode(array(
				'message' => $error,
				'flag' => false,
			));die();
		}
		
	}
	
	public function Register(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$re_password = $this->input->post('re_password');
		$fullname = $this->input->post('fullname');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		
		$this->form_validation->set_rules('fullname', 'Họ và tên', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__Email');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
		// $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'trim|required|matches[password]');
		if ($this->form_validation->run($this)){
			$affiliate_id = 'VANDO'.substr(md5(random().time()), 0, 10);
			$affiliate = (isset($_COOKIE['affiliate'])) ? $_COOKIE['affiliate'] : '';// Người giới thiệu
			$id_customers_gt = 0;
			if (!empty($affiliate)) {
				$check_affiliate = $this->FrontendProducts_Model->_read(array(
					'select' => 'id',
					'table' => 'customers',
					'where' => array('publish' => 1, 'trash' => 0, 'affiliate_id' => $affiliate),
				));
				if (isset($check_affiliate) && is_array($check_affiliate) && count($check_affiliate)) {
					$id_customers_gt = ((!empty($check_affiliate['id'])) ? $check_affiliate['id'] : 0);
				}
			}
			$salt = random();
			$password = password_encode($password, $salt);
			$_insert = array(
				'email' => $email,
				'fullname' => $fullname,
				'password' => $password,
				'salt' => $salt,
				'parentid' => $id_customers_gt,
				'affiliate_id' => $affiliate_id,
				'publish' => 1,
				'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				'groupsid' => 1, // THÀNH VIÊN
				'level' => 5,
			);
			$this->db->insert('customers', $_insert);
			$resultid = $this->db->insert_id();
			if($resultid > 0){
				$verify = random(68, TRUE);
				$this->load->library(array('mailbie'));
				$this->mailbie->sent(array(
					'to' => $this->input->post('email'),
					'cc' => '',
					'subject' => $this->fcSystem['contact_web'].' - Xác nhận tài khoản',
					'message' => 'Click vào link dưới để xác nhận tài khoản của bạn: '.'<br>'.'<a href="'.BASE_URL.'xac-minh.html?id='.$resultid.'&verify='.$verify.'" style="color:#3b5998;text-decoration:none;font-size:11px" target="_blank">'.(site_url('xac-minh').'?id='.$resultid.'&verify='.$verify).'</a>'
				));
				
				
				
				$flag = $this->FrontendCustomers_Model->UpdateByField('id', $resultid, array(
					'verify' => $verify,
				));
				if($flag > 0){
					$error = validation_errors();
					echo json_encode(array(
						'message' => 'Đăng ký tài khoản thành công, một email đã được gửi đến tài khoản của bạn',
						'flag' => true,
					));die();
				}
				
			}
		}else{
			$error = validation_errors();
			echo json_encode(array(
				'message' => $error,
				'flag' => false,
			));die();
		}
	}
	
	public function Logout(){
		$this->fcCustomer = $this->config->item('fcCustomer');
		if(!$this->fcCustomer) redirect(base_url());
		setcookie(CODE.'customer', '', time() - 86400, '/');
		redirect(base_url());
	}
	
	
	public function Verify(){
		$verify = $this->input->get('verify');
		$id = $this->input->get('id');
		if(isset($id) && $id > 0 && isset($verify) && !empty($verify)){
			$customer = $this->FrontendCustomers_Model->ReadByField('customers.id', $id);
			if(!isset($customer) || is_array($customer) == FALSE || count($customer) == 0){
				$this->session->set_flashdata('message-success', 'Tài khoản không tồn tại');
				redirect(base_url());
			}
			if($customer['verify'] != $verify){
				$this->session->set_flashdata('message-success', 'Mã xác nhận không hợp lệ');
				redirect(base_url());
			}
			$flag = $this->FrontendCustomers_Model->UpdateByField('id', $customer['id'], array(
				'verify' => '',
			));
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xác minh tài khoản thành công, Bạn đã có thể đăng nhập vào hệ thống sau thông báo này');
				redirect(base_url());
			}
		}
	}

	
	public function _AuthLogin(){
		$account = $this->input->post('email');
		$password = $this->input->post('password');
		$customer = $this->FrontendCustomers_Model->ReadByField('email', $account); // get infor email
		if(!isset($customer) && !is_array($customer) || count($customer) == 0 ){
			$customer = $this->FrontendCustomers_Model->ReadByField('phone', $account); // get infor phone
		}
		
		if(!isset($customer) || is_array($customer) == FALSE || count($customer) == 0){
			$this->form_validation->set_message('_AuthLogin', 'Tài khoản không tồn tại');
			return FALSE;
		}
		if(isset($customer) && $customer['verify'] != ''){
			$this->form_validation->set_message('_AuthLogin', 'Tài khoản chưa được xác minh');
			return FALSE;
		}
		$password_encode = password_encode($password, $customer['salt']);
		if($customer['password'] != $password_encode){
			$this->form_validation->set_message('_AuthLogin', 'Mật khẩu không đúng');
			return FALSE;
		}
		return TRUE;
	}
	
	public function _Email(){
		$email = $this->input->post('email');
		$count = $this->FrontendCustomers_Model->CheckFieldByCondition('email', $email);
		if($count > 0){
			$this->form_validation->set_message('_Email','Email đã tồn tại');
			return false;
		}
		return true;
	}
	
	
	public function _Phone(){
		$phone = $this->input->post('phone');
		$count = $this->FrontendCustomers_Model->CheckFieldByCondition('phone', $phone);
		if($count > 0){
			$this->form_validation->set_message('_Phone','Số điện thoại đã tồn tại');
			return false;
		}
		return true;
	}
	
	public function loaddistrict(){
		$cityid = $this->input->post('cityid');
		$district = $this->FrontendCustomers_Model->district($cityid);
		$str = '';
		$str = $str.'<option value="0">--Chọn Quận huyện--</option>';
		if(isset($district) && is_array($district) && count($district)){
			foreach($district as $key => $val){
				$str = $str.'<option value="'.$val['id'].'">'.$val['title'].'</option>';
			}
		}
		echo $str;die();
	}
	
	public function _EmailCallBack(){
		$email = $this->input->post('email');
		$original_email = $this->input->post('original_email');
		if($email != $original_email){
			$count = $this->FrontendCustomers_Model->CheckFieldByCondition('email', $email);
			if($count > 0){
				$this->form_validation->set_message('_EmailCallBack','Email đã tồn tại');
				return false;
			}
		}
		return true;
	}
	public function __Phone(){
		$phone = $this->input->post('phone');
		$original_phone = $this->input->post('original_phone');
		if($phone != $original_phone){
			$count = $this->FrontendCustomers_Model->CheckFieldByCondition('phone', $phone);
			if($count > 0){
				$this->form_validation->set_message('__Phone','Số điện thoại đã tồn tại');
				return false;
			}
		}
		return true;
	}

}
