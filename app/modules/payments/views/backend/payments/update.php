<section class="content-header">
	<h1>Cập nhật đơn hàng mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('payments/backend/payments/view');?>">đơn hàng</a></li>
		<li class="active"><a href="<?php echo site_url('payments/backend/payments/create');?>">Thêm đơn hàng mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form class="form-horizontal" method="post" action="">
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
						<!-- <li><a href="#tab-items" data-toggle="tab">Thông tin sản phẩm</a></li> -->
					</ul>
					<div class="tab-content">
						<div class="box-body">
							<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
						</div><!-- /.box-body -->
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left"></label>
									<div class="col-sm-10">
										<?php echo form_dropdown('sex', $this->configbie->data('sex'), set_value('publish', $DetailPayments['sex']), 'class="form-control" disabled style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Tên Khách hàng</label>
									<div class="col-sm-10">
										<?php echo form_input('fullname', set_value('fullname', $DetailPayments['fullname']), 'class="form-control form-static-link" placeholder="Họ tên khách hàng"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Số điện thoại</label>
									<div class="col-sm-10">
										<?php echo form_input('phone', set_value('phone', $DetailPayments['phone']), 'class="form-control form-static-link" placeholder="Số điện thoại"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Email</label>
									<div class="col-sm-10">
										<?php echo form_input('email', set_value('email', $DetailPayments['email']), 'class="form-control form-static-link" placeholder="Email"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Tỉnh/Thành Phố</label>
									<div class="col-sm-4">
										<?php echo form_input('cityid', set_value('cityid', $DetailPayments['cityid']), 'class="form-control" placeholder="Tỉnh/Thành Phố"');?>
									</div>
									<label class="col-sm-2 control-label tp-text-left">Quận/Huyện</label>
									<div class="col-sm-4">
										<?php echo form_input('districtid', set_value('districtid', $DetailPayments['districtid']), 'class="form-control" placeholder="Quận/Huyện"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Địa chỉ</label>
									<div class="col-sm-10">
										<?php echo form_input('address', set_value('address', $DetailPayments['address']), 'class="form-control" placeholder="Địa chỉ"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Ghi chú</label>
									<div class="col-sm-10">
										<?php echo form_textarea('content', htmlspecialchars_decode(set_value('message', $DetailPayments['message'])), 'id="txtContent" class="ckeditor-description" placeholder="Nội dung" style="width: 100%; height: 350px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>

								<div class="box-body table-responsive no-padding">
									<table class="table table-hover" id="diagnosis-list">
										<tr>
											<th>STT</th>
											<th>Ảnh</th>
											<th></th>
											<th>Thông tin đặt hàng</th>
											<th>Tổng tiền</th>
<!--											<th>Hoa hồng Affiliate</th>-->
										</tr>
										<?php
											$shipcode = array(
												'shop' => 'Mua tại cửa hàng',
												'inner' => 'Giao hàng khu vục nội thành Hà Nội',
												'outner' => 'Giao hàng các tỉnh',
											);
											// Giảm giá theo đơn hàng
                                            $price_gift = checkgiftcode_payment($DetailPayments['discount_code'], $DetailPayments['id']);
                                            //
											$affiliate_name = $this->BackendCustomers_Model->ReadByField('affiliate_id', $DetailPayments['affiliate_id']);
											$affliate_count = 0;
											$_payment_list_ = json_decode($DetailPayments['data'], TRUE);
											$price_affiliate = $total_ship = 0;
											if (isset($_payment_list_) && is_array($_payment_list_) && count($_payment_list_)): ?>
											<?php foreach($_payment_list_ as $key => $item){ ?>
												<?php
													$href = site_url('products/backend/products/update/'.$item['id'].'');
													if(!empty($item['detail']['shipcode'])){
														$ship_data = json_decode($item['detail']['shipcode'], TRUE);
														$total_ship += $ship_data[0][$DetailPayments['shipcode']];

													}
													// Phí vận chuyển cho mỗi sản phẩm
													// $total_ship += check_shipping_products($item['detail']['id'], $DetailPayments['shipcode']);

													$productDetail = $this->Autoload_Model->_get_where(array(
                                                        'select' => 'id, quantity, saleoff',
                                                        'table' => 'products',
                                                        'where' => array('publish' => 1, 'trash' => 0, 'id' => $item['id']),
                                                    ));
                                                    if (isset($productDetail) && is_array($productDetail) && count($productDetail)) {
                                                        // Kiểm tra tính hoa hồng cho người giới thiệu
                                                        if (isset($affiliate_name) && is_array($affiliate_name) && count($affiliate_name)) {
                                                            // Giá bán ra cho Affiliate
                                                            // $price_ = price_affiliate_id($productDetail['saleoff'], $productDetail['id'], $affiliate_name['id']);
                                                            $price_ = $item['price'] - ((isset($item['affiliate']) && is_array($item['affiliate']) && count($item['affiliate']) && !empty($item['affiliate']['count'])) ? $item['affiliate']['count'] : $item['price']);

                                                            $price_affiliate = ((!empty($price_)) ? $price_ : 0);
                                                        }
                                                    }
                                                    $affliate_count += $price_affiliate;
												?>
												<tr>
													<td><?php echo $key+1; ?></td>
													<td style="width:40px;">
														<img src="<?php echo $item['detail']['images']; ?>" alt="" style="width:40px;" />
													</td>
													<td style="text-align:left;">
														<a href="<?php echo $href; ?>" target="_blank" title="" style="color:#333;font-size:12px;font-weight:bold;">
															<?php echo $item['detail']['title']; ?>

														</a><br>

														<?php if(!empty($item['options']['sanphamtangkem'])) {

															$this->load->model('sanphamtangkem/FrontendSanphamtangkem_Model');
															$sanphamtangkem = $this->FrontendSanphamtangkem_Model->ReadByField('id', $item['options']['sanphamtangkem']);
															echo "Sản phẩm tặng kèm: ".$sanphamtangkem['title'];
														}?>

														<?php if (isset($item['options']) && is_array($item['options']) && count($item['options'])): ?>
                                                            <div class="uk-flex uk-flex-middle uk-grid-small">
                                                                <?php foreach ($item['options'] as $keyc => $vals): ?>
																<?php if($keyc != 'sanphamtangkem'){?>
                                                                    <span class="item_item"><?php echo $keyc.':'.$vals ?></span>
																<?php }?>
                                                                <?php endforeach ?>
                                                            </div>
                                                        <?php endif ?>





													</td>
													<td style="text-align:center;">
														<?php echo $item['qty'] ?> x <?php echo str_replace(',','.',number_format($item['price'])); ?> đ
													</td>
													<td style="text-align:center;">
														<strong><?php echo str_replace(',','.',number_format($item['subtotal'])); ?> đ</strong>
													</td>
													<td style="text-align:center;" class="hide">
														<strong><?php echo str_replace(',','.',number_format($price_affiliate)); ?> đ</strong>
													</td>
												</tr>
											<?php } ?>
										<?php endif ?>
										<tr>
											<td colspan="4" style="text-align: right"><strong>Tổng</strong></td>
											<td style="width: 140px; text-align: center">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($DetailPayments['total_price'])); ?>đ
												</span>
											</td>
											<td style="width: 140px;" class="hide">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($affliate_count)); ?>đ
												</span>
											</td>
										</tr>

										<?php $price_gift = checkgiftcode_payment($DetailPayments['discount_code'], $DetailPayments['id']); ?>
										<?php if($DetailPayments['total_price_sale']!=0){?>

										<tr>
											<td colspan="4" style="text-align: right"><strong>Chương trình khuyến mại</strong></td>
											<td style="width: 140px; text-align: center">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
												<?php echo '-'.str_replace(',','.',number_format($DetailPayments['total_price_sale'])); ?>đ
                                                </span>
											</td>
											<td class="hide" style="width: 140px;"></td>
										</tr>
										<?php }?>
										<?php if($DetailPayments['total_price_sale_khunggiovang']!=0){?>
										<tr>
											<td colspan="4" style="text-align: right"><strong>Chương trình khuyến mại khung giờ vàng</strong></td>
											<td style="width: 140px; text-align: center">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
												<?php echo '-'.str_replace(',','.',number_format($DetailPayments['total_price_sale_khunggiovang'])); ?>đ
                                                </span>
											</td>
											<td class="hide" style="width: 140px;"></td>
										</tr>
										<?php }?>
										<?php if($DetailPayments['discount_code']!=0){?>

										<tr>
											<td colspan="4" style="text-align: right"><strong>Giảm giá</strong></td>
											<td style="width: 140px; text-align: center">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo '-'.str_replace(',','.',number_format($price_gift)); ?>đ
												</span>
											</td>
											<td class="hide" style="width: 140px;"><?php echo $DetailPayments['discount_code'] ?></td>
										</tr>
										<?php }?>
										<?php if($DetailPayments['coint']!=0){?>

										<tr>
											<td colspan="4" style="text-align: right"><strong>Vando xu</strong></td>
											<td style="width: 140px; text-align: center">
												<span style="font-size:15px;font-weight:bold;">
													<?php echo '-'.str_replace(',','.',number_format($DetailPayments['coint'])); ?>đ
												</span>
											</td>
											<td class="hide" style="width: 140px;"></td>
										</tr>
										<?php }?>

										<tr>
											<td colspan="4" style="text-align: right"><strong>Tổng tiền</strong></td>
											<td style="width: 140px; text-align: center">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;color: green;font-weight: bold;font-size: 20px">
													<?php echo str_replace(',','.',number_format($DetailPayments['total_price']  - $price_gift - $DetailPayments['coint']-$DetailPayments['total_price_sale']-$DetailPayments['total_price_sale_khunggiovang'])); ?>đ
												</span>
											</td>
											<td style="width: 140px;" class="hide">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($affliate_count)); ?>đ
												</span>
											</td>
										</tr>
										<tr>
											<td colspan="4" style="text-align: right"><strong>Phí vận chuyển</strong></td>
											<td style="width: 140px; text-align: center">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													+<?php echo str_replace(',','.',number_format($DetailPayments['shipcode_value'])); ?>đ
												</span>
											</td>
										</tr>
										<tr>
											<td colspan="4" style="text-align: right"><strong>Tổng tiền cần thanh toán</strong></td>
											<td style="width: 140px; text-align: center">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;color: red;font-weight: bold;font-size: 20px">
													<?php echo str_replace(',','.',number_format($DetailPayments['total_price'] + $DetailPayments['shipcode_value'] - $price_gift - $DetailPayments['coint']-$DetailPayments['total_price_sale']-$DetailPayments['total_price_sale_khunggiovang'])); ?>đ
												</span>
											</td>
											<td style="width: 140px;" class="hide">
												<span class="<?php echo ($DetailPayments['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($affliate_count)); ?>đ
												</span>
											</td>
										</tr>
									</table>
								</div><!-- /.box-body -->

							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-items">
							<div class="box-body">

							</div>
						</div>
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
			<div class="col-md-3">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Nâng cao</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-seo">
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Trạng thái giao hàng</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('send', $this->configbie->data('send'), set_value('publish', $DetailPayments['send']), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Tình trạng</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('status', $this->configbie->data('status'), set_value('status', $DetailPayments['status']), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>
							<hr>
							<?php if (!empty($DetailPayments['affiliate_id'])): ?>
								<?php if (isset($affiliate_name) && is_array($affiliate_name) && count($affiliate_name)): ?>
									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">Người giới thiệu</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_input('affiliate_name', set_value('affiliate_name', $affiliate_name['fullname'].' - '.$affiliate_name['email']), 'class="form-control" disabled style="width: 100%;"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">Cấp Vip</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_dropdown('level', $this->BackendLevel_Model->Dropdown(), set_value('publish', $affiliate_name['level']), 'class="form-control" disabled style="width: 100%;"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">Hoa hồng Affiliate</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_input('affiliate_name', set_value('affiliate_name', str_replace(',','.',number_format($affliate_count - $price_gift)).' đ'), 'class="form-control" disabled style="width: 100%;"');?>
										</div>
									</div>
									<hr>
								<?php endif ?>
							<?php endif ?>
							<?php if (!empty($DetailPayments['process'])) { ?>
								<div class="callout callout-success">Đơn hàng của bạn đã hoàn thành</div>
							<?php }else{ ?>
								<div class="callout callout-danger">Note: Chọn đồng thời 2 trạng thái là <strong style="color: green">Đã giao hàng</strong> và <strong style="color: green">Hoàn thành</strong> để tích xử lý xong đơn hàng!</div>
							<?php } ?>
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer <?php echo ((!empty($DetailPayments['process'])) ? 'hide' : '') ?>">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
					</div><!-- /.box-footer -->
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
		</form>
	</div> <!-- /.row -->
</section><!-- /.content -->