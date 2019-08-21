<footer id="footer-site">
    <!-- back to top -->
    <div class="back-tt">
        <a href="#" id="back-to-top" title="Back to top" class="show"><i class="fa fa-arrow-circle-up"></i></a>
    </div>
    <!-- end back to top -->
    <div class="container-fluid pd-0">
        <div class="wp-footer-top">
            <div class="row">

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="wp-ft-top">
                        <h3 class="h3-title-ft"><?php echo $this->fcSystem['HOTLINE_goimuahang_title']?> ( <?php echo $this->fcSystem['HOTLINE_goimuahang_tv']?> )</h3>
                        <p class="p-phone">
                            <i class="fas fa-phone-alt"></i>
                            <span><?php echo $this->fcSystem['HOTLINE_goimuahang_phone']?></span>
                        </p>
                        <p class="p-span"><?php echo $this->fcSystem['HOTLINE_goimuahang_des']?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="wp-ft-top">
                        <h3 class="h3-title-ft"><?php echo $this->fcSystem['HOTLINE_khieunai_title']?> ( <?php echo $this->fcSystem['HOTLINE_khieunai_tv']?> )</h3>
                        <p class="p-phone">
                            <i class="fas fa-phone-alt"></i>
                            <span><?php echo $this->fcSystem['HOTLINE_khieunai_phone']?></span>
                        </p>
                        <p class="p-span"><?php echo $this->fcSystem['HOTLINE_khieunai_des']?></p>
                    </div>
                </div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="wp-ft-top">
                        <h3 class="h3-title-ft">ĐĂNG KÝ NHẬN THÔNG TIN MỚI</h3>
                        <div class="wp-form-dk">
                            <form action="<?php echo site_url('mailsubricre/frontend/mailsubricre/create') ?>" id="sform" method="post">
                                <div class="error alert"></div>

                                <div class="form-dk-email">
                                    <input type="email" placeholder="Email của bạn" class="form-control email" required name="email">
                                    <button class="btn btn-default btn-dk btn-hover">Đăng ký</button>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="check" value="" required> Tôi đồng ý với các điều kiện & điều khoản
                                    </label>
                                </div>
                            </form>
                            <script type="text/javascript" charset="utf-8">
                                $(document).ready(function(){
                                    $('#sform .error').hide();
                                    var uri = $('#sform').attr('action');
                                    $('#sform').on('submit',function(){
                                        var postData = $(this).serializeArray();
                                        $.post(uri, {post: postData, email: $('#sform .email').val()},
                                            function(data){
                                                var json = JSON.parse(data);
                                                $('#sform .error').show();
                                                if(json .error.length){
                                                    $('#sform .error').removeClass('alert alert-success').addClass('alert alert-danger');
                                                    $('#sform .error').html('').html(json.error);
                                                }else{
                                                    $('#sform .error').removeClass('alert alert-danger').addClass('alert alert-success');
                                                    $('#sform .error').html('').html('ĐĂNG KÝ NHẬN THÔNG TIN MỚI THÀNH CÔNG!.');
                                                    $('#sform').trigger("reset");
                                                    setTimeout(function(){ location.reload(); }, 5000);
                                                }
                                            });
                                        return false;
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="wp-ft-top">
                        <h3 class="h3-title-ft">LIKE VENUS TRÊN MẠNG XÃ HỘI</h3>
                        <ul class="ul-b list-mxh">
                            <li><a href="<?php echo $this->fcSystem['social_facebook']?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="<?php echo $this->fcSystem['social_instagram']?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="<?php echo $this->fcSystem['social_youtube']?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="<?php echo $this->fcSystem['social_zalo']?>" target="_blank" class="fa-zalo"><img src="templates/frontend/images/logo-zalo-vector.png" alt="<?php echo $this->fcSystem['social_zalo']?>"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="wp-footer-main">
            <div class="row">
                <?php echo $this->load->view('homepage/frontend/common/menu_footer');?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="wp-ft-main">
                        <h3 class="h3-title-ft">Fanpage của chúng tôi</h3>
                        <div class="ul-b list-ft-main" style="">
                            <div class="wp-iframe-fb">
                                <iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo $this->fcSystem['social_facebook']?>%2F&tabs=timeline&width=360&height=200&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1821093994887965" width="360" height="200" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wp-footer-bottom">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="left-ft-bt">
                        <span>© 2019 Venus</span>
                    </div>
                </div>
                <div class="col-md-6 hidden-sm hidden-xs">
                    <div class="right-ft-bt text-right">
                        <a href="<?php echo $this->fcSystem['homepage_links_bocongthuong']?>"> <img src="<?php echo $this->fcSystem['homepage_bocongthuong']?>" alt="bộ công thương"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>

<!-- js site -->
<script src="templates/frontend/js/bootstrap.min.js"></script>
<script type="text/javascript" src="templates/frontend/js/owl.carousel.js"></script>
<!-- js zoom img ctsp -->
<script type="text/javascript" src="templates/frontend/js/modernizr.custom.js"></script>
<script type="text/javascript" src="templates/frontend/js/jquery.glasscase.minf195.js"></script>
<!-- js countdown -->
<!-- js custom -->
<script type="text/javascript" src="templates/frontend/js/library.js"></script>
<!-- end footer -->
<script>


    $('.product-dosize span').click(function () {

    })
</script>


<!-- menu mobile -->
<div class="backdrop__body-backdrop___1rvky"></div>
<div class="mobile-main-menu">
    <div class="drawer-header">
        <a href="#">
            <div class="drawer-header--auth">
                <div class="_object"> <img src="templates/frontend/images/user.png" alt="" /> </div>
                <div class="_body"> ĐĂNG NHẬP<br> Nhận nhiều ưu đãi hơn
                </div>
            </div>
        </a>
    </div>
    <ul class="ul-first-menu">
        <li><a href="#"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
        </li>
        <li><a href="#"><i class="fas fa-user"></i> Đăng ký</a>
        </li>
    </ul>
    <div class="la-scroll-fix-infor-user">
        <div class="la-nav-menu-items">
            <ul class="la-nav-list-items ul-b">
                <li class="ng-scope"> <a href="#">Trang chủ</a>
                </li>
                <li class="ng-scope"> <a href="#">Giới thiệu</a>
                </li>
                <li class="ng-scope ng-has-child1"> <a href="#">Sản phẩm <i class="fa fa-plus fa1" aria-hidden="true"></i></a>
                    <ul class="ul-has-child1 ul-b">
                        <li class="ng-scope ng-has-child2"> <a href="#">Sản phẩm 2<i class="fa fa-plus fa2" aria-hidden="true"></i></a>
                            <ul class="ul-has-child2 ul-b">
                                <li class="ng-scope"> <a href="#">Sản phẩm 3</a> </li>
                                <li class="ng-scope"> <a href="#">Sản phẩm 3</a> </li>
                                <li class="ng-scope"> <a href="#">Sản phẩm 3</a> </li>
                                <li class="ng-scope"> <a href="#">Sản phẩm 3</a> </li>
                                <li class="ng-scope"> <a href="#">Sản phẩm 3</a> </li>
                            </ul>
                        </li>
                        <li class="ng-scope ng-has-child2"> <a href="#">Sản phẩm 2</a>
                        </li>
                        <li class="ng-scope ng-has-child2"> <a href="#">Sản phẩm 2</a>
                        </li>
                    </ul>
                </li>
                <li class="ng-scope"> <a href="#">Đại lý</a>
                </li>
                <li class="ng-scope"> <a href="#">Tin tức</a>
                </li>
                <li class="ng-scope"> <a href="#">Liên hệ</a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="ul-b mobile-support hidden">
        <li>
            <div class="drawer-text-support">HỖ TRỢ</div>
        </li>
        <li><i class="fa fa-phone"></i> HOTLINE: <a href="#">01225510042</a>
        </li>
        <li><i class="fa fa-envelope"></i> EMAIL: <a href="#">baotrung304@gmail.com</a>
        </li>
    </ul>
</div>