<div id="learn-page" class="full-wrapper with-sidebar-second clearfix" auth-course="170" auth-lession="4505">
    <div id="lp-content-wr" class="content-wr height-full">
        <div id="lp-content" class="content height-full">
            <div id="player-container" class="learn-page-container player-container height-full">
                <div class="player-header clearfix">
                    <div class="logo pull-left">
                        <a href="<?php echo $canonical ?>">
                            <img src="templates/frontend/resources/images/backbuttonsm.png" alt="Logo" style="margin: 10px 0px 0px 20px; opacity: 0.5; width: 24px;" />
                        </a>

                        <a href=".">
                            <img src="<?php echo $this->fcSystem['homepage_logo'] ?>" alt="Logo" style="width: 120px; margin: 0px 0px 0px 10px; opacity: 0.5;" />
                        </a>
                    </div>
                    <a id="scorm-view-back_mobile" class="hidden" href="<?php echo $canonical ?>"><i class="fa fa-chevron-circle-left"></i></a>
                    <div id="title_lession">
                        <p>Bài <span>1</span> : <?php echo $DetailLesson['title']; ?></p>
                    </div>
                    <a id="learn-panel-close" class="learn-panel-close">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
                <div class="player-rp" id="unicaplayer">
                    <div id="myPlayerID">
                        <?php echo $DetailLesson['source'] ?>
                    </div>
                </div>
                <div class="player-footer clearfix">
                    <div class="for-desktop">
                        <a id="scorm-next" data-next="<?php echo ($DetailLesson['id'] + 1) ?>" class="scorm-next scorm-prev-mobile" href="<?php echo site_url('learning/lecture-'.($DetailLesson['id'] + 1).'') ?>">
                            Bài sau 
                        </a>
                        <a style="cursor: pointer;" class="warning-lession clearfix"><span class="pull-left margin-right-5">Báo lỗi</span></a>
                        <a class="warning-lession clearfix">
                            <span class="pull-left margin-right-5">Auto play</span>
                            <i title="Auto play" id="autoplay" class="fa fa-2x fa-toggle-on" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
        </div>
        <div class="spinner toggle_sidebar"></div>
    </div>
    <div class="bg_overflow"></div>
    <div class="sidebar-second">
        <div class="spinner toggle_sidebar" style="display: none;"></div>
        <div class="learn-page-info height-full">
            <ul class="nav nav-tabs learn-page-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#course-outline-ebook">
                        <i class="fa fa-list"></i>
                        <span class="mobile_text" data-commend="load_outline_data"> Giáo trình</span>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#course-outline-comment">
                        <i class="fa fa-comments"></i>
                        <span class="mobile_text" data-commend="load_learn_data"> Thảo luận</span>
                    </a>
                </li>
                <li class="hideproducts_lecture">
                    <a data-toggle="tab" href="#course-outline-document">
                        <i class="fa fa-download"></i> 
                        <span class="mobile_text" data-commend="load_doc_data"> Tài liệu</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content learn-page-panels">
            <div id="course-outline-ebook" class="tab-pane fade active in">
                <div id="course-outline">
                    <?php $stt = 1; $number = 0 ?>
                    <?php if (isset($chapter) && is_array($chapter) && count($chapter)): ?>
                        <?php foreach ($chapter as $keyc => $vals): ?>
                            <div class="scorm-section-right">
                                <h3 class="section-right-name">Phần <?php echo ($keyc + 1) ?>: <?php echo $vals['title'] ?></h3>
                            </div>
                            <?php if (isset($vals['page']) && is_array($vals['page']) && count($vals['page'])): ?>
                                <div class="list-mobile">
                                    <ul class="learn-outline-list scorm-right-list">
                                        <?php foreach ($vals['page'] as $keyp => $val): ?>
                                            <?php $number = $val['id']; ?>
                                            <li class="learn-outline-item scorm-right-item <?php echo (($DetailLesson['id'] == $val['id']) ? 'active' : '') ?>" data-value="<?php echo $stt ?>">
                                                <div class="learn-lesson-wr scorm-right-link-wr" id="learn-lesson-<?php echo $val['id'] ?>" title="Nội dung bài học">
                                                    <div class="lesson-process-wr">
                                                        <span><i class="fa fa-check" style="background: green;border-radius: 8px;margin: 1px -2px;"></i></span>
                                                    </div>
                                                    <h4 class="scorm-right-name here">
                                                        <a href="<?php echo site_url('learning/lecture-'.$val['id'].'') ?>" title="Nội dung bài học" class="color-dark">
                                                            <span class="scorm-right-link">Bài <?php echo $stt ?>: <?php echo $val['title'] ?></span>
                                                        </a>
                                                    </h4>
                                                </div>
                                            </li>
                                            <?php $stt++; ?>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                    <div id="count_lesson" data-value="<?php echo $number ?>"></div>
                </div>
            </div>
            <div id="course-outline-comment" class="tab-pane fade">
                <div class="scorm-learn-panel-content comment-learn-cotent">
                    <div class="error uk-alert mb10"></div>
                    <div class="vietdanhgia">
                        <form action="<?php echo site_url('comments/ajax/comments/addcomment'); ?>" method="get" id="rateform">
                            <div class="nhapnoidung"><input id="discussion_text" class="form-control" placeholder="Nhập nội dung thảo luận"></div>
                            <button class="discusstion_submit" type="submit">Gửi</button>
                            <input id="course_id" value="<?php echo $DetailLesson['id'] ?>" type="hidden">
                            <div style="clear: both;"></div>
                        </form>
                    </div>
                    <ul class="uk-list uk-clearfix comment-list" data-page="1"></ul>
                </div>
            </div>
            <div id="course-outline-document" class="tab-pane fade">

            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Báo lỗi cho chúng tôi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('products/ajax/products/error_video') ?>" method="get" accept-charset="utf-8" id="error_form">
                    <div class="error_ uk-alert mb10"></div>
                    <textarea name="message" class="message form-control" rows="5"></textarea>
                    <div class="clearfix"></div>
                    <button class="btn btn-submit" type="submit">Gửi yêu cầu</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        width: 30px;
        height: 30px;
    }
    .btn.btn-submit {
        margin-top: 20px;
        background-color: #1b7997;
        color: #fff;
    }
</style>
<script type="text/javascript">
    $(function(){
        $('.toggle_sidebar, .bg_overflow').click(function(){
            $("body").toggleClass("canvas_toggle");
        })

        $('.error_').hide();
        $('.error').hide();
        var module = '<?php echo $module ?>';
        var moduleid = '<?php echo $moduleid ?>';
        var pageid = '<?php echo $pageid ?>';
        listComment(module, moduleid, pageid, $('.comment-list').attr('data-page'));


        $('.warning-lession').click(function(){
            $('#myModal').modal('toggle', {
                keyboard: false
            });
        });
        $('#error_form').on('submit',function(){
            var uri = $('#error_form').attr('action');
            var text = $('#error_form .message').val();
            $.post(uri, {
                message: text, module: module, moduleid: moduleid, pageid: pageid},
                function(data){
                    var json = JSON.parse(data);
                    $('.error_').show();
                    if(json.error.length){
                        $('.error_').removeClass('uk-alert-success').addClass('uk-alert-danger');
                        $('.error_').html('').html(json.error);
                    }else{
                        $('.error_').removeClass('uk-alert-danger').addClass('uk-alert-success');
                        $('.error_').html('').html('Gửi báo cáo thành công!.');
                        $('#error_form').trigger("reset");
                        setTimeout(function(){ $('#myModal').modal('hide') }, 3000);
                    }
                });
            return false;
        });

        

        
        $('#rateform').on('submit',function(){
            var uri = $('#rateform').attr('action');
            var text = $('#discussion_text').val();
            $.post(uri, {
                message: text, module: module, moduleid: moduleid, pageid: pageid, parentid: 0},
                function(data){
                    var json = JSON.parse(data);
                    $('.error').show();
                    if(json.error.length){
                        $('.error').removeClass('uk-alert-success').addClass('uk-alert-danger');
                        $('.error').html('').html(json.error);
                    }else{
                        $('.error').removeClass('uk-alert-danger').addClass('uk-alert-success');
                        $('.error').html('').html('Gửi bình luân thành công!.');
                        $('#rateform').trigger("reset");
                        setTimeout(function(){ listComment(module, moduleid, pageid, $('.comment-list').attr('data-page')) }, 3000);
                    }
                });
            return false;
        });
        $(document).on('click','.ajax-pagination .uk-pagination li a',function(){
            var page = $(this).attr('data-ci-pagination-page');
            listComment(module, moduleid, pageid, page);
            return false;
        });
    });
    function listComment(module, moduleid, pageid, page){
        var uri = '<?php echo site_url('comments/ajax/comments/listComment'); ?>';
        $.post(uri, {
            module: module, moduleid: moduleid, pageid: pageid, page:page},
        function(data){
            var json = JSON.parse(data);
            $('.comment-list').html(json.html);
            $('.error').hide();
        });
    }
    $(document).on('click','.item-reply',function(){
        $('.reply-comment').html('');
        $('.item-comments-sub').hide();
        var id = $(this).attr('data-id');
        var item = '<div class="rep-box-comment">' + 
            '<div class="error_comm mb5 uk-alert"></div>'+
            '<div class="input-box-comment">' + 
            '<input name="parentid" id="parentid" value="'+id+'" type="hidden">'+
            '<input class="form-control" id="content_comm" placeholder="Nội dung trả lời" type="text">'+
            '<a class="send-comment btn-send" title="Bấm vào đây để gửi bình luận">Gửi</a>'+
        '</div></div>';
        $(this).parent().parent().find('.reply-comment').append(item);
        $(this).parent().parent().find('.item-comments-sub').show();
        $('.error_comm').hide();
        return false;
    });
    $(document).on('click','.send-comment',function(){
        var module = '<?php echo $module ?>';
        var moduleid = '<?php echo $moduleid ?>';
        var pageid = '<?php echo $pageid ?>';
        var parentid = $('#parentid').val();
        var contents = $('#content_comm').val();
        var uri = '<?php echo site_url('comments/ajax/comments/addcomment'); ?>';
        $(this).html('Đang xử lý');
        $.post(uri, {
            module: module, moduleid: moduleid, pageid: pageid, message: contents, parentid : parentid},
        function(data){
            var json = JSON.parse(data);
            $('.error_comm').show();
            if(json.error.length){
                $('.error_comm').removeClass('uk-alert-success').addClass('uk-alert-danger');
                $('.error_comm').html('').html(json.error);
            }else{
                $('.error_comm').removeClass('uk-alert-danger').addClass('uk-alert-success');
                $('.error_comm').html('').html('Gửi bình luân thành công!.');
                 setTimeout(function(){ listComment(module, moduleid, pageid, $('.comment-list').attr('data-page')) }, 3000);
            }
        });
        return false;
    });
</script>
<script>
    function load_page_lesson(){
        var number = $('.learn-outline-item.active').attr('data-value');
        $('#title_lession p span').html('').html(number);
    }
    function load_href_lesson(){
        var number = parseInt($('#scorm-next').attr('data-next'));
        var total = parseInt($('#count_lesson').attr('data-value'));
        if (number > total) {          
            $('#scorm-next').attr('href', ''+BASE_URL+'learning/lecture-'+total+'.html');
        }
    }
    $(document).ready(function(){
        load_page_lesson();
        load_href_lesson();
    });
</script>