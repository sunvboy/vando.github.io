<section class="content-header">
	<h1>Xóa liên hệ</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('contacts/backend/home/view');?>">Liên hệ</a></li>
		<li class="active"><a href="<?php echo site_url('contacts/backend/home/delete/'.$detailContact['id']);?>">Xóa liên hệ</a></li>
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
								<i class="fa fa-envelope"></i> #<?php echo $detailContact['receiverid'];?>
								<small class="pull-right">Ngày gửi: <?php echo show_time($detailContact['created']);?></small>
							</h2>
						</div><!-- /.col -->
					</div>
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">
							<b>Người gửi</b><br>
							<br>
							<address>
							<strong><?php echo $detailContact['fullname'];?></strong><br>
							<?php echo $detailContact['address'];?><br>
							Điện thoại: <?php echo $detailContact['phone'];?><br>
							Email: <?php echo $detailContact['email'];?>
							</address>
						</div><!-- /.col -->
						<div class="col-sm-4 invoice-col">
							<b>Thông tin</b><br>
							<br>
							<b>Mức độ:</b> <?php echo $this->configbie->data('level', $detailContact['level']);?><br>
							<b>Tình trạng:</b> <?php echo $this->configbie->data('process', $detailContact['process']);?><br>
							<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $detailContact['publish']);?><br>
							<b>Trạng thái:</b> <?php echo ($detailContact['viewed'] == 1)?'Đã đọc':'Chưa đọc';?>
						</div><!-- /.col -->
						<div class="col-sm-4 invoice-col">
							<b>Nơi gửi</b><br>
							<br>
							<address>
							<strong><?php echo $detailContact['receiver_name'];?></strong><br>
							</address>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-xs-8">
							<p class="lead">Nội dung:</p>
							<div class="text-muted well well-sm no-shadow">
							<?php echo $detailContact['message'];?>
							</div>
						</div><!-- /.col -->
						<div class="col-xs-4">
							<p class="lead">Ghi chú:</p>						
							<?php echo !empty($detailContact['notes'])?$detailContact['notes']:'-';?>
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