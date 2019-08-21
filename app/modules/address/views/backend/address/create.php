<section class="content-header">
	<h1>Thêm liên Files download</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('address/backend/address/view');?>">Files download</a></li>
		<li class="active"><a href="<?php echo site_url('address/backend/address/create');?>">Thêm mới</a></li>
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
										<?php echo form_input('title', set_value('title'), 'class="form-control" placeholder="Tiêu đề"');?>
									</div>
									<label class="col-sm-1 control-label">Xuất bản</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Kích thước files</label>
									<div class="col-sm-4">
										<?php echo form_input('size', set_value('size'), 'class="form-control" placeholder="Kích thước files"');?>
									</div>
									<label class="col-sm-1 control-label">Loại Files</label>
									<div class="col-sm-4">
										<?php echo form_input('type', set_value('type'), 'class="form-control" placeholder="Loại Files"'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nội dung</label>
									<div class="col-sm-10">
										<?php echo form_textarea('attachs', set_value('attachs'), 'class="form-control" placeholder="Nội dung mô tả ngắn" onclick="openKCFinder(this, files)"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<input type="hidden" name="typeoff" value="0">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="create" value="action" class="btn btn-info pull-right">Thêm mới</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->