<section class="content-header">
	<h1>Xóa Danh mục hình ảnh</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('gallerys/backend/catalogues/view');?>">Danh mục hình ảnh</a></li>
		<li class="active"><a href="<?php echo site_url('gallerys/backend/catalogues/delete/'.$DetailArticlesCatalogues['id']);?>">Xóa Danh mục bài viết</a></li>
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
								<i class="fa fa-envelope"></i> #<?php echo $DetailArticlesCatalogues['id'];?>
								<small class="pull-right">Ngày tạo: <?php echo gettime($DetailArticlesCatalogues['created']);?></small>
							</h2>
						</div><!-- /.col -->
					</div>
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">
							<b>Danh mục hình ảnh</b><br>
							<br>
							<address>
							<strong><?php echo $DetailArticlesCatalogues['title'];?></strong><br>
							<input type="hidden" value="<?php echo $DetailArticlesCatalogues['id'] ?>" name="cataloguesid" />
							</address>
						</div><!-- /.col -->
						<div class="col-sm-8 invoice-col">
							<b>Thông tin</b><br>
							<br>
							<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailArticlesCatalogues['publish']);?><br>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-xs-12">
							<p class="lead">Mô tả:</p>
							<div class="text-muted well well-sm no-shadow">
							<?php echo $DetailArticlesCatalogues['description'];?>
							</div>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="box-footer">
						<div class="callout callout-warning">
							<p>Khi bạn xóa bỏ Danh mục hình ảnh, đồng nghĩa với việc xóa bỏ toàn bộ Hình ảnh thuộc danh mục này.</p>
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