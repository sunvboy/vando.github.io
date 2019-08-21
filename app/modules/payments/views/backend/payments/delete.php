<section class="content-header">
	<h1>Xóa đơn hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('payments/backend/payments/view');?>">đơn hàng</a></li>
		<li class="active"><a href="<?php echo site_url('payments/backend/payments/delete/'.$DetailPayments['id']);?>">Xóa đơn hàng</a></li>
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
								<i class="fa fa-envelope"></i> #<?php echo $DetailPayments['id'];?>
								<small class="pull-right">Ngày tạo: <?php echo gettime($DetailPayments['created']);?></small>
							</h2>
						</div><!-- /.col -->
					</div>
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">
							<b>đơn hàng</b><br>
							<br>
							<address>
							<strong><?php echo $DetailPayments['fullname'];?></strong><br>
							</address>
						</div><!-- /.col -->
						<div class="col-sm-8 invoice-col">
							<b>Thông tin</b><br>
							<br>
							<b>Trình trạng:</b> <?php echo $this->configbie->data('status', $DetailPayments['status']);?><br>
							<br>
							<b>Trạng thái:</b> <?php echo $this->configbie->data('send', $DetailPayments['send']);?><br>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-xs-12">
						<?php 
							$_product_ = json_decode($DetailPayments['data'], TRUE);
						?>
							<p class="lead">Mô tả:</p>
							<div class="text-muted well well-sm no-shadow">
							<?php if(isset($_product_) && is_array($_product_) && count($_product_)){ ?>
							<?php foreach($_product_ as $key => $val){ ?>
							<?php 
								$title = $val['detail']['title'];
								$href = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products');
								
								$price = number_format($val['price']);
							?>
								<div class="item" style="margin-bottom:20px;">
									<span style="margin-right:10px;"><strong>Tên sản phẩm: </strong> <a href="<?php echo $href; ?>" target="_blank" title=""><?php echo $title; ?> </a></span>
									<span style="margin-right:10px;"><strong>Số lượng: </strong> <?php echo $val['qty']; ?></span>
									<span style="margin-right:10px;"><strong>Đơn giá: </strong> <?php echo $price; ?></span>
								</div>
							<?php }} ?>
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