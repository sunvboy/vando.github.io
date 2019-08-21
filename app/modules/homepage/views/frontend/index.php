<div id="homepage" class="page-body">
    <div class="clr"></div>
    <?php $this->load->view('homepage/frontend/common/slider'); ?>
    <div class="clr"></div>
    <section class="home-page">
        <div class="uk-container uk-container-center">
            <section class="page-home">
                <?php if (isset($about_us) && is_array($about_us) && count($about_us)) { ?>
                    <?php foreach ($about_us as $key => $val) { ?>
                        <?php if (isset($val['post']) && is_array($val['post']) && count($val['post'])) { ?>
                            <ul class="uk-grid lib-grid-0 uk-grid-width-1-2 uk-grid-width-medium-1-2 uk-grid-width-large-1-4 page-abouts">
                                <li class="mb10">
                                    <div class="abouts-cat">
                                        <div class="title-cat"><?php echo $val['title'] ?></div>
                                        <div class="descript-cat">
                                            <?php echo $val['description'] ?>
                                        </div>
                                    </div>
                                </li>
                                <?php foreach ($val['post'] as $keypost => $vals) { ?>
                                    <?php $href = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles'); ?>
                                    <li class="mb10">
                                        <div class="list-abouts-cat uk-text-center">
                                            <a href="<?php echo $href ?>" title="<?php echo $vals['title'] ?>"> 
                                                <div class="images-cat">
                                                    <img src="templates/frontend/resources/img/icon-<?php echo ($keypost + 1) ?>.png" alt="<?php echo $vals['title'] ?>">
                                                </div>
                                                <div class="title-cat"><?php echo $vals['title'] ?></div>
                                            </a>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </section>
        </div>
    </section>
    <?php if (isset($ct_daotao) && is_array($ct_daotao) && count($ct_daotao)) { ?>
        <?php foreach ($ct_daotao as $key => $val) { ?>
            <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
            <?php if (isset($val['post']) && is_array($val['post']) && count($val['post'])) { ?>
                <section class="ct_daotao">
                    <div class="uk-container uk-container-center">
                        <header class="heading">
                            <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                        </header>
                        <section class="panel-body">
                            <div class="uk-slidenav-position slider-2" data-uk-slider="{autoplay: true, autoplayInterval: 5500}">
                                <div class="uk-slider-container">
                                    <ul class="uk-slider uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-5 uk-grid-width-large-1-4 list-products" data-uk-grid-match="{target: '.box_ctdaotao .title-ctdaotao'}">
                                        <?php foreach ($val['post'] as $keypost => $vals) { ?>
                                            <?php $href = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles'); ?>
                                            <li class="mb10">
                                                <div class="box_ctdaotao">
                                                    <div class="images-ctdaotao">
                                                        <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $vals['title'] ?>">
                                                            <img src="<?php echo $vals['images'] ?>" alt="<?php echo $vals['title'] ?>">
                                                            <span class="plus">+</span>
                                                        </a>
                                                    </div>
                                                    <div class="title-ctdaotao">
                                                        <a href="<?php echo $href ?>" title="<?php echo $vals['title'] ?>">
                                                            <?php echo $vals['title'] ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <a href="" class="uk-slidene uk-slidenav-contrast" data-uk-slider-item="previous">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="uk-slidepr uk-slidenav-contrast" data-uk-slider-item="next">
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
                </section>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <?php if (isset($danhgia) && is_array($danhgia) && count($danhgia)) { ?>
        <?php foreach ($danhgia as $key => $val) { ?>
            <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
            <?php if (isset($val['post']) && is_array($val['post']) && count($val['post'])) { ?>
                <section class="danhgia-tuvan bg-ebebeb">
                    <div class="uk-container uk-container-center">
                        <header class="heading">
                            <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                        </header>
                        <section class="panel-body">
                            <ul class="uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-4 uk-grid-width-large-1-4 list-products" data-uk-grid-match="{target: '.box_danhgia .title-danhgia'}">
                                <?php foreach ($val['post'] as $keypost => $vals) { ?>
                                    <?php $href = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles'); ?>
                                    <li class="mb30">
                                        <div class="box_danhgia">
                                            <div class="title-danhgia uk-flex lib-grid-10 mb10">
                                                <span class="number"><?php echo '0'.($keypost + 1) ?></span>
                                                <a href="<?php echo $href ?>" title="<?php echo $vals['title'] ?>">
                                                    <?php echo $vals['title'] ?>
                                                </a>
                                            </div>
                                            <div class="images-danhgia">
                                                <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $vals['title'] ?>">
                                                    <img src="<?php echo $vals['images'] ?>" alt="<?php echo $vals['title'] ?>">
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </section>
                    </div>
                </section>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <?php if (isset($lichhoc) && is_array($lichhoc) && count($lichhoc)) { ?>
        <section class="lichhoc">
            <div class="uk-container uk-container-center">
                <header class="heading">
                    <span>Lịch khai giảng</span>
                </header>
                <section class="panel-body">
                    <table class="uk-table uk-table-condensed uk-table-striped uk-table-middle table-lich-hoc">
                        <thead>
                            <th class="title-lich uk-text-left"><span>Tên chương trình đào tạo</span></th>
                            <th class="date-lich uk-text-center"><span>Ngày khai giản</span></th>
                            <th class="price-lich uk-text-center"><span>Học phí</span></th>
                            <th class="view-lich uk-text-center"><span>Chi tiết</span></th>
                        </thead>
                        <tbody>
                            <?php foreach ($lichhoc as $key => $val) { ?>
                             <?php $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'lichhoc'); ?>
                                <tr>
                                    <td>
                                        <div class="box-title-lichhoc">
                                            <label><b><?php echo $val['title'] ?></b></label>
                                            <span class="date_item"><?php echo $val['time'] ?></span>
                                            <span class="address_item"><?php echo $val['address'] ?></span>
                                            <span class="phone_item"><?php echo $val['phone'] ?></span>
                                        </div>
                                    </td>
                                    <td class="uk-text-center"><span><?php echo $val['date'] ?></span></td>
                                    <td class="uk-text-center"><span class="red"><b><?php echo number_format($val['price']) ?></b> đ</span></td>
                                    <td class="uk-text-center"><a href="<?php echo $href ?>" class="uk-btn uk-btn-view">Chi tiết</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    <?php } ?>
    <?php if (isset($tintuc) && is_array($tintuc) && count($tintuc)) { ?>
        <?php foreach ($tintuc as $key => $val) { ?>
            <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
            <?php if (isset($val['post']) && is_array($val['post']) && count($val['post'])) { ?>
                <section class="tintuc-home bg-ebebeb">
                    <div class="uk-container uk-container-center">
                        <header class="heading">
                            <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                        </header>
                        <section class="panel-body">
                            <ul class="uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-4 uk-grid-width-large-1-4 list-products" data-uk-grid-match="{target: '.box_danhgia .title-danhgia'}">
                                <?php foreach ($val['post'] as $keypost => $vals) { ?>
                                    <?php $href = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles'); ?>
                                    <li class="mb30">
                                        <div class="box-tin-tuc-home">
                                            <div class="images-danhgia">
                                                <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $vals['title'] ?>">
                                                    <img src="<?php echo $vals['images'] ?>" alt="<?php echo $vals['title'] ?>">
                                                </a>
                                            </div>
                                            <div class="title-tin-tuc uk-flex lib-grid-10 mb10">
                                                <span class="number"><?php echo '0'.($keypost + 1) ?></span>
                                                <a href="<?php echo $href ?>" title="<?php echo $vals['title'] ?>">
                                                    <?php echo $vals['title'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </section>
                    </div>
                </section>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>
<?php 

function show_article($attribute = ''){
    ?>
        <!-- Đăng ký Mail -->
        <section class="textwidget box-padding-background mt20 mb20">
            <div class="uk-container uk-container-center">
                <div class="thim-newlleter-homepage">
                    <p class="description">Đăng kí để được tư vấn miễn phí về dự án!</p> 
                    <form class="uk-form form" action="mailsubricre.html" method="post">
                        <div class="form-group">
                            <div class="uk-grid uk-grid-medium lib-grid-20">
                                <div class="uk-width-large-1-3 mb20">
                                    <div class="item_form">
                                        <input type="text" name="fullname" value="" class="text uk-width-1-1" placeholder="Họ và tên*"/>
                                    </div>
                                </div>
                                <div class="uk-width-large-1-3 mb20">
                                    <div class="item_form">
                                        <input type="text" name="email" class="text uk-width-1-1" placeholder="Email*" />
                                    </div>
                                </div>
                                <div class="uk-width-large-1-3 mb20">
                                    <div class="item_form">
                                        <input type="text" name="phone" class="text uk-width-1-1" placeholder="Số điện thoại*" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="item_form uk-text-center">
                                <input class="text uk-width-1-1" name="create" value="1" type="hidden">
                                <button type="submit" name="create_button" class="style-form-submit search-form-submit"><?php echo $this->lang->line('register') ?></button>
                            <div class="item_form">
                        </div>
                    </form>
                </div>
            <div class="uk-container uk-container-center">
        </section>
        <!-- END Đăng ký Mail -->
    <?php
    if (isset($attribute) && is_array($attribute) && count($attribute)) { ?>
        <section class="panel-body">
            <ul class="uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 listarticle" data-uk-grid-match="{target: '.article-item-col .article-title'}" >  
                <?php foreach($attribute as $key => $valst) { ?> 
                <?php 
                    $title = $valst['title'];
                    $href = rewrite_url($valst['canonical'], $valst['slug'], $valst['id'], 'articles');
                    $image = getthumb($valst['images'], FALSE);
                    $description = cutnchar(strip_tags($valst['description']), 200);
                    $created = show_time($valst['created'], 'd/m/Y');
                    $view = $valst['viewed'];
                    $time = strtotime($created);
                ?>
                    <li class="article-item-col">
                        <article class="article-1">
                            <div class="article-thumb">
                                <a class="cover ec-cover" href="<?php echo $href; ?>" title="<?php echo $title; ?>">
                                    <img src="<?php echo $image; ?>" alt="<?php echo $image; ?>">
                                </a>
                            </div>
                            <div class="article-info">
                                <div class="bor_box">
                                    <div class="box_title_article">
                                        <h2 class="article-title">
                                            <a class="link" href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
                                        </h2>
                                        <div class="clr"></div>
                                    </div>
                                    <div class="article-description lib-line-4"><?php echo $description; ?></div>
                                    <div class="xemthem0 uk-text-right">
                                        <a class="xemthem" href="<?php echo $href; ?>" title="Xem thêm">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </li>
                <?php } ?>
            </ul>
        </section><!-- .panel-body -->
    <?php }else
    {
        echo '<center>Dữ liệu đang cập nhật....</center>';
    }
}

    function show_spnoibat($arrray = ''){
        ?>
    <!-- Quảng cáo home-->
    <?php $this->load->view('homepage/frontend/common/advertise'); ?>
    <!-- END Quảng cáo home -->
    
    
    <!-- Danh mục sản phẩm -->
    
    <?php if (isset($products_cat_home) && is_array($products_cat_home) && count($products_cat_home)) { ?>
        <?php foreach ($products_cat_home as $key => $val) { ?>
            <?php if (isset($val['post']) && is_array($val['post']) && count($val['post'])) { ?>
                <?php $hrefC =  rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?> 
                <section class="home-products-shoping">
                    <div class="header-catelogies">
                        <div class="uk-container uk-container-center">
                            <h2 class="header-catelogies-title">
                                <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                            </h2>
                        </div>
                    </div>
                    <section class="panel-body bgwhite pt20">
                        <div class="uk-container uk-container-center">
                            <?php show_spnoibat($val['post']); ?>
                        </div>
                    </section>
                    <?php if ($key == 0) { ?>
                        <!-- Quản cáo -->
                        <section class="panel home-branch bgwhite">
                            <div class="uk-container uk-container-center">
                                <section class="panel-body uk-grid lib-grid-20">
                                    <?php $advhome = $this->FrontendSlides_Model->Read('adversite', $this->fc_lang); ?>
                                    <?php if(isset($advhome) && is_array($advhome) && count($advhome)){ ?>
                                        <?php foreach($advhome as $key => $val){ ?>
                                            <div class="adversite-item uk-width-1-1 mb20">
                                                <a href="<?php echo $val['url']; ?>" title="<?php echo $val['title']; ?>" class="link ec-fit">
                                                    <img src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>" />
                                                </a>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </section>
                            </div>
                        </section>
                        <!-- END Quảng cáo -->
                    <?php } ?>
                </section>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <!-- END danh mục sản phẩm -->

    <!-- Sản phẩm nổi bật + xem nhiều -->
    <section class="product_hightlight mb20">
        <div class="uk-container uk-container-center">
            <div class="nav-product-hightlight mb20">
                <ul class="uk-list uk-clearfix tabControl-hightlight" data-uk-switcher="{connect:'#tabContent-hightlight'}">
                    <li class="uk-active">Sản phẩm bán chạy</li>
                    <li class="">Sản phẩm xem nhiều</li>
                </ul>
            </div>
            <div class="clr"></div>
            <div class="content-product-hightlight">
                <ul id="tabContent-hightlight" class="uk-switcher tab-content-hightlight">
                    <li><?php show_sp_slide($prd_home_highlight); ?></li>
                    <li><?php show_sp_slide($prd_home_viewd); ?></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- END sản phẩm nổi bật + xem nhiều -->
    <?php
        if(isset($arrray) && is_array($arrray) && count($arrray)){ ?>
            <section class="panel-body" style="overflow: hidden;">
                <ul class="uk-grid lib-grid-20 uk-grid-width-1-2  uk-grid-width-large-1-4 listProduct" data-uk-grid-match="{target: '.product-1 .product-title'}">
                <?php foreach($arrray as $key => $val){ ?>
                    <?php 
                        $title = $val['title'];
                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                        $image = getthumb($val['images'], FALSE);
                        $price = $val['price'];
                        $saleoff = $val['saleoff'];
                        if ($price > 0) {
                            $giaold = str_replace(',', '.', number_format($price)).'₫';
                        }
                        else
                        {
                            $giaold = '';
                        }
                        if ($saleoff > 0) {
                            $gia = str_replace(',', '.', number_format($saleoff)).'₫';
                        }
                        else
                        {
                            $gia = 'Liên hệ';
                        }
                    ?>
                    <li class="product-item mb20">
                        <div class="product-1 skin-1">
                            <div class="product-thumb img-slide">
                                <a class="product-image" href="<?php echo $href ?>">
                                    <img src="<?php echo $val['images'] ?>" alt="<?php echo $title; ?>">
                                </a>
                            </div>
                            <div class="prid_item">
                                <h3 class="product-title uk-text-center">
                                    <a href="<?php echo $href ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
                                </h3>
                                <div class="price_view uk-text-center">
                                    Giá: <span class="product-price"><?php echo $gia ?></span>
                                </div>
                            </div>
                            <figure class="bginfo">
                                <div class="uk-flex uk-flex-middle lib-grid-20 mb20">
                                    <h3><?php echo $title; ?></h3> 
                                    <strong><?php echo $gia ?></strong> 
                                </div>
                                <div class="clr"></div>
                                <div class="span">
                                    <?php echo $val['description'] ?>
                                </div>
                            </figure>
                        </div>
                    </li>
                <?php } ?>
                </ul>
            </section>
        <?php }else{
            echo '<center>Dữ liệu đang cập nhật....</center>';
        }
    }
    function show_sp_slide($arrray=''){
        if(isset($arrray) && is_array($arrray) && count($arrray)){ ?>
        <section class="homepage-prdcategory-small sp-sale-box">
            <header class="panel-head">
                <div class="heading uk-flex uk-flex-middle uk-flex-space-between">
                    <a class="uk-text-uppercase" href="javascript: void(0)" title="Xả hàng">Xả hàng hôm nay</a>
                </div>
            </header>
            <section class="panel-body" style="overflow: hidden;">
                <div class="uk-slidenav-position slider-2" style="position: inherit;" data-uk-slider="{autoplay: true, autoplayInterval: 5500}">
                    <div class="uk-slider-container" style="overflow: inherit;">
                        <ul class="uk-grid lib-grid-15 uk-grid-width-1-2 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-5 uk-grid-width-large-1-4 list-products" data-uk-grid-match="{target: '.products .title'}">
                            <?php foreach($arrray as $key => $val){ ?>
                                <?php 
                                    $title = $val['title'];
                                    $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
                                    $image = getthumb($val['images'], FALSE);
                                    $price = $val['price'];
                                    $saleoff = $val['saleoff'];
                                    if ($price > 0) {
                                        $giaold = str_replace(',', '.', number_format($price)).'₫';
                                    }
                                    else
                                    {
                                        $giaold = '';
                                    }
                                    if ($saleoff > 0) {
                                        $gia = str_replace(',', '.', number_format($saleoff)).'₫';
                                    }
                                    else
                                    {
                                        $gia = 'Liên hệ';
                                    }if ($saleoff != 0 && $price != 0 && $saleoff < $price) {
                                            $sale = ceil(($saleoff - $price)/$price*100);
                                        }else{
                                            $sale = '';
                                        }
                                    ?>
                                    <li class="mb15">
                                        <div class="products <?php echo (($sale != '') ? 'acive-sale' : '') ?>">
                                            <?php if ($sale != ''): ?>
                                                <div class="sale-price"><?php echo $sale ?> %</div>
                                            <?php endif ?>
                                            <div class="thumb">
                                                <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $title ?>">
                                                    <img src="<?php echo $image; ?>" alt="<?php echo $val['title'] ?>" />
                                                </a>
                                            </div>
                                            <div class="infor">
                                                <h3 class="title"><a href="<?php echo $href ?>" title="<?php echo $title ?>">
                                                <?php echo $title ?></a></h3>
                                                <div class="star-item">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                                <div class="price_view uk-flex uk-flex-center lib-grid-20 uk-flex-middle mb10">
                                                    <span class="product-price"><?php echo $giaold ?></span>
                                                    <span class="product-pricesale"><?php echo $gia ?></span>
                                                </div>
                                                <div class="buon-shi mb10">
                                                    Giá bán buôn: <span>( Liên hệ )</span>
                                                </div>
                                                <div class="action-button-home ajax-addtocart mb10" data-quantity="1" data-id="<?php echo $val['id'] ?>" data-price="<?php echo $saleoff ?>">
                                                    Thêm vào giỏ hàng
                                                </div>
                                            </div>
                                        </div><!-- .product -->
                                    </li>
                            <?php } ?>
                        </ul>
                        <a href="" class="uk-slidene uk-slidenav-contrast" data-uk-slider-item="previous">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                        <a href="" class="uk-slidepr uk-slidenav-contrast" data-uk-slider-item="next">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </section>
        </section>
        <?php }
    }

    function FunctionName($value=''){
    ?>
    <!--  VB mới -->
    <section class="homepage-stt vb-moi">
        <div class="uk-container uk-container-center">
        
        </div>
    </section>
    <!-- END VB mới -->
    <!--  Khách hàng -->
    <section class="homepage-stt khach_hang">
        <div class="uk-container uk-container-center">
        <?php if (isset($khach_hang) && is_array($khach_hang) && count($khach_hang)) { ?>
            <?php foreach($khach_hang as $key => $valk) { ?> 
                <?php if (isset($valk['post']) && is_array($valk['post']) && count($valk['post'])) { ?>
                    <section class="article-catalogue khach_hang_box">
                        <div class="header-intro">
                            <h2 class="introduction-title">
                                <span><?php echo $valk['title'] ?></span>
                            </h2>
                        </div>
                        <section class="panel-body">
                            <div class="uk-slidenav-position slider-2" data-uk-slider="{autoplay: false, autoplayInterval: 5500}">
                                <div class="uk-slider-container" style="overflow: inherit;">
                                    <ul class="uk-slider uk-grid lib-grid-20 uk-grid-width-1-1 listarticle-col-kh" data-uk-grid-match="{target: '.article-item .header-title'}">  
                                        <?php foreach($valk['post'] as $key => $valks) { ?> 
                                        <?php 
                                            $image = getthumb($valks['images'], FALSE); 
                                            $href = rewrite_url($valks['canonical'], $valks['slug'], $valks['id'], 'article');
                                        ?>
                                            <li class="kh-item">
                                                <article class="kh-col-homepage">
                                                    <div class="img-kh">
                                                        <a href="<?php echo $href ?>" title="<?php echo $valks['title']  ?>">
                                                            <img src="<?php echo $image ?>" alt="<?php echo $valks['title'] ?>">
                                                        </a>
                                                    </div>
                                                    <div class="des_kh">
                                                        <h2 class="header-title">
                                                            <a href="<?php echo $href ?>" title="<?php echo $valks['title']  ?>"><?php echo $valks['title'] ?></a>
                                                        </h2>
                                                        <div class="descript-kh-1">
                                                            <?php echo cutnchar(strip_tags($valks['description']),150) ?>
                                                        </div>
                                                    </div>
                                                    <div class="clr"></div>
                                                </article>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <a href="" class="uk-slidene uk-slidenav-contrast" data-uk-slider-item="previous"></a>
                                    <a href="" class="uk-slidepr uk-slidenav-contrast" data-uk-slider-item="next"></a>
                                </div>
                            </div>
                        </section><!-- .panel-body -->
                    </section><!-- .home-listProduct -->
                <?php } ?>
            <?php } ?>
        <?php } ?>
        </div>
    </section>
    <!-- END Khách hàng -->
    
        <?php
    }
?>