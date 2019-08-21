<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendProjectsCatalogues_Model',
			'BackendProjects_Model',
			'routers/BackendRouters_Model',
		));
		
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'projects_catalogues'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/catalogues/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendProjectsCatalogues_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('projects/backend/catalogues/view');
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
			$data['listProjects'] = $this->BackendProjectsCatalogues_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'projects/backend/catalogues/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/catalogues/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục dự án', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				
				$resultid = $this->BackendProjectsCatalogues_Model->Create($this->fcUser);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'projects/frontend/catalogues/view', $resultid, 'number');
					}
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Thêm danh mục dự án mới thành công');
					redirect('projects/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'projects/backend/catalogues/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/catalogues/read'
		));
		$id = (int)$id;
		$data['DetailProjectsCatalogues'] = $this->BackendProjectsCatalogues_Model->ReadByField('id', $id);
		if(!isset($data['DetailProjectsCatalogues']) && !is_array($data['DetailProjectsCatalogues']) && count($data['DetailProjectsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục dự án không tồn tại');
			redirect_custom('projects/backend/catalogues/view');
		}
		$data['template'] = 'projects/backend/catalogues/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/catalogues/update'
		));
		$id = (int)$id;
		$data['DetailProjectsCatalogues'] = $this->BackendProjectsCatalogues_Model->ReadByField('id', $id);
		if(!isset($data['DetailProjectsCatalogues']) && !is_array($data['DetailProjectsCatalogues']) && count($data['DetailProjectsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục dự án không tồn tại');
			redirect_custom('projects/backend/catalogues/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục dự án', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendProjectsCatalogues_Model->UpdateByPost(array('id'=> $id, 'user' => $this->fcUser));
				if($flag > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'projects/frontend/catalogues/view', $data['DetailProjectsCatalogues']['id'], 'number');
						$this->BackendRouters_Model->Create($canonical, 'projects/frontend/catalogues/view', $data['DetailProjectsCatalogues']['id'], 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'projects/frontend/catalogues/view', $data['DetailProjectsCatalogues']['id'], 'number');
					}
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Cập nhật Danh mục dự án thành công');
					redirect_custom('projects/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'projects/backend/catalogues/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/catalogues/delete'
		));
		$id = (int)$id;
		$data['DetailProjectsCatalogues'] = $this->BackendProjectsCatalogues_Model->ReadByField('id', $id);
		
		if(!isset($data['DetailProjectsCatalogues']) && !is_array($data['DetailProjectsCatalogues']) && count($data['DetailProjectsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục dự án không tồn tại');
			redirect_custom('projects/backend/catalogues/view');
		}
		if($data['DetailProjectsCatalogues']['rgt'] - $data['DetailProjectsCatalogues']['lft'] > 1){
			$this->session->set_flashdata('message-danger', 'Cần phải xóa các danh mục con trước');
			redirect_custom('projects/backend/catalogues/view');
		}
		
		if($this->input->post('delete')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục', 'trim|required|callback__Count');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendProjectsCatalogues_Model->DeleteByField('id', $id);
				if($flag > 0){
					// /*Xóa những dự án chỉ nhận danh mục này làm cha*/
					// $projects_id = catalogues_relationship($data['DetailProjectsCatalogues']['id'], 'projects', array('Backendprojects','BackendprojectsCatalogues'), 'projects_catalogues');
					// $_delete_ = check_delete($projects_id, 'projects');
					/* ------------------------------------------------*/
					/* Xóa đường dẫn trong routers */
					$this->BackendRouters_Model->Delete($data['DetailProjectsCatalogues']['canonical'], 'projects/frontend/catalogues/view', $data['DetailProjectsCatalogues']['id'], 'number');	
					/* -----------------------------*/
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Xóa Danh mục dự án thành công');
					redirect('projects/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'projects/backend/catalogues/delete';
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
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['projects'] = $this->BackendProjectsCatalogues_Model->ReadByField('id', $id);
		$temp[$type] = (($data['projects'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('projects_catalogues', $temp);
		redirect((!empty($redirect)) ? $redirect : 'projects/backend/catalogues/view');
	}
	public function _Count(){
		$id = $this->input->post('cataloguesid');
		$DetailCatalogues =  $this->BackendProjectsCatalogues_Model->ReadByField('id', $id);
		$count = $this->Frontendprojects_Model->_count(array(
			'select' => '`pr`.`id`',
			'modules' => 'projects',
		), $DetailCatalogues);
		
		if($count > 0){
			$this->form_validation->set_message('_Count', 'Danh mục vẫn còn dự án, hãy chắc chắn rằng bạn đã xóa hết dự án trước khi xóa danh mục');
			return FALSE;
		}
		return TRUE;
	}
}
