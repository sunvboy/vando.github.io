<section class="content-header">
	<h1>Thêm danh mục bài viết mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('lichhoc/backend/catalogues/view');?>">Danh mục bài viết</a></li>
		<li class="active"><a href="<?php echo site_url('lichhoc/backend/catalogues/create');?>">Thêm danh mục bài viết mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form class="form-horizontal" method="post" action="">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
					</ul>
					
						<div class="tab-content">
							<div class="box-body">
								<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
							</div><!-- /.box-body -->
							<div class="tab-pane active" id="tab-info">
								<div class="box-body">
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Năm</label>
										<div class="col-sm-3">
											<select name="year" id="year" class="form-control" >
												<option value="0">|--- Chọn năm</option>
												<?php  
													for ($i = 2017; $i <= 2030 ; $i++) { 
														?><option value="<?php echo $i ?>">|--- Năm <?php echo $i ?></option><?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Tiêu đề (Tuần thứ)</label>
										<div class="col-sm-8">
											<?php echo form_input('title', set_value('title'), 'class="form-control form-static" placeholder="Tuần trong năm" readonly=""');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Từ Ngày</label>
										<div class="col-sm-10">
											<?php echo form_input('day', set_value('day'), 'class="form-control pick datetimepicker" placeholder="ngày/tháng/năm - 29/05/2017"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Đến Ngày</label>
										<div class="col-sm-10">
											<?php echo form_input('dayfrom', set_value('dayfrom'), 'class="form-control pick datetimepicker" placeholder="ngày/tháng/năm - 29/05/2017"');?>
										</div>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
						<div class="box-footer">
							<button type="reset" class="btn btn-default">Làm lại</button>
							<button type="submit" name="create" value="action" class="btn btn-info pull-right">Thêm mới</button>
						</div><!-- /.box-footer -->
					
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
		</form>
	</div> <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
	$('.pick').change(function(event) {
		var date = $(this).val();
		$.post('<?php echo site_url('articles/ajax/catalogues/createWeek'); ?>', {date: date}, function(data){
		   $('.form-static').val(data);
		});
		event.preventDefault();
	});
</script>