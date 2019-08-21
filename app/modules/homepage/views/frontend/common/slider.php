
<?php $slide = $this->FrontendSlides_Model->Read('index-slide', $this->fc_lang); ?>
<?php if(isset($slide) && is_array($slide) && count($slide)){ ?>
    <div class="slider-main-top">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php foreach($slide as $key => $val){ ?>
                    <div class="carousel-item <?php echo (($key == 0) ? 'active' : '') ?>">
                        <a href="<?php echo $val['url'] ?>" class="d-block w-100">
                            <img src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>" />
                        </a>
                    </div>
                <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
<?php } ?>