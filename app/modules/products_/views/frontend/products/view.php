<?php
$prdprice = $DetailProducts['price'];
$prdsaleoff = $DetailProducts['saleoff'];
if ($prdprice > 0) {
    $DetailProductsgiaold = '<span>' . str_replace(',', '.', number_format($prdprice)) . ' đ</span>';
} else {
    $DetailProductsgiaold = '';
}
if ($prdsaleoff > 0) {
    $DetailProductsgia = str_replace(',', '.', number_format($prdsaleoff)) . ' ₫';
} else {
    $DetailProductsgia = 'Liên hệ';
}
$gallerys = json_decode($DetailProducts['albums'], TRUE);
$price_affiliate = ((!empty(price_affiliate($prdsaleoff, $DetailProducts['id']))) ? '<font>' . str_replace(',', '.', number_format(price_affiliate($prdsaleoff, $DetailProducts['id']))) . ' ₫</font>' : '');
?>
<section class="conbtent-main">
    <div class="main-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 push-lg-3 push-md-4">
                    <div class="right-top-right">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <?php $product_sales = navigations_array('main', $this->fc_lang); ?>
                                <?php if (isset($product_sales) && is_array($product_sales) && count($product_sales)) { ?>
                                    <div class="main-navibar-content">
                                        <ul class="main-navibar-link mt-flex mt-flex-middle">
                                            <?php foreach ($product_sales as $key => $val): ?>
                                                <li><a href="<?php echo $val['href'] ?>"><?php echo $val['title'] ?>
                                                        <span><?php echo((!empty($val['description'])) ? '(-' . $val['description'] . '%)' : '') ?></span></a>
                                                </li>
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
                </div>
                <div class="col-lg-3 col-md-4 pull-lg-9 pull-md-4 hover-catalog mb15">
                    <?php
                    $left_nav = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                        'select' => 'id, title, slug, canonical, icon, lft, rgt',
                        'where' => array('trash' => 0, 'publish' => 1, 'highlight' => 1, 'alanguage' => '' . $this->fc_lang . ''),
                        'limit' => 6,
                        'order_by' => 'order asc, id desc'
                    ));
                    if (isset($left_nav) && is_array($left_nav) && count($left_nav)) {
                        foreach ($left_nav as $key => $val) {
                            $left_nav[$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                                'select' => 'id, title, slug, canonical, images, lft, rgt',
                                'where' => array('trash' => 0, 'publish' => 1, 'parentid' => $val['id'], 'alanguage' => '' . $this->fc_lang . ''),
                                'limit' => 5,
                                'order_by' => 'order asc, id desc',
                            ));
                        }
                    }
                    ?>
                    <?php if (isset($left_nav) && is_array($left_nav) && count($left_nav)) { ?>
                        <div class="list-left-content">
                            <h3><i class="fas fa-bars"></i> <span>Danh mục sản phẩm</span></h3>
                        </div>
                        <div class="list-icon-left list-icon-left-2">
                            <ul>
                                <?php foreach ($left_nav as $key => $val): ?>
                                    <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues'); ?>
                                    <li>
                                        <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>"
                                           style="<?php echo((!empty($val['icon'])) ? 'background-image: url(\'' . $val['icon'] . '\')' : '') ?>">
                                            <div class="icon-text-left">
                                                <span><?php echo $val['title'] ?></span>
                                            </div>
                                            <div class="icon-right"><i class="fas fa-angle-right"></i></div>
                                        </a>
                                        <?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
                                            <ul class="list-sub-catalog">
                                                <?php foreach ($val['child'] as $key => $valc): ?>
                                                    <?php $href = rewrite_url($valc['canonical'], $valc['slug'], $valc['id'], 'products_catalogues'); ?>
                                                    <li>
                                                        <a href="<?php echo $href ?>"
                                                           title="<?php echo $valc['title'] ?>"><?php echo $valc['title'] ?></a>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="."><i class="fa fa-home" aria-hidden="true"></i> Trang
                                    chủ</a></li>
                            <?php foreach ($Breadcrumb as $key => $val) { ?>
                                <?php
                                $title = $val['title'];
                                $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues');
                                ?>
                                <li class="breadcrumb-item active">
                                    <a href="<?php echo $href; ?>"
                                       title="<?php echo $title; ?>"><?php echo mb_strtolower($title, 'UTF-8'); ?></a>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN TOP -->
    <div class="main-slick-details mt25">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb25">
                    <div
                        class="slick-slider12 player_ <?php echo((!empty($DetailProducts['source'])) ? 'active_stop' : '') ?>"
                        data-source="<?php echo $DetailProducts['source'] ?>">
                        <img src="<?php echo $DetailProducts['images'] ?>" alt="<?php echo $DetailProducts['title'] ?>">
                        <span class="ic_player_start"><i class="far fa-play-circle"></i></span>
                        <span class="ic_player_stop"><i class="far fa-times-circle"></i></span>
                        <a class="next owl-custom"><i class="fas fa-chevron-right"></i></a>
                        <a class="prev owl-custom"><i class="fas fa-chevron-left"></i></a>
                        <?php if (!empty($DetailProducts['source'])): ?>
                            <video controls class="video_pl" id="myVideo">
                                <source src="<?php echo $DetailProducts['source'] ?>" type="video/mp4">
                            </video>
                            <a class="d-none autoplay">Enable autoplay</a>
                        <?php endif ?>
                    </div>
                    <div class="products-hidden-">
                        <div class="mt-flex mt-flex-middle mt-flex-space-between">
                            <div class="item-">
                                <?php if (!empty($DetailProducts['source'])): ?>
                                    <span class="player_button click_tog active" data-show="2"><i
                                            class="fab fa-google-play"></i> Videos</span>
                                <?php endif ?>
                                <span
                                    class="gallerys_button click_tog <?php echo((!empty($DetailProducts['source'])) ? '' : 'active') ?>"
                                    data-show="1"><i class="far fa-image"></i> Hình ảnh</span>
                            </div>
                            <div class="item-">
                                <span class="count-img">
                                    1/<?php echo(count($gallerys) + 1) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="slick-slider">
                        <div id="slider-owl" class="mt-list mt-clearfix owl-carousel">
                            <div>
                                <a href="javascript:void(0);" data-src="<?php echo $DetailProducts['images'] ?>">
                                    <img class="active-img"
                                         src="<?php echo getthumb($DetailProducts['images'], TRUE) ?>"
                                         alt="<?php echo $DetailProducts['title'] ?>"
                                         data-source="<?php echo $DetailProducts['source'] ?>"
                                         data-stt="1/<?php echo(count($gallerys) + 1) ?>">
                                </a>
                            </div>
                            <?php if (isset($gallerys) && is_array($gallerys) && count($gallerys)): ?>
                                <?php foreach ($gallerys as $key => $val): ?>
                                    <div class="<?php echo((!empty($DetailProducts['source'])) ? 'player_' : '') ?>">
                                        <a href="javascript:void(0);" data-src="<?php echo $val['images'] ?>">
                                            <img src="<?php echo getthumb($val['images'], TRUE) ?>"
                                                 alt="<?php echo $DetailProducts['title'] ?>"
                                                 data-source="<?php echo $DetailProducts['source'] ?>"
                                                 data-stt="<?php echo ($key + 2) . '/' . (count($gallerys) + 1) ?>">
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
                </div>
                <div class="col-md-7 mb25">
                    <div class="text-details">
                        <div class="text-details">
                            <h1><?php echo $DetailProducts['title'] ?></h1>

                            <div class="list-star-dg">
                                <ul class="ul1-star">
                                    <?php $a = count_rating($DetailProducts['id'], 'products', FALSE) ?>
                                    <?php $b = show_rating_products($DetailProducts['id'], 'products', FALSE) ?>
                                    <?php $j = ((!empty($a) && !empty($b)) ? round(($a / $b), 1) : 0); ?>
                                    <li><a href="javascript:;"><span class="span1-star"><?php echo $j; ?></span></a>
                                    </li>
                                    <?php
                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<li><a href="javascript:;">';
                                        $v = $j - $i;
                                        if ($v > 0) {
                                            if ($v == 0.5) {
                                                echo '<i class="fas fa-star-half-alt"></i>';
                                            } else {
                                                echo '<i class="fas fa-star"></i>';
                                            }
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                        echo '</a></li>';
                                    }
                                    ?>
                                    <li>
                                        <a class="csroll-tag" href="#rate-box">
                                            <span
                                                class="span2-star">(<?php echo number_format(show_rating_products($DetailProducts['id'], 'products', TRUE)) ?>
                                                đánh giá)</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php $customer = $this->config->item('fcCustomer'); ?>
                            <div class="list-text-style">
                                <?php echo $DetailProducts['description'] ?>
                                <div class="text-gia-tam">
                                    <ul>
                                        <li><?php echo $price_affiliate . $DetailProductsgia . ' ' . ((!empty($prdprice) && !empty($prdsaleoff) && $prdprice > $prdsaleoff) ? $DetailProductsgiaold : '') ?></li>
                                        <li>
                                            <a class="<?php echo((!empty($DetailProducts['quantity'])) ? 'bg-primary' : 'bg-danger') ?>"><?php echo $this->configbie->data('status', ((!empty($DetailProducts['quantity'])) ? 0 : 1)) ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php if (isset($customer) && is_array($customer) && count($customer)): ?>
                                <div class="getlink_affiliate mt-flex mt-flex-middle mt15 mb5">
                                    <span class="aff_left">Chia sẻ</span>
                                    <span class="relative aff_right">
                                        <input type="text" readonly=""
                                               value="<?php echo $canonical . '?aff=' . $customer['affiliate_id'] ?>"
                                               class="form-control" id="affiliate_link" style="padding-right: 75px;">
                                        <button type="button" class="btn btn-success" onclick="getlink_affiliate();">Lấy
                                            link
                                        </button>
                                    </span>
                                </div>
                                <script>
                                    function getlink_affiliate() {
                                        var copyText = document.getElementById("affiliate_link");
                                        copyText.select();
                                        document.execCommand("Copy");
                                        alert("Copied the text: " + copyText.value);
                                        return false;
                                    }
                                </script>
                            <?php endif ?>
                            <?php
                            $result = $this->Autoload_Model->_get_where(array(
                                'select' => 'id, title, slug, canonical, images, description, price, saleoff, status, quantity, source',
                                'table' => 'products',
                                'where' => array('publish' => 1, 'trash' => 0, 'parentid' => $DetailProducts['id']),
                                'order_by' => 'id desc, order asc'
                            ), TRUE);//
                            ?>
                            <?php if (isset($result) && is_array($result) && count($result)): ?>
                                <div class="list-images-color pc-screen mt-flex-middle mt-flex">
                                    <p>Phiên bản</p>
                                    <ul class="mt-flex mt-flex-middle">
                                        <li class="active-img-2"
                                            data-src="<?php echo((!empty($DetailProducts['images'])) ? $DetailProducts['images'] : 'templates/not-found.png') ?>"
                                            data-id="<?php echo $DetailProducts['id'] ?>"
                                            data-source="<?php echo $DetailProducts['source'] ?>">
                                            <img src="<?php echo getthumb($DetailProducts['images'], TRUE) ?>"
                                                 alt="<?php echo $DetailProducts['title'] ?>">
                                        </li>
                                        <?php foreach ($result as $key => $valv): ?>
                                            <li data-src="<?php echo((!empty($valv['images'])) ? $valv['images'] : 'templates/not-found.png') ?>"
                                                data-id="<?php echo $valv['id'] ?>"
                                                data-source="<?php echo $valv['source'] ?>">
                                                <img src="<?php echo getthumb($valv['images'], TRUE) ?>"
                                                     alt="<?php echo $valv['title'] ?>">
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>
                            <?php  
                                $result_attr_advanced = $this->Autoload_Model->_get_where(array(
                                    'select' => 'id, title, attribute',
                                    'table' => 'products_att_advanced',
                                    'where' => array('productsid' => $DetailProducts['id'], 'trash' => 0),
                                    'order_by' => 'id asc'
                                ), TRUE);//
                            ?>
                            <?php if (isset($result_attr_advanced) && is_array($result_attr_advanced) && count($result_attr_advanced)): ?>
                                <div class="list_attr_advanced">
                                    <?php foreach ($result_attr_advanced as $key => $valatt): ?>
                                        <?php $result_arr = explode(',', $valatt['attribute']); ?>
                                        <div class="item_attr_advanced mt-flex mt-flex-middle mb5">
                                            <div class="title_attr"><?php echo $valatt['title'] ?></div>
                                            <div class="content_attr">
                                                <?php if (isset($result_arr) && is_array($result_arr) && count($result_arr)): ?>
                                                    <ul class="mt-list mt-clearfix">
                                                        <?php foreach ($result_arr as $valval): ?>
                                                            <li>
                                                                <a data-flag="0" class="chose_attr_advanced <?php echo '_'.slug($valval) ?>" title="<?php echo $valatt['title'] ?>: <?php echo $valval ?>"><?php echo $valval ?></a>
                                                            </li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $(document).on('click', '.chose_attr_advanced:not(.disable)', function () {
                                            $('.list_attr_advanced').removeClass('mt-alert-danger').find('.text-left').remove();
                                            $('.chose_attr_advanced').removeClass('disable');
                                            var flag = $(this).attr('data-flag');
                                            if ($(this).hasClass('active')) {
                                                $(this).removeClass('active');
                                            }else{
                                                $(this).parent().parent().find('.chose_attr_advanced').removeClass('active');
                                                $(this).addClass('active');
                                            }
                                            load_attr_advanced();
                                        });
                                        function load_attr_advanced(){
                                            var text = ''
                                            var outputText = '';
                                            $('.chose_attr_advanced.active').each(function(){
                                                var divHtml = $(this).attr('title');
                                                var divHtml2 = $(this).html();
                                                outputText += divHtml + ',';
                                                text += divHtml2 + ',';
                                            });

                                            $.post('<?php echo site_url("products/ajax/products/load_attr_advanced");?>', 
                                                {id: '<?php echo $DetailProducts['id'] ?>', text: text.slice(0, -1)}, function (data) {
                                                var json = JSON.parse(data);
                                                if (json.error == true) {
                                                    var html = json.html.slice(0, -1).split("+");
                                                    for (var i = html.length - 1; i >= 0; i--) {
                                                        $('.list_attr_advanced').find('.'+html[i]+'').addClass('disable').removeClass('active');
                                                    }
                                                }
                                            });

                                            $('.ajax-addtocart.single_product, .ajax-addtocart-all').attr('data-option', outputText.slice(0, -1));
                                        }
                                    })
                                </script>
                            <?php endif ?>
                            <div class="input-text-bottom mt-flex-middle mt-flex">
                                <label>Số lượng</label>

                                <div class="form-cart- mt-flex mt-flex-middle">
                                    <span class="btn-agument mines btn-up"></span>
                                    <input type="input" class="quantity" value="1">
                                    <span class="btn-agument plus btn-down"></span>
                                </div>
                                <span class="label2"><span><?php echo number_format($DetailProducts['quantity']) ?></span> sản phẩm có sẵn</span>
                            </div>
                            <div class="mtb20 product-time mt-flex mt-flex-middle">
                                <div class="ul3-star">
                                    <i class="fas fa-user-tie mr5"></i>
                                    <b><?php echo number_format($DetailProducts['count_order'] + count_product_order_success($DetailProducts['id'])) ?></b>
                                    đã mua</a>
                                </div>
                                <?php $time = gmdate('Y-m-d H:i:s', time() + 7 * 3600); ?>
                                <?php if ($time <= $DetailProducts['saleoff_time']): ?>
                                    <div class="times-table-bottom ml20">
                                        <ul class="count-down-time-detail mt-flex mt-flex-middle"
                                            data-time="<?php echo $DetailProducts['saleoff_time'] ?>"></ul>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="button-bottom-right mt-flex mt-flex-middle mt-flex-space-between">
                                <button type="submit" class="ajax-addtocart single_product" data-quantity="1"
                                        data-id="<?php echo $DetailProducts['id'] ?>" data-redirect="redirect" data-option="">
                                    <i class="fas fa-luggage-cart"></i> Mua ngay
                                </button>
                                <button class="phone-hotline-detail mt-flex mt-flex-middle mt-flex-center">
                                    <div class="icon-hotline"><i class="fas fa-phone-volume"></i></div>
                                    <div class="text-number"><span><?php echo $this->fcSystem['contact_phone'] ?></span>
                                    </div>
                                </button>
                            </div>
                            <?php if (!empty($this->fcSystem['contact_capcuu'])): ?>
                                <div class="free-ship mt20">
                                    <?php echo $this->fcSystem['contact_capcuu'] ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-text-images-video main-content_3" style="margin-top: 0">
        <div class="container">
            <div class="row">
                <div
                    class="<?php echo((!empty($this->fcSystem['homepage_slogan'])) ? 'col-lg-9 col-md-8' : 'col-lg-12 col-md-12') ?>">
                    <?php if (!empty($DetailProducts['id_combo'])): ?>
                        <?php
                        $result_combo = $this->Autoload_Model->_get_where(array(
                            'select' => 'id, title, slug, canonical, images, description, price, saleoff, status',
                            'table' => 'products',
                            'where' => array('publish' => 1, 'trash' => 0),
                            'where_in' => explode('-', $DetailProducts['id_combo']),
                            'where_in_field' => 'id',
                            'order_by' => 'id desc, order asc'
                        ), TRUE);
                        $cart_list = $this->cart->contents();
                        $arr_ = array();
                        if (isset($cart_list) && is_array($cart_list) && count($cart_list)) {
                            foreach ($cart_list as $key => $value) {
                                $arr_[] = $value['id'];
                            }
                        }

                        ?>
                        <?php if (isset($result_combo) && is_array($result_combo) && count($result_combo)): ?>
                            <div class="text-left-video">
                                <h2>Combo mua kèm sản phẩm</h2>

                                <div class="images-text-link mt-flex mt-flex-middle mt-flex-space-between">
                                    <ul>
                                        <li>
                                            <a href="#" data-option=""
                                               class="<?php echo((in_array($DetailProducts['id'], $arr_)) ? '' : 'ajax-addtocart single_product') ?> mt-active"
                                               data-quantity="1" data-id="<?php echo $DetailProducts['id'] ?>"
                                               data-flag="1" data-price="<?php echo $DetailProducts['saleoff'] ?>" data-price-old="<?php echo $DetailProducts['price'] ?>">
                                                <img src="<?php echo getthumb($DetailProducts['images'], TRUE) ?>"
                                                     alt="<?php echo $DetailProducts['title'] ?>">
                                            </a>
                                        </li>
                                        <?php $total_price = $DetailProducts['saleoff']; ?>
                                        <?php $total_price_old = $DetailProducts['price']; ?>
                                        <?php foreach ($result_combo as $key => $valimg): ?>
                                            <?php $total_price += $valimg['saleoff'] ?>
                                            <?php $total_price_old += $valimg['price'] ?>
                                            <li>
                                                <a href="#"
                                                   class="plus_2 <?php echo((in_array($valimg['id'], $arr_)) ? 'mt-active ajax-deltocart' : 'ajax-addtocart') ?>"
                                                   data-quantity="1" data-id="<?php echo $valimg['id'] ?>" data-flag="1"
                                                   data-price="<?php echo $valimg['saleoff'] ?>" data-price-old="<?php echo $valimg['price'] ?>">
                                                    <img src="<?php echo getthumb($valimg['images'], TRUE) ?>"
                                                         alt="<?php echo $valimg['title'] ?>">
                                                </a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                    <div class="text-button-images">
                                        <p>Tổng giá trị :
                                            <span class="saleoff"><?php echo str_replace(',', '.', number_format($total_price)) ?>đ</span>
                                            <span class="priceold"><?php echo str_replace(',', '.', number_format($total_price_old)) ?>đ</span>
                                        </p>
                                        <button type="submit" class="ajax-addtocart-all" data-id=""> Thêm tất cả vào giỏ
                                            hàng
                                        </button>
                                    </div>
                                </div>
                                <?php if (isset($result_combo) && is_array($result_combo) && count($result_combo)): ?>
                                    <div class="list-gt-mm">
                                        <ul>
                                            <li>
                                                <a href="#" data-option=""
                                                   class="mt-active <?php echo((in_array($DetailProducts['id'], $arr_)) ? '' : 'ajax-addtocart single_product') ?>"
                                                   data-quantity="1" data-id="<?php echo $DetailProducts['id'] ?>"
                                                   data-flag="1">
                                                    <span class="span1-mm">Sản phẩm hiện tại: </span>
                                                    <span class="span2-mm"><?php echo $DetailProducts['title'] ?></span>
                                                    <span class="span3-mm"> - <?php echo $DetailProductsgia ?></span>
                                                </a>
                                            </li>
                                            <?php foreach ($result_combo as $key => $val): ?>
                                                <li>
                                                    <a href="#"
                                                       class="<?php echo((in_array($val['id'], $arr_)) ? 'mt-active ajax-deltocart' : 'ajax-addtocart') ?>"
                                                       data-quantity="1" data-id="<?php echo $val['id'] ?>"
                                                       data-flag="1">
                                                        <span class="span1-mm">Sản phẩm combo: </span>
                                                        <span class="span2-mm"><?php echo $val['title'] ?></span>
                                                        <span
                                                            class="span3-mm"> - <?php echo((!empty($val['saleoff'])) ? str_replace(',', '.', number_format($val['saleoff'])) . ' ₫' : 'Liên hệ') ?></span>
                                                    </a>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <div class="text-left-video">
                        <h3>Thông tin sản phẩm</h3>
                        <?php if (!empty($DetailProducts['content2'])): ?>
                            <section class="products-thong-so text-list-kt">
                                <?php echo $DetailProducts['content2'] ?>
                            </section>
                        <?php endif ?>
                        <div class="text-list-kt">
                            <?php echo $DetailProducts['content'] ?>
                        </div>
                        <?php if (!empty($DetailProducts['content3'])): ?>
                            <section class="products-infomation products-thong-so text-list-kt">
                                <?php echo $DetailProducts['content3'] ?>
                            </section>
                        <?php endif ?>
                        <?php if (!empty($DetailProducts['itinerary'])): ?>
                            <section class="products-noidung-2 text-list-kt">
                                <?php echo $DetailProducts['itinerary'] ?>
                            </section>
                        <?php endif ?>
                    </div>
                    <?php $this->load->view('homepage/frontend/common/comments') ?>
                </div>
                <?php if (!empty($this->fcSystem['homepage_slogan'])): ?>
                    <div class="col-lg-3 col-md-4">
                        <?php if (isset($products_same) && is_array($products_same) && count($products_same)): ?>
                            <div class="text-images-products-lq products-right-content_3">
                                <h4>Sản phẩm khác</h4>

                                <div class="content_product">
                                    <?php foreach ($products_same as $key => $val): ?>
                                        <?php
                                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
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
                                        ?>
                                        <div class="mb20">
                                            <div class="box1-right_content3">
                                                <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                                    <img src="<?php echo getthumb($val['images'], TRUE) ?>"
                                                         alt="<?php echo $val['title'] ?>">
                                                </a>

                                                <h3 class="span_col3">
                                                    <a href="<?php echo $href ?>"
                                                       title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                                                </h3>

                                                <div class="gia-col3 mt-clearfix">
                                                    <?php echo $pri_sale . ((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '') ?>
                                                    <font>Đã
                                                        bán: <?php echo($val['count_order'] + count_product_order_success($val['id'])) ?></font>
                                                </div>
                                                <div class="list-bottom-star">
                                                    <?php if (!empty($number_sale)): ?>
                                                        <div class="left-star"><?php echo $number_sale ?>%</div>
                                                    <?php endif ?>
                                                    <div
                                                        class="list-icon-star <?php echo((empty($number_sale)) ? 'text-left' : '') ?>">
                                                        <ul>
                                                            <?php $a = count_rating($val['id'], 'products', FALSE) ?>
                                                            <?php $b = show_rating_products($val['id'], 'products', FALSE) ?>
                                                            <?php $j = ((!empty($a) && !empty($b)) ? round(($a / $b), 1) : 0); ?>
                                                            <?php
                                                            for ($i = 0; $i < 5; $i++) {
                                                                echo '<li>';
                                                                $v = $j - $i;
                                                                if ($v > 0) {
                                                                    if ($v == 0.5) {
                                                                        echo '<i class="fas fa-star-half-alt"></i>';
                                                                    } else {
                                                                        echo '<i class="fas fa-star"></i>';
                                                                    }
                                                                } else {
                                                                    echo '<i class="far fa-star"></i>';
                                                                }
                                                                echo '</li>';
                                                            }
                                                            ?>
                                                            <li>
                                                                <span>( <?php echo number_format(show_rating_products($val['id'], 'products', TRUE)) ?>
                                                                    )</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
                <?php if (!empty($this->fcSystem['homepage_note'])): ?>
                    <?php if (isset($products_care) && is_array($products_care) && count($products_care)): ?>
                        <div class="col-md-12">
                            <div class="text-left-video products-right-content_3">
                                <h5>Có thể bạn quan tâm</h5>

                                <div class="row">
                                    <?php foreach ($products_care as $key => $val): ?>
                                        <?php
                                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
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
                                        ?>
                                        <div class="col-lg-3 col-md-3 mb20">
                                            <div class="box1-right_content3">
                                                <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                                    <img src="<?php echo getthumb($val['images'], TRUE) ?>"
                                                         alt="<?php echo $val['title'] ?>">
                                                </a>

                                                <h3 class="span_col3">
                                                    <a href="<?php echo $href ?>"
                                                       title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                                                </h3>

                                                <div class="gia-col3 mt-clearfix">
                                                    <?php echo $pri_sale . ((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '') ?>
                                                    <font>Đã
                                                        bán: <?php echo($val['count_order'] + count_product_order_success($val['id'])) ?></font>
                                                </div>
                                                <div class="list-bottom-star">
                                                    <?php if (!empty($number_sale)): ?>
                                                        <div class="left-star"><?php echo $number_sale ?>%</div>
                                                    <?php endif ?>
                                                    <div
                                                        class="list-icon-star <?php echo((empty($number_sale)) ? 'text-left' : '') ?>">
                                                        <ul>
                                                            <?php $a = count_rating($val['id'], 'products', FALSE) ?>
                                                            <?php $b = show_rating_products($val['id'], 'products', FALSE) ?>
                                                            <?php $j = ((!empty($a) && !empty($b)) ? round(($a / $b), 1) : 0); ?>
                                                            <?php
                                                            for ($i = 0; $i < 5; $i++) {
                                                                echo '<li>';
                                                                $v = $j - $i;
                                                                if ($v > 0) {
                                                                    if ($v == 0.5) {
                                                                        echo '<i class="fas fa-star-half-alt"></i>';
                                                                    } else {
                                                                        echo '<i class="fas fa-star"></i>';
                                                                    }
                                                                } else {
                                                                    echo '<i class="far fa-star"></i>';
                                                                }
                                                                echo '</li>';
                                                            }
                                                            ?>
                                                            <li>
                                                                <span>( <?php echo number_format(show_rating_products($val['id'], 'products', TRUE)) ?>
                                                                    )</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<div id="dt-fixed-buynow">
    <img class="br-expand" src="templates/frontend/resources/images/img-fixed-bot-up.png" alt="">
    <img class="br-expand" src="templates/frontend/resources/images/img-fixed-bot-down.png" alt="">

    <div id="ovflow-contain-fixed" class="">
        <div id="list-pd-buynow" class="ng-scope">
            <ul class="mt-list">
                <li id="temps0" class="ng-scope">
                    <div class="text-details conbody-buynow">
                        <div class="title mb5"><span class="ng-binding"><?php echo $DetailProducts['title'] ?></span>
                        </div>
                        <?php if (isset($result) && is_array($result) && count($result)): ?>
                            <div class="list-images-color mobile mt-flex-middle mt-flex">
                                <p>Phiên bản</p>
                                <ul class="mt-flex mt-flex-middle">
                                    <li class="active-img-2" data-src="<?php echo $DetailProducts['images'] ?>"
                                        data-id="<?php echo $DetailProducts['id'] ?>"
                                        data-source="<?php echo $DetailProducts['source'] ?>">
                                        <img src="<?php echo getthumb($DetailProducts['images'], TRUE) ?>"
                                             alt="<?php echo $DetailProducts['title'] ?>">
                                    </li>
                                    <?php foreach ($result as $key => $valv): ?>
                                        <li data-src="<?php echo $valv['images'] ?>" data-id="<?php echo $valv['id'] ?>"
                                            data-source="<?php echo $valv['source'] ?>">
                                            <img src="<?php echo getthumb($valv['images'], TRUE) ?>"
                                                 alt="<?php echo $valv['title'] ?>">
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>
                        <div class="list-text-style mt-flex-middle mt-flex mt-flex-space-between">
                            <div class="input-text-bottom mt-flex-middle mt-flex">
                                <div class="form-cart- mt-flex mt-flex-middle">
                                    <span class="btn-agument mines"></span>
                                    <input type="input" class="quantity_" value="1">
                                    <span class="btn-agument plus"></span>
                                </div>
                            </div>
                            <div class="text-gia-tam">
                                <ul class="mt-list">
                                    <li><?php echo $DetailProductsgia . ' ' . ((!empty($prdprice) && !empty($prdsaleoff) && $prdprice > $prdsaleoff) ? $DetailProductsgiaold : '') ?></li>
                                </ul>
                            </div>
                        </div>
                        <span class="dt-delete-buynow"></span>
                    </div>
                </li>
            </ul>
        </div>
        <div id="dt-total-money-buynow" class="mtb10 mt-flex-middle mt-flex mt-flex-space-between"
             data-price="<?php echo $DetailProducts['saleoff'] ?>">
            <span>Tổng số ước tính</span>

            <div class="price"><?php echo $DetailProductsgia ?></div>
        </div>
    </div>

    <div id="show-on-checkout">
        <div class="t-table">
            <div class="t-row">
                <div class="t-cell fx-add-cart">
                    <a class="pd-cart ajax-addtocart single_product" data-id="<?php echo $DetailProducts['id'] ?>"
                       data-quantity="1" data-option="">
                        <img src="templates/frontend/resources/images/id-add-cart.png" alt="add-cart">
                    </a>
                </div>
                <div class="t-cell">
                    <a class="checkout ajax-addtocart single_product" data-id="<?php echo $DetailProducts['id'] ?>"
                       data-quantity="1" data-option="" data-redirect="redirect">MUA NGAY</a>
                </div>
            </div>
        </div>
    </div>
    <a class="checkout ajax-addtocart single_product" data-id="<?php echo $DetailProducts['id'] ?>" data-option="" data-quantity="1">MUA
        NGAY</a>
</div>

<section class="overlay">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="overlay-content text-center">
                    <h2>KHUYẾN MÃI CỰC LỚN</h2>
                    <span style="color: rgb(0, 0, 0); font-style: italic;"><?php echo $DetailProducts['title'] ?></span>

                    <div class="clearfix-20"></div>
                    <div class="overlay-content" style="background: #000;padding: 10px;color: #fff">

                      <?php echo $this->fcSystem['detailproduct_title']?>


                    </div>
                    <div class="clearfix"></div>


                    <div class="overlay-content">
                        <?php $time = gmdate('Y-m-d H:i:s', time() + 7 * 3600); ?>
                        <?php $time_count = gmdate('Y-m-d H:i:s', time() + 12 * 3600 + 137); ?>
                        <?php if ($time <= $time_count): ?>
                            <div class="times-table-bottom">
                                <ul class="count-down-time-overlay mt-flex mt-flex-middle"
                                    data-time="<?php echo $time_count ?>">
                                </ul>
                            </div>
                        <?php endif ?>


                        <div class="clearfix-20"></div>
                        <form method="post" action="cartsale.html" id="sform_footer">
                            <div class="errorsaleoff"></div>

                            <input type="hidden" name="price" class="DetailProductsPrice"
                                   value="<?php echo $DetailProducts['saleoff'] ?>"/>

                            <div class="form-group">
                                <input type="text" name="fullname" class="fullname" placeholder="Họ và tên *">

                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="phone" placeholder="Số điện thoại *">

                            </div>
                            <div class="form-group">
                                <input type="text" name="address" class="address" placeholder="Địa chỉ *">

                            </div>
                            <div class="form-group">
                                <button type="submit">ĐẶT HÀNG NGAY</button>

                            </div>
                        </form>
                        
                        <script type="text/javascript" charset="utf-8">
                            $(document).ready(function () {
                                $('#sform_footer .error').hide();
                                var uri = $('#sform_footer').attr('action');
                                $('#sform_footer').on('submit', function () {
                                    var postData = $(this).serializeArray();
                                    var productDetails = JSON.stringify({
                                        'id':<?php echo $DetailProducts['id'] ?>,
                                        'name': "<?php echo $DetailProducts['title'] ?>",
                                        'qty': 1,
                                        'price':<?php echo $DetailProducts['saleoff'] ?>,
                                        'subtotal':<?php echo $DetailProducts['saleoff'] ?>,
                                        'detail': ({
                                            'id':<?php echo $DetailProducts['id'] ?>,
                                            'title': "<?php echo $DetailProducts['title'] ?>",
                                            'slug': '',
                                            'canonical': '',
                                            'images': "<?php echo $DetailProducts['images'] ?>",
                                            'price': '',
                                            'saleoff': '',
                                            'weight': '',
                                        }),
                                        'shipcode': ({
                                            'shop':'',
                                            'inner': '',
                                            'outner': '',

                                        })
                                    });
                                    $.post(uri, {
                                            productDetails: productDetails,
                                            fullname: $('#sform_footer .fullname').val(),
                                            phone: $('#sform_footer .phone').val(),
                                            address: $('#sform_footer .address').val(),
                                            price: $('#sform_footer .DetailProductsPrice').val(),
                                        },
                                        function (data) {
                                            var json = JSON.parse(data);
                                            $('#sform_footer .errorsaleoff').show();
                                            if (json.error.length) {
                                                $('#sform_footer .errorsaleoff').removeClass('alert alert-success').addClass('alert alert-danger');
                                                $('#sform_footer .errorsaleoff').html('').html(json.error);
                                            } else {
                                                $('#sform_footer .errorsaleoff').removeClass('alert alert-danger').addClass('alert alert-success');
                                                $('#sform_footer .errorsaleoff').html('').html('Đặt hàng thành công!.');
                                                $('#sform_footer').trigger("reset");
                                                setTimeout(function () {
                                                    location.reload();
                                                }, 5000);
                                            }
                                        });
                                    return false;
                                });
                            });
                        </script>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>
<style>
    .count-down-time-overlay {
        padding: 0px;
        margin: 0px;
        justify-content: center;
    }

    .count-down-time-overlay li {
        width: 80px;
    }

    .count-down-time-overlay .content_times {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .count-down-time-overlay li .number_times {
        background: #000;
        margin: 0px 5px;
        color: #fff;
        height: 57px;
        font-size: 40px;
        line-height: 57px;
    }

    .overlay-content input {
        width: 290px;
        border-width: 1px;
        border-style: solid;
        border-color: rgba(0, 0, 0, 1);
        height: 36px;
        padding: 10px;
    }

    .overlay-content button {
        border-radius: 5px;
        border-width: 2px;
        border-style: solid;
        border-color: rgba(0, 0, 0, 1);
        width: 290px;
        height: 40px;
        background-color: rgba(176, 68, 35, 1);
        color: #ffffff;
        font-weight: 600;
        line-height: 31px;
        box-shadow: 0px 0px 74px rgba(0, 0, 0, 1);
        font-size: 25px;
        text-align: center;
    }

    .clearfix-20 {
        clear: both;
        height: 20px;
    }

    .overlay-content {
        text-align: center !important;
        display: table;
        margin: 0px auto;
        padding: 30px 0;
    }

    .overlay {
        display: none;
        background-image: url(templates/frontend/resources/images/23-1540351225.jpg);
        background-color: rgba(127, 69, 57, 1);
        background-origin: content-box;
        background-size: cover;
        background-attachment: scroll;
        background-position: top center;
        background-repeat: no-repeat;
    }

    .overlay h2 {
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        color: rgba(0, 0, 0, 1);
        font-weight: 700;
        line-height: 63px;
        font-size: 35px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .overlay h2 {
            font-size: 33px;
            text-align: left;
        }
        footer {
            display: none;
        }
    }

</style>
<script>
    $(function(){
        var vid = document.getElementById("myVideo");
        function enableAutoplay() { 
          vid.autoplay = true;
          vid.load();
        }
        $(document).on('click', '.autoplay', function () {
            enableAutoplay();
        })
        click_video_player();
        function click_video_player(){
            vid.autoplay = true;
            vid.load();
        }
        
    });
</script> 
<script>
    $(document).ready(function () {
        $('#dt-fixed-buynow .br-expand').click(function () {
            $(this).parent().toggleClass('active');
        })
        $('#temps0 .mines').click(function () {
            var $_input = $(this).parent().find('.quantity_');
            var quantity = parseInt($_input.val());
            if (quantity <= 1) {
                quantity = 1;
            } else {
                quantity -= 1;
            }
            $_input.val(quantity);
            $('.ajax-addtocart.single_product').attr('data-quantity', quantity);
            load_total_price_cart();
        })
        $('#temps0 .plus').click(function () {
            var $_input = $(this).parent().find('.quantity_');
            var quantity = parseInt($_input.val());
            quantity += 1;
            $_input.val(quantity);
            $('.ajax-addtocart.single_product').attr('data-quantity', quantity);
            load_total_price_cart();
        });
        function load_total_price_cart() {
            var quantity = $('#temps0 .quantity_').val();
            var price = $('#dt-total-money-buynow').attr('data-price');
            var total = (quantity * price);
            $('#dt-total-money-buynow .price').html(number_format(total, 0, '.', '.') + ' ₫');
        }

        $('.list-images-color.mobile li').click(function () {
            var img = $(this).attr('data-src');
            var id = $(this).attr('data-id');
            $('.list-images-color.mobile li').removeClass('active-img-2');
            $(this).addClass('active-img-2');
            $('.ajax-addtocart.single_product').attr('data-id', id);
            load_price_versions_products(id);
            load_id_products_add_to_cart();
        });

        load_id_products_add_to_cart();
        load_products_count_price();
        $('.list-images-color.pc-screen li').click(function () {
            var img = $(this).attr('data-src');
            var id = $(this).attr('data-id');
            var source = $(this).attr('data-source');
            $(".slick-slider12.player_").removeClass('active_stop').find('video').remove();
            if (source != '') {
                $(".slick-slider12.player_").addClass('active_start');
                $(".slick-slider12.player_").attr('data-source', source);
                $(".products-hidden- .gallerys_button").removeClass('active');
                $(".products-hidden- .player_button").show().addClass('active');
                $('.player_ .ic_player_start').trigger('click');
            } else {
                $(".slick-slider12.player_").removeClass('active_start');
                $(".slick-slider12.player_").attr('data-source', '');
                $(".products-hidden- .player_button").hide().removeClass('active');
                $(".products-hidden- .gallerys_button").addClass('active');
            }
            $('.slick-slider12 img').attr('src', img);
            $('.list-images-color.pc-screen li').removeClass('active-img-2');
            $(this).addClass('active-img-2');
            $('.ajax-addtocart.single_product').attr('data-id', id);
            load_price_versions_products(id);
            load_id_products_add_to_cart();
            load_album_products(id);
        });

        $(document).on('click', '.click_tog', function () {
            $('.click_tog').removeClass('active');
            var flag = $(this).attr('data-show');
            var source = $(".slick-slider12.player_").attr('data-source');
            if (source != '') {
                if (flag == 1) {
                    $('.slick-slider12').removeClass('active_stop').addClass('active_start').find('video').remove();
                } else {
                    $('.slick-slider12').removeClass('active_start').addClass('active_stop');
                    $('.player_ .ic_player_start').trigger('click');
                }
            } else {

            }
            $(this).addClass('active');
        })

        function load_album_products(id) {
            $.post('<?php echo site_url("products/ajax/products/load_album_products");?>', {id: id}, function (data) {
                var json = JSON.parse(data);
                if (json.error == true) {
                    $('.slick-slider').html(json.html);
                    $('.count-img').html(json.count);
                }
            });
        }

        function load_price_versions_products(id) {
            $.post('<?php echo site_url("products/ajax/products/load_price_versions_products");?>', {id: id}, function (data) {
                var json = JSON.parse(data);
                $('.text-gia-tam').html(json.result);
                $('.input-text-bottom .label2 span').html(json.quantity);
                $('.ajax-addtocart.single_product').attr('data-price', json.price);
                $('#dt-total-money-buynow').attr('data-price', json.price);
                $('.ul3-star b').html('').html(json.count_order);
                load_products_count_price();
                load_total_price_cart();
            });
        }

        function load_products_count_price() {
            var outputText = 0;
            var outputText1 = 0;
            $('.images-text-link li a').each(function () {
                var divHtml = parseInt($(this).attr('data-price'));
                outputText = (outputText + divHtml);

                var divHtml1 = parseInt($(this).attr('data-price-old'));
                outputText1 = (outputText1 + divHtml1);
            });
            $('.text-button-images saleoff').html(number_format(outputText, 0, '.', '.') + 'đ');
            $('.text-button-images .priceold').html(number_format(outputText1, 0, '.', '.') + 'đ');
        }

        function load_id_products_add_to_cart() {
            var outputText = '';
            $('.images-text-link .ajax-addtocart').each(function () {
                var divHtml = $(this).attr('data-id');
                outputText += divHtml + '-';
            });
            $('.ajax-addtocart-all').attr('data-id', outputText.slice(0, -1));
        }
        
    });
</script>