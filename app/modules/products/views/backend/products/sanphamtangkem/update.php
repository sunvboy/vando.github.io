<div class="tab-pane" id="tab-sanphamtangkem">
    <div class="box-body">
        <div class="callout callout-danger">Thêm danh sách sản phẩm được tặng kèm</div>
        <div class="form-group">
            <label class="col-sm-2 control-label tp-text-left">Sản phẩm</label>
            <div class="col-sm-10">
                <input type="text" id="key_sanphamtangkem" class="form-control" placeholder="Tiêu đề sản phẩm">
                <input type="hidden" name="id_sanphamtangkem" id="id_sanphamtangkem" value="<?php echo $DetailProducts['id_sanphamtangkem'] ?>">
                <div id="result_product_sanphamtangkem">
                    <div class="panl-body">

                    </div>
                </div>
            </div>
        </div>
        <div id="list-sptk-product">
            <table class="table" id="diagnosis-listSanphamtankem">
                <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = $this->Autoload_Model->_get_where(array(
                    'select' => 'id, title, images',
                    'table' => 'products_sanphamtangkem',
                    'where' => array('publish' =>1, 'trash' => 0),
                    'where_in' => explode('-', $DetailProducts['id_sanphamtangkem']),
                    'where_in_field' => 'id',
                    'order_by' => 'id desc'
                ),TRUE);
                if(isset($result) && is_array($result) && count($result)) {
                    foreach ($result as $key => $val) {
                        $image = getthumb($val['images']);

                        echo '<tr class="add-item-sanphamtangkem" data-id="'.$val['id'].'">';
                        echo '<td style="width:650px;">';
                        echo '<article class="article-view-1 text-left">';
                        echo '<div class="col-sm-2 thumb">';
                        echo '<div class="tp-cover"><img  src="'.$image.'" alt="'.$val['title'].'" /></div>';
                        echo '</div>';
                        echo '<div class="col-sm-10">';
                        echo '<div class="title">'.$val['title'].'</div>';

                        echo '</div>';
                        echo '</article>';
                        echo '</td>';
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

    <script>
        $(document).ready(function(){
            if($('#list-sptk-product tbody').html().trim() == ''){
                $('#list-sptk-product').hide();
            }else{
                $('#list-sptk-product').show();
            }
            var time;
            $('#result_product_sanphamtangkem').hide();
            $('#key_sanphamtangkem').on('keyup', function() {
                var keyword = $(this).val();
                var id_arr = $('#id_sanphamtangkem').val();
                var numberKey = keyword.length;
                if(numberKey >= 0) {
                    clearTimeout(time);
                    time = setTimeout(function() {
                        $.ajax({
                            url: 'products/ajax/products/searchsanphamtangkem',
                            method: 'POST',
                            dataType: 'JSON',
                            data: {keyword: keyword, id: id_arr},
                            complete: function(data) {
                                var datajson = JSON.parse(data.responseText);
                                $('#result_product_sanphamtangkem').show();
                                $('#result_product_sanphamtangkem .panl-body').html(datajson.html);
                            }
                        });
                    }, 200);
                }else {
                    $('#result_product_sanphamtangkem').hide();
                }
            });
            $(document).on('click', '.add-item-sanphamtangkem', function(){
                var item_ = '<tr>' + $(this).html() + '</tr>';
                var id = $(this).attr('data-id');
                $('#list-sptk-product table tbody').append(item_);
                $('#list-sptk-product').show();
                $(this).remove();
                if($('#result_product_sanphamtangkem .panl-body tbody').html().trim() == ''){
                    $('#result_product_sanphamtangkem').hide();
                }
                load_item_sanphamtangkem();
                $('#result_product_sanphamtangkem').hide();

            });
            $(document).on('click', '.data-active-sanphamtangkem', function(){
                $(this).parent().parent().remove();
                load_item_sanphamtangkem();
            });
            function load_item_sanphamtangkem(){
                var outputText = '';
                $('#list-sptk-product .data-active-sanphamtangkem').each(function(){
                    var divHtml = $(this).attr('data-id');
                    outputText += divHtml + '-';
                });
                $('#id_sanphamtangkem').attr('value', outputText.slice(0, -1));
            }
        })
    </script>
    <style>
        #result_product_sanphamtangkem{position: relative}
        #result_product_sanphamtangkem .panl-body {
            max-height: 200px;
            overflow: hidden;
            position: absolute;
            background-color: #fff;
            box-shadow: 1px 1px 3px #dedede;
            right: 0;
            width: 100%;
            max-width: 810px;
            overflow-y: auto;z-index: 9;
        }
        #result_product_sanphamtangkem .panl-body .text-right{display: none;}
        #result_product_sanphamtangkem .article-view-1 .meta,
        #list-combo-product .article-view-1 .meta,
        #list-verstion-product .article-view-1 .meta{
            color: #f00;
            font-weight: bold;
            font-size: 13px;
        }
        #result_product_sanphamtangkem .article-view-1 .meta .span-gia,
        #list-sptk-product .article-view-1 .meta .span-gia,

        .add-item-sanphamtangkem{cursor: pointer}
    </style>
</div>