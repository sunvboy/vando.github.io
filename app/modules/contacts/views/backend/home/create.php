<section class="content-header">
	<h1>Thêm liên hệ mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('contacts/backend/home/view');?>">Liên hệ</a></li>
		<li class="active"><a href="<?php echo site_url('contacts/backend/home/create');?>">Thêm liên hệ mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
					<li><a href="#tab-advanced" data-toggle="tab">Nâng cao</a></li>
				</ul>
				<form class="form-horizontal" method="post" action="">
					<div class="tab-content">
						<div class="box-body">
							<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
						</div><!-- /.box-body -->
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Tên đầy đủ</label>
									<div class="col-sm-4">
										<?php echo form_input('fullname', set_value('fullname'), 'class="form-control" placeholder="Tên đầy đủ"');?>
									</div>
									<label class="col-sm-1 control-label">Email</label>
									<div class="col-sm-5">
										<?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Điện thoại</label>
									<div class="col-sm-4">
										<?php echo form_input('phone', set_value('phone'), 'class="form-control" placeholder="Điện thoại"');?>
									</div>
									<label class="col-sm-1 control-label">Nơi nhận</label>
									<div class="col-sm-5">
										<?php echo form_dropdown('receiverid', $this->BackendContactsReceiver_Model->dropdown(), set_value('receiverid'), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Địa chỉ</label>
									<div class="col-sm-10">
										<?php echo form_input('address', set_value('address'), 'class="form-control" placeholder="Địa chỉ"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nội dung</label>
									<div class="col-sm-10">
										<?php echo form_textarea('message', htmlspecialchars_decode(set_value('message')), 'class="textarea" placeholder="Nội dung" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control select2" style="width: 100%;"');?>
									</div>
									<label class="col-sm-1 control-label">Tình trạng</label>
									<div class="col-sm-3">
										<?php echo form_dropdown('process', $this->configbie->data('process'), set_value('process'), 'class="form-control select2" style="width: 100%;"');?>
									</div>
									<label class="col-sm-1 control-label">Mức độ</label>
									<div class="col-sm-3">
										<?php echo form_dropdown('level', $this->configbie->data('level'), set_value('level'), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Ghi chú</label>
									<div class="col-sm-10">
										<?php echo form_textarea('notes', set_value('notes'), 'class="form-control" rows="3" placeholder="Ghi chú"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="create" value="action" class="btn btn-info pull-right">Thêm mới</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->