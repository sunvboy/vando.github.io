
<?php $doitac = $this->FrontendSlides_Model->Read('doi-tac-truong', $this->fc_lang); ?>
<?php if(isset($doitac) && is_array($doitac) && count($doitac)){ ?>
	<section class="partner panel">
		<div class="uk-container uk-container-center">
			<section class="panel-body">
	      		<div class="uk-slidenav-position slider" data-uk-slider="{autoplay: true, autoplayInterval: 10000}">
	          		<div class="uk-slider-container">
			          	<ul class="uk-slider uk-grid lib-grid-5 uk-grid-width-1-3 uk-grid-width-small-1-4 uk-grid-width-medium-1-6 list">
							<?php foreach($doitac as $key => $val){ ?>
								<li>
									<div class="thumb">
										<a class="image img-scaledown" href="<?php echo $val['image'] ?>">
											<img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title']; ?>">
										</a>
									</div>
								</li>
							<?php } ?>
						</ul>
						<a href="" class="uk-slide-prev uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
						<a href="" class="uk-slide-next uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
					</div>
				</div>
			</section>
		</div>
	</section><!-- .panel-body -->
<?php } ?>
				            