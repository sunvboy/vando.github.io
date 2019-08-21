<?php
$this->load->model('FrontendSaleDG_Model');

$totalsale = 0;
$SaleTheoSoLuongDonHang = $this->FrontendSaleDG_Model->ReadByFieldSoLuong('1');
if(!empty($SaleTheoSoLuongDonHang)){
	if($this->cart->total_items() >= $SaleTheoSoLuongDonHang['qty']){
		$totalsale = ($this->cart->total()/100)*$SaleTheoSoLuongDonHang['saleoff'];

	}
}
?>
<!--end lấy sale theo số lượng-->
<!--lấy sale theo khung giờ vàng giảm theo %-->
<?php
$totalKGVPT = 0;
$SaleTheoKGVPT = $this->FrontendSaleDG_Model->ReadByFieldSoLuong('2');
if(!empty($SaleTheoKGVPT)){
	$totalKGVPT = ($this->cart->total()/100)*$SaleTheoKGVPT['saleoff'];

}
?>
<!--end lấy sale theo khung giờ vàng giảm theo %-->
<!--lấy sale theo khung giờ vàng freeship-->
<?php
$SaleTheoKGVPhiVanChuyen = $this->FrontendSaleDG_Model->ReadByFieldSoLuong('3');
?>
<!--end lấy sale theo khung giờ vàng freeship-->
<?php $customer = $this->config->item('fcCustomer'); ?>
<form action="" method="post">
	<main id="main-thanhtoan">
		<div class="container">
			<div class="wp-header-thanhtoan">
				<div class="wp-logo-fft">
					<a href="<?php echo base_url()?>"><img src="<?php echo $this->fcSystem['homepage_logo']?>" alt="<?php echo $this->fcSystem['homepage_company']?>"></a>
				</div>
				<p><i class="fas fa-question-circle"></i>&nbsp;<span>Đặt hàng thành công</span></p>
			</div>
			<div class="row row-tt">
				<div class="col-md-6 col-sm-12 col-xs-12 fl-right">
					<div class="wp-right-tt">
						<div class="wp-list-sp">
							<ul class="ul-b list-sp-tt">
								<?php $cart = json_decode($payment['data'], TRUE); ?>
								<?php if(isset($cart) && is_array($cart) && count($cart)){ ?>
									<?php foreach($cart as $key => $val){ ?>
										<?php $val['detail']['href'] = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products'); ?>
										<?php $price = $val['price']; ?>
										<li class="item-sp-tt">
											<div class="img-sp-tt">
												<a href="<?php echo $val['detail']['href']?>"><img src="<?php echo getthumb($val['detail']['images']);?>" alt="<?php echo $val['name']; ?>"></a>
											</div>
											<div class="text-sp-tt">
												<h4 class="h4-title"><?php echo $val['name']; ?></h4>
												<h4 class="h4-title">
													<?php if(!empty($val['options']['sanphamtangkem'])) {
														$this->load->model('sanphamtangkem/FrontendSanphamtangkem_Model');
														$sanphamtangkem = $this->FrontendSanphamtangkem_Model->ReadByField('id', $val['options']['sanphamtangkem']);
														echo 'Tặng kèm: '.$sanphamtangkem['title'];
													}?>
												</h4>
												<div class="price">
													<span><?php echo str_replace(',', '.', number_format($price))?>₫</span>
												</div>
												<div class="mau-size">
													<ul class="ul-b list-tt111">
														<?php if (isset($val['options']) && is_array($val['options']) && count($val['options'])): ?>
															<?php foreach ($val['options'] as $keyc => $vals): ?>
																<?php if($vals != ''){?>
																	<?php if($keyc != 'sanphamtangkem'){?>
																		<li><?php echo $keyc.':'.$vals ?></li>
																	<?php }?>
																<?php }?>
															<?php endforeach ?>
														<?php endif ?>

													</ul>
												</div>
											</div>
										</li>
									<?php }?>
								<?php }?>
							</ul>
						</div>
						<div class="list-thanhtien">
							<ul class="ul-b list-da">
								<li>
									<span>Tạm tính</span>
									<span class="sp2"><?php echo str_replace(',', '.', number_format($payment['total_price'])); ?>₫</span>
								</li>
								<li>
									<span>Phí vận chuyển</span>
									<input type="hidden" name="shipcode">
									<div class="price_tt sp2" id="shipcode_value"><strong id="shipcode-uppercase"><?php echo str_replace(',', '.', number_format($payment['shipcode_value'])) ?>₫</strong></div>
								</li>
								<?php $price_gift = checkgiftcode_payment($payment['discount_code'], $payment['id']); ?>
								<?php if(!empty($price_gift)){?>
								<li>
									<span>Giảm giá</span>
									<div class="price_tt sp2" id="giftcode_value"><strong id="giftcode-uppercase"><?php echo '-'.str_replace(',', '.', number_format($price_gift)) ?>₫</strong></div>
								</li>
								<?php }?>
							</ul>
						</div>
						<div class="tongtien">
							<div class="">
								<input type="hidden" name="userid" value="<?php echo ((!empty($customer['id'])) ? $customer['id'] : '') ?>">

								<input type="hidden" name="total_cart_money" id="total_cart_money" value="<?php echo $this->cart->total()?>">
								<span>Tổng cộng</span>
								<span id="price_tt" class="sp2"><?php echo str_replace(',', '.', number_format($payment['total_price'] + $payment['shipcode_value'] - $price_gift - $payment['coint']-$payment['total_price_sale']-$payment['total_price_sale_khunggiovang'])) ?>₫</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 fl-left">
					<div class="wp-left-tt">
						<div class="form-group">
							<?php if($payment['payments']=='online'){?>
								<?php if($payment['payments_status']==1){?>
									<div class="alert alert-success" data-uk-alert="">Thanh toán thành công qua VNPAY</div>

								<?php }else{?>
									<div class="alert alert-danger" data-uk-alert="">Thanh toán quan VNPAY không thành công</div>


							<?php }?>
							<?php }?>
						</div>
						<h2 class="h2-title p-mon">Thông tin giao hàng</h2>

						<div class="wp-form-tt">

							<?php
							$this->load->model('province/BackendProvince_Model');
							$cityid = $this->BackendProvince_Model->readF($payment['cityid']);
							$districtid = $this->BackendProvince_Model->readF($payment['districtid']);
							$wardid = $this->BackendProvince_Model->readF($payment['wardid']);
							?>
							<div class="infoorder mb15" style="line-height: 25px">
								<div class="item mb5"><strong><?php echo $this->lang->line('fullname_customers') ?>:</strong> <?php echo !empty($payment['fullname'])?$payment['fullname']:'-'; ?></div>
								<div class="item mb5"><strong><?php echo $this->lang->line('phone_customers') ?>:</strong> <?php echo !empty($payment['phone'])?$payment['phone']:'-'; ?></div>
								<div class="item mb5"><strong>Email:</strong> <?php echo !empty($payment['email'])?$payment['email']:'-'; ?></div>
								<div class="item mb5"><strong>Tỉnh/Thành phố:</strong> <?php echo !empty($cityid)?$cityid:'-'; ?></div>
								<div class="item mb5"><strong>Quận/Huyện:</strong> <?php echo !empty($districtid)?$districtid:'-'; ?></div>
								<div class="item mb5"><strong>Phường/Xã:</strong> <?php echo !empty($wardid)?$wardid:'-'; ?></div>
								<div class="item mb5"><strong>Địa chỉ:</strong> <?php echo !empty($payment['address'])?$payment['address']:'-'; ?></div>
								<div class="item mb5 d-none"><strong>Nội dung:</strong> <?php echo !empty($payment['message'])?$payment['message']:'-'; ?></div>
								<div class="item price mb5" id="total_total_1"><strong><?php echo $this->lang->line('total_money') ?>:</strong> <span><?php echo str_replace(',', '.', number_format($payment['total_price'] + $payment['shipcode_value'] - $price_gift - $payment['coint']-$payment['total_price_sale']-$payment['total_price_sale_khunggiovang'])) ?>₫</span></div>
							</div>
							<div class="btn-thanhtoan">
								<a style="width: 100%;float: left;color: #337ab7" href="<?php echo base_url()?>"><i class="fas fa-arrow-left"></i>&nbsp;Tiếp tục mua hàng</a><br>
								<input type="submit" value="<?php echo $this->lang->line('receiving_mail_system') ?>" class="confirm uk-button btn btn-default" name="confirm" style="background: #c73550; border: 0px;text-transform: uppercase;float: left;color: #fff;margin-top: 20px"/>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>
</form>
<style>
	header,footer{
		display: none;
	}
</style>
