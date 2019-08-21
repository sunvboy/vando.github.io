<section class="content-header">
	<h1>Thêm chứng chỉ</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('address/backend/hedaotao/view');?>">Chứng chỉ</a></li>
		<li class="active"><a href="<?php echo site_url('address/backend/hedaotao/create');?>">Thêm chứng chỉ</a></li>
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
									<label class="col-sm-2 control-label">Tiêu đề</label>
									<div class="col-sm-4">
										<?php echo form_input('title', set_value('title'), 'class="form-control" placeholder="Hệ đào tạo"');?>
									</div>
									<label class="col-sm-1 control-label">Xuất bản</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Kích thước</label>
									<div class="col-sm-4">
										<?php echo form_input('size', set_value('size'), 'class="form-control" placeholder="Kích thước"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Links liên kết</label>
									<div class="col-sm-4">
										<?php echo form_input('type', set_value('type'), 'class="form-control" placeholder="Links liên kết"');?>
									</div>
									<label class="col-sm-1 control-label">Hình ảnh</label>
									<div class="col-sm-4">
										<?php echo form_input('attachs', set_value('attachs'), 'class="form-control" placeholder="Hình ảnh" onclick="openKCFinder(this)"'); ?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<input type="hidden" name="typeoff" value="1">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="create" value="action" class="btn btn-info pull-right">Thêm mới</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->