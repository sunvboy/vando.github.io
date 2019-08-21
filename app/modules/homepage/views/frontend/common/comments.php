<?php if (show_rating_products($DetailProducts['id'], 'products', TRUE) > 0){ ?>
<?php

$j = round((count_rating($DetailProducts['id'], 'products', FALSE) / show_rating_products($DetailProducts['id'], 'products', FALSE)), 1);

?>


<?php }?>
<div class="wp-review">
    <div class="wp-title-sec">
        <h2 class="h2-title text-center">ĐÁNH GIÁ</h2>
        <div class="so-danhgia">
            <?php if (show_rating_products($DetailProducts['id'], 'products', TRUE) > 0){ ?>

            <span class="int-st"><?php echo $j; ?></span>
            <div class="start">
              <?php
              for ($i=0; $i <5 ; $i++) {
                  $v = $j - $i;
                  if ($v > 0) {
                      if ($v == 0.5) {
                          echo '<i style="color: #F49100;" class="fas fa-star-half-alt"></i>';
                      }else{
                          echo '<i style="color: #F49100;" class="fas fa-star"></i>';
                      }
                  }else{
                      echo '<i style="color: #F49100;" class="far fa-star"></i>';
                  }
              }
              ?>
            </div>
            <?php }?>
            <span><span class="count_comments">0</span> Reviews, <span class="count_cauhoi">0</span> Q&As</span>
        </div>
    </div>
    <div class="wp-btn-hoi">
        <button data-toggle="modal" data-target="#modal-danhgia">VIẾT ĐÁNH GIÁ</button>
        <button data-toggle="modal" data-target="#modal-hoidap">ĐẶT CÂU HỎI</button>
        <!-- modal -->
        <div class="modal fade" id="modal-danhgia">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="wp-text-danhgia">
                            <form id="rateform" action="<?php echo site_url('comments/ajax/comments/addcomment'); ?>" method="post">
                                <div class="wpdg1 form-group">
                                    <p class="mb0">Đánh giá</p>
                                    <span class="starRating">
                                                            <input id="rating5" type="radio" name="star" value="5">
                                                            <label class="full" data-value="5" for="rating5">5</label>
                                                            <input id="rating4" type="radio" name="star" value="4">
                                                            <label class="full" data-value="4" for="rating4">4</label>
                                                            <input id="rating3" type="radio" name="star" value="3" checked>
                                                            <label class="full" data-value="3" for="rating3">3</label>
                                                            <input id="rating2" type="radio" name="star" value="2">
                                                            <label class="full" data-value="2" for="rating2">2</label>
                                                            <input id="rating1" type="radio" name="star" value="1">
                                                            <label class="full" data-value="1" for="rating1">1</label>
                                                        </span>
                                </div>
                                <div class="wpdg2 form-group">
                                    <div class="error mt20 alert"></div>

                                </div>
                                <div class="wpdg2 form-group">
                                    <p class="mb0">Họ và tên</p>
                                    <input name="fullname" class="form-control" id="rate-name" placeholder="Nhập tên của bạn *" value="<?php echo ((!empty($customer['fullname'])) ? $customer['fullname'] : '') ?>" type="text">
                                    <input type="hidden" name="star" id="hidden_star" value="">
                                    <input type="hidden" name="customersid" value="<?php echo ((!empty($customer['id'])) ? $customer['id'] : 0) ?>">
                                </div>
                                <div class="wpdg3 form-group">
                                    <p class="mb0">Số điện thoại</p>
                                    <input title="Số điện thoại" name="phone" id="rate-phone" class="form-control" placeholder="Số điện thoại *" value="<?php echo ((!empty($customer['phone'])) ? $customer['phone'] : '') ?>" type="text">
                                </div>
                                <div class="wpdg3 form-group">
                                    <p class="mb0">Email</p>
                                    <input title="Nhập địa chỉ Email" name="email" id="rate-email" class="form-control" placeholder="Địa chỉ email *" value="<?php echo ((!empty($customer['email'])) ? $customer['email'] : '') ?>" type="text">
                                </div>

                                <div class="wpdg2 form-group">
                                    <p class="mb0">Nội dung</p>
                                    <textarea rows="5" title="Nhập nội dung đánh giá / nhận xét" name="message" id="rate-content" placeholder="Nhập nội dung đánh giá / nhận xét..." class="form-control" aria-required="true"></textarea>

                                </div>
                                <button class="btn btn-danger" type="submit">Gửi đánh giá</button>
                            </form>
                            <script type="text/javascript">
                                $(function(){
                                    $('.full').on('click',function(){
                                        var star = $(this).attr('data-value');
                                        $('#hidden_star').attr('value', star);
                                    });
                                    $('.error').hide();
                                    var module = '<?php echo $module ?>';
                                    var moduleid = '<?php echo $moduleid ?>';
                                    listComment(module, moduleid, $('.comment-list').attr('data-page'));

                                    var uri = $('#rateform').attr('action');
                                    $('#rateform').on('submit',function(){
                                        var postData = $(this).serializeArray();
                                        var fullname = $('#rate-name').val();
                                        var email = $('#rate-email').val();
                                        var phone = $('#rate-phone').val();
                                        var contents = $('#rate-content').val();
                                        $.post(uri, {
                                                post: postData, module: module, moduleid: moduleid,fullname: fullname, email: email, phone: phone, contents: contents, parentid : 0},
                                            function(data){
                                                var json = JSON.parse(data);
                                                $('.error').show();
                                                if (fullname == '') {
                                                    $('#rate-name').addClass('required');
                                                }
                                                if (email == '') {
                                                    $('#rate-email').addClass('required');
                                                }
                                                if (phone == '') {
                                                    $('#rate-phone').addClass('required');
                                                }
                                                if (contents == '') {
                                                    $('#rate-content').addClass('required');
                                                }
                                                if(json.error.length){
                                                    $('#rateform .error').removeClass('alert alert-success').addClass('alert alert-danger');
                                                    $('#rateform .error').html('').html(json.error);
                                                }else{
                                                    $('#rateform .error').removeClass('alert alert-danger').addClass('alert alert-success');
                                                    $('#rateform .error').html('').html('Gửi đánh giá sản phẩm thành công!.');
                                                    $('#rateform').trigger("reset");
                                                    setTimeout(function(){ window.location.href='<?php echo $canonical ?>'; }, 3000);
                                                }
                                            });
                                        return false;
                                    });
                                    $(document).on('click','.ajax-pagination .uk-pagination li a',function(){
                                        var page = $(this).attr('data-ci-pagination-page');
                                        listComment(module, moduleid, page);
                                        return false;
                                    });

                                });
                                function listComment(module, moduleid, page){
                                    var uri = '<?php echo site_url('comments/ajax/comments/listComment'); ?>';
                                    $.post(uri, {
                                            module: module, moduleid: moduleid, page:page},
                                        function(data){
                                            var json = JSON.parse(data);
                                            $('.comment-list').html(json.html);
                                            $('.count_comments').html(json.count_comments);
                                        });
                                }

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-hoidap">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="wp-cauhoi">
                            <h4>Hỏi đáp</h4>
                            <form action="<?php echo site_url('comments/ajax/comments/addquestion'); ?>" method="post" id="rateformCH">
                                <div class="wpdg2 form-group">
                                    <div class="errorcauhoi mt20 alert"></div>
                                </div>
                                <input name="fullname" class="form-control wpdg2 form-group" id="rate-namecauhoi" placeholder="Nhập tên của bạn *" value="<?php echo ((!empty($customer['fullname'])) ? $customer['fullname'] : '') ?>" type="text">

                                <input type="hidden" name="customersid" value="<?php echo ((!empty($customer['id'])) ? $customer['id'] : 0) ?>">
                                <textarea rows="5" title="Nhập nội dung đánh giá / nhận xét" name="message" id="rate-contentcauhoir" placeholder="Nhập nội dung câu hỏi..." class="wpdg2 form-group form-control" aria-required="true"></textarea>
                                <button class="btn btn-danger" type="submit">Gửi câu hỏi</button>
                            </form>
                            <script type="text/javascript">
                                $(function(){
                                    $('.errorcauhoi').hide();
                                    var module = '<?php echo $module ?>';
                                    var moduleid = '<?php echo $moduleid ?>';
                                    listCauhoi(module, moduleid, $('.cauhoi-list').attr('data-page'));

                                    var uri = $('#rateformCH').attr('action');
                                    $('#rateformCH').on('submit',function(){
                                        var postData = $(this).serializeArray();
                                        var contents = $('#rate-contentcauhoir').val();
                                        var fullname = $('#rate-namecauhoi').val();
                                        $.post(uri, {
                                                post: postData, fullname: fullname, module: module, moduleid: moduleid, contents: contents, parentid : 0},
                                            function(data){
                                                var json = JSON.parse(data);
                                                $('.errorcauhoi').show();
                                                if(json.error.length){
                                                    $('#rateformCH .errorcauhoi').removeClass('alert alert-success').addClass('alert alert-danger');
                                                    $('#rateformCH .errorcauhoi').html('').html(json.error);
                                                }else{
                                                    $('#rateformCH .errorcauhoi').removeClass('alert alert-danger').addClass('alert alert-success');
                                                    $('#rateformCH .errorcauhoi').html('').html('Gửi câu hỏi thành công!.');
                                                    $('#rateformCH').trigger("reset");
                                                    setTimeout(function(){ window.location.href='<?php echo $canonical ?>'; }, 3000);
                                                }
                                            });
                                        return false;
                                    });
                                    $(document).on('click','.ajax-pagination-cauhoi .uk-pagination li a',function(){
                                        var page = $(this).attr('data-ci-pagination-page');
                                        listCauhoi(module, moduleid, page);
                                        return false;
                                    });

                                });
                                function listCauhoi(module, moduleid, page){
                                    var uri = '<?php echo site_url('comments/ajax/comments/listQuestion'); ?>';
                                    $.post(uri, {
                                            module: module, moduleid: moduleid, page:page},
                                        function(data){
                                            var json = JSON.parse(data);
                                            $('.cauhoi-list').html(json.html);
                                            $('.count_cauhoi').html(json.count_comments);
                                        });
                                }

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wp-tab-content-review">
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#rv1"><span>Đánh giá</span></a></li>
            <li><a data-toggle="pill" href="#rv2"><span>Hỏi đáp</span></a></li>
        </ul>
        <div class="tab-content">
            <div id="rv1" class="tab-pane fade in active">
                <div class="wp-sautab">
                    <p class="b-mn "><span class="count_comments">0</span> đánh giá</p>
                    <div class="wp-list-danhgia comment-list">
                    </div>
                    <style>
                        .left-dg h4 {
                            margin-bottom: 0px;
                            font-family: Mon2;
                            line-height: 25px;
                        }
                        .combody-at strong i {
                           margin-left: 0px;
                        }
                    </style>
                </div>
            </div>
            <div id="rv2" class="tab-pane fade">
                <div class="wp-sautab cauhoi-list">

                </div>
            </div>
        </div>
    </div>
</div>