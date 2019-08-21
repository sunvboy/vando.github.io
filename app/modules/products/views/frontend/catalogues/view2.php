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
                </div>
                <div class="col-lg-3 col-md-4 pull-lg-9 pull-md-4 hover-catalog mb15">
                    <?php
                    $left_nav = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                        'select' => 'id, title, slug, canonical, icon, lft, rgt',
                        'where' => array('trash' => 0,'publish' => 1, 'highlight' => 1, 'alanguage' => ''.$this->fc_lang.''),
                        'limit' => 6,
                        'order_by' => 'order asc, id desc'
                    ));
                    if(isset($left_nav) && is_array($left_nav) && count($left_nav)){
                        foreach($left_nav as $key => $val){
                            $left_nav[$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                                'select' => 'id, title, slug, canonical, images, lft, rgt',
                                'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''),
                                'limit' => 5,
                                'order_by' => 'order asc, id desc',
                            ));
                        }
                    }
                    ?>
                    <?php if(isset($left_nav) && is_array($left_nav) && count($left_nav)){ ?>
                        <div class="list-left-content">
                            <h3><i class="fas fa-bars"></i> <span>Danh mục sản phẩm</span></h3>
                        </div>
                        <div class="list-icon-left list-icon-left-2">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="."><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                            <?php foreach($Breadcrumb as $key => $val){ ?>
                                <?php
                                $title = $val['title'];
                                $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues');
                                ?>
                                <li class="breadcrumb-item active">
                                    <a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo mb_strtolower($title, 'UTF-8'); ?></a>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END MAIN TOP -->


    <div class="main-content_3 mb0">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <aside class="mt-aside mb20">
                        <?php $this->load->view('homepage/frontend/common/filter') ?>
                    </aside>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="title-right-col9">
                        <div class="row mt-flex-middle">
                            <div class="col-xl-5 col-md-12">
                                <div class="h1-title-right">
                                    <h1><?php echo $DetailCatalogues['title'] ?></h1>
                                </div>
                            </div>
                            <div class="col-xl-7 col-md-12">
                                <div class="list-right-col9 text-right">
                                    <ul class="mt-flex mt-flex-middle mt-flex-right">
                                        <li><span>Xếp Theo : </span></li>
                                        <li><a class="mt-active" href="#">Hàng mới</a></li>
                                        <li><a href="#">Giá thấp đến cao</a></li>
                                        <li><a href="#">Giá cao xuống thấp</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="products-right-content_3 active-content_3">
                        <?php if(isset($productsList) && is_array($productsList) && count($productsList)){ ?>
                            <div class="row" id="ajax-product-list">
                                <?php foreach ($productsList as $keyp => $val): ?>
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
                                    <div class="col-lg-4 col-6 col-md-4 mb20">
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
                                                    <div class="left-star"><?php echo $number_sale ?>%</div>
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
                            <div id="ajax-product-pagination">
                                <?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
                            </div>
                        <?php }else{ ?>
                            <div class="mtb10 col-md-12 text-center"><?php echo $this->lang->line('no_data_table') ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="backend-loader"></div>