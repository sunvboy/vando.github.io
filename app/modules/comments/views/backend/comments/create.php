<section class="content-header">
	<h1>Thêm hỗ trợ trực tuyến mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('supports/backend/supports/view');?>">hỗ trợ trực tuyến</a></li>
		<li class="active"><a href="<?php echo site_url('supports/backend/supports/create');?>">Thêm hỗ trợ trực tuyến mới</a></li>
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
									<label class="col-sm-1 control-label">Nơi nhận</label>
									<div class="col-sm-5">
										<?php echo form_dropdown('cataloguesid', $this->BackendSupportsCatalogues_Model->dropdown(), set_value('cataloguesid'), 'class="form-control select2" style="width: 100%;"');?>
									</div>
									
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Điện thoại</label>
									<div class="col-sm-4">
										<?php echo form_input('phone', set_value('phone'), 'class="form-control" placeholder="Điện thoại"');?>
									</div>
									<label class="col-sm-1 control-label">Email</label>
									<div class="col-sm-5">
										<?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Skype</label>
									<div class="col-sm-4">
										<?php echo form_input('skype', set_value('skype'), 'class="form-control" placeholder="Skype"');?>
									</div>
									<label class="col-sm-1 control-label">Zalo</label>
									<div class="col-sm-5">
										<?php echo form_input('zalo', set_value('zalo'), 'class="form-control" placeholder="Zalo"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Facebook</label>
									<div class="col-sm-4">
										<?php echo form_input('facebook', set_value('facebook'), 'class="form-control" placeholder="facebook"');?>
									</div>
									<label class="col-sm-1 control-label">Yahoo</label>
									<div class="col-sm-5">
										<?php echo form_input('yahoo', set_value('yahoo'), 'class="form-control" placeholder="yahoo"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Pinterest</label>
									<div class="col-sm-4">
										<?php echo form_input('pinterest', set_value('pinterest'), 'class="form-control" placeholder="pinterest"');?>
									</div>
									<label class="col-sm-1 control-label">Viber</label>
									<div class="col-sm-5">
										<?php echo form_input('viber', set_value('i'), 'class="form-control" placeholder="i"');?>
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