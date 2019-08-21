<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receiver extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendContactsReceiver_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendContactsReceiver_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('contacts/backend/receiver/view');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
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
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['listContacts'] = $this->BackendContactsReceiver_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'contacts/backend/receiver/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('name', 'Nơi nhận liên hệ', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run()){
				$flag = $this->BackendContactsReceiver_Model->create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm nơi nhận liên hệ mới thành công');
					redirect('contacts/backend/receiver/view');
				}
			}
		}
		$data['template'] = 'contacts/backend/receiver/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function read($id = 0){
		$id = (int)$id;
		$data['detailContactReceiver'] = $this->BackendContactsReceiver_Model->read($id);
		if(!isset($data['detailContactReceiver']) && !is_array($data['detailContactReceiver']) && count($data['detailContactReceiver']) == 0){
			$this->session->set_flashdata('message-danger', 'Nơi nhận liên hệ không tồn tại');
			redirect_custom('contacts/backend/receiver/view');
		}
		$data['template'] = 'contacts/backend/receiver/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$id = (int)$id;
		$data['detailContactReceiver'] = $this->BackendContactsReceiver_Model->read($id);
		if(!isset($data['detailContactReceiver']) && !is_array($data['detailContactReceiver']) && count($data['detailContactReceiver']) == 0){
			$this->session->set_flashdata('message-danger', 'Nơi nhận liên hệ không tồn tại');
			redirect_custom('contacts/backend/receiver/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('name', 'Nơi nhận liên hệ', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run()){
				$flag = $this->BackendContactsReceiver_Model->update($id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật nơi nhận liên hệ thành công');
					redirect_custom('contacts/backend/receiver/view');
				}
			}
		}
		$data['template'] = 'contacts/backend/receiver/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['detailContactReceiver'] = $this->BackendContactsReceiver_Model->read($id);
		if(!isset($data['detailContactReceiver']) && !is_array($data['detailContactReceiver']) && count($data['detailContactReceiver']) == 0){
			$this->session->set_flashdata('message-danger', 'Nơi nhận liên hệ không tồn tại');
			redirect_custom('contacts/backend/receiver/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendContactsReceiver_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa nơi nhận liên hệ thành công');
				redirect('contacts/backend/receiver/view');
			}
		}
		$data['template'] = 'contacts/backend/receiver/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
