<div class="uk-margin-bottom uk-margin-right fc-border-bottom-1 fb-breadcrumb">
	<ul class="uk-breadcrumb">
		<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<a href="<?php echo base_url();?>" title="Trang chủ" itemprop="url" rel="nofollow">
				<span itemprop="title">Trang chủ</span>
			</a>
		</li>
		<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<h1><a href="<?php echo site_url('recovery');?>" title="Quên mật khẩu" itemprop="url">
				<span itemprop="title">Quên mật khẩu</span>
			</a></h1>
		</li>
	</ul>
</div>
<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
<p class="login-box-msg">Nhập vào Email của bạn để hệ thống xác nhận</p>
<form class="uk-form uk-form-horizontal" method="post" action="">
	<div class="uk-form-row">
		<label class="uk-form-label">Email</label>
		<div class="uk-form-controls">
			<?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email"');?>
		</div>
	</div>
	<div class="uk-form-row">
		<label class="uk-form-label">Thao tác</label>
		<div class="uk-form-controls">
			<button type="submit" name="recovery" value="recovery" class="uk-button">Xác nhận</button>
		</div>
	</div>
	<div class="uk-form-row">
		<label class="uk-form-label"></label>
		<div class="uk-form-controls">
			<a href="<?php echo site_url('login');?>" title="Đăng nhập">Đăng nhập</a>
		</div>
	</div>
</form>