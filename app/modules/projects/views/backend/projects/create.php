<section class="content-header">
	<h1>Thêm dự án mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('projects/backend/projects/view');?>">dự án</a></li>
		<li class="active"><a href="<?php echo site_url('projects/backend/projects/create');?>">Thêm dự án mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form class="hidden-form" style="display:none;" id="cat-form" method="post" action="">
			<input type="text" value="" id="str"/>
		</form>
		<form class="form-horizontal" method="post" action="">
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
						<li><a href="#tab-album" data-toggle="tab">Album ảnh</a></li>
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
									
									
									<div class="form-group" style="display:none;">
										<label class="col-sm-2 control-label tp-text-left">Chủ đề</label>
										<div class="col-sm-10">
											<?php echo form_dropdown('tagsid[]', $this->BackendTags_Model->Dropdown(), (isset($tagsid)?$tagsid:NULL), 'class="form-control select2" multiple="multiple" style="width: 100%;" id="tagsid"');?>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Địa chỉ</label>
										<div class="col-sm-10">
											<?php echo form_input('address', set_value('address'), 'class="form-control" id="address" placeholder=""');?>
										</div>
									</div>
									<script>
										var cityid = <?php echo (int)$this->input->post('cityid') ?>;
										var districtid = <?php echo (int)$this->input->post('districtid') ?>;
										var wardid = <?php echo (int)$this->input->post('wardid') ?>;
										var projectid = <?php echo (int)$this->input->post('projectid') ?>;
									</script>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Tỉnh / Thành Phố</label>
										<?php 
											$location_dropdown = $this->BackendProjects_Model->location_dropdown(array(
												'where' => array('parentid' => 0)
											));
										?>
										<div class="col-sm-4">
											<?php echo form_dropdown('cityid', $location_dropdown, set_value('cityid', 0), 'class="form-control location" style="width: 100%;" id="cityid" data-return="district" data-flag="0"');?>
										</div>
										<label class="col-sm-2 control-label tp-text-left">Quận / Huyện</label>
										<div class="col-sm-4">
											<select id="district" class="form-control location" name="districtid" data-return="ward" data-flag="0"><option value="0">[Chọn]</option></select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Phường / Xã</label>
										<div class="col-sm-4">
											<select id="ward" class="form-control location" name="wardid" data-flag="0"><option value="0">[Chọn]</option></select>
										</div>
										<label class="col-sm-2 control-label tp-text-left">Dự án</label>
										<div class="col-sm-4">
											<select id="project" class="form-control" name="projectid"><option value="0">[Chọn]</option></select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Diện tích</label>
										<div class="col-sm-4">
											<?php echo form_input('area', set_value('area',0), 'class="form-control " placeholder=""');?>
										</div>
										<label class="col-sm-2 control-label tp-text-left">Hướng</label>
										<div class="col-sm-4">
											<?php echo form_dropdown('floor', $this->configbie->data('floor'), set_value('floor', 0), 'class="form-control" style="width: 100%;"'); ?>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Giá tiền</label>
										<div class="col-sm-2">
											<?php echo form_input('price', set_value('price',0), 'class="form-control price" placeholder=""'); ?>
										</div>
										<div class="col-sm-4">
											<?php echo form_dropdown('measure', $this->configbie->data('measure'), set_value('measure', 0), 'class="form-control" style="width: 100%;"');?>
										</div>
										<div class="col-sm-4">
											<?php echo form_dropdown('type', $this->configbie->data('type'), set_value('type', 2), 'class="form-control" style="width: 100%;"');?>
										</div>
									</div>
								
									<div class="attribute-list">
										<?php if(isset($attr) && is_array($attr) && count($attr)){ ?>
											<?php if(isset($attribute_catalogues) && is_array($attribute_catalogues) && count($attribute_catalogues)){ ?>
												<?php foreach($attribute_catalogues as $key => $val){ ?>
												<?php if(in_array($val['id'], $cat_checked['attribute_catalogue']) == FALSE) continue; ?>
												<div class="form-group">
													<label class="col-sm-2 control-label"><?php echo $val['title']; ?></label>
													<div class="col-sm-10">
														<div class="checkbox">
														<?php if(isset($val['attributes']) && is_array($val['attributes']) && count($val['attributes'])){ ?>
														<?php foreach($val['attributes'] as $keyAttr => $valAttr){ ?>
														<?php 
															if(isset($cat_checked['attribute'][$val['keyword']]) && in_array($valAttr['id'], $cat_checked['attribute'][$val['keyword']]) == false) continue;
														?>
															<label class="tpInputLabel" style="width: 168px;">
																<input name="attr[<?php echo $valAttr['id'] ?>]" type="checkbox" class="tpInputCheckbox" <?php echo ((isset($attr) && in_array($valAttr['id'], $attr)) ? 'checked' : '') ?>  value="<?php  echo $valAttr['id'] ?>"  />
																<span><?php echo $valAttr['title']; ?></span>
															</label>
														<?php } ?>
														<?php } ?>
														</div>
													</div>
												</div>
												<?php } ?>
											<?php } ?>
										<?php } ?>
									</div>
									
									
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Thông tin liên hệ</label>
										<div class="col-sm-10">
											<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description')), 'id="txtDescription" class="" placeholder="Thông tin liên hệ" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Nội dung</label>
										<div class="col-sm-10">
											<?php echo form_textarea('content', htmlspecialchars_decode(set_value('content')), 'id="txtContent" class="ckeditor-description" placeholder="Nội dung" style="width: 100%; height: 350px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
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
										<?php echo form_input('images', set_value('images'), 'class="form-control"  placeholder="Ảnh đại diện"  ');?>
									</div>
								</div>
								<?php $code = code_generator('projects'); ?>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Mã dự án</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('code', set_value('code', $code), 'class="form-control" placeholder="" readonly="true"');?>
									</div>
								</div>
								<div class="form-group"><!-- Filter /  -->
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
													<label for="" class="catalogueid hide">
														<?php echo form_radio('att', $key, set_radio('att', $key, FALSE),'class="check-box"');?>
													</label>
													<label for="" class="">
														<?php echo form_radio('cataloguesid', $key, set_radio('cataloguesid', $key, FALSE),'class=""');?>
													</label>
													<label for="" class="catalogue">
													<?php echo form_checkbox('catalogue[]', $key, set_checkbox('catalogue[]', $key, FALSE), ((isset($catalogue) && in_array($key,$catalogue))?'checked="checked"': ''));?>
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
									<label class="col-sm-12 control-label tp-text-left">Ngày hết hạn</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('outofdate', set_value('outofdate', gmdate('Y-m-d H:i', time() + 7*3600)), 'class="form-control datetimepicker" placeholder="" readonly="true"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Bản đồ</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_textarea('map', htmlspecialchars_decode(set_value('map')), 'id="txtMap" class="" placeholder="Bản đồ" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
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
										<?php echo form_dropdown('ishome', $this->configbie->data('ishome'), set_value('ishome', -1), 'class="form-control" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Vip</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('isaside', $this->configbie->data('isaside'), set_value('isaside', -1), 'class="form-control" style="width: 100%;"');?>
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
	
	$(document).ready(function(){
		var time;
		// $('.price, .price-saleoff').on('keyup', function(event) {
		// 	var price = $(this).val();
		// 	var _this = $(this);
		// 	var url = 'projects' +'/ajax/'+ 'projects' + '/convert_commas_price';
		// 	clearTimeout(time);
		// 	time = setTimeout(function() {
		// 		$.post(url, {price: price}, function(data){
		// 			_this.val(data);
		// 		});
		// 	}, 300);
		// });
		// $('.attribute-list').hide();
		
		$('.check-box').change(function(){
			var str = '';
			$('.check-box').each(function(){
				if($(this).val() != 0  && $(this).prop('checked') == true){
					str = str + $(this).val() + '-';
				}
			});
			if(str.length > 0){
				str = str.substr(0, str.length - 1);
				$('#str').val(str);
			}else{
				$('#str').val('');
			}
			$('#cat-form').trigger('submit');
		});
		
		$('#cat-form').on('submit',function(){
			var postData = $('#str').val();
			var formURL = 'projects/ajax/projects/attributes';
			$.post(formURL, {
				post: postData,}, 
				function(data){
					$('.attribute-list').html(data);
				});
			return false;
		});
	});
</script>
<script type="text/javascript">
$(window).load(function(){
	var item;
	item = '<div class="col-sm-3 slideItem">';
	item = item + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
	item = item + '<input type="hidden" name="album[images][]" value="" />';
	item = item + '<input type="text" name="album[title][]" value="" class="form-control title" placeholder="Tên ảnh"/>';
	item = item + '<textarea name="album[description][]" cols="40" rows="10" class="form-control description" placeholder="Mô tả ảnh"></textarea>';
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