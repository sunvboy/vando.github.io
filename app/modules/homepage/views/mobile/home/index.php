<?php if(isset($slide) && is_array($slide) && count($slide)){ ?>
<section id="index-slide">
	<div class="uk-container uk-container-center">
		<div class="uk-slidenav-position" data-uk-slideshow="{animation: 'scroll', autoplay: true, autoplayInterval: 2000}">
			<ul class="uk-slideshow">
			<?php foreach($slide as $key => $val){ ?>
				<li><a href="<?php echo $val['url']; ?>" title="<?php echo $val['title']; ?>" class="fc-thumb"><img src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>" /></a></li>
			<?php } ?>
			</ul>
			<a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
			<a href="" class="uk-slidenav uk-slidenav-next" data-uk-slideshow-item="next"></a>
			<!-- <ul class="uk-dotnav uk-position-bottom uk-flex-center">
				<li data-uk-slideshow-item="0"><a href=""></a></li>
				<li data-uk-slideshow-item="1"><a href=""></a></li>
				<li data-uk-slideshow-item="2"><a href=""></a></li>
			</ul> -->
		</div>
	</div><!-- end .uk-container -->
</section><!-- end #index-slide -->
<?php } ?>

<?php if(isset($products_ishome) && is_array($products_ishome) && count($products_ishome)){ ?>
<section class="block margin-bottom-20 uk-margin-top">
	<div class="uk-container uk-container-center">
		<div class="uk-panel">
			<header class="uk-clearfix">
				<h3 class="block-title uk-margin-remove uk-float-left"><span class="fc-text-uppercase">Sản phẩm mới</span></h3>
			</header><!-- header -->
			<div class="fc-body">
				<div class="uk-grid uk-grid-small uk-grid-width-medium-1-3 uk-grid-width-small-1-2" data-uk-grid-match="{target:'.fc-product-title'}">
				<?php foreach($products_ishome as $key => $val){ ?>
				<?php 
					$title = $val['title'];
					$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
					$image = getthumb($val['images']);
					$description = cutnchar(strip_tags($val['description']), 250);
					$created = show_time($val['created'], 'd/m/Y');
					$price = number_format($val['price']);
				?>

					<div class="fc-product">
						<div class="fc-product-thumb">
							<a href="<?php echo $href; ?>" class="fc-fit-img" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a>
						</div>
						<div class="fc-product-title uk-margin-small-bottom">
							<a href="<?php echo $href; ?>" class="uk-text-bold" title="<?php echo $title; ?>"><?php echo $title; ?></a>
						</div>
						<div class="fc-product-price"> 
							<div class="fc-product-price-new uk-margin-small-bottom"><span class="uk-text-bold"><?php echo $price ?>đ</span></div>								
						</div>
						<div class="fc-product-link"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="uk-button">Xem chi tiết</a></div>
					</div>
				<?php } ?>
				</div>
			</div><!-- end fc-body -->
		</div><!-- end .uk-panel -->
	</div><!-- end .uk-container -->
</section><!-- end .block -->

<?php } ?>


<?php if(isset($products_highlight) && is_array($products_highlight) && count($products_highlight)){ ?>
<section class="block margin-bottom-20 uk-margin-top">
	<div class="uk-container uk-container-center">
		<div class="uk-panel">
			<header class="uk-clearfix">
				<h3 class="block-title uk-margin-remove uk-float-left"><span class="fc-text-uppercase">Sản phẩm bán chạy</span></h3>
			</header><!-- header -->
			<div class="fc-body">
				<div class="uk-grid uk-grid-small uk-grid-width-medium-1-3 uk-grid-width-small-1-2">
				<?php foreach($products_highlight as $key => $val){ ?>
				<?php 
					$title = $val['title'];
					$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
					$image = getthumb($val['images']);
					$description = cutnchar(strip_tags($val['description']), 250);
					$created = show_time($val['created'], 'd/m/Y');
					$price = number_format($val['price']);
				?>

					<div class="fc-product">
						<div class="fc-product-thumb">
							<a href="<?php echo $href; ?>" class="fc-fit-img" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a>
						</div>
						<div class="fc-product-title uk-margin-small-bottom">
							<a href="<?php echo $href; ?>" class="uk-text-bold" title="<?php echo $title; ?>"><?php echo $title; ?></a>
						</div>
						<div class="fc-product-price"> 
							<div class="fc-product-price-new uk-margin-small-bottom"><span class="uk-text-bold"><?php echo $price ?>đ</span></div>								
						</div>
						<div class="fc-product-link"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="uk-button">Xem chi tiết</a></div>
					</div>
				<?php } ?>
				</div>
			</div><!-- end fc-body -->
		</div><!-- end .uk-panel -->
	</div><!-- end .uk-container -->
</section><!-- end .block -->

<?php } ?>


<?php if(isset($catalogues_highlight) && is_array($catalogues_highlight) && count($catalogues_highlight)){ ?>
<?php foreach($catalogues_highlight as $key => $val){ ?>
<?php 
	$titleC = $val['title'];
	$hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues');
?>

<section class="block margin-bottom-20 uk-margin-top">
	<div class="uk-container uk-container-center">
		<div class="uk-panel">
			<header class="uk-clearfix">
				<h3 class="block-title uk-margin-remove uk-float-left"><a href="<?php echo $hrefC; ?>" title="<?php echo $titleC; ?>" class="fc-text-uppercase"><?php echo $titleC; ?></a></h3>
				<div class="uk-button-dropdown uk-float-right" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
					<a href="#" class="trigger"><i class="uk-icon-bars"></i></a> 
					<?php if(isset($val['child']) && is_array($val['child']) && count($val['child'])){ ?>
					<div class="uk-dropdown">
						<ul class="uk-list uk-panel fc-list uk-margin-remove uk-padding-remove">
						<?php foreach($val['child'] as $keyChild => $valChild){ ?>
						<?php 
							$titleSub = $valChild['title'];
							$hrefSub = rewrite_url($valChild['canonical'], $valChild['slug'], $valChild['id'], 'products_catalogues');
						?>

							<li class="lvl-1"><a href="<?php echo $hrefSub; ?>" class="lvl-1" title="<?php echo $titleSub; ?>"><?php echo $titleSub; ?></a></li>
						<?php } ?>
						</ul><!-- end .fc-list -->
					</div>
					<?php } ?>
				</div>
			</header><!-- header -->
			<?php if(isset($val['post']) && is_array($val['post']) && count($val['post'])){ ?>
			<div class="fc-body">
				<div class="uk-grid uk-grid-small uk-grid-width-medium-1-3 uk-grid-width-small-1-2">
					<?php foreach($val['post'] as $keyPost => $valPost){ ?>
					<?php 
						$title = $valPost['title'];
						$href = rewrite_url($valPost['canonical'], $valPost['slug'], $valPost['id'], 'products');
						$image = getthumb($valPost['images']);
						$description = cutnchar(strip_tags($valPost['description']), 250);
						$created = show_time($valPost['created'], 'd/m/Y');
						$price = number_format($valPost['price']);
					?>

					<div class="fc-product">
						<div class="fc-product-thumb">
							<a href="<?php echo $href; ?>" class="fc-fit-img" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a>
						</div>
						<div class="fc-product-title uk-margin-small-bottom">
							<a href="<?php echo $href; ?>" class="uk-text-bold" title=""><?php echo $title; ?></a>
						</div>
						<div class="fc-product-price"> 
							<div class="fc-product-price-new uk-margin-small-bottom"><span class="uk-text-bold"><?php echo $price; ?>đ</span></div>								
						</div>
						<div class="fc-product-link"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="uk-button">Xem chi tiết</a></div>
					</div>
					<?php } ?>
				</div>
			</div><!-- end fc-body -->
			<?php } ?>
		</div><!-- end .uk-panel -->
	</div><!-- end .uk-container -->
</section><!-- end .block -->
<?php } ?>
<?php } ?>

<section class="block articles uk-margin-top margin-bottom-25">
	<div class="uk-container uk-container-center">
	
	<?php if(isset($ac_hl) && is_array($ac_hl) && count($ac_hl)){ ?>
	<?php foreach($ac_hl as $key => $val){ ?>
	<?php 
		$titleC = $val['title'];
		$hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues');
	?>

		<div class="uk-panel">
			<h3 class="heading uk-clearfix fc-text-uppercase"><a href="<?php echo $hrefC; ?>" title="<?php echo $titleC; ?>"><?php echo $titleC; ?></a></h3>
			<?php if(isset($val['post']) && is_array($val['post']) && count($val['post'])){  ?>
			<div class="fc-body">
			<?php foreach($val['post'] as $keyPost => $valPost){ if($keyPost > 0) break; ?>
			<?php 
				$title = $valPost['title'];
				$href = rewrite_url($valPost['canonical'], $valPost['slug'], $valPost['id'], 'articles');
				$image = getthumb($valPost['images']);
				$description = cutnchar(strip_tags($valPost['description']), 250);
				$created = show_time($valPost['created'], 'd/m/Y');
			?>

				<div class="fc-featured uk-clearfix">
					<a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="fc-thumb"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>"></a>
					<div class="fc-info">
						<h3 class="title uk-margin-remove"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="uk-text-bold"><?php echo $title; ?></a></h3>
						<span class="uk-text-muted fc-article-meta"><?php echo $created; ?></span>
						<div class="fc-article-desc">
							<?php echo $description; ?>
						</div>
					</div>
				</div><!-- end .fc-featured -->
			<?php } ?>
				<div class="article-related">
					<ul class="uk-list post-list">
					<?php foreach($val['post'] as $keyPost => $valPost){ if($keyPost > 0) break; ?>
					<?php 
						$title = $valPost['title'];
						$href = rewrite_url($valPost['canonical'], $valPost['slug'], $valPost['id'], 'articles');
					?>
						<li class="item"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php  echo $title; ?></a></li>
					<?php } ?>
					</ul>
				</div><!-- end .fc-article-related -->
			</div>
			<?php } ?>
		</div><!-- end .uk-panel -->
	<?php } ?>
	<?php } ?>
	</div><!-- end .uk-container -->
</section><!-- end .index-section -->