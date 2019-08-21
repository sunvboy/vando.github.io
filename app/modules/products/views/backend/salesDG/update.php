<section class="content-header">
	<h1>Cập nhập</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('products/backend/SalesDG/view');?>">Danh sách sale</a></li>
		<li class="active"><a href="<?php echo site_url('products/backend/SalesDG/create');?>">Thêm mới</a></li>
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
						<li><a href="#tab-combo" data-toggle="tab">Sản phẩm được sale</a></li>
						<li><a href="#tab-seo" data-toggle="tab">Seo</a></li>
					</ul>
					<div class="tab-content">
						<?php $error = validation_errors(); echo !empty($error)?'<div class="box-body"><div class="callout callout-danger">'.$error.'</div></div><!-- /.box-body -->':'';?>
						<div class="tab-pane active" id="tab-info">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Tiêu đề</label>
									<div class="col-sm-10">
										<?php echo form_input('title', html_entity_decode(set_value('title', $DetailProducts['title'])), 'class="form-control form-static-link" placeholder="Tiêu đề"');?>
									</div>
									<div class="col-sm-2 hide"><span class="btn btn-primary create-static-links">Tạo liên kết tĩnh</span></div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Xuất bản</label>

									<div class="col-sm-10">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailProducts['publish']), 'class="form-control" style="width: 100%;"');?>
									</div>

								</div>

								<div class="form-group" id="scheduleStartDate">
									<div class="col-sm-2 control-label tp-text-left">Thời gian</div>
									<div class="col-md-10">
										<div class="row">
											<div class="col-sm-6">
												<div class="mb10">Ngày bắt đầu</div>
												<div class="input-group">
													<div class="input-group-btn">
														<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
													</div>
													<input type="text" name="time_start" class="form-control datetimemonthsale change_time" value="<?php echo $DetailProducts['time_start'] ?>">
												</div>
											</div>
											<div class="col-sm-6 mb15">
												<div class="mb10">Ngày kết thúc</div>
												<div class="input-group">
													<div class="input-group-btn">
														<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
													</div>
													<?php  $time = date('Y/m/d H:i:s');?>
													<input type="text" name="time_end" class="form-control datetimemonthsale change_time" value="<?php echo $DetailProducts['time_end'] ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label tp-text-left">Liên kết</label>
									<label class="col-sm-3 control-label tp-text-left"><?php echo base_url(); ?></label>
									<div class="col-sm-5">
										<?php echo form_input('canonical', set_value('canonical', $DetailProducts['canonical']), 'class="form-control canonical" placeholder="Liên kết"');?>
										<?php echo form_hidden('canonical_original', $DetailProducts['canonical']);?>
									</div>
									<div class="col-sm-2" style="line-height: 34px;font-weight: 600;">.html</div>
								</div>






							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->

						<div class="tab-pane" id="tab-combo">
							<div class="box-body">
								<div class="callout callout-danger">Thêm danh sách sản phẩm được sale</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Sản phẩm</label>
									<div class="col-sm-10">
										<input type="text" id="key" class="form-control" placeholder="Tiêu đề sản phẩm">
										<input type="hidden" name="id_combo" id="id_arr" value="<?php echo $DetailProducts['id_combo'] ?>">
										<div id="result_product">
											<div class="panl-body">
												
											</div>
										</div>
									</div>
								</div>
								<div id="list-combo-product">
									<table class="table" id="diagnosis-list">
										<thead>
											<tr>
												<th>Tiêu đề</th>
												<th>#</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php  
												$result = $this->Autoload_Model->_get_where(array(
													'select' => 'id, title, images, price, saleoff, saleoff_tmp',
													'table' => 'products',
													'where' => array('publish' =>1, 'trash' => 0),
													'where_in' => explode('-', $DetailProducts['id_combo']),
													'where_in_field' => 'id',
													'order_by' => 'id desc, order asc'
												),TRUE);
												if(isset($result) && is_array($result) && count($result)) {
													foreach ($result as $key => $val) {
														$image = getthumb($val['images']);
														$price = $val['price'];
								                        $saleoff = $val['saleoff'];
														if ($price > 0) {
									                        $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).' đ<span>';
									                    }else{
									                        $pri_old  = '';
									                    }
									                    if ($saleoff > 0) {
									                        $pri_sale = str_replace(',', '.', number_format($saleoff)).' đ';
									                    }else{
									                        $pri_sale  = 'Liên hệ';
									                    }
														echo '<tr>';
															echo '<td style="width:650px;">';
																echo '<article class="article-view-1 text-left">';
																	echo '<div class="col-sm-2 thumb">';
																		echo '<div class="tp-cover"><img  src="'.$image.'" alt="'.$val['title'].'" /></div>';
																	echo '</div>';
																	echo '<div class="col-sm-10">';
																		echo '<div class="title">'.$val['title'].'</div>';
																		echo '<div class="meta">';
																			echo $pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '');
																		echo '</div>';
																	echo '</div>';
																echo '</article>';
															echo '</td>';
															echo '<td class="text-right">';
																echo '<div class="btn btn-default data-active" data-id="'.$val['id'].'">';
																	echo '<span class="fa fa-trash"></span>';
																echo '</div>';
															 echo '</td>';
														echo '</tr>';
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>


						</div>
						<div class="tab-pane" id="tab-seo">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Tiêu đề SEO</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_title', set_value('meta_title', $DetailProducts['meta_title']), 'class="form-control" placeholder="Tiêu đề SEO"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Từ khóa SEO</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_keyword', set_value('meta_keyword', $DetailProducts['meta_keyword']), 'class="form-control" placeholder="Từ khóa SEO"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label tp-text-left">Mô tả SEO</label>
									<div class="col-sm-10">
										<?php echo form_textarea('meta_description', set_value('meta_description', $DetailProducts['meta_description']), 'class="form-control" placeholder="Mô tả SEO" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div>
						</div>
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
									<?php echo form_input('saleoff', set_value('saleoff', str_replace(',','.',number_format($DetailProducts['saleoff']))), 'class="form-control price" placeholder="Giá tiền"');?>
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
<script>
	$(document).on('click', '.img-thumbnail', function(){
		openKCFinderAlbum($(this));
	});
	$('.price, .price-saleoff').on('keyup', function(event) {
		var price = $(this).val();
		var _this = $(this);
		var url = 'products' +'/ajax/'+ 'products' + '/convert_commas_price';
		time = setTimeout(function() {
			$.post(url, {price: price}, function(data){
				_this.val(data);
			});
		}, 0);
	});
	$(document).ready(function(){
		if($('#list-combo-product tbody').html().trim() == ''){
			$('#list-combo-product').hide();
		}else{
			$('#list-combo-product').show();
		}
		var time;
		$('#result_product').hide();
		$('#key').on('keyup', function() {
			var keyword = $(this).val();
			var id_arr = $('#id_arr').val();
			var prdid = '<?php echo $DetailProducts['id'] ?>';
			var numberKey = keyword.length;
			if(numberKey >= 0) {
				clearTimeout(time);
				time = setTimeout(function() {
					$.ajax({
						url: 'products/ajax/SaleDG/search',
						method: 'POST',
						dataType: 'JSON',
						data: {keyword: keyword, id: id_arr, prdid: prdid},
						complete: function(data) {
							var datajson = JSON.parse(data.responseText);
							$('#result_product').show();
							$('#result_product .panl-body').html(datajson.html);
						}
					});
				}, 0);
			}else {
				$('#result_product').hide();
			}
		});
		$(document).on('click', '.add-item', function(){
			var item_ = '<tr>' + $(this).html() + '</tr>';
			var id = $(this).attr('data-id');
			$('#list-combo-product table tbody').append(item_);
			$('#list-combo-product').show();
			$(this).remove();
			if($('#result_product .panl-body tbody').html().trim() == ''){
				$('#result_product').hide();
			}
			load_item_combo();

		});
		$(document).on('click', '.data-active', function(){
			$(this).parent().parent().remove();
			load_item_combo();
		});
		function load_item_combo(){
			var outputText = '';
			$('#list-combo-product .data-active').each(function(){
				var divHtml = $(this).attr('data-id');
				outputText += divHtml + '-';
			});
			$('#id_arr').attr('value', outputText.slice(0, -1));
		}
	})
</script>
<style>
	#result_product{position: relative}
	#result_product .panl-body {
		max-height: 200px;
		overflow: hidden;
		position: absolute;
		background-color: #fff;
		box-shadow: 1px 1px 3px #dedede;
		right: 0;
		width: 100%;
		overflow-y: auto;z-index: 9;
	}
	#result_product .panl-body .text-right{display: none;}
	#result_product .article-view-1 .meta,
	#list-combo-product .article-view-1 .meta,
	#list-verstion-product .article-view-1 .meta{
		color: #f00;
		font-weight: bold;
		font-size: 13px;
	}
	#result_product .article-view-1 .meta .span-gia,
	#list-combo-product .article-view-1 .meta .span-gia,
	#list-verstion-product .article-view-1 .meta .span-gia {
		margin-left: 10px;
		font-weight: normal;
		text-decoration: line-through;
		color: #999;
		font-size: 11px;
	}
	.add-item{cursor: pointer}
	#diagnosis-list th, #diagnosis-list td {
		text-align: left;
	}
</style>