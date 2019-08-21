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
			0 => 'Hiển thị món ăn',
			1 => 'Hiển thị đồ uống',
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
		$data['psale'] = array(
			-1 => '- Chọn khuyến mại -',
			0 => 'Không khuyến mại',
			1 => 'Khuyến mại',
		);
		$data['status'] = array(
			0 => 'Còn hàng',
			1 => 'Hết hàng',
		);
		$data['type_aff'] = array(
			0 => 'Chọn hình thức tính hoa hồng',
			// 1 => 'Theo phần trăm theo giá bán sản phẩm',
			2 => 'Theo số tiền theo giá bán sản phẩm',
		);
		$data['version'] = array(
			0 => 'Thuộc tính',
			1 => 'Kích thước',
			2 => 'Màu sắc',
			3 => 'Vật liệu',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}