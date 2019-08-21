<section class="content-header">
	<h1>Thêm combo mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('combos/backend/combos/view');?>">combo</a></li>
		<li class="active"><a href="<?php echo site_url('combos/backend/combos/create');?>">Thêm combo mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
				</ul>
				<form class="form-horizontal" method="post" action="">
					<div class="tab-content">
						<div class="box-body">
							<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
						</div><!-- /.box-body -->
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6 col-xs-12 col-sm-6">
										<div class="form-group">
											<label class="col-sm-2 control-label">Tiêu đề</label>
											<div class="col-sm-10">
												<?php echo form_input('title', set_value('title'), 'class="form-control" placeholder="Tên combo"');?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Giá</label>
											<div class="col-sm-10">
												<?php echo form_input('saleoff', set_value('saleoff'), 'class="form-control price" placeholder=""');?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Sản phẩm chính</label>
											<div class="col-sm-10">
												<?php echo form_dropdown('parentid', $this->BackendProducts_Model->Dropdown(), (isset($data)?$data:NULL), 'class="form-control select2"  style="width: 100%;" id="data"');?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Ảnh combos sản phẩm</label>
											<div class="col-sm-10">
												<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (isset($avatar) && !empty($avatar))?$avatar: 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;object-fit: scale-down;height: 200px;" /></div>
												<?php echo form_input('images', set_value('images'), 'class="form-control"  placeholder="Ảnh đại diện"  ');?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Xuất bản</label>
											<div class="col-sm-10">
												<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-xs-12 col-sm-6">
										<?php echo $this->load->view('combos/backend/combos/view/create');?>
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
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
	
	$(document).ready(function(){
		var time;
		$('.price').on('keyup', function(event) {
			var price = $(this).val();
			var _this = $(this);
			var url = 'products' +'/ajax/'+ 'products' + '/convert_commas_price';
			clearTimeout(time);
			time = setTimeout(function() {
				$.post(url, {price: price}, function(data){
					_this.val(data);
				});
			}, 300);
		});
	});
</script>