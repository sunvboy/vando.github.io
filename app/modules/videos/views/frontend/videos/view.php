<div id="videos-page" class="body-container">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo BASE_URL ?>" title="<?php echo $this->lang->line('home_page') ?>">
						<?php echo $this->lang->line('home_page'); ?>
					</a>
				</li>
				<?php foreach($Breadcrumb as $key => $val){ ?>
					<?php 
						$title = $val['title'];
						$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'videos_catalogues');
					?>
					<li class="uk-active">
						<a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="main-videos mt30">
		<div class="uk-container uk-container-center">
			<div class="uk-grid uk-grid-medium homepage">
		        <div class="uk-width-large-3-4 uk-push-3-4">
					<section class="page-content">
						<header class="heading">
							<h1 class="heading-heading">
								<span><?php echo $DetailVideos['title'] ?></span>
							</h1>
						</header>	
						<section class="panel-body">
							<div class="iframe_video border">
								<?php $video_code = explode('?v=', $DetailVideos['videos_code']); ?>
								<iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?php echo $video_code[1]; ?>" frameborder="0" allowfullscreen></iframe>
							</div>
							<div class="meta uk-flex uk-flex-middle mt20 uk-flex-space-between">
								<div class="views_video">
		                            <span>Ngày đăng: <?php echo show_time($DetailVideos['created'], 'Y-m-d') ?></span>
								</div>
								<div class="views_video">
									<?php echo $DetailVideos['viewed'] ?> lượt xem
								</div>
							</div>
							<article class="article" style="display: none;">
								<div class="description"><?php echo $DetailVideos['description']; ?> </div>
							</article><!-- .article -->
						</section><!-- .panel-body -->
					</section><!-- .article-detail -->
			
					<?php if(isset($videos_same) && is_array($videos_same) && count($videos_same)){ ?>
						<section class="uk-panel article-related mt20 ">
							<header class="heading">
								<h1 class="heading-heading">
									<span>Videos khác</span>
								</h1>
							</header>	
							<section class="panel-body">
								<ul class="uk-grid lib-grid-30 uk-grid-width-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 list-video" data-uk-grid-match="{target: '.featured .entry-title'}"> 
									<?php foreach($videos_same as $key => $val) { ?>
									<?php 
										$title = $val['title'];
										$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'videos');
										$image = getthumb($val['images'], FALSE); 
										$description = cutnchar(strip_tags($val['description']), 250);
									?>
									<li class="mb30">
										<div class="featured">
											<div class="box-image">
			                                    <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $title ?>">
			                                        <img src="<?php echo $image ?>" alt="<?php echo $title ?>" />
			                                        <span class="player_"></span>
			                                    </a>
			                                </div>
			                                <div class="box_video_item">
			                                    <h3 class="entry-title">
			                                        <a href="<?php echo $href ?>" title="<?php echo $title ?>">
			                                            <?php echo $title ?>
			                                        </a>
			                                    </h3>
			                                </div>
			                            </div>
			                        </li>
									<?php } ?>
								</ul><!-- .list-videos -->
							</section><!-- .panel-body -->
						</section><!-- .videos-related -->
					<?php } ?>
				</div>
				<div class="uk-width-large-1-4 mt20 uk-pull-3-4">
		            <?php $this->load->view('homepage/frontend/common/aside') ?>
		        </div>
			</div>
		</div><!-- .uk-width -->
	</div><!-- .main-content -->
</div><!-- .uk-container -->