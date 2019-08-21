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
			-1 => '- Chọn giao diện-',
			0 => 'Mặc định (Tin Tức)',
			1 => 'Kết nối học viên',
			2 => 'Hỗ trợ sự nghiệp',
			3 => 'Hội thảo AND Small talk',
			4 => 'Nghiên cứu',
			5 => 'Tuyển sinh',
			6 => 'Truyền thông',
			7 => 'Học viên ưu tú',
			8 => 'Videos Truyền thông',
			9 => 'Dvụ cộng đồng',
			10 => 'Thư viện sách(Cộng đồng)',
			11 => 'Hỗ trợ(Cộng đồng)',
			12 => 'Biểu mẫu(Cộng đồng)',
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