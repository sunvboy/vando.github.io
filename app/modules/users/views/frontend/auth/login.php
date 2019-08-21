<section class="index-navigation margin-bottom-25px">
	<div class="uk-container uk-container-center">
		<div class="fc-breadcrumb uk-margin-bottom uk-margin-top">
			<ul class="uk-breadcrumb uk-margin-remove">
				<li><a href="<?php echo base_url(); ?>" title="">Trang chủ</a></li>
				<li class="uk-active"><a href="login.html" title="">Đăng nhập - Đăng ký</a></li>
			</ul>
		</div><!-- .fc-breadcrumb -->

		<div class="uk-grid">
			<div class="uk-width-1-6"></div>
			<div class="uk-width-2-3">
				<div class="uk-panel log-panel margin-bottom-25px">
					<div class="fc-panel-body uk-panel-box">
					<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger uk-margin-bottom" style="background:#AB5858;padding:8px;color:#fff;">'.$error.'</div>':'';?>
						<form action="" method="post" class="uk-form">
							<div class="uk-grid uk-grid-collapse uk-grid-width-1-2 uk-position-relative">
								<div class="log login">
									<h5 class="header uk-text-center">ĐĂNG NHẬP</h5>
									
									
									<div class="body">
										<div class="uk-form-row"><label for="">Email</label><input type="text" name="email" id="" class="uk-width-1-1" value="<?php echo set_value('email'); ?>" placeholder="Email" /></div>
										<div class="uk-form-row"><label for="">Mật khẩu</label><input type="password" value="<?php echo set_value('password'); ?>"  name="password" id="" class="uk-width-1-1" placeholder="Mật khẩu" /></div>
										<div class="uk-form-row uk-text-center"><input type="submit" name="login" class="uk-button" value="Đăng nhập" /></div>
									</div>
								</div>
							</form>
							<form  action="register.html" method="post" class="uk-form">
								<div class="log signup">
									<h5 class="header uk-text-center">ĐĂNG KÝ</h5>
									<div class="body">
										<div class="uk-form-row"><label for="">Họ và tên</label><input type="text" name="fullname" value="<?php  echo set_value('fullname');?>" id="" class="uk-width-1-1" placeholder="Tên đầy đủ" /></div>
										<div class="uk-form-row"><label for="">Email</label><input type="text" name="email" <?php  echo set_value('email');?> id="" class="uk-width-1-1" placeholder="Email" /></div>
										<div class="uk-form-row"><label for="">Điện thoại di động</label><input type="text" name="phone" <?php  echo set_value('phone');?> id="" class="uk-width-1-1" placeholder="Nhập số điện thoại" /></div>
										<div class="uk-form-row"><label for="">Địa chỉ</label><textarea name="address" rows="5" cols="" class="uk-width-1-1" placeholder="Nhập địa chỉ"><?php  echo set_value('address');?></textarea></div>
										<div class="uk-form-row"><label for="">Mật khẩu</label><input type="password" name="password" id="" class="uk-width-1-1" placeholder="Chọn mật khẩu" /></div>
										<div class="uk-form-row"><label for="">Nhập lại mật khẩu</label><input type="password" name="re-password" id="" class="uk-width-1-1" placeholder="Xác nhận lại mật khẩu" /></div>
										<div class="uk-form-row uk-text-center"><input type="submit" name="register" class="uk-button" value="Đăng ký" /></div>
									</div>
								</div>
							</div><!-- .uk-grid -->
						</form>
					</div><!-- .fc-panel-body -->
				</div><!-- .uk-panel -->
			</div><!-- .uk-width -->
		</div><!-- .uk-grid -->
	</div><!-- .uk-container -->
</section><!-- .index-navigation -->