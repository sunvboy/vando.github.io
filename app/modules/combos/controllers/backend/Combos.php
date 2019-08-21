<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Combos extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');

		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendCombos_Model','products/BackendProducts_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendCombos_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('combos/backend/combos/view');
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
			$data['listCombos'] = $this->BackendCombos_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'combos/backend/combos/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên Combo', 'trim|required');
			$this->form_validation->set_rules('saleoff', 'Giá combo', 'trim|required');
			$this->form_validation->set_rules('parentid', 'Sản phẩm chính', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendCombos_Model->create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm  mới thành công');
					redirect('combos/backend/combos/view');
				}
			}
		}
		$data['template'] = 'combos/backend/combos/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}


	public function update($id = 0){
		$id = (int)$id;
		$data['DetailCombos'] = $this->BackendCombos_Model->read($id);
//		$data['data'] = json_decode($data['DetailCombos']['data'], TRUE);
		if(!isset($data['DetailCombos']) && !is_array($data['DetailCombos']) && count($data['DetailCombos']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('combos/backend/combos/view');
		}
		if($this->input->post('update')){
			$data['data'] = $this->input->post('data');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tên Combo', 'trim|required');
			$this->form_validation->set_rules('saleoff', 'Giá combo', 'trim|required');
			$this->form_validation->set_rules('parentid', 'Sản phẩm chính', 'trim|required');
			if ($this->form_validation->run()){
				$flag = $this->BackendCombos_Model->update($id);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật  thành công');
					redirect_custom('combos/backend/combos/view');
				}
			}
		}
		$data['template'] = 'combos/backend/combos/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['DetailCombos'] = $this->BackendCombos_Model->read($id);
		if(!isset($data['DetailCombos']) && !is_array($data['DetailCombos']) && count($data['DetailCombos']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('combos/backend/combos/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendCombos_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa  thành công');
				redirect('combos/backend/combos/view');
			}
		}
		$data['template'] = 'combos/backend/combos/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
