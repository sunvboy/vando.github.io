<section class="content-header">
	<h1>Cập nhật khách hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('users/backend/payment/view');?>">khách hàng - Thanh toán</a></li>
		<li class="active"><a href="<?php echo site_url('users/backend/users/update/'.$DetailPayment['id']);?>">Cập nhật thanh toán</a></li>
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
							<?php echo show_flashdata();?>
						</div><!-- /.box-body -->
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Họ và tên</label>
									<div class="col-sm-4">
										<?php echo form_input('fullname', set_value('fullname', $DetailPayment['fullname']), 'class="form-control" placeholder="Email" disabled');?>
									</div>
									<label class="col-sm-2 control-label">Trạng thái</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('status', $this->configbie->data('status'), set_value('status', $DetailPayment['status']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Số tiền</label>
									<div class="col-sm-4">
										<?php echo form_input('money1', str_replace(',', '.', number_format(set_value('money', $DetailPayment['money']))).' vnđ', 'class="form-control" placeholder="Số tiền" disabled');?>

										<?php echo form_hidden('money', set_value('money', $DetailPayment['money']), 'class="form-control" placeholder="Số tiền"');?>
									</div>
									<label class="col-sm-2 control-label">Tên tài khoản</label>
									<div class="col-sm-4">
										<?php echo form_input('fullname', set_value('fullname', $DetailPayment['fullname']), 'class="form-control" placeholder="Tên thành viên" disabled');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label <?php echo (($DetailPayment['trash'] != 3) ? 'hide' : '') ?>">Người nhận</label>
									<div class="col-sm-4 <?php echo (($DetailPayment['trash'] != 3) ? 'hide' : '') ?>">
										<?php echo form_input('customer_name', set_value('customer_name', $DetailPayment['customer_name']), 'class="form-control" placeholder="Người nhận" disabled');?>
									</div>
									<label class="col-sm-2 control-label <?php echo (($DetailPayment['trash'] == 3) ? 'hide' : '') ?>">Hình thức</label>
									<div class="col-sm-4 <?php echo (($DetailPayment['trash'] == 3) ? 'hide' : '') ?>">
										<?php echo form_input('method', set_value('method', $DetailPayment['method']), 'class="form-control" placeholder="Hình thức" disabled');?>
									</div>
									<label class="col-sm-2 control-label">Phương thức</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('trash', $this->configbie->data('method'), set_value('trash', $DetailPayment['trash']), 'class="form-control" style="width: 100%;" disabled');?>
									</div>
								</div>
								<div class="form-group <?php echo (($DetailPayment['trash'] == 3) ? 'hide' : '') ?>">
									<label class="col-sm-2 control-label">Ngân hàng</label>
									<div class="col-sm-4">
										<?php echo form_input('bank_name', set_value('bank_name', $DetailPayment['bank_name']), 'class="form-control" placeholder="Ngân hàng" disabled');?>
									</div>
									<label class="col-sm-2 control-label">Số TK</label>
									<div class="col-sm-4">
										<?php echo form_input('bank_number', set_value('bank_number', $DetailPayment['bank_number']), 'class="form-control" placeholder="Địa chỉ" disabled');?>
									</div>
								</div>
								<div class="form-group <?php echo (($DetailPayment['trash'] == 3) ? 'hide' : '') ?>">
									<label class="col-sm-2 control-label">Chủ TK</label>
									<div class="col-sm-4">
										<?php echo form_input('bank_code', set_value('bank_code', $DetailPayment['bank_code']), 'class="form-control" placeholder="Chủ TK" disabled');?>
									</div>
									<label class="col-sm-2 control-label">Chi nhánh ngân hàng</label>
									<div class="col-sm-4">
										<?php echo form_input('company', set_value('company', $DetailPayment['company']), 'class="form-control" placeholder="Chi nhánh ngân hàng" disabled');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Ghi chú<br>thành viên</label>
									<div class="col-sm-4">
										<?php echo form_textarea('message', set_value('message', $DetailPayment['message']), 'class="form-control" disabled placeholder="Ghi chú thành viên" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
									<label class="col-sm-2 control-label">Ghi chú<br>Quản trị viên</label>
									<div class="col-sm-4">
										<?php echo form_textarea('note_admin', set_value('note_admin', $DetailPayment['note_admin']), 'class="form-control" placeholder="Ghi chú Quản trị viên" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<span style="color: red">Lưu ý: khi bạn ấn cập nhật thì số tiền thành viên sẽ tự động cập nhật và không thể chỉnh sửa lại</span>
						<button type="submit" name="update" value="action" class="btn btn-info pull-right <?php echo (($DetailPayment['status'] == 1) ? 'hide' : '') ?>">Cập nhật</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->