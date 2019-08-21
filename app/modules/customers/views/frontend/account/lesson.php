<section class="page-content" id="customers">
	<div class="top_barr">
		<div class="container">
			<div class="relative">
				<div class="title_name_members">Học viên: <?php echo $this->fcCustomer['fullname'] ?></div>
				<ul class="nav nav-tabs">
                    <li class="active">
                    	<a href="<?php echo site_url('my-lesson') ?>"><i class="fa fa-book" aria-hidden="true"></i> Khóa học</a>
                	</li>
                    <li>
                    	<a href="<?php echo site_url('my-profile') ?>"><i class="fa fa-user" aria-hidden="true"></i> Hồ sơ cá nhân</a>
                    </li>
                    <li class="hiden-md hidden-sm ">
                        <a href="<?php echo site_url('my-payment') ?>"><i class="fa fa-money" aria-hidden="true"></i> Nạp tiền</a>
                    </li>
					<li class="hidden-md hidden-sm ">
                        <a href="<?php echo site_url('my-order') ?>"> <i class="fa fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
                    </li>
                    <li class="hidden-lg btn-group hidden-xs pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Thêm  <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="hidden-lg hidden-md "><a href="<?php echo site_url('my-payment') ?>"><i class="fa fa-money" aria-hidden="true"></i> Nạp tiền</a></li>
                            <li><a href="<?php echo site_url('my-order') ?>" class=""> <i class="fa fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a></li>
                        </ul>
                    </li>
                </ul>
			</div>
		</div>
	</div>
	<div class="main-content">
		<div class="container">
           	<div class="main-inner">
                <div class="panel panel-default">
                 	<div class="panel-heading"> <span style="font-weight: bold;"><i class="fa fa-book" aria-hidden="true"></i> Khóa học của tôi </span> </div>
                 	<div class="panel-body pdXS0">
                      	<div class="container-fluid">
                           	<div class="row">
								<form action="" method="get" name="search_form" class="row">
									<div class="col-lg-6 col-md-6 col-sm-9 pdS8">
										 <div class="form-group">
											<div class="searchBox">
												<input name="keyword" value="<?php echo ((!empty($this->input->get('keyword'))) ? $this->input->get('keyword') : '') ?>" placeholder="Nhập tên khóa học" class="form-control" type="text">
											</div>
										 </div>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-3 pdS7"> 
										<button type="submit" title="Tìm kiếm" class="btn btn-primary btnnomal"><i class="fa fa-search"></i> Tìm kiếm</button> 
									</div>
								</form>
								<div class="clearfix"></div>
                            	<div id="w0" class="list-view">
                            		<?php if (isset($ListLesson) && is_array($ListLesson) && count($ListLesson)) { ?>
                            			<section class="lesson-list">
                            				<?php foreach ($ListLesson as $key => $val): ?>
                                                <?php $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_overview'); ?>
                            					<div class="item_lesson uk-grid uk-flex-middle">
                            						<div class="col-lg-2 col-md-2 hidden-sm col-xs-12 p10">
                            							<a title="<?php echo $val['title'] ?>" href="<?php echo $href ?>" class="imgBox">
                                                            <img class="thumb" src="<?php echo $val['images'] ?>" alt="<?php echo $val['title'] ?>">
                                                        </a>
                            						</div>
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p10">
                                                        <div class="infor">
                                                            <h3 class="title">
                                                                <a title="<?php echo $val['title'] ?>" href="<?php echo $href ?>"><?php echo $val['title'] ?></a>
                                                            </h3>
                                                        </div>
                                                        <div class="description">                                                                
                                                            <span>Giảng viên: <?php echo $val['teachers_title'] ?></span>
                                                            <span>Học viên:  <?php echo counthocvien($val['id']) ?> </span>
                                                        </div>      
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p10">
                                                        <div class="description">
                                                            <div class="meta_">Bài giảng: <?php echo countlesson($val['id']) ?> bài</div>
                                                            <div class="meta_">Thời lượng: <?php echo $val['code'] ?></div>
                                                        </div>     
                                                    </div>
                                                    <div class="col-lg-2 col-md-1 col-sm-1 col-xs-12 p10" style="vertical-align: middle;">
                                                        <div id="btnnomal">
                                                            <a title="<?php echo $val['title'] ?>" style="width: 100%;" href="<?php echo $href ?>" class="btn btn-primary btnnomal">Vào học ngay</a>
                                                        </div>
                                                    </div>
                            					</div>
                            				<?php endforeach ?>
                            			</section>
                            		<?php }else{ ?>
                            			<div class="empty">Không tìm thấy kết quả nào.</div>
                            		<?php } ?>
                            	</div>                                                                           
                            </div>
                      	</div>
                 	</div>
                 	<div class="clearfix"></div>
                </div>
           	</div>
     	</div>
	</div>	
</section>