<link rel="stylesheet" href="templates/frontend/resources/libs/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="templates/frontend/resources/libs/slider/owl.carousel.css">
<link rel="stylesheet" href="templates/frontend/resources/css/style.css">
<link rel="stylesheet" href="templates/frontend/resources/libs/dist/jquery.mmenu.all.css" />
<link rel="stylesheet" type="text/css" href="templates/frontend/resources/css/responsive.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<script src="templates/frontend/resources/libs/jquery/jquery.min.js"></script>
<!--  header -->
<header>
    <section class="content-header">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="left-header-top">
                            <i class="fas fa-truck"></i> <span><?php echo $this->fcSystem['contact_tongdai'] ?></span>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="list-header-top">
                            <ul>
                                <li><span>Liên kết mạng xã hội</span></li>
                                <li><a href="<?php echo $this->fcSystem['social_facebook'] ?>"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="<?php echo $this->fcSystem['social_twitter'] ?>"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="<?php echo $this->fcSystem['social_linkedin'] ?>"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="<?php echo $this->fcSystem['social_youtube'] ?>"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="<?php echo $this->fcSystem['social_google'] ?>"><i class="fab fa-google-plus-g"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="login-header-top">
                            <ul>
                                <?php $customer = $this->config->item('fcCustomer'); ?>
                                <?php if(!isset($customer) || !is_array($customer) || count($customer) == 0){ ?>
                                    <li><a href="<?php echo site_url('register') ?>"><i class="fas fa-key"></i> <span>Đăng ký</span></a></li>
                                    <li><a href="<?php echo site_url('login') ?>"><i class="fas fa-sign-in-alt"></i> <span>Đăng nhập</span></a></li>
                                <?php }else{ ?>
                                    <li class="icon-user dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <span class="fa-stack fa-lg">
                                                <img style="border-radius: 50%;width: 37px;height: 37px;" src="<?php echo $customer['images'] ?>" alt="">
                                            </span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="active"><a href="<?php echo site_url('my-profile'); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i> Thông tin tài khoản</a></li>
                                            <li><a href="<?php echo site_url('logout') ?>" class="btnDangxuat"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Đăng xuất</a></li>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <div class="header-logo">
                            <a itemprop="url" href="<?php echo BASE_URL ?>" title="<?php echo $this->fcSystem['homepage_company'] ?>">
                                <img src="<?php echo $this->fcSystem['homepage_logo'] ?>" alt="<?php echo $this->fcSystem['homepage_company'] ?>" />
                            </a>
                            <div class="icon-menu-mobile">
                                <a href="#menu"><i class="fas fa-bars"></i></a>
                            </div>
                            <div class="search-header">
                                <a href="javascript:;"><i class="fas fa-search"></i></a>
                            </div>
                            <div class="toggle_search">
                                <form action="<?php echo site_url('tim-kiem') ?>" method="get">
                                    <input type="text" name="key" placeholder="Tìm kiếm từ khóa">
                                    <button type="submit">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="right-search-right">
                            <div class="search-right">
                                <form action="<?php echo site_url('tim-kiem') ?>" method="get">
                                    <input type="text" name="key" placeholder="Tìm kiếm từ khóa">
                                    <button type="submit"><i class="fas fa-search"></i><span>tìm kiếm</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="cart-header-mid">
                            <div class="cart-left">
                                <a href="<?php echo site_url('dat-mua') ?>"><img src="templates/frontend/resources/images/cart.png" alt="Cart"></a>
                            </div>
                            <div class="text-right-cart">
                                <p><span>Giỏ hàng</span><span>có <font><?php echo $this->cart->total_items() ?></font> sản phẩm</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>
<section class="conbtent-main">
    <div class="main-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 push-lg-3 push-md-4">
                    <div class="right-top-right">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <?php $product_sales = navigations_array('main', $this->fc_lang); ?>
                                <?php if(isset($product_sales) && is_array($product_sales) && count($product_sales)){ ?>
                                    <div class="main-navibar-content">
                                        <ul class="main-navibar-link mt-flex mt-flex-middle">
                                            <?php foreach ($product_sales as $key => $val): ?>
                                                <li><a href="<?php echo $val['href'] ?>"><?php echo $val['title'] ?><span><?php echo ((!empty($val['description'])) ? '(-'.$val['description'].'%)' : '') ?></span></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="phone-hotline mt-flex-middle">
                                    <div class="icon-hotline"><i class="fas fa-phone-volume"></i></div>
                                    <div class="text-number">
                                        <p>Tổng đài miển phí</p>
                                        <p><span><?php echo $this->fcSystem['contact_phone'] ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->load->view('homepage/frontend/common/slider') ?>
                </div>
                <div class="col-lg-3 col-md-4 pull-lg-9 pull-md-4">
                    <?php
                    $left_nav = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                        'select' => 'id, title, slug, canonical, icon, lft, rgt',
                        'where' => array('trash' => 0,'publish' => 1, 'highlight' => 1, 'alanguage' => ''.$this->fc_lang.''),
                        'order_by' => 'order asc, id desc'
                    ));
                    if(isset($left_nav) && is_array($left_nav) && count($left_nav)){
                        foreach($left_nav as $key => $val){
                            $left_nav[$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                                'select' => 'id, title, slug, canonical, images, lft, rgt',
                                'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''),
                                'order_by' => 'order asc, id desc',
                            ));
                        }
                    }
                    ?>
                    <?php if(isset($left_nav) && is_array($left_nav) && count($left_nav)){ ?>
                        <div class="list-left-content">
                            <h3><i class="fas fa-bars"></i> <span>Danh mục sản phẩm</span></h3>
                        </div>
                        <div class="list-icon-left">
                            <ul>
                                <?php foreach ($left_nav as $key => $val): ?>
                                    <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues');  ?>
                                    <li>
                                        <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>" style="<?php echo ((!empty($val['icon'])) ? 'background-image: url(\''.$val['icon'].'\')' : '') ?>">
                                            <div class="icon-text-left">
                                                <span><?php echo $val['title'] ?></span>
                                            </div>
                                            <div class="icon-right"><i class="fas fa-angle-right"></i></div>
                                        </a>
                                        <?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
                                            <ul class="list-sub-catalog">
                                                <?php foreach ($val['child'] as $key => $valc): ?>
                                                    <?php $href = rewrite_url($valc['canonical'], $valc['slug'], $valc['id'], 'products_catalogues');  ?>
                                                    <li>
                                                        <a href="<?php echo $href ?>" title="<?php echo $valc['title'] ?>"><?php echo $valc['title'] ?></a>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>
                                        <?php endif ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div><!-- END MAIN TOP -->

    <div class="main-content_1">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="icon-text-conten_1">
                        <div class="icon-content_1">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="text-content_1">
                            <p><?php echo $this->fcSystem['services_services_1']?></p>
                            <p><span><?php echo $this->fcSystem['services_services_2']?></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-text-conten_1">
                        <div class="icon-content_1">
                            <i class="far fa-thumbs-up"></i>
                        </div>
                        <div class="text-content_1">
                            <p><?php echo $this->fcSystem['services_services_3']?></p>
                            <p><span><?php echo $this->fcSystem['services_services_4']?></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-text-conten_1">
                        <div class="icon-content_1">
                            <i class="fas fa-truck-moving"></i>
                        </div>
                        <div class="text-content_1">
                            <p><?php echo $this->fcSystem['services_services_5']?></p>
                            <p><span><?php echo $this->fcSystem['services_services_6']?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END MAIN TOP 1 -->

    <div class="main-content_2">
        <div class="container">
            <?php if (isset($products_saleoff_time) && is_array($products_saleoff_time) && count($products_saleoff_time)): ?>
                <header class="mt-flex mt-flex-middle mt-flex-space-between mb20">
                    <div class="title-contnet_2">
                        <h1>Giá tốt mỗi ngày</h1>
                    </div>
                    <div class="link-right_2 mt-flex mt-flex-middle">
                        <span class="mr10">Thời gian còn lại: </span>
                        <div class="times-table-bottom">
                            <ul class="count-down-time" data-time="<?php echo $time_start ?>"></ul>
                        </div>
                    </div>
                </header><!-- /header -->

                <div class="owl-carousel-1 owl-carousel owl-theme">
                    <?php foreach ($products_saleoff_time as $key => $val): ?>
                        <?php
                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                        $price = $val['price'];
                        $saleoff = $val['saleoff'];
                        if ($price > 0) {
                            $pri_old = '<span>'.str_replace(',', '.', number_format($price)).'<sup>đ</sup></span>';
                        }else{
                            $pri_old  = '';
                        }
                        if ($saleoff > 0) {
                            $pri_sale = str_replace(',', '.', number_format($saleoff)).'<sup>đ</sup>';
                        }else{
                            $pri_sale  = 'Liên hệ';
                        }
                        if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                            $number_sale = ceil((($price - $saleoff)/$price)*100);
                        }else{
                            $number_sale = '';
                        }
                        $price_affiliate = ((!empty(price_affiliate($saleoff, $val['id']))) ? '<small>'.str_replace(',', '.', number_format(price_affiliate($saleoff, $val['id']))).'</small>' : '');
                        ?>
                        <div class="row-edit-10 row">
                            <div class="col-lg-6 p10 mb10">
                                <div class="images-col4_2">
                                    <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                        <img src="<?php echo getthumb($val['images'], TRUE) ?>" alt="<?php echo $val['title'] ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 p10 mb10">
                                <div class="text-col4-times">
                                    <h3 class="span-text1"><a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a></h3>
                                    <ul class="clearfix">
                                        <?php $a = count_rating($val['id'], 'products', FALSE) ?>
                                        <?php $b = show_rating_products($val['id'], 'products', FALSE) ?>
                                        <?php $j = ((!empty($a) && !empty($b)) ? round(($a / $b), 1) : 0); ?>
                                        <?php
                                        for ($i=0; $i <5 ; $i++) {
                                            echo '<li>';
                                            $v = $j - $i;
                                            if ($v > 0) {
                                                if ($v == 0.5) {
                                                    echo '<i class="fas fa-star-half-alt"></i>';
                                                }else{
                                                    echo '<i class="fas fa-star"></i>';
                                                }
                                            }else{
                                                echo '<i class="far fa-star"></i>';
                                            }
                                            echo '</li>';
                                        }
                                        ?>
                                        <li><span>( <?php echo number_format(show_rating_products($val['id'], 'products', TRUE)) ?> )</span> </li>
                                    </ul>
                                    <span class="span-text2"><?php echo cutnchar(strip_tags($val['description']), 150) ?></span>
                                    <div class="gia-text_2">
                                        <div class="number-km">
                                            <?php echo $price_affiliate.$pri_sale ?>
                                            <?php echo ((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '') ?>
                                        </div>
                                        <div class="text-link-right_2">
                                            <a href="javascript: void(0)">Còn hàng</a>
                                        </div>
                                    </div>
                                    <div class="button-icon-bottom">
                                        <button type="submit" class="ajax-addtocart" data-quantity="1" data-id="<?php echo $val['id'] ?>">
                                            <i class="fas fa-luggage-cart"></i> Mua hàng
                                        </button>
                                    </div>
                                    <?php if (!empty($number_sale)): ?>
                                        <span class="span-text3">Nhanh tay rình ngày giảm giá lên tới <b><?php echo $number_sale ?>%</b></span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="mtb20 text-center view-all">
                    <a href="<?php echo site_url('san-pham-giam-gia') ?>" target="_blank"><span>Xem tất cả</span></a>
                </div>
            <?php endif ?>

            <?php if (isset($products_hot) && is_array($products_hot) && count($products_hot)): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="list-products-lq">
                            <ul class="ul1-list row">
                                <?php foreach ($products_hot as $key => $val): ?>
                                    <?php
                                    $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                                    $price = $val['price'];
                                    $saleoff = $val['saleoff'];
                                    if ($price > 0) {
                                        $pri_old = '<span>'.str_replace(',', '.', number_format($price)).'<sup>đ</sup></span>';
                                    }else{
                                        $pri_old  = '';
                                    }
                                    if ($saleoff > 0) {
                                        $pri_sale = str_replace(',', '.', number_format($saleoff)).'<sup>đ</sup>';
                                    }else{
                                        $pri_sale  = 'Liên hệ';
                                    }
                                    if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                                        $number_sale = ceil((($price - $saleoff)/$price)*100);
                                    }else{
                                        $number_sale = '';
                                    }
                                    $price_affiliate = ((!empty(price_affiliate($saleoff, $val['id']))) ? '<small>'.str_replace(',', '.', number_format(price_affiliate($saleoff, $val['id']))).'</small>' : '');
                                    ?>
                                    <li class="col-md-6 mt-flex mb20">
                                        <div class="images-list-products">
                                            <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                                <img src="<?php echo getthumb($val['images'], TRUE) ?>" alt="<?php echo $val['title'] ?>">
                                            </a>
                                        </div>
                                        <div class="text-products-list">
                                            <h3 class="span1-list1">
                                                <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                                            </h3>
                                            <div class="gia-text_2 mt-flex mt-flex-middle mt-flex-space-between">
                                                <div class="number-km">
                                                    <?php echo $price_affiliate.$pri_sale ?>
                                                    <?php echo ((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '') ?>
                                                </div>
                                                <div class="text-link-right_2">
                                                    <ul>
                                                        <?php $a = count_rating($val['id'], 'products', FALSE) ?>
                                                        <?php $b = show_rating_products($val['id'], 'products', FALSE) ?>
                                                        <?php $j = ((!empty($a) && !empty($b)) ? round(($a / $b), 1) : 0); ?>
                                                        <?php
                                                        for ($i=0; $i <5 ; $i++) {
                                                            echo '<li>';
                                                            $v = $j - $i;
                                                            if ($v > 0) {
                                                                if ($v == 0.5) {
                                                                    echo '<i class="fas fa-star-half-alt"></i>';
                                                                }else{
                                                                    echo '<i class="fas fa-star"></i>';
                                                                }
                                                            }else{
                                                                echo '<i class="far fa-star"></i>';
                                                            }
                                                            echo '</li>';
                                                        }
                                                        ?>
                                                        <li><span>( <?php echo number_format(show_rating_products($val['id'], 'products', TRUE)) ?> )</span> </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="link-bottom-list-products">
                                                <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                                    <span>Xem chi tiết</span>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div><!-- END MAIN TOP 2 -->

    <?php if (isset($product_catalog) && is_array($product_catalog) && count($product_catalog)): ?>
        <?php foreach ($product_catalog as $key => $vals): ?>
            <?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'products_catalogues'); ?>
            <?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
                <div class="main-content_3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-nexttab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="title-products_top1">
                                                <h2><a href="<?php echo $hrefC ?>"><?php echo $vals['title'] ?></a></h2>
                                            </div>
                                        </div>
                                        <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])): ?>
                                            <div class="col-md-8">
                                                <div class="list-next-tab">
                                                    <ul class="mt-flex mt-flex-middle mt-flex-right ml10 mr10">
                                                        <?php foreach ($vals['child'] as $keyc => $valc): ?>
                                                            <li data-tab="tab<?php echo $vals['id'].($keyc + 1) ?>">
                                                                <a href="javascript: void(0);"><?php echo $valc['title'] ?></a>
                                                            </li>
                                                        <?php endforeach ?>
                                                        <li class="active-li" data-tab="taball<?php echo $vals['id'] ?>">
                                                            <a href="javascript: void(0);">Tất cả</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="images-left-right-content_3">
                                    <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])){ ?>
                                        <?php foreach ($vals['child'] as $keyc => $valc): ?>
                                            <div class="products-right-content_3 active-tab " id="tab<?php echo $vals['id'].($keyc + 1) ?>">
                                                <?php show_product_value($valc['post']) ?>
                                            </div>
                                        <?php endforeach ?>
                                        <div class="products-right-content_3 active-tab active-content_3" id="taball<?php echo $vals['id'] ?>">
                                            <?php show_product_value($vals['post']) ?>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="products-right-content_3" style="display: block">
                                            <?php show_product_value($vals['post']) ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
</section>

<?php function show_product_value($param=''){ ?>
    <?php if (isset($param) && is_array($param) && count($param)){ ?>
        <div class="row row-edit-10">
            <?php foreach ($param as $key => $val): ?>
                <?php
                $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                $price = $val['price'];
                $saleoff = $val['saleoff'];
                if ($price > 0) {
                    $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).'</span>';
                }else{
                    $pri_old  = '';
                }
                if ($saleoff > 0) {
                    $pri_sale = str_replace(',', '.', number_format($saleoff));
                }else{
                    $pri_sale  = 'Liên hệ';
                }
                if (!empty($price) && !empty($saleoff) && $price > $saleoff) {
                    $number_sale = ceil((($price - $saleoff)/$price)*100);
                }else{
                    $number_sale = '';
                }
                $price_affiliate = ((!empty(price_affiliate($saleoff, $val['id']))) ? '<small>'.str_replace(',', '.', number_format(price_affiliate($saleoff, $val['id']))).'</small>' : '');
                ?>
                <div class="col-lg-3 col-md-4 col-6 mb20">
                    <div class="box1-right_content3">
                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                            <img src="<?php echo getthumb($val['images'], TRUE) ?>" alt="<?php echo $val['title'] ?>">
                        </a>
                        <h3 class="span_col3">
                            <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                        </h3>
                        <div class="gia-col3 mt-clearfix">
                            <?php echo $price_affiliate.$pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '') ?>
                            <font>Đã bán: <?php echo ($val['count_order'] + count_product_order_success($val['id'])) ?></font>
                        </div>
                        <div class="list-bottom-star">
                            <?php if (!empty($number_sale)): ?>
                                <div class="left-star"><?php echo '-'.$number_sale ?>%</div>
                            <?php endif ?>
                            <div class="list-icon-star <?php echo ((empty($number_sale)) ? 'text-left' : '') ?>">
                                <ul>
                                    <?php $a = count_rating($val['id'], 'products', FALSE) ?>
                                    <?php $b = show_rating_products($val['id'], 'products', FALSE) ?>
                                    <?php $j = ((!empty($a) && !empty($b)) ? round(($a / $b), 1) : 0); ?>
                                    <?php
                                    for ($i=0; $i <5 ; $i++) {
                                        echo '<li>';
                                        $v = $j - $i;
                                        if ($v > 0) {
                                            if ($v == 0.5) {
                                                echo '<i class="fas fa-star-half-alt"></i>';
                                            }else{
                                                echo '<i class="fas fa-star"></i>';
                                            }
                                        }else{
                                            echo '<i class="far fa-star"></i>';
                                        }
                                        echo '</li>';
                                    }
                                    ?>
                                    <li><span>( <?php echo number_format(show_rating_products($val['id'], 'products', TRUE)) ?> )</span> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php }else{ ?>
        <div class="text-center no_table_result">Dữ liệu đang cập nhật!</div>
    <?php } ?>
<?php } ?>
<?php
$this->db->select('*')->from('counter_values');
$row = $this->db->get()->row_array();
$this->db->select('*')->from('counter_ips');
$online = $this->db->count_all_results();
?>
<footer>
    <section class="footer-content">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="left-box1-footer-top">
                            <p class="p-footer1">Nhận tin khuyến mãi</p>
                            <p class="p-footer2">Nhận thông tin sản phâm mới nhất, tin khuyến mãi và nhiều hơn nữa</p>
                            <form action="<?php echo site_url('mailsubricre/frontend/mailsubricre/create') ?>" method="post" id="sform">
                                <div class="error uk-alert"></div>
                                <input class="form-control fullname" type="text" placeholder="Họ và tên">
                                <input class="form-control input-2-footer email" type="text" placeholder="Email của bạn">
                                <button type="submit"><i class="fas fa-arrow-right"></i></button>
                            </form>
                            <script type="text/javascript" charset="utf-8">
                                $(document).ready(function(){
                                    $('#sform .error').hide();
                                    var uri = $('#sform').attr('action');
                                    $('#sform').on('submit',function(){
                                        var postData = $(this).serializeArray();
                                        $.post(uri, {post: postData, fullname: $('#sform .fullname').val(), email: $('#sform .email').val()},
                                            function(data){
                                                var json = JSON.parse(data);
                                                $('#sform .error').show();
                                                if(json .error.length){
                                                    $('#sform .error').removeClass('uk-alert-success').addClass('uk-alert-danger');
                                                    $('#sform .error').html('').html(json.error);
                                                }else{
                                                    $('#sform .error').removeClass('uk-alert-danger').addClass('uk-alert-success');
                                                    $('#sform .error').html('').html('Gửi yêu cầu tư vấn online thành công!.');
                                                    $('#sform').trigger("reset");
                                                    setTimeout(function(){ location.reload(); }, 5000);
                                                }
                                            });
                                        return false;
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <?php $this->load->view('homepage/frontend/common/menu_footer') ?>
                    <div class="col-md-3">
                        <div class="maps-footer left-box1-footer-top">
                            <p class="p-footer1">Fanpage facebook</p>
                            <div class="maps-content">
                                <div class="fb-page" data-href="<?php echo $this->fcSystem['social_facebook'] ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="<?php echo $this->fcSystem['social_facebook'] ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->fcSystem['social_facebook'] ?>">Facebook</a></blockquote></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="left-box1-footer-top">
                            <p class="p-footer1">Phương Thức Thanh Toán</p>
                            <div class="images-footer">
                                <a href="javascript: void(0)"><img src="templates/frontend/resources/images/footer-nh1.png" alt=""></a>
                                <a href="javascript: void(0)"><img src="templates/frontend/resources/images/footer-nh2.png" alt=""></a>
                                <a href="javascript: void(0)"><img src="templates/frontend/resources/images/footer-nh3.png" alt=""></a>
                                <a href="javascript: void(0)"><img src="templates/frontend/resources/images/footer-nh4.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="left-box1-footer-top">
                            <p class="p-footer1">Thông tin liên hệ</p>
                            <div class="images-footer">
                                <ul class="ul1-footer">
                                    <li><i class="fas fa-map-marker-alt"></i> <span>Showroom :</span> <?php echo $this->fcSystem['contact_address'] ?></li>
                                    <li><i class="fas fa-phone"></i> <span>Điện thoại :</span><span class="number-footer"><?php echo $this->fcSystem['contact_phone'] ?></span></li>
                                    <li><i class="far fa-envelope"></i> <span>Email : </span><?php echo $this->fcSystem['contact_email'] ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="left-box1-footer-top">
                            <p class="p-footer1">Thống kê truy cập</p>
                            <div class="images-footer">
                                <ul class="ul-footer2">
                                    <li>
                                        <div class="text-footer-1">Đang online: </div>
                                        <div class="number-footer-1"><?php echo $online ?></div>
                                    </li>
                                    <li>
                                        <div class="text-footer-1">Hôm qua: </div>
                                        <div class="number-footer-1"><?php echo str_replace(',', '.', number_format($row['yesterday_value'])) ?></div>
                                    </li>
                                    <li>
                                        <div class="text-footer-1">Tổng truy cập: </div>
                                        <div class="number-footer-1"><?php echo str_replace(',', '.', number_format($row['year_value'])) ?></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="maps-footer left-box1-footer-top">
                            <p class="p-footer1">Kết nối với chúng tôi</p>
                            <div class="list-maps-footer">
                                <ul>
                                    <li><a href="<?php echo $this->fcSystem['social_facebook'] ?>"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="<?php echo $this->fcSystem['social_twitter'] ?>"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="<?php echo $this->fcSystem['social_linkedin'] ?>"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="<?php echo $this->fcSystem['social_google'] ?>"><i class="fab fa-google-plus-g"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span>Bản quyền thuộc về <?php echo $this->fcSystem['homepage_brandname'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div style="display: block;" class="customized fade-in fade-out" id="someone-purchased">
        <div style="display: none;" class="item_order mt-clearfix"> </div>
        <div style="display: none;" class="item_order mt-clearfix"> </div>
    </div>
</footer>
<?php
$main_nav = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
    'select' => 'id, title, slug, canonical, icon, lft, rgt',
    'where' => array('trash' => 0,'publish' => 1, 'highlight' => 1, 'alanguage' => ''.$this->fc_lang.''),
    // 'limit' => 6,
    'order_by' => 'order asc, id desc'
));
if(isset($main_nav) && is_array($main_nav) && count($main_nav)){
    foreach($main_nav as $key => $val){
        $main_nav[$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
            'select' => 'id, title, slug, canonical, images, lft, rgt',
            'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''),
            // 'limit' => 5,
            'order_by' => 'order asc, id desc',
        ));
    }
}
?>
<?php if(isset($main_nav) && is_array($main_nav) && count($main_nav)){ ?>
    <nav id="menu">
        <ul>
            <?php foreach ($main_nav as $key => $val): ?>
                <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues');  ?>
                <li>
                    <a href="<?php echo $hrefC ?>"><?php echo $val['title'] ?></a>
                    <?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
                        <ul class="">
                            <?php foreach ($val['child'] as $key => $valc): ?>
                                <?php $href = rewrite_url($valc['canonical'], $valc['slug'], $valc['id'], 'products_catalogues');  ?>
                                <li>
                                    <a href="<?php echo $href ?>" title="<?php echo $valc['title'] ?>"><?php echo $valc['title'] ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
    </nav>
<?php } ?>
<?php if (!empty($this->fcSystem['contact_hotline'])): ?>
    <div class="call-btn">
        <div class="zoomIn"></div>
        <div class="pulse"></div>
        <div class="tada">
            <a href="tel:<?php echo $this->fcSystem['contact_hotline'] ?> "><?php echo $this->fcSystem['contact_hotline'] ?></a>
        </div>
        <div class="tel"><?php echo $this->fcSystem['contact_hotline'] ?></div>
    </div>
<?php endif ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/<?php echo (($this->fc_lang == 'vietnamese') ? 'vi_VN' : 'en_US') ?>/sdk.js#xfbml=1&version=v2.12";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<script src="https://apis.google.com/js/platform.js" async defer>{lang: '<?php echo (($this->fc_lang == 'vietnamese') ? 'vi' : 'en') ?>'}</script>
