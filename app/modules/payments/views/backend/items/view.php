<style>
	.fix{float:right;}
	.fix a{    display: block;font-size: 12px; line-height: 16px;  background: #f4c58f; padding: 3px;border-radius: 3px;color: #815621 !important;font-weight: bold;}
	#infor .item{margin-bottom:15px;}
	#infor .item .text{font-weight:bold;padding-left:3px;}
	#infor .item input{border:1px solid #e3e3e3;width:100%;padding:0 8px 0 8px;border-radius:5px;height:32px;}
	#infor .item select{height:32px;border-radius:3px;border-color:#e3e3e3;}
	#infor .save{background:#6b1313;border:0;border-radius:3px;color:#fff;padding: 5px 16px;}
	
</style>

<section class="content-header">
	<h1>Chi tiết đơn hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('items/backend/items/view');?>">Danh mục bài viết</a></li>
	</ol>
</section>
<?php if(isset($payment) && is_array($payment) && count($payment)){ ?>
<section class="content" id="print">
  <div class="row">
	<div class="col-xs-9">
	  <div class="box">
		<div class="box-header">
			<div class="box-tools pull-left">
				Danh sách đơn hàng / <?php echo gettime($payment['created']); ?> / Mã đơn hàng:  #<?php echo (10000+$payment['id']); ?>
				<!-- <i style="margin-left:20px;font-weight:bold;font-size:15px;cursor:pointer;" class="fa fa-print" onclick="printDiv('print');"></i> -->
			</div>
		</div><!-- /.box-header -->
		<?php echo show_flashdata();?>
		
		<?php 
			$_payment_list_ = json_decode($payment['data'], TRUE);
			// print_r($_payment_list_);die;
		?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>STT</th>
					<th>Ảnh</th>
					<th></th>
					<th>Thông tin đặt hàng</th>
					<th>Tổng tiền</th>
				</tr>
				<?php foreach($_payment_list_ as $key => $item){ ?>
					<?php $href = rewrite_url($item['detail']['canonical'], $item['detail']['slug'], $item['detail']['id'], 'products'); ?>
					<?php  
						$code_active = $this->BackendItems_Model->_get_where(array(
							'select' => 'id, salt, code',
				            'table' => 'products_code',
				            'where' => array('productsid' => $item['detail']['id'], 'customersid' => $payment['customersid']),
				            'limit' => 1,
				            'order_by' => 'id desc',
						))
					?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td style="width:40px;"><img src="<?php echo $item['detail']['images']; ?>" alt="" style="width:40px;height:25px;" /></td>
						<td style="text-align:left;"><a href="<?php echo $href; ?>" target="_blank" title="" style="color:#333;font-size:12px;font-weight:bold;"><?php echo $item['detail']['title']; ?></a></td>
						<td style="text-align:center;"><?php echo $item['qty'] ?> x <?php echo str_replace(',','.',number_format($item['price'])); ?></td>
						<td style="text-align:center;"><strong><?php echo str_replace(',','.',number_format($item['subtotal'])); ?></strong></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="4"><strong>Tổng</strong></td>
					<td style="width:40px;">
						<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
							<?php echo str_replace(',','.',number_format($payment['total_price'])); ?>đ
						</span>
					</td>
				</tr>
			</table>
			</form>
		</div><!-- /.box-body -->
		
		
		
		
	  </div><!-- /.box -->
	</div>
	<div class="col-xs-3">
		<div class="box">
			<div class="box-header">
				<span class="address">Địa chỉ giao hàng</span>
				<div class="fix">
					<a href="" title="" data-toggle="modal" data-target="#myModal">Chỉnh sửa</a>
				</div>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label class="col-sm-12 control-label tp-text-left">Thành viên mua hàng</label>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<?php echo ((!empty($payment['customersid'])) ? '<a target="_blank" style="color: red" href="'.site_url('customers/backend/customers/update/'.$payment['customersid']).'">'.$customers[$payment['customersid']].'</a>' : '<span style="color: red">Chưa xác định</span>') ?>
					</div>
				</div>
				<div class="clearfix"></div>
				<p></p>
				<?php $city = location_dropdown('Thành phố', array('id' => $payment['cityid']));?>
				<p><i class="fa fa-credit-card" aria-hidden="true"></i> <span style="font-weight:bold;margin-left:10px;"><?php echo $payment['fullname']; ?></span></p>
				<p class="hide"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span style="font-weight:bold;margin-left:10px;"><?php echo $payment['email']; ?></span></p>
				<p><i class="fa fa-map-marker" aria-hidden="true"></i> <span style="font-weight:bold;margin-left:10px;"><?php echo $payment['address']; ?></span></p>
				<p><i class="fa fa-phone-square" aria-hidden="true"></i> <span style="font-weight:bold;margin-left:10px;"><?php echo $payment['phone']; ?></span></p>
				<?php $map = $payment['address'].' '.$city[$payment['cityid']];  ?>
				<p><a style="text-decoration:underline;" class="map" href="https://www.google.com/maps/place/<?php echo $map; ?>" target="_blank">Xem bản đồ</a></p>
			</div>
		</div>
	</div>
  </div>
</section><!-- /.content -->
<?php } else { ?>
	<div class="box-body">
		<div class="callout callout-danger" >Không có dữ liệu</div>
	</div><!-- /.box-body -->
<?php } ?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<form class="" id="infor" method="post" action="">
		<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Chỉnh sửa thông tin khách hàng</h4>
			</div>
			<div class="modal-body" style="width: 100%; float: left;">
				<div class="col-xs-6 item">
					<div class="text">Họ tên</div>
					<input type="text" name="fullname" value="<?php echo set_value('fullname', $payment['fullname']); ?>" placeholder="Họ tên khách hàng" />
					<input type="hidden" value="<?php echo $payment['id'] ?>" name="id" />
				</div>
				<div class="col-xs-6 item">
					<div class="text">Email</div>
					<input type="text" name="email" value="<?php echo set_value('email', $payment['email']); ?>" placeholder="Email" />
				</div>
				<div class="col-xs-6 item">
					<div class="text">Số điện thoại</div>
					<input type="text" name="phone" value="<?php echo set_value('phone', $payment['phone']); ?>" placeholder="Số điện thoại" />
				</div>
				<div class="col-xs-6 item">
					<div class="text">Địa chỉ</div>
					<input type="text" name="address" value="<?php echo set_value('address', $payment['address']); ?>" placeholder="Địa chỉ" />
				</div>
				<div class="col-xs-6 item">
					<div class="text">Tỉnh / Thành phố</div>
					<?php echo form_dropdown('cityid', location_dropdown('Thành phố', array('parentid' => 0)), set_value('cityid', ''), 'style="width: 100%;" class="select2" id="cityid"');?>
				</div>
				<div class="col-xs-6 item">
					<div class="text">Quận/ huyện</div>
					<select name="districtid" id="districtid" style="width:100%;">
						<option value="0">--Chọn Quận/huyện--</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button save" name="save" value="">Lưu</button>
			</div>
		</div>

	  </div>
	</form>
</div>
<script type="text/javascript">
	$('document').ready(function(){
		$('#infor').submit(function(){
			$('.save').html('<i class="fa fa-cog fa-spin fa-fw"></i>');
			var postData = $(this).serializeArray();
			var formURL = 'products/ajax/cart/save';
			$.post(formURL, {
				post: postData,}, 
				function(data){
					$('.save').html('Lưu');
					location.reload();
				});
			return false;
		});
		
		
		/* ------------ */
		$('#cityid').change(function(){
			var city_id = $('#cityid').val();
				$.post('<?php echo site_url('products/ajax/cart/ajax_location')?>', {
					cityid: city_id, 
					}, 
					function(data){
						var json = JSON.parse(data);
						$('#districtid').html(json.option);
						$('#districtid').val(<?php echo $payment['districtid']; ?>);
					});
			return false;
		});
		$('#cityid').val(<?php echo $payment['cityid']; ?>).trigger('change');
	});
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
		 document.body.innerHTML = printContents;
		 window.print();
		 document.body.innerHTML = originalContents;
	}
</script>
