<script src="templates/backend/plugins/ckeditor-4.4.3/ckeditor.js"></script>
<script type="text/javascript">
	$(function(){
		$('.ckeditor-description').each(function(){
			//colorbutton,
			CKEDITOR.replace( this.id, {
				height: 250,
				extraPlugins: 'colorbutton,font,lineutils,justify,lineheight,letterspacing,youtube',
				removeButtons: '',
				entities: false,
				allowedContent: true,
				toolbarGroups: [
					{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
					{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
					{ name: 'links' },
					{ name: 'insert' },
					{ name: 'forms' },
					{ name: 'tools' },
					{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
					{ name: 'colors' },
					{ name: 'others' },
					'/',
					{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
					{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
					{ name: 'styles' }
				],
			});
		});
	});
</script>
<?php $DetailCatalogues = recursive($DetailCatalogues); ?>
<div id="homepage" class="page-body">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center"> 
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
					<i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a>
				</li>
				<li class="uk-active">
					<a href="javascript: void(0)" title="Đăng tin">
					Đăng tin</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mb20">
			<div class="uk-width-large-2-3">
				<section class="project-create">
					<header class="panel-head">
						<div class="heading-2 mb0"><span>Đăng tin</span></div>
					</header>
					<section class="panel-body">
						<?php $error = validation_errors(); echo !empty($error) ? '<div class="callout callout-danger" style="padding:10px;background:rgb(195, 94, 94);color:#fff;margin-bottom:10px;">'.$error.'</div>' : '';?>
						<form action="" method="post" accept-charset="utf-8">
							<div class="line-form mb20">
								<div class="box_title">
									<div class="uk-flex lib-grid-15 uk-flex-middle">
										<div class="label-left">
											<label>Tiều đề đăng</label>
										</div>
										<div class="label-right uk-width-1-1">
											<label class="label-label">
												<?php echo form_input('title', set_value('title'), 'class="uk-width-1-1 input-text"');?>
											</label>
											<?php $code = code_generator('projects'); ?>
											<?php echo form_hidden('code', set_value('code', $code), 'class="uk-width-1-1"'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="line-form mb20 bor_bor">
								<div class="box_title_2">
									<span>Thông tin chung</span>
								</div>
								<div class="content_content">
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-left bg_bg">
											<label class="label-label">Loại BĐS *</label>
										</div>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label">
												<div class="uk-flex uk-flex-middle pdall">
													<select class="input-text catagolies" name="catalogue[]">
														<option value="">Chọn danh mục</option>
														<?php if (isset($DetailCatalogues) && is_array($DetailCatalogues) && count($DetailCatalogues)) { ?>
															<?php foreach ($DetailCatalogues as $key => $val){ ?>
																<option value="<?php echo $val['id'] ?>"><?php echo $val['title'] ?></option>
																<?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])) { ?>
																	<?php foreach ($val['child'] as $key => $vals){ ?>
																		<option value="<?php echo $vals['id'] ?>">|----<?php echo $vals['title'] ?></option>
																	<?php } ?>
																<?php } ?>
															<?php } ?>
														<?php } ?>
													</select>
													<span> / </span>
													<div class="fillter">
														<label class="red">
															Tin thường  
															<input name="isaside" value="0" <?php echo ((isset($_POST['isaside']) && $_POST['isaside'] == 0) ? 'checked' : '') ?> class="check-box" type="radio">
														</label>
													</div>
													<div class="fillter">
														<label class="red">
															Tin vip  
															<input name="isaside" value="1" <?php echo ((isset($_POST['isaside']) && $_POST['isaside'] == 1) ? 'checked' : '') ?> class="check-box" type="radio">
														</label>
													</div>
												</div>
											</label>
										</div>
									</div>
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-left bg_bg">
											<label class="label-label">Giá </label>
										</div>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label">
												<div class="uk-flex uk-flex-middle pdall">
													<?php echo form_input('price', set_value('price'), '');?>
													<span> </span>
													<?php echo form_dropdown('measure', $this->configbie->data('measure'), set_value('measure', 0), 'class="form-control"');?>
													<span> / </span>
													<?php echo form_dropdown('type', $this->configbie->data('type'), set_value('type', 2), 'class="form-control"');?>
												</div>
											</label>
										</div>
									</div>
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-left bg_bg">
											<label class="label-label">Địa điểm - Vị trí</label>
										</div>
										<?php 
											$location_dropdown = $this->BackendProjects_Model->location_dropdown(array(
												'where' => array('parentid' => 0)
											));
										?>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label">
												<div class="uk-grid lib-grid-5">
													<div class="uk-width-1-2 uk-flex lib-grid-5 uk-flex-middle uk-flex-space-between">
														<label style="width: 100%;">Tỉnh / Thành phố</label>
														<?php echo form_dropdown('cityid', $location_dropdown, set_value('cityid', 0), 'class="form-control location" style="width: 100%;" id="cityid" data-return="district" data-flag="0"');?>
													</div>
													<div class="uk-width-1-2 uk-flex lib-grid-5 uk-flex-middle uk-flex-space-between">
														<label style="width: 100%;">Quận / Huyện</label>
														<select style="width: 100%;" name="districtid" class="form-control location" id="district" data-return="ward" data-flag="0">
															<option value="0" selected="selected">[Chọn]</option>
														</select>
													</div>
													<div class="uk-width-1-2 uk-flex lib-grid-5 uk-flex-middle uk-flex-space-between">
														<label style="width: 100%;">Xã / Phường</label>
														<select style="width: 100%;" name="wardid" class="form-control location" id="ward" data-flag="0">
															<option value="0" selected="selected">[Chọn]</option>
														</select>
													</div>
													<div class="uk-width-1-2 uk-flex lib-grid-5 uk-flex-middle uk-flex-space-between">
														<label style="width: 100%;">Dự án</label>
														<select style="width: 100%;" name="projectid" class="form-control location" id="project" data-return="district">
															<option value="0" selected="selected">[Chọn]</option>
														</select>
													</div>
												</div>
											</label>
										</div>
									</div>
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-left bg_bg">
											<label class="label-label">Địa chỉ</label>
										</div>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label">
												<input id="address" type="text" name="address" value="" class="uk-width-1-1">
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="line-form mb20 bor_bor" id="fillter_att">
								<div class="box_title_2">
									<span>Hạn vip</span>
								</div>
								<div class="content_content">
									<div class="uk-grid uk-flex-middle lib-grid-0">
										<div class="uk-width-1-2">
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Ngày hết hạn</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<input type="hidden" name="outohor" value="<?php echo set_value('outohour', gmdate('H:i', time() + 7*3600)) ?>" class="uk-width-1-1 outohour">
														<?php echo form_input('outofdate', set_value('outofdate', gmdate('Y-m-d', time() + 31*3600)), 'class="uk-width-1-1 outofdate" readonly="" data-uk-datepicker="{format:\'YYYY-MM-DD\'}" ');?>
													</label>
												</div>
											</div>
										</div>
										<div class="uk-width-1-2" id="data-time-vip">

										</div>
									</div>
									<div class="orror_vip"></div>
								</div>
							</div>

							<div class="line-form mb20 bor_bor">
								<div class="box_title_2">
									<span>Đặc điểm</span>
								</div>
								<div class="content_content">
									<div class="uk-grid uk-flex-middle lib-grid-0">
										<div class="uk-width-1-2">
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Diện tích (m2)</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<?php echo form_input('area', set_value('area'), 'class="uk-width-1-1"');?>
													</label>
												</div>
											</div>
										</div>
										<div class="uk-width-1-2">
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Hướng</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<?php echo form_dropdown('floor', $this->configbie->data('floor'), set_value('floor', 0), 'class="uk-width-1-1"'); ?>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="line-form mb20 bor_bor">
								<div class="box_title_2">
									<span>Albulm ảnh</span>
								</div>
								<div class="content_content">
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-left bg_bg">
											<label class="label-label">Upload ảnh</label>
										</div>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label">
												<div class="box image-wapper">
						                            <div class="image-wapper-label">
						                                Đăng ảnh thật để được hiệu quả nhất!
						                            </div>
						                            <div class="image-wapper-take">
						                                <div class="jfu-container" id="jfu-plugin-a7d4b6e75885-45ee-925e-138faba4318f"><span class="jfu-btn-upload"><span><span style="position:relative; cursor:pointer"> <i class="fa fa-camera camera-add-image"></i><i class="fa fa-plus-circle plus-add-image"></i></span></span><input class="input-file jfu-input-file" accept="image/*" id="file" multiple="" name="file[]" type="file"></span></div>
						                            </div>
						                            <div class="image-wapper-des">
						                                <div>Click vào dấu cộng ở trên để up hình,</div>
						                                <div>bạn có thể up tối đa 30 hình, mỗi hình tối đa 2MB</div>
						                            </div>
						                        </div>
						                        <div class="progress" style="display: none;">
												    <div id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
												      0%
												    </div>
												</div>
											</label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="line-form mb20 bor_bor hide" id="list_album">
								<div class="box_title_2">
									<span>Danh sách ảnh</span>
								</div>
								<div class="content_content">
									<div class="list-error"></div>
									<ul class="list-group lib-grid-10 uk-flex uk-flex-middle"></ul>
								</div>
							</div>

							<div class="line-form mb20 bor_bor">
								<div class="box_title_2">
									<span>Chi tiết</span>
								</div>
								<div class="content_content">
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-left bg_bg">
											<label class="label-label">Thông tin liên hệ</label>
										</div>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label" style="line-height: 0;padding: 10px;">
												<?php echo form_textarea('description', set_value('description'), 'cols="40" rows="10" id="txtDescription" class="" placeholder="Mô tả" style="width: 100%; height: 100px; font-size: 13px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
											</label>
										</div>
									</div>
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-left bg_bg">
											<label class="label-label">Nội dung</label>
										</div>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label" style="line-height: 0;padding: 10px;">
												<?php echo form_textarea('content', htmlspecialchars_decode(set_value('content')), 'cols="40" rows="10"  id="txtContent" class="ckeditor-description" placeholder="Nội dung" style="width: 100%; height: 350px; font-size: 13px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
											</label>
										</div>
									</div>
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-right uk-width-1-1 uk-text-center" style="width: 100%;">
											<button type="submit" name="create" value="action" class="btn btn-info">Thêm mới</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</section>
				</section>
			</div>
			<div class="uk-width-large-1-3">
				<?php $this->load->view('homepage/frontend/common/customers_aside'); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		var checked = $('input[name="isaside"]:checked').val();
		var date = $('.outofdate').val();
		var hour = $('.outohour').val();
		checkvippost (date, hour, checked);

		$('input[name="isaside"]').on('click', function(){
			var data = $(this).val();
			var date = $('.outofdate').val();
			var hour = $('.outohour').val();
			checkvippost (date, hour, data);
		});
		
		$('input[name="outofdate"]').on('change', function(){
			var checked = $('input[name="isaside"]:checked').val();
			var data = $(this).val();
			var hour = $('.outohour').val();
			checkvippost (data, hour, checked);
		});
	});
	$(document).ready(function(){
		$('.catagolies').on('change', function() {
			var id = $(this).val();
			var uri = '<?php echo site_url('projects/ajax/projects/check_fillter'); ?>';
			$.post(uri, {post: id},
			function(data){
				var json = JSON.parse(data);
				$('#fillter_att .content_content .orror_vip').html('').html(json.html);
			});
			return false;
		});

		var time;
		$('.location').on('change',function(){
			var id = $(this).val();
			var returnSection = $(this).attr('data-return');
			var flag = $(this).attr('data-flag');
			var formURL = 'projects/ajax/projects/ajax_change_location';
			var _this = $(this);
			if(returnSection == 'district'){
				$('#ward').html('');
				$('#district').html('');
			}else if(returnSection == 'ward'){
				$('#ward').html('');
			}
		
			$.post(formURL, {id: id},
			function(data){
				var json = JSON.parse(data);
				if(flag == 0){
					if(returnSection == 'district'){
						$('#'+returnSection).html(json.html).val(districtid).trigger('change');
					}else if(returnSection == 'ward'){
						$('#'+returnSection).html(json.html).val(wardid).trigger('change');
					}
					_this.attr('data-flag',1);
				}else{
					$('#'+returnSection).html(json.html);
				}
			});
			
			var city_id = $('#cityid option:selected').val();
			var district_id = $('#district option:selected').val();
			var ward_id = $('#ward option:selected').val();
			
			
			var city_text = $('#cityid option:selected').text();
			var district_text = $('#district option:selected').text();
			var ward_text = $('#ward option:selected').text();
			/* Ghi nhanh địa chỉ */
			var address = '';
			address = ((ward_text != '') ? ' - ' + ward_text : '') + ((district_text != '') ? ' - ' + district_text : '') + ((city_text != '') ? ' - ' + city_text : '');
			$('#address').val('').val(address);
			/* ---------------- */
			if(typeof(district_id) == 'undefined'){
				district_id = 0;
			}
			if(typeof(ward_id) == 'undefined'){
				ward_id = 0;
			}
			if(typeof(projectid) == 'undefined'){
				projectid = 0;
			}
			listProject(city_id, district_id, ward_id, projectid);
		});

	});
	function listProject (cityid, districtid, wardid, projectid){
		var formURL = 'projects/ajax/projects/ajax_get_project_list'
		$.post(formURL, {cityid: cityid, districtid:districtid, wardid:wardid},
		function(data){
			var json = JSON.parse(data);
			$('#project').html('').html(json.html).val(projectid);
		});
	}
	function checkvippost (data, hour, checked){
		if (checked == 1) {
			$('#fillter_att').show();
		}else{
			$('#fillter_att').hide();
		}
		var uri = '<?php echo site_url('projects/ajax/projects/check_vip'); ?>';
		$.post(uri, {data: data, hour: hour},
		function(data){
			var json = JSON.parse(data);
			$('#fillter_att .content_content #data-time-vip').html('').html(json.html);
		});
		return false;
	}
</script>