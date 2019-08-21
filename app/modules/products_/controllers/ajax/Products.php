<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendProducts_Model',
			'FrontendProducts_Model',
			'tags/BackendTags_Model',
			'customers/FrontendCustomers_Model'
		));
		$this->load->library(array('configbie'));
		$this->fcUser = $this->config->item('fcUser');
		$this->fc_lang = $this->config->item('fc_lang');
		$this->fcCustomer = $this->config->item('fcCustomer');
	}
	public function Change_level_nhanhapi(){
		// https://vando.vn/products/ajax/products/change_level_nhanhapi.html
		$data = array(
            'uriListenOrderStatus' => 'https://vando.vn/products/ajax/products/update_status_order_nhanhapi.html',
        );

        $response = sendRequestNhanhVN('/api/store/configwebhooks', $data);

        if($response->code) {
            echo "<h1>Success!</h1>";
            print_r($response);die;
        } else {
            echo "<h1>Failed!</h1>";
            foreach ($response->messages as $message) {
                echo "<p>$message</p>";
            }
        }
	}

	public function Update_status_order_nhanhapi(){
		// https://vando.vn/products/ajax/products/update_status_order_nhanhapi.html
		// Cập nhật trạng thái đơn hàng từ nhanh.vn
    	require_once 'plugins/nhanh.vn-master/src/NhanhService.php';
 		$service = new NhanhService();

 		$alert = array(
 			'code' => 1,
			'messages' => '',
			'data' => ''
 		);

 		$error = 0;
		$checksum = $this->input->post('checksum');
		$data_arr = $this->input->post('data');

		// kiểm tra tính hợp lệ của checksum
		if (!$service->isValidChecksum($checksum, $data_arr)) {
		    echo 'Invalid checksum';
		    return;
		}



		$products = json_decode($data_arr, true);
		if (isset($products) && is_array($products) && count($products)){
			foreach ($products as $key => $val) {
				$orderID = $val['id'];
				$data_update = array(
					'publish' => 1,
					'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				);
				$data_update['data_nhanh_api'] = json_encode(array('data' => $data_arr, 'checksum' => $checksum));
				// Kiểm tra đơn hàng trên hệ thống.
				$check_payments_detail = $this->BackendProducts_Model->_read(array(
					'select' => '*',
					'table' => 'payments', 
					'where' => array('id' => $orderID, 'publish' => 1, 'trash' => 0),
				));
			    if (isset($check_payments_detail) && is_array($check_payments_detail) && count($check_payments_detail)) {
			    	// Cập nhật lại trạng thái
			    	if ($val['status'] == 'Success') {
			    		// Đơn hàng đã dc tích thành công trên nhanh.vn
			    		$data_update['status'] = 'success';
			    		$data_update['send'] = 1;
			    		$data_update['process'] = 1;
			    	}elseif($val['status'] == 'New'){
			    		$data_update['status'] = 'processing';
			    		$data_update['send'] = 0;
			    		$data_update['process'] = 0;
			    	}
			    
				    $update_payment = $this->BackendProducts_Model->_update(array(
				 		'table' => 'payments',
				 		'where' => array('id' => $orderID ),
				 		'data' => $data_update,
				 	));
				 	if ($update_payment > 0) {
				 		# Lưu lại lịch sử thao tác từ bên nhanh.vn gửi sang
				 		$insert_coint_add = $this->BackendProducts_Model->_create(array(
							'table' => 'payments_log_nhanhapi',
							'data' => array(
								'title' => $val['status'],
								'paymentsid' => $orderID, // ID Đơn hàng 
								'data' => json_encode(array('data' => $data_arr, 'checksum' => $checksum)),
								'publish' => 1,
								'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
							),
						));
				 	}
			 	}
			}
		}
		echo json_encode($alert);die;
	}

	public function Update_point_nhanhapi(){
		// https://vando.vn/products/ajax/products/subtract_point_nhanhapi.html
		require_once 'plugins/nhanh.vn-master/src/NhanhService.php';
 		$service = new NhanhService();

 		$alert = array(
 			'code' => 1,
			'messages' => '',
			'data' => ''
 		);
 		$error = 0;
		$checksum = $this->input->post('checksum');
		$data_arr = $this->input->post('data');
		// echo $checksum;
		// echo $data_arr;
		// kiểm tra tính hợp lệ của checksum
		if (!$service->isValidChecksum($checksum, $data_arr)) {
		    echo 'Invalid checksum';
		    return;
		}
		$products = json_decode($data_arr, true);
		// echo $data_arr;
		// Decode data
		if (isset($products) && is_array($products) && count($products)){
			$type = $products['type'];// type: addOrder, addBill
			$customerMobile = $products['customerMobile'];// customerMobile: Số điện thoại khách hàng,
			$billType = $products['billType'];// billType: export (mua hàng) hoặc import (trả hàng)
			$addPoint = $products['addPoint'];// addPoint: Số điểm được tặng,
		    $subtractPoint = $products['subtractPoint'];// subtractPoint: Số điểm đã sử dụng cho đơn hàng,
		    $totalAmount = $products['totalAmount'];// totalAmount:  Giá trị đơn hàng,
			if ($type == 'addOrder') {
				# Đơn hàng tạo trên nhanh.vn (Đơn hàng mới)
				$insert_coint_add = $this->BackendProducts_Model->_create(array(
					'table' => 'customers_coint',
					'data' => array(
						'title' => 'Xu tích điểm mua hàng',
						'customers_id' => $check_customers['id'],
						'paymentsid' => $products['orderId'], // Đơn hàng trên nhanh.vn
						'type' => 0,
						'coint' => $addPoint,
						'billType' => $billType,
						'data' => $data_arr,
						'publish' => 1,
						'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
					),
				));
			}else{
				# Đơn hàng thành công trả về Bill kèm theo số poin dc cộng hoặc trừ
				$billId = $products['billId']; // billId: ID hóa đơn,

				// Kiểm tra thành viên có tài khoản trên website không
			    $check_customers = $this->FrontendCustomers_Model->ReadByCustomersParam(array('customers.phone' => $customerMobile, 'customers.publish' => 1));

			    if (isset($check_customers) && is_array($check_customers) && count($check_customers)) {

			    	// Kiểm tra Bill đó đã tồn tại trên hệ thống chưa. Nếu đã tồn tại tiến hành xóa Bill đó
			    	$delete_bill_nhanhapi = $this->BackendProducts_Model->_delete(array(
						'table' => 'customers_coint',
						'where' => array('paymentsid' => $billId,),
						'data' => array(
							'trash' => 1,
							'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						),
					));
			    	
		    		if (!empty($addPoint)) {
		    			# Số điểm được tặng trong đơn hàng
		    			$insert_coint_add = $this->BackendProducts_Model->_create(array(
							'table' => 'customers_coint',
							'data' => array(
								'title' => 'Xu tích điểm mua hàng',
								'customers_id' => $check_customers['id'],
								'paymentsid' => $billId, // hóa đơn trên nhanh.vn
								'type' => 0,
								'coint' => $addPoint,
								'billType' => $billType,
								'data' => $data_arr,
								'publish' => 1,
								'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
							),
						));
		    		}

		    		if (!empty($subtractPoint)) {
		    			# Số điểm được sử dụng trong đơn hàng
		    			$insert_coint_subtract = $this->BackendProducts_Model->_create(array(
							'table' => 'customers_coint',
							'data' => array(
								'title' => 'Dùng xu thanh toán trong đơn hàng',
								'customers_id' => $check_customers['id'],
								'paymentsid' => $billId, // hóa đơn trên nhanh.vn
								'type' => 1,
								'coint' => $subtractPoint,
								'billType' => $billType,
								'data' => $data_arr,
								'publish' => 1,
								'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
							),
						));
		    		}
			    }else{
			    	$alert['code'] = 0;
			    	$alert['messages'] = json_encode(array('customer_error' => 'Không tìm thấy thành viên trên hệ thống'));
			    }
			}	
		}
		echo json_encode($alert);die;
	}

	public function load_attr_advanced(){
		$text = $this->input->post('text');
		$id = $this->input->post('id');
		$alert = array(
			'error' => false,
			'html' => '',
		);
		$html = '';
		if (!empty($text)) {
			$arrtext = explode(',', $text);
			foreach ($arrtext as  $vals) {
				$result_attr_advanced = $this->FrontendProducts_Model->_get_where(array(
		            'select' => 'productsid, title, quantity',
		            'table' => 'products_att_advanced_relation',
		            'where' => array('productsid' => $id, 'quantity' => 0, 'title !=' => $text),
		            'keyword' => $vals
		        ), TRUE);
		        if (isset($result_attr_advanced) && is_array($result_attr_advanced) && count($result_attr_advanced)) {
		        	foreach ($result_attr_advanced as $key => $val) {
		        		$attr = explode(',', $val['title']);
		        		for ($i=0; $i <  count($attr); $i++) { 
		        			if ($attr[$i] == $vals) continue;
		        			$alert['html'] .= '_'.slug($attr[$i]).'+';
		        			$alert['error'] = true;
		        		}
		        	}
		        }
		    }
		}
		echo json_encode($alert);die;
	}

	public function load_attribute(){
		$attr_arr = $this->input->post('attr_arr');
		//Tách thuộc tính
		$attr_ = explode('-', $attr_arr);
		$attr = $arr_arr = '';
		$i = 0;
		if (isset($attr_) && is_array($attr_) && count($attr_)) {
			foreach ($attr_ as $vals) {
				if (empty($vals)) continue;				
				// Tách giá trị trong thuộc tính
				$value_attr = explode(',', $vals);
				$j = 0;
				if (isset($value_attr) && is_array($value_attr) && count($value_attr)) {
					foreach ($value_attr as $val) {
						if (empty($val)) continue;
						$attr[$i][] = $val;
						$j++;
					}
				}
				$i++;
			}
		}

		// Tính tổ hợp sản phẩm được ra
		if (isset($attr) && is_array($attr) && count($attr)) {
			for ($i=0; $i < count($attr); $i++) {
				$arr_arr = convert_array($arr_arr, $attr[$i], $i);
			}
		}
		
		$html = '';
		if (isset($arr_arr) && is_array($arr_arr) && count($arr_arr)) {
			$k = 1;
			$html .= '<div class="box_result_">';
				$html .= '<h3>Chỉnh sửa các phiên bản dưới đây để tạo:</h3>';
				$html .= '<div class="box_result_content">';
					$html .= '<table class="table-reponsive table">';
                        $html .= '<thead>';
                            $html .= '<tr>';
                                $html .= '<th class="select"></th>';
                                $html .= '<th><span class="options-header">Phiên bản</span></th>';
                                // $html .= '<th style="width:150px"><span>Giá bán</span></th>';
                                // $html .= '<th style="width:150px"><span>Giá khuyến mại</span></th>';
                                $html .= '<th style="min-width:100px"><span>Số lượng</span></th>';
                                $html .= '<th style="min-width:100px"><span>Đã bán</span></th>';
                            $html .= '</tr>';
                        $html .= '</thead>';
                        $html .= '<tbody>';
							foreach ($arr_arr as $val) {
								$title = strip_tags(str_replace('</span><span>', ',', $val));
								$html .= '<tr>';
	                                $html .= '<td class="select">'.$k.'<input class="form-control" type="hidden" name="version[title][]" value="'.$title.'"></td>';
	                                $html .= '<td>'.$val.'</td>';
	                                // $html .= '<td style="width:100px"><input class="form-control" type="text" name="version[price][]"></td>';
	                                // $html .= '<td style="width:100px"><input class="form-control" type="text" name="version[saleoff][]"></td>';
	                                $html .= '<td style="min-width:100px"><input class="form-control" type="text" name="version[quantity][]"></td>';
	                                $html .= '<td style="min-width:100px"><input class="form-control" type="text" name="version[count_order][]"></td>';
	                            $html .= '</tr>';
	                            $k++;
							}
						$html .= '</tbody>';
                    $html .= '</table>';
				$html .= '</div>';
			$html .= '</div>';
		}
		echo $html;die;
	}

	public function add_attribute(){
		$html = '';
		$attrid = explode('-', $this->input->post('attrid'));
		$type_attr = $this->configbie->data('version');
		if (isset($type_attr) && is_array($type_attr) && count($type_attr)) {
			foreach ($type_attr as $key => $value) {
				if (!in_array($key, $attrid) && !empty($key)) {
					$html .= '<tr>
						<td>
							<input class="form-control" type="text" name="option[title][]" value="'.$value.'">
							<input type="hidden" name="option[stt][]" class="attrid" value="'.$key.'">
							<input type="hidden" name="option[count][]" class="count_attr" value="0">
						</td>
						<td><input data-role="tagsinput" type="text" name="option[attribute][]" value="" class="form-control tags"></td>
						<td><a class="btn btn-default btn-trash-attr"><i class="fa fa-trash"></i></a>
							<script>
								$(document).ready(function(){
									$(\'.tags\').tagsinput({
									    confirmKeys: [13, 44],
										maxTags: 20
									});
								});
							</script></td>
						</tr>';
					$html .= '<tr class="'.(($key != (count($type_attr) - 1)) ? '' : 'hide').'"><td colspan="3"><a class="btn btn-default btn-add-attr">Thêm thuộc tính khác</a></td></tr>';
					break;
				}
			}
		}
		
		echo $html;die;
	}

	public function aff_type(){
		$html = '';
		$type = $this->input->post('type');
		$LevelCustomers = $this->FrontendProducts_Model->_get_where(array(
			'select' => 'id, title',
			'table' => 'customers_level',
			'where' => array('trash' => 0, 'publish' => 1),
		), TRUE);
		if (!empty($type)) {
			if (isset($LevelCustomers) && is_array($LevelCustomers) && count($LevelCustomers)){
				$html .= '<div class="form-group">';
					foreach ($LevelCustomers as $key => $val){
						$html .= '<div class="col-sm-4">';
							$html .= '<div class="form-group">';
								$html .= '<label class="col-sm-12 control-label tp-text-left" style="margin-bottom: 10px">Cấp độ: '.$val['title'].'</label>';
								$html .= '<div class="col-sm-12">';
									$html .= '<input type="hidden" name="discount[level][]" class="level" value="'.$val['id'].'">';
									$html .= '<input type="text" name="discount[count][]" value="" placeholder="'.(($type == 1) ? 'Phần trăm' : 'Số tiền').' triết khấu theo sản phẩm" class="form-control count">';
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
					}
				$html .= '</div>';
			}
		}
		echo json_encode(array('html' => $html)); die();
	}

	public function load_album_products(){
		$alert = array(
			'error' => false,
			'html' => '',
			'count' => 1,
		);
		$count = 0;
		$id = $this->input->post('id');
		$html = '';
		if (!empty($id)) {
			$result = $this->Autoload_Model->_read(array(
				'select' => 'id, title, images, albums, source, parentid',
				'table' => 'products',
				'where' => array('publish' => 1, 'trash' => 0, 'id' => $id),
				'order_by' => 'id desc, order asc'
			));
			if (isset($result) && is_array($result) && count($result)) {
				$gallerys = json_decode($result['albums'], TRUE);
                if (isset($gallerys) && is_array($gallerys) && count($gallerys)){
                	$html .= '<div id="slider-owl" class="mt-list mt-clearfix owl-carousel">';
                    $html .= '<div>';
                        $html .= '<a href="javascript:void(0);" data-src="'.$result['images'].'">';
                            $html .= '<img class="active-img" src="'.getthumb($result['images'], TRUE).'" alt="'.$result['title'].'" data-source="'.((!empty($result['source'])) ? $result['source'] : '').'" data-stt="1/'.(count($gallerys) + 1).'">';
                        $html .= '</a>';
                    $html .= '</div>';
	                    foreach ($gallerys as $key => $val){
	                        $html .= '<div class="'.((!empty($result['source'])) ? 'player_' : '').'">';
	                            $html .= '<a href="javascript:void(0);" data-src="'.$val['images'].'">';
	                                $html .= '<img src="'.getthumb($val['images'], TRUE).'" alt="'.$result['title'].'" data-source="'.((!empty($result['source'])) ? $result['source'] : '').'" data-stt="'.($key + 2).'/'.(count($gallerys) + 1).'">';
	                            $html .= '</a>';
	                        $html .= '</div>';
	                    }
                    $html .= '</div>';
                    $count = '1/'.(count($gallerys) + 1).'';
                }else{
                	$result1 = $this->Autoload_Model->_read(array(
						'select' => 'id, title, images, albums, source',
						'table' => 'products',
						'where' => array('publish' => 1, 'trash' => 0, 'id' => $result['parentid']),
						'order_by' => 'id desc, order asc'
					));
					if (isset($result1) && is_array($result1) && count($result1)) {
						$gallerys1 = json_decode($result1['albums'], TRUE);
						if (isset($gallerys1) && is_array($gallerys1) && count($gallerys1)){
							$html .= '<div id="slider-owl" class="mt-list mt-clearfix owl-carousel">';
			                    $html .= '<div>';
			                        $html .= '<a href="javascript:void(0);" data-src="'.$result1['images'].'">';
			                            $html .= '<img class="active-img" src="'.getthumb($result1['images'], TRUE).'" alt="'.$result1['title'].'" data-source="'.((!empty($result1['source'])) ? $result['source'] : '').'"  data-stt="1/'.(count($gallerys1) + 1).'">';
			                        $html .= '</a>';
			                    $html .= '</div>';
		                        foreach ($gallerys1 as $key => $val){
		                            $html .= '<div class="'.((!empty($result1['source'])) ? 'player_' : '').'">';
		                                $html .= '<a href="javascript:void(0);" data-src="'.$val['images'].'">';
		                                    $html .= '<img src="'.getthumb($val['images'], TRUE).'" alt="'.$result1['title'].'" data-source="'.((!empty($result1['source'])) ? $result1['source'] : '').'" data-stt="'.($key + 2).'/'.(count($gallerys1) + 1).'">';
		                                $html .= '</a>';
		                            $html .= '</div>';
		                        }
	                        $html .= '</div>';
	                    }
	                    $count = '1/'.(count($gallerys1) + 1).'';
					}
                }
                $html .= '<script>';
                	$html .= '$(document).ready(function(){';
                		$html .= 'var owl = $(\'#slider-owl\').owlCarousel({';
						    $html .= 'loop: false,';
						    $html .= 'margin: 5,';
						    $html .= 'nav: false,';
						    $html .= 'dots: true,';
						    $html .= 'items: 4,';
						    $html .= 'responsive:{0:{items: 1,dots: false},600:{items: 1,dots: false},1000:{items: 4}}';
						$html .= '});';
						$html .= '$(".next").click(function(){
                            owl.trigger(\'next.owl.carousel\');
                            $(\'.owl-item.active img\').trigger(\'click\')
                        });
                        $(".prev").click(function(){
                            owl.trigger(\'prev.owl.carousel\');
                            $(\'.owl-item.active img\').trigger(\'click\')
                        });';
                	$html .= '});';
                $html .= '</script>';
                $alert['html'] = $html;
                $alert['count'] = $count;
                $alert['error'] = true;
			}
		}
		echo json_encode($alert); die();
	}

	public function load_price_versions_products(){
		$alert = array(
			'error' => TRUE,
			'result' => '',
			'quantity' => 0,
			'price' => 0,
		);
		$id = $this->input->post('id');
		$html = '';
		if (!empty($id)) {
			$result = $this->Autoload_Model->_read(array(
				'select' => 'id, price, saleoff, quantity, status, count_order',
				'table' => 'products',
				'where' => array('publish' => 1, 'trash' => 0, 'id' => $id),
				'order_by' => 'id desc, order asc'
			));
			if (isset($result) && is_array($result) && count($result)) {
				$price = $result['price'];
			    $saleoff = $result['saleoff'];
			    if ($price > 0) {
			        $giaold = '<span>'.str_replace(',', '.', number_format($price)).' đ</span>';
			    }else{
			        $giaold  = '';
			    }
			    if ($saleoff > 0) {
			        $gia = str_replace(',', '.', number_format($saleoff)).' ₫';
			    }else{
			        $gia  = 'Liên hệ';
			    }
			    $price_affiliate = ((!empty(price_affiliate($saleoff, $result['id']))) ? '<font>'.str_replace(',', '.', number_format(price_affiliate($saleoff, $result['id']))).' ₫</font>' : '');
				$html .= '<ul>';
                    $html .= '<li>'.$price_affiliate.$gia.' '.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $giaold : '').'</li>';
                    $html .= '<li><a class="'.((!empty($result['quantity'])) ? 'bg-primary' : 'bg-danger').'">'.$this->configbie->data('status', ((!empty($result['quantity'])) ? 0 : 1 )).'</a></li>';
                $html .= '</ul>';
				$alert['error'] = false;
				$alert['result'] = $html;
				$alert['quantity'] = number_format($result['quantity']);
				$alert['count_order'] = number_format($result['count_order']);
				$alert['price'] = number_format($result['saleoff']);
			}
		}
		echo json_encode($alert); die();
	}

	// Create Version Products
	public function add_vesions(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		$this->form_validation->set_rules('title', 'Tiêu đề sản phẩm', 'trim|required');
		if ($this->form_validation->run($this)){

			$att = '';
			$album_data = $shipcode_data = '';

			// Affiliate
			$level = explode('+-+', $this->input->post('level'));
			$count = explode('+-+', $this->input->post('count'));

			/* ---------- ----------*/
			$discount_data = '';
			if(isset($level) && is_array($level)  && count($level)) {
				foreach ($level as $key => $val) {
					$discount_data[] = array('level' => $val); 
				}
			}
			if(isset($discount_data) && is_array($discount_data)  && count($discount_data) && isset($count) && is_array($count) && count($count)) {
				foreach ($discount_data as $key => $val) {
					$discount_data[$key]['count'] = $count[$key];
				}
			}

			// End Affiliate
			
			$album = explode('+-+', $this->input->post('albums'));
			$shipcode = explode('+-+', $this->input->post('shipcode'));

			if(isset($album) && is_array($album)  && count($album)) {
				foreach ($album as $key => $val) {
					if(empty($val)) continue;
					$album_data[] = array('images' => $val); 
				}
			}

			if(isset($shipcode) && is_array($shipcode)  && count($shipcode)) {
				$shipcode_data['shop'] = ((!empty($shipcode[0])) ? $shipcode[0] : 0); 
				$shipcode_data['inner'] = ((!empty($shipcode[1])) ? $shipcode[1] : 0);
				$shipcode_data['outner'] = ((!empty($shipcode[2])) ? $shipcode[2] : 0);
			}

			$data = array(
				'albums' => json_encode($album_data),
				'shipcode' => json_encode(array(0 => $shipcode_data)),
				'publish' => 1,
				'userid_created' => $this->fcUser['id'],
				'alanguage' => $this->fc_lang,
				'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			);
			$post = $this->input->post('post');
			if(isset($post) && is_array($post)  && count($post)) {
				foreach ($post as $key => $val) {
					$att[$val['name']] = (($val['name'] == 'price' || $val['name'] == 'saleoff') ? (int)str_replace('.','', $val['value']) : nl2br($val['value']));
				}
				foreach ($data as $key => $val) {
					$att[$key] = $val;
				}
			}
			$flag = $this->BackendProducts_Model->_create(array('table' => 'products', 'data' => $att));
			if ($flag > 0) {
				$this->BackendProducts_Model->CreateAff($flag, $discount_data);
			}
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}

	public function edit_vesions_now(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		$this->form_validation->set_rules('title', 'Tiêu đề sản phẩm', 'trim|required');
		$this->form_validation->set_rules('id', 'ID sả phẩm', 'trim|required');
		if ($this->form_validation->run($this)){

			$att = '';
			$album_data = $shipcode_data = '';

			// Affiliate
			$level = explode('+-+', $this->input->post('level'));
			$count = explode('+-+', $this->input->post('count'));

			/* ---------- ----------*/
			$discount_data = '';
			if(isset($level) && is_array($level)  && count($level)) {
				foreach ($level as $key => $val) {
					$discount_data[] = array('level' => $val); 
				}
			}
			if(isset($discount_data) && is_array($discount_data)  && count($discount_data) && isset($count) && is_array($count) && count($count)) {
				foreach ($discount_data as $key => $val) {
					$discount_data[$key]['count'] = $count[$key];
				}
			}
			// End Affiliate

			$album = explode('+-+', $this->input->post('albums'));
			$shipcode = explode('+-+', $this->input->post('shipcode'));

			if(isset($shipcode) && is_array($shipcode)  && count($shipcode)) {
				$shipcode_data['shop'] = ((!empty($shipcode[0])) ? $shipcode[0] : 0); 
				$shipcode_data['inner'] = ((!empty($shipcode[1])) ? $shipcode[1] : 0);
				$shipcode_data['outner'] = ((!empty($shipcode[2])) ? $shipcode[2] : 0);
			}
			$album_data = '';
			if(isset($album) && is_array($album)  && count($album)) {
				foreach ($album as $key => $val) {
					if(empty($val)) continue;
					$album_data[] = array('images' => $val); 
				}
			}

			$data = array(
				'albums' => json_encode($album_data),
				'shipcode' => json_encode(array(0 => $shipcode_data)),
				'userid_updated' => $this->fcUser['id'],
				'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			);

			$post = $this->input->post('post');
			if(isset($post) && is_array($post)  && count($post)) {
				foreach ($post as $key => $val) {
					$att[$val['name']] = (($val['name'] == 'price' || $val['name'] == 'saleoff') ? (int)str_replace('.','', $val['value']) : nl2br($val['value']));
				}
				foreach ($data as $key => $val) {
					$att[$key] = $val;
				}
			}
			// print_r($att);die;
			$flag = $this->Autoload_Model->_update(array(
				'table' => 'products', 
				'data' => $att,
				'where' => array('id' => $this->input->post('id'), 'parentid !=' => 0)
			));
			if ($flag > 0) {
				// Xóa bản ghi triết khấu cho tk Affiliate
				$this->BackendProducts_Model->DeleteAff($this->input->post('id'));
				// Thêm bản ghi triết khấu cho tk Affiliate mới
				$this->BackendProducts_Model->CreateAff($this->input->post('id'), $discount_data);
			}
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}

	public function delete_version_products(){
		$alert = array(
			'error' => TRUE,
			'message' => '',
			'result' => ''
		);
		$id = $this->input->post('id');
		if (!empty($id)) {
			$result = $this->Autoload_Model->_read(array(
				'select' => 'id',
				'table' => 'products',
				'where' => array('publish' => 1, 'trash' => 0, 'parentid !=' => 0, 'id' => $id),
				'order_by' => 'id desc, order asc'
			));
			if (isset($result) && is_array($result) && count($result)) {
				$flag = $this->Autoload_Model->_delete(array(
					'table' => 'products', 
					'data' => array('trash' => 1, 'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600)), 
					'where' => array('id' => $result['id'])
				));
				$alert['error'] = false;
				$alert['message'] = 'Xóa bản ghi thành công';
			}else{
				$$alert['error'] = false;
				$alert['message'] = 'Bản ghi không tồn tại';
			}
		}else{
			$alert['error'] = false;
			$alert['message'] = 'Lỗi hệ thống vui lòng thử lại';
		}
		echo json_encode($alert); die();
	}

	public function edit_version_products(){
		$alert = array(
			'error' => TRUE,
			'message' => '',
			'result' => ''
		);
		$id = $this->input->post('id');
		$html = '';
		if (!empty($id)) {
			$result = $this->Autoload_Model->_read(array(
				'select' => 'id, title, images, albums, price, saleoff, quantity, source, shipcode, count_order, type_aff',
				'table' => 'products',
				'where' => array('publish' => 1, 'trash' => 0, 'parentid !=' => 0, 'id' => $id),
				'order_by' => 'id desc, order asc'
			));
			if (isset($result) && is_array($result) && count($result)) {
				$html .= '<div class="nav-tabs-custom" style="margin-bottom: 0;box-shadow: none;">';
					$html .= '<ul class="nav nav-tabs">';
						$html .= '<li class="active"><a href="#tab-info-modal-edit" data-toggle="tab">Thông tin cơ bản</a></li>';
						$html .= '<li><a href="#tab-album-modal-edit" data-toggle="tab">Album ảnh</a></li>';
						$html .= '<li><a href="#tab-ship-modal-edit" data-toggle="tab">Vận chuyển</a></li>';
						$html .= '<li><a href="#tab-aff-modal-edit" data-toggle="tab">Triết khấu Affiliate</a></li>';
					$html .= '</ul>';
					$html .= '<div class="tab-content">';
						$html .= '<div class="error callout callout-danger" style="display: none"></div>';
						$html .= '<div class="tab-pane active" id="tab-info-modal-edit">';
							$html .= '<div class="row">';
								$html .= '<div class="col-sm-6">';
									$html .= '<div class="form-group">';
										$html .= '<label class="col-sm-12 control-label tp-text-left">Tên phiên bản</label>';
										$html .= '<div class="col-sm-12">';
											$html .= '<input type="text" name="title" class="form-control title" value="'.$result['title'].'" placeholder="Tên phiên bản sản phẩm, vd: S, M, L, Đỏ, Đen">';
										$html .= '</div>';
										$html .= '<div class="col-sm-6">';
											$html .= '<div class="row">';
												$html .= '<label class="col-sm-12 control-label tp-text-left">Số lượng</label>';
												$html .= '<div class="col-sm-12">';
													$html .= '<input type="text" name="quantity" value="'.$result['quantity'].'" class="form-control" placeholder="Số lượng sp hiện có">';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</div>';
										$html .= '<div class="col-sm-6">';
											$html .= '<div class="row">';
												$html .= '<label class="col-sm-12 control-label tp-text-left">Đã bán</label>';
												$html .= '<div class="col-sm-12">';
													$html .= '<input type="text" name="count_order" value="'.$result['count_order'].'" class="form-control" placeholder="Số lượng sp đã bán">';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</div>';
										$html .= '<div class="col-sm-6">';
											$html .= '<div class="row">';
												$html .= '<label class="col-sm-12 control-label tp-text-left">Giá bán</label>';
												$html .= '<div class="col-sm-12">';
													$html .= '<input type="text" name="price" value="'.str_replace(',', '.', number_format($result['price'])).'" class="form-control price" placeholder="Giá bán">';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</div>';
										$html .= '<div class="col-sm-6">';
											$html .= '<div class="row">';
												$html .= '<label class="col-sm-12 control-label tp-text-left">Giá khuyến mãi</label>';
												$html .= '<div class="col-sm-12">';
													$html .= '<input type="text" name="saleoff" value="'.str_replace(',', '.', number_format($result['saleoff'])).'" class="form-control price-saleoff" placeholder="Giá khuyến mại">';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</div>';

										$html .= '<label class="col-sm-12 control-label tp-text-left">Videos giới thiệu</label>';
										$html .= '<div class="col-sm-12">';
											$html .= '<input type="text" name="source" value="'.$result['source'].'" class="form-control source" placeholder="Videos giới thiệu" onclick="openKCFinder(this, files)">';
										$html .= '</div>';
										$html .= '<input type="hidden" value="" id="albums_ver_edit">';
										$html .= '<input type="hidden" value="" id="shipcode_ver_edit">';
										$html .= '<input type="hidden" id="id_ver_edit" value="'.$result['id'].'">';
									$html .= '</div>';
								$html .= '</div>';
								$html .= '<div class="col-sm-6">';
									$html .= '<div class="form-group">';
										$html .= '<label class="col-sm-12 control-label tp-text-left">Ảnh đại diện</label>';
										$html .= '<div class="col-sm-12">';
											$html .= '<div class="avatar" style="cursor: pointer;">';
												$html .= '<img src="'.((!empty($result['images'])) ? $result['images'] : 'templates/not-found.png').'" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;object-fit: scale-down;height: 220px;"/>';
											$html .= '</div>';
											$html .= '<input type="hidden" class="images_" name="images" value="'.$result['images'].'">';
										$html .= '</div>';
									$html .= '</div>';
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
						$html .= '<div class="tab-pane" id="tab-album-modal-edit">';
							$html .= '<div class="box-body">';
								$html .= '<div class="form-group" id="fromVertionEdit">';
									$album = json_decode($result['albums'], TRUE);
									if(isset($album) && is_array($album) && count($album)){
										foreach($album as $key => $val){ 
											if(empty($album[$key]['images'])) continue;
											$html .= '<div class="col-sm-4 vertionItem">';
											$html .= '<div class="thumb"><img src="'.$album[$key]['images'].'" class="img-thumbnail img-responsive"/></div>';
											$html .= '<input type="hidden" class="img-ver" value="'.$album[$key]['images'].'" />';
											// $html .= '<input type="text" value="'.$album[$key]['title'].'" class="form-control title-ver" placeholder="Đường dẫn videos Youtube"/>';
											// $html .= '<textarea cols="40" rows="4" class="form-control description" readonly="" placeholder="Nếu có videos giới thiệu sản phẩm, dán đường dẫn lên trên ô trên. Thứ tự ưu tiên sẽ là Videos -> ảnh"></textarea>';
											$html .= '<button type="button" class="btn btnRemove remove_ver1 btn-danger pull-right">Xóa bỏ</button>';
											$html .= '</div>';
										}
									}
									$html .= '<div class="col-sm-4 vertionItem">';
										$html .= '<button type="button" class="btn btnAddVertion add_ver1">+</button>';
									$html .= '</div>		';							
								$html .= '</div>';
							$html .= '</div><!-- /.box-body -->';
						$html .= '</div>';

						$ship = json_decode($result['shipcode'], TRUE);
						
						$html .= '<div class="tab-pane" id="tab-ship-modal-edit">';
							$html .= '<div class="box-body"><div class="row">';
								if(isset($ship) && is_array($ship) && count($ship)){
									foreach($ship as $keykey => $val){
										$html .= '<div class="col-sm-4">';
											$html .= '<div class="form-group">';
												$html .= '<label class="col-sm-12 control-label tp-text-left">Tại cửa hàng</label>';
											$html .= '</div>';
											$html .= '<div class="form-group">';
												$html .= '<div class="col-sm-12">';
													$html .= '<input type="text" value="0" readonly="" class="form-control shipcode"/>';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</div>';
										
										$html .= '<div class="col-sm-4">';
											$html .= '<div class="form-group">';
												$html .= '<label class="col-sm-12 control-label tp-text-left">Nội thành HN</label>';
											$html .= '</div>';
											$html .= '<div class="form-group">';
												$html .= '<div class="col-sm-12">';
													$html .= '<input type="text" value="'.$ship[$keykey]['inner'].'" class="form-control shipcode"/>';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</div>';
										
										$html .= '<div class="col-sm-4">';
											$html .= '<div class="form-group">';
												$html .= '<label class="col-sm-12 control-label tp-text-left">COD các tỉnh</label>';
											$html .= '</div>';
											$html .= '<div class="form-group">';
												$html .= '<div class="col-sm-12">';
													$html .= '<input type="text" value="'.$ship[$keykey]['outner'].'" class="form-control shipcode"/>';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</div>';
									}
								}else{ 
									$html .= '<div class="col-sm-4">';
										$html .= '<div class="form-group">';
											$html .= '<label class="col-sm-12 control-label tp-text-left">Tại cửa hàng</label>';
										$html .= '</div>';
										$html .= '<div class="form-group">';
											$html .= '<div class="col-sm-12">';
												$html .= '<input type="text" value="0" readonly="" class="form-control shipcode"/>';
											$html .= '</div>';
										$html .= '</div>';
									$html .= '</div>';
									
									$html .= '<div class="col-sm-4">';
										$html .= '<div class="form-group">';
											$html .= '<label class="col-sm-12 control-label tp-text-left">Nội thành HN</label>';
										$html .= '</div>';
										$html .= '<div class="form-group">';
											$html .= '<div class="col-sm-12">';
												$html .= '<input type="text" value="" class="form-control shipcode"/>';
											$html .= '</div>';
										$html .= '</div>';
									$html .= '</div>';
									
									$html .= '<div class="col-sm-4">';
										$html .= '<div class="form-group">';
											$html .= '<label class="col-sm-12 control-label tp-text-left">COD các tỉnh</label>';
										$html .= '</div>';
										$html .= '<div class="form-group">';
											$html .= '<div class="col-sm-12">';
												$html .= '<input type="text" value="" class="form-control shipcode"/>';
											$html .= '</div>';
										$html .= '</div>';
									$html .= '</div>';
								}
							$html .= '</div></div>';
						$html .= '</div>';

						$html .= '<div class="tab-pane" id="tab-aff-modal-edit">';
							$html .= '<div class="box-body">';
								$html .= '<div class="form-group">';
									$html .= '<label class="col-sm-2 control-label tp-text-left">Giá thu về</label>';
									$html .= '<div class="col-sm-10">';
										$html .= form_dropdown('type_aff', $this->configbie->data('type_aff'), set_value('type_aff', $result['type_aff']), 'class="form-control chose_aff select2" style="width: 100%;" data-show="list-aff-modal-edit" data-remove-name="remove"');
									$html .= '</div>';
								$html .= '</div>';
								$html .= '<div id="list-aff-modal-edit">';
									if (!empty($result['type_aff'])){
										$LevelCustomers = $this->Autoload_Model->_get_where(array(
											'select' => 'id, title',
											'table' => 'customers_level',
											'where' => array('trash' => 0, 'publish' => 1),
										), TRUE);
										if (isset($LevelCustomers) && is_array($LevelCustomers) && count($LevelCustomers)){
											$html .= '<div class="form-group">';
												foreach ($LevelCustomers as $key => $val){
													$count = $this->Autoload_Model->_get_where(array(
														'select' => 'count',
														'table' => 'products_discount_affiliate',
														'where' => array('productsid' => $result['id'], 'level' => $val['id']),
													), FALSE);
													$html .= '<div class="col-sm-4">';
														$html .= '<div class="form-group">';
															$html .= '<label class="col-sm-12 control-label tp-text-left" style="margin-bottom: 10px">Cấp độ: '.$val['title'].'</label>';
															$html .= '<div class="col-sm-12">';
																$html .= '<input type="hidden" name="" class="level" value="'.$val['id'].'">';
																$html .= '<input type="text" name="" value="'.((!empty($count['count'])) ? $count['count'] : '').'" placeholder="'.(($result['type_aff'] == 1) ? 'Phần trăm' : 'Số tiền').' thu về theo giá sản phẩm" class="form-control count">';
															$html .= '</div>';
														$html .= '</div>';
													$html .= '</div>';
												}
											$html .= '</div>';
										}
									}
								$html .= '</div>';
								$html .= '<input type="hidden" id="level_aff_edit" value="">';
								$html .= '<input type="hidden" id="count_aff_edit" value="">';
							$html .= '</div>';
						$html .= '</div>';

					$html .= '</div>';
				$html .= '</div>';
				$alert['error'] = false;
				$alert['message'] = $html;
			}else{
				$$alert['error'] = false;
				$alert['message'] = 'Bản ghi không tồn tại';
			}
		}else{
			$alert['error'] = false;
			$alert['message'] = 'Lỗi hệ thống vui lòng thử lại';
		}
		echo json_encode($alert); die();
	}

	public function load_version_products(){
		$parentid = $this->input->post('parentid');
		$html = '';
		if (!empty($parentid)) {
			$result = $this->Autoload_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, images, description, price, saleoff, status, quantity',
				'table' => 'products',
				'where' => array('publish' => 1, 'trash' => 0, 'parentid' => $parentid),
				'order_by' => 'id desc, order asc'
			),TRUE);
		
			if(isset($result) && is_array($result) && count($result)) {
				$html .= '<table class="table" id="diagnosis-list">';
					$html .= '<thead><tr>';
						$html .= '<th>Tiêu đề</th>';
						$html .= '<th>Số lượng</th>';
						$html .= '<th>Tình trạng</th>';
						$html .= '<th>Thao tác</th>';
					$html .= '</tr>';			
					$html .= '</thead><tbody>';			
					foreach ($result as $key => $val) {
						$image = getthumb($val['images']);
						$description = cutnchar(strip_tags($val['description']), 250);
						$price = $val['price'];
                        $saleoff = $val['saleoff'];
						if ($price > 0) {
	                        $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).' đ<span>';
	                    }else{
	                        $pri_old  = '';
	                    }
	                    if ($saleoff > 0) {
	                        $pri_sale = str_replace(',', '.', number_format($saleoff)).' đ';
	                    }else{
	                        $pri_sale  = 'Liên hệ';
	                    }
						$html .= '<tr>';
							$html .= '<td style="width:650px;">';
								$html .= '<article class="article-view-1 text-left">';
									$html .= '<div class="col-sm-2 thumb">';
										$html .= '<div class="tp-cover"><img  src="'.$image.'" alt="'.$val['title'].'" /></div>';
									$html .= '</div>';
									$html .= '<div class="col-sm-10">';
										$html .= '<div class="title">'.$val['title'].'</div>';
										$html .= '<div class="description">'.$description.'</div>';
										$html .= '<div class="meta">';
											$html .= $pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '');
										$html .= '</div>';
									$html .= '</div>';
								$html .= '</article>';
							$html .= '</td>';
							$html .= '<td style="text-align:center">'.$val['quantity'].'</td>';
							$html .= '<td style="text-align:center"><span class="btn '.((!empty($val['status'])) ? 'btn-danger' : 'btn-success').'">'.$this->configbie->data('status', $val['status']).'</span></td>';
							$html .= '<td class="text-right">';
								$html .= '<div class="btn-group" style="min-width: auto;">';
									$html .= '<div class="btn btn-default delete-version" data-id="'.$val['id'].'">';
										$html .= '<span class="fa fa-trash"></span>';
									$html .= '</div>';
									$html .= '<div class="btn btn-default edit-version" data-id="'.$val['id'].'">';
										$html .= '<span class="fa fa-edit"></span>';
									$html .= '</div>';
								$html .= '</div>';
							 $html .= '</td>';
						$html .= '</tr>';
					}
				$html .= '</table>';
			}
		}
		echo json_encode(array('html'=>$html));die;
	}

	// Search Products
	public function search(){
		$keyword = $this->input->post('keyword');
		$id = $this->input->post('id');
		$prdid = $this->input->post('prdid');
		$html = '';
		if (!empty($keyword)) {
			$result = $this->Autoload_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, images, description, price, saleoff, status',
				'table' => 'products',
				'keyword' => $keyword,
				'where' => array('publish' =>1, 'trash' => 0, 'id !=' => $prdid),
				'where_not_in' => explode('-', $id),
				'where_not_in_field' => 'id',
				'order_by' => 'id desc, order asc'
			),TRUE);
		
			if(isset($result) && is_array($result) && count($result)) {
				$html .= '<table class="table" id="diagnosis-list">';
					$html .= '<thead><tr>';
						$html .= '<th>Tiêu đề</th>';
						$html .= '<th>Tình trạng</th>';
						$html .= '<th></th>';
					$html .= '</tr>';			
					$html .= '</thead><tbody>';			
					foreach ($result as $key => $val) {
						$image = getthumb($val['images']);
						$description = cutnchar(strip_tags($val['description']), 250);
						$price = $val['price'];
                        $saleoff = $val['saleoff'];
						if ($price > 0) {
	                        $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).' đ<span>';
	                    }else{
	                        $pri_old  = '';
	                    }
	                    if ($saleoff > 0) {
	                        $pri_sale = str_replace(',', '.', number_format($saleoff)).' đ';
	                    }else{
	                        $pri_sale  = 'Liên hệ';
	                    }
						$html .= '<tr class="add-item" data-id="'.$val['id'].'">';
							$html .= '<td style="width:650px;">';
								$html .= '<article class="article-view-1 text-left">';
									$html .= '<div class="col-sm-2 thumb">';
										$html .= '<div class="tp-cover"><img  src="'.$image.'" alt="'.$val['title'].'" /></div>';
									$html .= '</div>';
									$html .= '<div class="col-sm-10">';
										$html .= '<div class="title">'.$val['title'].'</div>';
										$html .= '<div class="description">'.$description.'</div>';
										$html .= '<div class="meta">';
											$html .= $pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '');
										$html .= '</div>';
									$html .= '</div>';
								$html .= '</article>';
							$html .= '</td>';
							$html .= '<td style="text-align:center"><span class="btn '.((!empty($val['status'])) ? 'btn-danger' : 'btn-success').'">'.$this->configbie->data('status', $val['status']).'</span></td>';
							$html .= '<td class="text-right">';
								$html .= '<div class="btn btn-default data-active" data-id="'.$val['id'].'">';
									$html .= '<span class="fa fa-trash"></span>';
								$html .= '</div>';
							 $html .= '</td>';
						$html .= '</tr>';
					}
				$html .= '</table>';
			}
		}
		echo json_encode(array('html'=>$html));die;
	}
	
	
	//   Báo cáo lỗi video
	public function error_video(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$id = $this->input->post('id');
		$module = $this->input->post('module');
		$moduleid = $this->input->post('moduleid');
		$pageid = $this->input->post('pageid');


		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' / ');
		$this->form_validation->set_rules('message', 'Nội dung báo lỗi', 'trim|required');
		if ($this->form_validation->run($this)){
			$post = $this->input->post('post');
			$data = '';
			if(isset($post) && is_array($post) && count($post)){
				foreach($post as $key => $val){
					$data[$val['name']] = nl2br($val['value']) ;
				}
			}else{
				$data['message'] = $this->input->post('message');
			}
			$data['module'] = $module;
			$data['moduleid'] = $moduleid;
			$data['pageid'] = $pageid;
			$data['customersid'] = $this->fcCustomer['id'];
			$data['publish'] = 0;
			$data['created'] = gmdate('Y-m-d H:i:s', time() + 7*3600);

			if(isset($data) && is_array($data) && count($data)){
				$this->db->insert('error_video', $data);
				$this->db->flush_cache();
			}
		}else{
			$alert['error'] = validation_errors();
		}
		echo json_encode($alert); die();
	}


	//   Load modal video học thử
	public function load_modal(){
		$alert = array(
			'error' => '',
			'message' => '',
			'result' => ''
		);
		$id = $this->input->post('id');
		if (!empty($id)) {
			$result = $this->Autoload_Model->_get_where(array(
				'select' => 'id, title, description',
	            'table' => 'products_page',
	            'where' => array('id' => $id),
	            'limit' => 1,
	            'order_by' => 'id desc',
			));
			if (!empty($result['description'])) {
				$alert['result'] = $result['description'];
			}
		}
		echo json_encode($alert);die;
	}

	//* LẤY ĐỊA ĐIỂM *//
	public function ajax_change_location(){
		$id = $this->input->post('id');
		$_html = '';
		$this->location = $this->BackendProducts_Model->location_dropdown(array(
			'where' => array('parentid' => $id),
		), true);
		if(isset($this->location) && is_array($this->location) && count($this->location)){
			foreach($this->location as $key => $val){
				$_html = $_html . '<option value="'.$key.'">'.$val.'</option>';
			}
		}
		echo json_encode(array(
			'html' => $_html,
		));
		die();
		
	}

	public function ajax_get_project_list(){
		$data['cityid'] = $this->input->post('cityid');
		$data['districtid'] = $this->input->post('districtid');
		$data['wardid'] = $this->input->post('wardid');
		$param['where'] = '';
		$_html = '';
	
		if($data['cityid'] > 0 && $data['districtid'] == 0){
			$param['where'] = array(
				'cityid' => $data['cityid'],
			);
		}else if($data['cityid'] > 0 && $data['districtid'] > 0 && $data['wardid']  == 0){
			$param['where'] = array(
				'cityid' => $data['cityid'],
				'districtid' => $data['districtid'],
			);
		}else if($data['cityid'] > 0 && $data['districtid'] > 0 && $data['wardid']  > 0){
			$param['where'] = array(
				'cityid' => $data['cityid'],
				'districtid' => $data['districtid'],
				'wardid' => $data['wardid'],
			);
		}else{
			echo $_html;die();
		}
		$param['where']['trash'] = 0;
		
		$listProject = $this->Autoload_Model->_get_where(array(
			'select' => 'id, title',
			'table' => 'places',
			'where' => $param['where'],
			'order_by' => 'title asc',
		), TRUE);
		
		if(isset($listProject) && is_array($listProject) && count($listProject)){
			$_html = $_html.'<option value="0">[Chọn dự án]</option>';
			foreach($listProject as $key => $val){
				$_html = $_html.'<option value="'.$val['id'].'">'.$val['title'].'</option>';
			}
		}else{
			$_html = $_html.'<option value="0">Không có dự án phù hợp</option>';
		}
		
		echo json_encode(array(
			'html' => $_html,
		)); die();
	}
	public function sort(){
		$data = NULL;
		$post = $this->input->post();
		foreach($post['order'] as $key => $val){
			$data[] = array(
				'id' => $key,
				'order' => $val,
			);
		}
		$flag = $this->BackendProducts_Model->UpdateBatchByField($data, 'id');
	}

	public function viewed(){
		$id = $this->input->post('id');
		if(!isset($_COOKIE['products_viewed_'.$id])){
			$flag = $this->FrontendProducts_Model->UpdateViewed('id', $id);
			setcookie('products_viewed_'.$id, 1, NULL, '/');
		}
	}
	public function createLink() {
		$link = $this->input->post('canonical');
		$link = slug($link);
	}
	public function sort_order() {
		sleep(0.5);
		$id = $this->input->post('id');
		$table = $this->input->post('table');
		$data = $this->input->post('number');
		if(isset($table) && !empty($table) && $id > 0) {
			$this->BackendProducts_Model->_update_sort_order($table, $id, $data);
		}
	}
	
	public function convert_commas_price(){
		$price = $this->input->post('price');
		$price_explode = explode('.',$price);
		if(count($price_explode) == 1){
			$price = (int)$price;
			
		}else{
			$price = str_replace('.','',$price);
			$price = (int)$price;
		}
		$price = str_replace(',','.',number_format($price));
		
		echo $price;die();
	}
	
	public function attributes(){
		$post = $this->input->post('post');
		$post_array = explode('-', $post);
		$temp = '';
		$_cat_ = '';
		$_attribute_cat = '';
		$_str = '';
		if(isset($post_array) && is_array($post_array) && count($post_array)){
			$_cat_ = $this->BackendProducts_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, attributes',
				'table' => 'products_catalogues',
				'where' => array('trash' => 0,),
				'where_in' => $post_array,
				'where_in_field' => 'id',
			), TRUE); 
		}
		
		if(isset($_cat_) && is_array($_cat_) && count($_cat_)){
			foreach($_cat_ as $key => $val){
				$attributes_decode = json_decode($val['attributes'], TRUE);
				$temp['attribute_catalogue'] = $attributes_decode['attribute_catalogue'];
				$temp['attribute'] = $attributes_decode['attribute'];
			}
		}
		if(count($temp['attribute_catalogue']) == 0 || $temp['attribute_catalogue'][0] == ''){
			echo $_str;die();
		}
	
		
		if(isset($_cat_) && is_array($_cat_) && count($_cat_)){
			$_attribute_cat = $this->BackendAttributes_Model->_get_where(array(
				'select' => 'id, title, keyword',
				'table' => 'attributes_catalogues',
				'where' => array('trash' => 0),
				'where_in' => $temp['attribute_catalogue'],
				'where_in_field' => 'id'
			), TRUE);
		}
		
		if(isset($_attribute_cat) && is_array($_attribute_cat) && count($_attribute_cat)){
			foreach($_attribute_cat as $key => $val){
				$_attribute_cat[$key]['attributes'] = $this->BackendAttributes_Model->_get_where(array(
					'select' => 'id, title',
					'table' => 'attributes',
					'where' => array('trash' => 0,'cataloguesid' => $val['id']),
				), TRUE);
			}
		}
		
		if(isset($_attribute_cat) && is_array($_attribute_cat) && count($_attribute_cat)){
			foreach($_attribute_cat as $key => $val){
				$_str = $_str.'<div class="form-group">';
					$_str = $_str.'<label class="col-sm-2 control-lanel">'.$val['title'].'</label>';
					$_str = $_str.'<div class="col-sm-10">';
					if(isset($val['attributes']) && is_array($val['attributes']) && count($val['attributes'])){
						$_str = $_str.'<div class="checkbox" style="padding:0;">';
						foreach($val['attributes'] as $keyAttr => $valAttr){
							if(isset($temp['attribute'][$val['keyword']]) && in_array($valAttr['id'], $temp['attribute'][$val['keyword']]) == false) continue;
							$_str = $_str.'<label class="tpInputLabel" style="width:168px;">';
								$_str = $_str.'<input name="attr['.$valAttr['id'].']" type="checkbox" class="tpInputCheckbox" value="'.$valAttr['id'].'" /><span>'.$valAttr['title'].'</span>';
							$_str = $_str.'</label>';
						}
						$_str = $_str.'</div>';
					}
					$_str = $_str.'</div>';
				$_str = $_str.'</div>';
				$_str = $_str.'<script>$(document).ready(function() {$(".tpInputLabel").on("click", function() {if($(this).find(".tpInputCheckbox").is(":checked")) {$(this).addClass("checked");}else {$(this).removeClass("checked");}});});</script>';
			}
		}
		echo $_str;die();
	}
	
	public function delete(){
		$error = true;
		$message = '';
		$id = $this->input->post('post');
		if(isset($id) && is_array($id) && count($id)){
			foreach($id as $key => $val){
				$DetailProducts = $this->BackendProducts_Model->ReadByField('id', $val);
				$flag = $this->BackendProducts_Model->DeleteByField('id', $val);
				if($flag > 0){
					if(!empty($DetailProducts['canonical'])){
						$this->BackendRouters_Model->Delete($DetailProducts['canonical'], 'products/frontend/products/view', $DetailProducts['id'], 'number');
					}
					$this->BackendProducts_Model->_delete_relationship('products', $val);
					$this->BackendTags_Model->DeleteByModule($val, 'products');
					$error = false;
					$message = 'Bản ghi đã được xóa thành công';
				}
			}
		}else{
			$message = 'Có lỗi trong quá trình xóa bản ghi, vui lòng kiểm tra lại';
		}
		echo json_encode(array(
			'error' => $error,
			'message' => $message,
		)); die();
	}

	public function filter(){
		
		$post = $this->input->post('post');
		$attribute = explode('-', $post);
		$page = $this->input->post('page');
		$temp_attribute['cataloguesid'] = $this->input->post('cataloguesid');
		$page = (int)$page;
		$config['total_rows'] = $this->FrontendProducts_Model->countajaxproduct($attribute, $temp_attribute['cataloguesid'], $this->fc_lang);
		
		$result = '';
		
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] ='#" data-page="';
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 24;
			$config['cur_page'] = $page;
			$config['page'] = $page;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination mb30"><ul class="uk-pagination uk-pagination-right" id="ajax-pagination">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="uk-active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['listProduct'] = $this->FrontendProducts_Model->viewajaxproduct(($page * $config['per_page']), $config['per_page'], $attribute, $temp_attribute['cataloguesid'], $this->fc_lang);	
		}
		$html = $page = '';
		if(isset($data['listProduct']) && is_array($data['listProduct']) && count($data['listProduct'])){
			foreach($data['listProduct'] as $key => $val){
				$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products'); 
                $price = $val['price'];
                $saleoff = $val['saleoff'];
                if ($price > 0) {
                    $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).'<span>';
                }else{
                    $pri_old  = '';
                }
                if ($saleoff > 0) {
                    $pri_sale = str_replace(',', '.', number_format($saleoff));
                }else{
                    $pri_sale  = 'Liên hệ';
                }
                if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                    $number_sale = ceil((($price - $saleoff)/$price)*100);
                }else{
                    $number_sale = '';
                }
				
				$html = $html.'<div class="col-lg-3 col-md-4 mb20">';
                    $html = $html.'<div class="box1-right_content3">';
                        $html = $html.'<a title="'.$val['title'].'" href="'.$href.'">';
                            $html = $html.'<img src="'.getthumb($val['images'], TRUE).'" alt="'.$val['title'].'" />';
                        $html = $html.'</a>';
                        $html = $html.'<h3 class="span_col3">';
                            $html = $html.'<a title="'.$val['title'].'" href="'.$href.'" >'.$val['title'].'</a>';
                        $html = $html.'</h3>';
                        $html = $html.'<div class="gia-col3">'.$pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '').'</div>';

                        $html = $html.'<div class="list-bottom-star">';
                        	if (!empty($number_sale)){
                                $html = $html.'<div class="left-star">'.$number_sale.'%</div>';
                        	}
                        	$html = $html.'<div class="list-icon-star '.((empty($number_sale)) ? 'text-left' : '').'">';
		                        $html = $html.'<ul>';
		                            $html = $html.'<li><i class="fas fa-star"></i></li>';
		                            $html = $html.'<li><i class="fas fa-star"></i></li>';
		                            $html = $html.'<li><i class="fas fa-star"></i></li>';
		                            $html = $html.'<li><i class="fas fa-star"></i></li>';
		                            $html = $html.'<li><i class="fas fa-star"></i></li>';
		                            $html = $html.'<li><span>( 30 )</span> </li>';
		                        $html = $html.'</ul>';
		                    $html = $html.'</div>';
                    	$html = $html.'</div>';

                    $html = $html.'</div>';
                $html = $html.'</div>';
                $page = $data['listPagination'];
			}
		}
		echo json_encode(array(
			'html' => $html,
			'page' => $page,
		));
		die();
	}
}
