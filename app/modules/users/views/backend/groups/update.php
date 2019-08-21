<section class="content-header">
	<h1>Cập nhật nhóm thành viên</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('users/backend/groups/view');?>">Nhóm thành viên</a></li>
		<li class="active"><a href="<?php echo site_url('users/backend/groups/update/'.$DetailUsersGroups['id']);?>">Cập nhật nhóm thành viên</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab-info" data-toggle="tab">Thông tin cơ bản</a></li>
					<li><a href="#tab-seo" data-toggle="tab">SEO</a></li>
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
									<label class="col-sm-2 control-label">Nhóm thành viên</label>
									<div class="col-sm-10">
										<?php echo form_input('title', set_value('title', $DetailUsersGroups['title']), 'class="form-control" placeholder="Nhóm thành viên"');?>
									</div>
								</div>
								<?php
								$dropdown  = $this->BackendFunctions_Model->Dropdown();
								$dir = 'app/modules';
								$folder = scandir($dir);
								$permissions = json_decode($DetailUsersGroups['group'], TRUE);
								$post_permissions = $this->input->post('permissions');
								if(isset($post_permissions) && is_array($post_permissions) && count($post_permissions)){
									$permissions = $post_permissions;
								}
								if(isset($folder) && is_array($folder) && count($folder)){
									foreach($folder as $keyFolder => $valFolder){
										if(in_array($valFolder, array('.', '..'))) continue;
										if(!in_array($valFolder, $dropdown)) continue;
										if(!file_exists($dir.'/'.$valFolder.'/config.xml')) continue;
										$xml = simplexml_load_file($dir.'/'.$valFolder.'/config.xml') or die('Error: Cannot create object '.$dir.'/'.$valFolder.'/config.xml');
										$xml = json_decode(json_encode((array)$xml), TRUE);
										if(isset($xml['permissions']) && is_array($xml['permissions']) && count($xml['permissions'])){
											foreach($xml['permissions'] as $keyPermissions => $valPermissions){
											if(!isset($valPermissions['title']) || empty($valPermissions['title'])) continue;
											?>
											<div class="form-group">
												<label class="col-sm-2 control-label"><?php echo $valPermissions['title'];?></label>
												<div class="col-sm-10">
												<?php if(isset($valPermissions['item']) && is_array($valPermissions['item']) && count($valPermissions['item'])){ ?>
													<div class="userGroupContainer checkbox clearfix">
													<?php foreach($valPermissions['item'] as $keyItem => $valItem){ if(!isset($valItem['param']) || empty($valItem['param'])) continue; ?>
														<label class="tpInputLabel">
															<input name="permissions[]" class="tpInputCheckbox" type="checkbox" value="<?php echo $valItem['param'];?>" <?php echo (isset($permissions) && is_array($permissions) && in_array($valItem['param'], $permissions))?'checked="checked"':'';?> />
															<span><?php echo $valItem['description'];?></span>
														</label>
													<?php } ?>
													</div>
												<?php } ?>
												</div>
											</div>
											<?php
											}
										}
									}
								}
								?>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-seo">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Title</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_title', set_value('meta_title', $DetailUsersGroups['meta_title']), 'class="form-control" placeholder="Meta Title"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Keyword</label>
									<div class="col-sm-10">
										<?php echo form_input('meta_keyword', set_value('meta_keyword', $DetailUsersGroups['meta_keyword']), 'class="form-control" placeholder="Meta Keyword"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Meta Description</label>
									<div class="col-sm-10">
										<?php echo form_textarea('meta_description', set_value('meta_description', $DetailUsersGroups['meta_description']), 'class="form-control" placeholder="Meta Description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab-advanced">
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-2 control-label">Xuất bản</label>
									<div class="col-sm-2">
										<?php echo form_dropdown('publish', $this->configbie->data('publish'), set_value('publish', $DetailUsersGroups['publish']), 'class="form-control select2" style="width: 100%;"');?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mô tả</label>
									<div class="col-sm-10">
										<?php echo form_textarea('description', htmlspecialchars_decode(set_value('description', $DetailUsersGroups['description'])), 'class="textarea" placeholder="Mô tả" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
									</div>
								</div>
							</div><!-- /.box-body -->
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">Làm lại</button>
						<button type="submit" name="update" value="action" class="btn btn-info pull-right">Cập nhật</button>
					</div><!-- /.box-footer -->
				</form>
			</div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div> <!-- /.row -->
</section><!-- /.content -->