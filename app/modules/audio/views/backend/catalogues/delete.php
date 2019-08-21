<section class="content-header">
	<h1>Xóa Danh mục audio</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('audio/backend/catalogues/view');?>">Danh mục audio</a></li>
		<li class="active"><a href="<?php echo site_url('audio/backend/catalogues/delete/'.$DetailAudioCatalogues['id']);?>">Xóa Danh mục audio</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form method="post" action="">
			<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
				<section class="invoice">
					<div class="row">
						<div class="col-xs-12">
							<h2 class="page-header">
								<i class="fa fa-envelope"></i> #<?php echo $DetailAudioCatalogues['id'];?>
								<small class="pull-right">Ngày tạo: <?php echo gettime($DetailAudioCatalogues['created']);?></small>
							</h2>
						</div><!-- /.col -->
					</div>
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">
							<b>Danh mục audio</b><br>
							<br>
							<address>
							<strong><?php echo $DetailAudioCatalogues['title'];?></strong><br>
							<input type="hidden" value="<?php echo $DetailAudioCatalogues['id'] ?>" name="cataloguesid" />
							</address>
						</div><!-- /.col -->
						<div class="col-sm-8 invoice-col">
							<b>Thông tin</b><br>
							<br>
							<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailAudioCatalogues['publish']);?><br>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-xs-12">
							<p class="lead">Mô tả:</p>
							<div class="text-muted well well-sm no-shadow">
							<?php echo $DetailAudioCatalogues['description'];?>
							</div>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="box-footer">
						<div class="callout callout-warning">
							<p>Khi bạn xóa bỏ Danh mục audio, đồng nghĩa với việc xóa bỏ toàn bộ audio thuộc nhóm này.</p>
						</div>
							<button type="reset" class="btn btn-default">Làm lại</button>
							<button type="submit" name="delete" value="action" class="btn btn-info pull-right">Xóa bỏ</button>
						</div><!-- /.box-footer -->
					</div>
				</section><!-- /.content -->
			</form>
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->