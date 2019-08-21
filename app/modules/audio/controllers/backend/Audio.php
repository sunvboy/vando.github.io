<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audio extends FC_Controller{
	
	public $action;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendAudio_Model',
			'BackendAudioCatalogues_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'audio_catalogues'));
		
		$this->action = array(
			'publish' => 'Xuất bản',
			'highlight' => 'Nổi bật'
		);
		
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'audio/backend/audio/view'
		));
		$page = (int)$page;
		$Audio_id = '';
		$userid = 0;
		$where = '';
		$cataloguesid = $this->input->get('cataloguesid');
		$filter = $this->input->get('filter');
		if($cataloguesid > 0){
			$Audio_id = catalogues_relationship($cataloguesid, 'audio', array('BackendAudio','BackendAudioCatalogues'), 'audio_catalogues');
		}
		if(in_array('audio/backend/audio/limit', $this->fcUser['group']) == FALSE){
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
		
		
		$config['total_rows'] = $this->BackendAudio_Model->CountAll($Audio_id, array('userid' => $userid,'where' => $where), $this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('audio/backend/audio/view');
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
			$data['ListAudio'] = $this->BackendAudio_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $Audio_id, array('userid' => $userid, 'where' => $where), $this->fclang);	
		}
		$data['template'] = 'audio/backend/audio/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'audio/backend/audio/create'
		));
		if($this->input->post('create')){
			$data['tagsid'] = $this->input->post('tagsid');
			$data['avatar'] = $this->input->post('images');
			$data['catalogue'] = $this->input->post('catalogue'); // mảng danh mục
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tiêu đề audio', 'trim|required');
			// $this->form_validation->set_rules('Audio_code', 'Liên kết video', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendAudio_Model->Create($this->fcUser,$data['catalogue'], $this->fclang);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'audio/frontend/audio/view', $resultid, 'number');
					}
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'audio',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendAudio_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$this->BackendTags_Model->InsertByModule($resultid, 'audio');
					$this->session->set_flashdata('message-success', 'Thêm bài viết mới thành công');
					redirect('audio/backend/audio/view');
				}
			}
		}
		$data['template'] = 'audio/backend/audio/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'audio/backend/audio/read'
		));
		$id = (int)$id;
		$data['DetailAudio'] = $this->BackendAudio_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailAudio']) && !is_array($data['DetailAudio']) && count($data['DetailAudio']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('audio/backend/audio/view');
		}
		$data['template'] = 'audio/backend/audio/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'audio/backend/audio/update'
		));
		$id = (int)$id;
		$data['DetailAudio'] = $this->BackendAudio_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailAudio']) && !is_array($data['DetailAudio']) && count($data['DetailAudio']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('audio/backend/audio/view');
		}
		$data['tagsid'] = $this->BackendTags_Model->ReadByModule($id, 'audio');
		$data['catalogue'] = json_decode($data['DetailAudio']['catalogues'], TRUE);
		$catalogues = $this->input->post('catalogue');
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tiêu đề audio', 'trim|required');
			// $this->form_validation->set_rules('Audio_code', 'Liên kết video', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			if ($this->form_validation->run($this)){
				$flag = $this->BackendAudio_Model->UpdateByPost('id', $id, $this->fcUser, $catalogues);
				if($flag > 0){
					
					$temp = '';
					foreach($catalogues as $key => $val){
						$temp[] = array(
							'modules' => 'audio',
							'modulesid' => $id,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendAudio_Model->_delete_batch('modulesid', $id,'catalogues_relationship', 'audio');
					$this->BackendAudio_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'audio/frontend/audio/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'audio/frontend/audio/view', $id, 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'audio/frontend/audio/view', $id, 'number');
					}
					$this->BackendTags_Model->DeleteByModule($id, 'audio');
					$this->BackendTags_Model->InsertByModule($id, 'audio');
					$this->session->set_flashdata('message-success', 'Cập nhật bài viết thành công');
					redirect_custom('audio/backend/audio/view');
				}
			}
		}
		$data['template'] = 'audio/backend/audio/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'audio/backend/audio/delete'
		));
		$id = (int)$id;
		$data['DetailAudio'] = $this->BackendAudio_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailAudio']) && !is_array($data['DetailAudio']) && count($data['DetailAudio']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('audio/backend/audio/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendAudio_Model->DeleteByField('id', $id, $this->fclang);
			if($flag > 0){
				if(!empty($data['DetailAudio']['canonical'])){
					$this->BackendRouters_Model->Delete($data['DetailAudio']['canonical'], 'audio/frontend/audio/view', $data['DetailAudio']['id'], 'number');
				}
				$this->BackendAudio_Model->_delete_relationship('audio', $id);
				$this->BackendTags_Model->DeleteByModule($id, 'audio');
				$this->session->set_flashdata('message-success', 'Xóa bài viết thành công');
				redirect('audio/backend/audio/view');
			}
		}
		$data['template'] = 'audio/backend/audio/delete';
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
		$data['audio'] = $this->BackendAudio_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['audio'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('audio', $temp);
		redirect((!empty($redirect)) ? $redirect : 'audio/backend/audio/view');
	}
}
