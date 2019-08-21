<section class="content-header">
	<h1>Thêm bài viết mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('articles/backend/articles/view');?>">Bài viết</a></li>
		<li class="active"><a href="<?php echo site_url('articles/backend/articles/create');?>">Thêm bài viết mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form class="form-horizontal" method="post" action="">
			<div class="col-md-9">
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
										<label class="col-sm-2 control-label tp-text-left">Bài viết</label>
										<div class="col-sm-8">
											<?php echo form_input('title', set_value('title'), 'class="form-control form-static-link" placeholder="Bài viết"');?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Thời gian học</label>
										<div class="col-sm-10">
											<?php echo form_input('time', html_entity_decode(htmlspecialchars_decode(set_value('time'))), 'class="form-control" placeholder="Thời gian học"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Nội dung bài học</label>
										<div class="col-sm-10">
											<?php echo form_input('content', set_value('content'), 'class="form-control" placeholder="Nội dung bài học"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Gv. Giảng dậy</label>
										<div class="col-sm-10">
											<?php echo form_input('diengia', set_value('diengia'), 'class="form-control" placeholder="Gv. Giảng dậy"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Đối tượng giảng dậy</label>
										<div class="col-sm-10">
											<?php echo form_input('customer_name', set_value('customer_name'), 'class="form-control" placeholder="Đối tượng giảng dậy"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Địa điểm giảng dậy</label>
										<div class="col-sm-10">
											<?php echo form_input('address', set_value('address'), 'class="form-control" placeholder="Đối tượng giảng dậy"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Thời lượng</label>
										<div class="col-sm-10">
											<?php echo form_input('number', set_value('number'), 'class="form-control" placeholder="Thời lượng"');?>
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
			<div class="col-md-3">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Nâng cao</a></li>
					</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab-seo">
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Danh mục ngày tháng</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<select name="cataloguesid" id="cataloguesid " class="form-control">
											<option value="0">|--- Chọn ngày cho buổi học</option>
											<?php
												$cate = $this->BackendLichhocCatalogues_Model->ReadByFieldALL($this->fclang); 
												if (isset($cate) && is_array($cate) && count($cate)) {
													foreach ($cate as $key => $val) {
														?><option value="<?php echo $val['id'] ?>">|--- <?php echo $val['title'].' - '.$val['day'] ?></option><?php
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
		</form>
	</div> <!-- /.row -->
</section><!-- /.content -->