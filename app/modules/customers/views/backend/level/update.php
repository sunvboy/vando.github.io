<section class="content-header">
	<h1>Cấp độ</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('customers/backend/level/view');?>">Level khách hàng</a></li>
		<li class="active">Chỉnh sửa cấp độ</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
				</ul>
				<form class="form-horizontal" method="post" action="">
					<div class="tab-content">
						<div class="box-body">
							<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
						</div><!-- /.box-body -->
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Tên cấp độ</label>
									<div class="col-sm-4">
										<?php echo form_input('title', set_value('title', $DetailLevel['title']), 'class="form-control" placeholder="Tên cấp độ"');?>
									</div>
									<label class="col-sm-1 control-label">Giảm giá %</label>
									<div class="col-sm-5">
										<?php echo form_input('discounted', set_value('discounted', $DetailLevel['discounted']), 'class="form-control" placeholder="Giảm giá % áp dụng cho mức này"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Giới hạn tiền</label>
									<div class="col-sm-4">
										<?php echo form_input('range_price', set_value('range_price', $DetailLevel['range_price']), 'class="form-control price" placeholder="Giới hạn tiền thăng cấp"');?>
									</div>
									<label class="col-sm-1 control-label">Xuất bản</label>
									<div class="col-sm-5">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailLevel['publish']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
	$(document).ready(function(){
		var time;
		$('.price').on('keyup', function(event) {
			var price = $(this).val();
			var _this = $(this);
			var url = 'products' +'/ajax/'+ 'products' + '/convert_commas_price';
			clearTimeout(time);
			time = setTimeout(function() {
				$.post(url, {price: price}, function(data){
					_this.val(data);
				});
			}, 300);
		});
	});
</script>