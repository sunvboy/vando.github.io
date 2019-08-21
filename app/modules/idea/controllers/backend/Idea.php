<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Idea extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendIdea_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendIdea_Model->countall($this->fclang, 0);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('idea/backend/idea/view');
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
			$data['listSupport'] = $this->BackendIdea_Model->view(($page * $config['per_page']), $config['per_page'], $this->fclang, 0);	
		}
		$data['template'] = 'idea/backend/idea/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		
		if($this->input->post('create')){
			$data['avatar'] = $this->input->post('images');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên đầy đủ', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendIdea_Model->create($this->fcUser, $this->fclang);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm  mới thành công');
					redirect('idea/backend/idea/view');
				}
			}
		}
		$data['template'] = 'idea/backend/idea/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function read($id = 0){
		
		$data['Detailaddress'] = $this->BackendIdea_Model->read($id, $this->fclang);
		if(!isset($data['Detailaddress']) && !is_array($data['Detailaddress']) && count($data['Detailaddress']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('idea/backend/idea/view');
		}
		
		$data['template'] = 'idea/backend/idea/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$id = (int)$id;
		$data['Detailaddress'] = $this->BackendIdea_Model->read($id, $this->fclang);
		if(!isset($data['Detailaddress']) && !is_array($data['Detailaddress']) && count($data['Detailaddress']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('idea/backend/idea/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên đầy đủ', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendIdea_Model->update($id, $this->fcUser);

				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật  thành công');
					redirect_custom('idea/backend/idea/view');
				}
			}
		}
		$data['template'] = 'idea/backend/idea/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['Detailaddress'] = $this->BackendIdea_Model->read($id, $this->fclang);
		if(!isset($data['Detailaddress']) && !is_array($data['Detailaddress']) && count($data['Detailaddress']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('idea/backend/idea/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendIdea_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa  thành công');
				redirect('idea/backend/idea/view');
			}
		}
		$data['template'] = 'idea/backend/idea/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['articles'] = $this->BackendIdea_Model->read($id, $this->fclang);
		$temp[$type] = (($data['articles'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('idea', $temp);
		redirect((!empty($redirect)) ? $redirect : 'idea/backend/idea/view');
	}
}
