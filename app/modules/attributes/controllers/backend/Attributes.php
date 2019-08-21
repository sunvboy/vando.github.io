<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attributes extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendAttributes_Model',
			'BackendAttributesCatalogues_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'attributes_catalogues'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/attributes/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendAttributes_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('attributes/backend/attributes/view');
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
			$data['ListAttributes'] = $this->BackendAttributes_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'attributes/backend/attributes/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/attributes/create'
		));
		if($this->input->post('create')){
			$data['tagsid'] = $this->input->post('tagsid');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Thuộc tính', 'trim|required');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục cha', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendAttributes_Model->Create();
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'attributes/frontend/attributes/view', $resultid, 'number');
					}
					$this->session->set_flashdata('message-success', 'Thêm thuộc tính mới thành công');
					redirect('attributes/backend/attributes/view');
				}
			}
		}
		
		$data['attributes_catalogues'] = $this->BackendAttributesCatalogues_Model->AttributesCataloguesList();
		$data['template'] = 'attributes/backend/attributes/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/attributes/read'
		));
		$id = (int)$id;
		$data['DetailAttributes'] = $this->BackendAttributes_Model->ReadByField('id', $id);
		if(!isset($data['DetailAttributes']) && !is_array($data['DetailAttributes']) && count($data['DetailAttributes']) == 0){
			$this->session->set_flashdata('message-danger', 'thuộc tính không tồn tại');
			redirect_custom('attributes/backend/attributes/view');
		}
		
		$data['template'] = 'attributes/backend/attributes/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/attributes/update'
		));
		$id = (int)$id;
		$data['DetailAttributes'] = $this->BackendAttributes_Model->ReadByField('id', $id);
		if(!isset($data['DetailAttributes']) && !is_array($data['DetailAttributes']) && count($data['DetailAttributes']) == 0){
			$this->session->set_flashdata('message-danger', 'thuộc tính không tồn tại');
			redirect_custom('attributes/backend/attributes/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'thuộc tính', 'trim|required');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục cha', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendAttributes_Model->UpdateByPost('id', $id);
				if($flag > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'attributes/frontend/attributes/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'attributes/frontend/attributes/view', $id, 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'attributes/frontend/attributes/view', $id, 'number');
					}
					$this->session->set_flashdata('message-success', 'Cập nhật thuộc tính thành công');
					redirect_custom('attributes/backend/attributes/view');
				}
			}
		}
		$data['attributes_catalogues'] = $this->BackendAttributesCatalogues_Model->AttributesCataloguesList();
		$data['template'] = 'attributes/backend/attributes/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'attributes/backend/attributes/delete'
		));
		$id = (int)$id;
		$data['DetailAttributes'] = $this->BackendAttributes_Model->ReadByField('id', $id);
		if(!isset($data['DetailAttributes']) && !is_array($data['DetailAttributes']) && count($data['DetailAttributes']) == 0){
			$this->session->set_flashdata('message-danger', 'thuộc tính không tồn tại');
			redirect_custom('attributes/backend/attributes/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendAttributes_Model->DeleteByField('id', $id);
			if($flag > 0){
				if(!empty($data['DetailAttributes']['canonical'])){
					$this->BackendRouters_Model->Delete($data['DetailAttributes']['canonical'], 'attributes/frontend/attributes/view', $data['DetailAttributes']['id'], 'number');
				}
				$this->BackendTags_Model->DeleteByModule($id, 'attributes');
				$this->session->set_flashdata('message-success', 'Xóa thuộc tính thành công');
				redirect('attributes/backend/attributes/view');
			}
		}
		$data['template'] = 'attributes/backend/attributes/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function _Canonical(){
		$canonical = slug($this->input->post('canonical'));
		$canonical_original = slug($this->input->post('canonical_original'));
		if(empty($canonical)){
			return TRUE;
		}
		if($canonical != $canonical_original){
			$count = $this->BackendRouters_Model->count($canonical);
			if($count > 0){
				$this->form_validation->set_message('_Canonical', 'Canonical đã tồn tại');
				return FALSE;
			}
		}
		return TRUE;
	}
}
