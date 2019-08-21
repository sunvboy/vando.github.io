<section class="content-header">
	<h1>Xóa khách hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('customers/backend/payment/view');?>">khách hàng</a></li>
		<li class="active"><a href="<?php echo site_url('customers/backend/payment/delete/'.$DetailPayment['id']);?>">Xóa khách hàng</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form method="post" action="">
				<section class="invoice">
					<div class="row">
						<div class="col-xs-12">
							<h2 class="page-header">
								<i class="fa fa-envelope"></i> #<?php echo $DetailPayment['id'];?>
								<small class="pull-right">Ngày tạo: <?php echo gettime($DetailPayment['created']);?></small>
							</h2>
						</div><!-- /.col -->
					</div>
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">
							<b>khách hàng</b><br>
							<br>
							<address>
							<strong><?php echo $DetailPayment['fullname'];?></strong><br>
							</address>
						</div><!-- /.col -->
						<div class="col-sm-8 invoice-col">
							<b>Thông tin</b> <br>
							<?php echo $this->configbie->data('method')[$DetailPayment['trash']]; ?>, Số tiền: <?php echo $DetailPayment['money'];?>
							<?php echo (($DetailPayment['customer_name'] != '') ? ', Người nhận: '.$DetailPayment['customer_name'].'' : '') ?>
							<br>

							<b>Xuất bản:</b> <?php echo $this->configbie->data('status', $DetailPayment['status']);?><br>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-xs-12">
							<p class="lead">Ghi chú:</p>
							<div class="text-muted well well-sm no-shadow">
							<?php echo $DetailPayment['message'];?>
							</div>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="box-footer">
							<button type="reset" class="btn btn-default">Làm lại</button>
							<button type="submit" name="delete" value="action" class="btn btn-info pull-right">Xóa bỏ</button>
						</div><!-- /.box-footer -->
					</div>
				</section><!-- /.content -->
			</form>
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->