<div class="login-box">
	<div class="login-logo">
		<a href="http://thietkewebtamphat.com/"><b>TamPhat</b>Software</a>
	</div><!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc của bạn</p>
		<?php echo show_flashdata(FALSE);?>
		<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
		<form method="post" action="">
			<div class="form-group has-feedback">
				<?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email"');?>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<?php echo form_password('password', set_value('password'), 'class="form-control" placeholder="Mật khẩu"');?>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="form-group has-feedback">
						<select name="lang" id="lang" class="form-control">
							<option value="vietnamese" >Vietnamese</option>
							<!-- <option value="english">English</option> -->
						</select>
						<i class="fa fa-language form-control-feedback" aria-hidden="true"></i>
					</div>
					<div class="checkbox icheck" style="display:none;">
						<label>
							<?php echo form_checkbox('remember', '1');?> Ghi nhớ
						</label>
					</div>
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" name="login" value="login" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
				</div><!-- /.col -->
			</div>
		</form>
		<div>
		<div class="social-auth-links text-center" style="display:none;">
			<p>- OR -</p>
			<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
			<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
		</div><!-- /.social-auth-links -->
		<a href="<?php echo site_url(BACKEND_DIRECTORY.'/recovery');?>">Quên mật khẩu</a><br>
		</div>
	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->
<style>
	select
	{
	    -moz-appearance:none;
	    text-indent:0;
	    text-overflow:'';
	}
</style>