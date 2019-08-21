<section class="content-header">
	<h1>cập nhật modules mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('functions/backend/functions/view');?>">modules</a></li>
		<li class="active"><a href="<?php echo site_url('functions/backend/functions/create');?>">Cập nhật modules mới</a></li>
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
									<label class="col-sm-2 control-label">Modules</label>
									<div class="col-sm-4">
										<?php echo form_input('title', set_value('title', $DetailFunctions['title']), 'class="form-control" placeholder="Tiêu đề"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Từ khóa</label>
									<div class="col-sm-4">
										<?php echo form_input('keyword', set_value('keyword', $DetailFunctions['keyword']), 'class="form-control" placeholder="Từ khóa"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailFunctions['publish']), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->