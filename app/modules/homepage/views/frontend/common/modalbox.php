<!-- MODAL -->
<div id="login-modal" class="uk-modal account-modal"><!-- ĐĂNG NHẬP -->
  	<div class="uk-modal-dialog modal">
	    <a class="uk-modal-close uk-close"></a>
	    <h2 class="heading"><span><?php echo $this->lang->line('login') ?></span></h2>
	    <div class="modal-body">
			<div class="login-error uk-alert"></div>
	        <form action="" method="" id="login_form" class="uk-form form">
		  		<div class="form-row">
		  			<input type="text" name="email" id="login_email" class="input-text uk-width-1-1" placeholder="<?php echo $this->lang->line('username') ?>" />
		  		</div> 
		  		<div class="form-row">
		  			<input type="password" name="password" id="login_password" class="input-text uk-width-1-1" placeholder="<?php echo $this->lang->line('password') ?>" />
		  		</div> 
		  		<div class="form-row action uk-flex uk-flex-middle uk-flex-space-between">
		  			<a class="forgot" href="" title="" data-uk-modal="{target: '#forgot-modal'}"><?php echo $this->lang->line('forgot_password') ?></a>
		  			<input type="submit" name="" id="submit" value="<?php echo $this->lang->line('login') ?>" class="btn-01 btn-submit" />
		  		</div>
	        </form>
    	</div>
  	</div>
</div><!-- #login-modal -->




<div id="register-modal" class="uk-modal account-modal"><!-- ĐĂNG KÝ THÀNH VIÊN -->
  <div class="uk-modal-dialog modal">
    <a class="uk-modal-close uk-close"></a>
    <h2 class="heading"><span><?php echo $this->lang->line('register_customers') ?></span></h2>
    <div class="modal-body">
		<div class="reg-error uk-alert"></div>
        <form action="<?php echo site_url('customers/ajax/auth/register'); ?>" onsubmit="return false;" method="post" class="uk-form form" id="FormRegister">
			<div class="form-row">
				<input type="text" name="fullname" id="reg_fullname" class="input-text uk-width-1-1" placeholder="<?php echo $this->lang->line('fullname_customers') ?> *" />
			</div> 
			<div class="form-row">
				<input type="text" name="email" id="reg_email" class="input-text uk-width-1-1" placeholder="Email *" />
			</div>
			<div class="form-row">
				<input type="password" name="password" id="reg_password" class="input-text uk-width-1-1" placeholder="<?php echo $this->lang->line('password') ?>" />
			</div> 
			<div class="form-row">
				<input type="password" name="re_password" id="reg_re_password" class="input-text uk-width-1-1" placeholder="<?php echo $this->lang->line('re_password') ?>" />
			</div> 
			<div class="form-row action uk-text-right">
				<input type="submit" name="" id="submit_reg" value="<?php echo $this->lang->line('register') ?>" class="btn-submit" />
			</div>
        </form>
    </div>
  </div>
</div><!-- #register-modal -->

<script type="text/javascript">
	$(function(){
		$('.login-error').hide();
		$('#login_form').on('submit',function(){
			$('#submit').val('Loading....');
			var email = $('#login_email').val();
			var password = $('#login_password').val();
			var formURL = 'customers/ajax/auth/login';
			$.post(formURL, {
				email: email,password:password},
				function(data){
					$('#submit').val('<?php echo $this->lang->line('login') ?>');
					$('.login-error').show();
					var json = JSON.parse(data);
					if(json.flag == false){
						$('.login-error').addClass('uk-alert-danger');
						$('.login-error').removeClass('uk-alert-success');
						$('.login-error').html(json.message);
					}else{
						$('.login-error').addClass('uk-alert-success');
						$('.login-error').removeClass('uk-alert-danger');
						$('.login-error').html(json.message);
						window.location.href='<?php echo base_url(); ?>';
					}
					
				});
			
			return false;
		});
		
		
		
		
		$('.reg-error').hide();
		var uri = $('#FormRegister').attr('action');
		$('#FormRegister').on('submit',function(){
			var email = $('#reg_email').val();
			var password = $('#reg_password').val();
			var re_password = $('#reg_re_password').val();
			var fullname = $('#reg_fullname').val();
			$('#submit_reg').val('Loading....');
			$.post(uri, {
				email: email,password:password, re_password: re_password,fullname:fullname},
				function(data){
					var json = JSON.parse(data);
					$('#submit_reg').val('<?php echo $this->lang->line('register') ?>');
					$('.reg-error').show();
					if(json.flag == false){
						$('.reg-error').addClass('uk-alert-danger');
						$('.reg-error').removeClass('uk-alert-success');
						$('.reg-error').html(json.message);
					}else{
						$('.reg-error').addClass('uk-alert-success');
						$('.reg-error').removeClass('uk-alert-danger');
						$('.reg-error').html(json.message);
						setTimeout(function(){ window.location.href='<?php echo base_url(); ?>'; }, 2000);
					}
					
				});
			return false;
		});
		
	});
</script>


<div id="success-modal" class="uk-modal account-modal success-modal"><!-- ĐĂNG KÝ THÀNH CÔNG -->
  <div class="uk-modal-dialog modal">
    <a class="uk-modal-close uk-close"></a>
    <h2 class="heading"><span>Đăng Ký thành công</span></h2>
    <div class="modal-body">
       <div class="note uk-text-center">Bạn vừa đăng ký thành viên thành công! Vui lòng sử dụng tài khoản bạn vừa đăng ký để đăng nhập.Xin cảm ơn!</div>
       <div class="action uk-text-center"><a href="" title="" class="btn-submit">Về trang chủ</a></div>
    </div>
  </div>
</div><!-- #success-modal -->

<div id="logout-modal" class="uk-modal account-modal logout-modal"><!-- ĐĂNG XUẤT -->
  <div class="uk-modal-dialog modal">
    <a class="uk-modal-close uk-close"></a>
    <h2 class="heading"><span>Thông báo</span></h2>
    <div class="modal-body">
       <div class="note uk-text-center">Bạn có chắc chắn muốn thoát ra không?</div>
       <div class="wrap-action uk-text-center">
       		<div class="action uk-flex-inline uk-flex-middle">
       			<a href="" title="" class="btn-submit">Có</a>
       			<a href="" title="" class="btn-no">Không</a>
       		</div>
       	</div>
    </div>
  </div>
</div><!-- #logout-modal -->

<div id="forgot-modal" class="uk-modal account-modal forgot-modal"><!-- QUÊN MẬT KHẨU -->
  <div class="uk-modal-dialog modal">
    <a class="uk-modal-close uk-close"></a>
    <h2 class="heading"><span><?php echo $this->lang->line('title_forgot_password') ?>?</span></h2>
    <div class="modal-body">
    	<div class="note uk-text-center mb10"><?php echo $this->lang->line('note_forgot_password') ?></div>
        <form action="" method="" class="uk-form form">
			<div class="form-row">
				<input type="text" name="" class="input-text uk-width-1-1" placeholder="<?php echo $this->lang->line('username') ?>" />
			</div>
			<div class="form-row action uk-text-center">
				<input type="submit" name="" value="<?php echo $this->lang->line('ok_forgot_password') ?>" class="btn-01 btn-submit" />
			</div>
        </form>
    </div>
  </div>
</div><!-- #forgot-modal -->