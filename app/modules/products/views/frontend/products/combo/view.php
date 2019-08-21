<div class="content-text-images-video main-content_3" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php
                $result_combos = $this->Autoload_Model->_get_where(array(
                    'select' => 'id, title,images,id_combo,saleoff',
                    'table' => 'products',
                    'where' => array('publish' => 1,'trash' => 0,'parentid' => $DetailProducts['id']),
                    'order_by' => 'id desc'
                ), TRUE);


                ?>
                <?php if (isset($result_combos) && is_array($result_combos) && count($result_combos)): ?>
                    <div class="text-left-video">
                        <h2>Combos sản phẩm</h2>

                        <div class="images-text-link mt-flex mt-flex-middle mt-flex-space-between">
                            <ul>
                                <?php foreach ($result_combos as $key => $val): ?>
                                    <li>
                                        <a class="click_add click_add<?php echo $val['id']?> <?php if($key>0){?>plus_2<?php }?> "  data-id="<?php echo $val['id'] ?>" data-price="<?php echo $val['saleoff'] ?>">
                                            <img src="<?php echo getthumb($val['images'], TRUE) ?>" alt="<?php echo $val['title'] ?>">
                                        </a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                            <div class="text-button-images" id="text-button-images">
                                <div id="tonggiatri">

                                </div>
                                <button type="submit" class="ajax-addtocart-all" data-id="" data-price=""> Thêm vào giỏ hàng</button>
                            </div>
                        </div>
                        <?php if (isset($result_combos) && is_array($result_combos) && count($result_combos)): ?>
                            <div class="list-gt-mm">
                                <ul>
                                    <?php foreach ($result_combos as $key => $val): ?>
                                        <?php
                                        $result_child = $this->Autoload_Model->_get_where(array(
                                            'select' => 'id, title, slug, canonical, images, description, price, saleoff, status',
                                            'table' => 'products',
                                            'where' => array('publish' =>1, 'trash' => 0),
                                            'where_in' => explode('-', $val['id_combo']),
                                            'where_in_field' => 'id',
                                            'order_by' => 'id desc, order asc'
                                        ),TRUE);
                                        ?>
                                        <li>
                                            <a data-id="<?php echo $val['id'] ?>" class="click_add click_add<?php echo $val['id']?>" data-price="<?php echo $val['saleoff'] ?>">
                                                <span class="span1-mm"><?php echo $val['title'] ?>: </span>
                                                <?php if(isset($result_child) && is_array($result_child) && count($result_child)) {
                                                    foreach ($result_child as $keyC => $valC) {?>
                                                        <span class="span2-mm"><?php echo $valC['title'] ?></span>&nbsp;+&nbsp;
                                                    <?php }}?>
                                            </a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>

                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>

            </div>
            <script>
                $('#text-button-images').hide();
                $(document).on('click', '.click_add', function () {
                    var id = $(this).data('id');
                    var price = $(this).data('price');
                    $('.click_add').removeClass('mt-active');
                    $('.click_add' + id).addClass('mt-active');
                    $('.ajax-addtocart-all').attr('data-id', id);
                    $('.ajax-addtocart-all').attr('data-price', price);
                    $('#tonggiatri').html('<p>Tổng giá trị : <span class="saleoff">'+number_format(price, 0, '.', '.') + ' ₫'+'</span></p>');
                    $('#text-button-images').show();

                });
            </script>

        </div>
    </div>
</div>