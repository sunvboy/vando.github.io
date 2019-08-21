<?php $upload_base = explode('/index.php', $_SERVER['SCRIPT_NAME']); $upload_base = $upload_base[0]; ?>
<?php $default = 'templates/backend/dist/img/default+.png'; ?>
<section class="content-header">
	<h1>Thêm Nhóm slide mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('slides/backend/groups/view');?>">Nhóm slide</a></li>
		<li class="active"><a href="<?php echo site_url('slides/backend/groups/create');?>">Thêm Nhóm slide mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
					<li><a href="#tab-slides" data-toggle="tab">Ảnh slide</a></li>
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
									<label class="col-sm-2 control-label">Tên nhóm slide</label>
									<div class="col-sm-8">
										<?php echo form_input('title', set_value('title'), 'class="form-control" placeholder="Tên nhóm slide"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Liên kết danh mục</label>
									<div class="col-sm-8">
										<?php echo form_input('href', set_value('href'), 'class="form-control" placeholder="Liên kết danh mục"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Từ khóa</label>
									<div class="col-sm-8">
										<?php echo form_input('keyword', set_value('keyword'), 'class="form-control" placeholder="Keyword"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mô tả</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description')), 'class="textarea" placeholder="Mô tả" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-slides">
							<div class="box-body" id="images-group">
							<?php
							$x = 1;
							if (isset($images_post) && is_array($images_post) && count($images_post)) {
								foreach ($images_post as $value) {
							?>
								<div class="col-sm-3 fc-thumb-block">
									<div class="fc-upload-thumb fc-crop-center-img-h"><img src="<?php echo $value['image']; ?>" alt="" id="txtImages<?php echo $x; ?>" title="Upload ảnh" /></div>
									<?php echo form_input('image'.$x, $value['image'], 'class="form-control" placeholder="Ảnh đại diện" onclick="openCurrentKCFinder(this, \'txtImages'.$x.'\')"');?>
									<?php echo form_input('order'.$x, $value['order'], 'class="order text-right" placeholder="#" title="Vị trí"');?>
									<button class="fc-edit-thumb btn btn-primary" title="Chỉnh sửa chi tiết ảnh" type="button" data-toggle="modal" data-target="#modal<?php echo $x; ?>"><i class="fa fa-pencil"></i></button>
									<button class="fc-remove-thumb btn btn-danger" title="Xóa ảnh"><i class="fa fa-trash"></i></button>
									<div class="modal fade" id="modal<?php echo $x; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Chỉnh sửa chi tiết ảnh</h4></div>
												<div class="modal-body">
													<div class="fc-upload-thumb fc-crop-center-img-h"><img src="<?php echo $value['image']; ?>" alt="" id="" /></div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Đường dẫn ảnh</label>
														<div class="col-sm-9"><?php echo form_input('_image'.$x, $value['image'], 'class="image form-control" placeholder="Ảnh đại diện" disabled="disabled"');?></div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Liên kết</label>
														<div class="col-sm-9"><?php echo form_input('url'.$x, $value['url'], 'class="url form-control" placeholder="URL"');?></div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Xuất bản</label>
														<div class="col-sm-9">
															<?php echo form_dropdown('publish'.$x, $this->configbie->data('publish'), set_value('publish'.$x, 1), 'class="form-control" style="width: 100%;"');?>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Tiêu đề ảnh</label>
														<div class="col-sm-9"><?php echo form_textarea('title'.$x, $value['title'], 'placeholder="Mô tả"');?></div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Mô tả ảnh</label>
														<div class="col-sm-9"><?php echo form_textarea('description'.$x, $value['description'], 'placeholder="Mô tả"');?></div>
													</div>
													<div class="text-right"><button type="button" class="save btn btn-primary" data-dismiss="modal">Lưu</button></div>
												</div>
											</div>
										</div>
									</div><!-- .modal -->
								</div><!-- .fc-thumb-block -->
							<?php $x++; } } ?>
							
								<div class="col-sm-3 fc-thumb-block fc-thumb-new">
									<div class="fc-upload-thumb fc-fit-img"><img src="<?php echo $default; ?>" alt="" id="txtImages<?php echo $x; ?>" title="Upload ảnh" /></div>
									<?php echo form_input('image'.$x, '', 'class="form-control" placeholder="Ảnh đại diện" onclick="openNextKCFinder(this, \'txtImages'.$x.'\')"');?>
									<?php echo form_input('order'.$x, '', 'class="order text-right" placeholder="#" title="Vị trí"');?>
									<button class="fc-edit-thumb btn btn-primary" title="Chỉnh sửa chi tiết ảnh" type="button" data-toggle="modal" data-target="#modal<?php echo $x; ?>"><i class="fa fa-pencil"></i></button>
									<button class="fc-remove-thumb btn btn-danger" title="Xóa ảnh"><i class="fa fa-trash"></i></button>
									<div class="modal fade" id="modal<?php echo $x; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Chỉnh sửa chi tiết ảnh</h4></div>
												<div class="modal-body">
													<div class="fc-upload-thumb fc-crop-center-img-h"><img src="<?php echo $default; ?>" alt="" id="" /></div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Đường dẫn ảnh</label>
														<div class="col-sm-9"><?php echo form_input('_image'.$x, '', 'class="image form-control" placeholder="Ảnh đại diện" disabled="disabled"');?></div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Liên kết</label>
														<div class="col-sm-9"><?php echo form_input('url'.$x, '', 'class="url form-control" placeholder="URL"');?></div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Xuất bản</label>
														<div class="col-sm-9">
															<?php echo form_dropdown('publish'.$x, $this->configbie->data('publish'), set_value('publish'.$x, 1), 'class="form-control" style="width: 100%;"');?>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Tiêu đề ảnh</label>
														<div class="col-sm-9"><?php echo form_textarea('title'.$x, $value['title'], 'placeholder="Mô tả"');?></div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">Mô tả ảnh</label>
														<div class="col-sm-9"><?php echo form_textarea('description'.$x, '', 'placeholder="Mô tả"');?></div>
													</div>
													<div class="text-right"><button type="button" class="save btn btn-primary" data-dismiss="modal">Lưu</button></div>
												</div>
											</div>
										</div>
									</div><!-- .modal -->
								</div><!-- .fc-thumb-block -->
								<!-- .fc-thumb-new -->

								<?php echo form_input('images_count', set_value('images_count', isset($images_count)?$images_count:0), 'class="hidden"'); ?>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
									</div>
									<label class="col-sm-2 control-label">Vị trí</label>
									<div class="col-sm-2">
										<?php echo form_input('order', set_value('order'), 'class="form-control" placeholder="Vị trí"');?>
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

<!-- EXCLUSIVE JAVASCRIPT FOR UPLOADING SLIDE IMAGES FUNCTION -->
<script type="text/javascript">
	function openCurrentKCFinder(field, destination) {
		window.KCFinder = {
			callBack: function(url) {
				field.value = url;
				window.KCFinder = null;
				if (destination != '') {
					$('#'+destination).attr('src', url);
					if (url != '') {
						$('#'+destination).parent().siblings('.modal').find('.form-control.image').val(url);
						$('#'+destination).parent().siblings('.modal').find('.fc-upload-thumb img').attr('src', url);
						// $('#'+destination).parent().parent().removeClass('fc-thumb-new').next().removeClass('hidden');
					}
				}
			}
		};
		window.open('<?php echo $upload_base; ?>/plugins/kcfinder-master/browse.php?type=images&dir=images/public', 'kcfinder_image',
			'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
			'resizable=1, scrollbars=0, width=800, height=600'
		);
	}

	function openNextKCFinder(field, destination) {
		window.KCFinder = {
			callBack: function(url) {
				field.value = url;
				window.KCFinder = null;
				if (destination != '') {
					$('#'+destination).parent().removeClass('fc-fit-img').addClass('fc-crop-center-img-h');
					$('#'+destination).attr('src', url);
					if (url != '') {
						currentid = destination.split('txtImages')[1];
						$('#'+destination).parent().siblings('input[name*=image]').removeAttr('onclick').attr('onclick', 'openCurrentKCFinder(this, \'txtImages'+currentid+'\')');
						$('#'+destination).parent().siblings('.modal').find('.form-control.image').val(url);
						$('#'+destination).parent().siblings('.modal').find('.fc-upload-thumb img').attr('src', url);
						$('#'+destination).parent().parent().removeClass('fc-thumb-new');
						var x = ++currentid;
						$('input[name=images_count]').attr('value', x-1);
						var append =
						'<div class="col-sm-3 fc-thumb-block fc-thumb-new">' +
							'<div class="fc-upload-thumb fc-fit-img" onclick="$(\'input[name=image'+x+']\').triggerHandler(\'click\');"><img src="<?php echo $default; ?>" alt="" id="txtImages'+x+'" title="Upload ảnh"></div>' +
							'<input type="text" name="image'+x+'" value="" class="form-control" placeholder="Ảnh đại diện" onclick="openNextKCFinder(this, \'txtImages'+x+'\')">' +
							'<input type="text" name="order'+x+'" value="" class="order text-right" placeholder="#" title="Vị trí">' +
							'<button class="fc-edit-thumb btn btn-primary" title="Chỉnh sửa chi tiết ảnh" type="button" data-toggle="modal" data-target="#modal'+x+'"><i class="fa fa-pencil"></i></button>' +
							'<button class="fc-remove-thumb btn btn-danger" title="Xóa ảnh" onclick="$(\'input[name=image'+x+']\').parent().remove();return false;"><i class="fa fa-trash"></i></button>' +
							'<div class="modal fade" id="modal'+x+'">' +
								'<div class="modal-dialog">' +
									'<div class="modal-content">' +
										'<div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h4 class="modal-title">Chỉnh sửa chi tiết ảnh</h4></div>' +
										'<div class="modal-body">' +
											'<div class="fc-upload-thumb fc-crop-center-img-v"><img src="templates/backend/dist/img/default.png" alt="" id=""></div>' +
											'<div class="form-group">' +
												'<label class="col-sm-3 control-label">Đường dẫn ảnh</label>' +
												'<div class="col-sm-9"><input type="text" name="_image'+x+'" value="" class="image form-control" placeholder="Ảnh đại diện" disabled="disabled"></div>' +
											'</div>' +
											'<div class="form-group">' +
												'<label class="col-sm-3 control-label">Liên kết</label>' +
												'<div class="col-sm-9"><input type="text" name="url'+x+'" value="" class="url form-control" placeholder="URL"></div>' +
											'</div>' +
											'<div class="form-group">' +
												'<label class="col-sm-3 control-label">Xuất bản</label>' +
												'<div class="col-sm-9">'+
												'<select name="publish3" class="form-control" style="width: 100%;">' +
													'<option value="-1">- Chọn xuất bản -</option>' +
													'<option value="0">Không xuất bản</option>' +
													'<option value="1" selected="selected">Xuất bản</option>' +
												'</select>'+
												'</div>' +
											'</div>' +
											'<div class="form-group">' +
												'<label class="col-sm-3 control-label">Tiêu đề ảnh</label>' +
												'<div class="col-sm-9"><textarea name="title'+x+'" cols="" rows="10" placeholder="title"></textarea></div>' +
											'</div>' +
											'<div class="form-group">' +
												'<label class="col-sm-3 control-label">Mô tả ảnh</label>' +
												'<div class="col-sm-9"><textarea name="description'+x+'" cols="" rows="10" placeholder="Mô tả"></textarea></div>' +
											'</div>' +
											'<div class="text-right"><button type="button" class="save btn btn-primary" data-dismiss="modal">Lưu</button></div>' +
										'</div>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>';
						$('#'+destination).closest('.box-body').append(append);
					}
				}
			}
		};
		window.open('<?php echo $upload_base; ?>/plugins/kcfinder-master/browse.php?type=images&dir=images/public', 'kcfinder_image',
			'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
			'resizable=1, scrollbars=0, width=800, height=600'
		);
	}

	$('.fc-thumb-block > .fc-upload-thumb').on('click', function() { $(this).siblings('.form-control').triggerHandler('click'); });

	$('.fc-remove-thumb').on('click', function() { $(this).parent().remove(); return false; });

	$('.modal input.form-control').keypress(function(event) { if (event.which == 13) event.preventDefault(); });

</script>
<!-- END OF SCRIPT -->