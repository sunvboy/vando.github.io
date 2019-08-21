<section class="page-content" id="customers">
    <div class="top_barr">
        <div class="container">
            <div class="relative">
                <div class="title_name_members">Thành viên: <?php echo $this->fcCustomer['fullname'] ?></div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?php echo site_url('my-profile') ?>"><i class="fas fa-user-tie" aria-hidden="true"></i> Hồ sơ cá nhân</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('thay-doi-mat-khau') ?>"><i class="fab fa-affiliatetheme" aria-hidden="true"></i>Thay đổi mật khẩu</a>
                    </li>

                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('my-order') ?>"> <i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
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



                    </div><!-- /.col -->
                    <div class="col-md-9 mt25">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#settings" data-toggle="tab">Cài đặt thông tin tài khoản</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">

                                    <?php $level = $this->BackendLevel_Model->Dropdown(); ?>
                                    <form class="form-horizontal" method="post" action="">
                                        <?php $error = validation_errors(); echo !empty($error)?'<div class="box-body"><div class="alert alert-danger">'.$error.'</div></div><!-- /.box-body -->':'';?>


                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-3 control-label">Email</label>
                                            <div class="col-sm-9">
                                                <?php echo form_input('email', set_value('email',$DetailCustomers['email']), 'class="form-control" readonly="true"');?>
                    					       <?php echo form_hidden('old_email', set_value('old_email',$DetailCustomers['email']), 'class="form-control" readonly="true"');?>
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
                                            <div class="col-sm-3"></div>

                                            <div class="offset-sm-3 col-sm-9">
                                                <input type="submit" class="btn btn-danger" name="update" value="Cập nhật">
                                            </div>
                                        </div>
                                    </form>

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