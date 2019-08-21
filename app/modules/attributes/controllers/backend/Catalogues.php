<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendAttributesCatalogues_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/catalogues/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendAttributesCatalogues_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('attributes/backend/catalogues/view');
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
			$data['ListAttributes'] = $this->BackendAttributesCatalogues_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'attributes/backend/catalogues/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/catalogues/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục thuộc tính', 'trim|required');
			$this->form_validation->set_rules('keyword', 'keyword','trim|required|callback__Keyword');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendAttributesCatalogues_Model->Create();
				if($resultid > 0){
					$this->session->set_flashdata('message-success', 'Thêm danh mục thuộc tính mới thành công');
					redirect('attributes/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'attributes/backend/catalogues/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/catalogues/read'
		));
		$id = (int)$id;
		$data['DetailAttributesCatalogues'] = $this->BackendAttributesCatalogues_Model->ReadByField('id', $id);
		if(!isset($data['DetailAttributesCatalogues']) && !is_array($data['DetailAttributesCatalogues']) && count($data['DetailAttributesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục thuộc tính không tồn tại');
			redirect_custom('attributes/backend/catalogues/view');
		}
		$data['template'] = 'attributes/backend/catalogues/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/catalogues/update'
		));
		$id = (int)$id;
		$data['DetailAttributesCatalogues'] = $this->BackendAttributesCatalogues_Model->ReadByField('id', $id);
		if(!isset($data['DetailAttributesCatalogues']) && !is_array($data['DetailAttributesCatalogues']) && count($data['DetailAttributesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục thuộc tính không tồn tại');
			redirect_custom('attributes/backend/catalogues/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục thuộc tính', 'trim|required');
			$this->form_validation->set_rules('keyword', 'keyword','trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendAttributesCatalogues_Model->UpdateByPost('id', $id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật Danh mục thuộc tính thành công');
					redirect_custom('attributes/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'attributes/backend/catalogues/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/catalogues/delete'
		));
		$id = (int)$id;
		$data['DetailAttributesCatalogues'] = $this->BackendAttributesCatalogues_Model->ReadByField('id', $id);
		if(!isset($data['DetailAttributesCatalogues']) && !is_array($data['DetailAttributesCatalogues']) && count($data['DetailAttributesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục thuộc tính không tồn tại');
			redirect_custom('attributes/backend/catalogues/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendAttributesCatalogues_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa Danh mục thuộc tính thành công');
				redirect('attributes/backend/catalogues/view');
			}
		}
		$data['template'] = 'attributes/backend/catalogues/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function _Keyword(){
		$keyword = slug($this->input->post('keyword'));
		$attributes = $this->BackendAttributesCatalogues_Model->ReadByField('keyword', $keyword);
		
		if(isset($attributes) && is_array($attributes) && count($attributes)){
			$this->form_validation->set_message('_Keyword', 'keyword đã tồn tại');
				return FALSE;
		}
		return TRUE;
	}
}
