<section class="index-navigation margin-bottom-25px">
	<div class="uk-container uk-container-center">
		<div class="fc-breadcrumb uk-margin-bottom uk-margin-top">
			<ul class="uk-breadcrumb uk-margin-remove">
				<li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
				<li><a href="<?php echo base_url(); ?>">Thông tin tài khoản</a></li>
			</ul>
		</div><!-- .fc-breadcrumb -->
		
		<div class="uk-grid">
			<?php echo $this->load->view('homepage/frontend/common/user_aside'); ?>
			<div class="uk-width-large-4-5 uk-width-medium-2-3 uk-width-small-1-1 user-content">	
			<div class="uk-panel">
				<div class="uk-panel-title">Thông tin tài khoản</div>
				<div class="uk-panel-body">
					<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
					<form class="uk-form uk-form-horizontal" method="post" action="">
						<div class="uk-form-row">
							<label class="uk-form-label">Tên đầy đủ</label>
							<div class="uk-form-controls">
								<?php echo form_input('fullname', set_value('fullname', $DetailUsers['fullname']), 'class="form-control" placeholder="Tên đầy đủ"');?>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Email</label>
							<div class="uk-form-controls">
								<?php echo form_hidden('old_email', $DetailUsers['email']);?>
								<?php echo form_input('email', set_value('email', $DetailUsers['email']), 'class="form-control" disabled placeholder="Email"');?>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Số điện thoại</label>
							<div class="uk-form-controls">
								<?php echo form_input('phone', set_value('phone', $DetailUsers['phone']), 'placeholder="Số điện thoại"');?>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Địa chỉ</label>
							<div class="uk-form-controls">
								<?php echo form_input('address', set_value('address', $DetailUsers['address']), 'placeholder="Địa chỉ"');?>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Thao tác</label>
							<div class="uk-form-controls">
								<input type="submit" name="update" value="Lưu thông tin" />
							</div>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div><!--.grid -->
		
		
	</div><!-- .uk-container -->
</section><!-- .index-navigation -->





















