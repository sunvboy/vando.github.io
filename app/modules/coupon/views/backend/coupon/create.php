<section class="content-header">
	<h1>Thêm Thêm mới khuyến mãi</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('coupon/backend/coupon/view');?>">Khuyến mãi</a></li>
		<li class="active"><a href="<?php echo site_url('coupon/backend/coupon/create');?>">Thêm mới</a></li>
	</ol>
</section>
<section class="content">
	<form class="form-horizontal" method="post" action="">
		<div class="row">
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
								<div class="box-form-center">
									<div class="form-group">
										<div class="col-sm-12 text-bold mb10">Mã khuyến mãi</div>
										<div class="col-sm-8">
											<?php echo form_input('couponCode', set_value('couponCode'), 'class="form-control" id="couponCode" placeholder="Ví dụ: COUPON10%"');?>
										</div>
										<div class="col-sm-4"><span class="btn btn-primary create-coupon">Tạo mã ngẫu nhiên</span></div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<div class="form-group">
												<div class="col-sm-12 text-bold mb10">Tùy chọn khuyến mãi</div>
												<div class="col-sm-12">
													<?php echo form_dropdown('couponType', $this->configbie->data('couponType'), 0, 'class="form-control select2" style="width: 100%;" id="couponType"');?>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="col-sm-12 text-bold mb10">Giá trị khuyến mãi</div>
												<div class="col-sm-12">
													<div class="input-group">
														<?php echo form_input('couponTypeValue', 0, 'class="form-control couponTypeValue"');?>
														<div class="input-group-btn" id="show_result">
															<button type="button" class="btn btn-default">%</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="box-form-center">
									<div class="form-group">
										<div class="col-sm-12">
	                                        <input class="next-checkbox checkbox-item" type="checkbox" value="1" name="requiresMinimumPurchase" id="discount_next_requires_minimum_purchase">
	                                        <label class="next-label-checkbox next-label--switch" for="discount_next_requires_minimum_purchase">
	                                            Áp dụng với đơn hàng có tổng giá trị sản phẩm thuộc chương trình khuyến mại từ
	                                        </label>
	                                    </div>
	                                    <div class="col-sm-12 hide mb15" id="minimumPurchase">
	                                    	<div class="input-group">
												<?php echo form_input('minimumPurchase', set_value('minimumPurchase'), 'class="form-control" placeholder=""');?>
												<div class="input-group-btn">
													<button type="button" class="btn btn-default">vnđ</button>
												</div>
											</div>
										</div>
		                            </div>
		                        </div>
								<div class="box-form-center">
		                            <div class="form-group">
										<div class="col-sm-12 text-bold mb10">Áp dụng cho</div>
										<div class="col-sm-12">
											<fieldset class="ui-choice-list">
	                                            <ul>
	                                                <li>
	                                                    <div class="next-input-wrapper">
	                                                        <input checked="checked" value="cart" type="radio" class="next-radio checkbox-item" name="appliesTo" id="discount_next_applies_to_cart">
	                                                        <label class="next-label-radio next-label--switch" for="discount_next_applies_to_cart">Tất cả đơn hàng</label>
	                                                    </div>
	                                                </li>
	                                                <li>
	                                                    <div class="next-input-wrapper">
	                                                        <input value="collections" type="radio" class="next-radio checkbox-item" name="appliesTo" id="discount_next_applies_to_collections">
	                                                        <label class="next-label-radio next-label--switch" for="discount_next_applies_to_collections">Danh mục sản phẩm</label>
	                                                    </div>
	                                                </li>
	                                                <li>
	                                                    <div class="next-input-wrapper">
	                                                        <input value="products" type="radio" class="next-radio checkbox-item" name="appliesTo" id="discount_next_applies_to_products">
	                                                        <label class="next-label-radio next-label--switch" for="discount_next_applies_to_products">Sản phẩm</label>
	                                                    </div>
	                                                </li>
	                                            </ul>
	                                        </fieldset>
										</div>	
										<div class="col-sm-12 hide chose-type mb15" id="products_show">
											<div class="input-group">
												<input type="text" name="" class="form-control" placeholder="Tìm kiếm sản phẩm" data-type="products">
												<div class="input-group-btn">
													<button type="button" class="btn btn-default">Tìm kiếm</button>
												</div>
											</div>
											<div class="products-resource">
												<ul class="next-list--divided next-list--divided--top" id="js-products-container">

												</ul>
												<input type="hidden" name="ProductsId" value="" id="ProductsId">
                                            </div>
										</div>
										<div class="col-sm-12 hide chose-type mb15" id="collections_show">
											<div class="input-group">
												<input type="text" name="" class="form-control" placeholder="Tìm kiếm danh mục sản phẩm" data-type="collections">
												<div class="input-group-btn">
													<button type="button" class="btn btn-default">Tìm kiếm</button>
												</div>
											</div>
											<div class="collection-resource">
												<ul class="next-list--divided next-list--divided--top" id="js-collections-container">

												</ul>
												<input type="hidden" name="CollectionId" value="" id="CollectionId">
                                            </div>
										</div>
									</div>
								</div>

								<div class="box-form-center">
		                            <div class="form-group">
										<div class="col-sm-12 text-bold mb10">Giới hạn sử dụng</div>
										<div class="col-sm-12">
	                                        <input class="next-checkbox checkbox-item" type="checkbox" value="1" name="limitTotalUse" id="discount_next_limit_total_use">
	                                        <label class="next-label-checkbox next-label--switch" for="discount_next_limit_total_use">
	                                            Giới hạn số lần mã giảm giá được áp dụng
	                                        </label>
	                                    </div>
	                                    <div class="col-sm-12 hide mb15" id="limitedUseSelected">
											<?php echo form_input('limitedUseTotal', set_value('limitedUseTotal'), 'class="form-control" placeholder="Số lần sử dụng"');?>
										</div>
									</div>
								</div>

								<div class="box-form-center">
		                            <div class="form-group" id="scheduleStartDate">
		                            	<div class="col-sm-12 text-bold mb10">Thời gian</div>
		                            	<div class="col-sm-6">
											<div class="mb10">Ngày bắt đầu</div>
											<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
												</div>
												<input type="text" name="" class="form-control datetimemonth change_time" value="<?php echo date('d/m/Y', time() + 7*3600) ?>">
											</div>
										</div>
										<div class="col-sm-6">
		                                    <div class="mb10">Thời điểm</div>
											<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
												</div>
												<input type="text" name="" class="form-control datetimeseconds change_time" value="<?php echo date('h:i', time() + 7*3600) ?>">
											</div>
										</div>
										<input type="hidden" name="date_start" id="date_start" value="">
									</div>
									<div class="form-group" style="margin-bottom: 0">
										<div class="col-sm-12">
	                                        <input class="next-checkbox checkbox-item" type="checkbox" value="1" name="scheduleEndDate" id="discount_next_schedule_end_date">
	                                        <label class="next-label-checkbox next-label--switch" for="discount_next_schedule_end_date">
	                                            Thời gian kết thúc
	                                        </label>
	                                    </div>
	                                    <div id="scheduleEndDate" class="hide">
											<div class="col-sm-6 mb15">
												<div class="mb10">Ngày kết thúc</div>
												<div class="input-group">
													<div class="input-group-btn">
														<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
													</div>
													<input type="text" name="" class="form-control datetimemonth change_time" value="<?php echo date('d/m/Y', time() + 7*3600) ?>">
												</div>
											</div>
											<div class="col-sm-6 mb15">
			                                    <div class="mb10">Thời điểm</div>
												<div class="input-group">
													<div class="input-group-btn">
														<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
													</div>
													<input type="text" name="" class="form-control datetimeseconds change_time" value="<?php echo date('h:i', time() + 7*3600) ?>">
												</div>
											</div>
											<input type="hidden" name="date_end" id="date_end" value="">
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="clearfix"></div>
									<script>
										$(document).ready(function(){
											load_end_date();
											$('#scheduleEndDate .change_time').change(function(){
												load_end_date();
												load_date_start_apply();
											})
											function load_end_date(){
												var month = $('#scheduleEndDate .datetimemonth').val();
												var seconds = $('#scheduleEndDate .datetimeseconds').val();
												$('#date_end').attr('value', month + ' ' + seconds + ':00');
											}

											load_start_date();
											$('#scheduleStartDate .change_time').change(function(){
												load_start_date();
												load_date_start_apply();
											})
											function load_start_date(){
												var month = $('#scheduleStartDate .datetimemonth').val();
												var seconds = $('#scheduleStartDate .datetimeseconds').val();
												$('#date_start').attr('value', month + ' ' + seconds + ':00');
											}
											// Tạo mã
											$('.create-coupon').click(function(){
												var uri = '<?php echo site_url('coupon/ajax/coupon/create_coupon') ?>'
											 	$.post(uri,
									            function(data){
									                var json = JSON.parse(data);
									                $('#couponCode').val(json.html);
									                show_code_note();
									            });
											});
											$('#couponCode').keyup(function(){
												show_code_note();
											})
											function show_code_note(){
												$('#result_value').addClass('active');
												var code = $('#couponCode').val().trim();
												var html = '<h2 data-bind="code" class="discount-code summary-card__code">'+ code +'</h2>';
				                                    html = html + '<div>';
				                                        html = html + '<span class="badge badge--status-success">Đang áp dụng</span>';
				                                    html = html + '</div>';
				                                if (code == '') {
				                                	$('#result_value .summary-card__header').html('').addClass('hide');
				                                }else{
				                                	$('#result_value .summary-card__header').removeClass('hide').html(html);
				                                }
											}
											// Check date apply coupon
											load_date_start_apply();
											function load_date_start_apply(){
												var data_time = $('#scheduleStartDate .datetimeseconds').val();
												var data_day = $('#scheduleStartDate .datetimemonth').val();
												var default_time = '<?php echo date('d/m/Y', time() + 7*3600) ?>';
												$('#time_apply').html(data_time);
												if (data_day != default_time) {
													$('#to_day').html(data_day);
												}else{
													$('#to_day').html('hôm nay');
												}
												if ($('input[name="scheduleEndDate"]').is(':checked')) {
													load_date_end_apply();
												}else{
													$('#time_apply_end').html('');
												}
											}
											$('input[name="scheduleEndDate"]').click(function(){
												if($(this).is(':checked')) {
													load_date_end_apply();
												}else{
													$('#time_apply_end').html('');
												}
											})
											function load_date_end_apply(){
												var data_time = $('#scheduleEndDate .datetimeseconds').val();
												var data_day = $('#scheduleEndDate .datetimemonth').val();
												$('#time_apply_end').html('đến ' + data_day + ' ' + data_time);
											}
										})
									</script>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<input type="hidden" name="typeoff" value="0">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="create" value="action" class="btn btn-info pull-right">Thêm mới</button>
					</div><!-- /.box-footer -->
				</div><!-- nav-tabs-custom -->
			</div><!-- /.col -->
			<div class="col-md-3">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-advanced" data-toggle="tab">Nâng cao</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-advanced">
							<div class="form-group">
								<label class="col-sm-12 control-label tp-text-left">Xuất bản</label>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
								</div>
							</div>
							<div class="box-body" id="result_value">
								<div class="no_data">Chưa có thông tin nào được nhập.</div>
								<div class="summary-card__header hide mt-flex-space-between mt-flex mt-flex-middle"></div>
								<ul class="" id="list-coupon-item">
									<li class="ui-content-list__item hide">Giảm <span id="value_type">0%</span> cho <span id="apply_coupon">tất cả đơn hàng</span></li>
									<li class="ui-content-list__item hide">Tổng giá trị sản phẩm được khuyến mãi tối thiểu <span id="total_order">0vnđ</span></li>
									<li class="ui-content-list__item hide">Mã được sử dụng <span id="total_apply">1</span> lần</li>
									<li class="ui-content-list__item hide">Áp dụng từ <span id="time_apply">5:05</span> <span id="to_day">hôm nay</span> <span id="time_apply_end"></span></li>
								</ul>
						    </div>
						</div>
						<div class="clearfix"></div>
						<style>
							.discount-code.summary-card__code {
							    font-size: 17px;
							    margin: 0;
							    font-weight: bold;
							}
							.badge.badge--status-success{display: block;}
							#result_value.active .no_data {display: none;}
							#list-coupon-item li {
							    padding: 5px 0;
							}
							#list-coupon-item {
							    padding-left: 15px;
							    margin-bottom: 0;
							}
						</style>
					</div>
				</div>
			</div><!-- /.col -->
		</div> <!-- /.row -->
	</form>
</section><!-- /.content -->

<div class="modal fade" id="ModalSearch_collections" role="dialog">
    <div class="modal-dialog modal-md" style="max-width: 600px; width: 100%;">
      	<div class="modal-content">
      		<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Áp dụng danh mục khuyến mãi</h4>
	      	</div>
	        <div class="modal-body-top">
				<div class="box-body">
			        <div class="input-group">
			        	<div class="input-group-btn">
							<button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
						<input type="text" class="form-control" placeholder="Tìm kiếm danh mục sản phẩm" value="">
					</div>
			    </div>
			</div>
			<div class="modal-body-content"></div>
	        <div class="modal-footer">
		        <button type="submit" class="btn update-collections btn-primary pull-left">Cập nhật ngay</button>
		        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Hủy</button>
		  	</div>
      	</div>
    </div>
</div>

<div class="modal fade" id="ModalSearch_products" role="dialog">
    <div class="modal-dialog modal-md" style="max-width: 600px; width: 100%;">
      	<div class="modal-content">
      		<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Áp dụng sản phẩm khuyến mãi</h4>
	      	</div>
	       <div class="modal-body-top">
				<div class="box-body">
			        <div class="input-group">
			        	<div class="input-group-btn">
							<button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
						<input type="text" class="form-control" placeholder="Tìm kiếm danh mục sản phẩm" value="">
					</div>
			    </div>
			</div>
			<div class="modal-body-content"></div>
	        <div class="modal-footer">
		        <button type="submit" class="btn update-products btn-primary pull-left">Cập nhật ngay</button>
		        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Hủy</button>
		  	</div>
      	</div>
    </div>
</div>

<script type="text/javascript">
	$(function(){
		$('.datetimemonth').datetimepicker({
			format:'d/m/Y',
			timepicker:false,
			minDate: '-1970/01/01',
		});
		$('.datetimeseconds').datetimepicker({
			datepicker:false,
  			format:'H:i'
		});
		$('.next-checkbox').click(function(){
			if($(this).is(':checked')) {
				$(this).parent().next().removeClass('hide');
			}else {
				$(this).parent().next().addClass('hide');
			}
		});
		$('.next-radio').click(function(){
			var flag = $(this).val();
			$('.chose-type').addClass('hide');
			$('#'+flag+'_show').removeClass('hide');
		});
		$('#couponType').change(function(){
			var result = $(this).val();
			if (result == 0) {
				$('#show_result button').html('%');
			}else{
				$('#show_result button').html('vnđ');
			}
			load_sale_type();
		});
		// Check giá trị giảm
		$('.couponTypeValue').keyup(function(){
			load_sale_type();
		});
		function load_sale_type(){
			var value = $('.couponTypeValue').val();
			var type = $('#show_result button').html();
			$('#value_type').html(number_format(value, 0, '.', '.')+type);
			if (value == 0) {
				$('#value_type').parent().addClass('hide');
				$('#time_apply').parent().addClass('hide');
				$('#result_value').removeClass('active');
			}else{
				$('#value_type').parent().removeClass('hide');
				$('#time_apply').parent().removeClass('hide');
				$('#result_value').addClass('active');
			}
		}
		// Check áp dụng
		$('input[name="appliesTo"]').change(function(){
			load_apply_to();
		});
		function load_apply_to(){
			var value = $('input[name="appliesTo"]:checked').val();
			if (value == 'products') {
				var products = $('#ProductsId').val();
				var html = ((products != '') ? products.split('-').length + ' ' : '') + 'sản phẩm';
			}else if (value == 'collections') {
				var collections = $('#CollectionId').val();
				var html = ((collections != '') ? collections.split('-').length + ' ' : '') + 'danh mục';
			}else{
				var html = 'tất cả đơn hàng';
			}
			$('#apply_coupon').html(html);
		}
		// Check Apply to cart 
		$('input[name="minimumPurchase"]').on('keyup change', function(){
			var value = $(this).val();
			$('#total_order').html(number_format(value, 0, '.', '.')+'vnđ');
			if (value == '') {
            	$('#total_order').parent().addClass('hide');
			}else{
				$('#total_order').parent().removeClass('hide');
			}
		});
		// Check limit apply coupon
		$('input[name="limitedUseTotal"]').on('keyup change', function(){
			var value = $(this).val();
			$('#total_apply').html(number_format(value, 0, '.', '.'));
			if (value == '') {
            	$('#total_apply').parent().addClass('hide');
			}else{
				$('#total_apply').parent().removeClass('hide');
			}
		});
		// Start Collections
		$('#collections_show input').on('keyup', function() {
			load_collections();
		})
		$(document).on('keyup', '#ModalSearch_collections input', function(){
			var keyword = $(this).val();
			var id = $('#CollectionId').val();
			var uri = '<?php echo site_url('coupon/ajax/coupon/load_collections') ?>'
		 	$.post(uri, {keyword: keyword, id: id},
            function(data){
                var json = JSON.parse(data);
                $('#ModalSearch_collections .modal-body-content').html(json.html);
            });
		});
		$('#collections_show .btn').on('click', function() {
			load_collections();
		});
		$(document).on('click', '.next-list-collections.js-results-list .li-root', function(){
			$(this).addClass('active');
		});
		$(document).on('click', '#js-collections-container .items-remove .close-item', function(){
			$(this).parent().parent().remove();
			load_collections_id();
		});

		$('.update-collections').click(function(){
			var outputText = '';
			$('.next-list-collections.js-results-list .li-root.active').not('.not_chose').each(function(){
				var id = $(this).attr('data-id');
				var name = $(this).find('.ui-stack-item--fill').html();
				var divHtml  = '<li class="items-remove active" data-id="'+id+'">';
					divHtml = divHtml+ '<div class="mt-flex mt-flex-middle mt-flex-space-between">';
						divHtml = divHtml+ '<div class="ui-stack-item ui-stack-item--fill">'+name+'</div>';
						divHtml = divHtml+ '<div class="ui-stack-item close-item"><i class="fa fa-close"></i></div>';
					divHtml = divHtml+ '</div>';
				divHtml = divHtml+ '</li>';
				outputText += divHtml;
			});
			$('#js-collections-container').append(outputText); 
			$('#ModalSearch_collections').modal('hide');
			load_collections_id();
		});
		function load_collections_id(){
			var outputText = '';
			$('#js-collections-container .items-remove.active').each(function(){
				var divHtml = $(this).attr('data-id');
				outputText += divHtml + '-';
			});
			$('#CollectionId').attr('value', outputText.slice(0, -1));
			load_apply_to();
		}
		function load_collections(){
			var keyword = $('#collections_show input').val();
			var id = $('#CollectionId').val();
			var uri = '<?php echo site_url('coupon/ajax/coupon/load_collections') ?>'
		 	$.post(uri, {keyword: keyword, id: id},
            function(data){
                var json = JSON.parse(data);
                $('#ModalSearch_collections .modal-body-content').html(json.html);
                $('#ModalSearch_collections .form-control').attr('value', keyword);
                setTimeout(function(){ 
                	$('#ModalSearch_collections').modal('toggle');
                }, 200);
            });
		}
		// END Collections
		// 
		// Start products
		$('#products_show input').on('keyup', function() {
			load_products();
		})
		$(document).on('keyup', '#ModalSearch_products input', function(){
			var keyword = $(this).val();
			var id = $('#ProductsId').val();
			var uri = '<?php echo site_url('coupon/ajax/coupon/load_products') ?>'
		 	$.post(uri, {keyword: keyword, id: id},
            function(data){
                var json = JSON.parse(data);
                $('#ModalSearch_products .modal-body-content').html(json.html);
            });
		});
		$('#products_show .btn').on('click', function() {
			load_products();
		});
		$(document).on('click', '.next-list-products.js-results-list .li-root.pen_root', function(){
			var $_this = $(this);
			$(this).addClass('active');
			check_parent_($_this.next());
		});
		$(document).on('click', '.next-list-products.js-results-list .li-root.li-child', function(){
			$(this).toggleClass('active');
		});
		
		function check_parent_($_this){
			if ($_this.not('.li-child').length == 0) {
				$_this.addClass('active');
				check_parent_($_this.next());
			}else{
				return;
			}
		}

		$(document).on('click', '#js-products-container .items-remove .close-item', function(){
			$(this).parent().parent().remove();
			load_products_id();
		});

		$('.update-products').click(function(){
			var outputText = '';
			$('.next-list-products.js-results-list .li-root.active').not('.not_chose').each(function(){
				var id = $(this).attr('data-id');
				var name = $(this).find('.ui-stack-item--fill').html();
				var divHtml  = '<li class="items-remove active" data-id="'+id+'">';
					divHtml = divHtml+ '<div class="mt-flex mt-flex-middle mt-flex-space-between">';
						divHtml = divHtml+ '<div class="ui-stack-item ui-stack-item--fill">'+name+'</div>';
						divHtml = divHtml+ '<div class="ui-stack-item close-item"><i class="fa fa-close"></i></div>';
					divHtml = divHtml+ '</div>';
				divHtml = divHtml+ '</li>';
				outputText += divHtml;
			});
			$('#js-products-container').append(outputText); 
			$('#ModalSearch_products').modal('hide');
			load_products_id();
		});
		function load_products_id(){
			var outputText = '';
			$('#js-products-container .items-remove.active').each(function(){
				var divHtml = $(this).attr('data-id');
				outputText += divHtml + '-';
			});
			$('#ProductsId').attr('value', outputText.slice(0, -1));
			load_apply_to();
		}
		function load_products(){
			var keyword = $('#products_show input').val();
			var id = $('#ProductsId').val();
			var uri = '<?php echo site_url('coupon/ajax/coupon/load_products') ?>'
		 	$.post(uri, {keyword: keyword, id: id},
            function(data){
                var json = JSON.parse(data);
                $('#ModalSearch_products .modal-body-content').html(json.html);
                $('#ModalSearch_products .form-control').attr('value', keyword);
                setTimeout(function(){ 
                	$('#ModalSearch_products').modal('toggle');
                }, 200);
            });
		}
		function number_format (number, decimals, dec_point, thousands_sep) {
	        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	        var n = !isFinite(+number) ? 0 : +number,
	        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	        s = '',
	        toFixedFix = function (n, prec) {
	            var k = Math.pow(10, prec);
	            return '' + Math.round(n * k) / k;
	        };
	        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	        if (s[0].length > 3) {
	            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	        }
	        if ((s[1] || '').length < prec) {
	            s[1] = s[1] || '';
	            s[1] += new Array(prec - s[1].length + 1).join('0');
	        }
	        return s.join(dec);
	    }
	});
</script>
<style>
	.clearfix {
	    clear: both;
	}
	.mb10{
		margin-bottom: 10px;
	}
	.mb15{
		margin-bottom: 15px;
	}
	.next-label-checkbox.next-label--switch:before,
	.next-label-radio.next-label--switch:before {
	    content: '';
	    width: 16px;
	    height: 16px;
	    box-sizing: border-box;
	    border: 1px solid #c8c8c8;
	    cursor: pointer;
	    display: block;
	    position: absolute;
	    left: 0;
	    top: 3px;
	}
	.next-label-radio.next-label--switch:before {
	    border-radius: 100%
	}
	.next-label-checkbox.next-label--switch,
	.next-label-radio.next-label--switch {
	    padding-left: 25px;
	    position: relative;
	    margin-bottom: 15px;
	    font-weight: normal;
	    cursor: pointer
	}
	.ui-choice-list ul {
	    list-style: none;
	    padding-left: 0;
	    margin-bottom: 0;
	}
	.box-form-center {
	    background-color: #fff;
	    -webkit-box-shadow: 0 0 0 1px rgba(63,63,68,.05),0 1px 3px 0 rgba(63,63,68,.15);
	    box-shadow: 0 0 0 1px rgba(63,63,68,.05),0 1px 3px 0 rgba(63,63,68,.15);
	    padding: 15px 15px 0;
	    margin-bottom: 10px;
	}
	.next-label-radio.next-label--switch:after {
	    content: "";
	    display: block;
	    height: 8px;
	    width: 8px;
	    position: absolute;
	    top: 7px;
	    left: 4px;
	    border-radius: 100%;
	    background-color: transparent;
	    -webkit-transition: -webkit-transform .15s ease-in-out;
	    transition: -webkit-transform .15s ease-in-out;
	    transition: transform .15s ease-in-out;
	    transition: transform .15s ease-in-out,-webkit-transform .15s ease-in-out;
	}
	.next-checkbox:checked ~ .next-label-checkbox.next-label--switch::after {
	    content: "\f00c";
	    font: normal normal normal 12px/1 FontAwesome;
	    color: #08f;
	    position: absolute;
	    left: 2px;
	    top: 5px;
	}
	.next-radio:checked ~ .next-label-radio.next-label--switch:before,
	.next-checkbox:checked ~ .next-label-checkbox.next-label--switch:before {
	    border-color: #08f;
	}
	.next-radio:checked ~ .next-label-radio.next-label--switch:after {
	    background-color: #08f;
	}
	.next-radio:checked ~ .next-label-radio.next-label--switch:after {
	    background-color: #007ace;
	}
	.mt-flex {
	    display: -ms-flexbox;
	    display: -webkit-flex;
	    display: flex
	}
	.mt-flex-middle {
	    -ms-flex-align: center;
	    -webkit-align-items: center;
	    align-items: center
	}
	.mt-flex-space-between {
	    -ms-flex-pack: justify;
	    -webkit-justify-content: space-between;
	    justify-content: space-between
	}
	.mt-flex-right {
	    -ms-flex-pack: end;
	    -webkit-justify-content: flex-end;
	    justify-content: flex-end
	}
	.modal-body-content .box-body:last-child {
	    border-top: 1px solid #f4f4f4;
	    padding: 0 20px;
	    max-height: calc(100vh - 290px);
		overflow: auto;
	}
	.modal-body-content .box-body {
	    padding: 20px;
	}
	.next-list.js-results-list,
	#js-collections-container,
	#js-products-container {
	    padding: 0;
	    margin-bottom: 0;
	    list-style: none;
	}
	.next-list.js-results-list .li-root > *,
	#js-collections-container .items-remove > *,
	#js-products-container .items-remove > * {
	    padding: 10px 10px 10px 30px;
	    position: relative;
	    cursor: pointer;
	}
	.next-list.js-results-list .li-root ,
	#js-collections-container .items-remove,
	#js-products-container .items-remove{
	    border-bottom: 1px solid #f4f4f4;
	}
	.li-child {
	    padding-left: 20px;
	}
	.next-list.js-results-list .li-root:last-child {border-bottom: 0;}
	.js-results-list .li-root  > *:before,
	#js-collections-container .items-remove  > *:before,
	#js-products-container .items-remove  > *:before {
	    content: '';
	    width: 16px;
	    height: 16px;
	    box-sizing: border-box;
	    border: 1px solid #c8c8c8;
	    cursor: pointer;
	    display: block;
	    position: absolute;
	    left: 0;
	    top: 50%;
	    -webkit-transform: translate(0, -50%);
	       -moz-transform: translate(0, -50%);
	        -ms-transform: translate(0, -50%);
	         -o-transform: translate(0, -50%);
	            transform: translate(0, -50%);
	}
	.js-results-list .li-root.active > *:after,
	#js-collections-container .items-remove > *:after,
	#js-products-container .items-remove > *:after{
		content: "\f00c";
	    font: normal normal normal 12px/1 FontAwesome;
	    color: #08f;
	    position: absolute;
	    left: 2px;
	    top: 50%;
	    -webkit-transform: translate(0, -50%);
	       -moz-transform: translate(0, -50%);
	        -ms-transform: translate(0, -50%);
	         -o-transform: translate(0, -50%);
	            transform: translate(0, -50%);
	}
	.js-results-list .li-root.active .ui-stack-item.hide {
	    display: block !important;
	}
	.next-list.js-results-list .li-root .ui-stack-item.ui-stack-item--fill {
	    width: 330px;
	}
	.next-list.js-results-list .li-root .ui-stack-item.v-v{
	 	width: -webkit-calc(100% - 330px);
        width: -moz-calc(100% - 330px);
        width: -ms-calc(100% - 330px);
        width: -o-calc(100% - 330px);
        width: calc(100% - 330px);
        font-size: 13px;
	}
	.next-list.js-results-list .li-root .ui-stack-item.v-v .ui-stack-item:not(:last-child){margin-right: 10px}
	.next-list.js-results-list .li-root .ui-stack-item.v-v .ui-stack-item span {
	    color: orange;
	}
	.next-list.js-results-list .li-root .ui-stack-item.v-v .ui-stack-item font {
	    color: red;
	}
	.next-list.js-results-list .li-root.li-child .ui-stack-item.ui-stack-item--fill {
	    color: green;
	}
</style>