<?php 
	$partner_slide = $this->FrontendSlides_Model->Read('partner');
?>
<?php if(isset($partner_slide) && is_array($partner_slide) && count($partner_slide)){ ?>
<section id="slide-partner" class="margin-bottom-25">
	<div class="uk-container uk-container-center">
		<div class="uk-panel">
			<div class="uk-slidenav-position" data-uk-slider>
			    <div class="uk-slider-container">
			        <ul class="uk-slider fc-list uk-grid uk-grid-width-medium-1-3 uk-grid-width-small-1-2">
					<?php foreach($partner_slide as $key => $val){ ?>
			            <li class="item">
			            	<a href="<?php echo $val['url'] ?>" title="<?php echo $val['title'] ?>"><img src="<?php echo $val['image'] ?>" alt="<?php echo $val['url'] ?>"></a>
			            </li>
					<?php } ?>
			        </ul>
			    </div><!-- end .uk-slider-container -->
			    <a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slider-item="previous" draggable="false"></a>
				<a href="" class="uk-slidenav uk-slidenav-next" data-uk-slider-item="next" draggable="false"></a>
			</div>
		</div>
	</div><!-- end .uk-container -->
</section><!-- end #slide-partner -->
<?php } ?>