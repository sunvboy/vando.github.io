<div class="wp-dangnhap">
    <div class="wrap-login100 p-l-110 p-r-110 p-t-20 p-b-13">
        <form method="" class="login100-form validate-form flex-sb flex-w" id="login_form">
            <input id="form-token" type="hidden" name="" value="">
            <div class="text-center">
                <img src="<?php echo $this->fcSystem['homepage_logo'] ?>" alt="<?php echo $this->fcSystem['homepage_company'] ?>" />
            </div>
            <div class="login100-form-title text-center">
                <h3>Đăng nhập tài khoản</h3>
            </div>
            <div class="clearfix"></div>
            <div class="login-error alert"></div>
            <div class="wrap-input100 validate-input register-input" data-validate="">
                <input placeholder="Email" class="input100" type="email" name="email" value="" id="input_email">
                <span class="focus-input100"></span>
            </div>
            <div class="wrap-input100 validate-input register-input" data-validate="">
                <input placeholder="Mật khẩu, lớn hơn 6 ký tự" class="input100" type="password" name="pass" id="input_password">
                <span class="focus-input100"></span>
            </div>
            <div class="container-login100-form-btn mt20">
                <button type="submit" class="login100-form-btn" id="btn-submit">
                    Đăng nhập
                </button>
            </div>
            <div class="clearfix"></div>
            <div class="mtb15 col-md-12">
                <center>
                    <span class="txt1">
                    Hoặc
                </span>
                </center>
            </div>
            <?php $google_login_url = '';//$this->google->get_login_url(); ?>
            <?php $facebook_login_url = '';//$this->facebook->get_loginfb_url(); ?>
            <a style="width: 100%;" href="<?php echo $google_login_url ?>" class="btn-google mb20">
                <i class="fab fa-google-plus-square"></i> Đăng nhập bằng Google
            </a>
            <a style="width: 100%;" href="<?php echo $facebook_login_url ?>" class="btn-face m-b-20">
                <i class="fab fa-facebook"></i> Đăng nhập bằng Facebook
            </a>
            <div class="w-full text-center mt15">
                <span class="txt2">
                    Bạn chưa có tài khoản?
                </span>
                <a href="<?php echo site_url('register') ?>" class="txt2 bo1" style="color: #0275d8;">
                    Đăng ký
                </a>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.login-error').hide();
        $('#login_form').on('submit',function(){
            var _this = $(this);
            $('#btn-submit').val('Loading....');
            var email = _this.find('#input_email').val();
            var password = _this.find('#input_password').val();
            var formURL = 'customers/ajax/auth/login';
            $.post(formURL, {
                email: email,password:password},
                function(data){
                    $('#btn-submit').val('Đăng nhập');
                    $('.login-error').show();
                    var json = JSON.parse(data);
                    if(json.flag == false){
                        $('.login-error').removeClass('alert alert-success').addClass('alert alert-danger');
                        $('.login-error').html(json.message);
                    }else{
                        $('.login-error').removeClass('alert alert-danger').addClass('alert alert-success');
                        $('.login-error').html(json.message);
                        setTimeout(function(){ window.location.href = json.redirect; }, 2000);
                    }
                });
            return false;
        });
    });
</script> 
<style>
    header, footer{display: none;}
    .wp-dangnhap {
        width: 100%;
        min-height: 100vh;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        background: url('templates/bg-01.jpg');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
    .wrap-login100 {
        width: 480px;
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        position: relative;
    }
    .login100-form-title {
        display: block;
        
        font-size: 30px;
        font-weight: bold;
        line-height: 1.2;
        margin-top: 10px;
    }
    .register-input {
        margin-top: 20px;
    }
    .validate-input {
        position: relative;
    }
    .input100 {
        color: #333333;
        line-height: 1.2;
        font-size: 15px;
        display: block;
        width: 100%;
        background: transparent;
        height: 40px;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 0 15px;
    }
    .focus-input100 {
        position: absolute;
        display: block;
        width: calc(100% + 2px);
        height: calc(100% + 2px);
        top: -1px;
        left: -1px;
        pointer-events: none;
        border: 1px solid #fc00ff;
        border-radius: 4px;
        visibility: hidden;
        opacity: 0;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
        -webkit-transform: scaleX(1.1) scaleY(1.3);
        -moz-transform: scaleX(1.1) scaleY(1.3);
        -ms-transform: scaleX(1.1) scaleY(1.3);
        -o-transform: scaleX(1.1) scaleY(1.3);
        transform: scaleX(1.1) scaleY(1.3);
    }
    .input100:focus + .focus-input100 {
        visibility: visible;
        opacity: 1;
        -webkit-transform: scale(1);
        -moz-transform: scale(1);
        -ms-transform: scale(1);
        -o-transform: scale(1);
        transform: scale(1);
    }
    .input100:focus {
        border-color: transparent;
    }
    .login100-form-btn {
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 20px;
        width: 100%;
        height: 48px;
        background-color: #38aae6;
        border-radius: 5px;
        font-size: 18px;
        color: #fff;
        line-height: 1.2;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
        position: relative;
        z-index: 1;
        border: none;
        
    }
    .login100-form-btn::before {
        content: "";
        display: block;
        position: absolute;
        z-index: -1;
        width: 100%;
        height: 100%;
        border-radius: 5px;
        top: 0;
        left: 0;
        background: #a64bf4;
        background: -webkit-linear-gradient(45deg, #00dbde, #fc00ff);
        background: -o-linear-gradient(45deg, #00dbde, #fc00ff);
        background: -moz-linear-gradient(45deg, #00dbde, #fc00ff);
        background: linear-gradient(45deg, #00dbde, #fc00ff);
        opacity: 0;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }
    .login100-form-btn:hover::before {
        opacity: 1;
    }
    .btn-face, .btn-google {
        font-size: 17px;
        line-height: 1.2;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        width: calc((100% - 20px) / 2);
        height: 48px;
        border-radius: 5px;
        box-shadow: 0 1px 5px 0px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 1px 5px 0px rgba(0, 0, 0, 0.2);
        -webkit-box-shadow: 0 1px 5px 0px rgba(0, 0, 0, 0.2);
        -o-box-shadow: 0 1px 5px 0px rgba(0, 0, 0, 0.2);
        -ms-box-shadow: 0 1px 5px 0px rgba(0, 0, 0, 0.2);
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
        position: relative;
        z-index: 1;
        
    }
    .btn-face {
        color: #fff;
        background-color: #3b5998;
    }
    .btn-google {
        color: #fff;
        background-color: #d51c0c;
    }
    .btn-face:hover, .btn-google:hover {
        color: #fff;
        text-decoration: none
    }
    .login100-form-btn:hover:before {
        opacity: 1;
    }
    .btn-face i, .btn-google i {
        font-size: 30px;
        margin-right: 17px;
        padding-bottom: 3px;
    }
    .btn-google::before, .btn-face::before {
        content: "";
        display: block;
        position: absolute;
        z-index: -1;
        width: 100%;
        height: 100%;
        border-radius: 5px;
        top: 0;
        left: 0;
        background: #a64bf4;
        background: -webkit-linear-gradient(45deg, #00dbde, #fc00ff);
        background: -o-linear-gradient(45deg, #00dbde, #fc00ff);
        background: -moz-linear-gradient(45deg, #00dbde, #fc00ff);
        background: linear-gradient(45deg, #00dbde, #fc00ff);
        opacity: 0;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }
    .btn-face:hover:before, .btn-google:hover:before {
        opacity: 1;
    }
    .mt20 {
        margin-top: 20px;
    }
    .mb20 {
        margin-bottom: 20px !important;
    }
    .mtb15 {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .mt15 {
        margin-top: 15px;
    }
    .mtb10 {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>