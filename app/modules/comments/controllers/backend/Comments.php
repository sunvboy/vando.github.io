<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendComments_Model', 'products/BackendProducts_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$page = (int)$page;
		$config['total_rows'] = $this->BackendComments_Model->countall();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('comments/backend/comments/view');
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
			$data['listComment'] = $this->BackendComments_Model->view(($page * $config['per_page']), $config['per_page']);	
		}
		
		
		$data['template'] = 'comments/backend/comments/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['comments'] = $this->BackendComments_Model->ReadByField('id', $id);
		$temp[$type] = (($data['comments'][$type] == 1)?0:1);
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('comments', $temp);
		redirect((!empty($redirect)) ? $redirect : 'comments/backend/comments/view');
	}


	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'comments/backend/comments/update'
		));
		$id = (int)$id;
		$data['DetailComments'] = $this->BackendComments_Model->ReadByField('id', $id);
		if(!isset($data['DetailComments']) && !is_array($data['DetailComments']) && count($data['DetailComments']) == 0){
			$this->session->set_flashdata('message-danger', 'Bài viết không tồn tại');
			redirect_custom('comments/backend/comments/view');
		}

		if($this->input->post('update')){
			$message2 = $this->input->post('message2');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('message2', 'Nội dung trả lời', 'trim|required');
			if ($this->form_validation->run($this)){
				// $dataupdate = array(
				// 	'fullname' => $this->input->post('fullname'),
				// 	'publish' => $this->input->post('publish'),
				// );
				// $flag = $this->BackendComments_Model->UpdateByPost('id', $id, $dataupdate);
				// echo $flag;die;
				// if($flag > 0){
					// echo $this->db->last_query();die;
					if ($message2 != '') {
						$datafeild = array(
							'fullname'  => 'Quản trị viên',
							'message' => $message2, 
							'type' => 'cauhoi',
							'module' => $data['DetailComments']['module'],
							'moduleid' => $data['DetailComments']['moduleid'],
							'parentid' => $id, 
							'publish' => 1,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
							'userid_created' => $this->fcUser['id'],
						);
						$flag1 = $this->BackendComments_Model->Create($datafeild);

					}
					// echo $this->db->last_query();die;
					$this->session->set_flashdata('message-success', 'Cập nhật bài viết thành công');
					redirect_custom('comments/backend/comments/view');
				// }
			}
		}
		$data['template'] = 'comments/backend/comments/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}


	public function delete($id = 0){
		$id = (int)$id;
		$data['Detailcomments'] = $this->BackendComments_Model->ReadByField('id',$id);
		if(!isset($data['Detailcomments']) && !is_array($data['Detailcomments']) && count($data['Detailcomments']) == 0){
			$this->session->set_flashdata('message-danger', ' không tồn tại');
			redirect_custom('comments/backend/comments/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendComments_Model->delete($id);
			if($flag > 0){
				$this->session->set_flashdata('message-success', 'Xóa  thành công');
				redirect('comments/backend/comments/view');
			}
		}
		$data['template'] = 'comments/backend/comments/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
