<section class="content-header">
	<h1>Cập nhật hỗ trợ trực tuyến</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('comments/backend/comments/view');?>"> Đánh giá sản phẩm</a></li>
		<li class="active"><a href="<?php echo site_url('comments/backend/comments/update/'.$DetailComments['id']);?>">Cập nhật bản ghi</a></li>
	</ol>
</section>
<?php  
	$module = $DetailComments['module'];
	$moduleid = $DetailComments['moduleid'];
	$object = $this->Autoload_Model->_get_where(array(
		'select' => 'id, title, slug, canonical',
		'table' => $module,
		'where' => array('publish' => 1,'trash' => 0,'id' => $moduleid),
		'limit' => 1,
	));
	$title = $object['title'];
	$href = rewrite_url($object['canonical'], $object['slug'], $object['id'], $module);
	// $href = site_url('learning/lecture-'.$DetailComments['pageid'].'');

	$customers = $this->Autoload_Model->_get_where(array(
		'select' => 'id, fullname, email',
		'table' => 'customers',
		'where' => array('publish' => 1,'trash' => 0,'id' => $DetailComments['customersid']),
		'limit' => 1,
	));
?>
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
									<label class="col-sm-2 control-label">Tên đầy đủ</label>
									<div class="col-sm-4">
										<?php echo form_input('fullname', set_value('fullname', ((isset($customers) && is_array($customers) && count($customers)) ? $customers['fullname'] : $DetailComments['fullname'])), 'class="form-control" disabled placeholder="Tên đầy đủ"');?>
									</div>
									<label class="col-sm-1 control-label">Email</label>
									<div class="col-sm-4">
										<?php echo form_input('email', set_value('email', ((isset($customers) && is_array($customers) && count($customers)) ? $customers['email'] : $DetailComments['email'])), 'class="form-control" disabled placeholder="Email"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Đánh giá</label>
									<div class="col-sm-4">
										<div style="line-height: 32px;">
											<?php for($i = 1; $i <= 5; $i++){ ?> <i class="fa fa-star" style="<?php echo ($i <= $DetailComments['star']) ? 'color:#FD4' : ''; ?>"></i> <?php  } ?>
										</div>
									</div>
									<label class="col-sm-1 control-label">Links bài viết</label>
									<div class="col-sm-4">
										<a href="<?php echo $href ?>" target="_blank" style="display: inline-block; line-height: 36px;"><?php echo $title ?></a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Nội dung</label>
									<div class="col-sm-9">
										<?php echo form_textarea('message', htmlspecialchars_decode(set_value('message', $DetailComments['message'])), 'class="textarea" placeholder="Nội dung" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
								<div class="form-group hide">
									<label class="col-sm-2 control-label">Ảnh đính kèm</label>
									<div class="col-sm-10">
										<?php  
											$list_image = explode('-+-', $DetailComments['images']);
											if (isset($list_image) && is_array($list_image) && count($list_image)) {
												echo '<ul class="clearfix mt-list mt15 list-attachs-images">';
													foreach ($list_image as $valimg) {
									            		echo '<li><a href="javascript:void(0)" data-file="'.$valimg.'">';
									            			echo '<img src="'.$valimg.'" alt="'.$valimg.'" />';
									            		echo '</a></li>';
													}
												echo '</ul>';
												echo '<div class="clearfix"></div>';
											}
										?>
									</div>
								</div>
								<?php if($DetailComments['parentid'] == 0){?>
								<div class="form-group">
									<label class="col-sm-2 control-label">Trả lời lại</label>
									<div class="col-sm-10">
										<?php echo form_textarea('message2', htmlspecialchars_decode(set_value('message2')), 'class="textarea" placeholder="Nội dung" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
								<?php }?>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailComments['publish']), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<?php if($DetailComments['parentid'] == 0){?>
						<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
						<?php }else{?>
							<a class="btn btn-danger" href="<?php echo site_url('comments/backend/comments/view');?>">Quay lại</a>
						<?php }?>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->
<style>
	.list-attachs-images {list-style: none;padding-left: 0}
	.list-attachs-images li{float: left;}
	.list-attachs-images li img{height: 80px}
</style>