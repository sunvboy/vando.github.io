<section class="content-header">
	<h1>Thêm sản phẩm mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('products/backend/products/view');?>">sản phẩm</a></li>
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
						<li><a href="#tab-combo" data-toggle="tab">Sản phẩm khuyến mại</a></li>
						<li><a href="#tab-size" data-toggle="tab">Size</a></li>
						<li><a href="#tab-colorvenus" data-toggle="tab">Màu sắc</a></li>
						<li><a href="#tab-seo" data-toggle="tab">Seo</a></li>
						<li class="hide"><a href="#tab-attr" data-toggle="tab">Thuộc tính sản phẩm</a></li>
						<li class="hide"><a href="#tab-ship" data-toggle="tab">Vận chuyển</a></li>
						<li class="hide"><a href="#tab-aff" data-toggle="tab">Triết khấu Affiliate</a></li>
					</ul>
					<div class="tab-content">
						<?php $error = validation_errors(); echo !empty($error)?'<div class="box-body"><div class="callout callout-danger">'.$error.'</div></div><!-- /.box-body -->':'';?>
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Tiêu đề</label>
									<div class="col-sm-8">
										<?php echo form_input('title', html_entity_decode(set_value('title', $DetailProducts['title'])), 'class="form-control form-static-link" placeholder="Tiêu đề"');?>
									</div>
									<div class="col-sm-2"><span class="btn btn-primary create-static-links">Tạo liên kết tĩnh</span></div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Liên kết</label>
									<label class="col-sm-3 control-label tp-text-left"><?php echo base_url(); ?></label>
									<div class="col-sm-5">
										<?php echo form_input('canonical', set_value('canonical', $DetailProducts['canonical']), 'class="form-control canonical" placeholder="Liên kết"');?>
										<?php echo form_hidden('canonical_original', $DetailProducts['canonical']);?>
									</div>
									<div class="col-sm-2" style="line-height: 34px;font-weight: 600;">.html</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Mã sản phẩm</label>
									<div class="col-sm-10">
										<?php echo form_input('code', html_entity_decode(set_value('code', $DetailProducts['code'])), 'class="form-control " placeholder="Mã sản phẩm"');?>
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
												<label class="col-sm-2 control-label tp-text-left"><?php echo $val['title']; ?></label>
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
									<?php }else{ ?>
										<?php if(isset($attribute_catalogues) && is_array($attribute_catalogues) && count($attribute_catalogues)){ ?>
										<?php if(isset($_static_cat_checked['attribute_catalogue']) && is_array($_static_cat_checked['attribute_catalogue']) && count($_static_cat_checked['attribute_catalogue'])){ ?>
											<?php foreach($attribute_catalogues as $key => $val){ ?>
											<?php if(in_array($val['id'], $_static_cat_checked['attribute_catalogue']) == FALSE) continue; ?>
											<div class="form-group">
												<label class="col-sm-2 control-label tp-text-left"><?php echo $val['title']; ?></label>
												<div class="col-sm-10">
													<div class="checkbox">
													<?php if(isset($val['attributes']) && is_array($val['attributes']) && count($val['attributes'])){ ?>
													<?php foreach($val['attributes'] as $keyAttr => $valAttr){ ?>
													<?php 
														if(isset($_static_cat_checked['attribute'][$val['keyword']]) && in_array($valAttr['id'], $_static_cat_checked['attribute'][$val['keyword']]) == false) continue;
													?>
														<label class="tpInputLabel" style="width: 180px;">
															<input name="attr[<?php echo $valAttr['id'] ?>]" type="checkbox" class="tpInputCheckbox" <?php echo ((in_array($valAttr['id'],$attribute_checked)) ? 'checked' : ''); ?>  value="<?php  echo $valAttr['id'] ?>"  />
															<span><?php echo $valAttr['title']; ?></span>
														</label>
													<?php } ?>
													<?php } ?>
													</div>
												</div>
											</div>
											<?php } ?>
										<?php }} ?>
									<?php } ?>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Mô tả <br>(Descriptions)</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description', $DetailProducts['description'])), 'id="txtContent2" class="ckeditor-description" placeholder="Mô tả vắn tắt" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>


							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-album">
							<div class="box-body">
								<div class="form-group" id="fromSlide">
								<?php 
									$slide = $this->input->post('album');
									$album = '';
									if(isset($slide) && is_array($slide) && count($slide)){
										foreach($slide['images'] as $key => $val){
											$album[$key]['images'] = $val;
											$album[$key]['title'] = $slide['title'][$key];
											$album[$key]['description'] = $slide['description'][$key];
										}
									}else{
										$album = json_decode($DetailProducts['albums'], TRUE);
									}
								?>
								<?php if(isset($album) && is_array($album) && count($album)){ ?>
								<?php foreach($album as $key => $val){ if(empty($album[$key]['images'])) continue;?>
								<div class="col-sm-3 slideItem">
								<div class="thumb"><img src="<?php echo $album[$key]['images'];?>" class="img-thumbnail img-responsive"/></div>
								<input type="hidden" name="album[images][]" value="<?php echo $album[$key]['images'];?>" />
								<button type="button" class="btn btnRemove remove1 btn-danger pull-right">Xóa bỏ</button>
								</div>
								<?php } ?>
								<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add1 pull-left">+</button></div>
								<?php } ?>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-seo">
							<div class="box-body">
								<div class="form-group hidden-xs">
									<label class="col-sm-2 control-label tp-text-left">Tiêu đề SEO</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_title', set_value('meta_title', $DetailProducts['meta_title']), 'class="form-control" placeholder="Tiêu đề SEO"');?>
									</div>
								</div>
								<div class="form-group hidden-xs">
									<label class="col-sm-2 control-label tp-text-left">Từ khóa SEO</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_keyword', set_value('meta_keyword', $DetailProducts['meta_keyword']), 'class="form-control" placeholder="Từ khóa SEO"');?>
									</div>
								</div>
								<div class="form-group hidden-xs">
									<label class="col-sm-2 control-label tp-text-left">Mô tả SEO</label>
									<div class="col-sm-10">
										<?php echo form_textarea('meta_description', set_value('meta_description', $DetailProducts['meta_description']), 'class="form-control" placeholder="Mô tả SEO" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div>
						</div>
						<?php echo $this->load->view('products/backend/products/combo/update')?>
						<div class="tab-pane" id="tab-color">
							<div class="box-body">
								<div class="callout callout-danger">Thêm danh sách màu cho sản phẩm</div>
								<div class="clearfix">
									<a class="btn btn-primary add_version" title="Thêm phiên bản sản phẩm">Thêm mới phiên bản sản phẩm</a>
								</div>
								<div id="list-verstion-product"></div>
							</div>
						</div>

						<?php echo $this->load->view('products/backend/products/attr/update');?>
						<?php echo $this->load->view('products/backend/products/ship/update');?>
						<?php echo $this->load->view('products/backend/products/affiliate/update');?>
						<div class="tab-pane" id="tab-colorvenus">
							<div class="box-body">
								<div class="form-group" id="fromSlideColor">
									<?php
									$slidecolor = $this->input->post('albumcolor');
									$albumcolor = '';
									if(isset($slidecolor) && is_array($slidecolor) && count($slidecolor)){
										foreach($slidecolor['images'] as $key => $val){
											$albumcolor[$key]['images'] = $val;
											$albumcolor[$key]['title'] = $slidecolor['title'][$key];
											$albumcolor[$key]['images_0'] = $slidecolor['images_0'][$key];
											$albumcolor[$key]['images_1'] = $slidecolor['images_1'][$key];
											$albumcolor[$key]['images_2'] = $slidecolor['images_2'][$key];
											$albumcolor[$key]['images_3'] = $slidecolor['images_3'][$key];
											$albumcolor[$key]['images_4'] = $slidecolor['images_4'][$key];
											$albumcolor[$key]['images_5'] = $slidecolor['images_5'][$key];
											$albumcolor[$key]['images_6'] = $slidecolor['images_6'][$key];
											$albumcolor[$key]['images_7'] = $slidecolor['images_7'][$key];
											$albumcolor[$key]['images_8'] = $slidecolor['images_8'][$key];
											$albumcolor[$key]['images_9'] = $slidecolor['images_9'][$key];
										}
									}else{
										$albumcolor = json_decode($DetailProducts['color'], TRUE);
									}
									?>
									<?php if(isset($albumcolor) && is_array($albumcolor) && count($albumcolor)){ ?>
										<?php foreach($albumcolor as $key => $val){ if(empty($albumcolor[$key]['images'])) continue;?>
											<div class="col-sm-3 slideItem">
												<input type="text" name="albumcolor[title][]" value="<?php echo $albumcolor[$key]['title'];?>" class="form-control title "/>

												<div class="thumb"><img src="<?php echo $albumcolor[$key]['images'];?>" class="img-thumbnail img-responsive"/></div>
												<input type="hidden" name="albumcolor[images][]" value="<?php echo $albumcolor[$key]['images'];?>" />
												<?php for($i=0;$i<=9;$i++){?>
													<div class="thumb"><img src="<?php echo (!empty($albumcolor[$key]['images_'.$i.'']))? $albumcolor[$key]['images_'.$i.'']:'templates/not-found.png'; ?>" class="img-thumbnail img-responsive"/></div>
													<input type="hidden" name="albumcolor[images_<?php echo $i?>][]" value="<?php echo $albumcolor[$key]['images_'.$i.''];?>" />
												<?php }?>

												<button type="button" class="btn btnRemove remove3 btn-danger pull-right">Xóa bỏ</button>
											</div>
										<?php } ?>
										<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add3 pull-left">+</button></div>
									<?php } ?>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-size">
							<div class="box-body">
								<div class="form-group" id="fromSlideSize">
									<?php
									$slidesize = $this->input->post('albumsize');
									$albumsize = '';
									if(isset($slidesize) && is_array($slidesize) && count($slidesize)){
										foreach($slidesize['title'] as $key => $val){
											$albumsize[$key]['title'] = $val;
											$albumsize[$key]['saleoff'] = $slidesize['saleoff'][$key];
											$albumsize[$key]['chieucao'] = $slidesize['chieucao'][$key];
											$albumsize[$key]['cannang'] = $slidesize['cannang'][$key];
											$albumsize[$key]['sodovong'] = $slidesize['sodovong'][$key];
										}
									}else{
										$albumsize = json_decode($DetailProducts['size'], TRUE);
									}
									?>
									<?php if(isset($albumsize) && is_array($albumsize) && count($albumsize)){ ?>
										<?php foreach($albumsize as $key => $val){ if(empty($albumsize[$key]['title'])) continue;?>



											<div class="col-sm-3 slideItem">
												<input type="text" name="albumsize[title][]" value="<?php echo $albumsize[$key]['title'];?>" class="form-control title"/>
												<input type="text" name="albumsize[saleoff][]" value="<?php echo $albumsize[$key]['saleoff'];?>" class="form-control title"/>
												<input type="text" name="albumsize[chieucao][]" value="<?php echo $albumsize[$key]['chieucao'];?>" class="form-control title"/>
												<input type="text" name="albumsize[cannang][]" value="<?php echo $albumsize[$key]['cannang'];?>" class="form-control title"/>
												<input type="text" name="albumsize[sodovong][]" value="<?php echo $albumsize[$key]['sodovong'];?>" class="form-control title"/>
												<button type="button" class="btn btnRemove remove2 btn-danger pull-right">Xóa bỏ</button>
											</div>
										<?php } ?>
										<div class="col-sm-3 slideItem"><button type="button" class="btn btnAddItem add2 pull-left">+</button></div>
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
									<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (!empty($DetailProducts['images']))? $DetailProducts['images']:'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;object-fit: scale-down;height: 200px;"/></div>
									<?php echo form_input('images', set_value('images', $DetailProducts['images']), 'class="form-control"  placeholder="Ảnh đại diện" onclick="openKCFinder(this)" ');?>
								</div>
							</div>


							
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Giá tiền</label>
								<div class="col-sm-12">
									<?php echo form_input('price', set_value('price', str_replace(',','.',number_format($DetailProducts['price']))), 'class="form-control price" placeholder="Giá tiền"');?>
								</div>
								<label class="col-sm-12 control-label tp-text-left">Giá bán ra</label>
								<div class="col-sm-12">
									<?php echo form_input('saleoff', set_value('saleoff', str_replace(',','.',number_format($DetailProducts['saleoff']))), 'class="form-control price-saleoff" placeholder="Giá tiền sau khuyến mãi"');?>
								</div>
							</div>
							
							<div class="hide">
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Trọng lượng (kg)</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('weight', set_value('weight', $DetailProducts['weight']), 'class="form-control" placeholder="Trọng lượng sản phẩm đơn vị tính kilogram"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">SKU</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('sku', set_value('sku', $DetailProducts['sku']), 'class="form-control" placeholder="Mã SKU"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Số lượng</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('quantity', set_value('quantity', $DetailProducts['quantity']), 'class="form-control" placeholder="Sợ lượng sản phẩm trong kho"');?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Số lượng đã bán</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('count_order', set_value('count_order', $DetailProducts['count_order']), 'class="form-control" placeholder="Sợ lượng sản phẩm đã bán"');?>
									</div>
								</div>

								<?php $time = gmdate('Y-m-d H:i:s', time() + 7*3600);  ?>
								<div class="form-group">
									<label class="col-sm-12 control-label tp-text-left">Thời gian khuyến mãi</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo form_input('time', set_value('time', gettime($DetailProducts['saleoff_time'])), 'class="form-control datetime" id="time" placeholder="Thời gian khuyến mãi" '.(($DetailProducts['saleoff_time'] != '0000-00-00 00:00:00' && $DetailProducts['saleoff_time'] > $time) ? '' : 'disabled').'');?>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="checkbox">
										<input name="timing" id="render-product-time" type="checkbox" class="tpInputCheckboxTime hide" value="1" />
										<label class="tpLabelTime <?php echo ($DetailProducts['saleoff_time'] != '0000-00-00 00:00:00' && $DetailProducts['saleoff_time'] > $time) ? 'checked' : ''; ?>" style="width: 168px;">
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
													<?php echo form_radio('cataloguesid', $key, set_radio('cataloguesid', $key, FALSE), (isset($DetailProducts['cataloguesid']) && $DetailProducts['cataloguesid'] == $key)?'checked="checked" class="check-box"':'class="check-box"');?>
												</label>
												<label for="" class="catalogue">
												<?php echo form_checkbox('catalogue[]', $key, set_checkbox('catalogue[]', $key, FALSE), (isset($catalogue) && count($catalogue) && is_array($catalogue) && in_array($key,$catalogue))?'checked="checked"': '');?>
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
									<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailProducts['publish']), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Vị trí</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_input('order', set_value('order', $DetailProducts['order']), 'class="form-control" placeholder="Vị trí"');?>
								</div>
							</div>
						</div>
					</div><!-- /.tab-pane -->
				</div><!-- /.tab-content -->
			</div><!-- /.col -->
		</form>
	</div> <!-- /.row -->
</section><!-- /.content -->
<div id="modal-form" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="max-width:768px;width: 100%;">
      	<div class="modal-content">
      		<form action="<?php echo site_url('products/ajax/products/add_vesions') ?>" method="post" class="form-horizontal" id="form_versions">
	      		<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Thêm phiên bản mới</h4>
		      	</div>
		        <div class="modal-body">
	        		<div class="nav-tabs-custom" style="margin-bottom: 0;box-shadow: none;">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-info-modal" data-toggle="tab">Thông tin cơ bản</a></li>
							<li><a href="#tab-attr-modal" data-toggle="tab">Thuộc tính</a></li>
							<li><a href="#tab-album-modal" data-toggle="tab">Album ảnh</a></li>
							<li><a href="#tab-ship-modal" data-toggle="tab">Vận chuyển</a></li>
							<li><a href="#tab-aff-modal" data-toggle="tab">Triết khấu Affiliate</a></li>
						</ul>
						<div class="tab-content">
							<div class="error callout callout-danger"></div>
							<div class="tab-pane active" id="tab-info-modal">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-12 control-label tp-text-left">Tên phiên bản</label>
											<div class="col-sm-12">
												<input type="text" name="title" class="form-control title" readonly="" value="<?php echo $DetailProducts['title'].' - ' ?>" placeholder="Tên phiên bản sản phẩm, vd: S, M, L, Đỏ, Đen">
											</div>
											<div class="col-sm-6">
												<div class="row">
													<label class="col-sm-12 control-label tp-text-left">Số lượng</label>
													<div class="col-sm-12">
														<input type="text" name="quantity" class="form-control" placeholder="Số lượng sp hiện có">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="row">
													<label class="col-sm-12 control-label tp-text-left">Đã bán</label>
													<div class="col-sm-12">
														<input type="text" name="count_order" class="form-control" placeholder="Số lượng sp đã bán">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="row">
													<label class="col-sm-12 control-label tp-text-left">Giá bán</label>
													<div class="col-sm-12">
														<input type="text" name="price" class="form-control price" placeholder="Giá bán">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="row">
													<label class="col-sm-12 control-label tp-text-left">Giá khuyến mãi</label>
													<div class="col-sm-12">
														<input type="text" name="saleoff" class="form-control price-saleoff" placeholder="Giá khuyến mại">
													</div>
												</div>
											</div>
											<label class="col-sm-12 control-label tp-text-left">Videos giới thiệu</label>
											<div class="col-sm-12">
												<input type="text" name="source" class="form-control source" placeholder="Videos giới thiệu" onclick="openKCFinder(this, files)">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-12 control-label tp-text-left">Ảnh đại diện</label>
											<div class="col-sm-12">
												<div class="avatar" style="cursor: pointer;">
													<img src="<?php echo 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;object-fit: scale-down;height: 220px;"/>
												</div>
												<input type="hidden" class="images_" name="images" value="">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-attr-modal">
								<div class="box-body"></div>
							</div>
							<div class="tab-pane" id="tab-album-modal">
								<div class="box-body">
									<div class="form-group" id="fromVertion">
										<div class="col-sm-4 vertionItem">
											<button type="button" class="btn btnAddVertion add_ver">+</button>
										</div>									
									</div>
								</div><!-- /.box-body -->
							</div>
							<div class="tab-pane" id="tab-ship-modal">
								<div class="box-body">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-12 control-label tp-text-left">Tại cửa hàng</label>
											</div>
											<div class="form-group">
												<div class="col-sm-12">
													<input type="text" value="0" readonly="" class="form-control shipcode" placeholder="Phí vận chuyển" />
												</div>
											</div>
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-12 control-label tp-text-left">Nội thành HN</label>
											</div>
											<div class="form-group">
												<div class="col-sm-12">
													<input type="text" value="" class="form-control shipcode" placeholder="Phí vận chuyển" />
												</div>
											</div>
										</div>
										
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-sm-12 control-label tp-text-left">COD các tỉnh</label>
											</div>
											<div class="form-group">
												<div class="col-sm-12">
													<input type="text" value="" class="form-control shipcode" placeholder="Phí vận chuyển" />
												</div>
											</div>
										</div>
									</div>
									<script>
										$(document).ready(function(){
											load_shipcode_modal();
											$('#form_versions .shipcode').keyup(function(){
												load_shipcode_modal();
											})
											function load_shipcode_modal(){
												var outputText = '';
												$('#form_versions .shipcode').each(function(){
													var divHtml = $(this).val();
													outputText += divHtml + '+-+';
												})
												$('#form_versions #shipcode_ver').attr('value', outputText.slice(0, -3));
											}
										})
									</script>
								</div>
							</div>
							<div class="tab-pane" id="tab-aff-modal">
								<div class="box-body">
									<div class="form-group">
										<label class="col-sm-2 control-label tp-text-left">Giá thu về</label>
										<div class="col-sm-10">
											<?php echo form_dropdown('type_aff', $this->configbie->data('type_aff'), set_value('type_aff', 0), 'class="form-control chose_aff select2" style="width: 100%;" data-show="list-aff-modal" data-remove-name="remove"');?>
										</div>
									</div>
									<div id="list-aff-modal"></div>
									<input type="hidden" id="level_aff" value="">
									<input type="hidden" id="count_aff" value="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" value="" id="albums_ver">
					<input type="hidden" value="" id="shipcode_ver">
					<input type="hidden" name="parentid " value="<?php echo $DetailProducts['id'] ?>">
			        <button type="submit" class="btn btn-primary pull-left">Thêm mới</button>
			        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			  	</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="messageModal" role="dialog">
    <div class="modal-dialog modal-sm">
      	<div class="modal-content">
      		<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Thống báo từ hệ thống</h4>
	      	</div>
	        <div class="modal-body">
				<div class="message-alert callout callout-danger" style="margin-bottom: 0;">Bạn có muốn thực sự xóa bản ghi này khỏi hệ thống</div>
	        </div>
	        <div class="modal-footer">
		        <button type="button" class="btn delete-version-now btn-primary pull-left">Xóa ngay</button>
		        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Hủy</button>
		  	</div>
      	</div>
    </div>
</div>

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog" style="max-width:768px;width: 100%;">
      	<div class="modal-content">
      		<form action="<?php echo site_url('products/ajax/products/edit_vesions_now') ?>" method="post" class="form-horizontal" id="form_versions_edit">
	      		<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Chỉnh sửa bản ghi</h4>
		      	</div>
		        <div class="modal-body">
					
		        </div>
		        <div class="modal-footer">
			        <button type="submit" class="btn edit-version-now btn-primary pull-left">Cập nhật ngay</button>
			        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Hủy</button>
			  	</div>
			</form>
      	</div>
    </div>
</div>

<div class="modal fade" id="modal-form-attr" role="dialog">
    <div class="modal-dialog" style="max-width:768px;width: 100%;">
      	<div class="modal-content">
      		<form action="<?php echo site_url('products/ajax/products/edit_vesions_attr') ?>" method="post" class="form-horizontal" id="form_versions_attr">
	      		<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Chỉnh sửa thuộc tính</h4>
		      	</div>
		        <div class="modal-body">
					
		        </div>
		        <div class="modal-footer">
			        <button type="submit" class="btn edit-version-now btn-primary pull-left">Cập nhật ngay</button>
			        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Hủy</button>
			  	</div>
			</form>
      	</div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change', '.chose_aff', function(){
			var type = $(this).val();
			var show = $(this).attr('data-show');
			var remove = $(this).attr('data-remove-name');
			$.post('<?php echo site_url("products/ajax/products/aff_type");?>', {type: type}, function(data){
				var json = JSON.parse(data);
				$('#'+show+'').html(json.html);
				if (remove == 'remove') {
					$('#'+show+' input').attr('name', '');
					load_count_aff_value();load_count_aff_value_edit();
				}
	        });
	        return false;
		});
		$(document).on('keyup', '#list-aff-modal .count', function(){
			load_count_aff_value();
		});
		function load_count_aff_value(){
			var outputText = '';
			$('#list-aff-modal .count').each(function(){
				var divHtml = $(this).val();
				outputText += divHtml + '+-+';
			})
			$('#tab-aff-modal #count_aff').attr('value', outputText.slice(0, -3));

			var outputText2 = '';
			$('#list-aff-modal .level').each(function(){
				var divHtml2 = $(this).val();
				outputText2 += divHtml2 + '+-+';
			})
			$('#tab-aff-modal #level_aff').attr('value', outputText2.slice(0, -3));
		}

        $('#form_versions .error').hide();
        var uri = $('#form_versions').attr('action');
        $('#form_versions').on('submit',function(){
            var postData = $(this).serializeArray();
            $.post(uri, {post: postData, title: $('#form_versions .title').val(), video: $('#form_versions .source').val(), albums: $('#form_versions #albums_ver').val(), shipcode: $('#form_versions #shipcode_ver').val(), level: $('#form_versions_edit #level_aff_edit').val(), count: $('#form_versions_edit #count_aff_edit').val()},
            function(data){
                var json = JSON.parse(data);
                $('#form_versions .error').show();
                if(json .error.length){
                    $('#form_versions .error').removeClass('callout-success').addClass('callout-danger');
                    $('#form_versions .error').html('').html(json.error);
                }else{
                    $('#form_versions .error').removeClass('callout-danger').addClass('callout-success');
                    $('#form_versions .error').html('').html('Thêm phiên bản mới cho sản phẩm thành công!.');
                    $('#form_versions').trigger("reset");
                    // Xóa ảnh trong form modal
                    $('#form_versions .avatar img').attr('src', 'templates/not-found.png')
                    $('#form_versions .images_').attr('value', '')
                    remove_albums_value();
                    load_album_vesion();
                    setTimeout(function(){ 
                    	load_version_products(); 
                    	$('#modal-form').modal('hide');
                    }, 2000);
                }
            });
            return false;
        });

        var uri_edit = $('#form_versions_edit').attr('action');
        $('#form_versions_edit').on('submit',function(){
            var postData = $(this).serializeArray();
            $.post(uri_edit, {post: postData, title: $('#form_versions_edit .title').val(), albums: $('#form_versions_edit #albums_ver_edit').val(), video: $('#form_versions_edit .source').val(), id: $('#form_versions_edit #id_ver_edit').val(), shipcode: $('#form_versions_edit #shipcode_ver_edit').val(), level: $('#form_versions_edit #level_aff_edit').val(), count: $('#form_versions_edit #count_aff_edit').val()},
            function(data){
                var json = JSON.parse(data);
                $('#form_versions_edit .error').show();
                if(json .error.length){
                    $('#form_versions_edit .error').removeClass('callout-success').addClass('callout-danger');
                    $('#form_versions_edit .error').html('').html(json.error);
                }else{
                    $('#form_versions_edit .error').removeClass('callout-danger').addClass('callout-success');
                    $('#form_versions_edit .error').html('').html('Cập nhật phiên bản mới cho sản phẩm thành công!.');
                    setTimeout(function(){ 
                    	load_version_products(); 
                    	$('#editModal').modal('hide');
                    }, 2000);
                }
            });
            return false;
        });

        $(document).on('keyup', '#list-aff-modal-edit .count', function(){
			load_count_aff_value_edit();
		});
		function load_count_aff_value_edit(){
			var outputText = '';
			$('#list-aff-modal-edit .count').each(function(){
				var divHtml = $(this).val();
				outputText += divHtml + '+-+';
			})
			$('#tab-aff-modal-edit #count_aff_edit').attr('value', outputText.slice(0, -3));

			var outputText2 = '';
			$('#list-aff-modal-edit .level').each(function(){
				var divHtml2 = $(this).val();
				outputText2 += divHtml2 + '+-+';
			})
			$('#tab-aff-modal-edit #level_aff_edit').attr('value', outputText2.slice(0, -3));
		}

        $(document).on('click', '.edit-version', function(){
			var id = $(this).attr('data-id');
			$.post('<?php echo site_url("products/ajax/products/edit_version_products");?>', {id: id}, function(data){
				$('#editModal').modal('toggle');
				$('#form_versions_edit .error').hide();
				var json = JSON.parse(data);
				if(json.error == false){
					$('#editModal .modal-body').html(json.message);
				}else{
					$('#editModal .modal-body').html(json.message);
				}
				load_album_vesion_edit();
				load_ship_vesion_edit();
				load_count_aff_value_edit();
	        });
		});

        $(document).on('keyup', '#form_versions_edit .shipcode', function(){
			load_ship_vesion_edit();
		})
		function load_ship_vesion_edit(){
			var outputText = '';
			$('#form_versions_edit .shipcode').each(function(){
				var divHtml = $(this).val();
				outputText += divHtml + '+-+';
			})
			$('#form_versions_edit #shipcode_ver_edit').attr('value', outputText.slice(0, -3));
		}

        $(document).on('click', '.delete-version', function(){
			var id = $(this).attr('data-id');
			$('#messageModal .delete-version-now').attr('data-id', id);
			$('#messageModal').modal('toggle');
		});
		$(document).on('click', '.delete-version-now', function(){
			$('#messageModal').modal('hide');
			var id = $(this).attr('data-id');
			$.post('<?php echo site_url("products/ajax/products/delete_version_products");?>', {id: id}, function(data){
				$('#alertModal').modal('toggle');
				var json = JSON.parse(data);
				if(json.error == false){
					$('#alertModal .message-alert').html(json.message);
				}else{
					$('#alertModal .message-alert').html(json.message);
				}
		 	 	setTimeout(function(){ 
                	load_version_products(); 
                	$('#alertModal').modal('hide');
                }, 2000);
	        });
	        return false;
		});

    });

	function load_version_products(){
		var parentid = '<?php echo $DetailProducts['id'] ?>';
		$.post('<?php echo site_url("products/ajax/products/load_version_products");?>', {parentid: parentid}, function(data){
		 	var json = JSON.parse(data);
            $('.box_result_content').html(json.html);
        });
        return false;
	}
	function remove_albums_value(){
		var item_ver;
		item_ver = '<div class="col-sm-4 vertionItem">';
		item_ver = item_ver + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
		item_ver = item_ver + '<input type="hidden" class="img-ver" value="" />';
		// item_ver = item_ver + '<input type="text" value="" class="form-control title-ver" placeholder="Đường dẫn videos" onclick="openKCFinder(this, files)"/>';
		// item_ver = item_ver + '<textarea cols="40" rows="4" class="form-control description" readonly="" placeholder="Nếu có videos giới thiệu sản phẩm, dán đường dẫn lên trên ô trên. Thứ tự ưu tiên sẽ là Videos -> ảnh"></textarea>';
		item_ver = item_ver + '<button type="button" class="btn btnRemove remove_ver btn-danger pull-right">Xóa bỏ</button>';
		item_ver = item_ver + '</div>';
		item_ver = item_ver + '<div class="col-sm-4 vertionItem"><button type="button" class="btn btnAddVertion add_ver pull-left">+</button></div>';
		$('#fromVertion').html('').append(item_ver);
	}

	$(window).load(function(){

		var item_ver;
		item_ver = '<div class="col-sm-4 vertionItem">';
		item_ver = item_ver + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
		item_ver = item_ver + '<input type="hidden" class="img-ver" value="" />';
		// item_ver = item_ver + '<input type="text" value="" class="form-control title-ver" placeholder="Đường dẫn videos" onclick="openKCFinder(this, files)"/>';
		// item_ver = item_ver + '<textarea cols="40" rows="4" class="form-control description" readonly="" placeholder="Nếu có videos giới thiệu sản phẩm, dán đường dẫn lên trên ô trên. Thứ tự ưu tiên sẽ là Videos -> ảnh"></textarea>';
		item_ver = item_ver + '<button type="button" class="btn btnRemove remove_ver btn-danger pull-right">Xóa bỏ</button>';
		item_ver = item_ver + '</div>';
		item_ver = item_ver + '<div class="col-sm-4 vertionItem"><button type="button" class="btn btnAddVertion add_ver pull-left">+</button></div>';

		if($('#fromVertion').html().trim() == ''){
			$('#fromVertion').append(item_ver);
		}

		/* Thêm phần tử tiếp theo */
		$(document).on('click', '.add_ver', function(){
			$('.add_ver').parent().remove();
			$('#fromVertion').append(item_ver);
		});

		/* Xóa phần tử */
		$(document).on('click', '.btnRemove.remove_ver', function(){
			$(this).parent().remove();
			load_album_vesion();
		});


		var item_ver_edit;
		item_ver_edit = '<div class="col-sm-4 vertionItem">';
		item_ver_edit = item_ver_edit + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
		item_ver_edit = item_ver_edit + '<input type="hidden" class="img-ver" value="" />';
		// item_ver_edit = item_ver_edit + '<input type="text" value="" class="form-control title-ver" placeholder="Đường dẫn videos" onclick="openKCFinder(this, files)"/>';
		// item_ver_edit = item_ver_edit + '<textarea cols="40" rows="4" class="form-control description" readonly="" placeholder="Nếu có videos giới thiệu sản phẩm, dán đường dẫn lên trên ô trên. Thứ tự ưu tiên sẽ là Videos -> ảnh"></textarea>';
		item_ver_edit = item_ver_edit + '<button type="button" class="btn btnRemove remove_ver1 btn-danger pull-right">Xóa bỏ</button>';
		item_ver_edit = item_ver_edit + '</div>';
		item_ver_edit = item_ver_edit + '<div class="col-sm-4 vertionItem"><button type="button" class="btn btnAddVertion add_ver1 pull-left">+</button></div>';

		/* Thêm phần tử tiếp theo */
		$(document).on('click', '.add_ver1', function(){
			$('.add_ver1').parent().remove();
			$('#fromVertionEdit').append(item_ver_edit);
		});

		/* Xóa phần tử */
		$(document).on('click', '.btnRemove.remove_ver1', function(){
			$(this).parent().remove();
			load_album_vesion_edit();
		});


	});
</script>
<script type="text/javascript">
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum1($(this));
		
	});
	function openKCFinderAlbum1(field, type, result) {
	    window.KCFinder = {
	        callBack: function(url) {
	            field.attr('src', url);
	            field.parent().next().val(url);
	            load_album_vesion();
	            load_album_vesion_edit();
	            window.KCFinder = null;
	        }
	    };

		if(typeof(type) == 'undefined'){
			type = 'images';
		}
	    window.open('<?php echo BASE_URL; ?>plugins/kcfinder-master/browse.php?type='+type+'&dir=images/public', 'kcfinder_image',
	        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
	        'resizable=1, scrollbars=0, width=1080, height=800'
	    );
		return false;
	}
	function load_album_vesion(){
		var outputText = '';
		$('#form_versions .img-ver').each(function(){
			var divHtml = $(this).val();
			outputText += divHtml + '+-+';
		})
		$('#form_versions #albums_ver').attr('value', outputText.slice(0, -3));
	}

	function load_album_vesion_edit(){
		var outputText = '';
		$('#form_versions_edit .img-ver').each(function(){
			var divHtml = $(this).val();
			outputText += divHtml + '+-+';
		})
		$('#form_versions_edit #albums_ver_edit').attr('value', outputText.slice(0, -3));
	}

	$(document).ready(function(){
		// $('.add_version_type').click(function(){
		// 	$('#modal-form-attr').modal('toggle');
		// });
		$('.add_version').click(function(){
			$('#modal-form').modal('toggle');
		});
		var time;
		$(document).on('keyup', '.price, .price-saleoff', function(){
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
	$(window).load(function(){

		var item;
		item = '<div class="col-sm-3 slideItem">';
		item = item + '<div class="thumb"><img src="templates/backend/images/not-found.png" class="img-thumbnail img-responsive"/></div>';
		item = item + '<input type="hidden" name="album[images][]" value="" class="form-control title "/>';
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
<style>
	.btnAddVertion{
	    height: 200px;
	    border: 1px solid #dddddd;
	    background: none;
	    width: 100%;
	    font-size: 60px;
	    color: rgba(162, 162, 162, 0.3);
	    border-radius: 0;
	}
	.vertionItem .thumb img {
	    height: 200px;
	    width: 100%;
	    object-fit: scale-down;
	    border-radius: 0;
	}
	.vertionItem .title-ver,.vertionItem .description{border-top: 0;}
	.vertionItem{margin-bottom: 20px;}
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
	.slideItem{
		height: auto;
	}
</style>