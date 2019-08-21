<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['couponType'] = array(
			0 => 'Theo phần trăm',
			1 => 'Theo số tiền',
		);
		$data['level'] = array(
			-1 => '- Chọn Mức độ -',
			0 => 'Rất quan trọng',
			1 => 'Quan trọng'
		);
		$data['publish'] = array(
			-1 => '- Chọn xuất bản -',
			0 => 'Không xuất bản',
			1 => 'Xuất bản',
		);
		$data['type'] = array(
			-1 => '- Chọn loại phòng -',
			0 => 'Phòng đơn',
			1 => 'Phòng đôi',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}