<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('show_flashdata_frontend')){
	function show_flashdata_frontend($body = TRUE){
		$result = '';
		$CI =& get_instance();
		$message = $CI->session->flashdata('message-success');
		if(isset($message)){
			if($body == TRUE) $result = $result . '<div class="fixed_bg" style="position: fixed;right: 0px;top: 100px;z-index: 9999;width: 317px;">
			<div class=""><div class="alert alert-success" data-dismiss="alert" aria-label="close">';
			$result = $result . '<a href="#" class="close">x</a><p>'.$message.'</p>';
			if($body == TRUE) $result = $result . '</div></div></div>';
			return $result;
		}
		$message = $CI->session->flashdata('message-danger');
		if(isset($message)){
			if($body == TRUE) $result = $result . '<div class="fixed_bg" style="position: fixed;right: 0px;top: 100px;z-index: 9999;width: 317px;"><div class=""><div class="alert alert-danger" data-uk-alert>';
			$result = $result . '<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><p>'.$message.'</p>';
			if($body == TRUE) $result = $result . '</div></div></div>';
			return $result;
		}
	}
}

if(!function_exists('sendRequestNhanhVN')){
 	function sendRequestNhanhVN($requestUri, $data = null, $storeId = null){
 		require_once 'plugins/nhanh.vn-master/src/NhanhService.php';
 		$service = new NhanhService();
 		$storeId = null;

        $service = new NhanhService();
        $response = $service->sendRequest($requestUri, $data, $storeId);

        return $response;
 	}
}

if(!function_exists('convert_array')){
 	function convert_array($array1 = '', $array2 = '', $i = 0){

		if (isset($array1) && is_array($array1) && count($array1)) {
			$arr = '';
			foreach ($array1 as $valp) {
				if (isset($array2) && is_array($array2) && count($array2)) {
					foreach ($array2 as $valp2) {
						$arr[] = (($i == 1) ? '<span>'.$valp.'</span><span>'.$valp2.'</span>' : $valp.'<span>'.$valp2.'</span>' );
					}
				}
			}
			return $arr;
		}else{
			return $array2;
		}
 	}
}

if(!function_exists('total_coin_customers')){
 	function total_coin_customers($customerid = 0){
 		$total = 0;
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$CoinCustomers = $CI->Autoload_model->_get_where(array(
			'select' => 'id, type, coint',
			'table' => 'customers_coint',
			'where' => array('trash' => 0, 'publish' => 1, 'customers_id' => $customerid),
		), TRUE);
 		if (isset($CoinCustomers) && is_array($CoinCustomers) && count($CoinCustomers)) {
 			foreach ($CoinCustomers as $key => $val) {
 				$total = ((!empty($val['type'])) ? ($total - $val['coint']) : ($total + $val['coint']));
 			}
 		}
 		return str_replace(',', '.', number_format($total));
 	}
}

if(!function_exists('load_products_type')){
 	function load_products_type(){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
		$Products = $CI->Autoload_model->_get_where(array(
			'select' => 'id, title, images',
			'table' => 'products',
			'where' => array('trash' => 0, 'publish' => 1, 'parentid' => 0),
			'order_by' => 'rand()',
			'limit' => 30,
		), TRUE);
		$temp = '';
		if(isset($Products) && is_array($Products) && count($Products)){
			foreach($Products as $key => $val){
				// $temp .= .((!empty($type) && $type == 'images') ? '\''.$val['images'].'\'' : '\''.$val['title'].'\'');
				$temp .= (($key == 0) ? '' : ', ').'\'<a href="#form-order">';
		            $temp .= '<img class="img-order" src="'.$val['images'].'" alt="order">';
		            $temp .= '<div class="infor"><h3 class="title-order-prd">'.$val['title'].'</h3>';
		            $temp .= '<p>Khách hàng <span class="people"></span> số điện thoại: <span class="phone-order"></span> <br>vừa đặt hàng cách đây <span class="timeAgo"></span></font></p></div>';
		        $temp .= '</a>\'';
			}
		}
		echo '['.$temp.']';
	}
}

if(!function_exists('show_rating_products')){
 	function show_rating_products($productsid = '', $module = 'products', $flag = TRUE, $star = 0){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($productsid)) {
 			if ($flag == FALSE) {
 				$CI->db->where(array('parentid' => 0));
 			}
 			if (!empty($star)) {
 				$CI->db->where(array('star' => $star));
 			}
 			$CI->db->where(array('moduleid' => $productsid, 'module' => $module, 'publish' => 1, 'type' => 'danhgia'));
 			$CI->db->from('comments');
			$count = $CI->db->count_all_results();
			$CI->db->flush_cache();
 		}
 		return $count;
 	}
}

if(!function_exists('check_catalogues_products_version')){
 	function check_catalogues_products_version($productsid = ''){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$catalogues = '';
 		if (!empty($productsid)) {
 			// Check sản phẩm 
			$products = $CI->Autoload_model->_get_where(array(
				'select' => 'id, parentid, catalogues',
 				'table' => 'products',
 				'where' => array('id' => $productsid)
 			), TRUE);
 			if (isset($products) && is_array($products) && count($products)) {
				foreach ($products as $key => $val) {
					if (!empty($val['parentid'])) {
						$catalogues = check_catalogues_products_version($val['parentid']);
					}else{
						$catalogues = $val['catalogues'];
					}
				}
 			}
 		}
 		return $catalogues;
 	}

}
if(!function_exists('checkgiftcode_payment')){
 	function checkgiftcode_payment($giftcode = '', $paymentsid = 0){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$price = $total_cart = 0;
 		if (!empty($giftcode) && !empty($paymentsid)) {
 			$_payment = $CI->Autoload_Model->_read(array(
				'table' => 'payments',
				'where' => array(
					'id' => $paymentsid,
				),
			));
			if (isset($_payment) && is_array($_payment) && count($_payment)) {
				$cart = json_decode($_payment['data'], TRUE);
				// Check tổng tiền của giỏ hàng đang xủa lý
				if(isset($cart) && is_array($cart) && count($cart)){
					foreach($cart as $keycart => $valcart){
						$total_cart += $valcart['subtotal'];
					}
				}
				// Check sự tồn tại của Giftcode
				$check_gift = $CI->FrontendProducts_Model->_read(array(
					'select' => '*',
					'table' => 'coupon',
					'where' => array('publish' => 1, 'trash' => 0, 'couponCode' => $giftcode),
				));

				if (isset($check_gift) && is_array($check_gift) && count($check_gift)) {
					if (empty($check_gift['status'])) {
						$check = 1; // Không có lỗi
						if (!empty($check_gift['requiresMinimumPurchase'])) {
							// Nếu Gift code có áp dụng cho giá trị đơn hàng tối thiểu
							if ($total_cart < $check_gift['minimumPurchase']) {
								// Tổng giá trị đơn hàng nhỏ hơn mức áo dụng tối thiểu
								$check = 0; // Xảy ra lỗi
							}
						}
						if (!empty($check)){
							if (!empty($check)){
								// Kiểm tra mã code áp dụng cho trường hợp nào
								if ($check_gift['appliesTo'] == 'cart') {// Áp dụng cho toàn bộ đơn hàng
									// Kiểm tra gift code giảm giá theo phương thức nào
									if (!empty($check_gift['couponType'])) {
										# Mã giảm giá theo số tiền 
										$price = $check_gift['couponTypeValue'];
									}else{
										# Mã giảm giá theo phần trăm
										$price = (($total_cart/100)*$check_gift['couponTypeValue']);
									}
								// END áp dụng cho đơn hàng
								}elseif ($check_gift['appliesTo'] == 'collections') {
									// Áp dụng cho danh mục sản phẩm
									// Kiểm tra sản phẩm trong đơn hàng có nằm trong danh sách các danh mục áp dụng khuyến mại không
									if (isset($cart) && is_array($cart) && count($cart)) {
										$price_ = 0;
										$i = 0;
										foreach ($cart as $key => $val) {
											$catalogues = check_catalogues_products_version($val['id']);// Lấy thông tin danh mục của sản phẩm
											$list_collection = json_decode($catalogues, TRUE);
											foreach ($list_collection as $key => $vals) {
												if (in_array($vals, explode('-', $check_gift['CollectionId']))) {
													// Nếu sản phẩm này nằm trong danh sách danh mục áp dụng chương trình khuyến mại
													// Kiểm tra gift code giảm giá theo phương thức nào
													if (!empty($check_gift['couponType'])) {
														# Mã giảm giá theo số tiền 
														$price_ += $check_gift['couponTypeValue'];
													}else{
														# Mã giảm giá theo phần trăm
														$price_ += (($val['subtotal']/100)*$check_gift['couponTypeValue']);
													}
													$i++;
												}
											}
										}
										if (!empty($price_)) {
											$price = $price_;
										}
									}
								}else{
									// Áp dụng cho danh sách sản phẩm
									// Kiểm tra sản phẩm trong đơn hàng có nằm trong danh sách các danh mục áp dụng khuyến mại không
									if (isset($cart) && is_array($cart) && count($cart)) {
										$price_ = 0;
										$i = 0;
										foreach ($cart as $key => $val) {
											if (in_array($val['id'], explode('-', $check_gift['ProductsId']))) {
												// Nếu sản phẩm này nằm trong danh sách danh mục áp dụng chương trình khuyến mại
												// Kiểm tra gift code giảm giá theo phương thức nào
												$alert['result'] = $check_gift['couponTypeValue'];
												$alert['typeoff'] = ((!empty($check_gift['couponType'])) ? '0' : '1');
												if (!empty($check_gift['couponType'])) {
													# Mã giảm giá theo số tiền 
													$price_ += $check_gift['couponTypeValue'];
												}else{
													# Mã giảm giá theo phần trăm
													$price_ += (($val['subtotal']/100)*$check_gift['couponTypeValue']);
												}
												$i++;
											}
										}
										if (!empty($price_)) {
											$price = $price_;
										}
									}
								}
							}
						}
					}
				}

			}
 		}
 		return $price;
 	}
}

if(!function_exists('check_shipping_products')){
 	function check_shipping_products($productsid = '', $type = 'shop'){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$count = 0;
 		if (!empty($productsid)) {
 			// Check sản phẩm 
			$products = $CI->Autoload_model->_read(array(
				'select' => 'id, title, shipcode, parentid, saleoff',
 				'table' => 'products',
 				'where' => array('id' => $productsid)
 			));
 			if (isset($products) && is_array($products) && count($products)) {
				$shipcode = json_decode($products['shipcode'], TRUE);
 				if (isset($shipcode) && is_array($shipcode) && count($shipcode)) {
 					foreach ($shipcode as $key => $val) {
 						if (!empty($val[$type])) {
 							$count = $val[$type];
 						}else{
 							$count = check_shipping_products($products['parentid'], $type);
 						}
 					}
 				}
 			}
 		}
 		return $count;
 	}
}

if(!function_exists('count_rating')){
 	function count_rating($productsid = '', $module = 'products', $flag = TRUE){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($productsid)) {
 			if ($flag == FALSE) {
 				$CI->db->where(array('parentid' => 0));
 			}
 			$CI->db->select('SUM(star) as count');
 			$CI->db->from('comments');
 			$CI->db->where(array('moduleid' => $productsid, 'module' => $module, 'publish' => 1, 'type' => 'danhgia'));
			$query = $CI->db->get()->row_array();
			$CI->db->flush_cache();
			if (isset($query) && is_array($query) && count($query)) {
				$count = ((!empty($query['count'])) ? $query['count'] : 0);
			}
 		}
 		return $count;
 	}
}

if(!function_exists('price_coupon')){
 	function price_coupon($productsid = 0){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$price = 0;
 		
	 	return $price;
 	}
}

if(!function_exists('price_affiliate_id')){
 	function price_affiliate_id($price_products = 0, $productsid = 0, $customerid = 0){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$price = 0;
 		$customer = $CI->FrontendCustomers_Model->ReadByField('id', $customerid);
 		if (isset($customer) && is_array($customer) && count($customer)) {
 			if (!empty($customer['level'])) {
				// Check giá sản phẩm theo cấp độ thành viên
				$affiliate_check = $CI->Autoload_model->_read(array(
 					'select' => 'count',
	 				'table' => 'products_discount_affiliate',
	 				'where' => array('productsid' => $productsid, 'level' => $customer['level'])
	 			));
	 			if (isset($affiliate_check) && is_array($affiliate_check) && count($affiliate_check)) {

	 				$price = ((!empty($price_products) && $affiliate_check['count'] < $price_products) ? ($price_products - $affiliate_check['count']) : 0);
	 			}
 			}
	 	}
	 	return $price;
 	}
}

if(!function_exists('price_affiliate')){
 	function price_affiliate($price_products = 0, $productsid = 0){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$customer = $CI->config->item('fcCustomer');
 		$price = 0;
 		// Check Affiliate
 		if (isset($customer) && is_array($customer) && count($customer)) {
 			if (!empty($customer['level'])) {
				// Check giá sản phẩm theo cấp độ thành viên
				$affiliate_check = $CI->Autoload_model->_read(array(
 					'select' => 'count',
	 				'table' => 'products_discount_affiliate',
	 				'where' => array('productsid' => $productsid, 'level' => $customer['level'])
	 			));

	 			if (isset($affiliate_check) && is_array($affiliate_check) && count($affiliate_check)) {
	 				$price = ((!empty($price_products) && $affiliate_check['count'] < $price_products) ? ($affiliate_check['count']) : 0);
	 			}
 			}
	 	}
	 	return $price;
 	}
}

if(!function_exists('discounted_member')){
 	function discounted_member(){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$customer = $CI->config->item('fcCustomer');
 		$discounted = '';
 		// Check Affiliate
 		if (isset($customer) && is_array($customer) && count($customer)) {
	 		$affiliate_name = $CI->FrontendCustomers_Model->ReadByField('id', $customer['id']);
	 		if (isset($affiliate_name) && is_array($affiliate_name) && count($affiliate_name)) {
	 			// Check phần trăm triết khấu của thành vien theo cấp level
	 			if (!empty($affiliate_name['level'])) {
	 				$level_check = $CI->Autoload_model->_read(array(
	 					'select' => 'title, discounted',
		 				'table' => 'customers_level',
		 				'where' => array('id' => $affiliate_name['level'])
		 			));
		 			if (isset($level_check) && is_array($level_check) && count($level_check)) {
		 				if (!empty($level_check['discounted'])) {
		 					$discounted = $level_check['discounted'];
		 				}
		 			}
	 			}
	 		}
	 	}
	 	return $discounted;
 	}
}

if(!function_exists('check_price_affiliate')){
 	function check_price_affiliate($price_products = 0, $flag = TRUE){
 		$CI =& get_instance();
 		$CI->load->model('Autoload_model');
 		$affiliate = (isset($_COOKIE['affiliate'])) ? $_COOKIE['affiliate'] : '';
 		$price = 0;
 		// Check Affiliate
 		if (!empty($affiliate)) {
	 		$affiliate_name = $CI->FrontendCustomers_Model->ReadByField('affiliate_id', $affiliate);
	 		if (isset($affiliate_name) && is_array($affiliate_name) && count($affiliate_name)) {
	 			// Check phần trăm triết khấu của thành vien theo cấp level
	 			if (!empty($affiliate_name['level'])) {
	 				$level_check = $CI->Autoload_model->_read(array(
	 					'select' => 'title, discounted',
		 				'table' => 'customers_level',
		 				'where' => array('id' => $affiliate_name['level'])
		 			));
		 			if (isset($level_check) && is_array($level_check) && count($level_check)) {
		 				if (!empty($level_check['discounted'])) {
		 					$price = ceil(($price_products/100)*$level_check['discounted']);
		 				}
		 			}
	 			}
	 		}
	 	}
	 	if ($flag == TRUE) {
	 		return ($price_products - $price);
	 	}else{
	 		return $price;
	 	}
 	}
}

if(!function_exists('convert_chapter')){
 	function convert_chapter( $chapter = '', $lesson = '', $productsid = ''){
 		$temp = '';
		if(isset($chapter['title']) && is_array($chapter['title'])  && count($chapter['title'])) {
			foreach ($chapter['title'] as $key => $val) {
				$temp[] = array('title' => $val); 
			}
		}
		if(isset($temp) && is_array($temp) && count($temp) && isset($chapter['count']) && is_array($chapter['count']) && count($chapter['count'])) {
			foreach ($temp as $key => $val) {
				$temp[$key]['title'] = $chapter['title'][$key];
				$temp[$key]['count'] = $chapter['count'][$key];
				if (isset($chapter['id']) && is_array($chapter['id']) && count($chapter['id'])) {
					$temp[$key]['id'] = $chapter['id'][$key];
				}
			}
		}

		$temp2 = '';
		if(isset($lesson['title']) && is_array($lesson['title'])  && count($lesson['title'])) {
			foreach ($lesson['title'] as $key => $val) {
				$temp2[] = array('title' => $val); 
			}
		}
		if(isset($temp2) && is_array($temp2) && count($temp2) && isset($lesson['time']) && is_array($lesson['time']) && count($lesson['time']) && isset($lesson['source']) && is_array($lesson['source']) && count($lesson['source']) && isset($lesson['description']) && is_array($lesson['description']) && count($lesson['description'])) {
			foreach ($temp2 as $key2 => $val) {
				$temp2[$key2]['title'] = $lesson['title'][$key2];
				$temp2[$key2]['time'] = $lesson['time'][$key2];
				$temp2[$key2]['description'] = $lesson['description'][$key2];
				$temp2[$key2]['source'] = $lesson['source'][$key2];
				if (isset($lesson['id']) && is_array($lesson['id']) && count($lesson['id'])) {
					$temp2[$key2]['id'] = $lesson['id'][$key2];
				}
			}
		}
		// return $temp;
		$array = '';
		if (isset($temp) && is_array($temp) && count($temp)) {
			$j = $i = 0;
			foreach ($temp as $key3 => $vals) {
				if (!empty($vals['id'])) {
					$array[$key3]['id'] = $vals['id'];
				}
				if (!empty($productsid)) {
					$array[$key3]['productsid'] = $productsid;
				}
				$array[$key3]['title'] = $vals['title'];
				$j = $j + $vals['count'];
				$page = '';
				
				if (isset($temp2) && is_array($temp2) && count($temp2)) {
					foreach ($temp2 as $keyp => $val) {
						if ( $keyp < $j && $keyp >= $i ){
							$page[$keyp] = $val;
							$i++;
						}
					}
					$page = array_values($page);
				}
				$array[$key3]['page'] = $page;
			}
			
		}
		return $array;
 	}
}
if(!function_exists('count_phien_ban')){
 	function count_phien_ban($id = 0){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($id)) {
 			$count_version = $CI->FrontendProducts_Model->_get_where(array(
	            'select' => 'id, title',
	            'table' => 'products',
	            'where' => array('trash' => 0,'publish' => 1, 'parentid' => $id),
	            'order_by' => 'id asc',
	        ), TRUE);
			if (isset($count_version) && is_array($count_version) && count($count_version)){
				$count = count($count_version);
			}
 		}
 		return $count;
 	}
 }
// Đếm số lượng bài giảng của 1 khóa học
if(!function_exists('countlesson')){
 	function countlesson($id = 0){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($id)) {
 			$chapter = $CI->FrontendProducts_Model->_get_where(array(
	            'select' => 'id, title, productsid',
	            'table' => 'products_chapter',
	            'where' => array('trash' => 0,'publish' => 1, 'productsid' => $id),
	            'order_by' => 'id asc',
	        ), TRUE);
			if(isset($chapter) && is_array($chapter) && count($chapter)){
				foreach($chapter as $key => $val){
					$chapter[$key]['page'] = $CI->FrontendProducts_Model->_get_where(array(
			            'select' => 'id, title, time, source',
			            'table' => 'products_page',
			            'where' => array('trash' => 0, 'publish' => 1, 'chapterid' => $val['id']),
			            'order_by' => 'id asc',
			        ), TRUE);
				}
			}
			if (isset($chapter) && is_array($chapter) && count($chapter)){
				foreach ($chapter as $keyc => $vals){
					if (isset($vals['page']) && is_array($vals['page']) && count($vals['page'])){
						foreach ($vals['page'] as $keyp => $val){
							$count++;
						}
					}
				}
			}
 		}
 		return $count;
 	}
}

// Đếm số lượng học viên mua bài giảng của 1 khóa học
if(!function_exists('counthocvien')){
 	function counthocvien($productsid = 0){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($productsid)) {
 			$CI->db->where(array('productsid' => $productsid, 'publish' => 1));
 			$CI->db->from('products_code');
			$count = $CI->db->count_all_results();
			$CI->db->flush_cache();
 		}
 		return $count;
 	}
}

// Đếm số lượng bài giảng của 1 giảng viên
if(!function_exists('count_lesson_teacher')){
 	function count_lesson_teacher($teachersid = 0){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($teachersid)) {
 			$CI->db->where(array('teachersid' => $teachersid, 'publish' => 1));
 			$CI->db->from('products');
			$count = $CI->db->count_all_results();
			$CI->db->flush_cache();
 		}
 		return $count;
 	}
}

// Đếm số lượng học viên của từng giảng viên
if(!function_exists('count_customers_teacher')){
 	function count_customers_teacher($teachersid = 0){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($teachersid)) {
 			$CI->db->from('products_code');
			$CI->db->join('products', 'products.id = products_code.productsid');
			$CI->db->join('teachers', 'teachers.id = products.teachersid');
 			$CI->db->where(array('teachers.id' => $teachersid, 'products_code.publish' => 1));
			$count = $CI->db->count_all_results();
			$CI->db->flush_cache();
 		}
 		return $count;
 	}
}

// Kiểm tra bài giảng đã được kích hoạt được chưa
if(!function_exists('check_lesson')){
 	function check_lesson($customersid = 0, $productsid = 0, $flag = TRUE){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($customersid) && !empty($productsid)) {
 			$CI->db->where(array('productsid' => $productsid, 'customersid' => $customersid));
 			if ($flag == TRUE) {
 				$CI->db->where(array('publish' => 1));
 			}
 			$CI->db->from('products_code');
			$count = $CI->db->count_all_results();
			$CI->db->flush_cache();
 		}
 		return $count;
 	}
}

// Đếm số lượng sản phẩm đã bán thành công kể cả các phiên bản của sản phẩm đó
if(!function_exists('count_product_order_success')){
 	function count_product_order_success($productsid = 0){
 		$CI =& get_instance();
 		$count = 0;
 		if (!empty($productsid)) {
 			// Lấy danh sách các phiên bản của sản phẩm đó
 			$result = $CI->Autoload_Model->_get_where(array(
				'select' => 'id, price, saleoff, quantity, status',
				'table' => 'products',
				'where' => array('publish' => 1, 'trash' => 0, 'parentid' => $productsid),
				'order_by' => 'id desc, order asc'
			),TRUE);
			$temp = '';
			$temp[0] = $productsid;
			if(isset($result) && is_array($result) && count($result)){
				foreach($result as $key => $val){
					$temp[($key + 1)] = $val['id'];
				}
			}
			$CI->db->select('SUM(payments_items.quantity) as count');
 			$CI->db->from('payments_items');
			$CI->db->join('payments', 'payments.id = payments_items.paymentsid');
 			$CI->db->where(array('payments.send' => 1, 'payments.status' => 'success'));
 			$CI->db->where_in('payments_items.productsid', $temp);
			$query = $CI->db->get()->row_array();
			$CI->db->flush_cache();
			if (isset($query) && is_array($query) && count($query)) {
				$count = ((!empty($query['count'])) ? $query['count'] : 0);
			}
 		}
 		return $count;
 	}
}


if( ! function_exists( 'menu_icon' ) ){
    function menu_icon(){
        return array("fa fa-home","fa fa-glass","fa fa-music","fa fa-search","fa fa-envelope-o","fa fa-heart","fa fa-star","fa fa-star-o","fa fa-user","fa fa-film","fa fa-th-large","fa fa-th","fa fa-th-list","fa fa-check","fa fa-remove","fa fa-close","fa fa-times","fa fa-search-plus","fa fa-search-minus","fa fa-power-off","fa fa-signal","fa fa-gear","fa fa-cog","fa fa-trash-o","fa fa-file-o","fa fa-clock-o","fa fa-road","fa fa-download","fa fa-arrow-circle-o-down","fa fa-arrow-circle-o-up","fa fa-inbox","fa fa-play-circle-o","fa fa-rotate-right","fa fa-repeat","fa fa-refresh","fa fa-list-alt","fa fa-lock","fa fa-flag","fa fa-headphones","fa fa-volume-off","fa fa-volume-down","fa fa-volume-up","fa fa-qrcode","fa fa-barcode","fa fa-tag","fa fa-tags","fa fa-book","fa fa-bookmark","fa fa-print","fa fa-camera","fa fa-font","fa fa-bold","fa fa-italic","fa fa-text-height","fa fa-text-width","fa fa-align-left","fa fa-align-center","fa fa-align-right","fa fa-align-justify","fa fa-list","fa fa-dedent","fa fa-outdent","fa fa-indent","fa fa-video-camera","fa fa-photo","fa fa-image","fa fa-picture-o","fa fa-pencil","fa fa-map-marker","fa fa-adjust","fa fa-tint","fa fa-edit","fa fa-pencil-square-o","fa fa-share-square-o","fa fa-check-square-o","fa fa-arrows","fa fa-step-backward","fa fa-fast-backward","fa fa-backward","fa fa-play","fa fa-pause","fa fa-stop","fa fa-forward","fa fa-fast-forward","fa fa-step-forward","fa fa-eject","fa fa-chevron-left","fa fa-chevron-right","fa fa-plus-circle","fa fa-minus-circle","fa fa-times-circle","fa fa-check-circle","fa fa-question-circle","fa fa-info-circle","fa fa-crosshairs","fa fa-times-circle-o","fa fa-check-circle-o","fa fa-ban","fa fa-arrow-left","fa fa-arrow-right","fa fa-arrow-up","fa fa-arrow-down","fa fa-mail-forward","fa fa-share","fa fa-expand","fa fa-compress","fa fa-plus","fa fa-minus","fa fa-asterisk","fa fa-exclamation-circle","fa fa-gift","fa fa-leaf","fa fa-fire","fa fa-eye","fa fa-eye-slash","fa fa-warning","fa fa-exclamation-triangle","fa fa-plane","fa fa-calendar","fa fa-random","fa fa-comment","fa fa-magnet","fa fa-chevron-up","fa fa-chevron-down","fa fa-retweet","fa fa-shopping-cart","fa fa-folder","fa fa-folder-open","fa fa-arrows-v","fa fa-arrows-h","fa fa-bar-chart-o","fa fa-bar-chart","fa fa-twitter-square","fa fa-facebook-square","fa fa-camera-retro","fa fa-key","fa fa-gears","fa fa-cogs","fa fa-comments","fa fa-thumbs-o-up","fa fa-thumbs-o-down","fa fa-star-half","fa fa-heart-o","fa fa-sign-out","fa fa-linkedin-square","fa fa-thumb-tack","fa fa-external-link","fa fa-sign-in","fa fa-trophy","fa fa-github-square","fa fa-upload","fa fa-lemon-o","fa fa-phone","fa fa-square-o","fa fa-bookmark-o","fa fa-phone-square","fa fa-twitter","fa fa-facebook-f","fa fa-facebook","fa fa-github","fa fa-unlock","fa fa-credit-card","fa fa-feed","fa fa-rss","fa fa-hdd-o","fa fa-bullhorn","fa fa-bell","fa fa-certificate","fa fa-hand-o-right","fa fa-hand-o-left","fa fa-hand-o-up","fa fa-hand-o-down","fa fa-arrow-circle-left","fa fa-arrow-circle-right","fa fa-arrow-circle-up","fa fa-arrow-circle-down","fa fa-globe","fa fa-wrench","fa fa-tasks","fa fa-filter","fa fa-briefcase","fa fa-arrows-alt","fa fa-group","fa fa-users","fa fa-chain","fa fa-link","fa fa-cloud","fa fa-flask","fa fa-cut","fa fa-scissors","fa fa-copy","fa fa-files-o","fa fa-paperclip","fa fa-save","fa fa-floppy-o","fa fa-square","fa fa-navicon","fa fa-reorder","fa fa-bars","fa fa-list-ul","fa fa-list-ol","fa fa-strikethrough","fa fa-underline","fa fa-table","fa fa-magic","fa fa-truck","fa fa-pinterest","fa fa-pinterest-square","fa fa-google-plus-square","fa fa-google-plus","fa fa-money","fa fa-caret-down","fa fa-caret-up","fa fa-caret-left","fa fa-caret-right","fa fa-columns","fa fa-unsorted","fa fa-sort","fa fa-sort-down","fa fa-sort-desc","fa fa-sort-up","fa fa-sort-asc","fa fa-envelope","fa fa-linkedin","fa fa-rotate-left","fa fa-undo","fa fa-legal","fa fa-gavel","fa fa-dashboard","fa fa-tachometer","fa fa-comment-o","fa fa-comments-o","fa fa-flash","fa fa-bolt","fa fa-sitemap","fa fa-umbrella","fa fa-paste","fa fa-clipboard","fa fa-lightbulb-o","fa fa-exchange","fa fa-cloud-download","fa fa-cloud-upload","fa fa-user-md","fa fa-stethoscope","fa fa-suitcase","fa fa-bell-o","fa fa-coffee","fa fa-cutlery","fa fa-file-text-o","fa fa-building-o","fa fa-hospital-o","fa fa-ambulance","fa fa-medkit","fa fa-fighter-jet","fa fa-beer","fa fa-h-square","fa fa-plus-square","fa fa-angle-double-left","fa fa-angle-double-right","fa fa-angle-double-up","fa fa-angle-double-down","fa fa-angle-left","fa fa-angle-right","fa fa-angle-up","fa fa-angle-down","fa fa-desktop","fa fa-laptop","fa fa-tablet","fa fa-mobile-phone","fa fa-mobile","fa fa-circle-o","fa fa-quote-left","fa fa-quote-right","fa fa-spinner","fa fa-circle","fa fa-mail-reply","fa fa-reply","fa fa-github-alt","fa fa-folder-o","fa fa-folder-open-o","fa fa-smile-o","fa fa-frown-o","fa fa-meh-o","fa fa-gamepad","fa fa-keyboard-o","fa fa-flag-o","fa fa-flag-checkered","fa fa-terminal","fa fa-code","fa fa-mail-reply-all","fa fa-reply-all","fa fa-star-half-empty","fa fa-star-half-full","fa fa-star-half-o","fa fa-location-arrow","fa fa-crop","fa fa-code-fork","fa fa-unlink","fa fa-chain-broken","fa fa-question","fa fa-info","fa fa-exclamation","fa fa-superscript","fa fa-subscript","fa fa-eraser","fa fa-puzzle-piece","fa fa-microphone","fa fa-microphone-slash","fa fa-shield","fa fa-calendar-o","fa fa-fire-extinguisher","fa fa-rocket","fa fa-maxcdn","fa fa-chevron-circle-left","fa fa-chevron-circle-right","fa fa-chevron-circle-up","fa fa-chevron-circle-down","fa fa-html5","fa fa-css3","fa fa-anchor","fa fa-unlock-alt","fa fa-bullseye","fa fa-ellipsis-h","fa fa-ellipsis-v","fa fa-rss-square","fa fa-play-circle","fa fa-ticket","fa fa-minus-square","fa fa-minus-square-o","fa fa-level-up","fa fa-level-down","fa fa-check-square","fa fa-pencil-square","fa fa-external-link-square","fa fa-share-square","fa fa-compass","fa fa-toggle-down","fa fa-caret-square-o-down","fa fa-toggle-up","fa fa-caret-square-o-up","fa fa-toggle-right","fa fa-caret-square-o-right","fa fa-euro","fa fa-eur","fa fa-gbp","fa fa-dollar","fa fa-usd","fa fa-rupee","fa fa-inr","fa fa-cny","fa fa-rmb","fa fa-yen","fa fa-jpy","fa fa-ruble","fa fa-rouble","fa fa-rub","fa fa-won","fa fa-krw","fa fa-bitcoin","fa fa-btc","fa fa-file","fa fa-file-text","fa fa-sort-alpha-asc","fa fa-sort-alpha-desc","fa fa-sort-amount-asc","fa fa-sort-amount-desc","fa fa-sort-numeric-asc","fa fa-sort-numeric-desc","fa fa-thumbs-up","fa fa-thumbs-down","fa fa-youtube-square","fa fa-youtube","fa fa-xing","fa fa-xing-square","fa fa-youtube-play","fa fa-dropbox","fa fa-stack-overflow","fa fa-instagram","fa fa-flickr","fa fa-adn","fa fa-bitbucket","fa fa-bitbucket-square","fa fa-tumblr","fa fa-tumblr-square","fa fa-long-arrow-down","fa fa-long-arrow-up","fa fa-long-arrow-left","fa fa-long-arrow-right","fa fa-apple","fa fa-windows","fa fa-android","fa fa-linux","fa fa-dribbble","fa fa-skype","fa fa-foursquare","fa fa-trello","fa fa-female","fa fa-male","fa fa-gittip","fa fa-gratipay","fa fa-sun-o","fa fa-moon-o","fa fa-archive","fa fa-bug","fa fa-vk","fa fa-weibo","fa fa-renren","fa fa-pagelines","fa fa-stack-exchange","fa fa-arrow-circle-o-right","fa fa-arrow-circle-o-left","fa fa-toggle-left","fa fa-caret-square-o-left","fa fa-dot-circle-o","fa fa-wheelchair","fa fa-vimeo-square","fa fa-turkish-lira","fa fa-try","fa fa-plus-square-o","fa fa-space-shuttle","fa fa-slack","fa fa-envelope-square","fa fa-wordpress","fa fa-openid","fa fa-institution","fa fa-bank","fa fa-university","fa fa-mortar-board","fa fa-graduation-cap","fa fa-yahoo","fa fa-google","fa fa-reddit","fa fa-reddit-square","fa fa-stumbleupon-circle","fa fa-stumbleupon","fa fa-delicious","fa fa-digg","fa fa-pied-piper-pp","fa fa-pied-piper-alt","fa fa-drupal","fa fa-joomla","fa fa-language","fa fa-fax","fa fa-building","fa fa-child","fa fa-paw","fa fa-spoon","fa fa-cube","fa fa-cubes","fa fa-behance","fa fa-behance-square","fa fa-steam","fa fa-steam-square","fa fa-recycle","fa fa-automobile","fa fa-car","fa fa-cab","fa fa-taxi","fa fa-tree","fa fa-spotify","fa fa-deviantart","fa fa-soundcloud","fa fa-database","fa fa-file-pdf-o","fa fa-file-word-o","fa fa-file-excel-o","fa fa-file-powerpoint-o","fa fa-file-photo-o","fa fa-file-picture-o","fa fa-file-image-o","fa fa-file-zip-o","fa fa-file-archive-o","fa fa-file-sound-o","fa fa-file-audio-o","fa fa-file-movie-o","fa fa-file-video-o","fa fa-file-code-o","fa fa-vine","fa fa-codepen","fa fa-jsfiddle","fa fa-life-bouy","fa fa-life-buoy","fa fa-life-saver","fa fa-support","fa fa-life-ring","fa fa-circle-o-notch","fa fa-ra","fa fa-resistance","fa fa-rebel","fa fa-ge","fa fa-empire","fa fa-git-square","fa fa-git","fa fa-y-combinator-square","fa fa-yc-square","fa fa-hacker-news","fa fa-tencent-weibo","fa fa-qq","fa fa-wechat","fa fa-weixin","fa fa-send","fa fa-paper-plane","fa fa-send-o","fa fa-paper-plane-o","fa fa-history","fa fa-circle-thin","fa fa-header","fa fa-paragraph","fa fa-sliders","fa fa-share-alt","fa fa-share-alt-square","fa fa-bomb","fa fa-soccer-ball-o","fa fa-futbol-o","fa fa-tty","fa fa-binoculars","fa fa-plug","fa fa-slideshare","fa fa-twitch","fa fa-yelp","fa fa-newspaper-o","fa fa-wifi","fa fa-calculator","fa fa-paypal","fa fa-google-wallet","fa fa-cc-visa","fa fa-cc-mastercard","fa fa-cc-discover","fa fa-cc-amex","fa fa-cc-paypal","fa fa-cc-stripe","fa fa-bell-slash","fa fa-bell-slash-o","fa fa-trash","fa fa-copyright","fa fa-at","fa fa-eyedropper","fa fa-paint-brush","fa fa-birthday-cake","fa fa-area-chart","fa fa-pie-chart","fa fa-line-chart","fa fa-lastfm","fa fa-lastfm-square","fa fa-toggle-off","fa fa-toggle-on","fa fa-bicycle","fa fa-bus","fa fa-ioxhost","fa fa-angellist","fa fa-cc","fa fa-shekel","fa fa-sheqel","fa fa-ils","fa fa-meanpath","fa fa-buysellads","fa fa-connectdevelop","fa fa-dashcube","fa fa-forumbee","fa fa-leanpub","fa fa-sellsy","fa fa-shirtsinbulk","fa fa-simplybuilt","fa fa-skyatlas","fa fa-cart-plus","fa fa-cart-arrow-down","fa fa-diamond","fa fa-ship","fa fa-user-secret","fa fa-motorcycle","fa fa-street-view","fa fa-heartbeat","fa fa-venus","fa fa-mars","fa fa-mercury","fa fa-intersex","fa fa-transgender","fa fa-transgender-alt","fa fa-venus-double","fa fa-mars-double","fa fa-venus-mars","fa fa-mars-stroke","fa fa-mars-stroke-v","fa fa-mars-stroke-h","fa fa-neuter","fa fa-genderless","fa fa-facebook-official","fa fa-pinterest-p","fa fa-whatsapp","fa fa-server","fa fa-user-plus","fa fa-user-times","fa fa-hotel","fa fa-bed","fa fa-viacoin","fa fa-train","fa fa-subway","fa fa-medium","fa fa-yc","fa fa-y-combinator","fa fa-optin-monster","fa fa-opencart","fa fa-expeditedssl","fa fa-battery-4","fa fa-battery-full","fa fa-battery-3","fa fa-battery-three-quarters","fa fa-battery-2","fa fa-battery-half","fa fa-battery-1","fa fa-battery-quarter","fa fa-battery-0","fa fa-battery-empty","fa fa-mouse-pointer","fa fa-i-cursor","fa fa-object-group","fa fa-object-ungroup","fa fa-sticky-note","fa fa-sticky-note-o","fa fa-cc-jcb","fa fa-cc-diners-club","fa fa-clone","fa fa-balance-scale","fa fa-hourglass-o","fa fa-hourglass-1","fa fa-hourglass-start","fa fa-hourglass-2","fa fa-hourglass-half","fa fa-hourglass-3","fa fa-hourglass-end","fa fa-hourglass","fa fa-hand-grab-o","fa fa-hand-rock-o","fa fa-hand-stop-o","fa fa-hand-paper-o","fa fa-hand-scissors-o","fa fa-hand-lizard-o","fa fa-hand-spock-o","fa fa-hand-pointer-o","fa fa-hand-peace-o","fa fa-trademark","fa fa-registered","fa fa-creative-commons","fa fa-gg","fa fa-gg-circle","fa fa-tripadvisor","fa fa-odnoklassniki","fa fa-odnoklassniki-square","fa fa-get-pocket","fa fa-wikipedia-w","fa fa-safari","fa fa-chrome","fa fa-firefox","fa fa-opera","fa fa-internet-explorer","fa fa-tv","fa fa-television","fa fa-contao","fa fa-500px","fa fa-amazon","fa fa-calendar-plus-o","fa fa-calendar-minus-o","fa fa-calendar-times-o","fa fa-calendar-check-o","fa fa-industry","fa fa-map-pin","fa fa-map-signs","fa fa-map-o","fa fa-map","fa fa-commenting","fa fa-commenting-o","fa fa-houzz","fa fa-vimeo","fa fa-black-tie","fa fa-fonticons", "fa fa-pied-piper");
    }
}

if(!function_exists('insert_captcha')){
 	function insert_captcha($arr = array()){
 		$CI =& get_instance();
 		$captcha = create_captcha($arr);
		$data = array(
	        'captcha_time'  => $captcha['time'],
	        'ip_address'    => $CI->input->ip_address(),
	        'word'          => $captcha['word']
		);
		$query = $CI->db->insert_string('captcha', $data);
		$CI->db->query($query);
		return $captcha;
	}
}



if(!function_exists('delete_captcha')){
 	function delete_captcha($code = ''){
 		$CI =& get_instance();
 		// First, delete old captchas
		$expiration = time() - 300; // Two hour limit
		$CI->db->where('captcha_time < ', $expiration)->delete('captcha');
		// Then see if a captcha exists:
		if (!empty($code)) {
			$sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
			$binds = array($_POST['captcha'], $CI->input->ip_address(), $expiration);
			$query = $CI->db->query($sql, $binds);
			$row = $query->row();
			if ($row->count == 0){
		        return 'You must submit the word that appears in the image.';
			}
		}else{
			return 'Bạn phải nhập mã code bảo vệ.';
		}
	}
}

if(!function_exists('convert_date')){
	function convert_date($timed) {
		$string = '';
		$CI =& get_instance();
		$string .= ' '.switch_month(show_time($timed, 'm')).' ';
		$string .= ' '.show_time($timed, 'd');
		$string .= ', '.show_time($timed, 'Y');
		return $string;
	}
}
if(!function_exists('switch_month')){
	function switch_month($month) {
		switch ($month) {
			case '01':
				$month_value = 'Tháng Một';
				break;
			case '02':
				$month_value = 'Tháng Hai';
				break;
			case '03':
				$month_value = 'Tháng Ba';
				break;
			case '04':
				$month_value = 'Tháng Tư';
				break;
			case '05':
				$month_value = 'Tháng Năm';
				break;
			case '06':
				$month_value = 'Tháng Sáu';
				break;
			case '07':
				$month_value = 'Tháng Bảy';
				break;
			case '08':
				$month_value = 'Tháng Tám';
				break;
			case '09':
				$month_value = 'Tháng Chín';
				break;
			case '10':
				$month_value = 'Tháng Mười';
				break;
			case '11':
				$month_value = 'Tháng Mười một';
				break;
			
			default:
				$month_value = 'Tháng Mười hai';
				break;
		}
		echo $month_value;
	}
}
if(!function_exists('Load_place')){
	function Load_place($projectid = 0, $wardid = 0, $districtid = 0){
		$CI =& get_instance();
		if ($projectid != 0) {
			$result = $CI->FrontendProjects_Model->read_place($projectid);
		}elseif ($wardid != 0) {
			$result = $CI->FrontendProjects_Model->read_location($wardid);
		}elseif ($districtid != 0) {
			$result = $CI->FrontendProjects_Model->read_location($districtid);
		}else{
			$result = '...';
		}	
		return $result;
	}
}
if(!function_exists('Load_catagoies')){
	function Load_catagoies($arr = '', $modules = 'articles'){
		$CI =& get_instance();
		$CI->load->model('Autoload_model');
		$atr = '';
		if (isset($arr) && is_array($arr) && count($arr)) {
			foreach ($arr as $key => $val) {
				$atr[] = $CI->Autoload_model->_get_where(array(
					'select'=>'id, title, slug, canonical',
					'table' => $modules.'_catalogues',
					'where' => array('id' => $val),
					'order_by' => 'order desc',
				), FALSE);
			}
		}
		return $atr;
	}
}
if(!function_exists('code_generator')){
	function code_generator($module = ''){
		$CI =& get_instance();
		$user = $CI->config->item('fcUser');
		$CI->db->select('id');
		$CI->db->from($module);
		$CI->db->where(array('trash' => 0));
		$CI->db->order_by('id desc');
		$result = $CI->db->get()->row_array();
		$code = '#'.$user['id'].'_'.(10000+$result['id']+1);
		return $code;
	}
}


if(!function_exists('getCurrentPageURL')){
	function getCurrentPageURL() {
	    $pageURL = 'http';
	    if (!empty($_SERVER['HTTPS'])) {if($_SERVER['HTTPS'] == 'on'){$pageURL .= "s";}}
	    $pageURL .= "://";
	    if ($_SERVER["SERVER_PORT"] != "80") {
	        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	    } else {
	        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	    }
	    return $pageURL;
	}
}
if(!function_exists('links_share')){
	function links_share(){
		?>
			<div class="connenct mt-flex mt-flex-bottom">
				<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo getCurrentPageURL(); ?>"></div>
				<div class="fb-like" data-href="<?php echo getCurrentPageURL(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
			</div>
		<?php
	}
}

if(!function_exists('coment_fb')){
	function coment_fb()
	{
		?>
			<div class="comment_fb">
				<div class="fb-comments" data-href="<?php echo getCurrentPageURL(); ?>" data-numposts="5" data-width="100%" ></div>
			</div>
		<?php
	}
}

if(!function_exists('show_flashdata')){
	function show_flashdata($body = TRUE){
		$result = '';
		$CI =& get_instance();
		$message = $CI->session->flashdata('message-success');
		if(isset($message)){
			if($body == TRUE) $result = $result . '<div class="box-body">';
			$result = $result . '<div class="callout callout-success">';
			$result = $result . '<p>'.$message.'</p>';
			$result = $result . '</div>';
			if($body == TRUE) $result = $result . '</div><!-- /.box-body -->';
			return $result;
		}
		$message = $CI->session->flashdata('message-danger');
		if(isset($message)){
			if($body == TRUE) $result = $result . '<div class="box-body">';
			$result = $result . '<div class="callout callout-danger">';
			$result = $result . '<p>'.$message.'</p>';
			$result = $result . '</div>';
			if($body == TRUE) $result = $result . '</div><!-- /.box-body -->';
			return $result;
		}
	}
}

if(!function_exists('selecteddropdown')){
	function selecteddropdown($dropdown = NULL){
		$temp = NULL;
		foreach($dropdown as $key => $val){
			$temp[] = $key;
		}
		return $temp;
	}
}

if(!function_exists('convert_time')){
	function convert_time($time = ''){
		if($time == '' || $time == '0000-00-00 00:00:00') return '0000-00-00 00:00:00';
		$current = explode('-', $time);
		$date = explode('/', trim($current[1]));
		$time_stamp = $date[2].'-'.$date[1].'-'.$date[0].' '.trim($current[0]).':00';
		return $time_stamp;
	}
}

if(!function_exists('convert_time_2')){
	function convert_time_2($time = ''){
		if($time == '' || $time == '0000-00-00 00:00:00') return '0000-00-00 00:00:00';
		$current = explode(' ', $time);
		$date = explode('/', trim($current[0]));
		$time_stamp = $date[2].'-'.$date[1].'-'.$date[0].' '.trim($current[1]);
		return $time_stamp;
	}
}

if(!function_exists('convert_time_3')){
	function convert_time_3($time = ''){
		$date = explode('-', trim($time));
		$time_stamp = $date[2].'/'.$date[1].'/'.$date[0];
		return $time_stamp;
	}
}

if(!function_exists('remake_array')){
	function remake_array($array = '', $keyword = ''){
		$temp = '';
		if(isset($array) && is_array($array) && count($array)){
			foreach($array as $key => $val){
				$temp[] = $val[$keyword];
			}
		}
		return $temp;
	}
}
if(!function_exists('get_videos_code')){
	function get_videos_code($url = ''){
		$result = '';
		if(!empty($url)) {
			$result = explode('?v=', $url);
		}
		return $result[1];
	}
}

if(!function_exists('location_dropdown')){
	function location_dropdown($keyword = '', $where = ''){
		$dropdown[0] = '--'.$keyword.'--';
		$CI =& get_instance();
		$CI->load->model('Autoload_model');
		$result = $CI->Autoload_model->_get_where(array(
			'select'=>'id, title',
			'table' => 'province',
			'where' => $where,
			'order_by' => 'order desc, title asc',
		), TRUE);
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}
}


if(!function_exists('percent')){
	function percent($price = 0, $saleoff = 0){
		$percent = ($price - $saleoff)/$price*100;
		return $percent;
	}
}


if(!function_exists('check_delete')){
	function check_delete($param = '', $modules = 'articles'){
		// param là list các id bài viết, sản phẩm ... 
		$CI =& get_instance();
		$CI->load->model('routers/BackendRouters_Model');
		$model = 'Backend'.ucfirst($modules).'_Model';
		$flag = 0;
		$_temp_ = '';
		$_list_ = $CI->$model->_get_where(array(
			'select' => 'id, slug, canonical, catalogues',
			'table' => $modules,
			'where' => array('trash' => 0),
			'where_in' => $param,
			'where_in_field' => 'id'
		), TRUE);
		
		
		if(isset($_list_) && is_array($_list_) && count($_list_)){
			foreach($_list_ as $key => $val){
				$json_decode_catalogues = json_decode($val['catalogues'], TRUE);
				if(count($json_decode_catalogues) == 1){
					// xóa trong catalogues relationship
					$CI->$model->_delete_relationship($modules, $val['id']);
					$_temp_[] = array(
						'id' => $val['id'],
						'canonical' => $val['canonical'],
					); // mảng id của những bài viết sẽ xóa
				}
			}
		}
		
		if(isset($_temp_) && is_array($_temp_) && count($_temp_)){
			foreach($_temp_ as $key => $val){
				// xóa trong bảng routers
				$CI->BackendRouters_Model->Delete($val['canonical'], $modules.'/frontend/'.$modules.'/view', $val['id'], 'number');
				// xóa bài viết --> cập nhật canonical bài viết về 0
				$_update_['table'] = $modules;
				$_update_['where'] = array('id' => $val['id'],);
				$_update_['data'] = array('trash' => 1,'canonical' => '');
				$CI->$model->_delete($_update_);
			}
		}
		
	}
}



if(!function_exists('catalogues_relationship')){
	function catalogues_relationship($cataloguesid = 0, $modules = 'articles', $model = '', $table = 'articles', $lang = 'vietnamese', $param = ''){
		$CI =& get_instance();
		if(isset($model) && is_array($model) && count($model)){
			foreach($model as $key => $val){
				$CI->load->model($modules.'/'.$val.'_Model');
			}
		}
		
		$model_cat = $model[1].'_Model';

		$detail_catalogues = $CI->$model_cat->_get_where(array(
			'table' => $table,
			'where' => array('id' => $cataloguesid, 'alanguage' => $lang),
			'select' => 'id, title, slug, canonical, lft, rgt',
			'trash' => 0
		), FALSE);
		
		$_id_list = '';
		$_article_id_list = '';
		$result_1 = '';
		if($detail_catalogues['rgt'] - $detail_catalogues['lft'] > 1){
			$result = $CI->$model_cat->_get_where(array(
				'table' => $table,
				'where' => array(
					'lft >=' => $detail_catalogues['lft'],
					'rgt <=' => $detail_catalogues['rgt'],
					'trash' => 0,
				),
				'select' => 'id',
			), TRUE);
			if(isset($result) && is_array($result) && count($result)){
				foreach($result as $key => $val){
					$_id_list[] = $val['id'];
				}
			}
			if(isset($_id_list) && is_array($_id_list) && count($_id_list)){
				$result_1 = $CI->db->select('modulesid')->from('catalogues_relationship')->where(array('modules'=> $modules))->where_in('cataloguesid', $_id_list)->group_by('modulesid')->get()->result_array();
			}
		}else{
			$result_1 = $CI->db->select('modulesid')->from('catalogues_relationship')->where(array('cataloguesid'=> $cataloguesid, 'modules'=> $modules))->get()->result_array();

		}
		if(isset($result_1) && is_array($result_1) && count($result_1)){
			foreach($result_1 as $key => $val){
				$_article_id_list[] = $val['modulesid'];
			}
		}
		
		return $_article_id_list;
	}
}

if(!function_exists('user_statistic')){
	function user_statistic($week = ''){
		$CI =& get_instance();
		$day = date('w');
		$temp['week_start'] = date('Y-m-d', strtotime('-'.$day.' days')).' 00:00:00';
		$temp['week_end'] = date('Y-m-d', strtotime('+'.(6-$day).' days')).' 00:00:00';
		$temp_1 = '';
		if($week == 'current'){
			$CI->db->select('*, DATE_FORMAT(created,\'%a\') AS daybyday ');
			$CI->db->from('users_online');
			$CI->db->where(array(
				'created >=' => $temp['week_start'],
				'created <=' => $temp['week_end'],
			));
			$result = $CI->db->get()->result_array();
			$temp_1 = converday($result);
			return $temp_1;
		}
		if($week = 'lastweek'){
			$previous_week = strtotime("-1 week +1 day");
			$start_week = strtotime("last sunday midnight",$previous_week);
			$end_week = strtotime("next saturday",$start_week);

			$temp['week_start'] = date("Y-m-d",$start_week);
			$temp['week_end'] = date("Y-m-d",$end_week);
			$CI->db->select('*, DATE_FORMAT(created,\'%a\') AS daybyday ');
			$CI->db->from('users_online');
			$CI->db->where(array(
				'created >=' => $temp['week_start'],
				'created <=' => $temp['week_end'],
			));
			$result = $CI->db->get()->result_array();
			$temp_1 = converday($result);
			return $temp_1;
		}
	}
}

if(!function_exists('converday')){
	function converday($param = ''){
		$CI =& get_instance();
		$result = '';
		$date = array('Mon', 'Tue', 'Wed','Thu','Fri', 'Sat','Sun');
		foreach($date as $key => $val){
			$result[] = array(
				'value' => count_array_by_value($param, $val),
			); 
				
		}
		return $result;
		// $timestamp = gmdate('D', strtotime($val['created'])+7*3600);
		// echo gmdate('D', strtotime('2016-11-22')+7*3600);die();
	
	}
}

if(!function_exists('count_array_by_value')){
	function count_array_by_value($array = '', $value = 0, $keyword = 'daybyday'){
		$total = 0;
		foreach($array as $key => $val){
			if($val[$keyword] == $value){
				$total = $total + 1;
			}
		}
		return $total;
	
	}
}

if(!function_exists('count_array_by_condition')){
	function count_array_by_condition($array = '', $value = 0, $keyword = 'district'){
		$total = 0;
		foreach($array as $key => $val){
			if($val[$keyword] == $value){
				$total = $total + $val['price']*$val['quantity'];
			}
		}
		return $total;
	
	}
}


if(!function_exists('mail_html')){
	function mail_html($param = NULL){
		$CI =& get_instance();
		return '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><section style="max-width:600px;margin:0 auto;background:#f8f8f8;border:1px solid #d8d8d8; font-family:Arial,sans-serif; font-size:14px;line-height:20px; border-radius: 10px; margin-top: 30px;"><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;"><h1 style="box-sizing:border-box;text-align:center;margin:-20px 0 10px 0;"><span style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;display: inline-block;padding: 7px 30px;line-height: 24px;font-size: 16px;color: #00af1d;font-weight: bold;text-align: center;text-transform: uppercase;background: #fff;border-radius: 20px;box-shadow: 0 1px 2px 0 rgba(0,0,0,.16);-webkit-transform: translate(0, -50%);-ms-transform: translate(0, -50%);-o-transform: translate(0, -50%);transform: translate(0, -50%);"> Đặt hàng thành công</span></h1><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;padding: 0 20px 20px 20px;"><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;margin-bottom: 20px;">Cảm ơn <strong style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;">anh '.$param['fullname'].'</strong> đã cho '.$param['web'].' cơ hội được phục vụ. Nhân viên sẽ liên hệ lại với anh để xác nhận thông tin đặt hàng trong 5 phút.</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;padding: 5px 10px;margin-bottom: 10px;font-weight: bold;background: #f3f3f3;">Thông tin đặt hàng:</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;"><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Họ và tên: '.$param['fullname'].'</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Điện thoại: '.$param['phone'].'</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Phường/xã: '.$param['phuongxa'].'</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Quận/huyện: '.$param['quanhuyen'].'</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Tinht/thành phố: '.$param['tinhthanhpho'].'</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Địa chỉ nhận hàng: '.$param['address'].'</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Ghi chú: '.$param['message'].'</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;"><strong style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;">Phương thức vận chuyển: '.$param['shipcode'].'</strong></div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;"><strong style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;">Phương thức thanh toán: '.$param['payments'].'</strong></div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Phí ship: <span style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-weight: bold;color: #c10017;">'.(str_replace(',','.', number_format($param['shipcode_value']))).'₫</span></div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;position: relative;padding-left: 15px;margin-bottom: 5px;">Tổng tiền thanh toán: <span style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-weight: bold;color: #c10017;">'.(str_replace(',','.', number_format($param['total_price_1']))).'₫</span></div></div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;margin-bottom: 20px;">Trước khi giao nhân viên sẽ liên lạc với anh <strong style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;"> '.$param['fullname'].'</strong> để xác nhận. Khi cần trợ giúp vui lòng gọi <a href="tel:'.$param['HOTLINE_goimuahang_phone'].'" title="" style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-weight: bold;color: #288ad6;">'.$param['HOTLINE_goimuahang_phone'].'</a> hoặc góp ý, khiếu nại về sản phẩm vui lòng gọi <a href="tel:'.$param['HOTLINE_khieunai_phone'].'" title="" style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-weight: bold;color: #288ad6;">'.$param['HOTLINE_khieunai_phone'].'</a> (7h30 - 22h)</div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;padding: 5px 10px;margin-bottom: 10px;font-weight: bold;background: #f3f3f3;">Sản phẩm đã mua:</div><ul style="margin: 0;padding: 0;list-style: none;-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;">'.$param['product'].'</ul><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;text-align: center;margin-top: 30px;"><a href="'.$param['web'].'" title="" style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;text-decoration: none;display: inline-block;overflow: hidden;background: #fff;line-height: 40px;width: 250px;font-size: 14px;color: #288ad6;font-weight: 600;text-transform: uppercase;border: 1px solid #288ad6;border-radius: 4px;-webkit-transition: all .25s linear;-o-transition: all .25s linear;transition: all .25s linear;">Mua thêm sản phẩm khác</a></div></div></div></section>';
	}
}