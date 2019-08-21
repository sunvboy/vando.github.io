<script>
    $('body').removeClass('page-child');
</script>




<main id="main-site">
    <section class="sec-home-01 mb-80">
        <div class="container-fluid pd-0">
            <div class="row row-edit-0 hidden-sm hidden-xs">
                <div class="col-md-6 col-edit-0">
                    <div class="wp-banner">
                        <div class="img-banner">
                            <img class="sample2 el_image" src="<?php echo $this->fcSystem['banner_banner_1']?>" alt="banner1">
                        </div>
                        <div class="text-banner">
                            <a href="<?php echo $this->fcSystem['banner_banner_1l']?>" class="btn btn-default btn-xem btn-hover">Xem thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-edit-0">
                    <div class="wp-banner">
                        <div class="img-banner">
                            <img class="el_image" src="<?php echo $this->fcSystem['banner_banner_2']?>" alt="banner2">
                        </div>
                        <div class="text-banner">
                            <a href="<?php echo $this->fcSystem['banner_banner_2l']?>" class="btn btn-default btn-xem btn-hover">Xem thêm</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-edit-0 hidden-lg hidden-md">
                <div class="col-md-6 col-edit-0">
                    <div class="wp-banner">
                        <div class="img-banner">
                            <img src="<?php echo $this->fcSystem['banner_banner_3']?>" alt="banner3">
                        </div>
                        <div class="text-banner">
                            <a href="<?php echo $this->fcSystem['banner_banner_3l']?>" class="btn btn-default btn-xem btn-hover">Xem thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $adversite1 = $this->FrontendSlides_Model->Read('adversite-1', $this->fc_lang); ?>
    <?php if(isset($adversite1) && is_array($adversite1) && count($adversite1)){ ?>
    <!-- end sec 01 -->
    <section class="sec-home-02 mb-80">
        <div class="container-fluid pd-0">
            <div class="row">
                <?php foreach($adversite1 as $key => $val){ ?>
                    <?php if($key==0){?>
                        <div class="col-md-6 col-sm-6 hidden-xs col-edit-0">
                            <div class="wp-tin wp-tin1">
                                <div class="img-tin">
                                    <a href="<?php echo $val['url'] ?>" class="d-block w-100">
                                        <img class="el_image" src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>" />
                                    </a>
                                </div>
                                <div class="text-tin">
                                    <h2 class="h2-title"><?php echo $val['title']; ?></h2>
                                    <span><?php echo $val['description']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php }else if($key==1){?>
                        <div class="col-md-6 col-sm-6 hidden-xs col-edit-0">
                            <div class="wp-tin wp-tin2 flex-oder">
                                <div class="img-tin">
                                    <a href="<?php echo $val['url'] ?>" class="d-block w-100">
                                        <img class="el_image" src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>" />
                                    </a>
                                </div>
                                <div class="text-tin">
                                    <h2 class="h2-title"><?php echo $val['title']; ?></h2>
                                    <span><?php echo $val['description']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>

            </div>
        </div>
    </section>
    <?php } ?>
    <!-- end sec 02 -->
    <section class="sec-home-03">
        <div class="wp-shopnow hidden-xs">
            <div class="img-bg">
                <img class="el_image" src="<?php echo $this->fcSystem['shopnow_images']?>" alt="banner">
            </div>
            <div class="text-home-03">
                <h2 class="h2-title"><?php echo $this->fcSystem['shopnow_title']?></h2>
                <a href="<?php echo $this->fcSystem['shopnow_links']?>" target="_blank" class="btn btn-default btn-shopnow btn-hover">shop now</a>
            </div>
        </div>
        <?php $home_nav = navigations_array('home', $this->fc_lang); ?>
        <?php if (isset($home_nav) && is_array($home_nav) && count($home_nav)) { ?>
        <div class="wp-suport-1">
            <div class="row">
                <?php foreach ($home_nav as $key => $val) { ?>
                <div class="col-md-4 col-sm-4 hidden-xs">
                    <div class="wp-item-support">
                        <h3 class="h3-title"><?php echo $val['title']; ?></h3>
                        <div class="wp-btn-xemct">
                            <a href="<?php echo(($val['href'] == '#') ? 'javascript: void(0)' : $val['href']); ?>" class="btn btn-default btn-xem-ct btn-hover">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <?php }?>
    </section>
    <!-- end sec 03 -->
    <?php if(isset($product_catalog_ao) && is_array($product_catalog_ao) && count($product_catalog_ao)){?>
    <section class="sec-home-04 mb-20">
        <div class="container-fluid">
            <div class="wp-flash-sale">
                <div class="title-sale">
                    <div class="wp-title-sale">
                        <h2 class="h2-title"><img src="templates/frontend/images/flash_02.png" alt="FLASH SALE">FLASH SALE</h2>
                    </div>
                    <div class="time-sale">
                        <span>KẾT THÚC SAU</span>
                        <link rel="stylesheet" href="templates/flipclock.css">
                        <script src="templates/flipclock.js"></script>
                        <div id="countdown-sale"></div>
                        <!-- js countdown -->
                        <script type="text/javascript">
                            var clock;
                            $(document).ready(function() {
                                // Grab the current date
                                var currentDate = new Date();
                                var futureDate  = new Date('<?php echo $ReadByFieldTungSanPham['time_end'];?>');
                                var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;
                                clock = $('#countdown-sale').FlipClock(diff, {
                                    clockFace: 'DailyCounter',
                                    countdown: true
                                });
                            });
                        </script>
                    </div>
<!--                    <div class="wp-xemthem-sale">-->
<!--                        <a href="#">Xem thêm</a>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="wp-list-sp-sec">
                <div class="row">
                    <?php
                    $result = $this->Autoload_Model->_get_where(array(
                        'select' => 'id, title, slug, canonical, images, description, price, saleoff, status,tmp_tungsanpham',
                        'table' => 'products',
                        'where' => array('publish' =>1, 'trash' => 0),
                        'where_in' => explode('-', $ReadByFieldTungSanPham['id_combo']),
                        'where_in_field' => 'id',
                        'order_by' => 'title desc'
                    ),TRUE);
                    ?>
                    <?php
                    if(isset($result) && is_array($result) && count($result)) {
                    foreach ($result as $key => $val) {
                        $image = getthumb($val['images']);
                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                        $description = cutnchar(strip_tags($val['description']), 250);
                        $price = $val['price'];
                        $saleoff = $val['saleoff'];
                        if ($price > 0) {
                            $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).' đ<span>';
                        }else{
                            $pri_old  = '';
                        }
                        if ($saleoff > 0) {
                            $pri_sale = str_replace(',', '.', number_format($saleoff)).' đ';
                        }else{
                            $pri_sale  = 'Liên hệ';
                        }
                        if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                            $number_sale = ceil((($price - $saleoff)/$price)*100).'%';
                        }else{
                            $number_sale = '';
                        }
                        $ReadByFieldProductsColors = $this->FrontendSaleDG_Model->ReadByFieldProductsColors('productsid',$val['id']);

                    ?>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="wp-item-sp">
                            <?php if (!empty($price) && !empty($saleoff) && $price > $saleoff) {?>
                            <div class="robbin-sale">
                                <span>sale <br> <?php echo $number_sale?></span>
                            </div>
                            <?php }?>
                            <?php if(isset($ReadByFieldProductsColors) && is_array($ReadByFieldProductsColors) && count($ReadByFieldProductsColors)) {?>
                                <div class="wp-list-sp-slide">
                                    <?php foreach ($ReadByFieldProductsColors as $keyColor => $valColor) {?>
                                        <div class="wp-item-sp-main <?php if($keyColor==0){?>active<?php }?>">
                                        <div id="" class="slide-sp owl-carousel owl-theme">
                                            <?php
                                            for ($i=0;$i<=9;$i++){
                                            if(!empty($valColor['images_'.$i.''])){
                                            ?>
                                            <div class="item">
                                                <div class="wp-img-slide-sp">
                                                    <a href="<?php echo $href?>" title="<?php echo $valColor['title']?>"><img class="el_image" src="<?php echo $valColor['images_'.$i.'']?>"></a>
                                                </div>
                                            </div>
                                            <?php }?>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            <?php }?>
                            <div class="wp-add-to-cart">
                                <a href="<?php echo $href?>">
                                    <span>Thêm vào giỏ</span>
                                    <i class="fas fa-shopping-bag"></i>
                                </a>
                            </div>
                            <div class="wp-name-sp">
                                <h3 class="h3-title"><a href="<?php echo $href?>"><?php echo $val['title']?></a></h3>
                            </div>
                            <div class="wp-price-sp">
                                <span class="int"><?php echo $pri_sale?></span>
                            </div>
                            <?php if(isset($ReadByFieldProductsColors) && is_array($ReadByFieldProductsColors) && count($ReadByFieldProductsColors)) {?>
                                <div class="wp-list-check-color">
                                    <ul class="ul-b list-color-sp">
                                        <?php foreach ($ReadByFieldProductsColors as $keyColor => $valColor) {?>
                                            <li class="item-color color-1 <?php if($keyColor==0){?>active<?php }?>"><span style="background: url('<?php echo $valColor['images']?>')"></span></li>
                                        <?php }?>
                                    </ul>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php }?>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>
    <?php }?>


    <?php $uudai_nav = navigations_array('uudai', $this->fc_lang); ?>
    <?php if (isset($uudai_nav) && is_array($uudai_nav) && count($uudai_nav)) { ?>
    <!-- end sec 04 -->
    <section class="sec-home-05 mb-50">
        <div class="container-fluid pd-0">
            <div class="wp-title-sec">
                <h2 class="h2-title up-case">Ưu đãi trong tuần</h2>
            </div>
            <div class="wp-list-uudai">
                <div class="row">
                    <?php foreach ($uudai_nav as $key => $val) { ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="wp-item-uudai">
                            <div class="img-uudai">
                                <a href="<?php echo(($val['href'] == '#') ? 'javascript: void(0)' : $val['href']); ?>"><img class="el_image" src="<?php echo $val['description'] ?>" alt="<?php echo $val['title'] ?>"></a>
                            </div>
                            <div class="text-uudai text-center">
                                <h3 class="h3-title"><?php echo $val['title'] ?></h3>
                                <div class="wp-shopnow">
                                    <a href="<?php echo(($val['href'] == '#') ? 'javascript: void(0)' : $val['href']); ?>" class="btn btn-default btn-now btn-hover">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>
    <?php }?>



    <?php if (isset($product_catalog_ao) && is_array($product_catalog_ao) && count($product_catalog_ao)): ?>
        <?php foreach ($product_catalog_ao as $key => $vals): ?>
            <?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
                <!-- end sec 05 -->
                <section class="sec-home-06">
                    <div class="container-fluid">
                        <div class="wp-title-sec-sp">
                            <h2 class="h2-title"><?php echo $vals['title'] ?></h2>
                            <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])): ?>
                                <ul class="ul-b list-link-title">
                                    <?php foreach ($vals['child'] as $keyc => $valc): ?>
                                        <?php $hrefC = rewrite_url($valc['canonical'], $valc['slug'], $valc['id'], 'products_catalogues'); ?>
                                        <li><a href="<?php echo $hrefC?>"><?php echo $valc['title']?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>
                        </div>
                        <div class="wp-list-sp-home">
                            <div class="row">
                            <?php foreach ($vals['post'] as $keyP => $val): ?>
                                <?php
                                $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                                if($val['active_phamtramgiamgia']==0) {
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
                                        $pri_sale = 'Liên hệ';
                                    }
                                    if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                                        $number_sale = ceil((($price - $saleoff) / $price) * 100);
                                    } else {
                                        $number_sale = '';
                                    }


                                }else{
                                    $price = $val['saleoff'];
                                    $saleoff = $val['saleoff']/100*$val['tmp_active_phamtramgiamgia'];
                                    if ($price > 0) {
                                        $pri_old = '<span class="span-gia">' . str_replace(',', '.', number_format($price)) . '</span>';
                                    } else {
                                        $pri_old = '';
                                    }
                                    if ($saleoff > 0) {
                                        $pri_sale = str_replace(',', '.', number_format($saleoff));
                                    } else {
                                        $pri_sale = 'Liên hệ';
                                    }
                                    if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                                        $number_sale = ceil((($price - $saleoff) / $price) * 100);
                                    } else {
                                        $number_sale = '';
                                    }

                                }
                                $ReadByFieldProductsColors = $this->FrontendSaleDG_Model->ReadByFieldProductsColors('productsid',$val['id']);
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
                                                                               title="<?php echo $valColor['title'] ?>"><img class="el_image"
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
                                                                        <a href="<?php echo $href ?>" title="<?php echo $valAB['title'] ?>"><img class="el_image" src="<?php echo $valAB['images'] ?>"></a>
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
                                                <span>Thêm vào giỏ</span>
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
                                                            <span
                                                                style="background: url('<?php echo $valColor['images'] ?>')"></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php endforeach ?>

                            </div>
                        </div>
                    </div>
                </section>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <!-- end sec 06 -->

    <?php if (isset($product_catalog_sanphamnoibat1) && is_array($product_catalog_sanphamnoibat1) && count($product_catalog_sanphamnoibat1)): ?>
        <?php foreach ($product_catalog_sanphamnoibat1 as $key => $vals): ?>
            <?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
                <?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'products_catalogues'); ?>
                <section class="sec-home-07 hidden-xs">
                    <div class="container-fluid">
                        <div class="wp-spnb-b">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="wp-sp-nb sp-nb1">
                                        <a href="<?php echo $hrefC?>"><img class="el_image" src="<?php echo $vals['images']?>" alt="<?php echo $vals['title']?>"></a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="wp-sp-nb sp-nb2">
                                        <div class="row">
                                            <?php foreach ($vals['post'] as $keyP => $val): ?>
                                                <?php  $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');?>
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <div class="wp-item-spnb2">
                                                            <a href="<?php echo $href?>"><img class="el_image" src="<?php echo $val['images']?>" alt="<?php echo $val['title']?>"></a>
                                                        </div>
                                                    </div>
                                            <?php endforeach;?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <!-- end sec 07 -->
    <?php $adversite4 = $this->FrontendSlides_Model->Read('adversite-4', $this->fc_lang); ?>
    <?php if(isset($adversite4) && is_array($adversite4) && count($adversite4)){ ?>
    <section class="sec-home-08 mb-20">
        <div class="container-fluid">
            <div class="wp-dichvu">
                <div class="row">
                    <?php foreach($adversite4 as $key => $val){ ?>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="wp-item-dv">
                            <div class="icon-dv">
                                <img class="el_image" src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>">
                            </div>
                            <div class="text-dv">
                                <h2 class="h2-title"><?php echo $val['title']; ?></h2>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- end sec 08 -->

    <?php } ?>

    <?php if (isset($product_catalog_quan) && is_array($product_catalog_quan) && count($product_catalog_quan)): ?>
        <?php foreach ($product_catalog_quan as $key => $vals): ?>
            <?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
                <!-- end sec 05 -->
                <section class="sec-home-08 mb-20">
                    <div class="container-fluid">
                        <div class="wp-title-sec-sp">
                            <h2 class="h2-title"><?php echo $vals['title'] ?></h2>
                            <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])): ?>
                                <ul class="ul-b list-link-title">
                                    <?php foreach ($vals['child'] as $keyc => $valc): ?>
                                        <?php $hrefC = rewrite_url($valc['canonical'], $valc['slug'], $valc['id'], 'products_catalogues'); ?>
                                        <li><a href="<?php echo $hrefC?>"><?php echo $valc['title']?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>
                        </div>
                        <div class="wp-list-sp-home">
                            <div class="row">
                                <?php foreach ($vals['post'] as $keyP => $val): ?>
                                    <?php
                                    $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                                    if($val['active_phamtramgiamgia']==0) {
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
                                            $pri_sale = 'Liên hệ';
                                        }
                                        if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                                            $number_sale = ceil((($price - $saleoff) / $price) * 100);
                                        } else {
                                            $number_sale = '';
                                        }


                                    }else{
                                        $price = $val['saleoff'];
                                        $saleoff = $val['saleoff']/100*$val['tmp_active_phamtramgiamgia'];
                                        if ($price > 0) {
                                            $pri_old = '<span class="span-gia">' . str_replace(',', '.', number_format($price)) . '</span>';
                                        } else {
                                            $pri_old = '';
                                        }
                                        if ($saleoff > 0) {
                                            $pri_sale = str_replace(',', '.', number_format($saleoff));
                                        } else {
                                            $pri_sale = 'Liên hệ';
                                        }
                                        if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                                            $number_sale = ceil((($price - $saleoff) / $price) * 100);
                                        } else {
                                            $number_sale = '';
                                        }

                                    }
                                    $ReadByFieldProductsColors = $this->FrontendSaleDG_Model->ReadByFieldProductsColors('productsid',$val['id']);


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
                                                                                   title="<?php echo $valColor['title'] ?>"><img class="el_image"
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
                                                                            <a href="<?php echo $href ?>" title="<?php echo $valAB['title'] ?>"><img class="el_image" src="<?php echo $valAB['images'] ?>"></a>
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
                                                    <span>Thêm vào giỏ</span>
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
                                                            <span
                                                                style="background: url('<?php echo $valColor['images'] ?>')"></span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>

                            </div>
                        </div>
                    </div>
                </section>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <!-- end sec 08 -->

    <!-- end sec 09 -->
    <?php if (isset($product_catalog_sanphamnoibat2) && is_array($product_catalog_sanphamnoibat2) && count($product_catalog_sanphamnoibat2)): ?>
    <?php foreach ($product_catalog_sanphamnoibat2 as $key => $vals): ?>
    <?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
    <?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'products_catalogues'); ?>
    <section class="sec-home-10 hidden-xs">
        <div class="container-fluid">
            <div class="wp-spnb-b">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="wp-sp-nb sp-nb2">
                            <div class="row">
                                <?php foreach ($vals['post'] as $keyP => $val): ?>
                                    <?php  $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');?>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="wp-item-spnb2">
                                            <a href="<?php echo $href?>"><img class="el_image" src="<?php echo $val['images']?>" alt="<?php echo $val['title']?>"></a>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="wp-sp-nb sp-nb1">
                            <a href="<?php echo $hrefC?>"><img class="el_image" src="<?php echo $vals['images']?>" alt="<?php echo $vals['title']?>"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <!-- end sec 10 -->

    <link rel="stylesheet" type="text/css" href="templates/frontend/skins/eezerq.css">
    <script src="templates/frontend/js/ryxren.js"></script>
    <?php $adversite2 = $this->FrontendSlides_Model->Read('adversite-2', $this->fc_lang); ?>
    <?php $ReadGroupSlide = $this->FrontendSlides_Model->ReadGroupSlide('adversite-2', $this->fc_lang); ?>
    <?php if(isset($adversite2) && is_array($adversite2) && count($adversite2)){ ?>
    <section class="sec-home-11 mb-80 hidden-xs">
        <div class="container-fluid pd-0">
            <div class="sec-instagam">
                <div class="wp-title-sec">
                    <div class="title-instagram text-center">
                        <span><i class="fab fa-instagram" aria-hidden="true"></i></span>
                        <h2><?php echo $ReadGroupSlide['title']?></h2>
                        <h4><?php echo strip_tags($ReadGroupSlide['description'])?></h4>
                    </div>
                </div>
                <div class="row img-instagram">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 inst-1">
                        <div class="row">
                            <?php foreach($adversite2 as $key => $val){ ?>
                                <?php if($key<=3){?>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                       <a data-fancybox="test-srcset"
                                          data-type="image"
                                          data-width="1200"
                                          data-height="720"
                                          href="<?php echo $val['image']; ?>">
                                           <img class="el_image" src="<?php echo $val['image']; ?>" alt="banner<?php echo $key?>">
                                       </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php foreach($adversite2 as $key => $val){ ?>
                        <?php if($key==4){?>
                            <div class="col-lg-4 col-md-12 inst-2">
                                <a data-fancybox="test-srcset"
                                   data-type="image"
                                   data-width="1200"
                                   data-height="720"
                                   href="<?php echo $val['image']; ?>">
                                    <img class="el_image" src="<?php echo $val['image']; ?>" alt="banner<?php echo $key?>">
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="col-lg-4 col-md-12 col-sm-12 hidden-xs inst-3">
                        <div class="row">
                            <?php foreach($adversite2 as $key => $val){ ?>
                                <?php if($key>4){?>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <a data-fancybox="test-srcset"
                                           data-type="image"
                                           href="<?php echo $val['image']; ?>">
                                            <img class="el_image" src="<?php echo $val['image']; ?>" alt="banner<?php echo $key?>">
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
</main>
<!-- end main -->
