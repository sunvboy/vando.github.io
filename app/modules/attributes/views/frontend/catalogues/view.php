<section class="index-navigation margin-bottom-25px">
	<div class="uk-container uk-container-center">
		<div class="fc-breadcrumb uk-margin-bottom uk-margin-top">
			<ul class="uk-breadcrumb uk-margin-remove">
				<li><a href="<?php echo base_url(); ?>" title="<?php echo 'Trang chủ'; ?>">Trang chủ</a></li>
				<?php if(isset($Breadcrumb) && is_array($Breadcrumb) && count($Breadcrumb)){ ?>
				<?php foreach($Breadcrumb as $key => $val){ ?>
				<?php 
					$title = $val['title'];
					$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues');
				?>
				<li><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
				<?php } ?>
				<?php } ?>
			</ul>
		</div><!-- .fc-breadcrumb -->

		<div class="uk-grid uk-grid-medium">
			<?php $this->load->view('homepage/frontend/common/article_aside'); ?>

			<div class="uk-width-3-4">
				<div class="uk-panel article-catalogue-panel">
					<div class="uk-panel-title"><div class="heading"><span><?php echo $DetailCatalogues['title']; ?></span></div></div>
					<?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)){ ?>
					<div class="fc-panel-body">
					<?php foreach($ArticlesList as $key => $val){ ?><?php 
						$title = $val['title'];
						$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
						$image = getthumb($val['images']);
						$description = cutnchar(strip_tags($val['description']), 250);
						$created = show_time($val['created'], 'd/m/Y');
					?>
						<article class="fc-article">
							<div class="uk-grid uk-grid-medium">
								<div class="uk-width-medium-1-3 uk-margin-bottom"><div class="fc-article-thumb"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="fc-crop-center-img-h"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a></div></div>
								<div class="uk-width-medium-2-3 uk-margin-bottom">
									<div class="fc-article-title uk-margin-small-bottom"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="uk-text-bold"><?php echo $title; ?></a></div>
									<div class="fc-article-meta uk-margin-bottom"><span class="uk-text-muted"><?php echo $created; ?></span></div>
									<div class="fc-article-lead uk-margin-bottom"><p><?php echo $description; ?></p></div>
									<div class="fc-article-readmore"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="uk-button">Đọc tiếp</a></div>
								</div>
							</div>
						</article><!-- .fc-article -->
					<?php } ?>
						<<?php echo ((isset($PaginationList)) ? $PaginationList : ''); ?>
					</div><!-- .fc-panel-body -->
					<?php } ?>
				</div><!-- .uk-panel -->
			</div><!-- .uk-width -->
		</div><!-- .uk-grid -->
	</div><!-- .uk-container -->
</section><!-- .index-navigation -->