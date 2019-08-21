<div class="uk-margin-bottom uk-margin-right fc-border-bottom-1 fb-breadcrumb">
	<ul class="uk-breadcrumb">
		<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<a href="<?php echo base_url();?>" title="Trang chủ" itemprop="url" rel="nofollow">
				<span itemprop="title">Trang chủ</span>
			</a>
		</li>
		<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<h1><a href="<?php echo site_url('register');?>" title="Đăng ký" itemprop="url">
				<span itemprop="title">Đăng ký</span>
			</a></h1>
		</li>
	</ul>
</div>
<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
<form class="uk-form uk-form-horizontal" method="post" action="">
	<div class="uk-form-row">
		<label class="uk-form-label">Email</label>
		<div class="uk-form-controls">
			<?php echo form_input('email', set_value('email'), 'placeholder="Email"');?>
		</div>
	</div>
	<div class="uk-form-row">
		<label class="uk-form-label">Mật khẩu</label>
		<div class="uk-form-controls">
			<?php echo form_password('password', set_value('password'), 'placeholder="Mật khẩu"');?>
		</div>
	</div>
	<div class="uk-form-row">
		<label class="uk-form-label">Tên đầy đủ</label>
		<div class="uk-form-controls">
			<?php echo form_input('fullname', set_value('fullname'), 'placeholder="Tên đầy đủ"');?>
		</div>
	</div>
	<!--
	<div class="uk-form-row">
		<label class="uk-form-label">Địa chỉ</label>
		<div class="uk-form-controls">
			<?php echo form_input('address', set_value('address'), 'placeholder="Địa chỉ"');?>
		</div>
	</div>
	<div class="uk-form-row">
		<label class="uk-form-label">Số điện thoại</label>
		<div class="uk-form-controls">
			<?php echo form_input('phone', set_value('phone'), 'placeholder="Số điện thoại"');?>
		</div>
	</div>
	-->
	<div class="uk-form-row">
		<label class="uk-form-label">Thao tác</label>
		<div class="uk-form-controls">
			<button type="submit" name="register" value="register" class="uk-button">Đăng ký</button>
		</div>
	</div>
</form>