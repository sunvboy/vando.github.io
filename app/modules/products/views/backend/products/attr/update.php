<div class="tab-pane" id="tab-attr">
    <div class="box-body">
        <div class="callout callout-danger">Thêm danh sách thuộc tính khác cho sản phẩm. Lưu ý: Mỗi lần thêm mới 1 giá trị dữ liệu cũ của bạn sẽ bị xóa, hãy cân nhắc kỹ trước khi thực hiện thay đổi</div>
        <div class="clearfix">
            <a class="btn btn-success add_version_type" data-flag="1">Thêm thuộc tính sản phẩm</a>
            <input type="hidden" name="check_att_advanced" value="0" id="check_att_advanced">
        </div>


        <div id="list-verstion-product-attr">
            <table class="table-reponsive table table_attr" style="margin: 20px 0 0">
                <thead>
                <tr>
                    <th width="150px">Tên thuộc tính</th>
                    <th>Giá trị</th>
                    <th width="50px"></th>
                </tr>
                </thead>
                <tbody>
                <?php

                $option = $this->input->post('option');

                ?>
                <?php $j = 0 ?>
                <?php if(isset($option) && is_array($option) && count($option)){ ?>
                    <?php foreach($option['title'] as $key => $val){ ?>
                    <?php if(empty($option['title'][$key])) continue; ?>
                    <tr>
                        <td>
                            <input class="form-control" type="text" name="option[title][]" value="<?php echo $option['title'][$key] ?>">
                        </td>
                        <td><input type="text" name="option[attribute][]" value="<?php echo $option['attribute'][$key] ?>" class="form-control tags"></td>
                        <td><a class="btn btn-default btn-trash-attr"><i class="fa fa-trash"></i></a></td>
                    </tr>
                <?php $j++; ?>
                <?php } ?>
                    <tr class="<?php echo (($j != 3) ? '' : 'hide') ?>">
                        <td colspan="3"><a class="btn btn-default btn-add-attr">Thêm thuộc tính khác</a></td>
                    </tr>
                    <script>
                        $(document).ready(function(){
                            $('.tags').tagsinput({
                                confirmKeys: [13, 44],
                                maxTags: 20
                            });
                        });
                    </script>
                <?php }else{ ?>
                <?php $option_query = $this->BackendProducts_Model->_get_where(array(
                    'select' => 'id, title, attribute',
                    'table' => 'products_att_advanced',
                    'where' => array('productsid' => $DetailProducts['id'], 'trash' => 0),
                    'order_by' => 'id asc'
                ), TRUE) ?>
                <?php $jj = 0; ?>
                <?php if (isset($option_query) && is_array($option_query) && count($option_query)): ?>
                <?php foreach ($option_query as $key => $vals): ?>
                    <tr>
                        <td>
                            <input class="form-control" type="text" name="option[title][]" value="<?php echo $vals['title'] ?>">
                            <input type="hidden" name="option[id][]" value="<?php echo $vals['id'] ?>">
                        </td>
                        <td><input type="text" name="option[attribute][]" value="<?php echo $vals['attribute'] ?>" class="form-control tags"></td>
                        <td><a class="btn btn-default btn-trash-attr"><i class="fa fa-trash"></i></a></td>
                    </tr>
                <?php $jj++ ?>
                <?php endforeach ?>

                    <tr class="<?php echo (($jj != 3) ? '' : 'hide') ?>">
                        <td colspan="3"><a class="btn btn-default btn-add-attr">Thêm thuộc tính khác</a></td>
                    </tr>
                    <script>
                        $(document).ready(function(){
                            $('.tags').tagsinput({
                                confirmKeys: [13, 44],
                                maxTags: 20
                            });
                        });
                    </script>
                <?php endif ?>
                <?php } ?>
                </tbody>
            </table>
            <div class="result_attr_form">
                <?php
                $option_relation_query = $this->BackendProducts_Model->_get_where(array(
                    'select' => 'id, title, sku, price, saleoff, quantity, count_order',
                    'table' => 'products',
                    'where' => array('parentid' => $DetailProducts['id'], 'publish' => 1, 'trash' => 0),
                ), TRUE);
                if (isset($option_relation_query) && is_array($option_relation_query) && count($option_relation_query)) {
                    $k = 1;
                    echo '<div class="box_result_">';
                    echo '<h3>Chỉnh sửa các phiên bản dưới đây để tạo:</h3>';
                    echo '<div class="box_result_content">';
                    echo '<table class="table-reponsive table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th class="select"></th>';
                    echo '<th><span class="options-header">Phiên bản</span></th>';
                    echo '<th style="min-width:100px"><span>SKU</span></th>';
                    echo '<th style="width:150px"><span>Giá bán</span></th>';
                    echo '<th style="width:150px"><span>Giá khuyến mại</span></th>';
                    echo '<th style="min-width:100px"><span>Số lượng</span></th>';
                    echo '<th style="min-width:100px"><span>Đã bán</span></th>';
                    echo '<th style="min-width:100px"><span></span></th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ($option_relation_query as $key => $val) {
                        $arr = explode(',', $val['title']);
                        $title = '';
                        for ($i=0; $i < count($arr) ; $i++) {
                            $title .= '<span>'.$arr[$i].'</span>';
                        }
                        echo '<tr>';
                        echo '<td class="select">'.$k.'<input class="form-control" type="hidden" name="version[title][]" value="'.$val['title'].'"><input class="form-control" type="hidden" name="version[id][]" value="'.$val['id'].'"></td>';
                        echo '<td>'.$title.'</td>';
                        echo '<td style="min-width:100px"><input class="form-control" type="text" name="version[sku][]" value="'.$val['sku'].'"></td>';
                        echo '<td style="min-width:100px"><input class="form-control" type="text" name="version[price][]" value="'.$val['price'].'"></td>';
                        echo '<td style="min-width:100px"><input class="form-control" type="text" name="version[saleoff][]" value="'.$val['saleoff'].'"></td>';
                        echo '<td style="min-width:100px"><input class="form-control" type="text" name="version[quantity][]" value="'.$val['quantity'].'"></td>';
                        echo '<td style="min-width:100px"><input class="form-control" type="text" name="version[count_order][]" value="'.$val['count_order'].'"></td>';
                        echo '<td style="min-width:100px">';
                        echo '<div class="btn-group" style="min-width: auto;">';
                        echo '<div class="btn btn-default delete-version" data-id="'.$val['id'].'"><span class="fa fa-trash"></span></div>';
                        echo '<div class="btn btn-default edit-version" data-id="'.$val['id'].'"><span class="fa fa-edit"></span></div>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                        $k++;
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <script>
                $(document).ready(function(){
                    if ($('#list-verstion-product-attr .result_attr_form').html().trim() == '') {
                        load_attr_arr();
                    }
                    load_attr_arr_count();
                    // Attribute
                    $('.add_version_type').click(function(){
                        var flag = $(this).attr('data-flag');
                        if (flag == 1) {
                            if ($('#list-verstion-product-attr .table_attr tbody').html().trim() == '') {load_attr_html();}
                            $('#list-verstion-product-attr').removeClass('hide');
                            $(this).removeClass('btn-success').addClass('btn-warning').attr('data-flag', 0).html('Hủy thuộc tính sản phẩm');
                            $('#check_att_advanced').attr('value', 1);
                        }else{
                            $('#list-verstion-product-attr').addClass('hide');
                            $(this).removeClass('btn-warning').addClass('btn-success').attr('data-flag', 1).html('Thêm thuộc tính sản phẩm');
                            $('#check_att_advanced').attr('value', 0);
                        }
                    });
                    $(document).on('click', '.btn-trash-attr', function(){
                        $(this).parent().parent().parent().find('.hide').removeClass('hide');
                        $(this).parent().parent().remove();
                        load_attr_arr();
                    });

                    $(document).on('click', '.btn-add-attr', function(){
                        load_attr_html();
                        $(this).parent().parent().remove();
                        return false;
                    });
                    function load_value_attr(){
                        var attr = '';
                        $('#list-verstion-product-attr .attrid').each(function(){
                            var divHtml = $(this).val();
                            attr += divHtml + '-';
                        })
                        return attr.slice(0, -1);
                    }
                    function load_attr_html(){
                        var formURL = 'products/ajax/products/add_attribute';
                        var attrid = load_value_attr();
                        $.post(formURL, {attrid: attrid}, function(data){
                            $('#list-verstion-product-attr .table_attr tbody').append(data);
                        });
                        return false;
                    }

                    $(document).on('change', '.tags', function(){
                        load_attr_arr();
                    });
                    function load_attr_arr_count(){
                        if($('#list-verstion-product-attr .table_attr tbody').html().trim() == ''){
                            $('#list-verstion-product-attr').addClass('hide');
                        }else{
                            $('.add_version_type').attr('data-flag', 0);
                            $('.add_version_type').removeClass('btn-success').addClass('btn-warning').attr('data-flag', 0).html('Hủy thuộc tính sản phẩm');
                            $('#check_att_advanced').attr('value', 1);
                        }
                    }
                    function load_attr_arr(){

                        if($('#list-verstion-product-attr .table_attr tbody').html().trim() == ''){
                            $('#list-verstion-product-attr').addClass('hide');
                        }else{
                            $('.add_version_type').attr('data-flag', 0);
                            $('.add_version_type').removeClass('btn-success').addClass('btn-warning').attr('data-flag', 0).html('Hủy thuộc tính sản phẩm');
                            $('#check_att_advanced').attr('value', 1);
                        }
                        var attr_arr = '';
                        var formURL = 'products/ajax/products/load_attribute';
                        $('#list-verstion-product-attr .tags').each(function(){
                            var divHtml = $(this).val();
                            attr_arr += divHtml + '-';
                        })
                        $.post(formURL, {attr_arr: attr_arr.slice(0, -1)}, function(data){
                            $('.result_attr_form').html(data);
                        });
                        return false;
                    }
                })
            </script>
        </div>


    </div>
</div>