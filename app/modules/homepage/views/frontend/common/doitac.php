
<?php $doitac = $this->FrontendSlides_Model->Read('partner', $this->fc_lang);?>
<?php if(isset($doitac) && is_array($doitac) && count($doitac)){ ?>
	<section class="partner-section">
        <div class="uk-container uk-container-center">
    	 	<header class="panel-head uk-text-center">
                <h2 class="heading"><span>Các đối tác quốc tế hàng đầu</span></h2>
            </header>
	      	<div class="slider-items owl-carousel mt20">
				<?php foreach($doitac as $key => $val){ ?>
					<div class="box_partner">
						<div class="thumb">
							<a class="image img-scaledown" href="<?php echo $val['url'] ?>" target="_blank">
								<img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title']; ?>">
							</a>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<script type="text/javascript">
    //<![CDATA[
        $(document).ready(function() {
            $(".partner-section .slider-items").owlCarousel({
                loop: true,
                margin: 25,
                autoPlay: true,
                nav:false,
                dots: false,
                items: 6,
                responsive:{
			        0:{
			            items: 2,
			            nav:false
			        },
			        600:{
			            items: 3,
			            nav:false
			        },
			        1000:{
			            items: 6,
			            nav:false,
			            loop:false
			        }
			    }
             });
        }); 
    //]]>
    </script>
<?php } ?>