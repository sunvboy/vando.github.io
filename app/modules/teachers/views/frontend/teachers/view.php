<div id="teachers-page" class="page-body">
	<div class="u-teacher-top">
        <div class="container">
            <div class="row">
                <div class="utt-bot">
                    <div class="container">
                        <div class="row uk-grid uk-flex-middle">
                            <div class="col-lg-6 col-md-7 col-sm-8 col-xs-12 padNo">
                                <div class="u-teacher-left">
                                    <div class="u-teacher-avatar">
                                        <img src="<?php echo $DetailTeachers['images'] ?>" alt="" width="160px" height="160px">
                                    </div>
                                    <div class="u-teacher-info">
                                        <h4 class="title"> <?php echo $DetailTeachers['title'] ?> </h4>
                                        <span><?php echo $DetailTeachers['chucvu'] ?></span>
	                                    <div class="uti-link">
	                                        <a target="_blank" href="<?php echo $DetailTeachers['facebook'] ?>"> <i class="fa fa-facebook-official" aria-hidden="true"></i> Follow mình </a>
	                                        <a target="_blank" href="<?php echo $DetailTeachers['messenger'] ?>"> <i class="fa fa-commenting-o" aria-hidden="true"></i> Nhắn cho mình </a>
	                                    </div>
	                                </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-sm-4 hidden-xs padNo">
                                <div class="u-teacher-right">
                                    <ul>
                                        <li>
                                            <p><?php echo count_lesson_teacher($DetailTeachers['id']); ?></p>
                                            <span>khóa học</span>
                                        </li>
                                        <li>
                                            <p><?php echo count_customers_teacher($DetailTeachers['id']) ?></p>
                                            <span>học viên</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="u-bread">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="unica-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="."><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">Giảng viên</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
    	<div class="u-teacher-box">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="u-teacher-intro">
                            <h3>Giới thiệu</h3>
                            <?php echo $DetailTeachers['description'] ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="u-teacher-video">
                            <?php echo $DetailTeachers['video'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="u-box-course">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
						<div class="u-box-course-teacher">
                            <h2>Các khóa học</h3>
                            <?php if (isset($Listproducts) && is_array($Listproducts) && count($Listproducts)): ?>
                            	<?php foreach ($Listproducts as $key => $val): ?>
                            		<?php 
                                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products'); 
                                        $price = $val['price'];
                                        $saleoff = $val['saleoff'];
                                        if ($price > 0) {
                                            $pri_old = str_replace(',', '.', number_format($price)).'<sup>đ</sup>';
                                        }else{
                                            $pri_old  = 'Liên hệ';
                                        }
                                        if ($saleoff > 0) {
                                            $pri_sale = str_replace(',', '.', number_format($saleoff)).'<sup>đ</sup>';
                                        }else{
                                            $pri_sale  = '';
                                        }
                                        $sale_value = ceil((($price - $saleoff)/$price)*100);
                                    ?>
		                            <div class="ubc-course">
		                                <div class="img-ubc-course">
		                                    <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
		                                    	<img class="img-responsive" src="<?php echo $val['images'] ?>" alt="<?php echo $val['title'] ?>">
		                                    </a>
		                                </div>
		                                <div class="des-ubc-course">
		                                    <h4><a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h4>
		                                    <ul class="mini-des">
		                                        <li><i class="fa fa-list-alt" aria-hidden="true"></i> <?php echo countlesson($val['id']) ?> bài giảng</li>
		                                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $val['code'] ?></li>
		                                    </ul>
		                                    <div class="description"><?php echo cutnchar(strip_tags($val['description']), 400) ?></div>
		                                </div>
		                                <div class="lp-bc-price price">
		                                	<div class="relative">
												<?php if (!empty($saleoff) && !empty($price) && $saleoff < $price){ ?>
	                                                <span class="sell-price"><?php echo $pri_sale ?></span>
	                                                <span class="old-price"><?php echo $pri_old ?></span>
	                                                <div class="clearfix"></div>
	                                                <span class="discount person">- <?php echo $sale_value ?>%</span>
	                                                <div class="clearfix"></div>
	                                            <?php }else{ ?>
	                                                <span class="sell-price"><?php echo $pri_old ?></span>
	                                            <?php } ?>
                                            </div>
                                            <div class="view_detail">
			                                	<a data-id="<?php echo $val['id'] ?>" data-quantity="1" title="Đăng ký khóa học" class="ajax-addtocart" data-mudule="redirect">Đăng ký học</a>
			                                </div>
		                                </div>
		                            </div>
		                        <?php endforeach ?>
                           	<?php endif ?>
                        </div>
                    </div>                              
                </div>
            </div>
        </div>
    </main>
</div>