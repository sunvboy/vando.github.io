<div id="body" class="body-container">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center"> 
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
					<i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a>
				</li>
				<li class="uk-active">
					<a href="javascript: void(0)" title="Dự án">Tìm kiếm</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mb20">
			<div class="uk-width-large-2-3">
				<section class="main-content big">
					<section class="project-catalogue">
						<header class="panel-head">
							<h1 class="heading-2"><span>Tìm kiếm</span></h1>
						</header>
						<?php $list = $this->configbie->data('measure'); ?>
						<?php if(isset($projectsList) && is_array($projectsList) && count($projectsList)){ ?>
							<section class="panel-body">
								<ul class="uk-grid lib-grid-0 uk-grid-width-1-1 list-projects">
									<?php foreach ($projectsList as $key => $val) { ?> 
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
                                            if (isset($prd_arr) && is_array($prd_arr) && count($prd_arr)) {
                                                $active = ((in_array($val['id'], $prd_arr) == TRUE) ? 'active-link' : 'normal');
                                            }else{
                                                $active = '';
                                            }
                                        ?>
                                        <li class="<?php echo (($val['isaside'] == 1) ? 'Vipbg' : '') ?>">
                                            <div class="projects uk-flex lib-grid-10 <?php echo (($val['isaside'] == 1) ? 'Vip' : '') ?>">
                                            	<?php echo (($val['isaside'] == 1) ? '<i class="i-bds-cc-1"></i>' : '') ?>
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
								<?php echo (isset($PaginationList)) ? $PaginationList: ''; ?>
							</section><!-- .panel-body -->
						<?php } ?>
					</section><!-- .project-catalogue -->
				</section><!-- .main-content -->
			</div>
			<div class="uk-width-large-1-3">
				<?php $this->load->view('homepage/frontend/common/aside');  ?>
			</div>
		</div>
	</div><!-- .wrapper -->
</div><!-- .page-body -->