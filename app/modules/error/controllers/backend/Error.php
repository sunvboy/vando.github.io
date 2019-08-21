<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendError_Model', 'products/BackendProducts_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendError_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('error/backend/error/view');
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
			$data['listError'] = $this->BackendError_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		
		
		$data['template'] = 'error/backend/error/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['error'] = $this->BackendError_Model->ReadByField('id', $id);
		$temp[$type] = (($data['error'][$type] == 1)?0:1);
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$temp['userid_updated'] = $this->fcUser['id'];
		$this->db->where('id', $id);
		$this->db->update('error_video', $temp);
		redirect((!empty($redirect)) ? $redirect : 'error/backend/error/view');
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['Detailerror'] = $this->BackendError_Model->ReadByField('id',$id);
		if(!isset($data['Detailerror']) && !is_array($data['Detailerror']) && count($data['Detailerror']) == 0){
			$this->session->set_flashdata('message-danger', 'Bản ghi không tồn tại');
			redirect_custom('error/backend/error/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendError_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa bản ghi thành công');
				redirect('error/backend/error/view');
			}
		}
		$data['template'] = 'error/backend/error/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
