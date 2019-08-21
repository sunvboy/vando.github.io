<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'FrontendContacts_Model'
		));
	}

	public function checkcode(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$captcha = $this->input->post('keyword');
		$expiration = time() - 3600; // 1 Ngày
		$this->db->where('captcha_time < ', $expiration)->delete('captcha');
		$sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
		$binds = array($captcha, $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		if ($row->count == 0){
	        $alert['error'] = $this->lang->line('error_code');
		}
		echo json_encode($alert); die();
	}
	public function create(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		// $this->form_validation->set_rules('fullname', $this->lang->line('fullname_customers'), 'trim|required');
		$this->form_validation->set_rules('email', $this->lang->line('address_customers').' Email', 'trim|required|valid_email');
		// $this->form_validation->set_rules('phone', $this->lang->line('phone_customers'), 'trim|required');
		if ($this->form_validation->run($this)){
			$att = '';
			$data = array(
				'publish' => 0,
				'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			);
			$post = $this->input->post('post');
			if(isset($post) && is_array($post)  && count($post)) {
				foreach ($post as $key => $val) {
					$att[$val['name']] = nl2br($val['value']);
				}
				foreach ($data as $key => $val) {
					$att[$key] = $val;
				}
			}
			$flag = $this->FrontendContacts_Model->Create_ar($att);
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}
}
