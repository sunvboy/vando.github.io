<section class="content-header">
	<h1>Thêm mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('idea/backend/team/view');?>">Đội ngũ</a></li>
		<li class="active"><a href="<?php echo site_url('idea/backend/team/create');?>">Thêm mới</a></li>
	</ol>
</section>
<section class="content">
	<form class="form-horizontal" method="post" action="">
		<div class="row">
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
									<label class="col-sm-2 control-label">Tiêu đề</label>
									<div class="col-sm-10">
										<?php echo form_input('title', set_value('title'), 'class="form-control" placeholder="Tiêu đề"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Chức vụ</label>
									<div class="col-sm-10">
										<?php echo form_input('address', set_value('address'), 'class="form-control" placeholder="Chức vụ"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Links Facebook</label>
									<div class="col-sm-9">
										<?php echo form_input('content', set_value('content'), 'class="form-control" placeholder="Links Facebook"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<input type="hidden" name="type" value="1">
						<button type="submit" name="create" value="action" class="btn btn-info pull-right">Cập nhật</button>
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
								<label class="col-sm-12 control-label tp-text-left">Ảnh đại diện</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (isset($avatar) && !empty($avatar))?$avatar: 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;" /></div>
									<?php echo form_input('images', set_value('images'), 'class="form-control"  placeholder="Ảnh đại diện" onclick="openKCFinder(this)" ');?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Xuất bản</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish'), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.tab-pane -->
				</div><!-- /.tab-content -->
			</div><!-- nav-tabs-custom -->
		</div> <!-- /.row -->
	</form>
</section><!-- /.content -->
<script type="text/javascript">
	$(window).load(function(){
		$(document).on('click', '.img-thumbnail', function(){
			openKCFinderAlbum($(this));
		});
	});
</script>