<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['process'] = array(
			-1 => '- Chọn tình trạng -',
			0 => 'Chưa xử lý',
			1 => 'Đang xử lý',
			2 => 'Đã xử lý xong'
		);
		$data['level'] = array(
			-1 => '- Chọn Mức độ -',
			0 => 'Rất quan trọng',
			1 => 'Quan trọng'
		);
		$data['publish'] = array(
			-1 => '- Chọn xuất bản -',
			0 => 'Deactive',
			1 => 'Active',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}