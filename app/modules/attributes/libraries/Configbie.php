<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['modules'] = array(
			-1 => '- [Chọn modules] -',
			'articles' => 'Modules bài viết',
			'products' => 'Modules sản phẩm',
			'gallerys' => 'Modules hình ảnh',
			'videos' => 'Modules videos',
		);
		$data['publish'] = array(
			-1 => '- Chọn xuất bản -',
			0 => 'Không xuất bản',
			1 => 'Xuất bản',
		);
		$data['highlight'] = array(
			-1 => '- Chọn nổi bật -',
			0 => 'Không nổi bật',
			1 => 'Nổi bật',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}