<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends FC_Controller{
	
	public $action;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendVideos_Model',
			'BackendVideosCatalogues_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
			'products/BackendProducts_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'videos_catalogues'));
		
		$this->action = array(
			'publish' => 'Xuất bản',
			'highlight' => 'Nổi bật'
		);
		
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'videos/backend/videos/view'
		));
		$page = (int)$page;
		$videos_id = '';
		$userid = 0;
		$where = '';
		$cataloguesid = $this->input->get('cataloguesid');
		$filter = $this->input->get('filter');
		if($cataloguesid > 0){
			$videos_id = catalogues_relationship($cataloguesid, 'videos', array('BackendVideos','BackendVideosCatalogues'), 'videos_catalogues');
		}
		if(in_array('videos/backend/videos/limit', $this->fcUser['group']) == FALSE){
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
		
		
		$config['total_rows'] = $this->BackendVideos_Model->CountAll($videos_id, array('userid' => $userid,'where' => $where), $this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('videos/backend/videos/view');
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
			$data['ListVideos'] = $this->BackendVideos_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $videos_id, array('userid' => $userid, 'where' => $where), $this->fclang);	
		}
		$data['template'] = 'videos/backend/videos/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'videos/backend/videos/create'
		));
		if($this->input->post('create')){
			$data['tagsid'] = $this->input->post('tagsid');
			$data['avatar'] = $this->input->post('images');
			$data['catalogue'] = $this->input->post('catalogue'); // mảng danh mục
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Bài viết', 'trim|required');
			// $this->form_validation->set_rules('videos_code', 'Liên kết video', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			// $this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendVideos_Model->Create($this->fcUser,$data['catalogue'], $this->fclang);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'videos/frontend/videos/view', $resultid, 'number');
					}
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'videos',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendVideos_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$this->BackendTags_Model->InsertByModule($resultid, 'videos');
					$this->session->set_flashdata('message-success', 'Thêm bài viết mới thành công');
					redirect('videos/backend/videos/view');
				}
			}
		}
		$data['template'] = 'videos/backend/videos/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'videos/backend/videos/read'
		));
		$id = (int)$id;
		$data['DetailVideos'] = $this->BackendVideos_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailVideos']) && !is_array($data['DetailVideos']) && count($data['DetailVideos']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('videos/backend/videos/view');
		}
		$data['template'] = 'videos/backend/videos/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'videos/backend/videos/update'
		));
		$id = (int)$id;
		$data['DetailVideos'] = $this->BackendVideos_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailVideos']) && !is_array($data['DetailVideos']) && count($data['DetailVideos']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('videos/backend/videos/view');
		}
		$data['tagsid'] = $this->BackendTags_Model->ReadByModule($id, 'videos');
		$data['catalogue'] = json_decode($data['DetailVideos']['catalogues'], TRUE);
		$catalogues = $this->input->post('catalogue');
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Video', 'trim|required');
			// $this->form_validation->set_rules('videos_code', 'Liên kết video', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			// $this->form_validation->set_rules('description', 'Mô tả', 'trim');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendVideos_Model->UpdateByPost('id', $id, $this->fcUser, $catalogues);
				if($flag > 0){
					
					$temp = '';
					foreach($catalogues as $key => $val){
						$temp[] = array(
							'modules' => 'videos',
							'modulesid' => $id,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendVideos_Model->_delete_batch('modulesid', $id,'catalogues_relationship', 'videos');
					$this->BackendVideos_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'videos/frontend/videos/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'videos/frontend/videos/view', $id, 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'videos/frontend/videos/view', $id, 'number');
					}
					$this->BackendTags_Model->DeleteByModule($id, 'videos');
					$this->BackendTags_Model->InsertByModule($id, 'videos');
					$this->session->set_flashdata('message-success', 'Cập nhật bài viết thành công');
					redirect_custom('videos/backend/videos/view');
				}
			}
		}
		$data['template'] = 'videos/backend/videos/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'videos/backend/videos/delete'
		));
		$id = (int)$id;
		$data['DetailVideos'] = $this->BackendVideos_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailVideos']) && !is_array($data['DetailVideos']) && count($data['DetailVideos']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('videos/backend/videos/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendVideos_Model->DeleteByField('id', $id, $this->fclang);
			if($flag > 0){
				if(!empty($data['DetailVideos']['canonical'])){
					$this->BackendRouters_Model->Delete($data['DetailVideos']['canonical'], 'videos/frontend/videos/view', $data['DetailVideos']['id'], 'number');
				}
				$this->BackendVideos_Model->_delete_relationship('videos', $id);
				$this->BackendTags_Model->DeleteByModule($id, 'videos');
				$this->session->set_flashdata('message-success', 'Xóa bài viết thành công');
				redirect('videos/backend/videos/view');
			}
		}
		$data['template'] = 'videos/backend/videos/delete';
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
		$data['videos'] = $this->BackendVideos_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['videos'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('videos', $temp);
		redirect((!empty($redirect)) ? $redirect : 'videos/backend/videos/view');
	}
}
