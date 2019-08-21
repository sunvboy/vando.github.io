<section class="conbtent-main">



    <div class="main-content_3 mb0">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-12">

                    <div class="products-right-content_3 active-content_3">
                        <?php if(isset($productsList) && is_array($productsList) && count($productsList)){ ?>
                            <div class="row" id="ajax-product-list">
                                <?php foreach ($productsList as $keyp => $val): ?>
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
                                        $price_affiliate = ((!empty(price_affiliate($saleoff, $val['id']))) ? '<small>' . str_replace(',', '.', number_format(price_affiliate($saleoff, $val['id']))) . '</small>' : '');


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
                                        $price_affiliate = ((!empty(price_affiliate($saleoff, $val['id']))) ? '<small>' . str_replace(',', '.', number_format(price_affiliate($saleoff, $val['id']))) . '</small>' : '');

                                    }


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