<?php  
	$data = $this->FrontendProducts_Model->ReadByCondition(array(
		'select' => 'id, title, slug, canonical, images, saleoff, price, code, description',
		'table' => 'products',
		'where' => array('publish' => 1,'trash' => 0, 'alanguage' => $this->fc_lang),
		'limit' => 3,
		'order_by' => 'id desc',
	));
?>
<?php if (isset($data) && is_array($data) && count($data)) { ?>
	<section class="prd-hot aside-panel mb30 mt30">
		<section class="panel-body">
			<div id="home-slideshow" class="uk-slidenav-position" data-uk-slideshow="{autoplay: true, autoplayInterval: 7500}">
	            <ul class="uk-slideshow list-products-hot" data-uk-grid-match="{target: '.product .title'}">
					<?php foreach($data as $key => $val){ ?>
						<?php 
							$title = $val['title'];
							$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
							$image = getthumb($val['images'], FALSE);
							$price = $val['price'];
							$saleoff = $val['saleoff'];
							if ($price > 0) {
								$giaold = str_replace(',', '.', number_format($price)).'₫';
							}else{
								$giaold = '';
							}
							if ($saleoff > 0) {
								$gia = str_replace(',', '.', number_format($saleoff)).'₫';
							}else{
								$gia = 'Liên hệ';
							}
							if ($saleoff > 0 && $price > 0 && $saleoff < $price) {
								$sale = ceil(($price - $saleoff)/$price*100);
								$price_sale = str_replace(',', '.', number_format($price - $saleoff)).'₫';
							}else{
								$sale = $price_sale = '';
							}
							$str = explode('-', $title);
						?>
						<li>
							<div class="product-hot uk-clearfix">
								<div class="thumb">
									<a class="image img-scaledown" href="<?php echo $href ?>" title="<?php echo $title; ?>">
										<img src="<?php echo $val['images'] ?>" alt="<?php echo $title; ?>" />
									</a>
								</div>
								<div class="infor">
									<h3 class="title">
										<a href="<?php echo $href ?>" title="<?php echo $title; ?>">
											<?php 
												if (isset($str) && is_array($str)) {
	                                                foreach ($str as $key => $value) {
	                                                    echo (($key == 0) ? '<span>' : ' ').$value.(($key == 0) ? '</span><br/>' : '');
	                                                }
	                                            }
											?>
										</a>
									</h3>
									<div class="description">
										<div class="code_products"><?php echo $val['code'] ?></div>
										<div class="style_des uk-grid uk-grid-width-1-2 uk-grid-collapse">
											<?php echo $val['description'] ?>
										</div>
									</div>
									<div class="more_detail">
										<a href="<?php echo $href ?>" title="<?php echo $title; ?>">Where to find</a>
									</div>
								</div><!-- .infor -->
							</div><!-- .product -->
						</li>
					<?php } ?>
				</ul>
				<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
            	<a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
			</div>
		</section>
	</section><!-- .prd-same -->
<?php } ?>


