<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mailsubricre extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->fclang = $this->config->item('fclang');
		$this->load->model(array('Backendmailsubricre_Model', 'products/BackendProducts_Model', 'address/Backendaddress_Model'));
		$this->load->library(array('configBie'));
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->Backendmailsubricre_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('mailsubricre/backend/mailsubricre/view');
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
			$data['listemail'] = $this->Backendmailsubricre_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		// echo $this->db->last_query();
		$data['template'] = 'mailsubricre/backend/mailsubricre/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			if ($this->form_validation->run()){
				$flag = $this->Backendmailsubricre_Model->create();
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm  mới thành công');
					redirect('mailsubricre/backend/mailsubricre/view');
				}
			}
		}
		$data['template'] = 'mailsubricre/backend/mailsubricre/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function read($id = 0){
		
		$data['Detailmailsubricre'] = $this->Backendmailsubricre_Model->read($id);
		if(!isset($data['Detailmailsubricre']) && !is_array($data['Detailmailsubricre']) && count($data['Detailmailsubricre']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('mailsubricre/backend/mailsubricre/view');
		}
		
		$data['template'] = 'mailsubricre/backend/mailsubricre/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$id = (int)$id;
		$data['Detailmailsubricre'] = $this->Backendmailsubricre_Model->read($id);
		if(!isset($data['Detailmailsubricre']) && !is_array($data['Detailmailsubricre']) && count($data['Detailmailsubricre']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('mailsubricre/backend/mailsubricre/view');
		}
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			if ($this->form_validation->run()){
				$flag = $this->Backendmailsubricre_Model->update($id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật  thành công');
					redirect_custom('mailsubricre/backend/mailsubricre/view');
				}
			}
		}
		$data['template'] = 'mailsubricre/backend/mailsubricre/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function delete($id = 0){
		$id = (int)$id;
		$data['Detailmailsubricre'] = $this->Backendmailsubricre_Model->read($id);
		if(!isset($data['Detailmailsubricre']) && !is_array($data['Detailmailsubricre']) && count($data['Detailmailsubricre']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('mailsubricre/backend/mailsubricre/view');
		}
		if($this->input->post('delete')){
			$flag = $this->Backendmailsubricre_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa  thành công');
				redirect('mailsubricre/backend/mailsubricre/view');
			}
		}
		$data['template'] = 'mailsubricre/backend/mailsubricre/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;

		$data['mailsubricre'] = $this->Backendmailsubricre_Model->ReadByField('id', $id);
		
		// echo $data['mailsubricre'][$type];die;
		$temp[$type] = (($data['mailsubricre'][$type] == 0) ? 1 : 0);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);

		$this->db->where('id', $id);
		$this->db->update('mailsubricre', $temp);
		redirect((!empty($redirect)) ? $redirect : 'mailsubricre/backend/mailsubricre/view');
	}
}
