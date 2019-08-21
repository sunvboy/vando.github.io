<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		$this->load->model(array(
			'BackendProducts_Model',
			'FrontendProducts_Model',
		));
		$this->load->library('cart');
	}
	
	public function apply_gift_code(){
		$giftcode = $this->input->post('giftcode');
		$alert = array(
			'error' => '',
			'message' => '',
			'typeoff' => '',
			'price' => 0,
			'result' => ''
		);
		if (!empty($giftcode)) {
			// Check sự tồn tại của Giftcode
			$check_gift = $this->FrontendProducts_Model->_read(array(
				'select' => '*',
				'table' => 'coupon',
				'where' => array('publish' => 1, 'trash' => 0, 'couponCode' => $giftcode),
			));
			// Check tổng tiền của giỏ hàng đang xủa lý
			$total_cart = 0;
			$cart = $this->cart->contents();
			if(isset($cart) && is_array($cart) && count($cart)){
				foreach($cart as $keycart => $valcart){
					$total_cart += $valcart['subtotal'];
				}
			}
			//
			if (isset($check_gift) && is_array($check_gift) && count($check_gift)) {
				if (!empty($check_gift['status'])) {
					$alert['error'] = 'Mã Gift Code đã được sử dụng';
				}else{
					$check = 1; // Không có lỗi
					// Kiểm tra hiệu lực của mã Gift code
					$timed = gmdate('Y-m-d H:i:s', time() + 7 * 3600 + 180);
					if (!empty($check_gift['scheduleEndDate'])) {
						// Có giới hạn ngày sư dụng gift code
						if ($timed > $check_gift['date_end'] || $timed < $check_gift['date_start']) {
							$alert['error'] = 'Mã Gift Code áp dụng trong khoảng thời gian từ '.$check_gift['date_start'].' đến '.$check_gift['date_end'].'';
							$check = 0; // Xảy ra lỗi
						}
					}
					if (!empty($check_gift['requiresMinimumPurchase'])) {
						// Nếu Gift code có áp dụng cho giá trị đơn hàng tối thiểu
						if ($total_cart < $check_gift['minimumPurchase']) {
							// Tổng giá trị đơn hàng nhỏ hơn mức áo dụng tối thiểu
							$alert['error'] = 'Mã Gift Code áp dụng cho đơn hàng có giá trị tối thiểu là '.str_replace(',', '.', number_format($check_gift['minimumPurchase'])).' vnđ.';
							$check = 0; // Xảy ra lỗi
						}
					}
					if (!empty($check)){
						if (!empty($check_gift['limitTotalUse'])) {
							// Nếu có giới hạn số lần sử dụng mã
							$limit = $this->FrontendProducts_Model->_countTable(array(
								'table' => 'coupon_relationship',
								'where' => array('couponid' => $check_gift['id']),
							));
							// Kiểm tra bảng relationship số lần mã này đã được sử dụng
							if ($limit >= $check_gift['limitedUseTotal']) {
								// Nếu số lần sử dụng đã hết
								$alert['error'] = 'Số lần sử dụng Mã Gift Code đã hết';
								$check = 0; // Xảy ra lỗi
							}
						}
						if (!empty($check)){
							// Kiểm tra mã code áp dụng cho trường hợp nào
							if ($check_gift['appliesTo'] == 'cart') {// Áp dụng cho toàn bộ đơn hàng
								// Kiểm tra gift code giảm giá theo phương thức nào
								$alert['result'] = $check_gift['couponTypeValue'];
								$alert['typeoff'] = ((!empty($check_gift['couponType'])) ? '0' : '1');
								if (!empty($check_gift['couponType'])) {
									# Mã giảm giá theo số tiền 
									$alert['price'] = $check_gift['couponTypeValue'];
									$alert['message'] = 'Mã Gift code có giá trị là '.str_replace(',', '.', number_format($check_gift['couponTypeValue'])).' đ trên tổng giá trị đơn hàng';
								}else{
									# Mã giảm giá theo phần trăm
									$alert['price'] = (($total_cart/100)*$check_gift['couponTypeValue']);
									$alert['message'] = 'Mã Gift code có giá trị là '.$check_gift['couponTypeValue'].' % trên tổng giá trị đơn hàng';
								}
							// END áp dụng cho đơn hàng
							}elseif ($check_gift['appliesTo'] == 'collections') {
								// Áp dụng cho danh mục sản phẩm
								// Kiểm tra sản phẩm trong đơn hàng có nằm trong danh sách các danh mục áp dụng khuyến mại không
								if (isset($cart) && is_array($cart) && count($cart)) {
									$price = 0;
									$i = 0;
									foreach ($cart as $key => $val) {
										$catalogues = check_catalogues_products_version($val['id']);// Lấy thông tin danh mục của sản phẩm
										$list_collection = json_decode($catalogues, TRUE);
										foreach ($list_collection as $key => $vals) {
											if (in_array($vals, explode('-', $check_gift['CollectionId']))) {
												// Nếu sản phẩm này nằm trong danh sách danh mục áp dụng chương trình khuyến mại
												// Kiểm tra gift code giảm giá theo phương thức nào
												$alert['result'] = $check_gift['couponTypeValue'];
												$alert['typeoff'] = ((!empty($check_gift['couponType'])) ? '0' : '1');
												if (!empty($check_gift['couponType'])) {
													# Mã giảm giá theo số tiền 
													$price += $check_gift['couponTypeValue'];
												}else{
													# Mã giảm giá theo phần trăm
													$price += (($val['subtotal']/100)*$check_gift['couponTypeValue']);
												}
												$i++;
											}
										}
									}
									if (!empty($price)) {
										$alert['price'] = $price;
										$alert['message'] = 'Mã Gift code có giá trị là '.str_replace(',', '.', number_format($check_gift['couponTypeValue'])).' '.((!empty($check_gift['couponType'])) ? 'vnđ' : '%').'. Áp dụng cho '.$i.' sản phẩm bạn đang đặt hàng.';
									}
								}
							}else{
								// Áp dụng cho danh sách sản phẩm
								// Kiểm tra sản phẩm trong đơn hàng có nằm trong danh sách các danh mục áp dụng khuyến mại không
								if (isset($cart) && is_array($cart) && count($cart)) {
									$price = 0;
									$i = 0;
									foreach ($cart as $key => $val) {
										if (in_array($val['id'], explode('-', $check_gift['ProductsId']))) {
											// Nếu sản phẩm này nằm trong danh sách danh mục áp dụng chương trình khuyến mại
											// Kiểm tra gift code giảm giá theo phương thức nào
											$alert['result'] = $check_gift['couponTypeValue'];
											$alert['typeoff'] = ((!empty($check_gift['couponType'])) ? '0' : '1');
											if (!empty($check_gift['couponType'])) {
												# Mã giảm giá theo số tiền 
												$price += $check_gift['couponTypeValue'];
											}else{
												# Mã giảm giá theo phần trăm
												$price += (($val['subtotal']/100)*$check_gift['couponTypeValue']);
											}
											$i++;
										}
									}
									if (!empty($price)) {
										$alert['price'] = $price;
										$alert['message'] = 'Mã Gift code có giá trị là '.str_replace(',', '.', number_format($check_gift['couponTypeValue'])).' '.((!empty($check_gift['couponType'])) ? 'vnđ' : '%').'. Áp dụng cho '.$i.' sản phẩm bạn đang đặt hàng.';
									}
								}
							}
						}
					}
				}
			}else{
				$alert['error'] = 'Mã Gift Code không tồn tại';
			}
		}else{
			$alert['error'] = 'Vui lòng nhập mã code';
		}
		echo json_encode($alert);die;
	}

	public function ajax_shipcode(){
		$check = $this->input->post('check');
		$id_list = $this->input->post('id_list');
		$shipcode = $this->input->post('shipcode');
		$price = $total = 0;
//		if (!empty($shipcode) && !empty($id_list)) {
//			$id_arr = explode('-', $id_list);
//			for ($i=0; $i < count($id_arr); $i++) {
//				$price += check_shipping_products($id_arr[$i], $shipcode);
//			}
//		}
		if($check == 1){
			$price += '0';
		}else{
			if($shipcode == 'shop'){
				$price += '30000';

			}else if($shipcode = 'inner'){
				$price += '9000';

			}
		}
		echo json_encode(array('price' => $price));die;
	}


	public function save(){
		sleep(1);
		$post = $this->input->post('post');
		$data = '';
		$flag = 0;
		if(isset($post) && is_array($post) && count($post)){
			foreach($post as $key => $val){
				// if(($val['name'] != 'cityid' || $val['name'] != 'districtid')) continue;
				$data[$val['name']] = $val['value'];
			}
		}
		if(isset($data) && is_array($data) && count($data)){
			$this->db->where('id', $data['id']);
			$this->db->update('payments', $data);
			$this->db->flush_cache();
			$flag = 1;
		}
		echo $flag;die();
	}
	
	
	public function notification(){
		echo json_encode(array(
			'item' => number_format($this->cart->total_items()),
			'total' => number_format($this->cart->total()),
		));
	}
	
	public function ajax_location(){
		$cityid = $this->input->post('cityid');
		// $result = location_dropdown('Quận/Huyện', array('parentid' => $cityid));
		$response = sendRequestNhanhVN('/api/shipping/location', array("type" => "DISTRICT", "parentId" => $cityid));
		$option = '<option value="">-- Chọn Quận/Huyện --</option>';
		if ($response->code) {
			foreach($response->data as $location) {
              	$option = $option.'<option value="'.$location->id.'">'.$location->name.'</option>';
            }
		}
		echo json_encode(array(
			'option' => $option,
		)); die();
	}
	
	public function updateitemcart(){
		$qty = $this->input->post('qty');
		$rowid = $this->input->post('rowid');
		$cart = $this->cart->contents();
		$result = NULL;
		if(isset($cart) && is_array($cart) && count($cart)){
			foreach($cart as $keyMain => $valMain){
				if ($valMain['rowid'] == $rowid) {
					$valMain['qty'] = $qty;
				}
				$result[] = $valMain;
			}
			$cart = $valMain;
		}
		$this->cart->update($result);
		print_r($result);
	}

	public function deletecart(){
		$id = $this->input->post('idprd');
		// $cart = $this->cart->contents();
		$cart = $this->cart->remove($id);
		$this->cart->update();
		print_r($id);
	}

	public function deltocart(){
		$id = (int)$this->input->post('id');
		$cart = $this->cart->contents();
		if(isset($cart) && is_array($cart) && count($cart)){
			// Kiểm tra id sp đã tồn tại chưa
			foreach($cart as $key => $val){
				if ($id == $val['id']) {
					// nếu tồn tại sản phẩm này trong gỏ hàng tiến hành xóa sản phẩm đó
					$cart = $this->cart->remove($val['rowid']);
					$this->cart->update();
				}
			}
		}
	}

	public function addalltocart(){
		$id = $this->input->post('id');
		$option = $this->input->post('option');
		$arr = explode('-', $id);
		if (isset($arr) && is_array($arr) && count($arr)) {
			for ($i=0; $i < count($arr) ; $i++) {
				$products = $this->FrontendProducts_Model->ReadByField('id', $arr[$i], $this->fc_lang);
				$globalprice = ($products['saleoff'])?$products['saleoff']:$products['saleoff'];
				//Size: 40,Màu: Đỏ
				$options = array();
				if (!empty($option) && $i == 0) {
					$arr_ = explode(',', $option);
					foreach ($arr_ as $val) {
						$arr__ = explode(':', $val);
						for ($j=0; $j < count($arr__) ; $j++) { 
							$options[$arr__[0]] = trim($arr__[1]);
						}
					}
				}
				$data = array(
					'id' => $arr[$i],
					'name' => ((!empty($products['sub_title'])) ? $products['sub_title'].' - ' : '').$products['title'],
					'type_aff' => $products['type_aff'],
					'qty' => 1,
					'price' => $globalprice,
					'options' => $options,
				);
				$this->cart->insert($data);
			}
		}
		$cart = $this->cart->contents();
		
		if(isset($cart) && is_array($cart) && count($cart)){
			$temp = NULL;
			foreach($cart as $keyMain => $valMain){
				$temp[] = $valMain['id'];
			}
			if(isset($temp) && is_array($temp) && count($temp)){
				$product = $this->FrontendProducts_Model->_get_where(array(
					'select' => 'id, title, slug, canonical, images, price, saleoff, weight, sku',
					'where' => array('publish' => 1,'trash' => 0, 'alanguage' => $this->fc_lang),
					'table'=> 'products',
					'where_in' => $temp,
					'where_in_field' => 'id',
				), TRUE);
			}
			$temp = NULL;
			foreach($cart as $keyMain => $valMain){
				foreach($product as $keyItem => $valItem){
					if($valItem['id'] == $valMain['id']){
						$valMain['detail'] = $valItem;
					}
				}
				$temp[] = $valMain;
			}
			$cart = $temp;
		}
		
		$html = '';

		$html = $html . '<div id="ec-module-cart">';
			$html = $html . '<section class="uk-panel buynow-2">';
				$html = $html . '<form action="" id="ajax-cart-form">';
					$html = $html . '<header class="panel-head mb15">';
						$html = $html . '<h1 class="heading"><span class="text">'.$this->lang->line('cart_products_title').' ('.number_format($this->cart->total_items()).' '.$this->lang->line('products').')</span></h1>';
					$html = $html . '</header><!-- .header -->';
					$html = $html . '<div class="panel-body">';
						$html = $html . '<ul class="uk-list mt-clearfix list-cart-heading">';
							$html = $html . '<li class="item product">'.$this->lang->line('product').'</li>';
							$html = $html . '<li class="item prices text-right none-768">'.$this->lang->line('cart_products_price').'</li>';
							$html = $html . '<li class="item count text-center">'.$this->lang->line('cart_products_number').'</li>';
							$html = $html . '<li class="item prices text-right">'.$this->lang->line('cart_products_total').'</li>';
						$html = $html . '</ul>';
						$html = $html . '<div id="scrollbar" class="uk-overflow-container cart-scrrolbar">';
							$html = $html . '<div class="list-order">';
								$i = 1;
								foreach($cart as $key => $val){
									$val['detail']['href'] = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products');
								$html = $html . '<div class="item">';
									$html = $html . '<ul class="uk-list mt-clearfix list-item-cart">';
										$html = $html . '<li class="product">';
											$html = $html . '<div class="mt-flex">';
												$html = $html . '<div class="thumb"><a class="link mt-scaledown" href="'.$val['detail']['href'].'" title="'.htmlspecialchars($val['detail']['title']).'" target="_blank"><img src="'.getthumb($val['detail']['images']).'" alt="'.htmlspecialchars($val['detail']['title']).'" /></a></div>';
												$html = $html . '<div class="info">';
													$html = $html . '<div class="title ec-line-3 mb10"><a class="link" href="'.$val['detail']['href'].'" title="'.htmlspecialchars($val['detail']['title']).'" target="_blank">'.$val['detail']['title'].'</a></div>';
													$html = $html . '<button class="delete"><i class="fa fa-trash"></i> '.$this->lang->line('remove_cart_item').'</button>';
												$html = $html . '</div>';
											$html = $html . '</div>';
										$html = $html . '</li>';
										$html = $html . '<li class="prices text-right none-768">';
										$price = ($val['detail']['saleoff'])?$val['detail']['saleoff']:$val['detail']['saleoff'];
										if(($val['detail']['saleoff'] > 0) && ($val['detail']['saleoff'] > 0)){
											$html = $html . '<span class="new">'.number_format($val['detail']['saleoff']).$this->lang->line('products_currency').'</span>';
											if($val['detail']['price'] > 0 && $val['detail']['price'] > $val['detail']['saleoff']){
												$html = $html . '<span class="old">'.number_format($val['detail']['price']).$this->lang->line('products_currency').'</span>';
											}
											if( $val['detail']['saleoff'] < $val['detail']['price']){
												$html = $html . '<span class="saleoff">-'.round((($val['detail']['price'] - $val['detail']['saleoff']) / $val['detail']['price']) * 100).'%</span>';
											}
										}
										else{
											$html = $html . '<span class="new">'.number_format($val['detail']['saleoff']).$this->lang->line('products_currency').'</span>';
										}
										$html = $html . '</li>';
										$html = $html . '<li class="count">';
											$html = $html . '<div class="uk-position-relative">';
												$html = $html . form_hidden($i.'[rowid]', $val['rowid']);
												$html = $html . form_input(array(
													'name' => $i.'[qty]',
													'value' => set_value($i.'[qty]', $val['qty']),
													'class' => 'quantity ajax-quantity',
												));
												$html = $html . '<span class="btns abate"></span>';
												$html = $html . '<span class="btns augment"></span>';
											$html = $html . '</div>';
										$html = $html . '</li>';
										$html = $html . '<li class="prices text-right"><span>'.number_format($price * $val['qty']).$this->lang->line('products_currency').'</span></li>';
									$html = $html . '</ul><!-- .list-order -->';
								$html = $html . '</div>';
								$i++;
								}
							$html = $html . '</div>';
						$html = $html . '</div>';
					$html = $html . '</div><!-- .panel-body -->';
					$html = $html . '<div class="panel-foot">';
						$html = $html . '<div class="total text-right mb10">';
							$html = $html . '<span class="price_tt">'.$this->lang->line('cart_money_total').': <strong id="ajax-cart-totalprice">'.number_format($this->cart->total()).'₫</strong></span>';
							// $html = $html . '<p>Giá đã bao gồm VAT</p>';
						$html = $html . '</div>';
						$html = $html . '<div class="action mt-flex mt-flex-middle mt-flex-space-between">';
							$html = $html . '<a class="continue ec-cart-continue"><i class="fa fa-caret-left"></i> '.$this->lang->line('cart_continnue').'</a>';
							$html = $html . '<a href="'.site_url('dat-mua').'" title="'.$this->lang->line('cart_payment').'" class="purchase">'.$this->lang->line('cart_payment').'</a>';
						$html = $html . '</div>';
					$html = $html . '</div><!-- .panel-foot -->';
				$html = $html . '</form>';
			$html = $html . '</section><!-- .buynow-2 -->';
		$html = $html . '</div>';
		echo json_encode(array(
			'item' => number_format($this->cart->total_items()),
			'total' => number_format($this->cart->total()),
			'html' => $html,
		));
	}

	public function addtocart(){
		$id = (int)$this->input->post('id');
		$quantity = (int)$this->input->post('quantity');
//		$option = $this->input->post('option');
		$color = $this->input->post('color');
		$size = $this->input->post('size');
		$price = $this->input->post('price');
		$sanpham = $this->input->post('sanpham');
		$products = $this->FrontendProducts_Model->ReadByField('id', $id, $this->fc_lang);
		$globalprice = ($products['saleoff'])?$products['saleoff']:$products['saleoff'];

		

		//Size: 40,Màu: Đỏ
//		$options = array();
//		if (!empty($option)) {
//			$arr_ = explode(',', $option);
//			foreach ($arr_ as $val) {
//				$arr__ = explode(':', $val);
//				for ($i=0; $i < count($arr__) ; $i++) {
//					$options[$arr__[0]] = trim($arr__[1]);
//				}
//			}
//		}
		// Kiểm tra sản phẩm có thuộc tính thêm không và check đã chọn đủ các thuộc tính chưa
//	 	$result_attr_advanced = $this->Autoload_Model->_get_where(array(
//            'select' => 'id, title, attribute',
//            'table' => 'products_att_advanced',
//            'where' => array('productsid' => $products['id'], 'trash' => 0),
//            'order_by' => 'id asc'
//        ), TRUE);
//        if (isset($result_attr_advanced) && is_array($result_attr_advanced) && count($result_attr_advanced)) {
//        	if (count($options) < count($result_attr_advanced)) {
//        		echo json_encode(array(
//					'error' => false,
//				));die;
//        	}
//        }

		$data = array(
			'id' => $id,
			'name' => ((!empty($products['sub_title'])) ? $products['sub_title'].' - ' : '').$products['title'],
			'type_aff' => $products['type_aff'],
			'qty' => $quantity,
			'price' => $price,
			'sanphamtangkem' => $sanpham,
			'options' => array('Size' => $color, 'Color' => $size, 'sanphamtangkem'=> $sanpham)
		);
		$this->cart->insert($data);
		$cart = $this->cart->contents();
		
		if(isset($cart) && is_array($cart) && count($cart)){
			$temp = NULL;
			foreach($cart as $keyMain => $valMain){
				$temp[] = $valMain['id'];
			}
			if(isset($temp) && is_array($temp) && count($temp)){
				$product = $this->FrontendProducts_Model->_get_where(array(
					'select' => 'id, title, slug, canonical, images, price, saleoff, weight, sku',
					'where' => array('publish' => 1,'trash' => 0, 'alanguage' => $this->fc_lang),
					'table'=> 'products',
					'where_in' => $temp,
					'where_in_field' => 'id',
				), TRUE);
			}
			$temp = NULL;
			foreach($cart as $keyMain => $valMain){
				foreach($product as $keyItem => $valItem){
					if($valItem['id'] == $valMain['id']){
						$valMain['detail'] = $valItem;
					}
				}
				$temp[] = $valMain;
			}
			$cart = $temp;
		}
		
		$html = '';

		$html = $html . '<div id="ec-module-cart">';
			$html = $html . '<section class="uk-panel buynow-2">';
				$html = $html . '<form action="" id="ajax-cart-form">';
					$html = $html . '<header class="panel-head mb15">';
						$html = $html . '<h1 class="heading"><span class="text">'.$this->lang->line('cart_products_title').' ('.number_format($this->cart->total_items()).' '.$this->lang->line('products').')</span></h1>';
					$html = $html . '</header><!-- .header -->';
					$html = $html . '<div class="panel-body">';
						$html = $html . '<ul class="uk-list mt-clearfix list-cart-heading">';
							$html = $html . '<li class="item product">'.$this->lang->line('product').'</li>';
							$html = $html . '<li class="item prices text-right none-768">'.$this->lang->line('cart_products_price').'</li>';
							$html = $html . '<li class="item count text-center">'.$this->lang->line('cart_products_number').'</li>';
							$html = $html . '<li class="item prices text-right">'.$this->lang->line('cart_products_total').'</li>';
						$html = $html . '</ul>';
						$html = $html . '<div id="scrollbar" class="uk-overflow-container cart-scrrolbar">';
							$html = $html . '<div class="list-order">';
								$i = 1;
								foreach($cart as $key => $val){
									$val['detail']['href'] = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products');
								$html = $html . '<div class="item">';
									$html = $html . '<ul class="uk-list mt-clearfix list-item-cart">';
										$html = $html . '<li class="product">';
											$html = $html . '<div class="mt-flex">';
												$html = $html . '<div class="thumb"><a class="link mt-scaledown" href="'.$val['detail']['href'].'" title="'.htmlspecialchars($val['detail']['title']).'" target="_blank"><img src="'.getthumb($val['detail']['images']).'" alt="'.htmlspecialchars($val['detail']['title']).'" /></a></div>';
												$html = $html . '<div class="info">';
													$html = $html . '<div class="title ec-line-3 mb10"><a class="link" href="'.$val['detail']['href'].'" title="'.htmlspecialchars($val['detail']['title']).'" target="_blank">'.$val['detail']['title'].'</a></div>';
													$html = $html . '<button class="delete"><i class="fa fa-trash"></i> '.$this->lang->line('remove_cart_item').'</button>';
												$html = $html . '</div>';
											$html = $html . '</div>';
										$html = $html . '</li>';
										$html = $html . '<li class="prices text-right none-768">';

										$price = ($val['detail']['saleoff'])?$val['detail']['saleoff']:$val['detail']['saleoff'];
										if(($val['detail']['saleoff'] > 0) && ($val['detail']['saleoff'] > 0)){
											$html = $html . '<span class="new">'.number_format($val['detail']['saleoff']).$this->lang->line('products_currency').'</span>';
											if($val['detail']['price'] > 0 && $val['detail']['price'] > $val['detail']['saleoff']){
												$html = $html . '<span class="old">'.number_format($val['detail']['price']).$this->lang->line('products_currency').'</span>';
											}
											if( $val['detail']['saleoff'] < $val['detail']['price']){
												$html = $html . '<span class="saleoff">-'.round((($val['detail']['price'] - $val['detail']['saleoff']) / $val['detail']['price']) * 100).'%</span>';
											}
										}
										else{
											$html = $html . '<span class="new">'.number_format($val['detail']['saleoff']).$this->lang->line('products_currency').'</span>';
										}
										$html = $html . '</li>';
										$html = $html . '<li class="count">';
											$html = $html . '<div class="uk-position-relative">';
												$html = $html . form_hidden($i.'[rowid]', $val['rowid']);
												$html = $html . form_input(array(
													'name' => $i.'[qty]',
													'value' => set_value($i.'[qty]', $val['qty']),
													'class' => 'quantity ajax-quantity',
												));
												$html = $html . '<span class="btns abate"></span>';
												$html = $html . '<span class="btns augment"></span>';
											$html = $html . '</div>';
										$html = $html . '</li>';
										$html = $html . '<li class="prices text-right"><span>'.number_format($price * $val['qty']).$this->lang->line('products_currency').'</span></li>';
									$html = $html . '</ul><!-- .list-order -->';
								$html = $html . '</div>';
								$i++;
								}
							$html = $html . '</div>';
						$html = $html . '</div>';
					$html = $html . '</div><!-- .panel-body -->';
					$html = $html . '<div class="panel-foot">';
						$html = $html . '<div class="total text-right mb10">';
							$html = $html . '<span class="price_tt">'.$this->lang->line('cart_money_total').': <strong id="ajax-cart-totalprice">'.number_format($this->cart->total()).'₫</strong></span>';
							// $html = $html . '<p>Giá đã bao gồm VAT</p>';
						$html = $html . '</div>';
						$html = $html . '<div class="action mt-flex mt-flex-middle mt-flex-space-between">';
							$html = $html . '<a class="continue ec-cart-continue"><i class="fa fa-caret-left"></i> '.$this->lang->line('cart_continnue').'</a>';
							$html = $html . '<a href="'.site_url('dat-mua').'" title="'.$this->lang->line('cart_payment').'" class="purchase">'.$this->lang->line('cart_payment').'</a>';
						$html = $html . '</div>';
					$html = $html . '</div><!-- .panel-foot -->';
				$html = $html . '</form>';
			$html = $html . '</section><!-- .buynow-2 -->';
		$html = $html . '</div>';
		echo json_encode(array(
			'item' => number_format($this->cart->total_items()),
			'total' => number_format($this->cart->total()),
			'html' => $html,
		));
	}
	
	
	
	public function updatetocart(){
		$this->cart->update($this->input->post());
		$cart = $this->cart->contents();
		
		
		if(isset($cart) && is_array($cart) && count($cart)){
			$temp = NULL;
			foreach($cart as $keyMain => $valMain){
				$temp[] = $valMain['id'];
			}
			if(isset($temp) && is_array($temp) && count($temp)){
				$product = $this->FrontendProducts_Model->_get_where(array(
					'select' => 'id, title, slug, canonical, images, price, saleoff, weight',
					'where' => array('publish' => 1,'trash' => 0, 'alanguage' => $this->fc_lang),
					'table'=> 'products',
					'where_in' => $temp,
					'where_in_field' => 'id',
				), TRUE);
			}
			$temp = NULL;
			foreach($cart as $keyMain => $valMain){
				foreach($product as $keyItem => $valItem){
					if($valItem['id'] == $valMain['id']){
						$valMain['detail'] = $valItem;
					}
				}
				$temp[] = $valMain;
			}
			$cart = $temp;
		}
		$html = '';

		$html = $html . '<header class="panel-head mb15">';
			$html = $html . '<h1 class="heading"><span class="text">'.$this->lang->line('cart_products_title').' ('.number_format($this->cart->total_items()).' '.$this->lang->line('cart_products_price').')</span></h1>';
		$html = $html . '</header><!-- .header -->';
		$html = $html . '<div class="panel-body">';
			$html = $html . '<ul class="uk-list mt-clearfix list-cart-heading">';
				$html = $html . '<li class="item product">'.$this->lang->line('product').'</li>';
				$html = $html . '<li class="item prices text-right none-768">'.$this->lang->line('cart_products_price').'</li>';
				$html = $html . '<li class="item count text-center">'.$this->lang->line('cart_products_number').'</li>';
				$html = $html . '<li class="item prices text-right">'.$this->lang->line('cart_products_total').'</li>';
			$html = $html . '</ul>';
			$html = $html . '<div id="scrollbar" class="uk-overflow-container cart-scrrolbar">';
				$html = $html . '<div class="list-order">';
					$i = 1;
					foreach($cart as $key => $val){
						$val['detail']['href'] = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products');
					$html = $html . '<div class="item">';
						$html = $html . '<ul class="uk-list mt-clearfix list-item-cart">';
							$html = $html . '<li class="product">';
								$html = $html . '<div class="mt-flex">';
									$html = $html . '<div class="thumb"><a class="link mt-scaledown" href="'.$val['detail']['href'].'" title="'.htmlspecialchars($val['detail']['title']).'" target="_blank"><img src="'.getthumb($val['detail']['images']).'" alt="'.htmlspecialchars($val['detail']['title']).'" /></a></div>';
									$html = $html . '<div class="info">';
										$html = $html . '<div class="title ec-line-3 mb10"><a class="link" href="'.$val['detail']['href'].'" title="'.htmlspecialchars($val['detail']['title']).'" target="_blank">'.$val['detail']['title'].'</a></div>';
										$html = $html . '<button class="delete"><i class="fa fa-trash"></i> '.$this->lang->line('remove_cart_item').'</button>';
									$html = $html . '</div>';
								$html = $html . '</div>';
							$html = $html . '</li>';
							$html = $html . '<li class="prices text-right none-768">';
							$price = ($val['detail']['saleoff'])?$val['detail']['saleoff']:$val['detail']['saleoff'];
							if(($val['detail']['saleoff'] > 0) && ($val['detail']['saleoff'] > 0)){
								$html = $html . '<span class="new">'.number_format($val['detail']['saleoff']).$this->lang->line('products_currency').'</span>';
								if($val['detail']['price'] > 0 && $val['detail']['price'] > $val['detail']['saleoff']){
									$html = $html . '<span class="old">'.number_format($val['detail']['price']).$this->lang->line('products_currency').'</span>';
								}
								if( $val['detail']['saleoff'] < $val['detail']['price']){
									$html = $html . '<span class="saleoff">-'.round((($val['detail']['price'] - $val['detail']['saleoff']) / $val['detail']['price']) * 100).'%</span>';
								}
							}
							else{
								$html = $html . '<span class="new">'.number_format($val['detail']['saleoff']).$this->lang->line('products_currency').'</span>';
							}
							$html = $html . '</li>';
							$html = $html . '<li class="count">';
								$html = $html . '<div class="uk-position-relative">';
									$html = $html . form_hidden($i.'[rowid]', $val['rowid']);
									$html = $html . form_input(array(
										'name' => $i.'[qty]',
										'value' => set_value($i.'[qty]', $val['qty']),
										'class' => 'quantity ajax-quantity',
									));
									$html = $html . '<span class="btns abate"></span>';
									$html = $html . '<span class="btns augment"></span>';
								$html = $html . '</div>';
							$html = $html . '</li>';
							$html = $html . '<li class="prices text-right"><span>'.number_format($price * $val['qty']).$this->lang->line('products_currency').'</span></li>';
						$html = $html . '</ul><!-- .list-order -->';
					$html = $html . '</div>';
					$i++;
					}
				$html = $html . '</div>';
			$html = $html . '</div>';
		$html = $html . '</div><!-- .panel-body -->';
		$html = $html . '<div class="panel-foot">';
			$html = $html . '<div class="total text-right mb10">';
				$html = $html . '<span class="price_tt">'.$this->lang->line('cart_money_total').': <strong id="ajax-cart-totalprice">'.number_format($this->cart->total()).$this->lang->line('products_currency').'</strong></span>';
				// $html = $html . '<p>Giá đã bao gồm VAT</p>';
			$html = $html . '</div>';
			$html = $html . '<div class="action mt-flex mt-flex-middle mt-flex-space-between">';
				$html = $html . '<a class="continue ec-cart-continue"><i class="fa fa-caret-left"></i> '.$this->lang->line('cart_continnue').'</a>';
				$html = $html . '<a href="'.site_url('dat-mua').'" title="'.$this->lang->line('cart_payment').'" class="purchase">'.$this->lang->line('cart_payment').'</a>';
			$html = $html . '</div>';
		$html = $html . '</div><!-- .panel-foot -->';
		echo json_encode(array(
			'item' => number_format($this->cart->total_items()),
			'total' => number_format($this->cart->total()),
			'html' => $html,
		));
	}
}
