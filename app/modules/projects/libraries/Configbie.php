<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie{
	
	function __construct($params = NULL){
		$this->params = $params;
	}

	public function data($field = 'process', $value = -1){
		$data['ishome'] = array(
			-1 => '- Chọn -',
			0 => 'Không hiển thị',
			1 => 'Hiện thị'
		);
		$data['isaside'] = array(
			-1 => '- Chọn -',
			0 => 'Không hiển thị',
			1 => 'Hiển thị'
		);
		$data['isfooter'] = array(
			-1 => '- Chọn -',
			0 => 'Không hiển thị',
			1 => 'Hiển thị'
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
		$data['measure'] = array(
			0 => 'Giá tiền',
			1 => 'Trăm triệu',
			2 => 'Triệu',
			3 => 'Tỷ',
			4 => 'Cây',
			5 => 'Ngàn USD',
		);
		$data['floor'] = array(
			0 => 'Chọn hướng',
			1 => 'Đông',
			2 => 'Tây',
			3 => 'Nam',
			4 => 'Bắc',
			5 => 'Đông Bắc',
			6 => 'Đông Nam',
			7 => 'Tây Bắc',
			8 => 'Tây Nam',
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