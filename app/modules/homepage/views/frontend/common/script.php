<script>
    $(document).ready(function() {
        $(".btn-click-cart").click( function (){
            $("#site-cart").addClass("active");
        })
        $("#site-close-handle").click( function (){
            $("#site-cart").removeClass("active");
        })
        //xóa cart
        $(document).on('click', '.delete_item', function () {
            var idprd = $(this).parent().find('.ajax-quantity').val();
            ajax_cart_update_delete(idprd);
            return false;
        });
        function ajax_cart_update_delete(idprd) {
            $.post('<?php echo site_url('products/ajax/cart/deletecartv');?>', {idprd: idprd}, function (data) {
                var price = JSON.parse(data);
                $('#ajax-cart-form').html(price.html);
                $('#total-view-cart').html(price.total);
                $('#qtotalitems').html(price.item);
            });
        }
        //end xóa cart
        //thêm vào giỏ hàng
        $(document).on('click', '.ajax-addtocart', function () {
            var product = $(this);
            $.post('products/ajax/cart/addtocartv', {
                id : product.attr('data-id'),
                quantity : product.attr('data-quantity'),
                color : product.attr('data-color'),
                size : product.attr('data-size'),
                price : product.attr('data-price'),
                sanpham : product.attr('data-sanpham'),
            },function(data){
                var json = JSON.parse(data);
                $('#ajax-cart-form').html(json.html);
                $('#total-view-cart').html(json.total);
                $('#qtotalitems').html(json.item);
                $("#site-cart").addClass("active");

            });
        });
        //end thêm giỏ hàng
    });

</script>
<?php /*?>
<script src="templates/frontend/resources/libs/dist/jquery.mmenu.all.js"></script>
<script src="templates/frontend/resources/libs/slider/owl.carousel.js"></script>
<script src="templates/frontend/resources/libs/bootstrap/js/popper.min.js"></script>
<script src="templates/frontend/resources/libs/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="templates/frontend/resources/js/main.js"></script>
<script type="text/javascript" src="templates/frontend/resources/js/jquery.countdown.min.js"></script>
<script>
    $('.count-down-time').each(function(index, element){
        var data_time = $(element).attr('data-time');
        $(element).countdown(data_time, function(event) {
            var html = '';
            html += '<li><div class="days number_times"><span>%D</span> Ngày</div><div class="smalltext">Days</div></li>';
            html += '<li><div class="hours number_times"><span>%H</span> : </div><div class="smalltext">Hours</div></li>';
            html += '<li><div class="minutes number_times"><span>%M</span> : </div><div class="smalltext">Minutes</div></li>';
            html += '<li><div class="seconds number_times"><span>%S</span></div><div class="smalltext">Seconds</div></li>';
            $(element).html(event.strftime(html));
        });
    });

    $('.count-down-time-detail').each(function(index, element){
        var data_time = $(element).attr('data-time');
        $(element).countdown(data_time, function(event) {
            var html = '';
            html += '<li><div class="days number_times"><span>%D</span> Ngày</div></li>';
            html += '<li><div class="hours number_times"><span>%H</span>:</div></li>';
            html += '<li><div class="minutes number_times"><span>%M</span>:</div></li>';
            html += '<li><div class="seconds number_times"><span>%S</span></div></li>';
            $(element).html(event.strftime(html));
        });
    });

    $('.count-down-time-overlay').each(function(index, element){
        var data_time = $(element).attr('data-time');
        $(element).countdown(data_time, function(event) {
            var html = '';
            html += '<li><div class="content_times">Ngày</div><div class="days number_times"><span>%D</span></div></li>';
            html += '<li><div class="content_times">Giờ</div><div class="hours number_times"><span>%H</span></div></li>';
            html += '<li><div class="content_times">Phút</div><div class="minutes number_times"><span>%M</span></div></li>';
            html += '<li><div class="content_times">Giây</div><div class="seconds number_times"><span>%S</span></div></li>';
            $(element).html(event.strftime(html));
        });
    });
</script>

<script>
    $(document).ready(function() {


        $('.uk-alert-close.uk-close').click(function(){
            $('.fixed_bg').css('height', 0).remove();
        })
        $('.quantity').change(function(){
            var number = $(this).val();
            $('.ajax-addtocart').attr('data-quantity','');
            $('.ajax-addtocart.single_product').attr('data-quantity', number);
        });
        if($('.btn-up')) {
            $('.btn-up').click(function() {
                var $_input = $(this).parent().find('.quantity');
                var quantity = parseInt($_input.val());
                if(quantity <= 1){
                    quantity = 1;
                }else {
                    quantity -= 1;
                }
                $_input.val(quantity);
                $('.ajax-addtocart.single_product').attr('data-quantity', quantity);
            });
        }
        if($('.btn-down')) {
            $('.btn-down').click(function() {
                var $_input = $(this).parent().find('.quantity');
                var quantity = parseInt($_input.val());
                quantity += 1;
                $_input.val(quantity);
                $('.ajax-addtocart.single_product').attr('data-quantity', quantity);
            });
        }

        $('.ajax-addtocart-all').click(function(){
            var product = $(this);
            $.post('<?php echo site_url("products/ajax/cart/addalltocart");?>', {
                id : product.attr('data-id'),

            },function(data){
                if(product.attr('data-redirect') == 'redirect'){
                    window.location.href = '<?php echo BASE_URL ?>' + 'dat-mua' + '.html';
                }else{
                    var json = JSON.parse(data);
                    $('#modal-cart .cart-content').html(json.html);
                    $('#ajax-home-cart-quantity').html(json.item);
                    $('.text-right-cart font').html(json.item);
                    $('#modal-cart').modal('toggle');
                }
            });
            return false;
        });

        $('.ajax-deltocart').click(function(){
            var product = $(this);
            $.post('<?php echo site_url("products/ajax/cart/deltocart");?>', {
                id : product.attr('data-id'),
            },function(data){
                if(product.attr('data-redirect') == 'redirect'){
                    window.location.href = '<?php echo BASE_URL ?>' + 'dat-mua' + '.html';
                }else{
                    alert('Bỏ sản phẩm thành công')
                    window.location.reload();
                }
            });
            return false;
        });

        $('.ajax-addtocart').click(function(){
            var product = $(this);
            var color = $('.item_attr_advanced_color.mt-flex.mt-flex-middle');
            var size = $('.item_attr_advanced_size.mt-flex.mt-flex-middle');
            for (var i = 0; i < color.length; i++) {
                if ($(color[i]).find('ul.mt-list li a.active').length == 0) {
                    if ( $('.list_attr_advanced_color.mt-alert-danger .text-left.mt5').length > 0) {
                        $('.list_attr_advanced_color.mt-alert-danger .text-left.mt5').html('Vui lòng chọn màu sắc');
                    }else{
                        $('.list_attr_advanced_color').addClass('mt-alert-danger').append('<div class="text-left mt5">Vui lòng chọn màu sắc</div>');
                    }
                    return false;
                }
            }
            for (var i = 0; i < size.length; i++) {
                if ($(size[i]).find('ul.mt-list li a.active').length == 0) {
                    if ( $('.list_attr_advanced_size.mt-alert-danger .text-left.mt5').length > 0) {
                        $('.list_attr_advanced_size.mt-alert-danger .text-left.mt5').html('Vui lòng chọn size');
                    }else{
                        $('.list_attr_advanced_size').addClass('mt-alert-danger').append('<div class="text-left mt5">Vui lòng chọn size</div>');
                    }
                    return false;
                }
            }
            if ($('.input-text-bottom.mt-flex-middle.mt-flex .label2 span').html() == 0) {
                if ( $('.list_attr_advanced_size.mt-alert-danger .text-left.mt5').length > 0) {
                    $('.list_attr_advanced_size.mt-alert-danger .text-left.mt5').html('Sản phẩm này hiện đang hết hàng, bạn vui lòng chọn sản phẩm khác.');
                }else{
                    $('.list_attr_advanced_size').addClass('mt-alert-danger').append('<div class="text-left mt5">Sản phẩm này hiện đang hết hàng, bạn vui lòng chọn sản phẩm khác.</div>');
                }
            }else{
                if ($(window).width() <= 768) {
                    $('[name="fullname"]').focus();
                    return false;
                }
                $.post('http://vando.local/products/ajax/cart/addtocart.html', {
                    id : product.attr('data-id'),
                    quantity : product.attr('data-quantity'),
                    color : product.attr('data-color'),
                    size : product.attr('data-size'),
                    price : product.attr('data-price'),
                    sanpham : product.attr('data-sanpham'),
                },function(data){
                    var json = JSON.parse(data);
                    if (json.error == false) {
                        $('.list_attr_advanced').addClass('mt-alert-danger').append('<div class="text-left mt5">Vui lòng chọn phân loại hàng</div>');
                    }else{
                        if(product.attr('data-redirect') == 'redirect'){
                        }else{
                            $('#modal-cart .cart-content').html(json.html);
                            $('#ajax-home-cart-quantity').html(json.item);
                            $('.text-right-cart font').html(json.item);
                            if (product.attr('data-flag') == 1) {
                                alert('Thêm sản phẩm thành công')
                                window.location.reload();
                            }else{
                                $('#modal-cart').modal('toggle');
                            }
                        }
                    }
                });
            }
            return false;
        });
            
        $(document).on('click', '#ec-module-cart .augment', function(){
        var item = $(this);
            var quantity = parseInt($(this).parent().find('.quantity').val());
            quantity = quantity + 1;
            item.parent().find('.quantity').val(quantity);
            ajax_cart_update();
            return false;
        }); 
            
        $(document).on('click', '#ec-module-cart .abate', function(){
            var item = $(this);
            var quantity = parseInt($(this).parent().find('.quantity').val());
            if(quantity <= 1){
                quantity = 1
            } else {
                quantity = quantity - 1;
            }
            item.parent().find('.quantity').val(quantity);
            ajax_cart_update();
            return false;
        });
        
        $(document).on('click', '#ec-module-cart .delete', function(){
            var item = $(this);
            item.parent().parent().parent().parent().parent().find('.quantity').val(0);
            item.parent().parent().parent().parent().parent().addClass('uk-hidden').removeClass('item');
            ajax_cart_update();
            return false;
        });
        
        $(document).on('click', '.ec-cart-continue', function(){
            $('#modal-cart').modal('hide');
            window.location.reload();
            return false;
        });
        
        $('.augment').click(function() {
            var num_order = parseInt($(this).parent().find('.quantity').val());
            num_order += 1;
            $(this).parent().find('.quantity').val(num_order);
        });
        $('.abate').click(function() {
            var cart_class = $(this).attr('data-cart');
            var num_order = parseInt($(this).parent().find('.quantity').val());
            if(num_order <= 1) {
                num_order = 1
            }else {
                num_order -= 1;
            }
            $(this).parent().find('.quantity').val(num_order);
        });
    });

    function ajax_cart_update(){
        $.post('<?php echo site_url("products/ajax/cart/updatetocart");?>', $('#ajax-cart-form').serialize(), function(data){
            var price = JSON.parse(data);
            $('#ajax-cart-form').html(price.html);
            $('.text-right-cart font').html(price.item);
        });
        return false;
    }
    function number_format (number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
</script>
<?php */?>