<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mailsubricre extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'Frontendmailsubricre_Model'
		));
	}

	public function create(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
//		$this->form_validation->set_rules('fullname', $this->lang->line('fullname_customers'), 'trim|required');
		$this->form_validation->set_rules('email', 'Địa chỉ Email', 'trim|required|valid_email');
//		$this->form_validation->set_rules('check', 'Bạn chưa đồng ý với điều khoản của chúng tôi', 'trim|required');
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
			$flag = $this->Frontendmailsubricre_Model->create($att);
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}
	public function createphone(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
//		$this->form_validation->set_rules('fullname', $this->lang->line('fullname_customers'), 'trim|required');
//		$this->form_validation->set_rules('email', 'Địa chỉ Email', 'trim|required|valid_email');
//		$this->form_validation->set_rules('check', 'Bạn chưa đồng ý với điều khoản của chúng tôi', 'trim|required');
		 $this->form_validation->set_rules('phone', $this->lang->line('phone_customers'), 'trim|required');
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
			$flag = $this->Frontendmailsubricre_Model->create($att);
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}
}
