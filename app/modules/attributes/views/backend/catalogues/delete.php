<section class="content-header">
	<h1>Xóa Danh mục thuộc tính</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('articles/backend/catalogues/view');?>">Danh mục thuộc tính</a></li>
		<li class="active"><a href="<?php echo site_url('articles/backend/catalogues/delete/'.$DetailAttributesCatalogues['id']);?>">Xóa Danh mục thuộc tính</a></li>
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
								<i class="fa fa-envelope"></i> #<?php echo $DetailAttributesCatalogues['id'];?>
								<small class="pull-right">Ngày tạo: <?php echo gettime($DetailAttributesCatalogues['created']);?></small>
							</h2>
						</div><!-- /.col -->
					</div>
					<div class="row invoice-info">
						<div class="col-sm-4 invoice-col">
							<b>Danh mục thuộc tính</b><br>
							<br>
							<address>
							<strong><?php echo $DetailAttributesCatalogues['title'];?></strong><br>
							</address>
						</div><!-- /.col -->
						<div class="col-sm-8 invoice-col">
							<b>Thông tin</b><br>
							<br>
							<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailAttributesCatalogues['publish']);?><br>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-xs-12">
							<p class="lead">Mô tả:</p>
							<div class="text-muted well well-sm no-shadow">
							<?php echo $DetailAttributesCatalogues['description'];?>
							</div>
						</div><!-- /.col -->
					</div><!-- /.row -->
					<div class="row">
						<div class="box-footer">
						<div class="callout callout-warning">
							<p>Khi bạn xóa bỏ Danh mục thuộc tính, đồng nghĩa việc xóa bỏ toàn bộ thuộc tính thuộc nhóm này.</p>
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