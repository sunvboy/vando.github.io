<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routers extends FC_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index($canonical = '', $page = 1){
		$module = '';
		$count = $this->FrontendRouters_Model->count($canonical);
		if($count > 0){
			$routers = $this->FrontendRouters_Model->read($canonical);
			// print_r($routers);
			if($routers['type'] == 'json'){
				$routers['param'] = json_decode($routers['param'], TRUE);
				$routers['param']['canonical'] = $canonical;
				if(!empty($routers['meta_title'])){
					$routers['param']['meta_seo'] = array(
						'meta_title' => $routers['meta_title'],
						'meta_keyword' => $routers['meta_keyword'],
						'meta_description' => $routers['meta_description'],
					);
				}
				$module = modules::run($routers['uri'], $routers['param'], $page);
			}
			else if($routers['type'] == 'number'){
				$id = $routers['param'];
				$routers['param'] = array(
					'id' => $id,
					'canonical' => $canonical,
				);
				$module = modules::run($routers['uri'], $routers['param']['id'], $page);
			}
			if(FCCOMPRESS == 1){
				$search = array(
					'/\n/', // replace end of line by a space
					'/\>[^\S ]+/s', // strip whitespaces after tags, except space
					'/[^\S ]+\</s', // strip whitespaces before tags, except space
					'/(\s)+/s' // shorten multiple whitespace sequences
				);
				$replace = array(
					' ',
					'>',
					'<',
					'\\1'
				);
				echo preg_replace($search, $replace, $module);
			}
			else{
				echo $module;
			}
		}
		else{
			show_404();
		}
	}

}
