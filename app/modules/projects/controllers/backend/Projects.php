<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends FC_Controller{
	
	public $action;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendProjects_Model',
			'BackendProjectsCatalogues_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'projects_catalogues'));
		
		$this->action = array(
			'publish' => 'Xuất bản',
			'highlight' => 'Nổi bật'
		);
		
	}
	
	
	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/projects/view'
		));
		$page = (int)$page;
		$projects_id = '';
		$userid = 0;
		$where = '';
		$cataloguesid = $this->input->get('cataloguesid');
		$filter = $this->input->get('filter');
		if($cataloguesid > 0){
			$projects_id = catalogues_relationship($cataloguesid, 'projects', array('BackendProjects','BackendProjectsCatalogues'), 'projects_catalogues');
		}
		if(in_array('projects/backend/projects/limit', $this->fcUser['group']) == FALSE){
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
		
		$config['total_rows'] = $this->BackendProjects_Model->CountAll($projects_id, array('userid' => $userid,'where' => $where));
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('projects/backend/projects/view');
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
			$data['Listprojects'] = $this->BackendProjects_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $projects_id, array('userid' => $userid, 'where' => $where));	
		}
		$data['template'] = 'projects/backend/projects/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/projects/create'
		));
		if($this->input->post('create')){
			$attr = $this->input->post('attr');
			$data['tagsid'] = $this->input->post('tagsid');
			$data['avatar'] = $this->input->post('images');
			$data['catalogue'] = $this->input->post('catalogue'); // mảng danh mục
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'dự án', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
			$this->form_validation->set_rules('content', 'Nội dung', 'trim');
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
				
			
				
				$resultid = $this->BackendProjects_Model->Create($this->fcUser,$data['catalogue'], $album_data);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'projects/frontend/projects/view', $resultid, 'number');
					}
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'projects',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendProjects_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$this->BackendAttributes_Model->InsertAttr($resultid, $attr);
					$this->session->set_flashdata('message-success', 'Thêm dự án mới thành công');
					redirect('projects/backend/projects/view');
				}
			}
			$_attribute_cat = '';
			$radio_cat_checked = $this->input->post('att');
			$data['attr'] = $this->input->post('attr');
			$cat_checked = $this->BackendProjectsCatalogues_Model->ReadByField('id', $radio_cat_checked);
			$cat_checked = json_decode($cat_checked['attributes'], TRUE);
			$data['cat_checked'] = $cat_checked;
			// print_r($data['cat_checked']);die();
		}
		
		$data['attribute_catalogues'] = $this->BackendAttributesCatalogues_Model->AttributesCataloguesList(FALSE);
		if(isset($data['attribute_catalogues']) && is_array($data['attribute_catalogues']) && count($data['attribute_catalogues'])){
			foreach($data['attribute_catalogues'] as $key => $val){
				$data['attribute_catalogues'][$key]['attributes'] = $this->BackendAttributes_Model->ReadAtrributes($val['id']);
			}
		}
		
		$data['template'] = 'projects/backend/projects/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/projects/read'
		));
		$id = (int)$id;
		$data['DetailProjects'] = $this->BackendProjects_Model->ReadByField('id', $id);
		if(!isset($data['DetailProjects']) && !is_array($data['DetailProjects']) && count($data['DetailProjects']) == 0){
			$this->session->set_flashdata('message-danger', 'dự án không tồn tại');
			redirect_custom('projects/backend/projects/view');
		}
		$data['template'] = 'projects/backend/projects/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/projects/update'
		));
		$id = (int)$id;
		$data['DetailProjects'] = $this->BackendProjects_Model->ReadByField('id', $id);
		if(!isset($data['DetailProjects']) && !is_array($data['DetailProjects']) && count($data['DetailProjects']) == 0){
			$this->session->set_flashdata('message-danger', 'dự án không tồn tại');
			redirect_custom('projects/backend/projects/view');
		}
		$data['tagsid'] = $this->BackendTags_Model->ReadByModule($id, 'projects');
		$data['catalogue'] = json_decode($data['DetailProjects']['catalogues'], TRUE);
		
		$catalogues = $this->input->post('catalogue');
		if($this->input->post('update')){
			$attr = $this->input->post('attr');
			$data['cityPost'] = $this->input->post('cityid');
			// echo $cityPost;die();
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'dự án', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim|required');
			$this->form_validation->set_rules('content', 'Nội dung', 'trim|required');
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
				
				$flag = $this->BackendProjects_Model->UpdateByPost('id', $id, $this->fcUser, $catalogues, $album_data);
				if($flag > 0){
					$temp = '';
					foreach($catalogues as $key => $val){
						$temp[] = array(
							'modules' => 'projects',
							'modulesid' => $id,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendProjects_Model->_delete_batch('modulesid', $id,'catalogues_relationship','projects');
					$this->BackendProjects_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'projects/frontend/projects/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'projects/frontend/projects/view', $id, 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'projects/frontend/projects/view', $id, 'number');
					}
					$this->BackendTags_Model->DeleteByModule($id, 'projects');
					$this->BackendTags_Model->InsertByModule($id, 'projects');
					$this->BackendAttributes_Model->DeleteAttr($id);
					$this->BackendAttributes_Model->InsertAttr($id, $attr);
					$this->session->set_flashdata('message-success', 'Cập nhật dự án thành công');
					redirect_custom('projects/backend/projects/view');
				}
			}
			$_attribute_cat = '';
			$radio_cat_checked = $this->input->post('att');
			$data['attr'] = $this->input->post('attr');
			$cat_checked = $this->BackendProjectsCatalogues_Model->ReadByField('id', $radio_cat_checked);
			// print_r($cat_checked);die();
			$cat_checked = json_decode($cat_checked['attributes'], TRUE);
			$data['cat_checked'] = $cat_checked;
		}
		
		$_static_cat_checked = $this->BackendProjectsCatalogues_Model->ReadByField('id', $data['DetailProjects']['filterid']);
		
		$_static_cat_checked = json_decode($_static_cat_checked['attributes'], TRUE);
		$data['_static_cat_checked'] = $_static_cat_checked;
		// print_r($data['_static_cat_checked']);die();
		
		$data['attribute_catalogues'] = $this->BackendAttributesCatalogues_Model->AttributesCataloguesList(FALSE);
		if(isset($data['attribute_catalogues']) && is_array($data['attribute_catalogues']) && count($data['attribute_catalogues'])){
			foreach($data['attribute_catalogues'] as $key => $val){
				$data['attribute_catalogues'][$key]['attributes'] = $this->BackendAttributes_Model->ReadAtrributes($val['id']);
			}
		}
		$data['attribute_checked'] = $this->BackendAttributes_Model->AttributesChecked($id);
		if (!is_array($data['attribute_checked']) || count($data['attribute_checked']) < 0) {
			$data['attribute_checked'] = array('100000');
		}
		$data['template'] = 'projects/backend/projects/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'projects/backend/projects/delete'
		));
		$id = (int)$id;
		$data['DetailProjects'] = $this->BackendProjects_Model->ReadByField('id', $id);
		if(!isset($data['DetailProjects']) && !is_array($data['DetailProjects']) && count($data['DetailProjects']) == 0){
			$this->session->set_flashdata('message-danger', 'dự án không tồn tại');
			redirect_custom('projects/backend/projects/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendProjects_Model->DeleteByField('id', $id);
			if($flag > 0){
				if(!empty($data['DetailProjects']['canonical'])){
					$this->BackendRouters_Model->Delete($data['DetailProjects']['canonical'], 'projects/frontend/projects/view', $data['DetailProjects']['id'], 'number');
				}
				$this->BackendProjects_Model->_delete_relationship('projects', $id);
				$this->BackendTags_Model->DeleteByModule($id, 'projects');
				if ($DetailProjects['filterid'] != 0) {
					$this->BackendProjects_Model->delete_attribute($id);
				}
				
				$this->session->set_flashdata('message-success', 'Xóa dự án thành công');
				redirect('projects/backend/projects/view');
			}
		}
		$data['template'] = 'projects/backend/projects/delete';
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
	
	public function _Captcha(){
		$api_url = 'https://www.google.com/recaptcha/api/siteverify';
		$site_key = '6LcyQSsUAAAAAKAHCdEnd8Mz2hDD1WwrEpuF0cpK';
		$secret_key = '6LcyQSsUAAAAALUbUhvFreVHIcM1kolRc0ysUbfZ';
		
		
		$site_key_post  = $_POST['g-recaptcha-response'];
		 //lấy IP của khach
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$remoteip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$remoteip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$remoteip = $_SERVER['REMOTE_ADDR'];
		}
		 //tạo link kết nối
		$api_url = $api_url.'?secret='.$secret_key.'&response='.$site_key_post.'&remoteip='.$remoteip;
		//lấy kết quả trả về từ google
		$response = file_get_contents($api_url);
		//dữ liệu trả về dạng json
		$response = json_decode($response);
		if(!isset($response->success))
		{
			$this->form_validation->set_message('_Captcha','Captcha không chính xác');
			return false;
		}
		if($response->success == true)
		{
			return true;
		}else{
			$this->form_validation->set_message('_Captcha','Captcha không chính xác');
			return false;
		}
	}
	
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['projects'] = $this->BackendProjects_Model->ReadByField('id', $id);
		$temp[$type] = (($data['projects'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('projects', $temp);
		redirect((!empty($redirect)) ? $redirect : 'projects/backend/projects/view');
	}
}
