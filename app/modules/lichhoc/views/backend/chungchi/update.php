<section class="content-header">
	<h1>Thêm bản ghi mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('lichhoc/backend/chungchi/view');?>">CV-tuyển dụng</a></li>
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
									<label class="col-sm-2 control-label tp-text-left">Vị trí ứng tuyển</label>
									<div class="col-sm-8">
										<?php echo form_input('title', set_value('title', $chungchi['title']), 'class="form-control" placeholder="Vị trí ứng tuyển"'); ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Địa điểm làm việc</label>
									<div class="col-sm-10">
										<?php echo form_dropdown('cityid', location_dropdown('Thành phố', array('parentid' => 0)), set_value('cityid', $chungchi['cityid']), 'class="form-control"'); ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Trình độ học vấn</label>
									<div class="col-sm-10">
										<?php echo form_dropdown('degree', $this->configbie->data('degree'), set_value('degree', $chungchi['degree']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Hình thức làm việc</label>
									<div class="col-sm-10">
										<?php echo form_dropdown('form', $this->configbie->data('form'), set_value('form', $chungchi['form']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Mức lương</label>
									<div class="col-sm-10">
										<?php echo form_input('money', set_value('money', $chungchi['money']), 'class="form-control" placeholder="Mức lương mong muốn"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Định hướng nghề</label>
									<div class="col-sm-10">
										<?php echo form_textarea('content', set_value('content', $chungchi['content']), 'class="form-control" placeholder="Định hướng nghề nghiệp" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
								
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
					</div><!-- /.box-footer -->
				
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
			<div class="col-md-3">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin ứng viên</a></li>
					</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab-seo">
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Họ tên ứng viên</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('fullname', set_value('fullname', $chungchi['fullname']), 'class="form-control" placeholder="Họ tên ứng viên"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Số điện thoại</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('phone', set_value('phone', $chungchi['phone']), 'class="form-control datetimepicker" placeholder="Số điện thoại"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Email</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('email', set_value('email', $chungchi['email']), 'class="form-control datetimepicker" placeholder="Email" ');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Bằng cấp/Chứng chỉ</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('type', set_value('type', $chungchi['type']), 'class="form-control datetimepicker" placeholder="Bằng cấp/Chứng chỉ" ');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Trường/Đơn vị đào tạo</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('school', set_value('type', $chungchi['school']), 'class="form-control datetimepicker" placeholder="Trường/Đơn vị đào tạo" ');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Loại tốt nghiệp</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('classify', $this->configbie->data('classify'), set_value('classify', $chungchi['classify']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Ngày ứng tuyển</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('created', set_value('created', $chungchi['created']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Trạng thái</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $chungchi['publish']), 'class="form-control" style="width: 100%;"');?>
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