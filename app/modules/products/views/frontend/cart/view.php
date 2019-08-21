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
			<p><i class="fas fa-question-circle"></i>&nbsp;<span>Thông tin khách hàng tuyệt đối bảo mật</span></p>
		</div>
		<div class="row row-tt">

			<div class="col-md-6 col-sm-12 col-xs-12 fl-right">
				<div class="wp-right-tt">
					<div class="wp-list-sp">
						<ul class="ul-b list-sp-tt">
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
					<div class="box-ma-gg">
						<div class="error uk-alert"></div>
						<div class="magg">
							<input type="text" name="discount_code" value="" class="text form-control" placeholder="Nhập mã giảm giá" />
							<input type="submit" class="btn btn-default button" value="Áp dụng" id="apply_gift_code" />

						</div>
					</div>
					<div class="list-thanhtien">
						<ul class="ul-b list-da">
							<li>
								<span>Tạm tính</span>
								<span class="sp2"><?php echo str_replace(',', '.', number_format($this->cart->total() - $totalsale - $totalKGVPT)) ?>₫</span>
							</li>
							<li>
								<span>Phí vận chuyển</span>
								<input type="hidden" name="shipcode">
								<div class="price_tt sp2" id="shipcode_value" data-price=""><input type="hidden" name="shipcode_value" value="0"><strong id="shipcode-uppercase"></strong></div>
							</li>
							<li>
								<span>Giảm giá</span>
								<div class="price_tt sp2" id="giftcode_value" data-price=""><input type="hidden" name="giftcode_value" value="0"><strong id="giftcode-uppercase">-</strong></div>
							</li>

						</ul>
					</div>
					<div class="tongtien">
						<div class="">
							<input type="hidden" name="userid" value="<?php echo ((!empty($customer['id'])) ? $customer['id'] : '') ?>">

							<input type="hidden" name="total_cart_money" id="total_cart_money" value="<?php echo $this->cart->total()?>">
							<span>Tổng cộng</span>
							<span id="price_tt" class="sp2">480,000 đ</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12 fl-left">
				<div class="wp-left-tt">
					<h2 class="h2-title p-mon">Thông tin giao hàng</h2>

						<div class="wp-form-tt">
							<div class="form-group">
								<?php $error = validation_errors(); if(isset($error) && !empty($error)){ ?>
									<div class="alert alert-danger" data-uk-alert=""><?php echo $error; ?></div>
								<?php } ?>
							</div>
							<div class="form-group">
								<input type="text" name="fullname" class="text form-control" placeholder="Ví dụ: Nguyễn Văn A" value="<?php echo set_value('fullname', ((!empty($customer['fullname'])) ? $customer['fullname'] : '') ) ?>" />
							</div>
							<div class="form-group group2">
								<input type="text" name="email" class="text form-control input-to" placeholder="supportxyz@gmail.com" value="<?php echo set_value('email', ((!empty($customer['email'])) ? $customer['email'] : '') ) ?>"/>
								<input type="text" name="phone" class="text form-control input-nho" placeholder="Ví dụ: 0987654321" value="<?php echo set_value('phone', ((!empty($customer['phone'])) ? $customer['phone'] : '') ) ?>" />
							</div>
							<div class="form-group">
								<div class="col right"><input type="text" name="address" class="text form-control" placeholder="Ví dụ: Số 10, Ngõ 50, Đường ABC" value="<?php echo set_value('phone', ((!empty($customer['phone'])) ? $customer['phone'] : '') ) ?>" /></div>
							</div>
							<div class="form-group group3">

								<?php echo form_dropdown('cityid', location_dropdown('Tỉnh/Thành Phố', array('parentid' => 0)), set_value('cityid'), 'class="form-control"   id="cityid"'); ?>

								<?php echo form_dropdown('districtid', array('--Quận/Huyện--'), set_value('districtid',$this->input->post('districtid')), 'class="form-control"  id="districtid"'); ?>

								<?php echo form_dropdown('wardid', array('--Phường/Xã--'), set_value('wardid'), 'class="form-control"  id="wardid"'); ?>

							</div>
							<div class="form-group">
								<textarea name="message" class="text form-control" placeholder="<?php echo $this->lang->line('note_message') ?>"></textarea>
							</div>

							<div class="wp-pt-thanhtoan">
								<p class="p-mon">Phương thức vận chuyển</p>
								<div class="radio">
									<label>
										<input type="radio" value="shop" name="pt-tt" checked=""> Giao hàng tận nơi(COD) <span>30.000 đ</span>
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" value="inner" name="pt-tt"> Giao hàng tận nơi(CK trước) <span>9.000 đ</span>
									</label>
								</div>
							</div>
							<div class="phuongthuc-ttt">
								<p class="p-mon">Phương thức thanh toán</p>
								<div class="wp-list-thanhtoan-a">
									<ul class="ul-b">
										<li>
											<div class="radio">
												<label>
													<input type="radio" value="cod" name="pt-tt2" checked=""> Thanh toán khi nhận hàng
												</label>
											</div>
										</li>
										<li>
											<div class="radio">
												<label>
													<input type="radio" value="online" name="pt-tt2"> Thanh toán online
												</label>
											</div>
										</li>

									</ul>
								</div>
							</div>
							<div class="btn-thanhtoan">
								<a href="<?php echo base_url()?>"><i class="fas fa-arrow-left"></i>&nbsp;Tiếp tục mua hàng</a>
								<button type="submit" name="create" value="create" class="uk-button btn btn-default" style="border: 0px">Hoàn tất đơn hàng</button>

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
<script type="text/javascript">
	$(document).ready(function () {
		$('#cityid').change(function () {
			var city_id = $('#cityid').val();
			$.post('<?php echo site_url('products/ajax/cart/ajax_location')?>', {
					cityid: city_id,
					quanhuyen: 0,

				},
				function (data) {
					var json = JSON.parse(data);
					$('#districtid').html(json.option);
				});
			return false;
		});
		$('#districtid').change(function () {
			var districtid = $('#districtid').val();
			$.post('<?php echo site_url('products/ajax/cart/ajax_location')?>', {
					cityid: districtid,
					quanhuyen: 1,
				},
				function (data) {
					var json = JSON.parse(data);
					$('#wardid').html(json.option);
				});
			return false;
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		load_total_price_cart();
		$('.error').hide();
		//tính phí vận chuyển
		$('input[name="pt-tt"]').each(function() {
			var check = <?php if(!empty($SaleTheoKGVPhiVanChuyen)){?>1<?php }else{?>0<?php }?>;
			var shipcode = $('input[name="pt-tt"]:checked').val();
			var id_list = $('#id_list').val();
			$('input[name="pt-tt"]').change(function () {
				var check = <?php if(!empty($SaleTheoKGVPhiVanChuyen)){?>1<?php }else{?>0<?php }?>;
				var shipcode = $('input[name="pt-tt"]:checked').val();
				var id_list = $('#id_list').val();
				$.post('<?php echo site_url('products/ajax/cart/ajax_shipcode')?>', {
					check: check,shipcode: shipcode, id_list: id_list
				},function(data){
					var json = JSON.parse(data);
					$('#shipcode_value').attr('data-price', json.price);
					$('#shipcode_value').find('input').attr('value', json.price);
					$('#shipcode-uppercase').html(number_format(json.price, 0, '.', '.')+' ₫');
					load_total_price_cart();
				});
				return false;
			});
			$.post('<?php echo site_url('products/ajax/cart/ajax_shipcode')?>', {
				check: check,shipcode: shipcode, id_list: id_list
			},function(data){
				var json = JSON.parse(data);
				$('#shipcode_value').attr('data-price', json.price);
				$('#shipcode_value').find('input').attr('value', json.price);
				$('#shipcode-uppercase').html(number_format(json.price, 0, '.', '.')+' ₫');
				load_total_price_cart();
			});
			return false;

		});
		//end tính phí vận chuyển
		//tính giftcode mã giảm giá
		$('#apply_gift_code').click(function(){
			var giftcode = $('input[name="discount_code"]').val();
			$.post('<?php echo site_url('products/ajax/cart/apply_gift_code')?>', {
				giftcode: giftcode
			},function(data){
				var json = JSON.parse(data);
				$('.error').show();
				if(json.error.length){
					$('#giftcode_value').addClass('d-none').attr('data-type', json.typeoff).attr('data-value', json.result).attr('data-price', json.price);
					$('.error').removeClass('alert alert-success').addClass('alert alert-danger');
					$('.error').html('').html(json.error);
				}else{
					$('#giftcode_value').removeClass('d-none').attr('data-type', json.typeoff).attr('data-value', json.result).attr('data-price', json.price);
					$('#giftcode-uppercase').html('-' + number_format(json.price, 0, '.', '.')+ ' ₫');
					$('#giftcode_value').find('input').attr('value', json.price);
					$('.error').removeClass('alert alert-danger').addClass('alert alert-success');
					$('.error').html('').html(json.message);
				}
				load_total_price_cart();
			});
			return false;
		});
		//end

		function load_total_price_cart(){
			var salesoluong = <?php echo (int)$totalsale?>;
			var saleKGVPT = <?php echo (int)$totalKGVPT?>;
			var shipcode = parseInt($('input[name="shipcode_value"]').val());
			var giftcode = parseInt($('input[name="giftcode_value"]').val());
			var total = parseInt($('#total_cart_money').val());
//
			$('#price_tt').html(number_format(( total + shipcode - giftcode - salesoluong - saleKGVPT), 0, '.', '.')+' ₫');
			$('#total_total').attr('data-price', (total + shipcode - giftcode - salesoluong - saleKGVPT));
			$('#total_total').find('input').attr('value', (total + shipcode - giftcode - salesoluong - saleKGVPT));
//			load_coint_cart();
		}


		function number_format (number, decimals, dec_point, thousands_sep) {
			number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
			var n = !isFinite(+number) ? 0 : +number,
				prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
				sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
				dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
				s = '',
				toFixedFix = function (n, prec) {
					var k = Math.pow(10, prec);
					return '' + Math.round(n * k) / k;
				};
			// Fix for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			if (s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
			}
			if ((s[1] || '').length < prec) {
				s[1] = s[1] || '';
				s[1] += new Array(prec - s[1].length + 1).join('0');
			}
			return s.join(dec);
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.fc-cart-update').change(function(){
			var qty = $(this).val();
			var rowid = $(this).attr('data-id');
			$.post('<?php echo site_url('products/ajax/cart/updateitemcart')?>', {
				qty: qty,
				rowid: rowid,
			},function(data){
				window.location.href = 'dat-mua.html';
			});
			return false;
		});
	});
	$(document).on('click', '.delete_item', function(){
		var item = $(this);
		var idprd = item.parent().parent().parent().parent().find('.ajax-quantity').val();
		ajax_cart_update1(idprd);
		return false;
	});
	function ajax_cart_update1(idprd){
		$.post('<?php echo site_url('products/ajax/cart/deletecart');?>', {idprd:idprd}, function(data){
			window.location.href = 'dat-mua.html';
		});
	}
</script>