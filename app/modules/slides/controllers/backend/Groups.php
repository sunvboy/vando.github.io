<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendSlides_Model',
			'BackendSlidesGroups_Model',
		));
		
		$this->load->library(array('ConfigBie'));
	}

	public function View($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendSlidesGroups_Model->Countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('slides/backend/groups/view');
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
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['listSlides'] = $this->BackendSlidesGroups_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $this->fclang);	
		}
		$data['template'] = 'slides/backend/groups/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên nhóm slide', 'trim|required');
			$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');

			$post = $this->input->post();
			$images_post = NULL;
			$images_count = (int)$post['images_count'];
			$data['images_count'] = $images_count;
			for ($i = 1; $i <= $images_count; $i++) {
				if (!empty($post['image'.$i])) {
					$images_post[] = array(
						'title' => $post['title'.$i],
						'image' 	  => $post['image'.$i],
						'url'   	  => $post['url'.$i],
						'order' 	  => $post['order'.$i],
						'description' => $post['description'.$i],
						'publish' => $post['publish'.$i],
					);
				}
			}
			$data['images_post'] = $images_post;
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendSlidesGroups_Model->Create($this->fcUser, $this->fclang);
				if($resultid > 0){
					if (isset($images_post) && is_array($images_post) && count($images_post)) {
						foreach ($images_post as $key => $value) {
							$this->BackendSlides_Model->Create($value, $resultid);
						}
					}
					$this->session->set_flashdata('message-success', 'Thêm nhóm slide mới thành công');
					redirect('slides/backend/groups/view');
				}
			}
		}
		$data['template'] = 'slides/backend/groups/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$id = (int)$id;
		$data['detailSlidesGroups'] = $this->BackendSlidesGroups_Model->ReadByField('id', $id);
		if(!isset($data['detailSlidesGroups']) && !is_array($data['detailSlidesGroups']) && count($data['detailSlidesGroups']) == 0){
			$this->session->set_flashdata('message-danger', 'Nhóm slide không tồn tại');
			redirect_custom('slides/backend/groups/view');
		}
		$data['template'] = 'slides/backend/groups/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$id = (int)$id;
		$data['detailSlidesGroups'] = $this->BackendSlidesGroups_Model->ReadByField('id', $id);
		if(!isset($data['detailSlidesGroups']) && !is_array($data['detailSlidesGroups']) && count($data['detailSlidesGroups']) == 0){
			$this->session->set_flashdata('message-danger', 'Nhóm slide không tồn tại');
			redirect_custom('slides/backend/groups/view');
		}

		$data['images_post'] = $this->BackendSlides_Model->ReadByField('groupsid', $id, $this->fclang);
		$data['images_count'] = $this->BackendSlides_Model->CountByField('groupsid', $id);

		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên nhóm slide', 'trim|required');
			$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim');

			$post = $this->input->post();
			$images_post = NULL;
			$images_count = (int)$post['images_count'];
			$data['images_count'] = $images_count;
			for ($i = 1; $i <= $images_count; $i++) {
				if (!empty($post['image'.$i])) {
					$images_post[] = array(
						'title' => $post['title'.$i],
						'image' 	  => $post['image'.$i],
						'url'   	  => $post['url'.$i],
						'order' 	  => $post['order'.$i],
						'description' => $post['description'.$i],
						'publish' => $post['publish'.$i],
					);
				}
			}
			$data['images_post'] = $images_post;
			// print_r($images_post);die;
			if ($this->form_validation->run()){
				$flag = $this->BackendSlidesGroups_Model->UpdateByPost('id', $id, $this->fcUser);
				if($flag > 0){
					if (isset($images_post) && is_array($images_post) && count($images_post)) {
						$this->BackendSlides_Model->DeleteByField('groupsid', $id, $this->fclang);
						foreach ($images_post as $key => $value) {
							$this->BackendSlides_Model->Create($value, $id, $this->fclang);
						}
					}
					$this->session->set_flashdata('message-success', 'Cập nhật nhóm slide thành công');
					redirect_custom('slides/backend/groups/view');
				}
			}
		}
		$data['template'] = 'slides/backend/groups/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['detailSlidesGroups'] = $this->BackendSlidesGroups_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['detailSlidesGroups']) && !is_array($data['detailSlidesGroups']) && count($data['detailSlidesGroups']) == 0){
			$this->session->set_flashdata('message-danger', 'Nhóm slide không tồn tại');
			redirect_custom('slides/backend/groups/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendSlidesGroups_Model->delete($id);
			if($flag > 0){
				$this->nestedsetbie->get();
				$this->nestedsetbie->recursive(0, $this->nestedsetbie->set());
				$this->nestedsetbie->action();
				$this->session->set_flashdata('message-success', 'Xóa nhóm slide thành công');
				redirect('slides/backend/groups/view');
			}
		}
		$data['template'] = 'slides/backend/groups/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['articles'] = $this->BackendSlidesGroups_Model->ReadByField('id', $id);
		$temp[$type] = (($data['articles'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('slides_groups', $temp);
		redirect((!empty($redirect)) ? $redirect : 'slides/backend/groups/view');
	}
}
