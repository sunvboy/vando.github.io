<section class="content-header">
	<h1>Thêm sản phẩm mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('products/backend/products/view');?>">Sản phẩm</a></li>
		<li class="active"><a href="<?php echo site_url('products/backend/products/create');?>">Thêm sản phẩm mới</a></li>
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
						<li><a href="#tab-combo" data-toggle="tab">Sản phẩm khuyến mãi</a></li>
						<li><a href="#tab-size" data-toggle="tab">Size</a></li>
						<li><a href="#tab-colorvenus" data-toggle="tab">Màu sắc</a></li>
						<li><a href="#tab-seo" data-toggle="tab">Seo</a></li>
						<li class="hide"><a href="#tab-color" data-toggle="tab">Phiên bản sản phẩm</a></li>
						<li class="hide"><a href="#tab-ship" data-toggle="tab">Vận chuyển</a></li>
						<li class="hide"><a href="#tab-aff" data-toggle="tab">Triết khấu Affiliate</a></li>
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
									<label class="col-sm-2 control-label tp-text-left">Mã sản phẩm</label>
									<div class="col-sm-10">
										<?php echo form_input('code', html_entity_decode(set_value('code')), 'class="form-control " placeholder="Mã sản phẩm"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label tp-text-left">Chủ đề</label>
									<div class="col-sm-10">
										<?php echo form_dropdown('tagsid[]', $this->BackendTags_Model->Dropdown('products'), (isset($tagsid)?$tagsid:NULL), 'class="form-control select2" multiple="multiple" style="width: 100%;" id="tagsid"');?>
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
									<label class="col-sm-2 control-label tp-text-left">Mô tả <br>(Descriptions)</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description')), 'id="txtContent2" class="ckeditor-description" placeholder="Mô tả vắn tắt" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>

							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-seo">
							<div class="box-body">
								<div class="form-group hidden-xs">
									<label class="col-sm-2 control-label tp-text-left">Tiêu đề SEO</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_title', set_value('meta_title'), 'class="form-control" placeholder="Tiêu đề SEO"');?>
									</div>
								</div>
								<div class="form-group hidden-xs">
									<label class="col-sm-2 control-label tp-text-left">Từ khóa SEO</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_keyword', set_value('meta_keyword'), 'class="form-control" placeholder="Từ khóa SEO"');?>
									</div>
								</div>
								<div class="form-group hidden-xs">
									<label class="col-sm-2 control-label tp-text-left">Mô tả SEO</label>
									<div class="col-sm-10">
										<?php echo form_textarea('meta_description', set_value('meta_description'), 'class="form-control" placeholder="Mô tả SEO" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div>
						</div>
						<?php echo $this->load->view('products/backend/products/combo/create')?>
						<div class="tab-pane" id="tab-color">
							<div class="box-body">
								<div class="callout callout-danger">Thêm mới thuộc tính giúp sản phẩm có nhiều lựa chọn, như kích cỡ hay màu sắc.</div>
								<div class="clearfix hide">
									<a class="btn btn-success add_version_type" data-flag="1">Thêm thuộc tính sản phẩm</a>
								</div>
								<div id="list-verstion-product-attr">
									<table class="table-reponsive table table_attr" style="margin: 20px 0 0">
										<thead>
											<tr>
												<th width="150px">Tên thuộc tính</th>
												<th>Giá trị</th>
												<th width="50px"></th>
											</tr>
										</thead>
										<tbody>
											<?php $option = $this->input->post('option'); $j = 0 ?>
											<?php if(isset($option) && is_array($option) && count($option)){ ?>
												<?php foreach($option['title'] as $key => $val){ ?>
													<?php if(empty($option['title'][$key])) continue; ?>
													<tr>
														<td>
															<input class="form-control" type="text" name="option[title][]" value="<?php echo $option['title'][$key] ?>">
															<input type="hidden" class="attrid" value="<?php echo $option['stt'][$key] ?>">
														</td>
														<td><input type="text" name="option[attribute][]" value="<?php echo $option['attribute'][$key] ?>" class="form-control tags"></td>
														<td><a class="btn btn-default btn-trash-attr"><i class="fa fa-trash"></i></a></td>
													</tr>
													<?php $j++; ?>
												<?php } ?>
												<tr class="<?php echo (($j != 3) ? '' : 'hide') ?>">
													<td colspan="3"><a class="btn btn-default btn-add-attr">Thêm thuộc tính khác</a></td>
												</tr>
												<script>
													$(document).ready(function(){
														$('.tags').tagsinput({
														    confirmKeys: [13, 44],
															maxTags: 20
														});
													});
												</script>
											<?php } ?>
										</tbody>
									</table>
									<div class="result_attr_form"></div>
									<script>
										$(document).ready(function(){	
											load_attr_arr();										
											// Attribute 
											$('.add_version_type').click(function(){
												var flag = $(this).attr('data-flag');
												if (flag == 1) {
													load_attr_html();
													$('#list-verstion-product-attr').removeClass('hide');
													$(this).removeClass('btn-success').addClass('btn-warning').attr('data-flag', 0).html('Hủy thuộc tính sản phẩm')
												}else{
													$('#list-verstion-product-attr').addClass('hide');
													$(this).removeClass('btn-warning').addClass('btn-success').attr('data-flag', 1).html('Thêm thuộc tính sản phẩm')
												}
											});
											$(document).on('click', '.btn-trash-attr', function(){
												$(this).parent().parent().parent().find('.hide').removeClass('hide');
												$(this).parent().parent().remove();
												load_attr_arr();
											});

											$(document).on('click', '.btn-add-attr', function(){
												load_attr_html();
												$(this).parent().parent().remove();
												return false;
											});
											function load_value_attr(){
												var attr = '';
												$('#list-verstion-product-attr .attrid').each(function(){
													var divHtml = $(this).val();
		    										attr += divHtml + '-';
												})
												return attr.slice(0, -1);
											}
											function load_attr_html(){
												var formURL = 'products/ajax/products/add_attribute';
												var attrid = load_value_attr();
												$.post(formURL, {attrid: attrid}, function(data){
													$('#list-verstion-product-attr .table_attr tbody').append(data);
												});
												return false;
											}

											$(document).on('change', '.tags', function(){
												load_attr_arr();
												load_attr_arr_count();
											});
											function load_attr_arr_count(){
												$('#list-verstion-product-attr .tags').each(function(){
													var value = $(this).val();
													var count = value.split(",").length;
													$(this).parent().parent().find('.count_attr').val(count);
												});
											}
											function load_attr_arr(){
												if($('#list-verstion-product-attr .table_attr tbody').html().trim() == ''){
													$('#list-verstion-product-attr').addClass('hide');
												}
												var attr_arr = '';
												var formURL = 'products/ajax/products/load_attribute';
												$('#list-verstion-product-attr .tags').each(function(){
													var divHtml = $(this).val();
		    										attr_arr += divHtml + '-';
												})
												$.post(formURL, {attr_arr: attr_arr.slice(0, -1)}, function(data){
													$('.result_attr_form').html(data);
												});
												return false;
											}
										})
									</script>
								</div>
							</div>
						</div>
						<?php echo $this->load->view('products/backend/products/affiliate/create');?>
						<?php echo $this->load->view('products/backend/products/ship/create');?>
						<div class="tab-pane" id="tab-album">
							<div class="box-body">
								<div class="form-group" id="fromSlide">
								<?php $album = $this->input->post('album'); if(isset($album) && is_array($album) && count($album)){ ?>
								<?php foreach($album['images'] as $key => $val){ if(empty($album['images'][$key])) continue;?>
								<div class="col-sm-3 slideItem">
								<div class="thumb"><img src="<?php echo $album['images'][$key];?>" class="img-thumbnail img-responsive"/></div>
								<input type="hidden" name="album[images][]" value="<?php echo $album['images'][$key];?>" />
								<button type="button" class="btn btnRemove add1 btn-danger pull-right">Xóa bỏ</button>
								</div>
								<?php } ?>
								<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add1 pull-left">+</button></div>
								<?php } ?>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-size">
							<div class="box-body">
								<div class="form-group" id="fromSlideSize">
									<?php $albumsize = $this->input->post('albumsize'); if(isset($albumsize) && is_array($albumsize) && count($albumsize)){ ?>
										<?php foreach($albumsize['title'] as $key => $val){ ?>
											<div class="col-sm-3 slideItem">
												<input type="text" name="albumsize[title][]" value="<?php echo $albumsize['title'][$key];?>" class="form-control title" placeholder="Tên size" />
												<input type="text" name="albumsize[saleoff][]" value="<?php echo $albumsize['saleoff'][$key];?>" class="form-control title" placeholder="Giá size" />
												<input type="text" name="albumsize[chieucao][]" value="<?php echo $albumsize['chieucao'][$key];?>" class="form-control title" placeholder="Chiều cao" />
												<input type="text" name="albumsize[cannang][]" value="<?php echo $albumsize['cannang'][$key];?>" class="form-control title" placeholder="Cân nặng" />
												<input type="text" name="albumsize[sodovong][]" value="<?php echo $albumsize['sodovong'][$key];?>" class="form-control title" placeholder="Số đo vòng" />
												<button type="button" class="btn btnRemove2 add2 btn-danger pull-right">Xóa bỏ</button>
											</div>
										<?php } ?>
										<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add2 pull-left">+</button></div>
									<?php } ?>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-colorvenus">
							<div class="box-body">
								<div class="form-group" id="fromSlideColor">
									<?php $albumcolor = $this->input->post('albumcolor'); if(isset($albumcolor) && is_array($albumcolor) && count($albumcolor)){ ?>
										<?php foreach($albumcolor['images'] as $key => $val){ if(empty($albumcolor['images'][$key])) continue;?>
											<div class="col-sm-3 slideItem">
												<input type="text" name="albumcolor[title][]" value="<?php echo $albumcolor['title'][$key];?>" class="form-control title " placeholder="Mã màu" />
												<div class="thumb"><img src="<?php echo $albumcolor['images'][$key];?>" class="img-thumbnail img-responsive"/></div>
												<input type="hidden" name="albumcolor[images][]" value="<?php echo $albumcolor['images'][$key];?>" />
												<?php for($i=0;$i<=9;$i++){?>
													<div class="thumb"><img src="<?php echo $albumcolor['images_'.$i.''][$key];?>" class="img-thumbnail img-responsive"/></div>
													<input type="hidden" name="albumcolor[images_<?php echo $i?>][]" value="<?php echo $albumcolor['images_'.$i.''][$key];?>" />
												<?php }?>
												<button type="button" class="btn btnRemove3 add3 btn-danger pull-right">Xóa bỏ</button>
											</div>
										<?php } ?>
										<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add3 pull-left">+</button></div>
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
										<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (isset($avatar) && !empty($avatar))?$avatar: 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;object-fit: scale-down;height: 200px;" /></div>
										<?php echo form_input('images', set_value('images'), 'class="form-control"  placeholder="Ảnh đại diện"  ');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Giá tiền</label>
									<div class="col-sm-12">
										<?php echo form_input('price', set_value('price'), 'class="form-control price" placeholder="Giá tiền"');?>
									</div>
									<label class="col-sm-12 control-label tp-text-left">Giá bán ra</label>
									<div class="col-sm-12">
										<?php echo form_input('saleoff', set_value('saleoff'), 'class="form-control price-saleoff" placeholder="Giá tiền sau khuyến mãi"');?>
									</div>
								</div>

								<div class="hide">
									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">Trọng lượng (kg)</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_input('weight', set_value('weight'), 'class="form-control" placeholder="Trọng lượng sản phẩm đơn vị tính kilogram"');?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">SKU</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_input('sku', set_value('sku'), 'class="form-control" placeholder="Mã SKU"');?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">Số lượng còn lại</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_input('quantity', set_value('quantity'), 'class="form-control" placeholder="Sợ lượng sản phẩm trong kho"');?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">Số lượng đã bán</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_input('count_order', set_value('count_order'), 'class="form-control" placeholder="Sợ lượng sản phẩm đã bán"');?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-12 control-label tp-text-left">Thời gian khuyến mãi</label>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<?php echo form_input('time', set_value('time', ''), 'class="form-control datetime" id="time" placeholder="Thời gian khuyến mãi" disabled');?>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="checkbox">
											<input name="timing" id="render-product-time" type="checkbox" class="tpInputCheckboxTime hide" value="" />
											<label class="tpLabelTime" style="width: 168px;">
												Thời gian khuyến mãi
											</label>
										</div>
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
														<?php echo form_radio('cataloguesid', $key, set_radio('cataloguesid', $key, FALSE),'class="check-box"');?>
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
									<label class="col-sm-12 control-label tp-text-left">Xuất bản</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
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
	$(document).ready(function(){
		
		$('.tpLabelTime').click(function(event) {
			$('#render-product-time').trigger('click');
			$(this).toggleClass('checked');
			if($(this).hasClass('checked')){
				$('#time').removeAttr('disabled');
			}else{
				$('#time').attr('disabled', true);
			}
			event.preventDefault();
		});
		var time = '<?php echo (isset($time) && $time == 1) ? 1 : 0; ?>';
		if(time == 1){
			$('.tpLabelTime').trigger('click');
		}
	
	});
</script>
<script type="text/javascript">
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
	
	$(document).ready(function(){
		var time;
		$('.price, .price-saleoff').on('keyup', function(event) {
			var price = $(this).val();
			var _this = $(this);
			var url = 'products' +'/ajax/'+ 'products' + '/convert_commas_price';
			clearTimeout(time);
			time = setTimeout(function() {
				$.post(url, {price: price}, function(data){
					_this.val(data);
				});
			}, 300);
		});
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
			var formURL = 'products/ajax/products/attributes';
			$.post(formURL, {
				post: postData,}, 
				function(data){
					$('.attribute-list').html(data);
				});
			return false;
		});
	});
</script>
<script>
	var itemcolor;
	itemcolor = '<div class="col-sm-3 slideItem">';
	itemcolor = itemcolor + '<input type="text" name="albumcolor[title][]" value="" class="form-control title " placeholder="Mã màu"/>';
	itemcolor = itemcolor + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
	itemcolor = itemcolor + '<input type="hidden" name="albumcolor[images][]" value="" />';
	<?php for($i=0;$i<=9;$i++){?>
	itemcolor = itemcolor + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
	itemcolor = itemcolor + '<input type="hidden" name="albumcolor[images_<?php echo $i?>][]" value="" />';
	<?php }?>
	itemcolor = itemcolor + '<button type="button" class="btn btnRemove remove3 btn-danger pull-right">Xóa bỏ</button>';
	itemcolor = itemcolor + '</div>';
	itemcolor = itemcolor + '<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add3 pull-left">+</button></div>';
	if($('#fromSlideColor').html().trim() == ''){
		$('#fromSlideColor').append(itemcolor);
	}
	/* Thêm phần tử tiếp theo */
	$(document).on('click', '.btnAddItem.add3', function(){
		$('.btnAddItem.add3').parent().remove();
		$('#fromSlideColor').append(itemcolor);
	});
	/* Xóa phần tử */
	$(document).on('click', '.btnRemove.remove3', function(){
		$(this).parent().remove();
	});
</script>
<script>
	var itemsize;
	itemsize = '<div class="col-sm-3 slideItem">';
	itemsize = itemsize + '<input type="text" name="albumsize[title][]" value="" class="form-control title" placeholder="Tên size" /><input type="text" name="albumsize[saleoff][]" value="" class="form-control title" placeholder="Giá size" /><input type="text" name="albumsize[chieucao][]" value="" class="form-control title" placeholder="Chiều cao" /><input type="text" name="albumsize[cannang][]" value="" class="form-control title" placeholder="Cân nặng" /><input type="text" name="albumsize[sodovong][]" value="" class="form-control title" placeholder="Số đo vòng" />';
	itemsize = itemsize + '<button type="button" class="btn btnRemove remove2 btn-danger pull-right">Xóa bỏ</button>';
	itemsize = itemsize + '</div>';
	itemsize = itemsize + '<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add2 pull-left">+</button></div>';
	if($('#fromSlideSize').html().trim() == ''){
		$('#fromSlideSize').append(itemsize);
	}
	/* Thêm phần tử tiếp theo */
	$(document).on('click', '.btnAddItem.add2', function(){
		$('.btnAddItem.add2').parent().remove();
		$('#fromSlideSize').append(itemsize);
	});

	/* Xóa phần tử */
	$(document).on('click', '.btnRemove.remove2', function(){
		$(this).parent().remove();
	});
</script>
<script type="text/javascript">
	$(window).load(function(){
		var item;
		item = '<div class="col-sm-3 slideItem">';
		item = item + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
		item = item + '<input type="hidden" name="album[images][]" value="" />';
		item = item + '<button type="button" class="btn btnRemove remove1 btn-danger pull-right">Xóa bỏ</button>';
		item = item + '</div>';
		item = item + '<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add1 pull-left">+</button></div>';
		if($('#fromSlide').html().trim() == ''){
			$('#fromSlide').append(item);
		}


		/* Thêm phần tử tiếp theo */
		$(document).on('click', '.btnAddItem.add1', function(){
			$('.btnAddItem.add1').parent().remove();
			$('#fromSlide').append(item);
		});

		/* Xóa phần tử */
		$(document).on('click', '.btnRemove.remove1', function(){
			$(this).parent().remove();
		});

		load_chapter_page();

		/*----------------     Thêm bài giảng         ----------------*/
	
		function load_chapter(stt = 1, page = 1){
			item2 = '<div class="chuong_box">';
				item2 = item2 + '<div class="box box-success direct-chat direct-chat-primary">';
					item2 = item2 + '<div class="box-header with-border">';
						item2 = item2+'<h3 class="box-title">Phần <span>' + (stt + 1) + '</span>: <input type="text" name="chapter[title][]" class="input_hide" value="" placeholder="Tiêu đề chương click để sửa"><input type="hidden" name="chapter[count][]" class="count" value="1"></h3>';
						item2 = item2 + '<div class="box-tools pull-right">';
							item2 = item2 + '<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>';
						item2 = item2 + '</div>';
					item2 = item2 + '</div>';
					item2 = item2 + '<div class="box-body" style="display: block;">';
						item2 = item2 + '<div class="form-group stock">';
							item2 = item2 + '<div class="col-sm-3 Item_baigiang">';
								item2 = item2 + '<div class="relative">';
									item2 = item2 + '<span>Bài '+(page + 1)+': </span>';
									item2 = item2 + '<input type="text" name="lesson[title][]" value="" class="form-control title" placeholder="Tên bài giảng" />';
								item2 = item2 + '</div>';
								item2 = item2 + '<input type="text" name="lesson[time][]" value="" class="form-control time" placeholder="Thời lượng" />';
								item2 = item2 + '<textarea name="lesson[description][]" cols="40" rows="5" class="form-control description" placeholder="Mã nhúng video bài giảng học thử"></textarea>';
								item2 = item2 + '<textarea name="lesson[source][]" cols="40" rows="5" class="form-control" placeholder="Mã nhúng video bài giảng"></textarea>';
								item2 = item2 + '<button type="button" class="btn Deletepage btn-danger pull-right" data-number="1">Xóa bỏ</button>';
							item2 = item2 + '</div>';
						item2 = item2 + '</div>';
						item2 = item2 + '<div class="item-line text-right">';
							item2 = item2 + '<button type="button" class="btn btnDelchuong btn-danger" data-number="' + (stt + 1) + '">Xóa chương này</button>';
							item2 = item2 + '<button type="button" class="btn btnAddpage btn-success" data-page="' + (page + 1) + '">Thêm bài mới cho chương này</button>';
						item2 = item2 + '</div>';
					item2 = item2 + '</div>';
				item2 = item2 + '</div>';
			item2 = item2 + '</div>';
			item2 = item2 + '<div class="item-line text-left">';
				item2 = item2 + '<button type="button" class="btn btnAddchuong btn-success" data-number="' + (stt + 1) + '" data-page="' + (page + 1) + '">Thêm chương mới</button>';
			item2 = item2 + '</div>';
			return item2;
		}

		function load_page(page = 1){
			item3 = '<div class="col-sm-3 Item_baigiang">';
				item3 = item3 + '<div class="relative">';
					item3 = item3 + '<span>Bài '+(page + 1)+': </span>';
					item3 = item3 + '<input type="text" name="lesson[title][]" value="" class="form-control title" placeholder="Tên bài giảng" />';
				item3 = item3 + '</div>';
				item3 = item3 + '<input type="text" name="lesson[time][]" value="" class="form-control time" placeholder="Thời lượng" />';
				item2 = item2 + '<textarea name="lesson[description][]" cols="40" rows="5" class="form-control description" placeholder="Mã nhúng video bài giảng học thử"></textarea>';
				item3 = item3 + '<textarea name="lesson[source][]" cols="40" rows="5" class="form-control description" placeholder="Mã nhúng video bài giảng"></textarea>';
				item3 = item3 + '<button type="button" class="btn Deletepage btn-danger pull-right" data-page="'+(page + 1)+'">Xóa bỏ</button>';
			item3 = item3 + '</div>';
			return item3;
		}

		function load_chapter_page(){
			var i = 1;
			var j = 1;
			$('#from-itinerary .chuong_box').each(function () {
				var chapt = i++;
				// Đánh số lại các Chapter
		        $(this).find('.box-title span').html(chapt);
		        $(this).find('.btnDelchuong').attr('data-number', chapt);
		        $('#from-itinerary').find('.btnAddchuong').attr('data-number', chapt);
		        // Đánh số lại các page
		        // var jj = j + 1;
		        $(this).find('.Item_baigiang').each(function(){
		        	var page = j++;
		        	$(this).find('.relative span').html('Bài '+page+': ');
			        $(this).find('.Deletepage').attr('data-page', page);
			        $('#from-itinerary').find('.btnAddchuong').attr('data-number', chapt);
			        $(this).parent().next().find('.btnAddpage').attr('data-page', page);
		        	$('#from-itinerary').find('.btnAddchuong').attr('data-page', page);
		        });
		        
		    });
		}

		/* Thêm chương tiếp theo */
		$(document).on('click', '.btnAddchuong', function(){
			var chap = parseInt($(this).attr('data-number'));
			var page = parseInt($(this).attr('data-page'));
			var item2 = load_chapter(chap, page);
			$(this).parent().remove();
			$('#from-itinerary').append(item2);
		});

		/* Xóa chương  */
		$(document).on('click', '.btnDelchuong', function(){
			$(this).parent().parent().parent().parent().remove();
			load_chapter_page();
		});

		/* Thêm bài giảng vào chương  */
		$(document).on('click', '.btnAddpage', function(){
			var page = parseInt($(this).attr('data-page'));
			var count = parseInt($(this).parent().parent().parent().find('.count').val());
			$(this).parent().parent().parent().find('.count').attr('value', (count + 1));
			var item3 = load_page(page);
			$(this).attr('data-page', (page + 1));
			$('.btnAddchuong').attr('data-page', (page + 1));
			$(this).parent().parent().find('.stock').append(item3);
			load_chapter_page();
		});

		/* Xóa bài giảng vào chương  */
		$(document).on('click', '.Deletepage', function(){
			var count = parseInt($(this).parent().parent().parent().parent().parent().find('.count').val());
			$(this).parent().parent().parent().parent().parent().find('.count').attr('value', (count - 1));
			$(this).parent().remove();
			load_chapter_page();
		});

	});
</script>
<style>
	.slideItem{
		height: auto;
	}
	.form-line, .reviewItem{margin-bottom: 10px;}
	.chuong_box .box-body{padding: 20px;}
	.Item_baigiang .title, .Item_baigiang .time, .Item_baigiang .description{border-bottom: 0}
	.Deletepage{margin-top: 10px;width: 100%;}
	.btnAddpage {margin-left: 5px;}
	.input_hide {border: 0;padding: 0;font-size: 15px;height: 20px;width: calc(100% - 120px);}
	.box-title {width: calc(100% - 30px);float: left;}
	.col-sm-3.Item_baigiang {margin-bottom: 15px;}
	.relative {position: relative;}
	.relative span {position: absolute;line-height: 32px;padding-left: 10px;background-color: #fff;top: 1px;left: 1px;}
	.relative .form-control.title {padding-left: 50px;}
	.bootstrap-tagsinput {width: 100%;}
	.box_result_content table td span:not(:last-child) {
	    position: relative;
	    padding-right: 15px;
	}
	.box_result_content table td span:nth-child(1){color: #29bc94;}
	.box_result_content table td span:nth-child(3){color: #763eaf;}
	.box_result_content table td span:nth-child(2){color: #ff9517;}
	.box_result_content table td span:not(:last-child):before{
		content: '';
		width: 3px;
		height: 3px;
		position: absolute;
		right: 5px;
		top: 50%;
		background-color: #333;
 	 	border-radius: 100%;
		-webkit-transform: translate(0, -50%);
		   -moz-transform: translate(0, -50%);
		    -ms-transform: translate(0, -50%);
		     -o-transform: translate(0, -50%);
		        transform: translate(0, -50%);
	}
</style>