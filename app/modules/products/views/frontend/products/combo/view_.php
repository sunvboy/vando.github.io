<div class="content-text-images-video main-content_3" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div  class="<?php echo((!empty($this->fcSystem['homepage_slogan'])) ? 'col-lg-9 col-md-8' : 'col-lg-12 col-md-12') ?>">
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
                                        <a href="#" data-color="" data-size=""
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
                                            <a href="#" data-color="" data-size=""
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

            </div>

        </div>
    </div>
</div>