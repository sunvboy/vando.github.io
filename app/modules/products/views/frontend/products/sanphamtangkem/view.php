<div class="content-text-images-video main-content_3" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php if (!empty($DetailProducts['id_sanphamtangkem'])): ?>
                    <?php
                    $result_sanphamtangkem = $this->Autoload_Model->_get_where(array(
                        'select' => 'id, title,images',
                        'table' => 'products_sanphamtangkem',
                        'where' => array('publish' => 1),
                        'where_in' => explode('-', $DetailProducts['id_sanphamtangkem']),
                        'where_in_field' => 'id',
                        'order_by' => 'id desc'
                    ), TRUE);


                    ?>
                    <?php if (isset($result_sanphamtangkem) && is_array($result_sanphamtangkem) && count($result_sanphamtangkem)): ?>
                        <div class="text-left-video">
                            <h2>Sản phẩm tặng kèm</h2>

                            <div class="images-text-link mt-flex mt-flex-middle mt-flex-space-between">
                                <ul>
                                    <?php foreach ($result_sanphamtangkem as $key => $val): ?>
                                        <li>
                                            <a class="click_addsptk click_addsptk<?php echo $val['id']?> <?php if($key>0){?>plus_2<?php }?> "  data-id="<?php echo $val['id'] ?>">
                                                <img src="<?php echo getthumb($val['images'], TRUE) ?>" alt="<?php echo $val['title'] ?>">
                                            </a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>

                            </div>
                            <?php if (isset($result_sanphamtangkem) && is_array($result_sanphamtangkem) && count($result_sanphamtangkem)): ?>
                                <div class="list-gt-mm">
                                    <ul>
                                        <?php foreach ($result_sanphamtangkem as $key => $val): ?>
                                            <li>
                                                <a data-id="<?php echo $val['id'] ?>" class="click_addsptk click_addsptk<?php echo $val['id']?>" >
                                                    <span class="span1-mm">Sản phẩm khuyến mại: </span>
                                                    <span class="span2-mm"><?php echo $val['title'] ?></span>
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
            <script>
                $(document).on('click', '.click_addsptk', function () {
                    var id = $(this).data('id');
                    $('.click_addsptk').removeClass('mt-active');
                    $('.click_addsptk' + id).addClass('mt-active');
                    $('.ajax-addtocart.single_product, .ajax-addtocart-all').attr('data-sanpham', id);

                });
            </script>

        </div>
    </div>
</div>