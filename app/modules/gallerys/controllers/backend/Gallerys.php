<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallerys extends FC_Controller{
	
	public $action;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendGallerys_Model',
			'BackendGallerysCatalogues_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'gallerys_catalogues'));
		
		$this->action = array(
			'publish' => 'Xuất bản',
			'highlight' => 'Nổi bật'
		);
		
	}

	public function View($page = 1){

		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/gallerys/view'
		));
		$page = (int)$page;
		$articles_id = '';
		$userid = 0;
		$where = '';
		$cataloguesid = $this->input->get('cataloguesid');
		$filter = $this->input->get('filter');
		if($cataloguesid > 0){
			$articles_id = catalogues_relationship($cataloguesid, 'gallerys', array('BackendGallerys','BackendGallerysCatalogues'), 'gallerys_catalogues');
		}
		if(in_array('gallerys/backend/gallerys/limit', $this->fcUser['group']) == FALSE){
			$userid = $this->fcUser['id'];
		}
		if(isset($this->action[$filter])){
			$where = array($filter => 1);
		}else{
			$prefix = substr($filter, 2);
			if(!empty($prefix)){
				$where = array($prefix.'<=' => 0);
			}
		}
		$config['total_rows'] = $this->BackendGallerys_Model->CountAll($articles_id, array('userid' => $userid,'where' => $where), $this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('gallerys/backend/gallerys/view');
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
			$data['ListGallerys'] = $this->BackendGallerys_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $articles_id, array('userid' => $userid, 'where' => $where), $this->fclang);	
		}
		
		$data['template'] = 'gallerys/backend/gallerys/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/gallerys/create'
		));
		if($this->input->post('create')){
			$data['tagsid'] = $this->input->post('tagsid');
			$data['avatar'] = $this->input->post('images');
			$data['catalogue'] = $this->input->post('catalogue'); // mảng danh mục
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Album', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
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

				$resultid = $this->BackendGallerys_Model->Create($this->fcUser,$data['catalogue'], $album_data, $this->fclang);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'gallerys/frontend/gallerys/view', $resultid, 'number');
					}
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'gallerys',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendGallerys_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$this->BackendTags_Model->InsertByModule($resultid, 'gallerys');
					$this->session->set_flashdata('message-success', 'Thêm bài album ảnh mới thành công');
					redirect('gallerys/backend/gallerys/view');
				}
			}
		}
		$data['template'] = 'gallerys/backend/gallerys/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/gallerys/read'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendGallerys_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Album ảnh không tồn tại');
			redirect_custom('gallerys/backend/gallerys/view');
		}
		$data['template'] = 'gallerys/backend/gallerys/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/gallerys/update'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendGallerys_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Album ảnh không tồn tại');
			redirect_custom('gallerys/backend/gallerys/view');
		}
		$data['tagsid'] = $this->BackendTags_Model->ReadByModule($id, 'gallerys');
		$data['catalogue'] = json_decode($data['DetailArticles']['catalogues'], TRUE);
		$catalogues = $this->input->post('catalogue');
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Bài viết', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			// $this->form_validation->set_rules('description', 'Mô tả', 'trim|required');
			if ($this->form_validation->run($this)){

				$album = $this->input->post('album');
			// var_dump($album);die;
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
				// $resultid = $this->BackendGallerys_Model->Create($this->fcUser,$data['catalogue'], $album_data);
				$flag = $this->BackendGallerys_Model->UpdateByPost('id', $id, $this->fcUser,$catalogues, $album_data);
				if($flag > 0){
					
					$temp = '';
					foreach($catalogues as $key => $val){
						$temp[] = array(
							'modules' => 'gallerys',
							'modulesid' => $id,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendGallerys_Model->_delete_batch('modulesid', $id,'catalogues_relationship', 'gallerys');
					$this->BackendGallerys_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'gallerys/frontend/gallerys/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'gallerys/frontend/gallerys/view', $id, 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'gallerys/frontend/gallerys/view', $id, 'number');
					}
					$this->BackendTags_Model->DeleteByModule($id, 'gallerys');
					$this->BackendTags_Model->InsertByModule($id, 'gallerys');
					$this->session->set_flashdata('message-success', 'Cập nhật album ảnh thành công');
					redirect_custom('gallerys/backend/gallerys/view');
				}
			}
		}
		$data['template'] = 'gallerys/backend/gallerys/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'gallerys/backend/gallerys/delete'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendGallerys_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('gallerys/backend/gallerys/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendGallerys_Model->DeleteByField('id', $id);
			if($flag > 0){
				if(!empty($data['DetailArticles']['canonical'])){
					$this->BackendRouters_Model->Delete($data['DetailArticles']['canonical'], 'gallerys/frontend/gallerys/view', $data['DetailArticles']['id'], 'number');
				}
				$this->BackendGallerys_Model->_delete_relationship('gallerys', $id);
				$this->BackendTags_Model->DeleteByModule($id, 'gallerys');
				$this->session->set_flashdata('message-success', 'Xóa bài viết thành công');
				redirect('gallerys/backend/gallerys/view');
			}
		}
		$data['template'] = 'gallerys/backend/gallerys/delete';
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
		$data['gallerys'] = $this->BackendGallerys_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['gallerys'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('gallerys', $temp);
		redirect((!empty($redirect)) ? $redirect : 'gallerys/backend/gallerys/view');
	}
}
