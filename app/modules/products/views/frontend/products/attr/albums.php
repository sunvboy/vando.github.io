<?php $gallerys = json_decode($DetailProducts['albums'], TRUE);
?>
<div class="slick-slider12 " >
    <img src="<?php echo $DetailProducts['images'] ?>" alt="<?php echo $DetailProducts['title'] ?>">
</div>

<div class="slick-slider">
    <div id="slider-owl" class="mt-list mt-clearfix owl-carousel">
        <div>
            <a href="javascript:void(0);" data-src="<?php echo $DetailProducts['images'] ?>">
                <img class="active-img"  src="<?php echo getthumb($DetailProducts['images'], TRUE) ?>"  alt="<?php echo $DetailProducts['title'] ?>" data-source="<?php echo $DetailProducts['source'] ?>" data-stt="1/<?php echo(count($gallerys) + 1) ?>">
            </a>
        </div>
        <?php if (isset($gallerys) && is_array($gallerys) && count($gallerys)): ?>
            <?php foreach ($gallerys as $key => $val): ?>
                <div class="<?php echo((!empty($DetailProducts['source'])) ? 'player_' : '') ?>">
                    <a href="javascript:void(0);" data-src="<?php echo $val['images'] ?>">
                        <img src="<?php echo getthumb($val['images'], TRUE) ?>" alt="<?php echo $DetailProducts['title'] ?>" data-source="<?php echo $DetailProducts['source'] ?>" data-stt="<?php echo ($key + 2) . '/' . (count($gallerys) + 1) ?>">
                    </a>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <script>
        $(document).ready(function () {
            var owl = $('#slider-owl').owlCarousel({
                loop: false,
                margin: 5,
                nav: false,
                dots: true,
                items: 4,
                responsive: {
                    0: {
                        items: 1,
                        dots: false,
                    },
                    600: {
                        items: 1,
                        dots: false,
                    },
                    1000: {
                        items: 4
                    },
                }
            })
            $(".next").click(function () {
                owl.trigger('next.owl.carousel');
                $('.owl-item.active img').trigger('click')
            })
            $(".prev").click(function () {
                owl.trigger('prev.owl.carousel');
                $('.owl-item.active img').trigger('click')
            })
        })
    </script>
</div>