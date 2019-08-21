<section class="content-header">
	<h1>Xóa combo</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('combos/backend/combos/view');?>">combo</a></li>
		<li class="active"><a href="<?php echo site_url('combos/backend/combos/delete/'.$DetailCombos['id']);?>">Xóa combo</a></li>
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
								<i class="fa fa-envelope"></i> #
								<small class="pull-right">Ngày gửi: <?php echo show_time($DetailCombos['created']);?></small>
							</h2>
						</div><!-- /.col -->
					</div>
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">
							<b>Người gửi</b><br>
							<br>
							<address>
							<strong><?php echo $DetailCombos['title'];?></strong><br>
							</address>
						</div><!-- /.col -->
						<div class="col-sm-4 invoice-col">
							<b>Thông tin</b><br>
							
							<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailCombos['publish']);?><br>
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