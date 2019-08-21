<?php $fcUser = $this->config->item('fcUser');?>
<a href="<?php echo site_url(BACKEND_DIRECTORY);?>" class="logo">
	<span class="logo-mini"><b>A</b>D</span>
	<span class="logo-lg"><b>MyCMS </b>v1.1.0</span>
</a>
<?php  
	$auth = isset($_COOKIE[CODE.'auth'])?$_COOKIE[CODE.'auth']:NULL;
	if(isset($auth) && !empty($auth)){
		$auth = json_decode($auth, TRUE);
	}
?>
<nav class="navbar navbar-static-top" role="navigation">
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>

	<div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
			<li class="language-header <?php echo (($auth['lang'] == 'vietnamese') ? 'active-lang' : '') ?>" data-lang="vietnamese" >
				<img src="templates/backend/images/vietnam.gif" class="img-lang" alt="vietnamese">
			</li>
 			<!-- <li class="language-header <?php //echo (($auth['lang'] == 'english') ? 'active-lang' : '') ?>" data-lang="english" >
				<img src="templates/backend/images/english.png" class="img-lang" alt="english">
			</li>  -->
			<li class="dropdown messages-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-language" aria-hidden="true"></i>
				</a>
			</li><!-- /.messages-menu -->
		<!-- Tasks Menu -->
		<!-- User Account Menu -->
		<li class="dropdown user user-menu">
		<!-- Menu Toggle Button -->
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<!-- The user image in the navbar-->
		<img src="templates/backend/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
		<!-- hidden-xs hides the username on small devices so only the image appears. -->
		<span class="hidden-xs"><?php echo !empty($fcUser['fullname'])?$fcUser['fullname']:$fcUser['email'];?></span>
		</a>
			<ul class="dropdown-menu">
				<li class="user-header">
					<img src="templates/backend/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
					<p>
					<?php echo !empty($fcUser['fullname'])?$fcUser['fullname']:$fcUser['email'];?>
					<small><?php echo $fcUser['groups_title'];?> (<?php echo gettime($fcUser['created']);?>)</small>
					</p>
				</li>
				<li class="user-footer">
					<div class="pull-left">
					<a href="<?php echo site_url('users/backend/account/information');?>" class="btn btn-default btn-flat">Hồ sơ</a>
					</div>
					<div class="pull-right">
					<a href="<?php echo site_url('users/backend/auth/logout');?>" class="btn btn-default btn-flat">Đăng xuất</a>
					</div>
				</li>
			</ul>
		</li>
		</ul>
	</div>
</nav>