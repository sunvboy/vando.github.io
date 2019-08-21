<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendTeachers_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'teachers/backend/teachers/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendTeachers_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('teachers/backend/teachers/view');
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
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['listSupport'] = $this->BackendTeachers_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'teachers/backend/teachers/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		$this->commonbie->Permissions(array(
			'uri' => 'teachers/backend/teachers/create'
		));
		if($this->input->post('create')){
			$data['avatar'] = $this->input->post('images');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên giảng viên', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả ngắn', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendTeachers_Model->create($this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm bản ghi mới thành công');
					redirect('teachers/backend/teachers/view');
				}
			}
		}
		$data['template'] = 'teachers/backend/teachers/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'teachers/backend/teachers/update'
		));
		$id = (int)$id;
		$data['Detailteachers'] = $this->BackendTeachers_Model->read($id);
		if(!isset($data['Detailteachers']) && !is_array($data['Detailteachers']) && count($data['Detailteachers']) == 0){
			$this->session->set_flashdata('message-danger', 'Bản ghi không tồn tại');
			redirect_custom('teachers/backend/teachers/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên giảng viên', 'trim|required');
			$this->form_validation->set_rules('description', 'Mô tả ngắn', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendTeachers_Model->update($id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật bản ghi thành công');
					redirect_custom('teachers/backend/teachers/view');
				}
			}
		}
		$data['template'] = 'teachers/backend/teachers/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'teachers/backend/teachers/delete'
		));
		$id = (int)$id;
		$data['Detailteachers'] = $this->BackendTeachers_Model->read($id);
		if(!isset($data['Detailteachers']) && !is_array($data['Detailteachers']) && count($data['Detailteachers']) == 0){
			$this->session->set_flashdata('message-danger', 'Bản ghi không tồn tại');
			redirect_custom('teachers/backend/teachers/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendTeachers_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa bản ghi thành công');
				redirect('teachers/backend/teachers/view');
			}
		}
		$data['template'] = 'teachers/backend/teachers/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['teachers'] = $this->BackendTeachers_Model->read($id);
		$temp[$type] = (($data['teachers'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('teachers', $temp);
		redirect((!empty($redirect)) ? $redirect : 'teachers/backend/teachers/view');
	}

}
