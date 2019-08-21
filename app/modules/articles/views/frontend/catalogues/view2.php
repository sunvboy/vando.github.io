<div id="article-page" class="page-body">
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mt25 homepage">
			<div class="uk-width-large-2-3">
				<section class="article-page bg_white shadow_box mb25">
					<div class="breadcrumb">
						<ul class="uk-breadcrumb">
							<li>
								<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
									<?php echo $this->lang->line('home_page') ?>
								</a>
							</li>
							<?php foreach($Breadcrumb as $key => $val){ ?>
								<?php 
									$title = $val['title'];
									$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues');
								?>
								<li class="uk-active">
									<a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
								</li>
							<?php } ?>
						</ul>
					</div>
					<header class="panel-head">
						<h1 class="heading relative"><span><?php echo $DetailCatalogues['title'] ?></span></h1>
					</header>
					<section class="panel-body" style="font-style: italic">
						<?php echo $DetailCatalogues['description'] ?>
					</section>
				</section>
					
				<?php if(isset($catalogues_child) && is_array($catalogues_child) && count($catalogues_child)){ ?>
					<?php foreach($catalogues_child as $key => $vals) { ?> 
						<?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles_catalogues'); ?>
						<?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
							<section class="article-page bg_white shadow_box mb25">
								<header class="panel-head">
									<h2 class="heading relative uk-flex-middle uk-flex uk-flex-space-between">
										<a href="<?php echo $hrefC ?>"><?php echo $vals['title'] ?></a>
										<a href="<?php echo $hrefC ?>" class="redect_link">Xem tất cả</a>
									</h2>
								</header>
								<section class="panel-body">
									<ul class="uk-list list-catalogues-child">
										<?php foreach ($vals['post'] as $keyp => $val) { ?>
											<?php 
												$title = $val['title'];
												$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
												$image = getthumb($val['images'], TRUE);
												$created = show_time($val['created'], 'd/m/Y');
												$description = cutnchar(strip_tags($val['description']), 450);
												$catalogues = Load_catagoies(json_decode($val['catalogues'], TRUE), 'articles');
											?>
											<li>
												<?php if ($keyp == 0){ ?>
													<div class="header">
	                                                    <h3 class="main-title">
															<a href="<?php echo $href ?>" title="<?php echo $title ?>">
				                                                <?php echo $title ?>
				                                            </a>
														</h3>
	                                                    <div class="meta-view mb10">
	                                                        <?php if (isset($catalogues) && is_array($catalogues) && count($catalogues)): ?>Danh mục: 
	                                                            <?php foreach ($catalogues as $key => $valss) { ?>
	                                                                <strong><?php echo $valss['title'] ?></strong>
	                                                            <?php } ?>
	                                                        <?php endif ?>
	                                                        <?php echo ' - '.$val['viewed'].' lượt xem'; ?>
	                                                    </div>
	                                                </div>
													<div class="uk-clearfix category">
					                                	<div class="thumb">
		                                                    <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $title ?>">
		                                                        <img src="<?php echo $image ?>" alt="<?php echo $title ?>">
		                                                    </a>
		                                                </div>
		                                                <div class="infor">
		                                                    <div class="description">
		                                                        <?php echo $description; ?>
		                                                    </div>
		                                                    <div class="view_detail">
		                                                        <a href="<?php echo $href ?>" title="<?php echo $title ?>">Xem thêm</a>
		                                                    </div>
		                                                </div>
													</div>
												<?php }else{ ?>
													<a href="<?php echo $href ?>" title="<?php echo $title ?>">
		                                                <?php echo $title ?>
		                                            </a>
												<?php } ?>
											</li>
										<?php } ?>
									</ul>
								</section>
							</section>
						<?php endif ?>
                    <?php } ?>
				<?php } ?>
			</div>
			<div class="uk-width-large-1-3 uk-visible-large">
				<?php $this->load->view('homepage/frontend/common/aside'); ?>
			</div>
		</div>
	</div>
</div> <!-- .mainContent -->