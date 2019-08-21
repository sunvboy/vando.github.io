<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcCustomer = $this->config->item('fcCustomer');
		$this->load->model(array('BackendComments_Model','FrontendComments_Model'));
		$this->load->library('ConfigBie');
	}

	public function addquestion(){
		$module = $this->input->post('module');
		$moduleid = $this->input->post('moduleid');
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		$this->form_validation->set_rules('fullname', 'Họ và tên', 'trim|required');
		$this->form_validation->set_rules('email', 'Đại chỉ email', 'trim|required');
		$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
		$this->form_validation->set_rules('message', 'Nội dung đánh giá', 'trim|required');
		if ($this->form_validation->run($this)){
			$post = $this->input->post('post');
			$data = '';
			if(isset($post) && is_array($post) && count($post)){
				foreach($post as $key => $val){
					$data[$val['name']] = nl2br($val['value']) ;
				}
			}else{
				$data['message'] = $this->input->post('message');
			}
			$data['module'] = $module;
			$data['moduleid'] = $moduleid;
			$data['customersid'] = $this->fcCustomer['id'];
			$data['publish'] = 1;
			$data['created'] = gmdate('Y-m-d H:i:s', time() + 7*3600);

			if(isset($data) && is_array($data) && count($data)){
				$this->db->insert('questions', $data);
				$this->db->flush_cache();
			}
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}

	public function listQuestion(){
		$module = $this->input->post('module');
		$moduleid = $this->input->post('moduleid');

		$listQuestion = $this->FrontendComments_Model->ViewQuestions($module, $moduleid, $this->fcCustomer['id']);

		$html = '';
		if(isset($listQuestion) && is_array($listQuestion) && count($listQuestion)){
			$html = $html . '<div class="box_scroll">';
				foreach($listQuestion as $key => $val){
					$html = $html . '<div class="item-comments mb10">';
						$html = $html .'<div class="info mt-flex '.((!empty($val['userid_created'])) ? 'uk-flex-left my_teacher' : 'uk-flex-right my_member').' mb5">';
							$html = $html.'<div class="author"><div>'.$val['message'].'</div><small><i>'.$val['created'].'</i></small></div>';
						$html = $html .'</div>';
					$html = $html . '</div>';
				}
			$html = $html . '</div>';
		}else{
			$html = $html.'';
		}
		echo json_encode(array(
			'html' => $html,
		));die;
	}


	public function addcomment(){
		$module = $this->input->post('module');
		$moduleid = $this->input->post('moduleid');
		$parentid = $this->input->post('parentid');
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		$this->form_validation->set_rules('fullname', 'Họ và tên', 'trim|required');
		$this->form_validation->set_rules('email', 'Đại chỉ email', 'trim|required');
		$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
		$this->form_validation->set_rules('contents', 'Nội dung đánh giá', 'trim|required');
		if ($this->form_validation->run($this)){
			$post = $this->input->post('post');
			$data = '';
			if(isset($post) && is_array($post) && count($post)){
				foreach($post as $key => $val){
					$data[$val['name']] = nl2br($val['value']) ;
				}
			}else{
				$data['fullname'] = $this->input->post('fullname');
				$data['email'] = $this->input->post('email');
				$data['phone'] = $this->input->post('phone');
				$data['message'] = $this->input->post('contents');
				$data['customersid'] = $this->input->post('customersid');
			}
			$data['parentid'] = $parentid;
			$data['module'] = $module;
			$data['moduleid'] = $moduleid;
			$data['moduleid'] = $moduleid;
			$data['type'] = 'danhgia';
			$data['publish'] = 0;
			$data['created'] = gmdate('Y-m-d H:i:s', time() + 7*3600);

			if(isset($data) && is_array($data) && count($data)){
				$this->db->insert('comments', $data);
				$this->db->flush_cache();
			}
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}
	
	
	public function listComment(){
		$module = $this->input->post('module');
		$moduleid = $this->input->post('moduleid');
		$page = $this->input->post('page');
		$page = (int)$page;
		$config['total_rows'] = $this->FrontendComments_Model->Countall($module, $moduleid);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] ='#" data-page="';
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['cur_page'] = $page;
			$config['page'] = $page; 
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination mb30"><ul class="uk-pagination uk-pagination-right">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="uk-active"><a>';
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
			// print_r($data['listPagination']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['listComment'] = $this->FrontendComments_Model->View(($page * $config['per_page']),$config['per_page'], $module, $moduleid);
			$data['listComment'] = recursive($data['listComment']);
		}
		$html = '';
		if(isset($data['listComment']) && is_array($data['listComment']) && count($data['listComment'])){
			foreach($data['listComment'] as $key => $val){
				$html = $html . '<li class="item-comments">';
					$html = $html .'<div class="info mt-flex mb10">';
						$html = $html .'<div class="avatar mt-cover">';
							$html = $html .'<img src="'.((!empty($val['avatar'])) ? $val['avatar'] : 'templates/frontend/resources/images/no_avata.jpg').'">';
						$html = $html .'</div>';
						$html = $html.'<div class="author">';
							$html = $html .'<div class="name"><span class="user mt-text-bold">'.$val['fullname'].'</span></div>';
							$html = $html.'<div class="rating mb10">';
								for ($i=0; $i < $val['star'] ; $i++) { 
									$html = $html.'<i class="fas fa-star"></i>';
								}
							$html = $html.'</div>';
							$html = $html.'<div class="date">'.show_time($val['created'], 'd-m-Y').'</div>';
						$html = $html.'</div>';
					$html = $html.'</div>';
					$html = $html.'<div class="description">';
						$html = $html.'<div class="scroll-text">'.$val['message'].'</div>';
						$html = $html.'<div class="a-expander-header" style="display: none">
							<div class="a-expander-content-fade"></div>
							<a href="javascript:void(0)"><i class="fas fa-angle-down mr5"></i><span class="a-expander-prompt">Xem tiếp</span></a>
						</div>';
					$html = $html.'</div>';
					$list_image = explode('-+-', $val['images']);
					if (isset($list_image) && is_array($list_image) && count($list_image)) {
						$html = $html.'<ul class="mt-clearfix mt-list mt15 list-attachs-images">';
							foreach ($list_image as $valimg) {
								if (empty($valimg)) continue;
			            		$html = $html .'<li><a href="javascript:void(0)" data-file="'.$valimg.'">';
			            			$html = $html .'<img src="'.$valimg.'" alt="'.$valimg.'" />';
			            		$html = $html .'</a></li>';
							}
						$html = $html.'</ul>';
					}
					$html = $html . '<div class="mt15 relative"><span class="item-reply" data-id="'.$val['id'].'">Trả lời ('.(isset($val['child']) && is_array($val['child']) && count($val['child']) ? count($val['child']) : '0').')</span></div>';
					$html = $html.'<div class="reply-comment"></div>';
					if(isset($val['child']) && is_array($val['child']) && count($val['child'])){
						foreach($val['child'] as $keyg => $vals){
							$html = $html . '<div class="item-comments-sub mt10">';
								$html = $html . '<div class="item-comments">';
									$html = $html .'<div class="info mt-flex mb10">';
										$html = $html .'<div class="avatar mt-cover">';
											$html = $html .'<img src="'.((!empty($vals['avatar'])) ? $vals['avatar'] : 'templates/frontend/resources/images/no_avata.jpg').'">';
										$html = $html.'</div>';	
										$html = $html.'<div class="author">';
											$html = $html .'<div class="name"><span class="user mt-text-bold">'.$vals['fullname'].'</span></div>';
											$html = $html.'<div class="date">'.show_time($vals['created'], 'd-m-Y').'</div>';
										$html = $html.'</div>';
									$html = $html .'</div>';
									$html = $html.'<div class="description">';
										$html = $html.'<div class="scroll-text">'.$vals['message'].'</div>';
										$html = $html.'<div class="a-expander-header" style="display: none">
											<div class="a-expander-content-fade"></div>
											<a href="javascript:void(0)"><i class="fas fa-angle-down mr5"></i><span class="a-expander-prompt">Xem tiếp</span></a>
										</div>';
									$html = $html.'</div>';
								$html = $html.'</div>';
							$html = $html.'</div>';
						}
					}
				$html = $html . '</li>';
			}
			$html = $html . '<li class="ajax-pagination">'.$data['listPagination'].'</li>';
		}else{
			$html = $html.'';
		}
		echo json_encode(array(
			'html' => $html,
		));
		die();
	}
		

	public function ajax_upload(){
		if (! empty($_FILES)) {

			$config['upload_path'] = './uploads/images/comments';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']     = '2048';
			$this->load->library('upload');

			$files = $_FILES;

			$number_of_file = count($_FILES['file']['name']);
			$errors = 0;
			$images_arr = array();
			for ($i=0; $i < $number_of_file ; $i++) { 

				$_FILES['file']['name'] = $files['file']['name'][$i];
				$_FILES['file']['type'] = $files['file']['type'][$i];
				$_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
				$_FILES['file']['error'] = $files['file']['error'][$i];
				$_FILES['file']['size'] = $files['file']['size'][$i];

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('file')) {
					$errors++;
				}
				else
				{
					$extra_info = $_FILES['file']['name'];
		        	$images_arr[] = removeutf8(preg_replace('/\s+/', '_', $extra_info));
				}

			}

			if ($errors > 0) {
				$errors = $errors . ' File(s) cannot be upload';
			}
			else
			{
				$errors = '';
			}

		    $html = '';
		    if(!empty($images_arr)){ 
			    foreach($images_arr as $image_src){ 
		            $html = $html .'<li class="list-item mb15">';
		            	$html = $html .'<img src="/uploads/images/comments/'.$image_src.'" alt="'.$image_src.'" />';
		            	$html = $html .'<div class="pull-right">';
		            		$html = $html .'<a href="javascript:void(0)" data-file="/uploads/images/comments/'.$image_src.'" class="remove-file">';
		            			$html = $html .' <i class="fas fa-times-circle" aria-hidden="true"></i>';
		            		$html = $html .' </a>';
		            	$html = $html .' </div>';        
		            $html = $html .' </li>';
				}
			}
			 // print_r($images_arr);
			echo json_encode(array(
				'error' => $errors,
				'html' => $html,
			));
		}
		elseif ($this->input->post('file_to_remove')) {
			$file_to_remove = $this->input->post('file_to_remove');
			unlink(".".$file_to_remove);
		}
		else
		{
			$this->listFile();
		}
	}
}
