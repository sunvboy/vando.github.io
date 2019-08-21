<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sanphamtangkem extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendSanphamtangkem_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'sanphamtangkem/backend/sanphamtangkem/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendSanphamtangkem_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('sanphamtangkem/backend/sanphamtangkem/view');
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
			$data['listSupport'] = $this->BackendSanphamtangkem_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'sanphamtangkem/backend/sanphamtangkem/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		$this->commonbie->Permissions(array(
			'uri' => 'sanphamtangkem/backend/sanphamtangkem/create'
		));
		if($this->input->post('create')){
			$data['avatar'] = $this->input->post('images');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên sản phẩm', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendSanphamtangkem_Model->create($this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm bản ghi mới thành công');
					redirect('sanphamtangkem/backend/sanphamtangkem/view');
				}
			}
		}
		$data['template'] = 'sanphamtangkem/backend/sanphamtangkem/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'sanphamtangkem/backend/sanphamtangkem/update'
		));
		$id = (int)$id;
		$data['DetailSanphamtangkem'] = $this->BackendSanphamtangkem_Model->read($id);
		if(!isset($data['DetailSanphamtangkem']) && !is_array($data['DetailSanphamtangkem']) && count($data['DetailSanphamtangkem']) == 0){
			$this->session->set_flashdata('message-danger', 'Bản ghi không tồn tại');
			redirect_custom('sanphamtangkem/backend/sanphamtangkem/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên sản phẩm', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendSanphamtangkem_Model->update($id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật bản ghi thành công');
					redirect_custom('sanphamtangkem/backend/sanphamtangkem/view');
				}
			}
		}
		$data['template'] = 'sanphamtangkem/backend/sanphamtangkem/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'sanphamtangkem/backend/sanphamtangkem/delete'
		));
		$id = (int)$id;
		$data['DetailSanphamtangkem'] = $this->BackendSanphamtangkem_Model->read($id);
		if(!isset($data['DetailSanphamtangkem']) && !is_array($data['DetailSanphamtangkem']) && count($data['DetailSanphamtangkem']) == 0){
			$this->session->set_flashdata('message-danger', 'Bản ghi không tồn tại');
			redirect_custom('sanphamtangkem/backend/sanphamtangkem/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendSanphamtangkem_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa bản ghi thành công');
				redirect('sanphamtangkem/backend/sanphamtangkem/view');
			}
		}
		$data['template'] = 'sanphamtangkem/backend/sanphamtangkem/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['Sanphamtangkem'] = $this->BackendSanphamtangkem_Model->read($id);
		$temp[$type] = (($data['Sanphamtangkem'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$this->db->where('id', $id);
		$this->db->update('products_sanphamtangkem', $temp);
		redirect((!empty($redirect)) ? $redirect : 'sanphamtangkem/backend/sanphamtangkem/view');
	}

}
