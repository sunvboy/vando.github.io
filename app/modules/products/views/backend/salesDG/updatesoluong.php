<section class="content-header">
    <h1>Sale theo số lượng</h1>
</section>
<section class="content">
    <div class="row">
        <form class="hidden-form" style="display:none;" id="cat-form" method="post" action="">
            <input type="text" value="" id="str"/>
        </form>
        <form class="form-horizontal" method="post" action="">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
                    </ul>
                    <div class="tab-content">
                        <?php $error = validation_errors(); echo !empty($error)?'<div class="box-body"><div class="callout callout-danger">'.$error.'</div></div><!-- /.box-body -->':'';?>
                        <div class="tab-pane active" id="tab-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label tp-text-left">Tiêu đề</label>
                                    <div class="col-sm-12">
                                        <?php echo form_input('title',  set_value('title', $DetailProducts['title']), 'class="form-control" style="width: 100%;"');?>
                                    </div>
                                </div>
                                <?php if($DetailProducts['id']==1){?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label tp-text-left">Số lượng</label>
                                    <div class="col-sm-12">
                                        <?php echo form_input('qty', html_entity_decode(set_value('qty', $DetailProducts['qty'])), 'class="form-control" placeholder="Số lượng"');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label tp-text-left">Phần trăm giảm giá(Đơn vị: %)</label>
                                    <div class="col-sm-12">
                                        <?php echo form_input('saleoff', html_entity_decode(set_value('saleoff', $DetailProducts['saleoff'])), 'class="form-control" placeholder="Phần trăm giảm giá(%)"');?>
                                    </div>
                                </div>
                                <?php }else if($DetailProducts['id']==2){?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label tp-text-left">Phần trăm giảm giá(Đơn vị: %)</label>
                                        <div class="col-sm-12">
                                            <?php echo form_input('saleoff', html_entity_decode(set_value('saleoff', $DetailProducts['saleoff'])), 'class="form-control" placeholder="Phần trăm giảm giá(%)"');?>
                                        </div>
                                    </div>

                                <?php }?>



                                <div class="form-group" id="scheduleStartDate">
                                    <div class="col-sm-2 control-label tp-text-left">Thời gian</div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb10">Ngày bắt đầu</div>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </div>
                                                    <input type="text" name="time_start" class="form-control datetimemonthsale change_time" value="<?php echo $DetailProducts['time_start'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb15">
                                                <div class="mb10">Ngày kết thúc</div>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                    </div>
                                                    <?php  $time = date('Y/m/d H:i:s');?>
                                                    <input type="text" name="time_end" class="form-control datetimemonthsale change_time" value="<?php echo $DetailProducts['time_end'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div><!-- /.box-body -->
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Làm lại</button>
                        <button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
                    </div><!-- /.box-footer -->
                </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->

        </form>
    </div> <!-- /.row -->
</section><!-- /.content -->
<script>
    $(document).on('click', '.img-thumbnail', function(){
        openKCFinderAlbum($(this));
    });

</script>
