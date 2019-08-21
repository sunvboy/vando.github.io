<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendLichhocCatalogues_Model'
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/catalogues/view'
		));
		
		$page = (int)$page;
		$config['total_rows'] = $this->BackendLichhocCatalogues_Model->CountAll($this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('lichhoc/backend/catalogues/view');
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
			$data['ListArticles'] = $this->BackendLichhocCatalogues_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $this->fclang);	
		}
		$data['template'] = 'lichhoc/backend/catalogues/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/catalogues/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('year', 'Năm', 'trim|required');
			$this->form_validation->set_rules('day', 'Ngày đàu tuần', 'trim');
			$this->form_validation->set_rules('dayfrom', 'Ngày cuối tuần', 'trim');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendLichhocCatalogues_Model->Create($this->fcUser, $this->fclang);
				if($resultid > 0){
					$this->session->set_flashdata('message-success', 'Thêm danh mục bài viết mới thành công');
					redirect('lichhoc/backend/catalogues/view');
				}
			}
		}

		$data['template'] = 'lichhoc/backend/catalogues/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/catalogues/read'
		));
		$id = (int)$id;
		$data['DetailArticlesCatalogues'] = $this->BackendLichhocCatalogues_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticlesCatalogues']) && !is_array($data['DetailArticlesCatalogues']) && count($data['DetailArticlesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục bài viết không tồn tại');
			redirect_custom('lichhoc/backend/catalogues/view');
		}
		$data['template'] = 'lichhoc/backend/catalogues/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/catalogues/update'
		));
		$id = (int)$id;
		$data['DetailArticlesCatalogues'] = $this->BackendLichhocCatalogues_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticlesCatalogues']) && !is_array($data['DetailArticlesCatalogues']) && count($data['DetailArticlesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục bài viết không tồn tại');
			redirect_custom('lichhoc/backend/catalogues/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tiêu đề', 'required');
			$this->form_validation->set_rules('day', 'ngày tháng', 'trim|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendLichhocCatalogues_Model->UpdateByPost(array('id'=> $id, 'user' => $this->fcUser));
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật Danh mục bài viết thành công');
					redirect_custom('lichhoc/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'lichhoc/backend/catalogues/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/catalogues/delete'
		));
		$id = (int)$id;
		$data['DetailArticlesCatalogues'] = $this->BackendLichhocCatalogues_Model->ReadByField('id', $id, $this->fclang);
		
		if(!isset($data['DetailArticlesCatalogues']) && !is_array($data['DetailArticlesCatalogues']) && count($data['DetailArticlesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục bài viết không tồn tại');
			redirect_custom('lichhoc/backend/catalogues/view');
		}
		
		if($this->input->post('delete')){
			$this->load->library('form_validation');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendLichhocCatalogues_Model->DeleteByField('id', $id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Xóa Danh mục bài viết thành công');
					redirect('lichhoc/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'lichhoc/backend/catalogues/delete';
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
		$data['lichhoc'] = $this->BackendLichhocCatalogues_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['lichhoc'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('articles_catalogues', $temp);
		redirect((!empty($redirect)) ? $redirect : 'lichhoc/backend/catalogues/view');
	}
	
	public function _Count(){
		$id = $this->input->post('cataloguesid');
		$DetailCatalogues =  $this->BackendLichhocCatalogues_Model->ReadByField('id', $id, $this->fclang);
		$count = $this->FrontendArticles_Model->_count(array(
			'select' => '`pr`.`id`',
			'modules' => 'lichhoc',
		), $DetailCatalogues);
		
		if($count > 0){
			$this->form_validation->set_message('_Count', 'Danh mục vẫn còn bài viết, hãy chắc chắn rằng bạn đã xóa hết bài viết trước khi xóa danh mục');
			return FALSE;
		}
		return TRUE;
	}
}
