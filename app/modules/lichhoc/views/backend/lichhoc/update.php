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
										<label class="col-sm-2 control-label tp-text-left">Tiêu đề</label>
										<div class="col-sm-8">
											<?php echo form_input('title', set_value('title', $DetailArticles['title']), 'class="form-control form-static-link" placeholder="Tiêu đề"');?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Thời gian học</label>
										<div class="col-sm-10">
											<?php echo form_input('time', html_entity_decode(htmlspecialchars_decode(set_value('time', $DetailArticles['time']))), 'class="form-control" placeholder="Thời gian học"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Ngày khai giảng</label>
										<div class="col-sm-10">
											<?php echo form_input('date', set_value('date', $DetailArticles['date']), 'class="form-control datetimepicker" placeholder="Ngày khai giảng"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Học phí</label>
										<div class="col-sm-10">
											<?php echo form_input('price', set_value('price', $DetailArticles['price']), 'class="form-control" placeholder="Học phí"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Địa điểm giảng dậy</label>
										<div class="col-sm-10">
											<?php echo form_input('address', set_value('address', $DetailArticles['address']), 'class="form-control" placeholder="Đối tượng giảng dậy"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Số điện thoại</label>
										<div class="col-sm-10">
											<?php echo form_input('phone', set_value('phone', $DetailArticles['phone']), 'class="form-control" placeholder="Số điện thoại"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Nội dung</label>
										<div class="col-sm-10">
											<?php echo form_textarea('content', htmlspecialchars_decode(set_value('content', $DetailArticles['content'])), 'id="txtContent" class="ckeditor-description" placeholder="Nội dung" style="width: 100%; height: 350px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
										</div>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
						<div class="box-footer">
							<button type="reset" class="btn btn-default">Làm lại</button>
							<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
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
														?><option <?php echo (($val['id'] == $DetailArticles['cataloguesid']) ? 'selected="selected"' : '') ?> value="<?php echo $val['id'] ?>">|--- <?php echo $val['title'].'' ?></option><?php
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Xuất bản</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailArticles['publish']), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Trang chủ</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('ishome', $this->configbie->data('ishome'), set_value('ishome', $DetailArticles['ishome']), 'class="form-control" style="width: 100%;"');?>
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
<script type="text/javascript">
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
</script>