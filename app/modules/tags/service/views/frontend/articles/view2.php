<div id="article-page" class="page-body">	
	<div class="banner-page  uk-text-center" >
        <div class="absulute-page">
			<header class="panelhead" style="background: url('<?php echo $this->fcSystem['banner_banner1'] ?>');">
				<h2 class="heading detalhead uk-container"><span><?php echo $DetailCatalogues['title'] ?></span></h2>
			</header>
		</div>
	</div>

	<section class="art-detail">
		<div class="uk-container uk-container-center">
			<div class="breadcrumb uk-container">
				<ul class="uk-breadcrumb">
					<li>
						<a href="<?php echo BASE_URL ?>" title="<?php echo $this->lang->line('home_page') ?>">
							<?php echo $this->lang->line('home_page'); ?>
						</a>
					</li>
					<?php foreach($Breadcrumb as $key => $val){ ?>
						<?php 
							$title = $val['title'];
							$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues');
						?>
						<li class="uk-active">
							<a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
						</li>
					<?php } ?>
				</ul>
			</div>
			<section class="detail-ebook">
	        	<div class="uk-grid mt20">
					<div class="uk-width-large-1-3 mb20">
						<div class="image-detail">
							<img src="<?php echo $DetailArticles['images'] ?>" alt="<?php echo $DetailArticles['title'] ?>">
						</div>
					</div>
					<div class="uk-width-large-2-3 mb20">
						<h1 class="title-ebook"><?php echo $DetailArticles['title'] ?></h1>
						<div class="meta_ mb10">Đăng bởi : <span>Administrator</span></div>
						<div class="description"><?php echo $DetailArticles['description'] ?></div>
					</div>
	        	</div>
	        </section>
	        <section class="conten-ebook mb30">
	        	<header class="panel-head mb15"><span>Nội dung sơ lược</span></header>
	        	<section class="panel-body">
	        		<?php echo $DetailArticles['content'] ?>
	        	</section>
	        </section>
	        <section class="ebook-section">
	        	<header class="panel-head uk-text-center">
					<h6 class="heading"><span>Ebook khác</span></h6>
				</header>
				<section class="panel-body">
					<?php if(isset($articles_same) && is_array($articles_same) && count($articles_same)){ ?>
						<ul class="uk-grid uk-grid-collapse uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 list-ebook"  data-uk-grid-match="{target: '.article .title'}">
							<?php foreach($articles_same as $key => $val) { ?> 
								<?php 
									$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
									$image = getthumb($val['images'], TRUE);
									$description = cutnchar(strip_tags($val['description']),450);
									$title = cutnchar(strip_tags($val['title']),250);
									$created = show_time($val['created'], 'd/m/Y');
									$view = $val['viewed'];
								?>
								<li class="mb20">
		                            <article class="uk-clearfix article">
		                                <div class="thumb">
		                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
		                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
		                                    </a>
		                                </div>
		                                <div class="infor">
		                                    <h3 class="title">
		                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
		                                            <?php echo $val['title'] ?>
		                                        </a>
		                                    </h3>
	                                   		<div class="description">
	                                        	<?php echo $description ?>
	                                    	</div>
		                                </div>
		                            </article>
		                        </li>				
                            <?php } ?>
                        </ul>
					<?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>';} ?>
				</section>
			</section><!-- .article-catalogue -->
        </div>
    </section>
</div>