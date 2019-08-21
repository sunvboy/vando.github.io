<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['process'] = array(
			-1 => '- Chọn tình trạng -',
			0 => 'Chưa xử lý',
			1 => 'Đã xử lý xong'
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
		
		$data['status'] = array(
			'wait' => 'Chưa xem',
			'opened' => 'Đã xem',
			'processing' => 'Đang xử lý',
			'success' => 'Hoàn thành',
			'cancle' => 'Đã hủy',
		);
		$data['send'] = array(
			0 => 'Chưa giao hàng',
			1 => 'Đã giao hàng',
			
		);
		
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}