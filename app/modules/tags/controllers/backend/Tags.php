<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendTags_Model',
			'BackendTagsCatalogues_Model',
			'routers/BackendRouters_Model',
			'articles/BackendArticlesCatalogues_Model'
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'tags/backend/tags/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendTags_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('tags/backend/tags/view');
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
			$data['ListTags'] = $this->BackendTags_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'tags/backend/tags/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'tags/backend/tags/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Từ khóa', 'trim|required');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục cha', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendTags_Model->create();
				if($flag > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'tags/frontend/articles/view', $flag, 'number');
					}
					$this->session->set_flashdata('message-success', 'Thêm từ khóa mới thành công');
					redirect('tags/backend/tags/view');
				}
			}
		}
		$data['template'] = 'tags/backend/tags/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'tags/backend/tags/read'
		));
		$id = (int)$id;
		$data['DetailTags'] = $this->BackendTags_Model->ReadByField('id', $id);
		if(!isset($data['DetailTags']) && !is_array($data['DetailTags']) && count($data['DetailTags']) == 0){
			$this->session->set_flashdata('message-danger', 'Từ khóa không tồn tại');
			redirect_custom('tags/backend/tags/view');
		}
		$data['template'] = 'tags/backend/tags/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'tags/backend/tags/update'
		));
		$id = (int)$id;
		$data['DetailTags'] = $this->BackendTags_Model->ReadByField('id', $id);
		if(!isset($data['DetailTags']) && !is_array($data['DetailTags']) && count($data['DetailTags']) == 0){
			$this->session->set_flashdata('message-danger', 'Từ khóa không tồn tại');
			redirect_custom('tags/backend/tags/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Từ khóa', 'trim|required');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục cha', 'trim');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendTags_Model->UpdateByPost('id', $id);
				if($flag > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'tags/frontend/articles/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'tags/frontend/articles/view', $id, 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'tags/frontend/articles/view', $id, 'number');
					}
					$this->cache->clean();
					$this->session->set_flashdata('message-success', 'Cập nhật từ khóa thành công');
					redirect_custom('tags/backend/tags/view');
				}
			}
		}
		$data['articlesCataloguesList'] = $this->BackendTagsCatalogues_Model->Dropdown();
		$data['template'] = 'tags/backend/tags/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'tags/backend/tags/delete'
		));
		$id = (int)$id;
		$data['DetailTags'] = $this->BackendTags_Model->ReadByField('id', $id);
		if(!isset($data['DetailTags']) && !is_array($data['DetailTags']) && count($data['DetailTags']) == 0){
			$this->session->set_flashdata('message-danger', 'Từ khóa không tồn tại');
			redirect_custom('tags/backend/tags/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendTags_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa từ khóa thành công');
				redirect('tags/backend/tags/view');
			}
		}
		$data['template'] = 'tags/backend/tags/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function _Canonical(){
		$canonical = slug($this->input->post('canonical'));
		$canonical_original = slug($this->input->post('canonical_original'));
		if(empty($canonical)){
			return TRUE;
		}
		if($canonical != $canonical_original){
			$count = $this->BackendRouters_Model->Count($canonical);
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
		$data['tags'] = $this->BackendTags_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['tags'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('tags', $temp);
		$this->cache->clean();
		redirect((!empty($redirect)) ? $redirect : 'tags/backend/tags/view');
	}
}
