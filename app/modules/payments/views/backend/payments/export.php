<section class="content-header">
	<h1>Trích xuất & Thống kê đơn hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('payments/backend/payments/view');?>">đơn hàng</a></li>
		<li class="active"><a href="<?php echo site_url('payments/backend/payments/export');?>">Trích xuất đơn hàng</a></li>
	</ol>
</section>
<form class="form-horizontal" method="post" action="">
<section class="content">
	<div class="row">
		<div class="box-body">
			<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger">'.$error.'</div>':'';?>
		</div><!-- /.box-body -->
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Lựa chọn</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active">
						<div class="box-body">
						<?php if(isset($filename) && !empty($filename)){ ?>
							<div class="form-group">
								<div class="col-sm-4">
									<a href="<?php echo $filename; ?>" downloaded title="">Click to download!</a>
								</div>
							</div>
						<?php } ?>
							<div class="form-group">
								<label class="col-sm-1 control-label">Từ ngày</label>
								<div class="col-sm-4">
									<?php echo form_input('from', set_value('from'), 'class="form-control datetimepicker" placeholder="Từ ngày"');?>
								</div>
								<label class="col-sm-1 control-label">Đến ngày</label>
								<div class="col-sm-4">
									<?php echo form_input('to', set_value('to'), 'class="form-control datetimepicker" placeholder="Đến ngày"');?>
								</div>
							</div>
							
							<?php $status[] = '[Chọn trạng thái]'; $action = $this->configbie->data('status')  ?>
							<?php 
								if(isset($action) && is_array($action) && count($action)){
									foreach($action as $key => $val){
										$status[$key] = $val;
									}
								}
							?>
							
							<div class="form-group">
								<label class="col-sm-1 control-label">Trạng Thái</label>
								<div class="col-sm-4">
									<?php echo form_dropdown('status', $status, $this->input->get('status'), 'class="form-control status"');?>
								</div>
								<label class="col-sm-1 control-label">Từ khóa</label>
								<div class="col-sm-4">
									<?php echo form_input('keyword', set_value('keyword'), 'class="form-control" placeholder="Đến ngày"');?>
								</div>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.tab-pane -->
				</div><!-- /.tab-content -->
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
	
	<div class="box-footer">
		<button type="submit" name="export" value="action" class="btn btn-info pull-right">Trích xuất</button>
	</div><!-- /.box-footer -->
</section><!-- /.content -->
</form>

