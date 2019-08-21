<div id="album-page" class="page-body bg-gray">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li><a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>"><i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a></li>
				<?php foreach($Breadcrumb as $key => $val){ ?>
				<?php 
					$title = $val['title'];
					$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'gallerys_catalogues');
				?>
				<li class="uk-active"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<section class="photos-catalogue mt20">
		<div class="uk-container uk-container-center">
			<section class="panel-body bg_white padding20px">
				<?php if(isset($gallerysList) && is_array($gallerysList) && count($gallerysList)){ ?>
					<ul class="uk-grid uk-grid-medium uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 list-photos" data-uk-grid>
						<?php foreach($gallerysList as $keyl => $val) { ?> 
							<?php 
								$title = $val['title'];
								$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'gallerys');
								$image = getthumb($val['images'], FALSE);
								$description = cutnchar(strip_tags($val['description']), 1000);
								$created = show_time($val['created'], 'd/m/Y');
								$albums = json_decode($val['albums'], TRUE);
							?>
							<li class="mb25">
								<div class="photo">
									<div class="thumb">
										<a class="image img-cover" href="<?php echo $val['images'] ?>" data-uk-lightbox="{group:'gallerys-<?php echo ($keyl + 1); ?>'}" title="<?php echo $title ?>">
	                                        <img src="<?php echo $image ?>" alt="<?php echo $title ?>" />
	                                    </a>
									</div>
									<?php if (isset($albums) && is_array($albums) && count($albums)): ?>
										<div class="uk-hidden">
											<?php foreach ($albums as $key => $vals) { ?>
												<a href="<?php echo $vals['images']; ?>" data-uk-lightbox="{group:'gallerys-<?php echo ($keyl + 1); ?>'}" class="img-cover">
													<span></span>
												</a>
											<?php } ?>
										</div>
									<?php endif ?>
									<div class="infor">
										<h3 class="title">
											<a href="<?php echo $href ?>" title="<?php echo $title ?>">
		                                        <?php echo $title ?>
		                                    </a>
										</h3>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
					<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
				<?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>'; } ?>
			</section><!-- .panel-body -->
		</div>
	</section>
</div><!-- .uk-width -->