<div id="lesson-page" class="page-body">
	<div class="u-course-highlight2">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="ubo-left">
                        <img class="img-responsive" src="<?php echo $DetailProducts['images'] ?>" alt="<?php echo $DetailProducts['title'] ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="ubo-right">
                        <div class="ubo-right-title"><?php echo $DetailProducts['title'] ?></div>
                        <div class="description mb20"><?php echo $DetailProducts['description'] ?></div>
                        <div class="ubo-right-btn mb20">
                            <a class="btn-learn" id="learn-star" href="">Vào học ngay</a>
                        </div>
                        <?php if (!empty($count_lesson_member)): ?>
                        	<?php $person = 0; ?>
                        	<?php $count_lesson = countlesson($DetailProducts['id']); ?>
                        	<?php if (!empty($complete)): ?>
                        		<?php 
                        			$person = round(($complete / $count_lesson)*100, 2); 
                        		?>
                        	<?php endif ?>
	                        <div class="ubo-right-prog">
	                            <p>Bạn hoàn thành <b><?php echo $complete ?></b> trong <b><?php echo $count_lesson ?></b> bài giảng</p>
	                            <div class="ubo-progress">
	                                <div class="progress">
	                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $person ?>%">
	                                        <?php echo $person ?>%
	                                    </div>
	                                </div>
	                                <div class="progress-cup progress">
	                                    <div class="cup-awards">
	                                        <i class="fa fa-trophy" aria-hidden="true"></i>
	                                    </div>
	                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $person ?>%">
	                                        Cup
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


	<div class="u-tab-overview">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="overview-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tongquan">Tổng quan</a></li>
                            <li class=""><a data-toggle="tab" href="#baihoc">Bài học</a></li>
                            <li class="hideproducts_lecture"><a data-toggle="tab" href="#tailieu">Tài liệu</a></li>
                            <li class="hideproducts_lecture"><a data-toggle="tab" href="#hoidap">Hỏi &amp; Đáp</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<?php $info_teacher = $this->FrontendTeachers_Model->ReadByField('id', $DetailProducts['teachersid']); ?>
	<?php $href_t = rewrite_url($info_teacher['canonical'], $info_teacher['slug'], $info_teacher['id'], 'teachers') ?>
	<div class="u-overview-main">
		<div class="container">
			<div class="row10">
				<div class="tab-content mt20">
					<div id="tongquan" class="tab-pane fade active in">
						<div class="col-lg-7 col-md-7 col-sm-7 pdLm pdR5 p10 ">
							<div class="uom-left">
								<div class="uom-block-intro mb20">
                                    <h3>Chào mừng khóa học</h3>
									<p>
										Bạn là một trong số những người tuyệt vời khi có mặt ở đây để tham gia Khóa học <?php echo $DetailProducts['title'] ?>, được hướng dẫn bởi Giảng viên <?php echo $info_teacher['title'] ?></p>
									<p>
										Phía bên phải màn hình là Nội dung bài học. Để vào học, bạn kích chuột vào tên bài học (bắt đầu từ bài 1) hoặc bất kỳ bài học nào bạn muốn, màn hình giao diện bài giảng sẽ hiện ra.</p>
									<p>
										Trong quá trình học, nếu có bất kỳ thắc mắc, câu hỏi nào, bạn hãy nhập vào ô Thảo luận khóa học, <?php echo $this->fcSystem['homepage_brandname'] ?> và Giảng viên sẽ hỗ trợ bạn.</p>
									<p>
										Chúc bạn có những trải nghiệm tuyệt vời cùng <?php echo $this->fcSystem['homepage_brandname'] ?>.</p>
                                </div>
                                <div class="overview_comment mb20">
									<?php coment_fb() ?>
								</div>	
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 pdLm pdRm p10">
							<div class="uom-right">
								<div class="uom-block-gv mb20">
                                    <h3>Thông tin giảng viên</h3>
                                    <div class="uom-gv-left">
                                        <div class="uct-ava-gv"><img src="<?php echo $info_teacher['images'] ?>" align="<?php echo $info_teacher['title'] ?>"></div>
                                    </div>
                                    <div class="uom-gv-right">
                                        <ul>
                                            <li><i class="fa fa-angle-double-right"></i> Giảng viên: <strong><?php echo $info_teacher['title'] ?></strong></li>
                                            <li><i class="fa fa-angle-double-right"></i> <span><?php echo count_customers_teacher($DetailProducts['teachersid']) ?></span> học viên</li>
                                            <li><i class="fa fa-angle-double-right"></i> <span><?php echo count_lesson_teacher($DetailProducts['teachersid']); ?></span> khóa học</li>
                                        </ul>
                                        <a href="<?php echo $href_t ?>" class="uct-more-info">Xem thêm thông tin</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="uom-block-aff-share mb20">
                                    <h3>Link chia sẻ khóa học </h3>
                                    <div class="uom-box-share">
                                        <center><div class="title_share">Bạn có thích khóa học này ? Chia sẻ ngay với bạn bè nhé</div></center>
                                        <center><a class="btn btn-facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $canonical ?>"><i class="fa fa-facebook"></i> Chia sẻ facebook</a></center>
                                    </div>
                                </div>
                                <div class="uom-block-aff-share mb20">
                                    <h3>Nội dung khóa học </h3>
                                    <div class="content">
                                    	<?php $stt = 1; ?>
                                        <?php if (isset($chapter) && is_array($chapter) && count($chapter)): ?>
		                                    <?php foreach ($chapter as $keyc => $vals): ?>
		                                        <div class="wp-item-acc">
		                                            <button class="accordion"> Phần <?php echo ($keyc + 1) ?>: <?php echo $vals['title'] ?></button>
		                                            <?php if (isset($vals['page']) && is_array($vals['page']) && count($vals['page'])): ?>
		                                                <div class="panel">
		                                                    <div class="sau-panel">
		                                                        <ul class="ul-b">
		                                                            <?php foreach ($vals['page'] as $keyp => $val): ?>
		                                                                <li class="uk-flex uk-flex-middle uk-flex-space-between">
		                                                                    <div class="wp-item-panel-kh">
		                                                                        <a href="<?php echo site_url('learning/lecture-'.$val['id'].'') ?>">
		                                                                            <i class="fa fa-play-circle" aria-hidden="true"></i>
		                                                                            <span>Bài <?php echo $stt ?>: <?php echo $val['title'] ?></span>
		                                                                        </a>
		                                                                    </div>
		                                                                    <div class="time-hocthu">
		                                                                        <div class="time"><?php echo $val['time'] ?></div>
		                                                                    </div>
		                                                                </li>
		                                                                <?php $stt++; ?>
		                                                            <?php endforeach ?>
		                                                        </ul>
		                                                    </div>
		                                                </div>
		                                            <?php endif ?>
		                                        </div>
		                                    <?php endforeach ?>
				                        <?php endif ?>
                                    </div>
                                </div>
							</div>
						</div>
					</div>

					<div id="baihoc" class="tab-pane fade">
						<div class="col-lg-12">
							<div class="u-list-course mb20">
								<h3>Nội dung khóa học</h3>
								<div class="content">
                                	<?php $stt = 1; ?>
                                    <?php if (isset($chapter) && is_array($chapter) && count($chapter)): ?>
	                                    <?php foreach ($chapter as $keyc => $vals): ?>
	                                        <div class="wp-item-acc">
	                                            <button class="accordion active"> Phần <?php echo ($keyc + 1) ?>: <?php echo $vals['title'] ?></button>
	                                            <?php if (isset($vals['page']) && is_array($vals['page']) && count($vals['page'])): ?>
	                                                <div class="panel" style="height: auto;">
	                                                    <div class="sau-panel">
	                                                        <ul class="ul-b">
	                                                            <?php foreach ($vals['page'] as $keyp => $val): ?>
	                                                            	<?php echo (($keyp == 0) ? '<div id="count_lesson" data-value="'.$val['id'].'"></div>' : '') ?>
	                                                                <li class="uk-flex uk-flex-middle uk-flex-space-between">
	                                                                    <div class="wp-item-panel-kh">
	                                                                        <a href="<?php echo site_url('learning/lecture-'.$val['id'].'') ?>">
	                                                                            <i class="fa fa-play-circle" aria-hidden="true"></i>
	                                                                            <span>Bài <?php echo $stt ?>: <?php echo $val['title'] ?></span>
	                                                                        </a>
	                                                                    </div>
	                                                                    <div class="time-hocthu">
	                                                                    	<?php if (!empty($val['description'])): ?>
	                                                                            <p>
	                                                                                <a data-id="<?php echo $val['id'] ?>" class="btn btn-preview various2">Học thử</a>
	                                                                            </p>
	                                                                        <?php endif ?>
	                                                                        <div class="time"><?php echo $val['time'] ?></div>
	                                                                    </div>
	                                                                </li>
	                                                                <?php $stt++; ?>
	                                                            <?php endforeach ?>
	                                                        </ul>
	                                                    </div>
	                                                </div>
	                                            <?php endif ?>
	                                        </div>
	                                    <?php endforeach ?>
	                                    <script>
			                                $(document).ready(function(){
			                                    $('.various2').click(function(){
			                                        var id = $(this).attr('data-id');
			                                        var formURL = '<?php echo site_url('products/ajax/products/load_modal') ?>';
			                                        $.post(formURL, {id: id},
			                                        function(data){
			                                            var json = JSON.parse(data);
			                                            if(json .error.length){

			                                            }else{
			                                                $('#myModal .modal-body').html('').html(json.result);
			                                                $('#myModal').modal('toggle', {
			                                                    keyboard: false
			                                                });
			                                            }
			                                        });
			                                        return false;
			                                    });
			                                })
			                            </script>
			                        <?php endif ?>
                                </div>
							</div>
						</div>
					</div>

					<div id="tailieu" class="tab-pane fade">
                        <div class="col-lg-12">
                            <div class="uom-block-doc mb20">
                                <h3>Tài liệu khóa học</h3>
                                <ul>
									
	                            </ul>
	                            <div class="note_no_data">Không có tài liệu tương ứng!</div>
                            </div>
                        </div>
                    </div>

                    <div id="hoidap" class="tab-pane fade">
                        <div class="col-lg-12">
                            <div class="u-video-qa-block mb20">
                            	<div class="block_comment_root"></div>
                            	<div class="error uk-alert mb10"></div>
		                        <div class="u-v-q-box">
		                        	<form action="<?php echo site_url('comments/ajax/comments/addquestion'); ?>" method="get" accept-charset="utf-8" id="form_">
			                            <textarea class="form-control" name="question_text" placeholder="Nhập nội dung câu hỏi" rows="2" id="question_text"></textarea>
			                            <button type="submit">Gửi câu hỏi</button>
		                            </form>
		                        </div>
		                        
                    		</div>
                        </div>
                    </div>

				</div>
			</div>
		</div>
	</div>
	<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(function(){
        $('.error').hide();
        var module = '<?php echo $module ?>';
        var moduleid = '<?php echo $moduleid ?>';
        ListQuestion(module, moduleid);
        var uri = $('#form_').attr('action');
        $('#form_').on('submit',function(){
            var text = $('#question_text').val();
            $.post(uri, {
                message: text, module: module, moduleid: moduleid},
                function(data){
                    var json = JSON.parse(data);
                    $('.error').show();
                    if(json.error.length){
                        $('.error').removeClass('uk-alert-success').addClass('uk-alert-danger');
                        $('.error').html('').html(json.error);
                    }else{
                        $('.error').removeClass('uk-alert-danger').addClass('uk-alert-success');
                        $('.error').html('').html('Gửi yêu cầu thành công!.');
                        $('#form_').trigger("reset");
                        setTimeout(function(){ ListQuestion(module, moduleid) }, 3000);
                    }
                });
            return false;
        });

        function ListQuestion(module, moduleid){
	        var uri = '<?php echo site_url('comments/ajax/comments/listQuestion'); ?>';
	        $.post(uri, {
	            module: module, moduleid: moduleid},
	        function(data){
	            var json = JSON.parse(data);
	            $('.block_comment_root').html(json.html);
	            $('.error').hide();
	        });
	    }

    });
</script>
<script>
    function load_href_lesson(){
        var total = parseInt($('#count_lesson').attr('data-value'));
        if (total) {          
            $('#learn-star').attr('href', ''+BASE_URL+'learning/lecture-'+total+'.html');
        }
    }
    $(document).ready(function(){
        load_href_lesson();
    });
</script>