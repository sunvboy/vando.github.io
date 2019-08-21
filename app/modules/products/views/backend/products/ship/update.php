<div class="tab-pane" id="tab-ship">
    <div class="box-body">
        <?php $shipcode = $this->input->post('shipcode'); $ship = '';?>
        <?php if(isset($shipcode) && is_array($shipcode) && count($shipcode)){ ?>
            <?php
            foreach($shipcode['shop'] as $keyship => $val){
                $ship[$keyship]['shop'] = $val;
                $ship[$keyship]['inner'] = $shipcode['inner'][$keyship];
                $ship[$keyship]['outner'] = $shipcode['outner'][$keyship];
            }
            ?>
        <?php }else{ ?>
            <?php $ship = json_decode($DetailProducts['shipcode'], TRUE); ?>
        <?php } ?>
        <?php if(isset($ship) && is_array($ship) && count($ship)){ ?>
            <?php foreach($ship as $keykey => $val){ ?>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-12 control-label tp-text-left">Tại cửa hàng</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="shipcode[shop][]" value="0" readonly="" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-12 control-label tp-text-left">Nội thành HN</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="shipcode[inner][]" value="<?php echo $ship[$keykey]['inner'];?>" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-12 control-label tp-text-left">COD các tỉnh</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="shipcode[outner][]" value="<?php echo $ship[$keykey]['outner'];?>" class="form-control"/>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-sm-12 control-label tp-text-left">Tại cửa hàng</label>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="shipcode[shop][]" value="0" readonly="" class="form-control" placeholder="Phí vận chuyển" />
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-sm-12 control-label tp-text-left">Nội thành HN</label>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="shipcode[inner][]" value="" class="form-control" placeholder="Phí vận chuyển" />
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-sm-12 control-label tp-text-left">COD các tỉnh</label>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="shipcode[outner][]" value="" class="form-control" placeholder="Phí vận chuyển" />
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>