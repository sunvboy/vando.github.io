<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends FC_Controller{
	
	public $action;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendArticles_Model',
			'BackendArticlesCatalogues_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
			'address/BackendAddress_Model',
			'supports/BackendSupports_Model',
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'articles_catalogues'));
		
		$this->action = array(
			'publish' => 'Xuất bản',
			'highlight' => 'Nổi bật'
		);
		
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'articles/backend/articles/view'
		));
		$page = (int)$page;
		$articles_id = '';
		$userid = 0;
		$where = '';
		$cataloguesid = $this->input->get('cataloguesid');
		$filter = $this->input->get('filter');
		if($cataloguesid > 0){
			$articles_id = catalogues_relationship($cataloguesid, 'articles', array('BackendArticles','BackendArticlesCatalogues'), 'articles_catalogues');
		}
		if(in_array('articles/backend/articles/limit', $this->fcUser['group']) == FALSE){
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
		
		
		$config['total_rows'] = $this->BackendArticles_Model->CountAll($articles_id, array('userid' => $userid,'where' => $where), $this->fclang);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('articles/backend/articles/view');
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
			$data['ListArticles'] = $this->BackendArticles_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $articles_id, array('userid' => $userid, 'where' => $where), $this->fclang);	
		}
		$data['template'] = 'articles/backend/articles/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'articles/backend/articles/create'
		));
		if($this->input->post('create')){
			$data['tagsid'] = $this->input->post('tagsid');
			$data['avatar'] = $this->input->post('images');
			$data['catalogue'] = $this->input->post('catalogue'); // mảng danh mục
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Bài viết', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');
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


				$date = $this->input->post('date');
				$data_date = '';
				if(isset($date['start']) && is_array($date['start'])  && count($date['start'])) {
					foreach ($date['start'] as $key => $val) {
						$data_date[] = array('start' => $val); 
					}
				}
				if(isset($data_date) && is_array($data_date)  && count($data_date) && isset($date['end']) && is_array($date['end']) && count($date['end']) && isset($date['time']) && is_array($date['time']) && count($date['time']) && isset($date['address']) && is_array($date['address']) && count($date['address'])) {
					foreach ($data_date as $key => $val) {
						$data_date[$key]['end'] = $date['end'][$key];
						$data_date[$key]['time'] = $date['time'][$key];
						$data_date[$key]['address'] = $date['address'][$key];
					}
				}


				$resultid = $this->BackendArticles_Model->Create($this->fcUser, $data['catalogue'], $album_data, $data_date, $this->fclang);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'articles/frontend/articles/view', $resultid, 'number');
					}
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'articles',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendArticles_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$this->BackendTags_Model->InsertByModule($resultid, 'articles');
					$this->session->set_flashdata('message-success', 'Thêm bài viết mới thành công');
					redirect('articles/backend/articles/view');
				}
			}
		}
		$data['template'] = 'articles/backend/articles/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'articles/backend/articles/read'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendArticles_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('articles/backend/articles/view');
		}
		$data['template'] = 'articles/backend/articles/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'articles/backend/articles/update'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendArticles_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('articles/backend/articles/view');
		}
		$data['tagsid'] = $this->BackendTags_Model->ReadByModule($id, 'articles');
		$data['catalogue'] = json_decode($data['DetailArticles']['catalogues'], TRUE);
		$catalogues = $this->input->post('catalogue');
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Bài viết', 'trim|required');
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


				$date = $this->input->post('date');
				$data_date = '';
				if(isset($date['start']) && is_array($date['start'])  && count($date['start'])) {
					foreach ($date['start'] as $key => $val) {
						$data_date[] = array('start' => $val); 
					}
				}
				if(isset($data_date) && is_array($data_date)  && count($data_date) && isset($date['end']) && is_array($date['end']) && count($date['end']) && isset($date['time']) && is_array($date['time']) && count($date['time']) && isset($date['address']) && is_array($date['address']) && count($date['address'])) {
					foreach ($data_date as $key => $val) {
						$data_date[$key]['end'] = $date['end'][$key];
						$data_date[$key]['time'] = $date['time'][$key];
						$data_date[$key]['address'] = $date['address'][$key];
					}
				}


				$flag = $this->BackendArticles_Model->UpdateByPost('id', $id, $this->fcUser, $catalogues, $album_data, $data_date);
				if($flag > 0){
					
					$temp = '';
					foreach($catalogues as $key => $val){
						$temp[] = array(
							'modules' => 'articles',
							'modulesid' => $id,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendArticles_Model->_delete_batch('modulesid', $id,'catalogues_relationship', 'articles');
					$this->BackendArticles_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'articles/frontend/articles/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'articles/frontend/articles/view', $id, 'number');
					}
					else{
						$this->BackendRouters_Model->Delete($canonical, 'articles/frontend/articles/view', $id, 'number');
					}
					$this->BackendTags_Model->DeleteByModule($id, 'articles');
					$this->BackendTags_Model->InsertByModule($id, 'articles');
					$this->session->set_flashdata('message-success', 'Cập nhật bài viết thành công');
					redirect_custom('articles/backend/articles/view');
				}
			}
		}
		$data['template'] = 'articles/backend/articles/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'articles/backend/articles/delete'
		));
		$id = (int)$id;
		$data['DetailArticles'] = $this->BackendArticles_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailArticles']) && !is_array($data['DetailArticles']) && count($data['DetailArticles']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('articles/backend/articles/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendArticles_Model->DeleteByField('id', $id);
			if($flag > 0){
				if(!empty($data['DetailArticles']['canonical'])){
					$this->BackendRouters_Model->Delete($data['DetailArticles']['canonical'], 'articles/frontend/articles/view', $data['DetailArticles']['id'], 'number');
				}
				$this->BackendArticles_Model->_delete_relationship('articles', $id);
				$this->BackendTags_Model->DeleteByModule($id, 'articles');
				$this->session->set_flashdata('message-success', 'Xóa bài viết thành công');
				redirect('articles/backend/articles/view');
			}
		}
		$data['template'] = 'articles/backend/articles/delete';
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
		$data['articles'] = $this->BackendArticles_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['articles'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('articles', $temp);
		redirect((!empty($redirect)) ? $redirect : 'articles/backend/articles/view');
	}
}
