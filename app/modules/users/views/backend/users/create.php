<section class="content-header">
	<h1>Thêm thành viên mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('users/backend/users/view');?>">Thành viên</a></li>
		<li class="active"><a href="<?php echo site_url('users/backend/users/create');?>">Thêm thành viên mới</a></li>
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
									<label class="col-sm-2 control-label">Thành viên</label>
									<div class="col-sm-4">
										<?php echo form_input('email', set_value('email'), 'class="form-control" placeholder="Email"');?>
									</div>
									<label class="col-sm-1 control-label">Mật khẩu</label>
									<div class="col-sm-5">
										<?php echo form_input('password', set_value('password'), 'class="form-control" placeholder="Mật khẩu"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nhóm thành viên</label>
									<div class="col-sm-4">
										<?php echo form_dropdown('groupsid', $this->BackendUsersGroups_Model->Dropdown(), set_value('groupsid'), 'class="form-control" style="width: 100%;" id="groupsid"');?>
									</div>
									<label class="col-sm-1 control-label">Tên đầy đủ</label>
									<div class="col-sm-5">
										<?php echo form_input('fullname', set_value('fullname'), 'class="form-control" placeholder="Tên đầy đủ"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mô tả</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description')), 'class="textarea" placeholder="Mô tả" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-seo">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Title</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_title', set_value('meta_title'), 'class="form-control" placeholder="Meta Title"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Keyword</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_keyword', set_value('meta_keyword'), 'class="form-control" placeholder="Meta Keyword"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Description</label>
									<div class="col-sm-10">
										<?php echo form_textarea('meta_description', set_value('meta_description'), 'class="form-control" placeholder="Meta Description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
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