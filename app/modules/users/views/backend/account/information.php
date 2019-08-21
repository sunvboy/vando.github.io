<section class="content-header">
	<h1>Cập nhật hồ sơ</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('users/backend/account/information');?>">Cập nhật hồ sơ</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="<?php echo site_url('users/backend/account/information');?>">Thông tin cơ bản</a></li>
					<li><a href="<?php echo site_url('users/backend/account/password');?>">Thay đổi mật khẩu</a></li>
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
									<label class="col-sm-2 control-label">Tên đầy đủ</label>
									<div class="col-sm-10">
										<?php echo form_input('fullname', set_value('fullname', $DetailUsers['fullname']), 'class="form-control" placeholder="Tên đầy đủ"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Email</label>
									<div class="col-sm-10">
										<?php echo form_hidden('old_email', $DetailUsers['email']);?>
										<?php echo form_input('email', set_value('email', $DetailUsers['email']), 'class="form-control" placeholder="Email"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mô tả</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description', $DetailUsers['description'])), 'class="textarea" placeholder="Mô tả" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
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