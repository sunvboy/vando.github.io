<section class="box_login_customers">
    <header class="heading-page">
        <div class="title-art">
            <a class="link" href="javascript: void(0)" title="Tra cứu kết quả">
                Tra cứu kết quả
            </a>
        </div>
    </header>
    <section class="panel-body">
        <ul class="uk-list uk-clearfix tabControl-home" data-uk-switcher="{connect:'#tabContent-home'}">
            <?php if (isset($DetailUsers) && is_array($DetailUsers) && count($DetailUsers)) { ?>
                <li class="<?php echo (($DetailUsers['groupsid'] == 2) ? 'uk-active' : 'uk-hidden') ?>">Đơn vị gửi mẫu</li>
                <li class="<?php echo (($DetailUsers['groupsid'] == 1) ? 'uk-active fleft' : 'uk-hidden') ?>">Khách hàng</li>
            <?php }else{ ?>
                <li class="uk-active">Đơn vị gửi mẫu</li>
                <li class="">Khách hàng</li>
            <?php } ?>
        </ul>
        <ul id="tabContent-home" class="uk-switcher tab-content">
            <li>
                <?php if (isset($DetailUsers) && is_array($DetailUsers) && count($DetailUsers)) { ?>
                    <div class="box_customers">
                        <div class="line-item-item">
                            Chào bạn: <span><?php echo $DetailUsers['fullname'] ?></span>
                        </div>
                        <div class="line-item-item">
                            Địa chỉ: <span><?php echo $DetailUsers['address'] ?></span>
                        </div>
                        <div class="line-item-item">
                            <a href="members/list-doctor.html">Xem danh sách bệnh nhân</a>
                        </div>
                        <div class="line-item-item">
                            <a href="members/logout.html">Thoát</a>
                        </div>
                    </div>
                <?php }else{?>
                    <form action="" action="" id="form-login1">
                        <div class="login-error uk-alert"></div>
                        <div class="form-row mb10">
                            <input type="text" class="input-text uk-width-1-1 email" placeholder="Tên đăng nhập" />
                        </div> 
                        <div class="form-row mb10">
                            <input type="password" class="input-text uk-width-1-1 password" placeholder="Mật khẩu" />
                        </div> 
                        <div class="form-row">
                            <input type="submit" value="Tra cứu" class=" btn btn-submit login-form" />
                            <input type="reset" value="Nhập lại" class=" btn btn-reset" />
                        </div>
                    </form>
                <?php } ?>
            </li>
            <li>
                <?php if (isset($DetailUsers) && is_array($DetailUsers) && count($DetailUsers)) { ?>
                    <div class="box_customers">
                        <div class="line-item-item">
                            Chào bạn: <span><?php echo $DetailUsers['fullname'] ?></span>
                        </div>
                        <div class="line-item-item">
                            Địa chỉ: <span><?php echo $DetailUsers['address'] ?></span>
                        </div>
                        <div class="line-item-item">
                            <a href="members/list-doctor.html">Xem danh sách mẫu biểu</a>
                        </div>
                        <div class="line-item-item">
                            <a href="members/logout.html">Thoát</a>
                        </div>
                    </div>
                <?php }else{?>
                    <form action="" action="" id="form-login2">
                        <div class="login-error uk-alert"></div>
                        <div class="form-row mb10">
                            <input type="text" class="input-text uk-width-1-1 email" placeholder="Tên đăng nhập" />
                        </div> 
                        <div class="form-row mb10">
                            <input type="password" class="input-text uk-width-1-1 password" placeholder="Mật khẩu" />
                        </div> 
                        <div class="form-row">
                            <input type="submit" value="Tra cứu" class=" btn btn-submit login-form" />
                            <input type="reset" value="Nhập lại" class=" btn btn-reset" />
                        </div>
                    </form>
                <?php } ?>
            </li>
        </ul>
    </section>
</section>
<script type="text/javascript">
    $(function(){
        $('.login-error').hide();
        $('#form-login1').on('submit',function(){
            $('#form-login1 .login-form').val('Loading....');
            var email = $('#form-login1 .email').val();
            var password = $('#form-login1 .password').val();
            var formURL = 'customers/ajax/auth/login';
            $.post(formURL, {
                email: email, password: password, type: 1},
                function(data){
                    $('#form-login1 .login-form').val('Tra cứu');
                    $('#form-login1 .login-error').show();
                    var json = JSON.parse(data);
                    if(json.flag == false){
                        $('#form-login1 .login-error').addClass('uk-alert-danger');
                        $('#form-login1 .login-error').removeClass('uk-alert-success');
                        $('#form-login1 .login-error').html(json.message);
                    }else{
                        $('#form-login1 .login-error').addClass('uk-alert-success');
                        $('#form-login1 .login-error').removeClass('uk-alert-danger');
                        $('#form-login1 .login-error').html(json.message);
                        setTimeout(function(){ window.location.href = json.href; }, 2000);
                    }
                });
            return false;
        });

        $('#form-login2').on('submit',function(){
            $('#form-login2 .login-form').val('Loading....');
            var email = $('#form-login2 .email').val();
            var password = $('#form-login2 .password').val();
            var formURL = 'customers/ajax/auth/login';
            $.post(formURL, {
                email: email, password: password, type: 2},
                function(data){
                    $('#form-login2 .login-form').val('Tra cứu');
                    $('#form-login2 .login-error').show();
                    var json = JSON.parse(data);
                    if(json.flag == false){
                        $('#form-login2 .login-error').addClass('uk-alert-danger');
                        $('#form-login2 .login-error').removeClass('uk-alert-success');
                        $('#form-login2 .login-error').html(json.message);
                    }else{
                        $('#form-login2 .login-error').addClass('uk-alert-success');
                        $('#form-login2 .login-error').removeClass('uk-alert-danger');
                        $('#form-login2 .login-error').html(json.message);
                        setTimeout(function(){ window.location.href = json.href; }, 2000);
                    }
                });
            return false;
        });
    });
</script>