<div id="tag-page" class="page-body">
	<div class="banner-page  uk-text-center" >
        <div class="absulute-page " >
			<header class="panelhead" style="background: url('<?php echo $this->fcSystem['banner_banner1'] ?>');">
				<h2 class="heading detalhead uk-container"><span style="color: #fff;">Tag</span></h2>
			</header>
			<div class="breadcrumb">
				<div class="uk-container uk-container-center">
					<ul class="uk-breadcrumb">
						<li>
							<a href="<?php echo BASE_URL ?>" title="<?php echo $this->lang->line('home_page') ?>">
								<?php echo $this->lang->line('home_page'); ?>
							</a>
						</li>
						<li class="uk-active">
							<a>Từ khóa: <?php echo $DetailTags['title'] ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<section class="artcatalogue">
		<div class="uk-container uk-container-center">
			<section class="panel-body">
				<?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)){ ?>
					<ul class="uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 list-article"  data-uk-grid-match="{target: '.article .title'}">
						<?php foreach($ArticlesList as $key => $val) { ?> 
							<?php 
								//$title = $val['title'];
								$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
								$image = getthumb($val['images'], TRUE);
								$description = cutnchar(strip_tags($val['description']),450);
								$title = cutnchar(strip_tags($val['title']),250);
								$created = show_time($val['created'], 'd/m/Y');
								$view = $val['viewed'];
								$list_cat = Load_catagoies(json_decode($val['catalogues'], TRUE), 'articles');
							?>
	                        <li class="mb20">
	                            <article class="uk-clearfix article relative">
	                                <div class="thumb">
	                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
	                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
	                                    </a>
	                                </div>
	                                <div class="infor uk-clearfix ">
	                                    <div class="admissions">
		                                	<div class="top_articles">
			                                    <h3 class="title">
			                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
			                                            <?php echo $val['title'] ?>
			                                        </a>
			                                    </h3>
			                                    <span class="view_detail">  <?php echo $created ?> - <?php echo $view ?> <?php echo $this->lang->line('viewed') ?></span>
		                                    </div>
		                                    <div class="morecat">
		                                    	<?php if (isset($list_cat) && is_array($list_cat) && count($list_cat)): ?>
		                                    		<?php foreach ($list_cat as $key => $valf) { ?>
		                                    			<?php $hrefv = rewrite_url($valf['canonical'], $valf['slug'], $valf['id'], 'articles_catalogues'); ?>
		                                    			<a href="<?php echo $hrefv ?>" title="<?php echo $valf['title'] ?>">
				                                    		<?php echo $valf['title'] ?>
				                                    	</a>
		                                    		<?php } ?>
		                                    	<?php endif ?>
		                                    </div>
		                                </div>
	                                </div>
	                            </article>
	                        </li>
	                    <?php } ?>
					</ul>
				<?php }else{ echo 'Dữ liệu đang được cập nhật ...'; } ?>
			</section>
		</div>
	</section>
</div>