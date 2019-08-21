<div id="body" class="body-container">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center"> 
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
					<i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a>
				</li>
				<?php foreach($Breadcrumb as $key => $val){ ?>
					<?php 
						$title = $val['title'];
						$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'projects_catalogues');
					?>
					<li class="uk-active">
						<a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mb20">
			<div class="uk-width-large-2-3">
				<section class="estate-detail mb15">
					<section class="panel-body">
						<div class="dv-ct-detail bor_bottom mb10">
		                    <h1 class="mb0"><?php echo $DetailProjects['title']; ?></h1>
		                </div>
		                <div class="meta_time mb5">
		                	Đăng ngày: <?php echo gettime($DetailProjects['created']) ?> - Số lượt xem: <?php echo $DetailProjects['viewed']; ?>
		                </div>
						<?php $list = $this->configbie->data('measure'); ?>
						<?php $list_1 = $this->configbie->data('floor'); ?>
						<div class="price_code mb10 uk-flex uk-flex-middle uk-flex-space-between">
							<div class="price">
								<span class="label">Giá:</span> 
								<span class="value"><b class="red"><?php echo $DetailProjects['price'].'</b> '.$list[$DetailProjects['measure']]; ?></span>
								<span> - Diện tích: <b class="red"><?php echo $DetailProjects['price'] ?></b> m²</span>
							</div>
							<div class="code uk-clearfix"><span class="label">Mã số tài sản:</span> <span class="value"><?php echo $DetailProjects['code']; ?></span></div>
						</div>
						<div class="bor_bottom mb10"></div>
						<?php 
							$city = $this->Autoload_Model->_get_where(array(
								'select' => '*',
								'table' => 'province',
								'where' => array('id' => $DetailProjects['cityid'])
							));
							$district = $this->Autoload_Model->_get_where(array(
								'select' => '*',
								'table' => 'province',
								'where' => array('id' => $DetailProjects['districtid'])
							));
						?>
						<div class="meta">
							<?php if(isset($attribute) && is_array($attribute) && count($attribute)){ ?>
							<?php foreach($attribute as $key => $val){ ?>
							<?php if($val['keyword'] != 'loai-tin') continue; ?>
							<?php if(isset($val['attr']) && is_array($val['attr']) && count($val['attr'])){ ?>
							<?php foreach($val['attr'] as $keyAttr => $valAttr){ ?>
								<b><?php echo $valAttr['title']; ?></b> 
							<?php }}}} ?>
						</div>
						<div class="gallerys_excerpt">
							<div class="uk-grid lib-grid-0">
								<div class="uk-width-large-1-2">
									<script>
							    		$(document).ready(function() {
											$("#content-slider").lightSlider({
								                loop:true,
								                keyPress:true
								            });
								            $('#image-gallery').lightSlider({
								                gallery:true,
								                item:1,
								                thumbItem:6,
								                slideMargin: 0,
								                speed:2500,
								                auto:false,
								                loop:true,
								                onSliderLoad: function() {
								                    $('#image-gallery').removeClass('cS-hidden');
								                }  
								            });
										});
								    </script>
									<div class="gallerys mb10">
										<div class="slider">
											<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
												<li data-thumb="<?php echo $DetailProjects['images']; ?>">
						                        	<a href="<?php echo $DetailProjects['images']; ?>" data-uk-lightbox="{group:'gallerys'}" class="img-cover image" title="<?php echo $DetailProjects['title'] ?>">
						                        		<img src="<?php echo $DetailProjects['images']; ?>" alt="<?php echo $DetailProjects['title'] ?>" />
						                        	</a>
						                        </li>
												<?php $album = json_decode($DetailProjects['albums'], TRUE); ?>
												<?php if(isset($album) && is_array($album) && count($album)){ ?>
													<?php foreach($album as $key => $val){ ?>
														<?php if ($val['images'] == '') continue; ?>
														<li data-thumb="<?php echo $val['images']; ?>">
								                        	<a href="<?php echo $val['images']; ?>" data-uk-lightbox="{group:'gallerys'}" class="img-cover image" title="<?php echo $val['title'] ?>">
								                        		<img src="<?php echo $val['images']; ?>" alt="<?php echo $val['title'] ?>" />
								                        	</a>
								                        </li>
													<?php } ?>
												<?php } ?>
							                </ul>
										</div>
									</div><!-- .gallerys -->
									<?php if (isset($User_post) && is_array($User_post) && count($User_post)) { ?>
										<div class="members_box">
											<div class="line_name mb5 uk-flex lib-grid-10 uk-flex-middle">
												<div class="avatar_members">
													<img src="<?php echo $User_post['avatar'] ?>" alt="<?php echo $User_post['fullname'] ?>">
												</div>
												<div class="right_avatar">
													<div class="name_members">
														<?php echo $User_post['fullname'] ?>
													</div>
													<div class="uk-flex lib-grid-10 list-item-chat">
														<a title="Chat Skype" href="skype:<?php echo $User_post['skype'] ?>?chat">
															Chat Skype: <i class="fa fa-skype"></i>
														</a>
													</div>
												</div>
											</div>
											<div class="line_name bor mb5">
												<i class="fa fa-user-secret" aria-hidden="true"></i>
												<span class="blue">Công Ty Nhà Đất - Môi Giới BĐS</span>
											</div>
											<div class="line_name bor mb5">
												<i class="fa fa-map-marker" aria-hidden="true"></i>
												<span class="blue"><?php echo $User_post['address'] ?></span>
											</div>
											<div class="line_name bor">
												<i class="fa fa-mobile" aria-hidden="true"></i>
												<span class="blue"><?php echo $User_post['phone'] ?></span>
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="uk-width-large-1-2">
									<ul class="uk-list list">
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Diện tích:</span>
											<span class="value blue"><b class="red"><?php echo (($DetailProjects['area'] != 0) ? $DetailProjects['area'].'</b> m²' : 'Chưa xác định') ?></span>
										</li>
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Giá bán:</span>
											<span class="value blue"><b class="red"><?php echo $DetailProjects['price'].'</b> '.$list[$DetailProjects['measure']]; ?></span>
										</li>
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Tỉnh thành</span>
											<span class="value blue"><?php echo $city['title']; ?></span>
										</li>
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Quận huyện:</span>
											<span class="value blue"><?php echo $district['title']; ?></span>
										</li>
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Vị trí:</span>
											<span class="value blue"><?php echo $DetailProjects['address']; ?></span>
										</li>
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Dự án:</span>
											<span class="value blue">
												<?php echo Load_place($DetailProjects['projectid'], $DetailProjects['wardid'], $DetailProjects['districtid']) ?>
											</span>
										</li>
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Loại BDS:</span>
											<span class="value blue"><?php echo Load_catagoies($DetailProjects['cataloguesid']) ?></span>
										</li>
										<li class="uk-flex uk-flex-middle line_item">
											<span class="label">Hướng nhà:</span> 
											<span class="value"><?php echo (($DetailProjects['floor'] != 0) ? $list_1[$DetailProjects['floor']] : 'Chưa xác định') ?></span>
										</li>
									</ul>
									<div class="share uk-flex uk-flex-middle mt10 ml5">
										<div class="share-box uk-flex uk-flex-middle"> 
											<?php links_share(); ?>
										</div><!-- end .share-box -->
									</div>
								</div>
							</div><!-- .uk-grid -->
						</div><!-- .gallerys_excerpt -->
						<div class="content mt15">
							<div class="title"><span>Mô tả chi tiết</span></div>
							<div class="description">
								<?php echo $DetailProjects['content']; ?>
							</div>
						</div>
					</section><!-- .panel-body -->
				</section><!-- .estate-detail -->

				<section class="estate-same">
					<?php if (isset($vip) && is_array($vip) && count($vip)) { ?>
	                    <section class="homepage-projects-small mb15 Vip">
	                        <header class="panel-head">
	                            <h3 class="heading uk-flex uk-flex-middle uk-flex-space-between">
	                                <a class="uk-text-uppercase" title="Tin Vip">Tin nổi bật</a>
	                            </h3>
	                        </header>
	                        <?php $list = $this->configbie->data('measure'); ?>
	                        <section class="panel-body box-padding-background">
	                            <ul class="uk-grid lib-grid-0 uk-grid-width-1-1 list-projects">
	                                <?php foreach ($vip as $key => $val) { ?> 
	                                    <?php  
	                                        $title = $val['title'];
	                                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'projects');
	                                        $image = getthumb($val['images'], FALSE);
	                                        $description = cutnchar(strip_tags($val['content']), 350);
	                                        $price = $val['price'];
	                                        if ($price > 0) {
	                                            $gia = $price.' '.$list[$val['measure']];
	                                        }
	                                        else
	                                        {
	                                            $gia = 'Thỏa thuận';
	                                        }
	                                    ?>
	                                    <li>
	                                        <div class="projects uk-flex lib-grid-10 Vip">
	                                            <i class="i-bds-cc-1"></i>
	                                            <div class="thumb">
	                                                <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $title ?>">
	                                                    <img src="<?php echo $image; ?>" alt="<?php echo $val['title'] ?>" />
	                                                </a>
	                                            </div>
	                                            <div class="infor">
	                                                <h4 class="title"><a class="<?php echo ((in_array($val['id'], $prd_arr)) ? 'active-link' : 'normal') ?>" href="<?php echo $href ?>" title="<?php echo $title ?>">
	                                                <?php echo $title ?></a></h4>
	                                                <div class="time_create">
	                                                    <?php echo $val['created'] ?>
	                                                </div>
	                                                <div class="projects_desc">
	                                                    <?php echo $description.' <a href="'.$href.'" title="Xem tiếp">Xem tiếp</a>' ?>
	                                                </div>
	                                                
	                                                <div class="uk-flex uk-flex-space-between lib-grid-10 uk-flex-middle list-item-projects">
	                                                    <div class="price_projects blue">
	                                                        Giá: <span class="red"><?php echo $gia ?></span>
	                                                    </div>
	                                                    <div class="area_projects blue">
                                                            - <span class="red"><?php echo $val['area'] ?></span> m²
                                                        </div>
	                                                    <div class="area_projects blue">
	                                                        - <span>
	                                                            <?php echo Load_catagoies($val['cataloguesid']) ?>
	                                                        </span>
	                                                    </div>
	                                                    <div class="place_projects blue">
	                                                        - <span>
	                                                            <?php echo Load_place($val['projectid'], $val['wardid'], $val['districtid']) ?>
	                                                        </span>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div><!-- .product -->
	                                    </li>
	                                <?php } ?>
	                            </ul>
	                        </section><!-- .panel-body -->
	                    </section><!-- .top-content -->
	                <?php } ?>

	                <?php if (isset($projects_same) && is_array($projects_same) && count($projects_same)) { ?>
                        <section class="homepage-projects-small mb15">
                            <header class="panel-head">
                                <h3 class="heading">
                                    <span>Có thể bạn quan tâm</span>
                                </h3>
                            </header>
                            <?php $list = $this->configbie->data('measure'); ?>
                            <section class="panel-body box-padding-background">
                                <ul class="uk-grid lib-grid-0 uk-grid-width-1-1 list-projects">
                                    <?php foreach ($projects_same as $key => $val) { ?> 
                                        <?php  
                                            $title = $val['title'];
                                            $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'projects');
                                            $image = getthumb($val['images'], FALSE);
                                            $description = cutnchar(strip_tags($val['content']), 350);
                                            $price = $val['price'];
                                            if ($price > 0) {
                                                $gia = $price.' '.$list[$val['measure']];
                                            }
                                            else
                                            {
                                                $gia = 'Thỏa thuận';
                                            }
                                        ?>
                                        <li class="<?php echo (($val['isaside'] == 1) ? 'Vip' : '') ?>">
                                            <div class="projects uk-flex lib-grid-10">
                                                <div class="thumb">
                                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $title ?>">
                                                        <img src="<?php echo $image; ?>" alt="<?php echo $val['title'] ?>" />
                                                    </a>
                                                </div>
                                                <div class="infor">
                                                    <h4 class="title"><a class="<?php echo ((in_array($val['id'], $prd_arr)) ? 'active-link' : 'normal') ?>" href="<?php echo $href ?>" title="<?php echo $title ?>">
                                                    <?php echo $title ?></a></h4>
                                                    <div class="time_create">
                                                        <?php echo $val['created'] ?>
                                                    </div>
                                                    <div class="projects_desc">
                                                        <?php echo $description.' <a href="'.$href.'" title="Xem tiếp">Xem tiếp</a>' ?>
                                                    </div>
                                                    
                                                    <div class="uk-flex uk-flex-space-between lib-grid-10 uk-flex-middle list-item-projects">
                                                        <div class="price_projects blue">
                                                            Giá: <span class="red"><?php echo $gia ?></span>
                                                        </div>
                                                        <div class="area_projects blue">
                                                            - <span class="red"><?php echo $val['area'] ?></span> m²
                                                        </div>
                                                        <div class="area_projects blue">
                                                            - <span>
                                                                <?php echo Load_catagoies($val['cataloguesid']) ?>
                                                            </span>
                                                        </div>
                                                        <div class="place_projects blue">
                                                            - <span>
                                                                <?php echo Load_place($val['projectid'], $val['wardid'], $val['districtid']) ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .product -->
                                        </li>
                                    <?php } ?>
                                </ul>
                            </section><!-- .panel-body -->
                        </section><!-- .top-content -->
	                <?php } ?>
				</section><!-- .estate-same -->
			</div>
			<div class="uk-width-large-1-3">
                <?php $this->load->view('homepage/frontend/common/aside'); ?>
            </div>
		</div>
	</div>
</div>