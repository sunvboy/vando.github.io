<section class="content-header">
	<h1>Thêm danh mục bài viết mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('articles/backend/catalogues/view');?>">Danh mục bài viết</a></li>
		<li class="active"><a href="<?php echo site_url('articles/backend/catalogues/create');?>">Thêm danh mục bài viết mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form class="form-horizontal" method="post" action="">
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
					</ul>
					
						<div class="tab-content">
							<div class="box-body">
								<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
							</div><!-- /.box-body -->
							<div class="tab-pane active" id="tab-info">
								<div class="box-body">
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Tiêu đề</label>
										<div class="col-sm-8">
											<?php echo form_input('title', set_value('title', $DetailArticlesCatalogues['title']), 'class="form-control form-static-link" placeholder="Tiêu đề"');?>
										</div>
										<div class="col-sm-2"><span class="btn btn-primary create-static-links" data-module="articles" data-controller="catalogues">Tạo liên kết tĩnh</span></div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Liên kết</label>
										<label class="col-sm-3 control-label tp-text-left"><?php echo base_url(); ?></label>
										<div class="col-sm-5">
											<?php echo form_input('canonical', set_value('canonical', $DetailArticlesCatalogues['canonical']), 'class="form-control canonical" placeholder="Liên kết"');?>
											<?php echo form_hidden('canonical_original', $DetailArticlesCatalogues['canonical']);?>
										</div>

										<div class="col-sm-2" style="line-height: 34px;font-weight: 600;">.html</div>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
						<div class="box-footer">
							<button type="reset" class="btn btn-default">Làm lại</button>
							<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
						</div><!-- /.box-footer -->
					
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
			<div class="col-md-3">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Nâng cao</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-seo">
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Xuất bản</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailArticlesCatalogues['publish']), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Trang chủ</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('ishome', $this->configbie->data('ishome'), set_value('ishome', $DetailArticlesCatalogues['ishome']), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>
						</div>
					</div><!-- /.tab-pane -->
				</div><!-- /.tab-content -->
			</div><!-- nav-tabs-custom -->
		</form>
	</div> <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
</script>