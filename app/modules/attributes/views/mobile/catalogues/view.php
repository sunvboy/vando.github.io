<section class="fc-breadcrumb">
	<div class="uk-container uk-container-center">
		<ul class="uk-breadcrumb uk-margin-remove">
			<li><a href="<?php echo base_url(); ?>" title="Trang chủ"><i class="uk-icon-home"></i></a></li>
		<?php if(isset($Breadcrumb) && is_array($Breadcrumb) && count($Breadcrumb)){ ?>
		<?php foreach($Breadcrumb as $key => $val){ ?>
		<?php 
			$title = $val['title'];
			$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 	'products_catalogues');
		?>
			<li><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
		<?php } ?>
		<?php } ?>
		
		</ul>
	</div><!-- .uk-container -->
</section><!-- .fc-breadcrumb -->

<?php if(isset($slide) && is_array($slide) && count($slide)){ ?>
<section class="index-slide uk-margin-bottom">
	<div class="uk-slidenav-position" data-uk-slideshow="{animation: 'scroll', autoplay: false, autoplayInterval: 2000}">
		<ul class="uk-slideshow">
		<?php foreach($slide as $key => $val){ ?>
			<li><div class="fc-crop-center-img-h"><img src="<?php echo $val['image']; ?>" alt="" class="uk-width-1-1" /></div></li>
		<?php } ?>
		</ul>
		<!-- <a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slideshow-item="previous"></a> -->
		<!-- <a href="" class="uk-slidenav uk-slidenav-next" data-uk-slideshow-item="next"></a> -->
		<ul class="uk-dotnav uk-position-bottom uk-flex-center">
		<?php foreach($slide as $key => $val){ ?>
			<li data-uk-slideshow-item="<?php echo $key; ?>"><a href=""></a></li>
		<?php } ?>
		</ul>
	</div>
</section><!-- .index-slide -->
<?php } ?>


<section class="index-section index-slider uk-margin-bottom">
	<div class="uk-container uk-container-center">
	<?php if(isset($productsList) && is_array($productsList) && count($productsList)){ ?>
		<div class="uk-panel">
			<div class="uk-panel-title uk-margin-small-bottom"><h3 class="heading uk-clearfix uk-margin-remove"><span class="uk-text-truncate"><?php echo $DetailCatalogues['title']; ?></span></h3></div>
			<div class="fc-panel-body">
				<ul class="uk-grid uk-grid-small uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 fc-product-grid" data-uk-grid-match="{target:'.fc-product-title'}">
				<?php foreach($productsList as $key => $val){ ?>
				<?php 
					$title = $val['title'];
					$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 	'articles');
					$image = $val['images'];
					$description = cutnchar(strip_tags($val['description']), 250);
					$created = show_time($val['created'], 'd/m/Y');
					$sale = $val['saleoff'];
					$price = $val['price'];
					$price_sale = $price - ($price*$sale)/100;
				?>
					<li class="margin-bottom-10px">
						<div class="fc-product">
							<div class="fc-product-thumb uk-margin-small-bottom"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="fc-fit-img"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a></div>
							<div class="fc-product-title uk-margin-small-bottom uk-text-bold"><?php echo $title; ?></div>
							<div class="fc-product-content margin-bottom-10px">
							<?php if($sale > 0){ ?>
								<div><s class="fc-product-price-old uk-text-muted"><?php echo str_replace(',','.',number_format($price)); ?> ₫</s></div>
							<?php } ?>
								<div><span>Giá: </span><span class="fc-product-price uk-text-bold"><?php echo (($sale > 0) ? str_replace(',','.',number_format($price_sale)) : str_replace(',','.',number_format($price)));  ?> ₫</span>
								<?php if($sale > 0){ ?>
								<span class="uk-badge uk-badge-warning margin-left-10px">-<?php echo $sale; ?>%</span>
								<?php } ?>
								</div>
								
							</div>
							<div class="fc-product-buy uk-text-center"><a title="" class="uk-button"><i class="uk-icon-cart-plus margin-right-10px"></i>Thêm vào giỏ hàng</a></div>
						</div>
					</li>
				<?php } ?>
				</ul>
				<?php echo ((isset($PaginationList)) ? $PaginationList : ''); ?>
			</div><!-- .fc-panel-body -->
		</div><!-- .uk-panel -->
	<?php } ?>
	</div><!-- .uk-container -->
</section><!-- .index-section -->
