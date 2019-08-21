<section class="index-navigation margin-bottom-25px">
	<div class="uk-container uk-container-center">
		<div class="fc-breadcrumb uk-margin-bottom uk-margin-top">
			<ul class="uk-breadcrumb uk-margin-remove">
				<li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
				<li><a href="password.html">Đổi mật khẩu</a></li>
			</ul>
		</div><!-- .fc-breadcrumb -->
		
		<div class="uk-grid">
			<?php echo $this->load->view('homepage/frontend/common/user_aside'); ?>
			<div class="uk-width-large-4-5 uk-width-medium-2-3 uk-width-small-1-1 user-content">	
			<div class="uk-panel">
				<div class="uk-panel-title">Đổi mật khẩu</div>
				<div class="uk-panel-body">
					<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
					<form class="uk-form uk-form-horizontal" method="post" action="">
						<div class="uk-form-row">
							<label class="uk-form-label">Mật khẩu mới</label>
							<div class="uk-form-controls">
								<?php echo form_password('newpassword', set_value('newpassword'), 'class="form-control" placeholder=""');?>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Xác nhận mật khẩu mới</label>
							<div class="uk-form-controls">
								<?php echo form_password('renewpassword', set_value('renewpassword'), 'class="form-control" placeholder=""');?>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Thao tác</label>
							<div class="uk-form-controls">
								<input type="submit" name="update" value="Lưu thông tin" class="uk-button">
							</div>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div><!--.grid -->
	</div><!-- .uk-container -->
</section><!-- .index-navigation -->

