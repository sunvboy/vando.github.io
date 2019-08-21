<div id="search-page" class="page-body">	
	<div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li><a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>"><i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a></li>
				<li><a href="" title="<?php echo $this->lang->line('search') ?>"><?php echo $this->lang->line('search') ?> </a></li>
				<?php echo ((isset($keys)) ? '<li class="uk-active"><a>'.$keys.'</a></li>' : '') ?>
			</ul>
		</div>
	</div>
	<section class="search-page">
		<div class="uk-container uk-container-center">
			<section class="artcatalogue">
				<?php if(isset($result) && is_array($result) && count($result)){ ?>
					<section class="panel-body panel-article">
						<ul class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 list-article">
							<?php foreach($result as $key => $val) { ?> 
							<?php 
								$title = $val['title'];
								$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
								$image = getthumb($val['images']);
								$description = cutnchar(strip_tags($val['description']), 250);
								$created = show_time($val['created'], 'd/m/Y');
								$view = $val['viewed'];
							?>
							<li>
								<div class="uk-clearfix article">
                                	<div class="thumb relative">
                                        <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $title ?>">
                                            <img src="<?php echo $image ?>" alt="<?php echo $title ?>">
                                            <i class="fa fa-align-justify"></i>
                                        </a>
                                    </div>
                                    <div class="infor">
                                    	<h3 class="main-title">
											<a href="<?php echo $href ?>" title="<?php echo $title ?>">
                                                <?php echo $title ?>
                                            </a>
										</h3>
										<div class="meta mb5"><?php echo $created.' - '.$val['viewed'].' '.$this->lang->line('viewed') ?></div>
                                    </div>
								</div>
							</li>
							
							<?php } ?>
						</ul>
						<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
					</section> <!-- .panel-body -->
				<?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>';} ?>
			</section>
		</div>
	</section>
</div>