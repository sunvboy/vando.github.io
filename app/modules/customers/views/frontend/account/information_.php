<section class="page-content" id="customers">
    <div class="top_barr">
        <div class="container">
            <div class="relative">
                <div class="title_name_members">Thành viên: <?php echo $this->fcCustomer['fullname'] ?></div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?php echo site_url('my-profile') ?>"><i class="fas fa-user-tie" aria-hidden="true"></i> Hồ sơ cá nhân</a>
                    </li>
                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('my-affiliate') ?>"><i class="fab fa-affiliatetheme" aria-hidden="true"></i> Lịch sử Affiliate</a>
                    </li>
                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('my-order') ?>"> <i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
                    </li>
                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('my-coint') ?>"> <i class="fas fa-coins" aria-hidden="true"></i> Lịch sử xu</a>
                    </li>
                    <li class="d-md-none btn-group">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Xem Thêm </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="<?php echo site_url('my-affiliate') ?>"><i class="fab fa-affiliatetheme" aria-hidden="true"></i> Lịch sử Affiliate</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('my-order') ?>"> <i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('my-coint') ?>"> <i class="fas fa-coins" aria-hidden="true"></i> Lịch sử xu</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="main-inner">
                <div class="row">
                    <div class="col-md-3 mt25">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
            	                <div class="avatar" style="margin-bottom: 10px;cursor: pointer;">
                                    <img src="<?php echo (isset($DetailCustomers['images']) && !empty($DetailCustomers['images']))?$DetailCustomers['images']: 'templates/not-found.png'; ?>" class="img-thumbnail" alt="" style="width: 100%;border-radius: 0;" />
                                </div>
            			        <input type="hidden" value="" class="img-avatar" />
                                <h3 class="profile-username text-center mb10"><?php echo $DetailCustomers['fullname']; ?></h3>
            			        <button type="submit" class="btn btn-danger btn-block btn-sm" id="save">Lưu</button>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                        <!-- About Me Box -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Thông tin cá nhân</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <p><i class="fas fa-user-tie margin-r-5" style="width: 24px;text-align:center"></i>
                				    <span class="text">
                					   <?php echo $DetailCustomers['fullname']; ?>
                				    </span>
                		        </p>
                			    <p>
                					<i class="fas fa-birthday-cake margin-r-5" style="width: 24px;text-align:center" aria-hidden="true"></i> 
                					<span class="text">
                					   <?php echo $DetailCustomers['birthday']; ?>
                				    </span>
                			    </p>
                			    <p>
                					<i class="fas fa-mobile-alt margin-r-5" style="width: 24px;text-align:center"></i> 
                					<span class="text">
                						<?php echo $DetailCustomers['phone']; ?>
                					</span>
                			    </p>
                				 <p>
                					<i class="fas fa-map-marker-alt margin-r-5" style="width: 24px;text-align:center" aria-hidden="true"></i>
                					<span class="text">
                						<?php echo $DetailCustomers['address']; ?>
                					</span>
                			    </p>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Tích điểm</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="mt-flex mt-flex-middle mt-flex-space-between">
                                    <div class="mt-flex mt-flex-middle xu-infomation">
                                        <img src="templates/frontend/resources/images/img-xu.png" alt="img-xu">
                                        <span><?php echo total_coin_customers($DetailCustomers['id']); ?> đang có</span>
                                    </div>
                                    <a href="<?php echo site_url('my-coint') ?>" title="">Xem chi tiết</a>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                    <div class="col-md-9 mt25">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#settings" data-toggle="tab">Cài đặt thông tin tài khoản</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
            			            <?php echo show_flashdata();?>
                                    <?php $level = $this->BackendLevel_Model->Dropdown(); ?>
                                    <form class="form-horizontal" method="post" action="">
                						<?php $error = validation_errors(); echo !empty($error)?'<div class="box-body"><div class="callout callout-danger">'.$error.'</div></div><!-- /.box-body -->':'';?>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-3 control-label">Cấp độ</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('level', set_value('level', ((!empty($DetailCustomers['level'])) ? $level[$DetailCustomers['level']] : 'Cấp cơ bản')), 'class="form-control" readonly="true"');?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-3 control-label">Mức triết khấu</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('discounted', set_value('discounted', discounted_member().'%'), 'class="form-control" readonly="true"');?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('email', set_value('email',$DetailCustomers['email']), 'class="form-control" readonly="true"');?>
                    					       <?php echo form_hidden('old_email', set_value('old_email',$DetailCustomers['email']), 'class="form-control" readonly="true"');?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-3 control-label">AF Link</label>
                                            <div class="col-sm-7 col-9">
                                              <?php echo form_input('affiliate_id', set_value('affiliate_id', base_url().'?aff='.$DetailCustomers['affiliate_id'].''), 'class="form-control" readonly id="affiliate_id"');?>
                                            </div>
                                            <div class="col-sm-2 col-3">
                                                <a id="copy" name="copy" class="btn btn-success" style="width:100%; color:#fff;cursor: pointer" onclick="myFunction()">Copy</a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-3 control-label">Họ tên</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('fullname', set_value('fullname',$DetailCustomers['fullname']), 'class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-3 control-label">Địa chỉ</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('address', set_value('address',$DetailCustomers['address']),'class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-3 control-label">Số điện thoại</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('phone', set_value('phone',$DetailCustomers['phone']), 'class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-3 control-label">Ngày sinh</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('birthday',set_value('birthday',$DetailCustomers['birthday']),'class="form-control"');?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-3 col-sm-9">
                                                <input type="submit" class="btn btn-danger" name="update" value="Cập nhật">
                                            </div>
                                        </div>
                                    </form>
                                    <?php if ($DetailCustomers['nickname'] == ''): ?>
                    			        <form class="form-horizontal" method="post" action="<?php echo site_url('thay-doi-mat-khau'); ?>">
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-3 control-label">Mật khẩu hiện tại</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_password('password', set_value('password'), 'class="form-control"');?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-3 control-label">Mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_password('newpassword', set_value('newpassword'), 'class="form-control"');?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 control-label">Xác nhận mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                    <?php echo form_password('renewpassword', set_value('renewpassword'), 'class="form-control"');?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-3 col-sm-9">
                                                    <input type="submit" class="btn btn-warning" name="update" value="Cập nhật">
                                                </div>
                                            </div>
                                        </form>
                                    <?php endif ?>
                                </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                        </div><!-- /.nav-tabs-custom -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>
    </section><!-- /.content -->
    <script type="text/javascript">
        function openKCFinderAlbum(field, type, result) {
            window.KCFinder = {
                callBack: function(url) {
                    field.attr('src', url);
                    field.parent().next().val(url);
                    window.KCFinder = null;
                }
            };
            if(typeof(type) == 'undefined'){
                type = 'images';
            }
            window.open('<?php echo BASE_URL;?>plugins/kcfinder-master-frontend/browse.php?type='+type+'&dir=images/public', 'kcfinder_image',
                'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                'resizable=1, scrollbars=0, width=1080, height=800'
            );
            return false;
        }
    	$(document).on('click', '.img-thumbnail', function(){
    		openKCFinderAlbum($(this));
    	});
    	$('document').ready(function(){
    		$('#save').click(function(){
    			$('#save').html('<i class="fa fa-cog fa-spin fa-fw"></i>');
    			var img = $('.img-avatar').val();
    			if(img.length > 0){
    				var formURL = 'customers/ajax/customers/avatar';
    				$.post(formURL, {
    				post: img,},
    				function(data){
    					$('.img-thumbnail').val(img);
    					$('#save').html('Lưu');
    				});
    			}
    		});
    	});
    </script>
    <script type="text/javascript">
        function myFunction() {
          /* Get the text field */

          var copyText = document.getElementById("affiliate_id");

          /* Select the text field */
          copyText.select();

          /* Copy the text inside the text field */
          document.execCommand("Copy");

          /* Alert the copied text */

          alert("Copied the text: " + copyText.value);
          return false;
        }
    </script>
</section>