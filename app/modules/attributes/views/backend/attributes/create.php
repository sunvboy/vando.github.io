<section class="content-header">
	<h1>Thêm thuộc tính mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('attributes/backend/attributes/view');?>">thuộc tính</a></li>
		<li class="active"><a href="<?php echo site_url('attributes/backend/attributes/create');?>">Thêm thuộc tính mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
					<li><a href="#tab-advanced" data-toggle="tab">Nâng cao</a></li>
				</ul>
				<form class="form-horizontal" method="post" action="">

					<div class="tab-content">
						<div class="box-body">
							<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
						</div><!-- /.box-body -->
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Thuộc tính</label>
									<div class="col-sm-3">
										<?php echo form_input('title', set_value('title'), 'class="form-control" placeholder="thuộc tính"');?>
									</div>
									<label class="col-sm-1 control-label">Canonical</label>
									<div class="col-sm-3">
										<?php echo form_input('canonical', set_value('canonical'), 'class="form-control" placeholder="Canonical"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Danh mục cha</label>
									<div class="col-sm-3">
										<?php echo form_dropdown('cataloguesid', $attributes_catalogues, set_value('cataloguesid'), 'class="form-control" style="width: 100%;" id="cataloguesid"');?>
									</div>
									<label class="col-sm-1 control-label">Xuất bản</label>
									<div class="col-sm-3">
										<?php echo form_input('created', set_value('created', gmdate('H:i - d/m/Y', time() + 7*3600)), 'class="form-control datetimepicker" placeholder="Thời gian xuất bản" readonly="true"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Ảnh minh họa</label>
									<div class="col-sm-5">
										<?php echo form_input('images', set_value('images'), 'class="form-control" style="width: 100%;" placeholder="Ảnh minh họa" onclick="openKCFinder(this)"');?>
									</div>
								</div>
								<script type="text/javascript">
									$(document).ready(function(){
										$('.p-type').hide();
										$('#cataloguesid').change(function(){
											var catid = $(this).val();
											if(catid == 21){
												$('.p-type').show();
											}else{
												$('.p-type').hide();
											}
										});
									});
								</script>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mô tả</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description')), 'id="txtDescription" class="ckeditor-description" placeholder="Mô tả" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
									</div>
									<label class="col-sm-2 control-label">Vị trí</label>
									<div class="col-sm-2">
										<?php echo form_input('order', set_value('order'), 'class="form-control" placeholder="Vị trí"');?>
									</div>
									<label class="col-sm-2 control-label">Nổi bật</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('highlight', $this->configbie->data('highlight'), set_value('highlight'), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="create" value="action" class="btn btn-info pull-right">Thêm mới</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
$(window).load(function(){
	var item;
	item = '<div class="col-sm-3 slideItem">';
	item = item + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
	item = item + '<input type="hidden" name="slide[images][]" value="" />';
	item = item + '<input type="text" name="slide[title][]" value="" class="form-control title" placeholder="Tên ảnh"/>';
	item = item + '<textarea name="slide[description][]" cols="40" rows="10" class="form-control description" placeholder="Mô tả ảnh"></textarea>';
	item = item + '<button type="button" class="btn btnRemove btn-danger pull-right">Xóa bỏ</button>';
	item = item + '</div>';
	item = item + '<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem pull-left">+</button></div>';
	if($('#fromSlide').html().trim() == ''){
		$('#fromSlide').append(item);
	}
	/* Thêm phần tử đầu tiên */
	$(document).on('click', '.btnAddFrist', function(){
		$('#fromSlide').html(item);
	});

	/* Thêm phần tử tiếp theo */
	$(document).on('click', '.btnAddItem', function(){
		$('.btnAddItem').parent().remove();
		$('#fromSlide').append(item);
	});

	/* Xóa phần tử */
	$(document).on('click', '.btnRemove', function(){
		$(this).parent().remove();
	});

	/* Xóa phần tử */
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
});
</script>