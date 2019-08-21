<section class="content-header">
	<h1>Thêm audio mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('videos/backend/videos/view');?>">Audio</a></li>
		<li class="active"><a href="<?php echo site_url('videos/backend/videos/create');?>">Thêm audio mới</a></li>
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
										<label class="col-sm-2 control-label tp-text-left">Audio</label>
										<div class="col-sm-8">
											<?php echo form_input('title', set_value('title'), 'class="form-control form-static-link" placeholder="Audio"');?>
										</div>
										<div class="col-sm-2"><span class="btn btn-primary create-static-links" data-module="articles" data-catalogue="catalogues">Tạo liên kết tĩnh</span></div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Liên kết</label>
										<label class="col-sm-3 control-label tp-text-left"><?php echo base_url(); ?></label>
										<div class="col-sm-5">
											<?php echo form_input('canonical', set_value('canonical'), 'class="form-control canonical" placeholder="Liên kết"');?>
										</div>
										<div class="col-sm-2" style="line-height: 34px;font-weight: 600;">.html</div>
									</div>
			
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Chủ đề</label>
										<div class="col-sm-10">
											<?php echo form_dropdown('tagsid[]', $this->BackendTags_Model->Dropdown(), (isset($tagsid)?$tagsid:NULL), 'class="form-control select2" multiple="multiple" style="width: 100%;" id="tagsid"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Tiêu đề SEO</label>
										<div class="col-sm-10">
											<?php echo form_input('meta_title', set_value('meta_title'), 'class="form-control" placeholder="Tiêu đề SEO"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Từ khóa SEO</label>
										<div class="col-sm-10">
											<?php echo form_input('meta_keyword', set_value('meta_keyword'), 'class="form-control" placeholder="Từ khóa SEO"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Mô tả SEO</label>
										<div class="col-sm-10">
											<?php echo form_textarea('meta_description', set_value('meta_description'), 'class="form-control" placeholder="Mô tả SEO" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Mô tả</label>
										<div class="col-sm-10">
											<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description')), 'id="txtDescription" class="ckeditor-description" placeholder="Mô tả" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
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
									<label class="col-sm-12 control-label tp-text-left">Ảnh đại diện</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (isset($avatar) && !empty($avatar))?$avatar: 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;" /></div>
										<?php echo form_input('images', set_value('images'), 'class="form-control"  placeholder="Ảnh đại diện" onclick="openKCFinder(this)"'); ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Audio upload</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('audio_link', set_value('audio_link'), 'class="form-control"  placeholder="Audio upload" onclick="openKCFinder(this, \'audio\')" ');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Breadcrumb / Danh mục cha</label>
								</div>
								<?php $dropdown = $this->nestedsetbie->Dropdown(); ?>
								<?php if(isset($dropdown) && is_array($dropdown) && count($dropdown)) { ?>
								<div class="form-group">
									<div class="col-sm-12">
										<div class="uk-scrollable-box">
											<ul class="uk-list tp-list-catalogue">
												<?php foreach ($dropdown as $key => $val) { if ($key == 0) continue; ?>
												<li>
													<label for="" class="catalogueid">
														<?php echo form_radio('cataloguesid', $key, set_radio('cataloguesid', $key, FALSE));?>
													</label>
													<label for="" class="catalogue">
													<?php echo form_checkbox('catalogue[]', $key, set_checkbox('catalogue[]', $key, FALSE), (isset($catalogue) && in_array($key,$catalogue))?'checked="checked"': '');?>
														<?php echo $val; ?>
													</label>
												</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
								 <?php } ?>
	
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Xuất bản</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Trang chủ</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('ishome', $this->configbie->data('ishome'), set_value('ishome', -1), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Aside</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('isaside', $this->configbie->data('isaside'), set_value('isaside', -1), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Footer</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('isfooter', $this->configbie->data('isfooter'), set_value('isfooter', -1), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Nổi bật</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('highlight', $this->configbie->data('highlight'), set_value('highlight', -1), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Vị trí</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('order', set_value('order'), 'class="form-control" placeholder="Vị trí"');?>
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