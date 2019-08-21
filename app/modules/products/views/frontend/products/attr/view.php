<?php
$color = $this->Autoload_Model->_get_where(array(
    'select' => 'id, title, images',
    'table' => 'products_color',
    'where' => array('productsid' => $DetailProducts['id']),
    'order_by' => 'id asc'
), TRUE);//
$size = $this->Autoload_Model->_get_where(array(
    'select' => 'id, title, saleoff,productsid',
    'table' => 'products_size',
    'where' => array('productsid' => $DetailProducts['id']),
    'order_by' => 'id asc'
), TRUE);//
?>
<?php if (isset($color) && is_array($color) && count($color)){ ?>
    <div class="list_attr_advanced list_attr_advanced_color">
        <div class="item_attr_advanced item_attr_advanced_color mt-flex mt-flex-middle mb5">
            <div class="title_attr">Màu sắc</div>
            <div class="content_attr">
                <ul class="mt-list mt-clearfix">
                    <?php foreach ($color as $key=>$val): ?>
                        <li>
                            <a style="padding: 2px;border-radius: 100%;width: 35px;height: 35px" data-title="<?php echo $val['title']?>" data-id="<?php echo $val['id']?>" class="chose_attr_advanced chose_attr_advanced_color" ><img src="<?php echo $val['images']?>" style="border-radius: 100%" alt="<?php echo $val['title']?>"></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
<?php //}else{ ?>
<!--    <div class="list_attr_advanced list_attr_advanced_color">-->
<!--        <div class="item_attr_advanced item_attr_advanced_color mt-flex mt-flex-middle mb5">-->
<!--            <div class="title_attr">Màu sắc</div>-->
<!--            <div class="content_attr">-->
<!--                <ul class="mt-list mt-clearfix">-->
<!--                    <li>-->
<!--                        <a style="padding: 2px;border-radius: 100%;width: 35px;height: 35px" data-title="" data-id="" class="chose_attr_advanced chose_attr_advanced_color active" >đâs</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php }?>
<?php if (isset($size) && is_array($size) && count($size)){ ?>
    <div class="list_attr_advanced list_attr_advanced_size">
        <div class="item_attr_advanced item_attr_advanced_size mt-flex mt-flex-middle mb5">
            <div class="title_attr">Kích thước</div>
            <div class="content_attr">
                <ul class="mt-list mt-clearfix">
                    <?php foreach ($size as $key=>$val): ?>
                        <li>
                            <a data-title="<?php echo $val['title']?>" data-saleoff="<?php echo !empty($val['saleoff']>0)?$val['saleoff']:$prdsaleoff?>" data-id="<?php echo $val['id']?>"  class="chose_attr_advanced chose_attr_advanced_size" ><?php echo $val['title'] ?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>

<?php //}else{  ?>
<!--<div class="list_attr_advanced list_attr_advanced_size">-->
<!--    <div class="item_attr_advanced item_attr_advanced_size mt-flex mt-flex-middle mb5">-->
<!--        <div class="title_attr">Kích thước</div>-->
<!--        <div class="content_attr">-->
<!--            <ul class="mt-list mt-clearfix">-->
<!--                    <li>-->
<!--                        <a data-title="" data-saleoff="" data-id=""  class="chose_attr_advanced chose_attr_advanced_size active" >size</a>-->
<!--                    </li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php }?>
<script>
    $(document).ready(function(){

        //click active color
        $(document).on('click', '.chose_attr_advanced_size:not(.disable)', function () {
            $('.list_attr_advanced').removeClass('mt-alert-danger').find('.text-left').remove();
            $('.chose_attr_advanced').removeClass('disable');
            var flag = $(this).attr('data-flag');
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }else{
                $(this).parent().parent().find('.chose_attr_advanced').removeClass('active');
                $(this).addClass('active');
            }
            load_size_price();
        });
        function load_size_price(){
            $('.chose_attr_advanced_size.active').each(function(){
                var title = $(this).data('title');
                var saleoff = $(this).data('saleoff');
                $.post('<?php echo site_url("products/ajax/products/load_price_size_products");?>', {saleoff: saleoff,productsid: <?php echo  $DetailProducts['id']?>}, function (data) {
                    var json = JSON.parse(data);
                    if (json.error == false) {
                        $('.text-gia-tam').html(json.result);
                        $('.ajax-addtocart.single_product').attr('data-price', json.price);
                        $('#dt-total-money-buynow').attr('data-price', json.price);
                    }
                });
                $('.ajax-addtocart.single_product').attr('data-size', title);
            });

        }
        //end
        //click size
        $(document).on('click', '.chose_attr_advanced_color:not(.disable)', function () {
            $('.list_attr_advanced').removeClass('mt-alert-danger').find('.text-left').remove();

            $('.chose_attr_advanced').removeClass('disable');
            var flag = $(this).attr('data-flag');
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }else{
                $(this).parent().parent().find('.chose_attr_advanced').removeClass('active');
                $(this).addClass('active');
            }
            load_album_color();
        });
        function load_album_color(){
            $('.chose_attr_advanced_color.active').each(function(){
                var id = $(this).data('id');
                var title = $(this).data('title');
                $.post('<?php echo site_url("products/ajax/products/load_album_color");?>', {id: id}, function (data) {
                    var json = JSON.parse(data);
                    if (json.error == true) {
                        $('#load_albums_color').html(json.html);
                    }
                });
                $('.ajax-addtocart.single_product').attr('data-color', title);

            });

        }
        //end

    })
</script>