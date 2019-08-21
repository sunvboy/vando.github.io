<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'files/backend/files/view'
		));
		$page = (int)$page;
		
		$data['template'] = 'files/backend/files/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	
	public function upload(){
		$path_url = substr(APPPATH,0,-4);
		if(!empty($_FILES)){
			$config['upload_path'] = $path_url;
			$config['allowed_types'] = 'zip|html|txt|xml';
			$config['max_size']     = '2048';
			$config['detect_mime']  = TRUE;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('file')){
				$error = $this->upload->display_errors();
				echo json_encode(array('error' => $error));die();
			}
		}else if($this->input->post('file_to_remove')){
			$file_to_remove = $this->input->post('file_to_remove');
			unlink($path_url.$file_to_remove);
		}
		$this->listFiles();
	}
	
	private function listFiles(){
		$config['allowed_types'] = array('xml','zip','html','txt');
		$this->load->helper('file');
		$path_url = substr(APPPATH,0,-4);
		// $files = get_filenames($path_url.'/asset');
		$files = scandir($path_url);
		$temp = '';
		if(isset($files) && is_array($files) && count($files)){
			foreach($files as $key => $val){
				if($val == '.' || $val == '..') continue;
				$explode = explode('.',$val);
				if(count($explode) <= 1) continue;
				$extension = $explode[1];
				if(isset($explode[1]) && !in_array($extension, $config['allowed_types'])) continue;
				$temp[] = $val;
			}
		}
		
		echo json_encode($temp);
	}

}
