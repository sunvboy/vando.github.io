<div class="uk-container uk-container-center">
	<div class="main-banner ec-cover"><a href="" title=""><img src="templates/frontend/resources/img/upload/banner-3.png" alt="" /></a></div>
	<div class="uk-grid uk-grid-small">
		<div class="uk-width-large-7-10">
			<section class="main-content">
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
				<section class="article-catalogue">
				<?php if(isset($highlight_post) && is_array($highlight_post) && count($highlight_post)){ ?>
					<div class="uk-grid ec-grid-15">
						<div class="uk-width-medium-2-3">
						<?php foreach($highlight_post as $key => $val){ ?>
						<?php 
							if($key > 0) break;
							$title = $val['title'];
							$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
							$image = $val['images'];
							$description = cutnchar(strip_tags($val['description']), 250);
						?>
							<section class="featured">
								<article class="article-2">
									<div class="thumb"><a class="image ec-cover" href="<?php echo $href; ?>" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a></div>
									<h2 class="title"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h2>
									<div class="description"><?php echo $description; ?></div>
								</article><!-- .article-2 -->
							</section>
						<?php } ?>
						</div><!-- .uk-width -->
						<div class="uk-width-medium-1-3">
							<aside class="aside">
								<section class="featured-articles movie">
									<header class="panel-head skin-1"><div class="heading-1"><span>Đọc nhiều</span></div></header>
									<div class="panel-body">
										<ul class="uk-list list-article">
										<?php foreach($highlight_post as $key => $val){ ?>
										<?php 
											if($key == 0) continue;
											$title = $val['title'];
											$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
										?>

											<li><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
										<?php } ?>
										</ul>
									</div>
								</section><!-- .featured-articles -->
							</aside><!-- .aside -->
						</div><!-- .uk-width -->
					</div><!-- .uk-grid -->
				<?php } ?>
					<?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)){ ?>
					<ul class="uk-list list-articles">
						<?php foreach($ArticlesList as $key => $val) { ?>
						<?php 
							$title = $val['title'];
							$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
							$image = getthumb($val['images']);
							$description = cutnchar(strip_tags($val['description']), 250);
						?>
						<li class="article-item">
							<article class="article-3 uk-grid uk-grid-collapse">
								<div class="uk-width-small-2-5 uk-width-large-1-3">
									<div class="thumb img-flash"><a class="image ec-cover" href="<?php echo $href; ?>" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a></div>
								</div>
								<div class="uk-width-small-3-5 uk-width-large-2-3">
									<div class="info">
										<h2 class="title"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h2>
										<div class="meta"><i class="fa fa-calendar"></i> <time>03-01-2017</time></div>
										<div class="description c-line-3">
											<?php echo $description; ?>
										</div>
									</div>
								</div>
							</article><!-- .article-3 -->
						</li>
						<?php } ?>
					</ul><!-- .list-article -->
					<?php } ?>
					<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
				</section><!-- .article-catalogue-->
			</section><!-- .main-content -->
		</div><!-- .uk-width -->
		<div class="uk-width-large-3-10">
			<aside class="aside mb10" data-uk-sticky="{top: 5, boundary: true,media: '(min-width: 960px)'}">
				<div class="banner uk-visible-large"><a href="" title=""><img src="templates/frontend/resources/img/upload/banner.gif" alt="" /></a></div>
				<?php $aside_news = $this->FrontendArticlesCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, lft, rgt','where' => array('publish' => 1,'trash' => 0,'isaside' => 1),'limit' => 1)); 
					if(isset($aside_news) && is_array($aside_news) && count($aside_news)){
						foreach($aside_news as $key => $val){
							$aside_news[$key]['post'] = $this->FrontendArticles_Model->_read_condition(array(
								'cataloguesid' => $val['id'],
								'modules' => 'articles',
								'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`',
								'where' => '`pr`.`trash` = 0',
								'limit' => 7,
								'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
							));
						}
					}
				?>
				<?php if(isset($aside_news) && is_array($aside_news) && count($aside_news)){ ?>
				<?php foreach($aside_news as $key => $val){ ?>
				<section class="top-new">
					<header class="panel-head skin-1"><div class="heading-1"><span><?php echo $val['title']; ?></span></div></header>
					<?php if(isset($val['post']) && is_array($val['post']) && count($val['post'])){ ?>
					<div class="panel-body">
						<ul class="uk-list list-article" data-uk-grid-match="{target: '.article-1 .title'}">
							<?php foreach($val['post'] as $keyPost => $valPost) { ?> 
							<?php 
								$title = $valPost['title'];
								$href = rewrite_url($valPost['canonical'], $valPost['slug'], $valPost['id'], 'articles');
								$image = getthumb($valPost['images']);
								$description = cutnchar(strip_tags($valPost['description']), 250);
							?>
							<li class="article-item">
								<article class="article-1 uk-grid uk-grid-collapse">
									<div class="uk-width-1-3">
										<div class="thumb"><a class="image ec-cover" href="" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a></div>
									</div>
									<div class="uk-width-2-3">
										<div class="info">
											<h3 class="title"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
										</div>
									</div>
								</article><!-- .article-1 -->
							</li>
							<?php } ?>
						</ul><!-- .lisr-article -->
					</div>
					<?php } ?>
				</section><!-- .featured-articles -->
				<?php }} ?>
				<div class="banner uk-visible-large"><a href="" title=""><img src="templates/frontend/resources/img/upload/banner-2.jpg" alt="" /></a></div>
				<div class="banner uk-visible-large"><a href="" title=""><img src="templates/frontend/resources/img/upload/banner-3.jpg" alt="" /></a></div>
			</aside><!-- .aside -->
		</div><!-- .uk-width -->
	</div><!-- .uk-grid -->
</div><!-- .uk-container -->