<section class="content-header">
	<h1>Cập nhật hỗ trợ trực tuyến</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('supports/backend/supports/view');?>">hỗ trợ trực tuyến</a></li>
		<li class="active"><a href="<?php echo site_url('supports/backend/supports/update/'.$DetailSupports['id']);?>">Cập nhật hỗ trợ trực tuyến</a></li>
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
										<?php echo form_input('fullname', set_value('fullname', $DetailSupports['fullname']), 'class="form-control" placeholder="Tên đầy đủ"');?>
									</div>
									<label class="col-sm-1 control-label">Nơi nhận</label>
									<div class="col-sm-5">
										<?php echo form_dropdown('cataloguesid', $this->BackendSupportsCatalogues_Model->dropdown(), set_value('cataloguesid', $DetailSupports['cataloguesid']), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-1 control-label">Zalo</label>
									<div class="col-sm-5">
										<?php echo form_input('zalo', set_value('zalo', $DetailSupports['zalo']), 'class="form-control" placeholder="Zalo"');?>
									</div>
									<label class="col-sm-1 control-label">Email</label>
									<div class="col-sm-5">
										<?php echo form_input('email', set_value('email', $DetailSupports['email']), 'class="form-control" placeholder="Email"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Skype</label>
									<div class="col-sm-4">
										<?php echo form_input('skype', set_value('skype', $DetailSupports['skype']), 'class="form-control" placeholder="Skype"');?>
									</div>
									<label class="col-sm-2 control-label">Điện thoại</label>
									<div class="col-sm-4">
										<?php echo form_input('yahoo', set_value('yahoo', $DetailSupports['yahoo']), 'class="form-control" placeholder="Yahoo"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Facebook</label>
									<div class="col-sm-4">
										<?php echo form_input('facebook', set_value('facebook', $DetailSupports['facebook']), 'class="form-control" placeholder="facebook"');?>
									</div>
									<label class="col-sm-1 control-label">Điện thoại</label>
									<div class="col-sm-5">
										<?php echo form_input('phone', set_value('phone', $DetailSupports['phone']), 'class="form-control" placeholder="Điện thoại"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Pinterest</label>
									<div class="col-sm-4">
										<?php echo form_input('pinterest', set_value('pinterest', $DetailSupports['pinterest']), 'class="form-control" placeholder="pinterest"');?>
									</div>
									<label class="col-sm-1 control-label">Viber</label>
									<div class="col-sm-5">
										<?php echo form_input('viber', set_value('viber', $DetailSupports['viber']), 'class="form-control" placeholder="Viber"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailSupports['publish']), 'class="form-control select2" style="width: 100%;"');?>
									</div>
									<label class="col-sm-1 control-label">Hình ảnh</label>
									<div class="col-sm-5">
										<?php echo form_input('images', set_value('images', $DetailSupports['images']), 'class="form-control" placeholder="Ảnh đại diện" onclick="openKCFinder(this)"');?>
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