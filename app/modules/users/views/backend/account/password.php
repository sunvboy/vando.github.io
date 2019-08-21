<section class="content-header">
	<h1>Thay đổi mật khẩu</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('users/backend/account/password');?>">Thay đổi mật khẩu</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li><a href="<?php echo site_url('users/backend/account/information');?>">Thông tin cơ bản</a></li>
					<li class="active"><a href="<?php echo site_url('users/backend/account/password');?>">Thay đổi mật khẩu</a></li>
				</ul>
				<form class="form-horizontal" method="post" action="">
					<div class="tab-content">
						<div class="box-body">
							<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
						</div><!-- /.box-body -->
						<?php echo show_flashdata();?>
						<div class="tab-pane active">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Mật khẩu mới</label>
									<div class="col-sm-4">
										<?php echo form_input('newpassword', set_value('newpassword'), 'class="form-control" placeholder=""');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Xác nhận mật khẩu mới</label>
									<div class="col-sm-4">
										<?php echo form_input('renewpassword', set_value('renewpassword'), 'class="form-control" placeholder=""');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="update" value="update" class="btn btn-info pull-right">Cập nhật</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->