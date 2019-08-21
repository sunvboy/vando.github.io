<div id="article-page" class="page-body detailpage">
	<div class="banner-page  uk-text-center" >
        <div class="absulute-page">
        	<?php if ($Catalog_goc['isaside'] == 1) { ?>
        		<header class="panelhead">
					<h2 class="heading detalhead uk-container"><span style="color: #333;"><?php echo $Catalog_goc['title'] ?></span></h2>
				</header>
        	<?php }else{ ?>
				<header class="panelhead" style="background: url('<?php echo $this->fcSystem['banner_banner1'] ?>');">
					<h2 class="heading detalhead uk-container"><span><?php echo $DetailCatalogues['title'] ?></span></h2>
				</header>
			<?php } ?>
		</div>
	</div>
	<?php if (isset($list_child) && is_array($list_child) && count($list_child) && $Catalog_goc['isaside'] == 1): ?>
		<section class="box_catalog_child">
			<div class="uk-container uk-container-center">
				<ul class="uk-list uk-flex uk-flex-middle uk-flex-center relative tabchild">
					<?php foreach ($list_child as $key => $val) { ?>
						<?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
						<li class="uk-width-1-1 uk-text-center <?php echo (($hrefC == $canonicalcata) ? 'uk-active' : '') ?>" id="tab<?php echo $key ?>">
							<a href="<?php echo ((isset($val['child']) && is_array($val['child']) && count($val['child'])) ? 'javascript: void(0)' : ''.$hrefC.'') ?>" title="<?php echo $val['title'] ?>">
								<?php echo $val['title'] ?>
							</a>
						</li>
						<?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
						<script>
							$(document).ready(function() {
								$('#tab<?php echo $key ?>').click(function(){
									$('.tabchild li').removeClass('uk-active');
									$('#products-page').find('.tab_child').hide();
									$(this).toggleClass('uk-active');
									$('#products-page').find('#child<?php echo $key ?>').slideToggle('slow');
								});
							});
						</script>
						<?php endif ?>
					<?php } ?>
				</ul>
			</div>
		</section>
	<?php endif ?>
	<?php if (isset($list_child) && is_array($list_child) && count($list_child) && $Catalog_goc['isaside'] == 1): ?>
		<section class="tab-content_child">
			<div class="uk-container uk-container-center">
		  		<?php foreach ($list_child as $keyg => $val) { ?>
		  			<?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
	  				<?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
				  		<div id="child<?php echo $keyg ?>" class="tab_child <?php echo (($hrefC == $canonicalcata)?'uk-active':'') ?>">
				  			<ul class="uk-list uk-list-child-item">
								<?php foreach ($val['child'] as $key => $vals) { ?>
									<?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles_catalogues'); ?>
									<li>
										<a href="<?php echo $hrefC ?>" title="<?php echo $vals['title'] ?>">
											<span aria-hidden="true" class="fa fa-angle-right"></span>
											<?php echo $vals['title'] ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					<?php endif ?>
				<?php } ?>
			</div>
		</section>
	<?php endif ?>
	<?php $listcat = Load_catagoies(json_decode($DetailArticles['catalogues'], TRUE), 'articles');  ?>
	<?php if (!empty($DetailArticles['supportid'])): ?>
		<?php $supportList = $this->Frontendsupports_Model->ReadByField('id', $DetailArticles['supportid'], $this->fc_lang); ?>
	<?php endif ?>
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
        	<div class="uk-grid mt20">
		        <div class="uk-width-large-3-4">
					<section class="panel-body">
						<div class="uk-grid">
							<?php if (isset($supportList) && is_array($supportList) && count($supportList)){ ?>
								<?php $hrefgv = rewrite_url($supportList['canonical'], $supportList['slug'], $supportList['id'], 'supports'); ?>
		        				<div class="uk-width-large-1-3 mb20">
		        					<section class="aside_giangvien">
										<div class="giang-vien-box">
											<div class="thumb">
												<a href="<?php echo $hrefgv ?>" title="<?php echo $supportList['fullname'] ?>" class="img-cover">
													<img src="<?php echo $supportList['images'] ?>" alt="<?php echo $supportList['fullname'] ?>">
												</a>
											</div>
											<div class="infor">
												<h4 class="title">
													<a href="<?php echo $hrefgv ?>" title="<?php echo $supportList['fullname'] ?>">
														<?php echo $supportList['fullname'] ?>
													</a>
												</h4>
												<div class="mb15 meta-gv uk-text-center"><?php echo $supportList['facebook'] ?></div>
												<div class="description">
													<?php echo $supportList['viber'] ?>
												</div>
											</div>
										</div>
									</section>
		        				</div>
		        				<div class="uk-width-large-2-3 mb20">
							<?php }else{ ?>
								<div class="uk-width-1-1 mb20">
							<?php } ?>
								<article class="article">
									<div class="content mb20 uk-clearfix">
										<header class="panel-head mb20">
											<h1 class="heading"><span><?php echo $DetailArticles['title'] ?></span></h1>
											<div class="uk-flex uk-flex-middle meta-head lib-grid-30">
												<?php if (isset($listcat) && is_array($listcat) && count($listcat)): ?>
													<div class="meta_ic">
					        							<span class="ic_catalog">
				                                            <?php foreach ($listcat as $key => $val) { ?>
				                                                <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'],'articles_catalogues'); ?>
				                                                    <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>">
				                                                        <?php echo $val['title'] ?>
				                                                    </a>
				                                            <?php } ?>
					                                    </span>
					                                </div>
					                            <?php endif ?>
		                                    	<div class="meta_ic">
													<span class="ic_time"><?php echo show_time($DetailArticles['created'], 'd/m/Y') ?></span>
		                                    	</div>
		                                    	<div class="meta_ic">
		                                    		<span class="ic_user">Administrator</span>
		                                    	</div>
		        							</div>
										</header>
				                        <div class="desdetailnew"><?php echo $DetailArticles['description']; ?></div>
				                        <div class="content_article mt10">
											<?php echo $DetailArticles['content']; ?>
										</div>
									</div>
								</article>
								<div class="uk-flex uk-flex-middle uk-flex-space-between meta">
									<div class="left-meta uk-flex-middle uk-flex">
										<span>Tag:</span>
										<?php if (isset($TagsList) && is_array($TagsList) && count($TagsList)): ?>
											<?php foreach ($TagsList as $key => $val) { ?>
												<?php $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'tags'); ?>
												<a href="<?php echo $href ?>"><?php echo $val['title'] ?>, </a>
											<?php } ?>
										<?php endif ?>
									</div>
									<div class="links_share uk-flex-middle uk-flex">
										<span>Chia sẻ: </span>
										<a href="http://www.facebook.com/sharer.php?u=<?php echo $canonical ?>&t=<?php echo $DetailArticles['title']; ?>" class="ic_share share_fb"  target="_blank"></a>
										<a href="https://plus.google.com/share?url=<?php echo $canonical ?>" target="_blank" class="ic_share share_gg"></a>
										<a href="https://twitter.com/share?url=<?php echo $canonical ?>&text=<?php echo $DetailArticles['title']; ?>&hashtags=simplesharebuttons" target="_blank" class="ic_share share_tw"></a>
										<a href="http://pinterest.com/pin/create/bookmarklet/?is_video=false&url=<?php echo $canonical ?>&media=&description=HTML%20Share%20Buttons" class="ic_share share_pin" target="_blank"></a>
									</div>
								</div>
							</div>
						</div>
					</section>
		            
		            <?php if (is_array($articles_same) && isset($articles_same) && count($articles_same)) { ?>
						<section class="art-same mt20 mb20">
							<div class="uk-container uk-container-center">
								<header class="panel-head uk-text-center">
									<h6 class="heading"><span><?php echo $this->lang->line('aticles_otther') ?></span></h6>
								</header>
								<div class="panel-body artcatalogue mt20">
									<div class="uk-slidenav-position slider-2" data-uk-slider="{autoplay: true, autoplayInterval: 5500}">
				                    	<div class="uk-slider-container">
											<ul class="uk-slider uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-small-1-3 list-article">
												<?php foreach ($articles_same as $key => $val) { ?> 
													<?php 
														$title = $val['title'];
														$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
														$image = getthumb($val['images'], TRUE);
														$description = cutnchar(strip_tags($val['description']),450);
														$created = show_time($val['created'], 'd/m/Y');
														$view = $val['viewed'];
													?>
							                        <li>
							                            <article class="uk-clearfix article">
							                                <div class="thumb">
							                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
							                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
							                                    </a>
							                                </div>
							                                <div class="infor">
							                                	<div class="top_articles">
								                                    <h3 class="title">
								                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
								                                            <?php echo $val['title'] ?>
								                                        </a>
								                                    </h3>
				                                                    <span class="view_detail">  <?php echo $created ?> - <?php echo $view ?> <?php echo $this->lang->line('views') ?></span>
							                                    </div>
							                                    <div class="more_art">
							                                    	<a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>"><?php echo $this->lang->line('see-detail') ?></a>
							                                    </div>
							                                </div>
							                            </article>
							                        </li>
												<?php } ?>
											</ul>
											<a href="" class="uk-slidene uk-slidenav-contrast" data-uk-slider-item="next">
					                            <i class="fa fa-angle-right" aria-hidden="true"></i>
					                        </a>
					                        <a href="" class="uk-slidepr uk-slidenav-contrast" data-uk-slider-item="previous">
					                            <i class="fa fa-angle-left" aria-hidden="true"></i>
					                        </a>
										</div>
									</div>
								</div>
							</div>
						</section><!-- .article-related -->
					<?php } ?>
		        </div>
		        <div class="uk-width-large-1-4 lib-grid-20 mb20">
					<aside class="aside aside_products">
						<?php $this->load->view('homepage/frontend/common/aside'); ?>
					</aside><!-- aside -->
				</div>   
			</div>
		</div>
	</section><!-- .article-detail -->
</div>