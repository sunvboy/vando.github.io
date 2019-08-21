<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Icon extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendIcon_Model',
		));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendIcon_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('comments/backend/icon/view');
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
			$data['listComment'] = $this->BackendIcon_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		
		
		$data['template'] = 'comments/backend/icon/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		if($this->input->post('create')){

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên đầy đủ', 'trim|required');
			$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required');
			$this->form_validation->set_rules('url', 'Đường dẫn ảnh', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendIcon_Model->create($this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm  mới thành công');
					redirect('comments/backend/icon/view');
				}
			}
		}
		$data['template'] = 'comments/backend/icon/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$id = (int)$id;
		$data['Detailcomments'] = $this->BackendIcon_Model->read($id);
		if(!isset($data['Detailcomments']) && !is_array($data['Detailcomments']) && count($data['Detailcomments']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('comments/backend/icon/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên đầy đủ', 'trim|required');
			$this->form_validation->set_rules('keyword', 'Từ khóa', 'trim|required');
			$this->form_validation->set_rules('url', 'Đường dẫn ảnh', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendIcon_Model->update('id', $id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật  thành công');
					redirect_custom('comments/backend/icon/view');
				}
			}
		}
		$data['template'] = 'comments/backend/icon/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['comments'] = $this->BackendIcon_Model->ReadByField('id', $id);
		$temp[$type] = (($data['comments'][$type] == 1)?0:1);
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('comments', $temp);
		redirect((!empty($redirect)) ? $redirect : 'comments/backend/icon/view');
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['Detailcomments'] = $this->BackendIcon_Model->ReadByField('id',$id);
		if(!isset($data['Detailcomments']) && !is_array($data['Detailcomments']) && count($data['Detailcomments']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('comments/backend/icon/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendIcon_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa  thành công');
				redirect('comments/backend/icon/view');
			}
		}
		$data['template'] = 'comments/backend/icon/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
