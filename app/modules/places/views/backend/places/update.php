<section class="content-header">
	<h1>Cập nhật dự án</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('places/backend/places/view');?>">dự án</a></li>
		<li class="active"><a href="<?php echo site_url('places/backend/places/update/'.$DetailPlaces['id']);?>">Cập nhật dự án</a></li>
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
									<label class="col-sm-2 control-label">Dự án</label>
									<div class="col-sm-4">
										<?php echo form_input('title', set_value('title', $DetailPlaces['title']), 'class="form-control" placeholder=""');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Tỉnh / Thành Phố</label>
									<?php 
										$location_dropdown = $this->BackendProjects_Model->location_dropdown(array(
											'where' => array('parentid' => 0)
										));
									?>
									<script type="text/javascript">
										var cityid = <?php echo (int)$DetailPlaces['cityid']; ?>;
										var districtid = <?php echo (int)$DetailPlaces['districtid']; ?>;
										var wardid = <?php echo (int)$DetailPlaces['wardid']; ?>;
										var projectid = 0;
									</script>
									<div class="col-sm-4">
										<?php echo form_dropdown('cityid', $location_dropdown, set_value('cityid', $DetailPlaces['cityid']), 'class="form-control location" style="width: 100%;" id="cityid" data-return="district" data-flag="0"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Quận / Huyện</label>
									<div class="col-sm-4">
										<select id="district" class="form-control location" name="districtid" data-return="ward" data-flag="0"><option value="0">[Chọn]</option></select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Phường / Xã</label>
									<div class="col-sm-4">
										<select id="ward" class="form-control location" name="wardid" data-flag="0"><option value="0">[Chọn]</option></select>
									</div>
								</div>
								
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailPlaces['publish']), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->