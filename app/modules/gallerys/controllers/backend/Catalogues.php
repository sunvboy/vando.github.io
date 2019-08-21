<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendGallerysCatalogues_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'gallerys_catalogues'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/catalogues/view'
		));
		
		$page = (int)$page;
		$config['total_rows'] = $this->BackendGallerysCatalogues_Model->CountAll($this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('gallerys/backend/catalogues/view');
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
			$data['ListGallerys'] = $this->BackendGallerysCatalogues_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $this->fclang);
		}
		$data['template'] = 'gallerys/backend/catalogues/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/catalogues/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục bài viết', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendGallerysCatalogues_Model->Create($this->fcUser, $this->fclang);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'gallerys/frontend/catalogues/view', $resultid, 'number');
					}
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Thêm danh mục hình ảnh mới thành công');
					redirect('gallerys/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'gallerys/backend/catalogues/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/catalogues/read'
		));
		$id = (int)$id;
		$data['DetailArticlesCatalogues'] = $this->BackendGallerysCatalogues_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticlesCatalogues']) && !is_array($data['DetailArticlesCatalogues']) && count($data['DetailArticlesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục bài viết không tồn tại');
			redirect_custom('gallerys/backend/catalogues/view');
		}
		$data['template'] = 'gallerys/backend/catalogues/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/catalogues/update'
		));
		$id = (int)$id;
		$data['DetailArticlesCatalogues'] = $this->BackendGallerysCatalogues_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticlesCatalogues']) && !is_array($data['DetailArticlesCatalogues']) && count($data['DetailArticlesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục bài viết không tồn tại');
			redirect_custom('gallerys/backend/catalogues/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục bài viết', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendGallerysCatalogues_Model->UpdateByPost(array('id'=> $id, 'user' => $this->fcUser));
				if($flag > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'gallerys/frontend/catalogues/view', $data['DetailArticlesCatalogues']['id'], 'number');
						$this->BackendRouters_Model->Create($canonical, 'gallerys/frontend/catalogues/view', $data['DetailArticlesCatalogues']['id'], 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'gallerys/frontend/catalogues/view', $data['DetailArticlesCatalogues']['id'], 'number');
					}
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Cập nhật Danh mục bài viết thành công');
					redirect_custom('gallerys/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'gallerys/backend/catalogues/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/catalogues/delete'
		));
		$id = (int)$id;
		$data['DetailArticlesCatalogues'] = $this->BackendGallerysCatalogues_Model->ReadByField('id', $id, $this->fclang);
		
		if(!isset($data['DetailArticlesCatalogues']) && !is_array($data['DetailArticlesCatalogues']) && count($data['DetailArticlesCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục hình ảnh không tồn tại');
			redirect_custom('gallerys/backend/catalogues/view');
		}
		if($data['DetailArticlesCatalogues']['rgt'] - $data['DetailArticlesCatalogues']['lft'] > 1){
			$this->session->set_flashdata('message-danger', 'Cần phải xóa các danh mục con trước');
			redirect_custom('gallerys/backend/catalogues/view');
		}
		
		if($this->input->post('delete')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục', 'trim|required|callback__Count');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendGallerysCatalogues_Model->DeleteByField('id', $id);
				if($flag > 0){
					/*Xóa những bài viết chỉ nhận danh mục này làm cha*/
					// $gallerys_id = catalogues_relationship($data['DetailArticlesCatalogues']['id'], 'gallerys', array('BackendGallerys','BackendGallerysCatalogues'), 'gallerys_catalogues');
					// $_delete_ = check_delete($gallerys_id, 'gallerys');
					/* ------------------------------------------------*/
					/* Xóa đường dẫn trong routers */
					$this->BackendRouters_Model->Delete($data['DetailArticlesCatalogues']['canonical'], 'gallerys/frontend/catalogues/view', $data['DetailArticlesCatalogues']['id'], 'number');	
					/* -----------------------------*/
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Xóa Danh mục hình ảnh thành công');
					redirect('gallerys/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'gallerys/backend/catalogues/delete';
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
		$data['gallerys'] = $this->BackendGallerysCatalogues_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['gallerys'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('gallerys_catalogues', $temp);
		redirect((!empty($redirect)) ? $redirect : 'gallerys/backend/catalogues/view');
	}
	public function _Count(){
		$id = $this->input->post('cataloguesid');
		$DetailCatalogues =  $this->BackendGallerysCatalogues_Model->ReadByField('id', $id, $this->fclang);
		$count = $this->FrontendGallerys_Model->_count(array(
			'select' => '`pr`.`id`',
			'modules' => 'gallerys',
		), $DetailCatalogues);
		
		if($count > 0){
			$this->form_validation->set_message('_Count', 'Danh mục vẫn còn bài viết, hãy chắc chắn rằng bạn đã xóa hết bài viết trước khi xóa danh mục');
			return FALSE;
		}
		return TRUE;
	}
}
