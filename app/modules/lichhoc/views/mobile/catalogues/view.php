<div class="fc-breadcrumb uk-margin-bottom uk-margin-top">
	<div class="uk-container uk-container-center">
	<?php if (isset($Breadcrumb) && is_array ($Breadcrumb) && count ($Breadcrumb) ) {  ?>
		<ul class="uk-breadcrumb uk-margin-remove">
			<li><a href="" title="Trang chủ">Trang chủ</a></li>
		<?php foreach ($Breadcrumb as $key => $value) {
			$href = rewrite_url($value['canonical'] , $value['slug'], $value['id'], 'articles_catalogues')
		 ?>
			<li class=""><a href="<?php echo $href; ?>" title="<?php echo $Breadcrumb[0]['title']; ?>">
				<?php echo $Breadcrumb[$key]['title']; ?></a></li>
		<?php } ?>
		</ul>
	<?php } ?>
	</div><!-- .uk-container -->
</div><!-- end .fc-breadcrumb -->
<section class="block margin-bottom-20 uk-margin-top">
	<div class="uk-container uk-container-center">
		<div class="uk-panel">
		<?php if (isset($DetailCatalogues) && is_array ($DetailCatalogues) && count ($DetailCatalogues) ) {  ?>
			<header class="uk-clearfix">
				<h3 class="block-title uk-margin-remove uk-float-left"><a href="" title="" class="fc-text-uppercase"><?php echo $DetailCatalogues['title']; ?></a></h3>
			</header><!-- header -->
		
			<?php if (isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)) { ?>
			<div class="fc-body">
				<div class="uk-grid uk-grid-collapse uk-grid-width-medium-1-1">
			<?php foreach ($ArticlesList as $key => $value) {
				//print_r($ArticlesList);die();
				$title = $value['title'];
				$href = rewrite_url($value['canonical'], $value['slug'], $value['id'], 'articles');
				$img = ($value['images']!='')?$value['images']:'uploads/images/not-found.png';
				$created = show_time($value['created'], 'd/m/Y');
				$des = $value['description'];  ?>
					<div class="fc-featured uk-clearfix">
						<a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="fc-thumb"><img src="<?php echo $img; ?>" alt=""></a>
						<div class="fc-info">
							<h3 class="title uk-margin-remove"><a href="<?php echo $href; ?>" title="" class="uk-text-bold"><?php echo $title; ?></a></h3>
							<span class="uk-text-muted fc-article-meta">07/04/2016</span>
							<div class="fc-article-desc">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis non doloribus facere ...
							</div>
						</div>
					</div><!-- end .fc-featured -->
			<?php } ?>
				</div>	<!-- end .uk-grid -->
				<div class="pagination uk-text-right">
					<?php echo (isset($PaginationList)? $PaginationList :''); ?>
				</div><!-- end .pagination -->
			</div><!-- end fc-body -->
		<?php } } ?>
		</div><!-- end .uk-panel -->
	</div><!-- end .uk-container -->
</section><!-- end .block -->
