<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['publish'] = array(
			-1 => '- Chọn xuất bản -',
			0 => 'Không xuất bản',
			1 => 'Xuất bản',
		);
		
		$data['width'] = array(
			0 => 'Chọn loại tin',
			1 => 'Cần bán',
			2 => 'Cần mua',
			3 => 'Cần thuê',
			4 => 'Cần cho thuê',
		);
		$data['type'] = array(
			0 => 'Không thương lượng',
			1 => 'Có thương lượng',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}