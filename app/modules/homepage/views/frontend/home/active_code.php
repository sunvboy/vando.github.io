<div class="wp-kichhoat-khoahoc">
    <div class="container">
    	<div class="box_kic-hoat_code">
	        <div class="title-kichhoat">
	            <h1 class="ten-pages-a">Kích hoạt khóa học</h1>
	        </div>
	        <div class="div-wp-text-kh">
	            <p><label class="label label-danger">Lưu ý</label> 
	            Mỗi khoá học chỉ cần kích hoạt 1 lần duy nhất. Không lặp lại bước này ở lần vào học sau.</p>
	            <br>
	            <p><span class="badge">1</span> Bạn <b>chưa có</b> tài khoản đăng nhập?, vui lòng <a href="#"><b>Đăng ký tài khoản mới</b></a>.</p>
	            <p><span class="badge">2</span> Bạn <b>đã có</b> tài khoản đăng nhập?, vui lòng <a href="#"><b>Đăng nhập tài khoản</b></a>.</p>
	        </div>
	        <div class="form-kh">
	        	<div class="reg-error uk-alert"></div>
	            <form method="POST" action="" id="form_active">
	                <div class="form-group">
	                    <input value="" type="text" name="key" id="code" class="form-control input-lg text-center" placeholder="Nhập mã kích hoạt, Ví dụ: 130E3157B8">
	                </div>
	                <center>
	                    <button title="Vui lòng nhập mã kích hoạt và đăng nhập tài khoản học viên để vào học" name="active" type="submit" class="btn btn-danger" id="submit_active">
	                    	<i class="fa fa-unlock" aria-hidden="true"></i> KÍCH HOẠT NGAY
	                    </button>
	                </center>
	            </form>
	        </div>
	        <div class="note_active text-center">
	        	Nếu gặp khó khăn trong việc kích hoạt khóa học, bạn vui lòng liên hệ với chúng tôi theo số: <font color="red"><?php echo $this->fcSystem['contact_phone'] ?></font>
	        </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.reg-error').hide();
        $('#form_active').on('submit',function(){
            var code = $('#code').val();
            $('#submit_active').html('<i class="fa fa-spinner" aria-hidden="true"></i> Loading....');
            var formURL = 'customers/ajax/auth/active_code';
            $.post(formURL, {
                code: code},
                function(data){
                    var json = JSON.parse(data);
                    $('.reg-error').show();
                    $('#submit_active').html('<i class="fa fa-unlock" aria-hidden="true"></i> KÍCH HOẠT NGAY');
                    if(json .error.length){
                        $('.reg-error').removeClass('uk-alert-success').addClass('uk-alert-danger');
                        $('.reg-error').html('').html(json.message);
                    }else{
                        $('.reg-error').removeClass('uk-alert-danger').addClass('uk-alert-success');
                        $('.reg-error').html('').html(json.message);
                        $('#submit_active').trigger("reset");
                        // setTimeout(function(){ location.reload(); }, 5000);
                    }
                    
                });
            return false;
        });
    });
</script>