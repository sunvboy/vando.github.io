<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lichhoc extends FC_Controller{
	
	public $action;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendLichhoc_Model',
			'BackendLichhocCatalogues_Model'
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/lichhoc/view'
		));
		$page = (int)$page;
		
		$config['total_rows'] = $this->BackendLichhoc_Model->CountAll($this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('lichhoc/backend/lichhoc/view');
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
			$data['ListPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['ListArticles'] = $this->BackendLichhoc_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $this->fclang);	
		}
		$data['template'] = 'lichhoc/backend/lichhoc/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/lichhoc/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục ngày tháng', 'trim|required');
			$this->form_validation->set_rules('time', 'Thời gian', 'trim');
			$this->form_validation->set_rules('content', 'Nội dung bài học', 'trim|required');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendLichhoc_Model->Create($this->fcUser, $this->fclang);
				if($resultid > 0){
					$this->session->set_flashdata('message-success', 'Thêm bài viết mới thành công');
					redirect('lichhoc/backend/lichhoc/view');
				}
			}
		}
		$data['template'] = 'lichhoc/backend/lichhoc/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'articles/backend/articles/read'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendLichhoc_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('articles/backend/articles/view');
		}
		$data['template'] = 'articles/backend/articles/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/lichhoc/update'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendLichhoc_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('lichhoc/backend/lichhoc/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục ngày tháng', 'trim|required');
			$this->form_validation->set_rules('time', 'Thời gian', 'trim');
			$this->form_validation->set_rules('content', 'Nội dung bài học', 'trim|required');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendLichhoc_Model->UpdateByPost('id', $id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật bài viết thành công');
					redirect_custom('lichhoc/backend/lichhoc/view');
				}
			}
		}
		$data['template'] = 'lichhoc/backend/lichhoc/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'lichhoc/backend/lichhoc/delete'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendLichhoc_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('lichhoc/backend/lichhoc/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendLichhoc_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa bài viết thành công');
				redirect('lichhoc/backend/lichhoc/view');
			}
		}
		$data['template'] = 'lichhoc/backend/lichhoc/delete';
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
	public function _Catalogue() {
		$catalogue = $this->input->post('catalogue');
		if(!isset($catalogue) || count($catalogue) == 0 || !is_array($catalogue)) {
			$this->form_validation->set_message('_Catalogue','Danh mục cha trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['articles'] = $this->BackendLichhoc_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['articles'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('articles', $temp);
		redirect((!empty($redirect)) ? $redirect : 'articles/backend/articles/view');
	}
}
