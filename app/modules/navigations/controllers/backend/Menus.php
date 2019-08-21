<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendNavigationsMenus_Model',
			'BackendNavigationsPositions_Model',
			'BackendNavigationsMenusItems_Model',
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/menus/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendNavigationsMenus_Model->CountAll($this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('navigations/backend/menus/view');
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
			$data['Listnavigations'] = $this->BackendNavigationsMenus_Model->ReadAll($this->fclang);	
			$data['Listnavigations'] = recursive($data['Listnavigations']);
			// print_r($data['Listnavigations']);die;
			// if(isset($data['Listnavigations']) && is_array($data['Listnavigations']) && count($data['Listnavigations'])){
			// 	foreach($data['Listnavigations'] as $key => $val){
			// 		$data['Listnavigations'][$key]['child'] = $this->BackendNavigationsMenus_Model->ReadAll($val['id']);
			// 	}
			// }
		}
		$data['template'] = 'navigations/backend/menus/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/menus/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Menu', 'trim|required');
			$this->form_validation->set_rules('href', 'Href', 'trim|required');
			$this->form_validation->set_rules('positionsid', 'Vị trí', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendNavigationsMenus_Model->Create($this->fcUser, $this->fclang);
				if($resultid > 0){
					$this->BackendNavigationsMenusItems_Model->InsertBatchByMenusid($resultid);
					$this->session->set_flashdata('message-success', 'Thêm mới thành công');
					redirect('navigations/backend/menus/view');
				}
			}
		}
		$data['template'] = 'navigations/backend/menus/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/menus/read'
		));
		$id = (int)$id;
		$data['DetailNavigationsMenus'] = $this->BackendNavigationsMenus_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailNavigationsMenus']) && !is_array($data['DetailNavigationsMenus']) && count($data['DetailNavigationsMenus']) == 0){
			$this->session->set_flashdata('message-danger', 'Menu không tồn tại');
			redirect_custom('navigations/backend/menus/view');
		}
		$data['MenusItems'] = $this->BackendNavigationsMenusItems_Model->ReadByMenusid($id);
		$data['template'] = 'navigations/backend/menus/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/menus/update'
		));
		$id = (int)$id;
		$data['DetailNavigationsMenus'] = $this->BackendNavigationsMenus_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailNavigationsMenus']) && !is_array($data['DetailNavigationsMenus']) && count($data['DetailNavigationsMenus']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('navigations/backend/menus/view');
		}
		$data['MenusItems'] = $this->BackendNavigationsMenusItems_Model->ReadByMenusid($id);
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Menu', 'trim|required');
			$this->form_validation->set_rules('href', 'Href', 'trim|required');
			$this->form_validation->set_rules('positionsid', 'Vị trí', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendNavigationsMenus_Model->UpdateByPost('id', $id, $this->fcUser);
				if($flag > 0){
					$this->BackendNavigationsMenusItems_Model->DeleteByMenusid($id);
					$this->BackendNavigationsMenusItems_Model->InsertBatchByMenusid($id);
					$this->session->set_flashdata('message-success', 'Cập nhật Menu thành công');
					redirect_custom('navigations/backend/menus/view');
				}
			}
		}
		$data['template'] = 'navigations/backend/menus/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'navigations/backend/menus/delete'
		));
		$id = (int)$id;
		$data['DetailNavigationsMenus'] = $this->BackendNavigationsMenus_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailNavigationsMenus']) && !is_array($data['DetailNavigationsMenus']) && count($data['DetailNavigationsMenus']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('navigations/backend/menus/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendNavigationsMenus_Model->DeleteByField('id', $id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa bài viết thành công');
				redirect('navigations/backend/menus/view');
			}
		}
		$data['template'] = 'navigations/backend/menus/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['menus'] = $this->BackendNavigationsMenus_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['menus'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('navigations_menus', $temp);
		redirect((!empty($redirect)) ? $redirect : 'navigations/backend/menus/view');
	}
}
