<div class="login-box">
	<div class="login-logo">
		<a href="../../index2.html"><b>Final</b>CMS</a>
	</div><!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Nhập vào Email của bạn để hệ thống xác nhận</p>
		<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
		<form method="post" action="">
			<div class="form-group has-feedback">
				<?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email"');?>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" name="recovery" value="recovery" class="btn btn-primary btn-block btn-flat">Xác nhận</button>
				</div><!-- /.col -->
			</div>
		</form>
		<div>
		<div class="social-auth-links text-center" style="display:none;">
			<p>- OR -</p>
			<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
			<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
		</div><!-- /.social-auth-links -->
		<a href="<?php echo site_url(BACKEND_DIRECTORY.'/login');?>">Đăng nhập</a><br>
		</div>
	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->