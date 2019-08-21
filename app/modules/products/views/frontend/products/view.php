<main id="main-site">
    <section class="sec-main-page">
        <div class="container">
            <div class="wp-img-ctsp">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="wp-img-left">
                            <div class="tab-content">
                                <style>
                                    @media (min-width: 1200px) {
                                        .wp-sautab img{
                                            height: 435px;
                                        }
                                    }
                                </style>

                                <?php
                                $ReadByFieldProductsColors = $this->FrontendSaleDG_Model->ReadByFieldProductsColors('productsid', $DetailProducts['id']);
                                ?>
                                <?php if (isset($ReadByFieldProductsColors) && is_array($ReadByFieldProductsColors) && count($ReadByFieldProductsColors)) { ?>
                                    <?php foreach ($ReadByFieldProductsColors as $keyColor => $valColor) { ?>
                                        <div id="img-id<?php echo $valColor['id']?>"  class="tab-pane fade row <?php if($keyColor==0){?>active in<?php }?>">
                                            <?php
                                            for ($i = 0; $i <= 9; $i++) {
                                            if (!empty($valColor['images_' . $i . ''])) {
                                            ?>
                                            <div class="wp-sautab img-cover col-md-6 col-xs-6 col-sm-6">
                                               <img src="<?php echo $valColor['images_' . $i . ''] ?>">
                                            </div>
                                            <?php } ?>
                                            <?php } ?>
                                        </div>
                                    <?php }?>
                                <?php }else{?>
                                    <div class="tab-pane fade active in  row">
                                        <?php $list_albums = json_decode($DetailProducts['albums'],TRUE);?>
                                        <?php if (isset($list_albums) && is_array($list_albums) && count($list_albums)) { ?>
                                            <?php foreach($list_albums as $key=>$val){?>
                                                <div class="wp-sautab img-cover col-md-6 col-xs-6 col-sm-6">
                                                    <img src="<?php echo $val['images']?>" alt="<?php echo $DetailProducts['title']?>">
                                                </div>
                                            <?php }?>
                                        <?php }?>
                                    </div>
                                <?php }?>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="wp-text-right">
                            <h1 class="h1-title-ctsp"><?php echo $DetailProducts['title'] ?></h1>
                            <div class="price-ctsp">
                                <span class="int"><?php echo $DetailProductsgia?></span>
                            </div>
                            <div class="wpmaxx">
                                <?php if($DetailProducts['code']!= ''){?>
                                <p>Mã sản phẩm: <?php echo $DetailProducts['code']?></p>
                                <?php }?>
                                <p>Trạng thái: <?php echo $this->configbie->data('status', ((!empty($DetailProducts['status'])) ? 1 : 0)) ?></p>
                            </div>
                            <?php if (isset($ReadByFieldProductsColors) && is_array($ReadByFieldProductsColors) && count($ReadByFieldProductsColors)) { ?>
                            <div class="wp-chonmau">
                                <ul class="nav nav-pills">
                                    <?php foreach ($ReadByFieldProductsColors as $keyColor => $valColor) { ?>
                                    <li class="chose_attr_advanced_color <?php if($keyColor==0){?>active<?php }?>" data-title="<?php echo $valColor['title']?>"><a class=""  data-toggle="pill" href="#img-id<?php echo $valColor['id']?>"><span class="color color4" style="background: url('<?php echo $valColor['images'] ?>')"></span></a></li>
                                    <?php }?>
                                </ul>
                            </div>
                            <?php }?>
                            <?php
                            $size = $this->Autoload_Model->_get_where(array(
                                'select' => 'id, title, saleoff,productsid',
                                'table' => 'products_size',
                                'where' => array('productsid' => $DetailProducts['id']),
                                'order_by' => 'id asc'
                            ), TRUE);
                            ?>
                            <?php if (isset($size) && is_array($size) && count($size)){ ?>
                            <div class="wp-chonsize">
                                <ul class="ul-b list-size">
                                    <?php foreach ($size as $key=>$val): ?>
                                        <li><a href="<?php echo $urlbl?>#" class="filtersize <?php if($key==0){?>active<?php }?>" data-title="<?php echo $val['title']?>" data-saleoff="<?php echo !empty($val['saleoff']>0)?$val['saleoff']:$prdsaleoff?>" data-id="<?php echo $val['id']?> "><?php echo $val['title'] ?></a> </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                            <?php }?>

                            <style>
                                .wp-chonsize ul li a.active {
                                    font-family: Mon2;
                                    font-size: 14px;
                                    text-decoration: underline;
                                }
                            </style>

                            <?php echo $this->load->view('homepage/frontend/common/dosize')?>
                            <?php if($this->fcSystem['UUDAI_title'] != ''){?>
                            <div class="wwp-uudai-rieng">

                                <p><?php echo $this->fcSystem['UUDAI_title']?></p>
                                <p class="b"><?php echo $this->fcSystem['UUDAI_description']?>&nbsp;<i class="fas fa-question-circle"></i></p>
                            </div>
                            <?php }?>
                            <div class="wp-btn-mua">
                                <button class="ajax-addtocart"  data-quantity="1" data-id="<?php echo $DetailProducts['id'] ?>" data-redirect="redirect" data-price="<?php echo $prdsaleoff?>" data-size="" data-color="">Mua ngay&nbsp;<i class="fas fa-shopping-bag"></i></button>
                            </div>

                            <script>
                                load_size_price();
                                $(document).on('click', '.filtersize', function () {
                                    $('.filtersize').removeClass('active');
                                    $(this).parent().find('.filtersize').addClass('active');
                                    load_size_price();
                                });
                                function load_size_price(){
                                    $('.filtersize.active').each(function(){
                                        var title = $(this).data('title');
                                        var saleoff = $(this).data('saleoff');
                                        $('.ajax-addtocart').attr('data-size', title);
                                    });
                                }
                                load_album_color();
                                $(document).on('click', '.chose_attr_advanced_color', function () {
                                    var title = $(this).data('title');
                                    load_album_color();
                                });
                                function load_album_color(){
                                    $('.chose_attr_advanced_color.active').each(function(){
                                        var title = $(this).data('title');
                                        $('.ajax-addtocart').attr('data-color', title);

                                    });

                                }

                            </script>
                            <?php $adversite3 = $this->FrontendSlides_Model->Read('adversite-3', $this->fc_lang); ?>
                            <?php if(isset($adversite3) && is_array($adversite3) && count($adversite3)){ ?>
                            <div class="wp-list-dinhvu2">
                                <ul class="ul-b lits-dv2">
                                    <?php foreach($adversite3 as $key => $val){ ?>
                                    <li>
                                        <div class="icon-dv2">
                                            <img src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>">
                                        </div>
                                        <div class="text-dv2">
                                            <p><?php echo $val['title']; ?></p>
                                            <span><?php echo $val['description']; ?></span>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } ?>

                            <div class="wp-tab-mota">
                                <ul class="nav nav-pills">
                                    <li class="active"><a data-toggle="pill" href="#tab-mt-1"><span>MÔ tả</span></a></li>
                                    <li><a data-toggle="pill" href="#tab-mt-2"><span>Phí ship</span></a></li>
                                    <li><a data-toggle="pill" href="#tab-mt-3"><span>Đổi trả</span></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-mt-1" class="tab-pane fade in active">
                                        <div class="wp-sautab">
                                            <p><?php echo strip_tags($DetailProducts['description']) ?></p>
                                        </div>
                                    </div>
                                    <div id="tab-mt-2" class="tab-pane fade">
                                        <div class="wp-sautab">
                                            <?php echo strip_tags($this->fcSystem['common_phiship']) ?>
                                        </div>
                                    </div>
                                    <div id="tab-mt-3" class="tab-pane fade">
                                        <div class="wp-sautab">
                                            <?php echo strip_tags($this->fcSystem['common_doitra']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wp-form-sdt">

                                <?php echo $this->load->view('homepage/frontend/common/subscribe')?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end wp-img-ctsp -->
            <?php echo $this->load->view('homepage/frontend/common/comments')?>
            <!-- end review -->
            <div class="box-datmua">
                <div class="wp-icon">
                    <img src="templates/frontend/images/icon-c4.svg" alt="">
                </div>
                <div class="wp-text">
                    <p>Sản phẩm đặc biệt dành cho:</p>
                    <p>Ngực xệ, cho con bú, muốn nâng đỡ ngực:</p>
                </div>
                <div class="wp-btn">
                    <button>ĐẶT MUA</button>
                </div>
            </div>
            <!-- end box dat mua -->
            <?php if (isset($products_same) && is_array($products_same) && count($products_same)): ?>
            <div class="sp-quantam">
                <div class="wp-title-spqt">
                    <h2 class="h2-title">Có thể bạn quan tâm</h2>
                </div>
                <div class="wp-list-sp-home">
                    <div class="row">
                        <?php foreach ($products_same as $key => $val): ?>
                            <?php
                            $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                            if ($val['active_phamtramgiamgia'] == 0) {
                                $price = $val['price'];
                                $saleoff = $val['saleoff'];
                                if ($price > 0) {
                                    $pri_old = '<span class="span-gia">' . str_replace(',', '.', number_format($price)) . '</span>';
                                } else {
                                    $pri_old = '';
                                }
                                if ($saleoff > 0) {
                                    $pri_sale = str_replace(',', '.', number_format($saleoff));
                                } else {
                                    $pri_sale = 'LiÃªn há»‡';
                                }
                                if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                                    $number_sale = ceil((($price - $saleoff) / $price) * 100);
                                } else {
                                    $number_sale = '';
                                }


                            } else {
                                $price = $val['saleoff'];
                                $saleoff = $val['saleoff'] / 100 * $val['tmp_active_phamtramgiamgia'];
                                if ($price > 0) {
                                    $pri_old = '<span class="span-gia">' . str_replace(',', '.', number_format($price)) . '</span>';
                                } else {
                                    $pri_old = '';
                                }
                                if ($saleoff > 0) {
                                    $pri_sale = str_replace(',', '.', number_format($saleoff));
                                } else {
                                    $pri_sale = 'LiÃªn há»‡';
                                }
                                if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                                    $number_sale = ceil((($price - $saleoff) / $price) * 100);
                                } else {
                                    $number_sale = '';
                                }

                            }
                            $ReadByFieldProductsColors = $this->FrontendSaleDG_Model->ReadByFieldProductsColors('productsid', $val['id']);
                            ?>
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div class="wp-item-sp">
                                    <?php if (!empty($price) && !empty($saleoff) && $price > $saleoff) { ?>
                                        <div class="robbin-sale">
                                            <span>sale <br> <?php echo $number_sale ?>%</span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($ReadByFieldProductsColors) && is_array($ReadByFieldProductsColors) && count($ReadByFieldProductsColors)) { ?>
                                        <div class="wp-list-sp-slide">
                                            <?php foreach ($ReadByFieldProductsColors as $keyColor => $valColor) { ?>
                                                <div
                                                    class="wp-item-sp-main <?php if ($keyColor == 0) { ?>active<?php } ?>">
                                                    <div id="" class="slide-sp owl-carousel owl-theme">
                                                        <?php
                                                        for ($i = 0; $i <= 9; $i++) {
                                                            if (!empty($valColor['images_' . $i . ''])) {
                                                                ?>
                                                                <div class="item">
                                                                    <div class="wp-img-slide-sp">
                                                                        <a href="<?php echo $href ?>"
                                                                           title="<?php echo $valColor['title'] ?>"><img
                                                                                src="<?php echo $valColor['images_' . $i . ''] ?>"></a>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php }else{ ?>
                                        <?php $list_albums = json_decode($val['albums'],TRUE);?>
                                        <?php if (isset($list_albums) && is_array($list_albums) && count($list_albums)) { ?>
                                            <div class="wp-list-sp-slide">
                                                <div class="wp-item-sp-main active">
                                                    <div id="" class="slide-sp owl-carousel owl-theme">
                                                        <?php foreach ($list_albums as $keyAB => $valAB) { ?>
                                                            <div class="item">
                                                                <div class="wp-img-slide-sp">
                                                                    <a href="<?php echo $href ?>" title="<?php echo $valAB['title'] ?>"><img src="<?php echo $valAB['images'] ?>"></a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php }?>
                                    <div class="wp-add-to-cart">
                                        <a href="<?php echo $href ?>">
                                            <span>Thêm vào giỏ hàng</span>
                                            <i class="fas fa-shopping-bag"></i>
                                        </a>
                                    </div>
                                    <div class="wp-name-sp">
                                        <h3 class="h3-title"><a
                                                href="<?php echo $href ?>"><?php echo $val['title'] ?></a></h3>
                                    </div>
                                    <div class="wp-price-sp">
                                        <span class="int"><?php echo $pri_sale ?></span>
                                    </div>
                                    <?php if (isset($ReadByFieldProductsColors) && is_array($ReadByFieldProductsColors) && count($ReadByFieldProductsColors)) { ?>
                                        <div class="wp-list-check-color">
                                            <ul class="ul-b list-color-sp">
                                                <?php foreach ($ReadByFieldProductsColors as $keyColor => $valColor) { ?>
                                                    <li class="item-color color-1 <?php if ($keyColor == 0) { ?>active<?php } ?>">
                                                            <span  style="background: url('<?php echo $valColor['images'] ?>')"></span>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
            <!-- end sp quan tam -->
            <?php endif;?>
            <div class="box-maxx">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="wp-max-giamgia">
                            <div class="wp-box-left-giamgia">
                                <p>Giảm 5% khi nhập mã voucher</p>
                                <div class="form-voucher">
                                    <input type="text" class="form-control" placeholder="MÃ£ giáº£m giÃ¡" value="W001TGH" style="border-radius: 0px;border: 1px solid #000">

                                </div>
                            </div>
                            <div class="wp-box-right-giamgia">


                                <div id="countdown-sale"></div>
                                <script type="text/javascript" src="templates/frontend/js/jquery.countdown.js"></script>

                                <script>
                                    var ts = new Date(2019, 7, 20);
                                    if((new Date()) > ts){
                                    }
                                    jQuery('#countdown-sale').countdown({
                                        timestamp   : ts,
                                    });
                                </script>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="wp-list-danhmuc">
                            <ul class="ul-b list-text-danhmuc">
                                <?php $rank_nav = navigations_array('menu-rank', $this->fc_lang); ?>
                                <?php if (isset($rank_nav) && is_array($rank_nav) && count($rank_nav)) { ?>
                                    <?php foreach ($rank_nav as $key => $vals) { ?>
                                        <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])) { ?>
                                            <li class="wp-li-c1">
                                                <h4 class="h4-title"><?php echo $vals['title'] ?></h4>
                                                <ul class="ul-b sub-danhmuc">
                                                    <?php foreach ($vals['child'] as $keys => $val) { ?>
                                                        <li>
                                                            <a href="<?php echo(($val['href'] == '#') ? 'javascript: void(0)' : $val['href']); ?>"
                                                               title="<?php echo $val['title']; ?>">
                                                                <?php echo $val['title']; ?>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript" src="templates/frontend/js/rangeslider.js"></script>
<script>

    $('.backstep').click(function () {
        $('.range-slider').css('display','block');
        $('.khongcosize').css('display','none');
        $('.sizecuaban').css('display','none');
    });



    $('.btn-close-dosize').click(function () {
        $('.dosize').css('display','none');
        $('.mask').css('display','none');
        $('body').css('overflow-y','auto');
    })

    $('.mask').click(function () {
        $('.dosize').css('display','none');
        $('.mask').css('display','none');
        $('body').css('overflow-y','auto');
    })

    $('.product-dosize span').click(function () {
        $('.dosize').css('display','block');
        $('.mask').css('display','block');
        // $('body').css('overflow-y','hidden');

        $('.range-slider').css('display','block');
        $('.khongcosize').css('display','none');
        $('.sizecuaban').css('display','none');
    })

    $('input[name="participants"]').rangeslider({
        polyfill: false,
        onInit: function () {
            $handle = $('.rangeslider-group1 .rangeslider__handle');
            updateHandle($handle[0], this.value);
        }
    }).on('input', function () {
        updateHandle($handle[0], this.value);
    });

    $('input[name="participants2"]').rangeslider({
        polyfill: false,
        onInit: function () {
            $handle2 = $('.rangeslider-group2 .rangeslider__handle');
            updateHandle($handle2[0], this.value);
        }
    }).on('input', function () {
        updateHandle($handle2[0], this.value);
    });

    $('input[name="participants3"]').rangeslider({
        polyfill: false,
        onInit: function () {
            $handle3 = $('.rangeslider-group3 .rangeslider__handle');
            updateHandle($handle3[0], this.value);
        }
    }).on('input', function () {
        updateHandle($handle3[0], this.value);
    });

    // Update the value inside the slider handle
    function updateHandle(el, val) {
        el.textContent = val;
    }


    $(document).ready(function () {
        $hidden = 0;
        $('.nhomhinhanh').each(function () {
            if($hidden >0){
                $(this).css('display','none');
            }
            $hidden++;
        });

        $hidden = 0;
        $('.nhomsize').each(function () {
            if($hidden >0){
                $(this).css('display','none');
            }
            $hidden++;
        });
        $hidden = 0;
        $('.colort').each(function () {
            if($hidden >0){
                $(this).css('display','none');
            }
            $hidden++;
        });

        $hidden = 0;
        $('.pickcolor').each(function () {
            if($hidden == 0){
                $(this).addClass('pick');
            }
            $hidden++;
        });
    })





</script>

