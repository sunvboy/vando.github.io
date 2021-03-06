<div class="tab-pane" id="tab-combo">
    <div class="box-body">
        <div class="callout callout-danger">Thêm danh sách sản phẩm mua cùng</div>
        <div class="form-group">
            <label class="col-sm-2 control-label tp-text-left">Sản phẩm</label>
            <div class="col-sm-10">
                <input type="text" id="key" class="form-control" placeholder="Tiêu đề sản phẩm">
                <input type="hidden" name="id_combo" id="id_arr" value="<?php echo $DetailCombos['id_combo'] ?>">
                <div id="result_product">
                    <div class="panl-body">

                    </div>
                </div>
            </div>
        </div>
        <div id="list-combo-product">
            <table class="table" id="diagnosis-list">
                <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Tình trạng</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = $this->Autoload_Model->_get_where(array(
                    'select' => 'id, title, slug, canonical, images, description, price, saleoff, status',
                    'table' => 'products',
                    'where' => array('publish' =>1, 'trash' => 0),
                    'where_in' => explode('-', $DetailCombos['id_combo']),
                    'where_in_field' => 'id',
                    'order_by' => 'id desc, order asc'
                ),TRUE);
                if(isset($result) && is_array($result) && count($result)) {
                    foreach ($result as $key => $val) {
                        $image = getthumb($val['images']);
                        $description = cutnchar(strip_tags($val['description']), 250);
                        $price = $val['price'];
                        $saleoff = $val['saleoff'];
                        if ($price > 0) {
                            $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).' đ<span>';
                        }else{
                            $pri_old  = '';
                        }
                        if ($saleoff > 0) {
                            $pri_sale = str_replace(',', '.', number_format($saleoff)).' đ';
                        }else{
                            $pri_sale  = 'Liên hệ';
                        }
                        echo '<tr>';
                        echo '<td style="width:650px;">';
                        echo '<article class="article-view-1 text-left">';
                        echo '<div class="col-sm-2 thumb">';
                        echo '<div class="tp-cover"><img  src="'.$image.'" alt="'.$val['title'].'" /></div>';
                        echo '</div>';
                        echo '<div class="col-sm-10">';
                        echo '<div class="title">'.$val['title'].'</div>';
                        echo '<div class="description">'.$description.'</div>';
                        echo '<div class="meta">';
                        echo $pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '');
                        echo '</div>';
                        echo '</div>';
                        echo '</article>';
                        echo '</td>';
                        echo '<td style="text-align:center"><span class="btn '.((!empty($val['status']==1)) ? 'btn-success' : 'btn-danger').'">'.$this->configbie->data('status', $val['status']).'</span></td>';
                        echo '<td class="text-right">';
                        echo '<div class="btn btn-default data-active" data-id="'.$val['id'].'">';
                        echo '<span class="fa fa-trash"></span>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <style>
        #result_product{position: relative}
        #result_product .panl-body {
            max-height: 200px;
            overflow: hidden;
            position: absolute;
            background-color: #fff;
            box-shadow: 1px 1px 3px #dedede;
            right: 0;
            width: 100%;
            max-width: 100%;
            overflow-y: auto;z-index: 9;
        }
        #result_product .panl-body .text-right{display: none;}
        #result_product .article-view-1 .meta,
        #list-combo-product .article-view-1 .meta,
        #list-verstion-product .article-view-1 .meta{
            color: #f00;
            font-weight: bold;
            font-size: 13px;
        }
        #result_product .article-view-1 .meta .span-gia,
        #list-combo-product .article-view-1 .meta .span-gia,
        #list-verstion-product .article-view-1 .meta .span-gia {
            margin-left: 10px;
            font-weight: normal;
            text-decoration: line-through;
            color: #999;
            font-size: 11px;
        }
        .add-item{cursor: pointer}
    </style>
    <script>
        $(document).ready(function(){
            if($('#list-combo-product tbody').html().trim() == ''){
                $('#list-combo-product').hide();
            }else{
                $('#list-combo-product').show();
            }
            var time;
            $('#result_product').hide();
            $('#key').on('keyup', function() {
                var keyword = $(this).val();
                var id_arr = $('#id_arr').val();
                var prdid = '<?php echo $DetailCombos['parentid'] ?>';
                var numberKey = keyword.length;
                if(numberKey >= 0) {
                    clearTimeout(time);
                    time = setTimeout(function() {
                        $.ajax({
                            url: 'products/ajax/products/search',
                            method: 'POST',
                            dataType: 'JSON',
                            data: {keyword: keyword, id: id_arr, prdid: prdid},
                            complete: function(data) {
                                var datajson = JSON.parse(data.responseText);
                                $('#result_product').show();
                                $('#result_product .panl-body').html(datajson.html);
                            }
                        });
                    }, 200);
                }else {
                    $('#result_product').hide();
                }
            });
            $(document).on('click', '.add-item', function(){
                var item_ = '<tr>' + $(this).html() + '</tr>';
                var id = $(this).attr('data-id');
                $('#list-combo-product table tbody').append(item_);
                $('#list-combo-product').show();
                $(this).remove();
                if($('#result_product .panl-body tbody').html().trim() == ''){
                    $('#result_product').hide();
                }
                load_item_combo();
                $('#result_product').hide();

            });
            $(document).on('click', '.data-active', function(){
                $(this).parent().parent().remove();
                load_item_combo();
            });
            function load_item_combo(){
                var outputText = '';
                $('#list-combo-product .data-active').each(function(){
                    var divHtml = $(this).attr('data-id');
                    outputText += divHtml + '-';
                });
                $('#id_arr').attr('value', outputText.slice(0, -1));
            }
        })
    </script>
</div>
