<?php $this->fcCustomer = $this->config->item('fcCustomer');?>
<?php $customer = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);  ?>
<a href="<?php echo site_url(BACKEND_DIRECTORY);?>" class="logo">
	<span class="logo-mini"><b>T</b>P</span>
	<span class="logo-lg"><b>CMS </b>v1.1.0</span>
</a>

<nav class="navbar navbar-static-top" role="navigation">
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>
	<style>
		.navbar-nav>.user-menu .user-image {
			float: left;
			width: 25px;
			height: 25px;
			border-radius: 50%;
			margin-right: 10px;
			margin-top: -2px;
		}
	</style>
	<div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
			
		<!-- Tasks Menu -->
		<!-- customer Account Menu -->
		<li class="dropdown customer customer-menu">
		<!-- Menu Toggle Button -->
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<!-- The customer image in the navbar-->
		
		<!-- hidden-xs hides the customername on small devices so only the image appears. -->
		<span class="hidden-xs"><?php echo !empty($customer['fullname'])?$customer['fullname']:$customer['email'];?></span>
		</a>
			<ul class="dropdown-menu" style="padding:20px;width:250px;">
				<li class="customer-header">
					<p>
					<?php echo !empty($customer['fullname'])?$customer['fullname']:$customer['email'];?>
					<small><?php echo $customer['groups_title'];?> (<?php echo gettime($customer['created']);?>)</small>
					</p>
				</li>
				<li class="customer-footer">
					<div class="pull-left">
					<a href="<?php echo site_url('thong-tin-tai-khoan');?>" class="btn btn-default btn-flat">Hồ sơ</a>
					</div>
					<div class="pull-right">
					<a href="<?php echo site_url('logout');?>" class="btn btn-default btn-flat">Đăng xuất</a>
					</div>
				</li>
			</ul>
		</li>
		</ul>
	</div>
</nav>