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
		        <div class="uk-width-large-3-4 mb20 uk-push-1-4">
					<div class="videos_catalogues">
						<header class="panelhead uk-hidden">
							<h1 class="heading"><span><?php echo $DetailCatalogues['title'] ?></span></h1>
						</header>
						<section class="panel-body">
							<?php if(isset($videosList) && is_array($videosList) && count($videosList)){ ?>
								<ul class="uk-grid lib-grid-30 uk-grid-width-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 list-video" data-uk-grid-match="{target: '.featured .entry-title'}"> 
									<?php foreach($videosList as $key => $val) { ?>
									<?php 
										$title = $val['title'];
										$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'videos');
										$image = getthumb($val['images'], FALSE); 
										$description = cutnchar(strip_tags($val['description']), 250);
									?>
									<li class="mb30">
										<div class="featured uk-text-center">
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
								<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
							<?php } ?>
						</section><!-- .article-catalogue-->
					</div>
				</div>
				<div class="uk-width-large-1-4 mb20 uk-pull-3-4">
		            <?php $this->load->view('homepage/frontend/common/aside') ?>
		        </div>
			</div>
		</div>
	</div>
</div>