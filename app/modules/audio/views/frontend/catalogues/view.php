<div id="body" class="body-container">
	<?php $this->load->view('homepage/frontend/common/slider'); ?>
	<div class="uk-container uk-container-center">
		<div class="main-videos">
			<div class="videos_catalogues">
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
					<div class="header-intro mb10">
                        <h1 class="introduction-title">
                            <span><?php echo $DetailCatalogues['title'] ?></span>
                        </h1>
                    </div>
					<?php if(isset($audioList) && is_array($audioList) && count($audioList)){ ?>
					<div class="uk-grid uk-grid-width-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 list-video" data-uk-grid-match="{target: '.box_video_item .entry-title'}"> 
						<?php foreach($audioList as $key => $val) { ?>
						<?php 
							$title = $val['title'];
							$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'videos');
							$image = getthumb($val['images'], FALSE); 
						?>
							<div class="featured uk-text-center mb30">
                                <div class="box_audio_item">
                                    <div class="box-frame">
                                        <audio controls>
                                            <source src="<?php echo $val['audio_link'] ?>" type="audio/mpeg">
                                        </audio> 
                                    </div>
                                    <h3 class="entry-title">
                                        <span><?php echo $title ?></span>
                                    </h3>
                                </div>
                            </div>
						<?php } ?>
					</div><!-- .list-article -->
					<?php } ?>
					<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
				</section><!-- .article-catalogue-->
			</div>
		</div>
	</div>
</div>