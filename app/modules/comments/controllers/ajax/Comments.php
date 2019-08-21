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
		$this->form_validation->set_rules('contents', 'Nội dung câu hỏi', 'trim|required');
		if ($this->form_validation->run($this)){
			$post = $this->input->post('post');
			$data = '';
			if(isset($post) && is_array($post) && count($post)){
				foreach($post as $key => $val){
					$data[$val['name']] = nl2br($val['value']) ;
				}
			}else{
				$data['fullname'] = $this->input->post('fullname');
				$data['message'] = $this->input->post('contents');
				$data['customersid'] = $this->input->post('customersid');
			}
			$data['parentid'] = 0;
			$data['module'] = $module;
			$data['moduleid'] = $moduleid;
			$data['type'] = 'cauhoi';
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

	public function listQuestion(){
		$module = $this->input->post('module');
		$moduleid = $this->input->post('moduleid');
		$page = $this->input->post('page');
		$page = (int)$page;
		$config['total_rows'] = $this->FrontendComments_Model->CountallQuestions($module, $moduleid);
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
			$config['full_tag_open'] = '<ul class="uk-pagination uk-pagination-right pagination">';
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
			// print_r($data['listPagination']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['listComment'] = $this->FrontendComments_Model->ViewQuestions(($page * $config['per_page']),$config['per_page'], $module, $moduleid);
			$data['listComment'] = recursive($data['listComment']);
		}
		$html = '';
		if(isset($data['listComment']) && is_array($data['listComment']) && count($data['listComment'])){
			foreach($data['listComment'] as $key => $val){
				$name = explode(' ', $val['fullname']);
				$tmp = '';
				foreach($name as $valaa){
					$tmp .= substr( $valaa,  0, 1);

				}
				if(!empty($tmp != '')){
					$ten = $tmp;

				}else{
					$ten = 'KH';
				}

				$html = $html . '<div class="media-at">
                        <div class="comava-at"> '.$ten.' </div>
                        <div class="combody-at">
                            <strong>'.$val['fullname'].'</strong>
                            <p>'.$val['message'].'</p>
                            <div class="comact-at">
                                <span class="time-at">'.show_time($val['created'], 'd-m-Y').'</span>
                            </div>
                        </div>';
				if(isset($val['child']) && is_array($val['child']) && count($val['child'])){

						$html = $html . '<ul class="ul-b listrep-at">';
					foreach($val['child'] as $keyg => $vals) {
						$html = $html . '<li>
                                <div class="comava-at qtv-at">QTV</div>
                                <div class="combody-at">
                                    <strong><i>Quản trị viên</i></strong>
                                    <p>'.strip_tags($vals['message']).'</p>
                                    <div class="comact-at">
                                        <span class="time-at">'.show_time($vals['created'], 'd-m-Y').'</span>
                                    </div>
                                </div>
                            </li>';
					}
					$html = $html . '</ul>';
					}
						$html = $html . '</div>';
			}
			$html = $html . '<div class="ajax-pagination-cauhoi" style="    float: right;">'.$data['listPagination'].'</div>';
		}else{
			$html = $html.'';
		}
		echo json_encode(array(
			'html' => $html,
			'count_comments' => count($data['listComment']),
		));
		die();
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
			$config['full_tag_open'] = '<ul class="uk-pagination uk-pagination-right pagination">';
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
				$html = $html . '<div class="wp-item-danhgia">
                            <div class="left-dg">
                                <h4 class="h4-title">'.$val['fullname'].'</h4>
                                <span>'.show_time($val['created'], 'd-m-Y').'</span>
                                <div class="start2">';
									for ($i=0; $i < $val['star'] ; $i++) {
										$html = $html.'<span><i style="color: #F49100;" class="fas fa-star"></i></span>';
									}
				$html = $html . '</div></div>
                            <div class="right-dg">
                                <p>'.$val['message'].'</p>
                            </div></div>';
			}
			$html = $html . '<div class="ajax-pagination" style="    float: right;">'.$data['listPagination'].'</div>';
		}else{
			$html = $html.'';
		}
		echo json_encode(array(
			'html' => $html,
			'count_comments' => count($data['listComment']),
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
