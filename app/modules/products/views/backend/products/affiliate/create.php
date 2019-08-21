<div class="tab-pane hide" id="tab-aff">
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-2 control-label tp-text-left">Hình thức triết khấu</label>
            <div class="col-sm-4">
                <?php echo form_dropdown('type_aff', $this->configbie->data('type_aff'), set_value('type_aff', 0), 'class="form-control chose_aff select2" style="width: 100%;"');?>
            </div>
        </div>
        <div id="list-aff">

        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.chose_aff').change(function(){
                var type = $(this).val();
                $.post('<?php echo site_url("products/ajax/products/aff_type");?>', {type: type}, function(data){
                    var json = JSON.parse(data);
                    $('#list-aff').html(json.html);
                });
                return false;
            })
        })
    </script>
</div>