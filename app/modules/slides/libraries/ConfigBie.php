<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['publish'] = array(
			-1 => '- Chọn xuất bản -',
			0  => 'Không xuất bản',
			1  => 'Xuất bản',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}

	// // meta_title là 1 row -> seo_meta_title
	// // contact_address
	// // chưa có thì insert
	// // có thì update
	// public function system($field = 'process', $value = -1){
	// 	$data['seo'] = array(
	// 		'meta_title' => 'text',
	// 		'meta_keywords' => 'text',
	// 		'meta_description' => 'textarea'
	// 	);
	// 	$data['contact'] = array(
	// 		'address' => 'editor',
	// 		'phone' => 'text',
	// 		'map' => 'textarea'
	// 	);
	// }
}