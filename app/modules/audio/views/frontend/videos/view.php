<?php $this->load->view('homepage/frontend/common/slider'); ?>
<div class="main_main">
	<div class="uk-container uk-container-center">
		<div class="main-videos">
			<div class="videos_catalogues">
				<div class="uk-grid uk-grid-collapse uk-flex-middle" style="display: block;">
					<div class="uk-width-large-1-4">
						<?php $this->load->view('homepage/frontend/common/aside'); ?>
					</div>
					<div class="uk-width-large-3-4 pl20">
						<section class="page-content">
							<div class="breadcrumb">
								<ul class="uk-breadcrumb">
									<li><a href="" title=""><i class="fa fa-home"></i> Trang chủ</a></li>
									<?php foreach($Breadcrumb as $key => $val){ ?>
									<?php 
										$title = $val['title'];
										$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues');
									?>

									<li class="uk-active"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
									<?php } ?>
								</ul>
							</div><!-- .breadcrumb -->
							<section class="panel-body">
								<div class="iframe_video border">
									<?php $video_code = explode('?v=', $DetailVideos['videos_code'])[1]; ?>
									<iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?php echo $video_code; ?>" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="meta uk-flex uk-flex-middle">
									<div class="box_video_content">
										<div class="title_video af">
											<?php echo $DetailVideos['title'] ?>
										</div>
										<div class="views_video bg_v" style="width: 110px">
											<?php echo $DetailVideos['viewed'] ?> Lượt xem
										</div>
									</div>
								</div>
								<article class="article">
									<div class="description"><?php echo $DetailVideos['description']; ?> </div>
								</article><!-- .article -->
							</section><!-- .panel-body -->
						</section><!-- .article-detail -->
				
						<?php if(isset($videos_same) && is_array($videos_same) && count($videos_same)){ ?>
						<section class="uk-panel article-related">
							<section class="panel-body">
								<div class="box_videos row10">
								<?php foreach($videos_same as $key => $val){ ?>
								<?php 
									$title = $val['title'];
									$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
									$image = $val['images'];
									$description = cutnchar(strip_tags($val['description']), 250);
								?>
									<div class="uk-width-1-2 col-video-left p10" style="margin-bottom: 20px;">
										<div class="box_out">
											<div class="box_video">
												<div class="bg_opacity"></div>
												<a href="<?php echo $href ?>" title="<?php echo $title ?>">
													<img src="<?php echo $image ?>" alt="<?php echo $title ?>">
												</a>
												<a class="d" href="<?php echo $href ?>"><em>Xem video</em></a>
											</div>
										</div>
										<div class="box_video_content bor">
											<div class="title_video " style="width: 100%; text-align: center;">
												<a href="<?php echo $href ?>" title="<?php echo $title ?>">
													<?php echo $title ?>
												</a>
											</div>
										</div>
									</div>
								<?php } ?>
								</ul>
							</section><!-- .panel-body -->
						</section><!-- .article-related -->
						<?php } ?>
					</div>
				</div>
			</div><!-- .uk-width -->
		</div><!-- .uk-grid -->
	</div><!-- .main-content -->
</div><!-- .uk-container -->