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
			-1 => '- Chọn trạng thái -',
			0 => 'Chưa xử lý',
			1 => 'Đang chờ',
			2 => 'Đã xác minh',
			3 => 'Đã xử lý',
		);
		$data['highlight'] = array(
			-1 => '- Chọn nổi bật -',
			0 => 'Không nổi bật',
			1 => 'Nổi bật',
		);
		$data['degree'] = array(
			0 => '- Chọn trình độ học vấn cao nhất -',
			1 => 'Trên Đại học',
			2 => 'Đại học',
			3 => 'Cao đẳng',
			4 => 'Trung cấp',
			5 => 'Trung học',
			6 => 'Chứng chỉ nghề',
			7 => 'Không qua đào tạo',
		);
		$data['classify'] = array(
			0 => 'Chọn loại tốt nghiệp',
			1 => 'Xuất sắc',
			2 => 'Giỏi',
			3 => 'Khá',
			4 => 'Trung bình khá',
			5 => 'Trung bình',
		);
		$data['form'] = array(
			0 => 'Chọn hình thức làm việc',
			1 => 'Toàn thời gian',
			2 => 'Bán thời gian',
			3 => 'Theo hợp đồng',
			4 => 'Thực tập',
		);
		if($value == -1){
			return $data[$field];
		}
		else{
			return $data[$field][$value];
		}
	}
}