<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['modules'] = array(
			-1 => 'Chọn Module',
			'Articles_Catalogues' => 'Danh mục bài viết',
			'Products_Catalogues' => 'Danh mục sản phẩm',
			'Gallerys_Catalogues' => 'Danh mục hình ảnh',
			'Videos_Catalogues' => 'Danh mục videos',
		);
		$data['publish'] = array(
			-1 => '- Chọn xuất bản -',
			0 => 'Không xuất bản',
			1 => 'Xuất bản',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}