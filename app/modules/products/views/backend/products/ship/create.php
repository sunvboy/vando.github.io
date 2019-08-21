<div class="tab-pane hide" id="tab-ship">
    <div class="box-body">
        <?php $shipcode = $this->input->post('shipcode'); ?>
        <?php if(isset($shipcode) && is_array($shipcode) && count($shipcode)){ ?>
            <?php foreach($shipcode['shop'] as $key => $val){ ?>
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
                            <input type="text" name="shipcode[inner][]" value="<?php echo $shipcode['inner'][$key];?>" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-12 control-label tp-text-left">COD các tỉnh</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="shipcode[outner][]" value="<?php echo $shipcode['outner'][$key];?>" class="form-control"/>
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
                        <input type="text" name="shipcode[shop][]" value="0" readonly="" class="form-control" placeholder="Phí vận chuyển"/>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-sm-12 control-label tp-text-left">Nội thành HN</label>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="shipcode[inner][]" value="" class="form-control" placeholder="Phí vận chuyển"/>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-sm-12 control-label tp-text-left">COD các tỉnh</label>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="shipcode[outner][]" value="" class="form-control" placeholder="Phí vận chuyển"/>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>