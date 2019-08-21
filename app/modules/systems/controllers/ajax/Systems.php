<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Systems extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fclang = $this->config->item('fclang');
	}
	public function language() {
		$fclang = $this->input->post('lang');
		$array = '';
		if ($fclang == $this->fclang) {
			
		}
		else
		{
			$auth = isset($_COOKIE[CODE.'auth'])?$_COOKIE[CODE.'auth']:NULL;
			if(isset($auth) && !empty($auth)){
				$auth = json_decode($auth, TRUE);
				foreach ($auth as $key => $val) {
					if ($key == 'lang') {
						$array[$key] = $fclang;
					}
					else{
						$array[$key] = $val;
					}
				}
			}
			setcookie(CODE.'auth', json_encode($array), time() + (86400 * 30), '/');
		}
		print_r($array);die;
	}
	public function lang() {
		$language = $this->input->post('lang');
		$fc_lang = isset($_COOKIE['fc_lang'])?$_COOKIE['fc_lang']:NULL;
		if(isset($fc_lang) && !empty($fc_lang)){
			setcookie('fc_lang', $language, time() + 3600, '/');
		}
	}
}
