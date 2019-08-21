<div class="tab-pane" id="tab-aff">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-2 control-label tp-text-left">Giá thu về</label>
            <div class="col-sm-4">
                <?php echo form_dropdown('type_aff', $this->configbie->data('type_aff'), set_value('type_aff', $DetailProducts['type_aff']), 'class="form-control chose_aff select2" style="width: 100%;" data-show="list-aff" data-remove-name="noremove"');?>
            </div>
        </div>
        <div id="list-aff">
            <?php if (!empty($DetailProducts['type_aff'])): ?>
                <?php
                $LevelCustomers = $this->FrontendProducts_Model->_get_where(array(
                    'select' => 'id, title',
                    'table' => 'customers_level',
                    'where' => array('trash' => 0, 'publish' => 1),
                ), TRUE);
                if (isset($LevelCustomers) && is_array($LevelCustomers) && count($LevelCustomers)){
                    echo '<div class="form-group">';
                    foreach ($LevelCustomers as $key => $val){
                        $count = $this->FrontendProducts_Model->_get_where(array(
                            'select' => 'count',
                            'table' => 'products_discount_affiliate',
                            'where' => array('productsid' => $DetailProducts['id'], 'level' => $val['id']),
                        ), FALSE);
                        echo '<div class="col-sm-4">';
                        echo '<div class="form-group">';
                        echo '<label class="col-sm-12 control-label tp-text-left" style="margin-bottom: 10px">Cấp độ: '.$val['title'].'</label>';
                        echo '<div class="col-sm-12">';
                        echo '<input type="hidden" name="discount[level][]" class="level" value="'.$val['id'].'">';
                        echo '<input type="text" name="discount[count][]" value="'.((!empty($count['count'])) ? $count['count'] : '').'" placeholder="'.(($DetailProducts['type_aff'] == 1) ? 'Phần trăm' : 'Số tiền').' thu về theo giá sản phẩm" class="form-control count">';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                ?>
            <?php endif ?>
        </div>
    </div>
</div>