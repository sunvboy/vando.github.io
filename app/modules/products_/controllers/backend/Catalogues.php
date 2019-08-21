<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendProductsCatalogues_Model',
			'BackendProducts_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'products_catalogues'));
		
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/catalogues/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendProductsCatalogues_Model->CountAll($this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('products/backend/catalogues/view');
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
			$data['Listproducts'] = $this->BackendProductsCatalogues_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $this->fclang);	
		}
		$data['template'] = 'products/backend/catalogues/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/catalogues/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục sản phẩm', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				
				$album = $this->input->post('album');
				$album_data = '';
				if(isset($album['images']) && is_array($album['images'])  && count($album['images'])) {
					foreach ($album['images'] as $key => $val) {
						$album_data[] = array('images' => $val); 
					}
				}
				if(isset($album_data) && is_array($album_data)  && count($album_data) && isset($album['title']) && is_array($album['title']) && count($album['title']) && isset($album['description']) && is_array($album['description']) && count($album['description'])) {
					foreach ($album_data as $key => $val) {
						$album_data[$key]['title'] = $album['title'][$key];
						$album_data[$key]['description'] = $album['description'][$key];
					}
				}

				$video = $this->input->post('video');
				$video_data = '';
				if(isset($video['images']) && is_array($video['images'])  && count($video['images'])) {
					foreach ($video['images'] as $key => $val) {
						$video_data[] = array('images' => $val); 
					}
				}
				if(isset($video_data) && is_array($video_data)  && count($video_data) && isset($video['title']) && is_array($video['title']) && count($video['title']) && isset($video['description']) && is_array($video['description']) && count($video['description'])) {
					foreach ($video_data as $key => $val) {
						$video_data[$key]['title'] = $video['title'][$key];
						$video_data[$key]['description'] = $video['description'][$key];
					}
				}

				$resultid = $this->BackendProductsCatalogues_Model->Create($this->fcUser, $album_data, $video_data, $this->fclang);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'products/frontend/catalogues/view', $resultid, 'number');
					}
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Thêm danh mục sản phẩm mới thành công');
					redirect('products/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'products/backend/catalogues/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/catalogues/read'
		));
		$id = (int)$id;
		$data['DetailProductsCatalogues'] = $this->BackendProductsCatalogues_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailProductsCatalogues']) && !is_array($data['DetailProductsCatalogues']) && count($data['DetailProductsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục sản phẩm không tồn tại');
			redirect_custom('products/backend/catalogues/view');
		}
		$data['template'] = 'products/backend/catalogues/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/catalogues/update'
		));
		$id = (int)$id;
		$data['DetailProductsCatalogues'] = $this->BackendProductsCatalogues_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailProductsCatalogues']) && !is_array($data['DetailProductsCatalogues']) && count($data['DetailProductsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục sản phẩm không tồn tại');
			redirect_custom('products/backend/catalogues/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Danh mục sản phẩm', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){

				$album = $this->input->post('album');
				$album_data = '';
				if(isset($album['images']) && is_array($album['images'])  && count($album['images'])) {
					foreach ($album['images'] as $key => $val) {
						$album_data[] = array('images' => $val); 
					}
				}
				if(isset($album_data) && is_array($album_data)  && count($album_data) && isset($album['title']) && is_array($album['title']) && count($album['title']) && isset($album['description']) && is_array($album['description']) && count($album['description'])) {
					foreach ($album_data as $key => $val) {
						$album_data[$key]['title'] = $album['title'][$key];
						$album_data[$key]['description'] = $album['description'][$key];
					}
				}


				$video = $this->input->post('video');
				$video_data = '';
				if(isset($video['images']) && is_array($video['images'])  && count($video['images'])) {
					foreach ($video['images'] as $key => $val) {
						$video_data[] = array('images' => $val); 
					}
				}
				if(isset($video_data) && is_array($video_data)  && count($video_data) && isset($video['title']) && is_array($video['title']) && count($video['title']) && isset($video['description']) && is_array($video['description']) && count($video['description'])) {
					foreach ($video_data as $key => $val) {
						$video_data[$key]['title'] = $video['title'][$key];
						$video_data[$key]['description'] = $video['description'][$key];
					}
				}

				$flag = $this->BackendProductsCatalogues_Model->UpdateByPost(array('id'=> $id, 'user' => $this->fcUser), $album_data, $video_data);
				if($flag > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'products/frontend/catalogues/view', $data['DetailProductsCatalogues']['id'], 'number');
						$this->BackendRouters_Model->Create($canonical, 'products/frontend/catalogues/view', $data['DetailProductsCatalogues']['id'], 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'products/frontend/catalogues/view', $data['DetailProductsCatalogues']['id'], 'number');
					}
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Cập nhật Danh mục sản phẩm thành công');
					redirect_custom('products/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'products/backend/catalogues/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/catalogues/delete'
		));
		$id = (int)$id;
		$data['DetailProductsCatalogues'] = $this->BackendProductsCatalogues_Model->ReadByField('id', $id, $this->fclang);
		
		if(!isset($data['DetailProductsCatalogues']) && !is_array($data['DetailProductsCatalogues']) && count($data['DetailProductsCatalogues']) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục sản phẩm không tồn tại');
			redirect_custom('products/backend/catalogues/view');
		}
		if($data['DetailProductsCatalogues']['rgt'] - $data['DetailProductsCatalogues']['lft'] > 1){
			$this->session->set_flashdata('message-danger', 'Cần phải xóa các danh mục con trước');
			redirect_custom('products/backend/catalogues/view');
		}
		
		if($this->input->post('delete')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('cataloguesid', 'Danh mục', 'trim|required|callback__Count');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendProductsCatalogues_Model->DeleteByField('id', $id);
				if($flag > 0){
					// /*Xóa những sản phẩm chỉ nhận danh mục này làm cha*/
					// $products_id = catalogues_relationship($data['DetailProductsCatalogues']['id'], 'products', array('Backendproducts','BackendproductsCatalogues'), 'products_catalogues');
					// $_delete_ = check_delete($products_id, 'products');
					/* ------------------------------------------------*/
					/* Xóa đường dẫn trong routers */
					$this->BackendRouters_Model->Delete($data['DetailProductsCatalogues']['canonical'], 'products/frontend/catalogues/view', $data['DetailProductsCatalogues']['id'], 'number');	
					/* -----------------------------*/
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
					$this->session->set_flashdata('message-success', 'Xóa Danh mục sản phẩm thành công');
					redirect('products/backend/catalogues/view');
				}
			}
		}
		$data['template'] = 'products/backend/catalogues/delete';
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
		$data['products'] = $this->BackendProductsCatalogues_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['products'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('products_catalogues', $temp);
		redirect((!empty($redirect)) ? $redirect : 'products/backend/catalogues/view');
	}
	public function _Count(){
		$id = $this->input->post('cataloguesid');
		$DetailCatalogues =  $this->BackendProductsCatalogues_Model->ReadByField('id', $id, $this->fclang);
		$count = $this->FrontendProducts_Model->_count(array(
			'select' => '`pr`.`id`',
			'modules' => 'products',
		), $DetailCatalogues);
		
		if($count > 0){
			$this->form_validation->set_message('_Count', 'Danh mục vẫn còn sản phẩm, hãy chắc chắn rằng bạn đã xóa hết sản phẩm trước khi xóa danh mục');
			return FALSE;
		}
		return TRUE;
	}
}
