<?php 
	$this->fcCustomer = $this->config->item('fcCustomer');
	$customer = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']); 
?>
<section class="sidebar">
	<div class="user-panel">
		<div class="pull-left image img-fit">
			<img src="<?php echo (!empty($customer['images'])) ? $customer['images'] : 'templates/not-found.png'; ?>" class="img-circle" alt="User Image">
		</div>
		<?php $this->fcCustomer = $this->config->item('fcCustomer');
		?>
		<div class="pull-left info">
			<p><?php echo $this->fcCustomer['fullname']; ?></p>
			<a href="<?php echo site_url('users/backend/account/information');?>"><i class="fa fa-circle text-success"></i> Online</a>
		</div>
	</div>
	<form action="#" method="get" class="sidebar-form">
		<div class="input-group">
			<input type="text" name="q" class="form-control" placeholder="Search...">
			<span class="input-group-btn">
				<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form><!-- /.search form -->
	<ul class="sidebar-menu">
		<li class="treeview <?php echo ($this->router->module == 'customers')?'active':'';?>">
			<a href=""><i class="fa fa-cog" aria-hidden="true"></i> <span>Quản lý</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="<?php echo site_url('thong-tin-tai-khoan'); ?>"><i class="fa fa-caret-right"></i> Quản lý thông tin<span class="pull-right-container">
				</span></a></li>
				<!-- <li><a href="<?php echo site_url('danh-sach-bai-thi'); ?>"><i class="fa fa-caret-right"></i> Quản lý bài thi<span class="pull-right-container"> -->
				<!-- </span></a></li> -->
			</ul>
		</li>
	</ul><!-- /.sidebar-menu -->
</section><!-- /.sidebar -->