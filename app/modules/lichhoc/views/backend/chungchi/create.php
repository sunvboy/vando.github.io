<section class="content-header">
	<h1>Thêm bản ghi mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('lichhoc/backend/chungchi/view');?>">Chúng chỉ</a></li>
		<li class="active"><a href="<?php echo site_url('lichhoc/backend/chungchi/create');?>">Thêm bản ghi mới</a></li>
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
										<label class="col-sm-2 control-label tp-text-left">Họ và tên</label>
										<div class="col-sm-8">
											<?php echo form_input('fullname', set_value('fullname'), 'class="form-control form-static-link" placeholder="Họ và tên học viên"');?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Email</label>
										<div class="col-sm-10">
											<?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email học viên"');?>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Chi tiết</label>
										<div class="col-sm-10">
											<?php echo form_textarea('detail', set_value('detail'), 'class="form-control" placeholder="Chi tiết thêm" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Tiêu chuẩn</label>
										<div class="col-sm-10">
											<?php echo form_input('standard', set_value('standard'), 'class="form-control" placeholder="Tiêu chuẩn (Standard)"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Tư thế ktra</label>
										<div class="col-sm-10">
											<?php echo form_input('position', set_value('position'), 'class="form-control" placeholder="Tư thế kiểm tra (Position)"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Quá trình hàn</label>
										<div class="col-sm-10">
											<?php echo form_input('process', set_value('process'), 'class="form-control" placeholder="Quá trình hàn (Process)"');?>
										</div>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
						<div class="box-footer">
							<button type="reset" class="btn btn-default">Làm lại</button>
							<button type="submit" name="create" value="action" class="btn btn-info pull-right">Thêm mới</button>
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
									<label class="col-sm-12 control-label tp-text-left">Mã chứng chỉ</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('type', set_value('type'), 'class="form-control" placeholder="Mã chứng chỉ"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Ngày dự thi</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('datethi', set_value('datethi'), 'class="form-control datetimepicker" placeholder="Ngày dự thi" readonly');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Ngày hết hạn</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('datehet', set_value('datehet'), 'class="form-control datetimepicker" placeholder="Ngày hết hạn" readonly');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Ảnh chứng chỉ</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (isset($avatar) && !empty($avatar))?$avatar: 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;" /></div>
										<?php echo form_input('images', set_value('images'), 'class="form-control"  placeholder="Ảnh đại diện" onclick="openKCFinder(this)" ');?>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
							</div>
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
		</form>
	</div> <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
</script>