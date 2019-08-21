<section class="content-header">
	<h1>Chỉnh sửa giảng viên</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('teachers/backend/teachers/view');?>">Giảng viên</a></li>
		<li class="active"><a href="<?php echo site_url('teachers/backend/teachers/create');?>">Thêm mới</a></li>
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
									<label class="col-sm-2 control-label tp-text-left">Tên giảng viên</label>
									<div class="col-sm-8">
										<?php echo form_input('title', set_value('title', $Detailteachers['title']), 'class="form-control form-static-link" placeholder="Tên giảng viên"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Chức vụ</label>
									<div class="col-sm-8">
										<?php echo form_input('chucvu', set_value('chucvu', $Detailteachers['chucvu']), 'class="form-control form-static-link" placeholder="Tên chức vụ, chuyên ngành"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Facebook</label>
									<div class="col-sm-8">
										<?php echo form_input('facebook', set_value('facebook', $Detailteachers['facebook']), 'class="form-control form-static-link" placeholder="Links Facebook"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Messenger</label>
									<div class="col-sm-8">
										<?php echo form_input('messenger', set_value('messenger', $Detailteachers['messenger']), 'class="form-control form-static-link" placeholder="Links messenger"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Videos giới thiệu</label>
									<div class="col-sm-10">
										<?php echo form_textarea('video', htmlspecialchars_decode(set_value('video', $Detailteachers['video'])), 'placeholder="Videos giới thiệu"  style="width: 100%; height: 150px;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Mô tả</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description', $Detailteachers['description'])), 'id="txtDescription" class="ckeditor-description" placeholder="Mô tả ngắn"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-album">
							<div class="box-body">
								<div class="form-group" id="fromSlide">
								<?php $album = $this->input->post('album'); if(isset($album) && is_array($album) && count($album)){ ?>
								<?php foreach($album['images'] as $key => $val){ if(empty($album['images'][$key])) continue;?>
								<div class="col-sm-3 slideItem">
								<div class="thumb"><img src="<?php echo $album['images'][$key];?>" class="img-thumbnail img-responsive"/></div>
								<input type="hidden" name="album[images][]" value="<?php echo $album['images'][$key];?>" />
								<input type="text" name="album[title][]" value="<?php echo $album['title'][$key];?>" class="form-control title" placeholder="Tên ảnh" />
								<textarea name="album[description][]" cols="40" rows="10" class="form-control description" placeholder="Mô tả ảnh"><?php echo $album['description'][$key];?></textarea>
								<button type="button" class="btn btnRemove btn-danger pull-right">Xóa bỏ</button>
								</div>
								<?php } ?>
								<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem pull-left">+</button></div>
								<?php } ?>
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
								<label class="col-sm-12 control-label tp-text-left">Ảnh đại diện</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (!empty($Detailteachers['images']))? $Detailteachers['images']:'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;" /></div>
									<?php echo form_input('images', set_value('images', $Detailteachers['images']), 'class="form-control"  placeholder="Ảnh đại diện" onclick="openKCFinder(this)" ');?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Xuất bản</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $Detailteachers['publish']), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Nổi bật</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('highlight', $this->configbie->data('highlight'), set_value('highlight', $Detailteachers['highlight']), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>
						</div>
					</div><!-- /.tab-pane -->
				</div><!-- /.tab-content -->
			</div><!-- nav-tabs-custom -->
		</form>
	</div> <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
</script>