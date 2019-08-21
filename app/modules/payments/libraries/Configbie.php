<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
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
		$data['sex'] = array(
			2 => 'Bạn',
			0 => 'Anh',
			1 => 'Chị',
		);
		$data['type_aff'] = array(
			0 => 'Chọn hình thức triết khấu',
			1 => 'Theo phần trăm theo giá bán sản phẩm',
			2 => 'Theo số tiền theo giá bán sản phẩm',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}