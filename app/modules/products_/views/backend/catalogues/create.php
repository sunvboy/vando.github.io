<section class="content-header">
	<h1>Thêm danh mục sản phẩm mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('products/backend/catalogues/view');?>">Danh mục sản phẩm</a></li>
		<li class="active"><a href="<?php echo site_url('products/backend/catalogues/create');?>">Thêm danh mục sản phẩm mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form class="form-horizontal" method="post" action="">
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
						<li class=""><a href="#tab-attribute" data-toggle="tab">Thuộc tính</a></li>
						<!-- <li class=""><a href="#tab-video" data-toggle="tab">Videos giới thiệu</a></li> -->
						<!-- <li class=""><a href="#tab-albums" data-toggle="tab">Phương pháp giảng dậy</a></li> -->
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
											<?php echo form_input('title', set_value('title'), 'class="form-control form-static-link" placeholder="Tiêu đề"');?>
										</div>
										<div class="col-sm-2"><span class="btn btn-primary create-static-links">Tạo liên kết tĩnh</span></div>
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
											<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description')), 'id="txtDescription" class="ckeditor-description" placeholder="Mô tả" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
										</div>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.tab-pane -->
							<div class="tab-pane " id="tab-attribute">
								<?php 
									$attribute_group = $this->BackendAttributes_Model->_get_where(array(
										'select' => 'id, title, keyword',
										'table' => 'attributes_catalogues',
										'where' => array('publish' => 1,'trash' => 0),
										'order_by' => 'title asc, id desc',
										'modules' => 'products',
									), TRUE);
									if(isset($attribute_group) && is_array($attribute_group) && count($attribute_group)){
										foreach($attribute_group as $key => $val){
											$attribute_group[$key]['attribute'] = $this->BackendAttributes_Model->_get_where(array(
												'select' => 'id, title',
												'table' => 'attributes',
												'where' => array('publish' => 1,'cataloguesid' => $val['id'],'trash' => 0),
												'order_by' => 'title asc, id desc',
											), TRUE);
										}
									}
								?>
								<div class="box-body">
									<?php if(isset($attribute_group) && is_array($attribute_group) && count($attribute_group)){ ?>
									<?php foreach($attribute_group as $key => $val){ ?>
										<div class="group">
											<div class="form-group attribute-title">
												<div class="col-sm-12">
													<label class="form-label"><input type="checkbox" name="attribute_group[]" value="<?php echo $val['id']; ?>" /> <?php echo $val['title']; ?></label>
												</div>
											</div>
											<?php if(isset($val['attribute']) && is_array($val['attribute']) && count($val['attribute'])){ ?>
											<div class="form-group attribute-group">
											<?php foreach($val['attribute'] as $keyAttr => $valAttr){ ?>
												<label class="col-sm-2 form-label"><input type="checkbox" name="attribute[<?php echo $val['keyword']; ?>][]" disabled="disabled" value="<?php echo $valAttr['id']; ?>" /><?php echo $valAttr['title']; ?></label>
											<?php } ?>
											</div>
											<?php } ?>
										</div>
									<?php }} ?>
								</div><!-- /.box-body -->
							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="tab-video">
								<div class="box-body">
									<?php 
										$video_ = $this->input->post('video');
									?>
									<?php if(isset($video_) && is_array($video_) && count($video_)){ ?>
										<?php foreach($video_['images'] as $key => $val){ ?>
											<?php if(empty($video_['images'][$key])) continue; ?>
											<div class="form-group">
												<label class="col-sm-2 control-label tp-text-left">Links Videos</label>
												<div class="col-sm-10">
													<input type="text" name="video[title][]" value="<?php echo $video_['title'][$key];?>" class="form-control title" placeholder="Tên ảnh" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label tp-text-left">Ảnh đại diện videos</label>
												<div class="col-sm-10">
													<input type="text" name="video[images][]" class="form-control" onclick="openKCFinder(this)" value="<?php echo $video_['images'][$key];?>" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label tp-text-left">Mô tả Videos</label>
												<div class="col-sm-10">
													<textarea name="video[description][]" id="txtDescription2" class="ckeditor-description form-control" cols="40" rows="10" placeholder="Mô tả ảnh"><?php echo $video_['description'][$key];?></textarea>
												</div>
											</div>
										<?php } ?>
									<?php }else{ ?>
										<div class="form-group">
											<label class="col-sm-2 control-label tp-text-left">Links Videos</label>
											<div class="col-sm-10">
												<input type="text" name="video[title][]" value="" class="form-control" placeholder="Links Videos" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label tp-text-left">Ảnh đại diện videos</label>
											<div class="col-sm-10">
												<input type="text" name="video[images][]" class="form-control" onclick="openKCFinder(this)" value="" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label tp-text-left">Mô tả Videos</label>
											<div class="col-sm-10">
												<textarea name="video[description][]" cols="40" rows="10" id="txtDescription2" class="ckeditor-description form-control" placeholder="Mô tả ảnh"></textarea>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="tab-pane " id="tab-albums">
								<div class="box-body">
									<div class="form-group" id="fromSlide">
									<?php $album = $this->input->post('album'); if(isset($album) && is_array($album) && count($album)){ ?>
									<?php foreach($album['images'] as $key => $val){ if(empty($album['images'][$key])) continue;?>
									<div class="col-sm-12 slideItem"  style="height: auto;">
									<div class="thumb hide"><img src="<?php echo $album['images'][$key];?>" class="img-thumbnail img-responsive"/></div>
									<input type="hidden" name="album[images][]" value="<?php echo $album['images'][$key];?>" />
									<input type="text" name="album[title][]" value="<?php echo $album['title'][$key];?>" class="form-control title hide" placeholder="Tên ảnh" />
									<textarea name="album[description][]" cols="40" rows="10" class="form-control" placeholder="Nội dung"><?php echo $album['description'][$key];?></textarea>
									<button type="button" class="btn btnRemove btn-danger pull-right">Xóa bỏ</button>
									</div>
									<?php } ?>
									<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem pull-left">+</button></div>
									<?php } ?>
									</div>
								</div><!-- /.box-body -->
							</div>
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
						<li  class="active"><a href="#tab-advanced" data-toggle="tab">SEO - Nâng cao</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-seo">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Ảnh đại diện</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="templates/not-found.png" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;" /></div>
										<?php echo form_input('images', set_value('images'), 'class="form-control"  placeholder="Ảnh đại diện" onclick="openKCFinder(this)" ');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Icon danh mục</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('icon', set_value('icon'), 'class="form-control" placeholder="Icon danh mục" onclick="openKCFinder(this)"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Danh mục cha</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('parentid', $this->nestedsetbie->dropdown(), set_value('parentid'), 'class="form-control" style="width: 100%;" id="parentid"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Giới hạn sp hiển thị trang chủ (Bội số của 4)</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('limit_home', set_value('limit_home', 8), 'class="form-control" placeholder="Bội số của 4"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Giới hạn danh mục con hiển thị trang chủ</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('limit_parent', set_value('limit_parent'), 'class="form-control" placeholder="Mặc định là 4"');?>
									</div>
								</div>

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
										<?php echo form_dropdown('ishome', $this->configbie->data('ishome'), set_value('ishome', 0), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Cột Aside</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('isaside', $this->configbie->data('isaside'), set_value('isaside', 0), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Nổi bật</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('highlight', $this->configbie->data('highlight'), set_value('highlight', 0), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-12 control-label tp-text-left">Giao diện Menu(Ebook)</label>
								</div>
								<div class="form-group hide">
									<div class="col-sm-12">
										<?php echo form_dropdown('isfooter', $this->configbie->data('isfooter'), set_value('isfooter', -1), 'class="form-control" style="width: 100%;"');?>
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
							</div><!-- /.box-body -->
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
<script>
   	$(document).ready(function() {
		$('.attribute-title .form-label').on('click', function() {
	 		var $_this = $(this);
	 		if(!$_this.find('input[type=checkbox]').prop('checked')) {
	  			$_this.parents('.group').find('.attribute-group input[type=checkbox]').attr('disabled','disabled');
	 		}else {
	 		 	$_this.parents('.group').find('.attribute-group input[type=checkbox]').removeAttr('disabled checked');
	 		}
		});
   	});
</script>
<script type="text/javascript">
	$(window).load(function(){
		var item;
		item = '<div class="col-sm-12 slideItem"  style="height: auto;">';
		item = item + '<div class="thumb hide"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
		item = item + '<input type="hidden" name="album[images][]" value="STT" />';
		item = item + '<input type="text" name="album[title][]" value="" class="form-control title hide" placeholder="Tên ảnh"/>';
		item = item + '<textarea name="album[description][]" cols="40" rows="10" class="form-control " placeholder="Mô tả ảnh"></textarea>';
		item = item + '<button type="button" class="btn btnRemove btn-danger pull-right">Xóa bỏ</button>';
		item = item + '</div>';
		item = item + '<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem pull-left">+</button></div>';
		if($('#fromSlide').html().trim() == ''){
			$('#fromSlide').append(item);
		}
		/* Thêm phần tử đầu tiên */
		$(document).on('click', '.btnAddFrist', function(){
			$('#fromSlide').html(item);
		});

		/* Thêm phần tử tiếp theo */
		$(document).on('click', '.btnAddItem', function(){
			$('.btnAddItem').parent().remove();
			$('#fromSlide').append(item);
		});

		/* Xóa phần tử */
		$(document).on('click', '.btnRemove', function(){
			$(this).parent().remove();
		});

		/* Xóa phần tử */
		$(document).on('click', '.img-thumbnail', function(){
			openKCFinderAlbum($(this));
		});
	});
</script>