<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Systems extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendSystems_Model',
		));
		$this->load->library(array('Configbie'));
	}

	public function View(){
		$this->commonbie->Permissions(array(
			'uri' => 'systems/backend/systems/view'
		));
		$data['tabs'] = $this->configbie->system();
		$data['systems'] = $this->BackendSystems_Model->ReadAll($this->fclang);
		if($this->input->post('submit')){
			$flag = $this->BackendSystems_Model->Create($this->fclang);
			$this->session->set_flashdata('message-success', 'Cập nhật hệ thống thành công');
			redirect('systems/backend/systems/view');
		}
		$data['template'] = 'systems/backend/systems/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
