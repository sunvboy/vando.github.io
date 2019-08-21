<section class="fc-breadcrumb margin-bottom-10px">
	<div class="uk-container uk-container-center">
		<ul class="uk-breadcrumb uk-margin-remove">
			<li><a href="<?php echo base_url(); ?>" title="Trang chủ"><i class="uk-icon-home"></i></a></li>
			<?php if(isset($Breadcrumb) && is_array($Breadcrumb) && count($Breadcrumb)){ ?>
		<?php foreach($Breadcrumb as $key => $val){ ?>
		<?php 
			$title = $val['title'];
			$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 	'articles_catalogues');
		?>
			<li><?php echo $title; ?></li>
		<?php } ?>
		<?php } ?>
		</ul>
	</div><!-- .uk-container -->
</section><!-- .fc-breadcrumb -->

<section class="index-news uk-margin-bottom">
	<div class="uk-container uk-container-center">
		<div class="uk-panel">
			<div class="uk-panel-title uk-margin-small-bottom"><h3 class="heading uk-clearfix uk-margin-remove"><span><?php echo $DetailArticles['title']; ?></span></h3></div>
			<div class="fc-panel-body">
				<article class="fc-article fc-article-detail">
					<div class="fc-article-thumb uk-margin-small-bottom"><a href="" title="" class="fc-crop-center-img-h"><img src="<?php echo $DetailArticles['images']; ?>" alt="" class="uk-width-1-1"></a></div>
					<div class="fc-article-lead uk-margin-small-bottom uk-text-bold"><?php echo $DetailArticles['description']; ?></div>
					<div class="fc-article-content margin-bottom-25px"><?php echo $DetailArticles['content']; ?> </div>
					<?php if(isset($ArticlesSame) && is_array($ArticlesSame) && count($ArticlesSame)){ ?>
					<div class="fc-article-related">
						<h3 class="uk-text-bold uk-margin-small-bottom">Tin bài liên quan</h3>
						<ul class="uk-list uk-list-space uk-margin-top-remove uk-margin-left">
						<?php foreach($ArticlesSame as $key => $val){ ?>
						<?php 
							$title = $val['title'];
							$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 	'articles');
							$created = show_time($val['created'], 'd/m/Y');
						?>
							<li><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a> <span class="uk-text-muted"><?php echo $created; ?></span></li>
						<?php } ?>
						</ul>
					</div>
					<?php } ?>
				</article><!-- .fc-article -->
			</div><!-- .fc-panel-body -->
		</div><!-- .uk-panel -->
	</div><!-- .uk-container -->
</section><!-- .index-section -->