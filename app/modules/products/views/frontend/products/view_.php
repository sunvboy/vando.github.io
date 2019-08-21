
<section class="conbtent-main">

    <!-- END MAIN TOP -->
    <div class="main-slick-details mt25">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb25" id="load_albums_color">
                    <?php echo $this->load->view('products/frontend/products/attr/albums')?>
                </div>
                <div class="col-md-7 mb25">
                    <div class="text-details">
                        <div class="text-details">
                            <h1><?php echo $DetailProducts['title'] ?></h1>
                            <?php echo $this->load->view('products/frontend/products/attr/rating')?>

                            <?php $customer = $this->config->item('fcCustomer'); ?>
                            <div class="list-text-style">
                                <?php echo $DetailProducts['description'] ?>
                                <div class="text-gia-tam">
                                    <ul>
                                        <li><?php echo $price_affiliate . $DetailProductsgia . ' ' . ((!empty($prdprice) && !empty($prdsaleoff) && $prdprice > $prdsaleoff) ? $DetailProductsgiaold : '') ?></li>
                                        <li>
                                            <a class="<?php echo((!empty($DetailProducts['status']==1)) ? 'bg-primary' : 'bg-danger') ?>"><?php echo $this->configbie->data('status', ((!empty($DetailProducts['status'])) ? 1 : 0)) ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!--chọn size chọn color-->
                            <?php echo $this->load->view('products/frontend/products/attr/view')?>

                            <!--end chọn size chọn color-->
                            <div class="input-text-bottom mt-flex-middle mt-flex">
                                <label>Số lượng</label>

                                <div class="form-cart- mt-flex mt-flex-middle">
                                    <span class="btn-agument mines btn-up"></span>
                                    <input type="input" class="quantity" value="1">
                                    <span class="btn-agument plus btn-down"></span>
                                </div>
                                <span class="label2"><span><?php echo $DetailProducts['status'] ?></span> sản phẩm có sẵn</span>
                            </div>
                            <div class="mtb20 product-time mt-flex mt-flex-middle">
                                <div class="ul3-star">
                                    <i class="fas fa-user-tie mr5"></i>
                                    <b><?php echo number_format($DetailProducts['count_order'] + count_product_order_success($DetailProducts['id'])) ?></b> đã mua</a>
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
                                <button type="submit" class="ajax-addtocart single_product" data-quantity="1" data-id="<?php echo $DetailProducts['id'] ?>" data-redirect="redirect" data-price="<?php echo $DetailProducts['saleoff']?>" data-color="" data-size="" data-sanpham="">
                                    <i class="fas fa-luggage-cart"></i> Mua ngay
                                </button>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $this->load->view('products/frontend/products/combo/view')?>
    <?php echo $this->load->view('products/frontend/products/sanphamtangkem/view')?>


</section>

<div id="dt-fixed-buynow">
    <img class="br-expand" src="templates/frontend/resources/images/img-fixed-bot-up.png" alt="">
    <img class="br-expand" src="templates/frontend/resources/images/img-fixed-bot-down.png" alt="">
    <div id="ovflow-contain-fixed" class="">
        <div id="list-pd-buynow" class="ng-scope">
            <ul class="mt-list">
                <li id="temps0" class="ng-scope">
                    <div class="text-details conbody-buynow">
                        <div class="title mb5"><span class="ng-binding"><?php echo $DetailProducts['title'] ?></span></div>
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
                       data-quantity="1" data-color="" data-size="">
                        <img src="templates/frontend/resources/images/id-add-cart.png" alt="add-cart">
                    </a>
                </div>
                <div class="t-cell">
                    <a class="checkout ajax-addtocart single_product" data-id="<?php echo $DetailProducts['id'] ?>"
                       data-quantity="1" data-color="" data-size="" data-redirect="redirect">MUA NGAY</a>
                </div>
            </div>
        </div>
    </div>
    <a class="checkout ajax-addtocart single_product" data-id="<?php echo $DetailProducts['id'] ?>" data-color="" data-size="" data-quantity="1">MUA NGAY</a>
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


</script>