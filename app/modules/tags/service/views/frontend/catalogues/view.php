<div id="article-page" class="page-body">	
	<div class="banner-page  uk-text-center" >
        <div class="absulute-page">
			<?php if ($Catalog_goc['isfooter'] != 3) { ?>
	    		<header class="panelhead">
					<h1 class="heading detalhead uk-container"><span style="color: #333;"><?php echo $Catalog_goc['title'] ?></span></h1>
				</header>
	    	<?php }else{ ?>
				<header class="panelhead" style="background: url('<?php echo $this->fcSystem['banner_banner1'] ?>');">
					<h1 class="heading detalhead uk-container"><span style="color: #fff;"><?php echo $Catalog_goc['title'] ?></span></h1>
				</header>
			<?php } ?>
		</div>
	</div>
	
	<?php if (isset($list_child) && is_array($list_child) && count($list_child) && $Catalog_goc['isfooter'] != 3): ?>
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
	<?php if (isset($list_child) && is_array($list_child) && count($list_child) && $Catalog_goc['isfooter'] != 3): ?>
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
	<section class="<?php echo (($Catalog_goc['isfooter'] == 1) ? 'catalog_netwwork' : (($Catalog_goc['isfooter'] == 2) ? 'catalog_support' : (($Catalog_goc['isfooter'] == 3) ? 'catalog_seminor' : (($Catalog_goc['isfooter'] == 4) ? 'catalog_research' : (($Catalog_goc['isfooter'] == 5) ? 'catalog_admissions' : (($Catalog_goc['isfooter'] == 6) ? 'catalog_media' : (($Catalog_goc['isfooter'] == 9) ? 'catalog_dichvu' : 'artcatalogue'))))))) ?>" style="margin-top: 0">
		<div class="uk-container uk-container-center">
			<div class="breadcrumb mb20">
				<ul class="uk-breadcrumb">
					<li>
						<a href="<?php echo BASE_URL ?>" title="<?php echo $this->lang->line('home_page') ?>">
							<?php echo $this->lang->line('home_page') ?>
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
			<section class="panel-body">

				<?php if ($Catalog_goc['isfooter'] == 3 && $DetailCatalogues['parentid'] == 0): ?>
					<?php if (isset($cataloghome) && is_array($cataloghome) && count($cataloghome)): ?>
						<div class="uk-grid uk-grid-medium">
							<?php foreach ($cataloghome as $key => $vals) { ?>
								<?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles_catalogues'); ?>
								<?php if ($key == 0){ ?>
									<?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
										<div class="uk-width-large-1-1 mb20">
											<div class="panel-head event_title">
												<h2 class="heading">
													<a href="<?php echo $hrefC ?>"><?php echo $vals['title'] ?></a>
												</h2>
											</div>
											<div id="cataloghome<?php echo $key ?>" class="<?php echo (($key = 0) ? 'owl-carousel' : '') ?>">
							                    <?php foreach ($vals['post'] as $keyp => $val) { ?>
							                    	<?php $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles'); ?>
													<div class="box_home_slide">
														<div class="thumb">
															<a class="image img-cover" href="<?php echo $href ?>" target="_blank">
																<img src="<?php echo $val['images']; ?>" alt="<?php echo $val['title']; ?>">
															</a>
														</div>
													</div>
												<?php } ?>
										    </div>
										    <script>
										    	$(document).ready(function () {
													$('#cataloghome<?php echo $key ?>').owlCarousel({
												        autoPlay: true,
												        // singleItem: true,
												        slideSpeed: 600,
												        navigation: true,
												        pagination: false,
												        margin: 15,
												        items: 2,
												        responsiveRefreshRate: 200,
												        navigationText: ["<i class='glyphicon glyphicon-menu-left'></i>", "<i class='glyphicon glyphicon-menu-right'></i>"]
												    });
												});
										    </script>
										</div>
									<?php endif ?>
								<?php }else{ ?> 
									<div class="uk-width-large-1-1 mb20">
										<div class="panel-head event_title">
											<h2 class="heading">
												<a href="<?php echo $hrefC ?>"><?php echo $vals['title'] ?></a>
											</h2>
										</div>
										<?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
											<ul class="uk-grid lib-grid-20 <?php echo (($Catalog_goc['isfooter'] == 1 || $Catalog_goc['isfooter'] == 2 ) ? 'uk-grid-width-1-2 uk-grid-width-medium-1-3' : (($Catalog_goc['isfooter'] == 3) ? 'uk-grid-width-1-1 uk-grid-width-medium-1-2' : (($Catalog_goc['isfooter'] == 4) ? 'uk-grid-width-medium-1-2 uk-grid-width-1-1' : (($Catalog_goc['isfooter'] == 5) ? 'uk-grid-width-1-1' :  'uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4')))) ?> list-article"  data-uk-grid-match="{target: '.article .title'}">
												<?php foreach($vals['post'] as $key => $val) { ?> 
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
							                                	<?php if ($Catalog_goc['isfooter'] == 5): ?>
							                                   		<div class="date_start_">
							                                        	<?php 
							                                        		$time_arr = explode('-', $val['date_start']);
							                                        		if (isset($time_arr) && is_array($time_arr) && count($time_arr)) {
							                                        			echo '<div class="time_start">';
								                                        			echo "<span class=\"day_time\">".$time_arr[0]."</span>";
								                                        			echo "<span class=\"line_time\">".$this->lang->line('month')." ".$time_arr[1].".".$time_arr[2]."</span>";
								                                        		echo "</div>";
							                                        		}
							                                        	?>
							                                    	</div>
							                                    <?php endif ?>
							                                    <div class="admissions">
								                                	<div class="top_articles">
									                                    <h3 class="title">
									                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
									                                            <?php echo $val['title'] ?>
									                                        </a>
									                                    </h3>
									                                    <?php if ($Catalog_goc['isfooter'] == 5){ ?>
																			<div class="ic_time"><?php echo $val['time_start'] ?></div>
																			<div class="address_start_"><?php echo $val['address'] ?></div>
																		<?php }else{ ?>
									                                    	<span class="view_detail">  <?php echo $created ?> - <?php echo $view ?> <?php echo $this->lang->line('viewed') ?></span>
									                                    <?php } ?>
								                                    </div>
								                                    <?php if ($Catalog_goc['isfooter'] == 3 || $Catalog_goc['isfooter'] == 4 || $Catalog_goc['isfooter'] == 5): ?>
								                                   		<div class="description">
								                                        	<?php echo $description ?>
								                                    	</div>
								                                    <?php endif ?>
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
										<?php endif ?>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					<?php endif ?>
				<?php endif ?>

				<?php if ($Catalog_goc['isfooter'] == 1 && $DetailCatalogues['parentid'] == 0): ?>
					<?php if (isset($articles_hot) && is_array($articles_hot) && count($articles_hot)): ?>
						<div class="articles_hot_cat">
							<ul class="uk-grid lib-grid-20 uk-grid-width-1-1 uk-grid-width-small-1-2">
								<?php foreach ($articles_hot as $key => $val) { ?>
									<?php 
										$title = $val['title'];
										$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
										$image = getthumb($val['images'], TRUE);
									?>
									<li class="mb20">
			                            <article class="uk-clearfix article">
			                                <div class="thumb relative">
			                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $title ?>">
			                                        <img src="<?php echo $image ?>" alt="<?php echo $title ?>">
			                                        <h3 class="title"><?php echo $title ?></h3>
			                                    </a>
			                                </div>
			                            </article>
			                        </li>
								<?php } ?>
							</ul>
						</div>
					<?php endif ?>
				<?php endif ?>
				<?php if ($Catalog_goc['isfooter'] == 2 || $Catalog_goc['isfooter'] == 4) { ?>
					<?php if ($Catalog_goc['isfooter'] == 2){ ?>
						<section class="box_hotro_sunghiep">
							<?php if (isset($cataloghome) && is_array($cataloghome) && count($cataloghome)) { ?>
								<div class="uk-grid">
									<?php foreach ($cataloghome as $key => $vals) { ?>
										<?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles_catalogues'); ?>
										<?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
											<div class="uk-width-large-1-3 mb20">
												<section class="box-column">
													<?php foreach ($vals['post'] as $keya => $val) { ?>
														<?php
															$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
															$image = getthumb($val['images'], TRUE);
														?>
														<?php if ($keya == 0) { ?>
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
									                                    </div>
									                                </div>
								                                </div>
								                            </article>
														<?php }else{ ?>
															<div class="articles_child">
						                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
						                                            <?php echo $val['title'] ?>
						                                        </a>
						                                    </div>
														<?php } ?>
													<?php } ?>
												</section>
												<div class="uk-flex uk-flex-middle uk-flex-left mt20">
													<a href="<?php echo $hrefC ?>" title="Xem tất cả" class="view_all">
														<?php echo $this->lang->line('view-more') ?>
													</a>
												</div>
											</div>
										<?php endif ?>
									<?php } ?>
								</div>
							<?php }else{ ?>
								<?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)){ ?>
									<ul class="uk-grid lib-grid-20 <?php echo (($Catalog_goc['isfooter'] == 1 || $Catalog_goc['isfooter'] == 2 ) ? 'uk-grid-width-1-2 uk-grid-width-medium-1-3' : (($Catalog_goc['isfooter'] == 3) ? 'uk-grid-width-1-1 uk-grid-width-medium-1-2' : (($Catalog_goc['isfooter'] == 4) ? 'uk-grid-width-medium-1-2 uk-grid-width-1-1' : (($Catalog_goc['isfooter'] == 5) ? 'uk-grid-width-1-1' :  'uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4')))) ?> list-article"  data-uk-grid-match="{target: '.article .title'}">
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
					                                	<?php if ($Catalog_goc['isfooter'] == 5): ?>
					                                   		<div class="date_start_">
					                                        	<?php 
					                                        		$time_arr = explode('-', $val['date_start']);
					                                        		if (isset($time_arr) && is_array($time_arr) && count($time_arr)) {
					                                        			echo '<div class="time_start">';
						                                        			echo "<span class=\"day_time\">".$time_arr[0]."</span>";
						                                        			echo "<span class=\"line_time\">".$this->lang->line('month')." ".$time_arr[1].".".$time_arr[2]."</span>";
						                                        		echo "</div>";
					                                        		}
					                                        	?>
					                                    	</div>
					                                    <?php endif ?>
					                                    <div class="admissions">
						                                	<div class="top_articles">
							                                    <h3 class="title">
							                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
							                                            <?php echo $val['title'] ?>
							                                        </a>
							                                    </h3>
							                                    <?php if ($Catalog_goc['isfooter'] == 5){ ?>
																	<div class="ic_time"><?php echo $val['time_start'] ?></div>
																	<div class="address_start_"><?php echo $val['address'] ?></div>
																<?php }else{ ?>
							                                    	<span class="view_detail">  <?php echo $created ?> - <?php echo $view ?> <?php echo $this->lang->line('viewed') ?></span>
							                                    <?php } ?>
						                                    </div>
						                                    <?php if ($Catalog_goc['isfooter'] == 3 || $Catalog_goc['isfooter'] == 4 || $Catalog_goc['isfooter'] == 5): ?>
						                                   		<div class="description">
						                                        	<?php echo $description ?>
						                                    	</div>
						                                    <?php endif ?>
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
									<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
								<?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>';} ?>
							<?php } ?>
						</section>
					<?php }else{ ?>
						<!-- -->
						<?php if (isset($cataloghome) && is_array($cataloghome) && count($cataloghome)) { ?>
								<div class="uk-grid">
									<?php foreach ($cataloghome as $key => $vals) { ?>
										<?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
										<?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
											<div class="uk-width-large-1-2 mb20">
												<?php foreach ($vals['post'] as $keya => $val) { ?>
													<?php 
														//$title = $val['title'];
														$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
														$image = getthumb($val['images'], TRUE);
														$description = cutnchar(strip_tags($val['description']),450);
														$title = cutnchar(strip_tags($val['title']),250);
														$created = show_time($val['created'], 'd/m/Y');
														$view = $val['viewed'];$list_cat = Load_catagoies(json_decode($val['catalogues'], TRUE), 'articles');
													?>
							                        <div class="mb20 list-article">
							                            <article class="uk-clearfix article relative">
							                                <div class="thumb">
							                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
							                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
							                                    </a>
							                                </div>
							                                <div class="infor uk-clearfix ">
							                                	<?php if ($Catalog_goc['isfooter'] == 5): ?>
							                                   		<div class="date_start_">
							                                        	<?php 
							                                        		$time_arr = explode('-', $val['date_start']);
							                                        		if (isset($time_arr) && is_array($time_arr) && count($time_arr)) {
							                                        			echo '<div class="time_start">';
								                                        			echo "<span class=\"day_time\">".$time_arr[0]."</span>";
								                                        			echo "<span class=\"line_time\">".$this->lang->line('month')." ".$time_arr[1].".".$time_arr[2]."</span>";
								                                        		echo "</div>";
							                                        		}
							                                        	?>
							                                    	</div>
							                                    <?php endif ?>
							                                    <div class="admissions">
								                                	<div class="top_articles">
									                                    <h3 class="title">
									                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
									                                            <?php echo $val['title'] ?>
									                                        </a>
									                                    </h3>
									                                    <?php if ($Catalog_goc['isfooter'] == 5){ ?>
																			<div class="ic_time"><?php echo $val['time_start'] ?></div>
																			<div class="address_start_"><?php echo $val['address'] ?></div>
																		<?php }else{ ?>
									                                    	<span class="view_detail">  <?php echo $created ?> - <?php echo $view ?> <?php echo $this->lang->line('viewed') ?></span>
									                                    <?php } ?>
								                                    </div>
								                                    <?php if ($Catalog_goc['isfooter'] == 3 || $Catalog_goc['isfooter'] == 4 || $Catalog_goc['isfooter'] == 5): ?>
								                                   		<div class="description">
								                                        	<?php echo $description ?>
								                                    	</div>
								                                    <?php endif ?>
								                                    <div class="morecat mt5">
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
							                        </div>
												<?php } ?>
											</div>
										<?php endif ?>
									<?php } ?>
								</div>
							<?php }else{ ?>
								<?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)){ ?>
									<ul class="uk-grid lib-grid-20 <?php echo (($Catalog_goc['isfooter'] == 1 || $Catalog_goc['isfooter'] == 2 ) ? 'uk-grid-width-1-2 uk-grid-width-medium-1-3' : (($Catalog_goc['isfooter'] == 3) ? 'uk-grid-width-1-1 uk-grid-width-medium-1-2' : (($Catalog_goc['isfooter'] == 4) ? 'uk-grid-width-medium-1-2 uk-grid-width-1-1' : (($Catalog_goc['isfooter'] == 5) ? 'uk-grid-width-1-1' :  'uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4')))) ?> list-article"  data-uk-grid-match="{target: '.article .title'}">
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
					                                	<?php if ($Catalog_goc['isfooter'] == 5): ?>
					                                   		<div class="date_start_">
					                                        	<?php 
					                                        		$time_arr = explode('-', $val['date_start']);
					                                        		if (isset($time_arr) && is_array($time_arr) && count($time_arr)) {
					                                        			echo '<div class="time_start">';
						                                        			echo "<span class=\"day_time\">".$time_arr[0]."</span>";
						                                        			echo "<span class=\"line_time\">".$this->lang->line('month')." ".$time_arr[1].".".$time_arr[2]."</span>";
						                                        		echo "</div>";
					                                        		}
					                                        	?>
					                                    	</div>
					                                    <?php endif ?>
					                                    <div class="admissions">
						                                	<div class="top_articles">
							                                    <h3 class="title">
							                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
							                                            <?php echo $val['title'] ?>
							                                        </a>
							                                    </h3>
							                                    <?php if ($Catalog_goc['isfooter'] == 5){ ?>
																	<div class="ic_time"><?php echo $val['time_start'] ?></div>
																	<div class="address_start_"><?php echo $val['address'] ?></div>
																<?php }else{ ?>
							                                    	<span class="view_detail">  <?php echo $created ?> - <?php echo $view ?> <?php echo $this->lang->line('viewed') ?></span>
							                                    <?php } ?>
						                                    </div>
						                                    <?php if ($Catalog_goc['isfooter'] == 3 || $Catalog_goc['isfooter'] == 4 || $Catalog_goc['isfooter'] == 5): ?>
						                                   		<div class="description">
						                                        	<?php echo $description ?>
						                                    	</div>
						                                    <?php endif ?>
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
									<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
								<?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>';} ?>
							<?php } ?>
							<!-- -->
					<?php } ?>
				<?php }else{ ?>
					<?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList) && $Catalog_goc['isfooter'] == 3 && $DetailCatalogues['parentid'] != 0){ ?>
						<ul class="uk-grid lib-grid-20 <?php echo (($Catalog_goc['isfooter'] == 1 || $Catalog_goc['isfooter'] == 2) ? 'uk-grid-width-1-2 uk-grid-width-medium-1-3' : (($Catalog_goc['isfooter'] == 3) ? 'uk-grid-width-1-1 uk-grid-width-medium-1-2' : (($Catalog_goc['isfooter'] == 4) ? 'uk-grid-width-medium-1-2 uk-grid-width-1-1' : (($Catalog_goc['isfooter'] == 5) ? 'uk-grid-width-1-1' : (($Catalog_goc['isfooter'] == 6 && $DetailCatalogues['isfooter'] == 7) ? 'uk-grid-width-1-2 uk-grid-width-medium-1-3' :  'uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4'))))) ?> list-article"  data-uk-grid-match="{target: '.article .title'}">
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
		                            <article class="uk-clearfix article <?php echo (($DetailCatalogues['isfooter'] == 7) ? 'student' : (($DetailCatalogues['isfooter'] == 8) ? 'videos' : '')) ?> relative">
		                                <div class="thumb">
		                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
		                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
		                                    </a>
		                                </div>
		                                <div class="infor uk-clearfix ">
		                                	<?php if ($Catalog_goc['isfooter'] == 5): ?>
		                                   		<div class="date_start_">
		                                        	<?php 
		                                        	if (!empty($val['date_start'])) {
		                                        		$time_arr = explode('-', $val['date_start']);
		                                        		if (isset($time_arr) && is_array($time_arr) && count($time_arr) >=1) {
		                                        			echo '<div class="time_start">';
			                                        			echo "<span class=\"day_time\">".$time_arr[0]."</span>";
			                                        			echo "<span class=\"line_time\">".$this->lang->line('month')." ".$time_arr[1].".".$time_arr[2]."</span>";
			                                        		echo "</div>";
		                                        		}
		                                        	}
		                                        	?>
		                                    	</div>
		                                    <?php endif ?>
		                                    <div class="admissions">
			                                	<div class="top_articles">
				                                    <h3 class="title">
				                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
				                                            <?php echo $val['title'] ?>
				                                        </a>
				                                    </h3>
				                                    <?php if ($Catalog_goc['isfooter'] == 6 && ($DetailCatalogues['isfooter'] == 7 || $DetailCatalogues['isfooter'] == 8)){ ?>
														<div class="description mb10"><?php echo $val['description']; ?>
				                                    <?php } ?>
				                                    <?php if ($Catalog_goc['isfooter'] == 5){ ?>
														<div class="ic_time"><?php echo $val['time_start'] ?></div>
														<div class="address_start_"><?php echo $val['address'] ?></div>
													<?php }else{ ?>
				                                    	<span class="view_detail">  <?php echo $created ?> - <?php echo $view ?> <?php echo $this->lang->line('viewed') ?></span>
				                                    <?php } ?>
			                                    </div>
			                                    <?php if ($Catalog_goc['isfooter'] == 3 || $Catalog_goc['isfooter'] == 4 || $Catalog_goc['isfooter'] == 5): ?>
			                                   		<div class="description">
			                                        	<?php echo $description ?>
			                                    	</div>
			                                    <?php endif ?>
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
						<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
					<?php }else{ echo (($Catalog_goc['isfooter'] == 3 && $DetailCatalogues['parentid'] == 0) ? '' : '<div class="mt10">'.$this->lang->line('no_data_table').'</div>');} ?>
				<?php } ?>
			</section>
			<?php if ($Catalog_goc['isfooter'] == 6): ?>
				<?php if (isset($articles_student) && is_array($articles_student) && count($articles_student)): ?>
					<?php foreach ($articles_student as $key => $vals) { ?>
						<?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
							<section class="articles_student uk-text-center mb30">
								<header class="panel-head">
									<h2 class="heading"><span><?php echo $this->lang->line('feel-student') ?></span></h2>
								</header>
								<section class="panel-body">
									<div id="home-slideshow" class="uk-slidenav-position" data-uk-slideshow="{autoplay: true, autoplayInterval: 4500}">
		    							<ul class="uk-slideshow list-article-student">
											<?php foreach ($vals['post'] as $key => $val) { ?> 
												<?php 
													$title = $val['title'];
													$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
													$image = getthumb($val['images'], TRUE);
													$description = cutnchar(strip_tags($val['content']),450);
													$created = show_time($val['created'], 'd/m/Y');
													$view = $val['viewed'];
												?>
						                        <li>
						                            <article class="article-student">
						                            	<div class="content">
				                                        	<?php echo $description ?>
				                                    	</div>
						                                <div class="thumb">
						                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
						                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
						                                    </a>
						                                </div>
						                                <div class="infor">
						                                    <h3 class="title">
					                                            <?php echo $val['title'] ?>
						                                    </h3>
						                                    <div class="description">
					                                        	<?php echo $val['description'] ?>
					                                    	</div>
						                                </div>
						                            </article>
						                        </li>
											<?php } ?>
										</ul>
										<ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center mb10">
							                <?php foreach($articles_student as $key1 => $vals){ ?>
							                    <li data-uk-slideshow-item="<?php echo $key1 ?>"><a href=""></a></li>
							                <?php } ?>
							            </ul>
									</div>
								</section>
							</section>
						<?php endif ?>
					<?php } ?>
				<?php endif ?>
			<?php endif ?>
		</div>
	</section><!-- .article-catalogue -->
</div>
