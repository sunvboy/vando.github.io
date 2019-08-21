<main id="main-site">
    <section class="sec-main-page">
        <div class="wp-list-tin">
            <div class="container">
                <div class="wp-boloc">
                    <div class="wp-title">
                        <h1 class="h1-title-danhmuc"><?php echo $DetailCatalogues['title']?></h1>
                        <?php $hrefC = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'products_catalogues');  ?>
                    </div>
                    <div class="filter">
                        <div class="sapxep">
                            <span>Sắp xếp theo:</span>
                            <a href="<?php echo $hrefC?>?price=desc">Giá giảm dần</a> - <a href="<?php echo $hrefC?>?price=asc">Giá tăng dần</a>

                        </div>

                        <?php echo $this->load->view('homepage/frontend/common/filter')?>
                    </div>
                </div>
                <!-- end bo loc -->

                <?php if (isset($productsList) && is_array($productsList) && count($productsList)) { ?>

                    <div class="wp-list-sp-home list-danhmyc-spsp">
                        <div class="row" id="ajax-product-list">
                            <?php foreach ($productsList as $keyp => $val): ?>
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
                                        $pri_sale = 'Liên hệ';
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
                                        $pri_sale = 'Liên hệ';
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
                                                            <span style="background: url('<?php echo $valColor['images'] ?>')"></span>
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
                    <!-- end list sp -->
                    <div id="ajax-product-pagination" style="text-align: center">
                        <?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>

                    </div>

                <?php } ?>


            </div>
        </div>
    </section>
</main>