<section class="content-header">
	<h1>Cập nhật</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('mailsubricre/backend/mailsubricre/view');?>">Danh sách</a></li>
		<li class="active"><a href="<?php echo site_url('mailsubricre/backend/mailsubricre/update/'.$Detailmailsubricre['id']);?>">Cập nhật</a></li>
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
								<div class="form-group">
									<label class="col-sm-2 control-label">Họ và tên</label>
									<div class="col-sm-4">
										<?php echo form_input('fullname', set_value('fullname', $Detailmailsubricre['fullname']), 'class="form-control" placeholder="Tên đầy đủ"');?>
									</div>
									<label class="col-sm-1 control-label">Email</label>
									<div class="col-sm-4">
										<?php echo form_input('email', set_value('email', $Detailmailsubricre['email']), 'class="form-control" placeholder="Email"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Số điện thoại</label>
									<div class="col-sm-4">
										<?php echo form_input('phone', set_value('phone', $Detailmailsubricre['phone']), 'class="form-control" placeholder="Điện thoại"');?>
									</div>
									<label class="col-sm-1 control-label">Giống chó</label>
									<div class="col-sm-4">
										<?php echo form_input('address', set_value('address', $Detailmailsubricre['address']), 'class="form-control" placeholder="Giống chó"');?>
									</div>
								</div>
								<?php if ($Detailmailsubricre['type'] == 1){ ?>
								<div class="form-group">
									<label class="col-sm-2 control-label">Người lớn</label>
									<div class="col-sm-4">
										<?php echo form_input('adults', set_value('adults', $Detailmailsubricre['adults']), 'class="form-control" placeholder="Người lớn"');?>
									</div>
									<label class="col-sm-1 control-label">Trẻ em</label>
									<div class="col-sm-4">
										<?php echo form_input('children', set_value('children', $Detailmailsubricre['children']), 'class="form-control" placeholder="Trẻ em"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Trẻ sơ sinh</label>
									<div class="col-sm-4">
										<?php echo form_input('infants', set_value('infants', $Detailmailsubricre['infants']), 'class="form-control" placeholder="Trẻ sơ sinh"');?>
									</div>
									<label class="col-sm-1 control-label">Khởi hành</label>
									<div class="col-sm-4">
										<?php echo form_input('tour_date', set_value('tour_date', $Detailmailsubricre['tour_date']), 'class="form-control" placeholder="Ngày khỏi hành"');?>
									</div>
								</div>
								<?php } ?>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Tên Tour</label>
									<div class="col-sm-4">
										<?php $Product = $this->BackendProducts_Model->ReadByFieldLang('id', $Detailmailsubricre['productid']); ?>
										<?php  
											if(isset($Product) && is_array($Product) && count($Product)){
												$href = rewrite_url($Product['canonical'], $Product['slug'], $Product['id'], 'products'); ?>
												<div class="title">
													<a style="display: block;line-height: 34px;text-decoration: underline;" href="<?php echo $href; ?>" target="_blank" title="<?php echo $Product['title']; ?>"><?php echo $Product['title']; ?></a>
												</div>
										<?php } ?>
									</div>
									<?php if ($Detailmailsubricre['type'] == 2): ?>
										<label class="col-sm-1 control-label">Tên phòng</label>
										<div class="col-sm-4">
											<?php $address = $this->Backendaddress_Model->read($Detailmailsubricre['hotelid']); ?>
											<?php  
												if(isset($address) && is_array($address) && count($address)){ ?>
													<div class="title">
														<a style="display: block;line-height: 34px;text-decoration: underline;" href="<?php echo site_url('address/backend/address/update/'.$address['id']);?>" target="_blank" title="<?php echo $address['title']; ?>"><?php echo $address['title']. ' - '.$address['size']; ?></a>
													</div>
											<?php } ?>
										</div>
									<?php endif ?>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mô tả</label>
									<div class="col-sm-9">
										<?php echo form_textarea('message', set_value('message', $Detailmailsubricre['message']), 'class="form-control"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Ngày đăng ký</label>
									<div class="col-sm-4">
										<?php echo form_input('created', set_value('created', $Detailmailsubricre['created']), 'class="form-control"  disabled=""');?>
									</div>
									<label class="col-sm-1 control-label">Xuất bản</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $Detailmailsubricre['publish']), 'class="form-control select2" style="width: 100%;"');?>
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