<section class="content-header">
	<h1>Cập nhật danh mục Menu</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('navigations/backend/positions/view');?>">Danh mục Menu</a></li>
		<li class="active"><a href="<?php echo site_url('navigations/backend/positions/update/'.$DetailNavigationsPositions['id']);?>">Cập nhật danh mục Menu</a></li>
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
									<label class="col-sm-2 control-label">Danh mục Menu</label>
									<div class="col-sm-5">
										<?php echo form_input('title', set_value('title', $DetailNavigationsPositions['title']), 'class="form-control" placeholder="Danh mục Menu"');?>
									</div>
								<div class="form-group">
								</div>
									<label class="col-sm-2 control-label">Canonical</label>
									<div class="col-sm-5">
										<?php echo form_input('canonical', set_value('canonical', $DetailNavigationsPositions['canonical']), 'class="form-control" placeholder="Canonical"');?>
										<?php echo form_hidden('canonical_original', $DetailNavigationsPositions['canonical']);?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailNavigationsPositions['publish']), 'class="form-control" style="width: 100%;"');?>
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