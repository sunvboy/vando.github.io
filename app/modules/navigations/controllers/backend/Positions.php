<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Positions extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendNavigationsPositions_Model'
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/positions/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendNavigationsPositions_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('navigations/backend/positions/view');
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
			$data['ListNavigations'] = $this->BackendNavigationsPositions_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $this->fclang);	
		}
		$data['template'] = 'navigations/backend/positions/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/positions/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục Menu', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|required|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendNavigationsPositions_Model->Create($this->fcUser);
				if($resultid > 0){
					$this->session->set_flashdata('message-success', 'Thêm danh mục Menu mới thành công');
					redirect('navigations/backend/positions/view');
				}
			}
		}
		$data['template'] = 'navigations/backend/positions/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/positions/read'
		));
		$id = (int)$id;
		$data['DetailNavigationsPositions'] = $this->BackendNavigationsPositions_Model->ReadByField('id', $id);
		if(!isset($data['DetailNavigationsPositions']) && !is_array($data['DetailNavigationsPositions']) && count($data['DetailNavigationsPositions']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục Menu không tồn tại');
			redirect_custom('navigations/backend/positions/view');
		}
		$data['template'] = 'navigations/backend/positions/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/positions/update'
		));
		$id = (int)$id;
		$data['DetailNavigationsPositions'] = $this->BackendNavigationsPositions_Model->ReadByField('id', $id);
		if(!isset($data['DetailNavigationsPositions']) && !is_array($data['DetailNavigationsPositions']) && count($data['DetailNavigationsPositions']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục Menu không tồn tại');
			redirect_custom('navigations/backend/positions/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục Menu', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|required|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendNavigationsPositions_Model->UpdateByPost('id', $id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật danh mục Menu thành công');
					redirect_custom('navigations/backend/positions/view');
				}
			}
		}
		$data['template'] = 'navigations/backend/positions/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/positions/delete'
		));
		$id = (int)$id;
		$data['DetailNavigationsPositions'] = $this->BackendNavigationsPositions_Model->ReadByField('id', $id);
		if(!isset($data['DetailNavigationsPositions']) && !is_array($data['DetailNavigationsPositions']) && count($data['DetailNavigationsPositions']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục Menu không tồn tại');
			redirect_custom('navigations/backend/positions/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendNavigationsPositions_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa danh mục Menu thành công');
				redirect('navigations/backend/positions/view');
			}
		}
		$data['template'] = 'navigations/backend/positions/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function _Canonical(){
		$canonical = slug($this->input->post('canonical'));
		$canonical_original = slug($this->input->post('canonical_original'));
		if($canonical != $canonical_original){
			$count = $this->BackendNavigationsPositions_Model->CountByField('canonical', $canonical);
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
		$data['menus'] = $this->BackendNavigationsPositions_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['menus'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('navigations_positions', $temp);
		redirect((!empty($redirect)) ? $redirect : 'navigations/backend/positions/view');
	}
}
