<section class="content-header">
	<h1>Thêm bài viết mới</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('navigations/backend/menus/view');?>">Bài viết</a></li>
		<li class="active"><a href="<?php echo site_url('navigations/backend/menus/create');?>">Thêm bài viết mới</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
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
									<label class="col-sm-2 control-label">Menu</label>
									<div class="col-sm-3">
										<?php echo form_input('title', set_value('title'), 'class="form-control" placeholder="Tên menu"');?>
									</div>
									<label class="col-sm-1 control-label">Href</label>
									<div class="col-sm-6">
										<?php echo form_input('href', set_value('href'), 'class="form-control" placeholder="Đường dẫn"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Vị trí</label>
									<div class="col-sm-3">
										<?php echo form_dropdown('positionsid', $this->BackendNavigationsPositions_Model->Dropdown(), set_value('positionsid'), 'class="form-control" style="width: 100%;" id="positionsid"');?>
									</div>
									<label class="col-sm-1 control-label">Menu con</label>
									<div class="col-sm-6">
										<select name="parentid" id="parentid" class="form-control" style="width: 100%;">
											<option value="0">- Chọn Vị Trí -</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Ảnh đại diện</label>
									<div class="col-sm-3">
										<div class="avatar" style="margin-bottom: 10px;cursor: pointer;"><img src="<?php echo (isset($avatar) && !empty($avatar))?$avatar: 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;object-fit: scale-down;height: 200px;" /></div>
										<?php echo form_input('description', set_value('description'), 'class="form-control"  placeholder="Ảnh đại diện"  ');?>
									</div>
								</div>
								<script type="text/javascript">
									$(document).on('click', '.img-thumbnail', function(){
										openKCFinderAlbum($(this));
									});
								</script>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Icon</label>
									<div class="col-sm-4">
										<div class="icon_title">
											<i class="fa fa-home"></i>
										</div>
										<!-- <input type="hidden" name="description" value="" class="icon_des"> -->
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Chọn icon</label>
									<div class="col-sm-9">
										<?php $menu_icon = menu_icon(); $icon = (!empty($this->input->post('description'))) ? $this->input->post('description') : 'fa fa-home'; ?>
										<div class="box_item_icon">
											<ul class="list_icon">
												<?php 
													foreach ( $menu_icon as $val ) {
														echo '<li class="'.(($val == $icon) ? 'active' : '').'"><i class="'.$val.'"></i></li>';
													}
												?>
											</ul>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>

								<div class="form-group" style="display: none">
									<label class="col-sm-2 control-label">Module</label>
									<div class="col-sm-3">
										<?php echo form_dropdown('modules', $this->configbie->data('modules', -1), set_value('modules'), 'class="form-control" style="width: 100%;" id="modules"');?>
									</div>
									<label class="col-sm-1 control-label">Nội dung</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('modulesid', NULL, NULL, 'class="form-control" style="width: 100%;" id="modulesid"');?>
									</div>
									<div class="col-sm-1">
										<button type="button" class="btn btn-default" id="btnloadmodulesid">Load</button>
									</div>
								</div>
								<div id="sub3"></div>
								
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', 1), 'class="form-control" style="width: 100%;"');?>
									</div>
									<label class="col-sm-1 control-label">Sắp xếp</label>
									<div class="col-sm-2">
										<?php echo form_input('order', set_value('order'), 'class="form-control" placeholder="Sắp xếp"');?>
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
<style>
	.box_item_icon {
	    background: #f7f7f7;
	    border: 1px solid #ddd;
	    max-height: 125px;
	    overflow: auto;
	}
	.list_icon {
	    list-style: none;
	    width: 100%;
	    float: left;
	    padding: 5px 0 0 5px;
	}
	.list_icon li {
	    width: 40px;
	    float: left;
	    line-height: 38px;
	    text-align: center;
	    border: 1px solid #ddd;
	    margin: 5px 5px;
	    cursor: pointer;
	}
	.icon_title i {
	    width: 32px;
	    line-height: 30px;
	    text-align: center;
	    background-color: #f7f7f7;
	    border: 1px solid #ddd;
	}
	.list_icon li.active {
	    background-color: #0f9ef2;
	    color: #fff;
	    border-color: #0f9ef2;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){

		load_icon();
		function load_icon(){
			$('.list_icon li.active').each(function(){
				var clas = $(this).find('.fa').attr('class');
				$('.icon_title i').attr('class', clas);
				$('.icon_des').attr('value', clas);
			})
		}
		$('.list_icon li').click(function(){
			$('.list_icon li').removeClass('active');
			$(this).addClass('active');
			load_icon();
		});

		$('#positionsid').change(function(){
			$.post('<?php echo site_url('navigations/ajax/modulesbie/loadparantid')?>', {'positionsid': $('#positionsid').val()}, function(data){
				$('#parentid').html(data);
			})
			return false;
		});

		// $('#parentid').change(function(){
		// 	$.post('<?php echo site_url('navigations/ajax/modulesbie/loadsub')?>', {'parentid': $('#parentid').val()}, function(data){
		// 		$('#sub3').html(data).val(<?php echo set_value('sub3', 0);?>).trigger('change');
		// 	})
		// 	return false;
		// }).trigger('change');

		$('#modules').change(function(){
			$.post('<?php echo site_url('navigations/ajax/modulesbie/load')?>', {'modules': $('#modules').val()}, function(data){
				$('#modulesid').html(data).val(<?php echo set_value('modulesid', 0);?>).trigger('change');
			})
			return false;
		}).trigger('change');

		
		$('#btnloadmodulesid').on('click', function(){
			/* var flag = confirm('Confirm?');
			if(flag == true){ */
				$.post('<?php echo site_url('navigations/ajax/modulesbie/loaditem')?>', {'modules': $('#modules').val(), 'modulesid': $('#modulesid').val()}, function(data){
					var theList = JSON.parse(data);
					resetItem();
					if($.isArray(theList) && theList.length){
						$.each(theList, function(key, val) {
							key = parseInt(key + 1);
							$('#txtTitle'+key).val(val.title);
							$('#txtId'+key).val(val.id);
							$('#txtHref'+key).val(val.href);
							$('#txtOrder'+key).val(val.order);
						});
					}
				});
			/* } */
			return false;
		});
	});
	$(window).load(function(){
	});
	function resetItem(){
		for(var i = 1; i <= 15; i++){
			$('#txtTitle'+i).val('');
			$('#txtId'+i).val('');
			$('#txtHref'+i).val('');
			$('#txtOrder'+i).val('');
		}
	}
</script>