<div class="fc-breadcrumb uk-margin-bottom uk-margin-top">
	<div class="uk-container uk-container-center">
	<?php if (isset($Breadcrumb) && is_array($Breadcrumb) && count ($Breadcrumb)) { ?>
		<ul class="uk-breadcrumb uk-margin-remove">
			<li><a href="" title="Trang chủ">Trang chủ</a></li>
		<?php foreach ($Breadcrumb as $key => $value) {
			$title = $value['title'];
			$href = rewrite_url($value['canonical'] , $value['slug'] , $value['id'] , 'articles_catalogues');
		 ?>
			<li><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
		<?php } ?>
		</ul>
	<?php } ?>
	</div><!-- .uk-container -->
</div><!-- end .fc-breadcrumb -->
<section class="block-article">
	<div class="uk-container uk-container-center">
		<div class="uk-panel article-detail">
		<?php if (isset($DetailArticles) && is_array($DetailArticles) && count ($DetailArticles)) {
			$title = $DetailArticles['title'];
			$created = show_time($DetailArticles['created'], 'd/m/Y');
			$des = $DetailArticles['description'];
			$content = $DetailArticles['content'];
		 ?>
			<article  class="uk-article">
				<h1 class="uk-article-title"><?php echo $title; ?></h1>
				<div class="uk-article-meta uk-clearfix">
					<time datetime="12/04/2016" class="uk-float-right"><?php echo $created; ?></time>
				</div>
				<div class="article-description">
					<?php echo $des; ?>
				</div>
				<div class="uk-article-lead">
					<?php echo $content; ?>
				</div>
				
			</article>
		<?php } ?>
		</div><!-- end uk-panel -->
		<div class="uk-panel coment-fb uk-margin-small-top">
			<div class="fc-panel-body">
				<div class="fb-comments" data-href="binh-sieu-toc-happycook-hs17sk-1-7-lit-p24.html" data-width="100%" data-numposts="3"></div>
				</div><!-- .fc-panel-body -->
				
		</div>
	</div><!-- end .uk-container -->
</section><!-- end .product-block -->

<section class="block article-related uk-margin-top">
	<div class="uk-container uk-container-center">
		<div class="uk-panel">
			<header class="uk-clearfix">
				<h3 class="block-title uk-margin-remove uk-float-left"><a href="" title="" class="fc-text-uppercase">Sản phẩm cùng loại</a></h3>
			</header><!-- header -->
			<div class="fc-body">
				
			</div><!-- end fc-body -->
		</div><!-- end .uk-panel -->
	</div><!-- end .uk-container -center -->
</section><!-- end .block -->