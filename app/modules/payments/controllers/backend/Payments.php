<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends FC_Controller{
	
	public $action;
	public $status;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendPayments_Model',
			'BackendItems_Model',
			'customers/BackendCustomers_Model',
			'customers/BackendLevel_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
		));
		$this->load->library(array('configbie'));
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'payments/backend/payments/view'
		));
		$userid = 0;
		if(in_array('payments/backend/payments/limit', $this->fcUser['group']) == FALSE){
			$userid = $this->fcUser['id'];
		}
		$page = (int)$page;
		$config['total_rows'] = $this->BackendPayments_Model->CountAll($userid);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('payments/backend/payments/view');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
			$config['full_tag_close'] = '</ul>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['ListPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['Listpayments'] = $this->BackendPayments_Model->ReadAll($userid, ($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'payments/backend/payments/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'payments/backend/payments/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
			if ($this->form_validation->run($this)){
				$resultid = $this->BackendPayments_Model->Create($this->fcUser);
				if($resultid > 0){
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'payments/frontend/payments/view', $resultid, 'number');
					}
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'payments',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendPayments_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$this->BackendTags_Model->InsertByModule($resultid, 'payments');
					$this->session->set_flashdata('message-success', 'Thêm đơn hàng mới thành công');
					redirect('payments/backend/payments/view');
				}
			}
		}
		$data['template'] = 'payments/backend/payments/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}


	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'payments/backend/payments/update'
		));
		$id = (int)$id;
		$data['DetailPayments'] = $this->BackendPayments_Model->ReadByField('id', $id);
		if(!isset($data['DetailPayments']) && !is_array($data['DetailPayments']) && count($data['DetailPayments']) == 0){
			$this->session->set_flashdata('message-danger', 'đơn hàng không tồn tại');
			redirect_custom('payments/backend/payments/view');
		}
		$catalogues = $this->input->post('catalogue');
		if($this->input->post('update')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
			if ($this->form_validation->run($this)){
				$status = $this->input->post('status');
				$send = $this->input->post('send');
				$flag = $this->BackendPayments_Model->_update(array(
					'where' => array('id' => $id),
					'table' => 'payments',
					'data' => array(
						'fullname' => $this->input->post('fullname'),
						'phone' => $this->input->post('phone'),
						'email' => $this->input->post('email'),
						'address' => $this->input->post('address'),
						'message' => $this->input->post('message'),
						'status' => $this->input->post('status'),
						'send' => $this->input->post('send'),
					),
				));
				if($flag > 0){
					if ($status == 'success' && $send == 1) {
						// Cập nhật lại số lượng sản phẩm trong quản trị
						$affiliate_name = $this->BackendCustomers_Model->ReadByField('affiliate_id', $data['DetailPayments']['affiliate_id']);
						$_payment_list_ = json_decode($data['DetailPayments']['data'], TRUE);
						// Khuyến mại được trừ
						$gift_code = checkgiftcode_payment($data['DetailPayments']['discount_code'], $data['DetailPayments']['id']);
						$price_affiliate = 0;
						if(isset($_payment_list_) && is_array($_payment_list_) && count($_payment_list_)){
							foreach($_payment_list_ as $key => $val){
								// Lấy thông tin sản phẩm
								$productDetail = $this->Autoload_Model->_get_where(array(
									'select' => 'id, quantity, saleoff',
									'table' => 'products',
									'where' => array('publish' => 1, 'trash' => 0, 'id' => $val['id']),
								));
								if (isset($productDetail) && is_array($productDetail) && count($productDetail)) {

									// Nếu sản phẩm có lựa chọn phân loại hàng
									if (isset($val['options']) && is_array($val['options']) && count($val['options'])) {
										$text = implode(',', $val['options']);
										// Cập nhật số lượng cho phân loại đã chọn
										$advanced_relation = $this->Autoload_Model->_get_where(array(
											'select' => 'productsid, quantity, title',
											'table' => 'products_att_advanced_relation',
											'where' => array('productsid' => $productDetail['id'], 'title' => $text),
											'limit' => 1
										));

										if (isset($advanced_relation) && is_array($advanced_relation) && count($advanced_relation)) {
											// Cập nhật số lượng sản phẩm
											$_update_['quantity'] = (int)$advanced_relation['quantity'] - $val['qty'];
											$_update_['quantity'] = ($_update_['quantity'] <= 0) ? 0 : $_update_['quantity'];
											$this->db->where(array('productsid' => $productDetail['id'], 'title' => $text));
											$this->db->update('products_att_advanced_relation', $_update_);
										}
									}

									// Cập nhật số lượng sản phẩm
									$_update['quantity'] = (int)$productDetail['quantity'] - $val['qty'];
									$_update['quantity'] = ($_update['quantity'] <= 0) ? 0 : $_update['quantity'];
									$this->db->where(array('id' => $productDetail['id']));
									$this->db->update('products', $_update);

									// Tính hoa hồng Affiliate
									// HOA HỒNG  = GIÁ BÁN LẺ TRÊN WEBSITE - GIÁ BÁN RA CHO AFFILIATE - KHUYẾN MÃI (KHUYẾN MÃI NÀY THAY ĐỔI ĐƯỢC, BẰNG CÁCH TẠO MÃ KM THEO GIÁ TIỀN HOẶC THEO %)
									// Nếu có người giới thiệu 
									if (isset($affiliate_name) && is_array($affiliate_name) && count($affiliate_name)) {
										// Giá bán ra cho Affiliate
									 	$price_ = price_affiliate_id($val['detail']['saleoff'], $val['id'], $affiliate_name['id']);
                                        $price_affiliate += ((!empty($price_)) ? $price_ : 0);
									}
								}
							}
						}
						// Nếu có hoa hồng cho Affiliate tiến hành ghi log
						if (!empty($price_affiliate)) {
							// Cập nhật log lịch sử thự hưởng
							$insert_affiliate = $this->Autoload_Model->_create(array(
								'table' => 'customers_log_affiliate',
								'data' => array(
									'title' => 'Nhận hoa hồng thụ hưởng Affiliate',
									'customersid' => $affiliate_name['id'],
									'paymentsid' => $data['DetailPayments']['id'],
									'type_aff' => 1,
									'money' => ($price_affiliate - $gift_code),
									'status' => 1,
									'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
								),
							));
						}

						// Nếu Người mua hàng là thành viên của shop thực hiện ghi log tặng xu. 1k vnd = 1xu
						if (!empty($data['DetailPayments']['customersid'])) {
							$insert_coint = $this->Autoload_Model->_create(array(
								'table' => 'customers_coint',
								'data' => array(
									'title' => 'Xu tích điểm mua hàng',
									'customers_id' => $data['DetailPayments']['customersid'],
									'paymentsid' => $data['DetailPayments']['id'],
									'type' => 0,
									'coint' => ceil((($data['DetailPayments']['total_price'] - $gift_code)/1000)),
									'publish' => 1,
									'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
								),
							));
						}
						
						//Cập nhật trạng thái đơn hàng đã xử lý
						$_update_info['process'] = 1;
						$_update_info['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
						$this->db->where(array('id' => $data['DetailPayments']['id']));
						$this->db->update('payments', $_update_info);
					}
					$this->session->set_flashdata('message-success', 'Cập nhật đơn hàng thành công');
					redirect_custom('payments/backend/payments/view');
				}
			}
		}
		$data['template'] = 'payments/backend/payments/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'payments/backend/payments/delete'
		));
		$id = (int)$id;
		$data['DetailPayments'] = $this->BackendPayments_Model->ReadByField('id', $id);
		if(!isset($data['DetailPayments']) && !is_array($data['DetailPayments']) && count($data['DetailPayments']) == 0){
			$this->session->set_flashdata('message-danger', 'đơn hàng không tồn tại');
			redirect_custom('payments/backend/payments/view');
		}
		if($this->input->post('delete')){
			
			
			$flag = $this->BackendPayments_Model->DeleteByField('id', $id);
			if($flag > 0){

				/* Nếu đơn hàng chưa hoàn thành. Xóa bản ghi dùng xu tích điểm mua hàng */
				if ($data['DetailPayments']['status'] != 'success' && $data['DetailPayments']['send'] != 1) {
					$this->BackendPayments_Model->_delete(array(
						'table' => 'customers_coint',
						'where' => array('paymentsid' => $id),
						'data' => array(
							'trash' => 1,
						),
					));
				}
				/* ---------------------*/

				/* Xóa chi tiết đơn hàng */
					$this->BackendPayments_Model->_delete(array(
						'table' => 'payments_items',
						'where' => array('paymentsid' => $id),
						'data' => array(
							'trash' => 1,
						),
					));
				/* ---------------------*/
				
				$this->session->set_flashdata('message-success', 'Xóa đơn hàng thành công');
				redirect('payments/backend/payments/view');
			}
		}
		$data['template'] = 'payments/backend/payments/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	public function Export(){
		$this->commonbie->Permissions(array(
			'uri' => 'payments/backend/payments/export'
		));
		$url = substr(APPPATH, 0, -4);
		$excel_path = $url.'plugins/PHPExcel/Classes/PHPExcel.php';
		require($excel_path);
		if($this->input->post('export')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('from', 'Ngày bắt đầu', 'trim|required');
			$this->form_validation->set_rules('to', 'Ngày kết thúc', 'trim|required');
			if ($this->form_validation->run($this)){
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->setActiveSheetIndex(0); 
				$post = $this->input->post();
				$from = convert_time($post['from']);
				$to = convert_time($post['to']);
				$status = $this->input->post('status');
				$keyword = $this->input->post('keyword');
			
				$list_payment = $this->BackendPayments_Model->ReadDataByTime(array(
					'from' => $from,
					'to' => $to,
					'status' => $status,
					'keyword' => $keyword,
				));
				$where = '';
				if(!empty($status)){
					$where = 'AND `pt`.`status` = \''.$status.'\'';
				}
				if(!empty($keyword)){
					if(empty($where)){
						$where = 'AND (`pt`.`fullname` LIKE \'%'.$keyword.'%\' OR `pt`.`email` LIKE \'%'.$keyword.'%\' OR `pt`.`phone` LIKE \'%'.$keyword.'%\' OR `pt`.`address` LIKE \'%'.$keyword.'%\' OR `pt`.`message` LIKE \'%'.$keyword.'%\')';
					}else{
						$where = $where.' AND (`pt`.`fullname` LIKE \'%'.$keyword.'%\' OR `pt`.`email` LIKE \'%'.$keyword.'%\' OR `pt`.`phone` LIKE \'%'.$keyword.'%\' OR `pt`.`address` LIKE \'%'.$keyword.'%\' OR `pt`.`message` LIKE \'%'.$keyword.'%\')';
					}
				}
				
				$list_payment_1 = $this->BackendPayments_Model->ReadDataRelationShip(array(
					'where' => '`pt`.`created` >= \''.$from.'\' AND `pt`.`created` <= \''.$to.'\''.' '.((!empty($where)) ? $where : '').'',
				));
			
				$status = $this->configbie->data('status');
				$action = $this->configbie->data('send');
				$columnArray = array("A", "B", "C", "D", "E", "F", "G","H","I","J","K","L","M","N","O","P","Q");
				$titlecolumnArray = array('STT','MÃ SP','TÊN SẢN PHẨM','HÌNH ẢNH','MÃ ĐƠN HÀNG','KHÁCH HÀNG','GIỚI TÍNH','SỐ ĐIỆN THOẠI','EMAIL','TỈNH/THÀNH PHỐ','QUẬN/HUYỆN','ĐỊA CHỈ','TỔNG TIỀN','GHI CHÚ','TRẠNG THÁI','TÌNH TRẠNG','NGÀY ĐẶT HÀNG');
				$row_count = 1;
				 $styleArray = array(
					  'borders' => array(
						  'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
						  )
					  )
				  );
				$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);
				foreach($columnArray as $key => $val){
					$objPHPExcel->getActiveSheet()->SetCellValue($val.$row_count, $titlecolumnArray[$key]);  // lấy ra tiêu đề của từng cột	
					 $objPHPExcel->getActiveSheet()->getColumnDimension($val)->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($val.$row_count)->applyFromArray(
						array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'F28A8C')
							)
						)
					);
				}
				$i = 2;
				$total_row = $i + count($list_payment_1);
				$total = 0;
				if(isset($list_payment_1) && is_array($list_payment_1) && count($list_payment_1)){
					// $_product_ = '';
					// if(isset($list_payment) && is_array() )
					foreach($list_payment_1 as $key => $val){
						
						
						$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(50);
						$total = $total + $val['total_price'];
						$city = location_dropdown('Thành phố', array('id' => $val['cityid']));
						$district = location_dropdown('Quận HUyện', array('id' => $val['districtid']));
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $i); 
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $val['id']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $val['title']); 
						// $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $val['images']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, '#'.(10000+$val['paymentsid'])); 
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $val['fullname']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, (($val['gender'] == 0) ? 'Nam' : 'Nữ')); 
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $val['phone']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $val['email']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $city[$val['cityid']]); 
						$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $district[$val['districtid']]); 
						$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $val['address']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $val['total_price']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $val['message']); 
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $status[$val['status']]); 
						$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $action[$val['send']]); 
						$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, gettime($val['created'])); 
						
						
						$objDrawing = new PHPExcel_Worksheet_Drawing();
						$objDrawing->setName('Thumb');
						$objDrawing->setDescription('Thumbnail Image');
						$objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . getthumb($val['images']));
						$objDrawing->setHeight(60);
						$objDrawing->setCoordinates('D'.$i.'');
						$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						
						$i++;
					}
				}
				
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(75);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(26);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(33);
				$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14);
				$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(17);
				$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
				$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(17);
				$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
				
				$style = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
				);
				
				/* BORDER */
				
				/* --------------- */
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$total_row.':L'.$total_row.'')->applyFromArray($style);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$total_row.':L'.$total_row.'', 'Tổng');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$total_row, 'Tổng'); 
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$total_row, $total); 
				
				
				
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
				// Write the Excel file to filename some_excel_file.xlsx in the current directory
				$objWriter->save(''.$url.'uploads/files/excel/result'.str_replace('/','_',date("Y/m/d")).'.xlsx'); 
				$data['filename'] = 'uploads/files/excel/result'.str_replace('/','_',date("Y/m/d")).'.xlsx';
				// $objWriter->save("php://output");
			}
		}
		
		
		$data['template'] = 'payments/backend/payments/export';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
}
