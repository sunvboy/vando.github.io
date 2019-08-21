<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendSupportsCatalogues_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendSupportsCatalogues_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('supports/backend/catalogues/view');
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
			$data['listSupports'] = $this->BackendSupportsCatalogues_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'supports/backend/catalogues/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Nhóm hỗ trợ', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run()){
				$flag = $this->BackendSupportsCatalogues_Model->create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm nhóm hỗ trợ mới thành công');
					redirect('supports/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'supports/backend/catalogues/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function read($id = 0){
		$id = (int)$id;
		$data['DetailSupportsCatalogues'] = $this->BackendSupportsCatalogues_Model->read($id);
		if(!isset($data['DetailSupportsCatalogues']) && !is_array($data['DetailSupportsCatalogues']) && count($data['DetailSupportsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'nhóm hỗ trợ không tồn tại');
			redirect_custom('supports/backend/catalogues/view');
		}
		$data['template'] = 'supports/backend/catalogues/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$id = (int)$id;
		$data['DetailSupportsCatalogues'] = $this->BackendSupportsCatalogues_Model->read($id);
		if(!isset($data['DetailSupportsCatalogues']) && !is_array($data['DetailSupportsCatalogues']) && count($data['DetailSupportsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'nhóm hỗ trợ không tồn tại');
			redirect_custom('supports/backend/catalogues/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Nhóm hỗ trợ', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run()){
				$flag = $this->BackendSupportsCatalogues_Model->update($id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật nhóm hỗ trợ thành công');
					redirect_custom('supports/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'supports/backend/catalogues/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['DetailSupportsCatalogues'] = $this->BackendSupportsCatalogues_Model->read($id);
		if(!isset($data['DetailSupportsCatalogues']) && !is_array($data['DetailSupportsCatalogues']) && count($data['DetailSupportsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'nhóm hỗ trợ không tồn tại');
			redirect_custom('supports/backend/catalogues/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendSupportsCatalogues_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa nhóm hỗ trợ thành công');
				redirect('supports/backend/catalogues/view');
			}
		}
		$data['template'] = 'supports/backend/catalogues/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
