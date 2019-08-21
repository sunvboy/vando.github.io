<section class="content-header">
	<h1>Cấu hình hệ thống</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('systems/backend/systems/view');?>">Hệ thống</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
				<?php if(isset($tabs) && is_array($tabs) && count($tabs)){ ?>
				<?php foreach($tabs as $keyTab => $valTab){ ?>
					<li class="<?php echo (($keyTab == 'homepage') ? 'active' : ''); ?>"><a href="#tab-<?php echo $keyTab; ?>" data-toggle="tab"><?php echo strtoupper($keyTab); ?></a></li>
				<?php } ?>
				<?php } ?>
				</ul>
				<form class="form-horizontal" method="post" action="">
					<div class="tab-content">
						<div class="box-body">
							<?php echo show_flashdata();?>
						</div><!-- /.box-body -->
					<?php if(isset($tabs) && is_array($tabs) && count($tabs)){ ?>
					<?php foreach($tabs as $key => $val){ ?>
						<div class="tab-pane <?php echo ($key == 'homepage') ? 'active' : ''; ?>" id="tab-<?php echo $key; ?>">
							<div class="box-body">
							<?php foreach($val as $keyItem => $valItem){ ?>
								<div class="form-group">
									<label class="col-sm-2 control-label"><?php echo $valItem['label']; ?></label>
									<div class="col-sm-<?php echo ($valItem['type'] == 'editor')? '9' : '6' ?>">
									<?php 
										if($valItem['type'] == 'text'){ 
											echo form_input('config['.$key.'_'.$keyItem.']', html_entity_decode(htmlspecialchars_decode(set_value($key.'_'.$keyItem, isset($systems[$key.'_'.$keyItem]) ? $systems[$key.'_'.$keyItem]: ''))), 'class="form-control '.((isset($valItem['class'])) ? $valItem['class'] : '').'" placeholder="'.$valItem['label'].'"');
										}
										else if($valItem['type'] == 'textarea'){
											echo form_textarea('config['.$key.'_'.$keyItem.']', (isset($systems[$key.'_'.$keyItem]) ? $systems[$key.'_'.$keyItem]: ''), 'class="form-control" placeholder="'.$valItem['label'].'"');
										}
										else if($valItem['type'] == 'images'){
											echo form_input('config['.$key.'_'.$keyItem.']', html_entity_decode(htmlspecialchars_decode(set_value($key.'_'.$keyItem, isset($systems[$key.'_'.$keyItem]) ? $systems[$key.'_'.$keyItem]: ''))), 'class="form-control" placeholder="'.$valItem['label'].'" onclick="openKCFinder(this)"');
										}
										else if($valItem['type'] == 'files'){
											echo form_input('config['.$key.'_'.$keyItem.']', html_entity_decode(htmlspecialchars_decode(set_value($key.'_'.$keyItem, isset($systems[$key.'_'.$keyItem]) ? $systems[$key.'_'.$keyItem]: ''))), 'class="form-control" placeholder="'.$valItem['label'].'" onclick="openKCFinder(this, \'files\')"');
										}
										else if($valItem['type'] == 'editor'){
											echo form_textarea('config['.$key.'_'.$keyItem.']', html_entity_decode(htmlspecialchars_decode(set_value($key.'_'.$keyItem, isset($systems[$key.'_'.$keyItem]) ? $systems[$key.'_'.$keyItem]: ''))), 'id="'.$key.'_'.$keyItem.'" class="ckeditor-description" placeholder="'.$valItem['label'].'" style="height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px"');
										}else if($valItem['type'] == 'dropdown'){
											echo form_dropdown('config['.$key.'_'.$keyItem.']', $valItem['value'], set_value($key.'_'.$keyItem, isset($systems[$key.'_'.$keyItem]) ? $systems[$key.'_'.$keyItem]: ''), 'class="form-control" style="width: 100%;"');
										}
									?>
									</div>
								</div>
							<?php } ?>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					<?php } ?>
					<?php } ?>
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="submit" value="action" class="btn btn-info pull-right">Xác nhận</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->