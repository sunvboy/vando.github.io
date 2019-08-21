<section class="content-header">
	<h1>Cập nhật khách hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('users/backend/users/view');?>">khách hàng</a></li>
		<li class="active"><a href="<?php echo site_url('users/backend/users/update/'.$DetailCustomers['id']);?>">Cập nhật khách hàng</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
					<li><a href="#tab-seo" data-toggle="tab">SEO</a></li>
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
									<label class="col-sm-2 control-label">Email</label>
									<div class="col-sm-4">
										<?php echo form_input('email', set_value('email', $DetailCustomers['email']), 'class="form-control" placeholder="Email"');?>
									</div>
									<label class="col-sm-1 control-label">Mã Affiliate</label>
									<div class="col-sm-5">
										<?php echo form_input('affiliate_id', set_value('affiliate_id', $DetailCustomers['affiliate_id']), 'class="form-control" placeholder="Mã Affiliate"');?>
										<?php echo form_hidden('original_affiliate_id', set_value('affiliate_id', $DetailCustomers['affiliate_id']), 'class="form-control" placeholder="Mã Affiliate"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nhóm khách hàng</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('groupsid', $this->BackendCustomersGroups_Model->Dropdown(), set_value('groupsid', $DetailCustomers['groupsid']), 'class="form-control" style="width: 100%;" id="groupsid"');?>
									</div>
									<label class="col-sm-1 control-label">Tên đầy đủ</label>
									<div class="col-sm-5">
										<?php echo form_input('fullname', set_value('fullname', $DetailCustomers['fullname']), 'class="form-control" placeholder="Tên đầy đủ"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Nickname</label>
									<div class="col-sm-4">
										<?php echo form_input('nickname', set_value('nickname', $DetailCustomers['nickname']), 'class="form-control" placeholder="Nickname"');?>
									</div>
									<label class="col-sm-2 control-label">Mã KH</label>
									<div class="col-sm-4">
										<?php echo form_input('code', set_value('code', $DetailCustomers['code']), 'class="form-control" placeholder="Mã khách hàng"');?>
										<?php echo form_hidden('original_code', set_value('code', $DetailCustomers['code']), 'class="form-control" placeholder="Mã khách hàng"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Số điện thoại</label>
									<div class="col-sm-4">
										<?php echo form_input('phone', set_value('phone', $DetailCustomers['phone']), 'class="form-control" placeholder="Phone"');?>
									</div>
									<label class="col-sm-1 control-label">Địa chỉ</label>
									<div class="col-sm-5">
										<?php echo form_input('address', set_value('address', $DetailCustomers['address']), 'class="form-control" placeholder="Địa chỉ"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Người giới thiệu</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('parentid', $this->BackendCustomers_Model->DropdownName(), set_value('parentid', $DetailCustomers['parentid']), 'class="form-control select2"');?>
									</div>
									<label class="col-sm-1 control-label">Level</label>
									<div class="col-sm-5">
										<?php echo form_dropdown('level', $this->BackendLevel_Model->Dropdown(), set_value('level', $DetailCustomers['level']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mô tả</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description', $DetailCustomers['description'])), 'class="textarea" placeholder="Mô tả" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-seo">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Title</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_title', set_value('meta_title', $DetailCustomers['meta_title']), 'class="form-control" placeholder="Meta Title"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Keyword</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_keyword', set_value('meta_keyword', $DetailCustomers['meta_keyword']), 'class="form-control" placeholder="Meta Keyword"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Description</label>
									<div class="col-sm-10">
										<?php echo form_textarea('meta_description', set_value('meta_description', $DetailCustomers['meta_description']), 'class="form-control" placeholder="Meta Description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailCustomers['publish']), 'class="form-control" style="width: 100%;"');?>
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