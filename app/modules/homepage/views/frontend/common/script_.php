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
                option : product.attr('data-option'),
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
                            window.location.href = 'http://vando.local/' + 'dat-mua' + '.html';
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
<script>
    $(function() {
    setInterval(function() {
        $('#someone-purchased > div:first')
            .fadeOut(200)
            .next()
            .fadeIn(0)
            .end()
            .appendTo('#someone-purchased');
            var collections = <?php load_products_type() ?>;
            var phone = ['0974665xxx', '0971824xxx', '0968773xxx', '0966421xxx', '0916291xxx', '0888192xxx', '0913439xxx', '0962056xxx', '0912969xxx', '0127246xxx', '0166779xxx', '0166793xxx', '0923387xxx', '0913756xxx', '0903994xxx', '0913610xxx', '0982520xxx', '0912669xxx', '0168277xxx', '0946245xxx', '0983547xxx', '0946568xxx', '0907441xxx', '0977975xxx', '0903364xxx', '0931908xxx', '0169688xxx', '0987526xxx', '0169290xxx', '0165213xxx', '0946245xxx', '0967775xxx', '0913276xxx', '0931908xxx', '0944388xxx', '0983101xxx', '0908740xxx', '0918204xxx', '0902661xxx', '0972367xxx', '0918035xxx', '0982819xxx', '0918530xxx', '0908676xxx', '0982515xxx', '0918324xxx', '0918534xxx', '0903727xxx', '0901776xxx', '0916946xxx', '0915038xxx', '0982144xxx', '0163551xxx', '0946157xxx', '0938181xxx', '0941827xxx', '0971011xxx', '0919868xxx', '0913823xxx', '0975434xxx', '0169473xxx', '0983897xxx', '0913151xxx', '0166299xxx', '0974384xxx', '0169643xxx', '0123926xxx', '0906656xxx', '0916812xxx', '0913955xxx', '0985839xxx', '0977256xxx', '0974010xxx', '0935080xxx', '0918125xxx', '0914451xxx', '0163320xxx', '0912016xxx', '0985779xxx', '0983328xxx', '0985287xxx', '0916609xxx', '0989352xxx', '0905316xxx', '0968275xxx', '0167520xxx', '0938708xxx', '0938922xxx', '0167707xxx', '0128411xxx', '0128411xxx', '0221386xxx', '0908534xxx', '0971902xxx', '0911473xxx', '0917384xxx', '0169499xxx', '0948121xxx', '0967797xxx', '0913222xxx'];
            var mytimeAgo = ['1 giây','2 giây','3 giây','4 giây','5 giây','6 giây','7 giây','8 giây','9 giây','10 giây','11 giây','12 giây','13 giây','14 giây','15 giây','16 giây','17 giây','18 giây','19 giây','20 giây','21 giây','22 giây','23 giây','24 giây','25 giây','26 giây','27 giây','28 giây','29 giây','30 giây','31 giây','32 giây','33 giây','34 giây','35 giây','36 giây','37 giây','38 giây','39 giây','40 giây','41 giây','42 giây','43 giây','44 giây','45 giây','46 giây','47 giây','48 giây','1 phút', '2 phút', '3 phút', '4 phút', '5 phút', '6 phút', '7 phút', '8 phút', '9 phút', '10 phút', '11 phút', '12 phút', '13 phút', '14 phút', '15 phút', '16 phút', '17 phút', '18 phút', '19 phút', '20 phút', '21 phút', '22 phút', '23 phút', '24 phút', '25 phút', '26 phút', '27 phút', '28 phút', '29 phút', '30 phút', '31 phút', '32 phút', '33 phút', '34 phút', '35 phút', '36 phút', '37 phút', '38 phút', '39 phút', '40 phút', '41 phút', '42 phút', '43 phút', '44 phút', '45 phút', '46 phút', '47 phút', '48 phút', '49 phút', '50 phút', '51 phút', '52 phút' ];  
            var people = [ 'ANH HƯNG', 'Nguyễn Đăng Dũng', 'ANH HẢI', 'Anh Tấn', 'Anh Bình', 'Anh Thái', 'ANH LỘC', 'Anh Thành', 'Anh Chương', 'Anh Giang', 'Anh Trịnh Quốc Thành', 'Anh Tín', 'ANH KHÁNH', 'Anh Lang', 'Anh ngân', 'ANH PHAN', 'Chị Hà', 'Anh Tuấn', 'Anh Thế', 'Anh tuấn', 'anh Dũng', 'Đoàn Văn Thiệu', 'Anh Phước', 'Hoàng Văn Quỳnh', 'Nguyễn Thành Nhơn', 'CHỊ MAI', 'NGUYỄN TUẤN ANH', 'Anh tiến', 'Chị Nga', 'Anh Trung', 'Anh tuấn', 'Anh Dũng', 'Anh Hàm', 'CHỊ MAI', 'Nguyễn Thị Mỹ Phượng', 'ANH THẮNG', 'Bùi Sách', 'DIỆP THANH ĐIỀN', 'NGUYỄN MINH NHỰT', 'Anh Hồng', 'Anh trọng', 'ANH TIỀN', 'Nguyễn Văn Bình', 'VŨ TUYNH', 'Anh Hùng', 'A TRẦN THANH HÒA', 'Lê Thành Trung', 'Anh linh', 'Nguyễn Văn Quyết', 'A quang', 'Anh lợi', 'Anh Thắng', 'Anh chính', 'Lê Trường', 'Nguyễn Ngọc Trung', 'võ hồng nam', 'Anh Trà', 'TRẦN QUỐC DŨNG', 'ANH NGUYỄN HUY LONG.', 'Trần Chính', 'Phạm Đình Tháp', 'Nguyễn Thị Kim Loan', 'LẠI HỒNG CHIẾN', 'Anh Cờ', 'Nguyễn Ngọc Huấn', 'NGUYỄN THANH HẢI', 'Nguyễn Văn Lâm', 'Phạm Linh', 'Đặng Thị Hồng Hạnh', 'Đoàn Văn Sơn', 'Anh Kỳ', 'Trần Văn Hoá', 'Anh Khúc', 'TRẦN ĐỨC VIỄN', 'Anh Vinh', 'Anh Phi', 'Chị Loan', 'VŨ HỒNG ĐỨC', 'Anh Tuyền', 'Anh Hòa', 'Anh Tuấn', 'Anh Quốc', 'Anh Kiệm', 'Anh Hùng', 'Anh Toản', 'Anh Tiền', 'Nguyễn Tuấn', 'CHỊ NGỌC', 'anh Thái', 'Anh Chung', 'Anh Chung', 'LÊ VĂN TIỂU', 'LÊ NHƯ SƠN', 'Chú Thủy', 'Dương Mộng Nghi', 'Anh Dũng', 'Anh Tân', 'Anh hưng', 'ANH SƠN', 'ANH THÀNH'];  
            var country = ['Bà Rịa - Vũng Tàu', 'Lâm Đồng', 'Tuyên Quang', 'Thành phố Hồ Chí Minh', 'Quảng Bình', 'Thành phố Hồ Chí Minh', 'Đắk Lắk', 'Hải Dương', 'Đắk Lắk', 'Quảng Bình', 'Bình Dương', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Quảng Nam', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Thanh Hóa', 'Huế', 'Thành phố Hồ Chí Minh', 'Nghệ An', 'Thành phố Hồ Chí Minh', 'Nam Định', 'Bạc Liêu', 'Quảng Trị', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Bắc Giang', 'Vĩnh Phúc', 'Hà Nội', 'Kiên Giang', 'Nghệ An', 'Đồng Nai', 'Hà Tĩnh', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Thanh Hóa', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Bắc Ninh', 'Cần Thơ', 'Bà Rịa - Vũng Tàu', 'Bình Dương', 'Bình Dương', 'Đà Nẵng', 'Đồng Nai', 'Đồng Nai', 'Thành phố Hồ Chí Minh', 'Phú Thọ', 'Hà Nội', 'Bắc Ninh', 'Đắk Lắk', 'Thành phố Hồ Chí Minh', 'Đồng Nai', 'Bình Dương', 'Long An', 'Thanh Hóa', 'Tây Ninh', 'Yên Bái', 'Thành phố Hồ Chí Minh', 'Thanh Hóa', 'Gia Lai', 'Ninh Bình', 'Quảng Ninh', 'Lào Cai', 'Quảng Ninh', 'Long An', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Tây Ninh', 'Thanh Hóa', 'Kon Tum', 'Kiên Giang', 'Đắk Lắk', 'Đồng Tháp', 'Phú Yên', 'Gia Lai', 'Lào Cai', 'Hải Phòng', 'Phú Thọ', 'Hà Nội', 'Long An', 'Ninh Bình', 'Kon Tum', 'Ninh Bình', 'Quảng Ninh', 'Hải Dương', 'Thành phố Hồ Chí Minh', 'Bà Rịa - Vũng Tàu', 'Lâm Đồng', 'Lâm Đồng', 'Hưng Yên', 'Thành phố Hồ Chí Minh', 'Sơn La', 'Cần Thơ', 'Hải Phòng', 'Thành phố Hồ Chí Minh', 'Hà Nội', 'Lâm Đồng', 'Hà Nội']; 
            var randomlytimeAgo = Math.floor(Math.random() * mytimeAgo.length);
            var randomlytimeAgo1 = Math.floor(Math.random() * people.length);
            var randomlytimeAgo2 = Math.floor(Math.random() * country.length);
            var randomlytimeAgo3 = Math.floor(Math.random() * phone.length);
            var randomlytimeAgo4 = Math.floor(Math.random() * collections.length);
            var currentmytimeAgo = mytimeAgo[randomlytimeAgo];
            var currentpeople = people[randomlytimeAgo1];
            var currentcountry = country[randomlytimeAgo2];
            var currentphone = phone[randomlytimeAgo3];
            var currentcollections = collections[randomlytimeAgo4];
            $(".item_order").html(currentcollections);
            $(".timeAgo").text(currentmytimeAgo+" trước");
            $(".people").text(currentpeople);
            // $(".country").text(currentcountry); 
            $(".phone-order").text(currentphone); 
             
        },  20000);
        setInterval(function() {
            $('#someone-purchased').fadeIn(function() {    $(this).removeClass("fade-out"); }).delay(5000).fadeIn( function() {  $(this).addClass("fade-out"); }).delay(5000); 
        }, 10000);
    });
</script>