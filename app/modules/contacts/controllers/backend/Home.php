<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendContacts_Model', 'BackendContactsReceiver_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendContacts_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('contacts/backend/home/view');
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
			$data['listContacts'] = $this->BackendContacts_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'contacts/backend/home/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('message', 'Nội dung', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendContacts_Model->create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm liên hệ mới thành công');
					redirect('contacts/backend/home/view');
				}
			}
		}
		$data['template'] = 'contacts/backend/home/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function read($id = 0){
		$this->BackendContacts_Model->update_field(array('read' => 1), $id);
		
		$data['detailContact'] = $this->BackendContacts_Model->read($id);
		if(!isset($data['detailContact']) && !is_array($data['detailContact']) && count($data['detailContact']) == 0){
			$this->session->set_flashdata('message-danger', 'Liên hệ không tồn tại');
			redirect_custom('contacts/backend/home/view');
		}
		if($data['detailContact']['viewed'] == 0){
			$this->BackendContacts_Model->update_field(array('viewed' => 1), $id);
		}
		$data['template'] = 'contacts/backend/home/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$id = (int)$id;
		$data['detailContact'] = $this->BackendContacts_Model->read($id);
		if(!isset($data['detailContact']) && !is_array($data['detailContact']) && count($data['detailContact']) == 0){
			$this->session->set_flashdata('message-danger', 'Liên hệ không tồn tại');
			redirect_custom('contacts/backend/home/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim|required');
			// $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			// $this->form_validation->set_rules('message', 'Nội dung', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendContacts_Model->update($id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật liên hệ thành công');
					redirect_custom('contacts/backend/home/view');
				}
			}
		}
		$data['template'] = 'contacts/backend/home/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['detailContact'] = $this->BackendContacts_Model->read($id);
		if(!isset($data['detailContact']) && !is_array($data['detailContact']) && count($data['detailContact']) == 0){
			$this->session->set_flashdata('message-danger', 'Liên hệ không tồn tại');
			redirect_custom('contacts/backend/home/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendContacts_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa liên hệ thành công');
				redirect('contacts/backend/home/view');
			}
		}
		$data['template'] = 'contacts/backend/home/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
