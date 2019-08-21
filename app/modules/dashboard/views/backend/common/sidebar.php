<?php $dropdown = $this->BackendFunctions_Model->Dropdown(); ?>
<section class="sidebar">
	<div class="user-panel">
		<div class="pull-left image">
			<img src="templates/backend/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
		</div>
		<?php $this->fcUser = $this->config->item('fcUser');
		?>
		<div class="pull-left info">
			<p><?php echo $this->fcUser['fullname']; ?></p>
			<a href="<?php echo site_url('users/backend/account/information');?>"><i class="fa fa-circle text-success"></i>Online</a>
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
	<?php if(in_array('error/backend/error/view', $this->fcUser['group']) && in_array('error', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'error')?'active':'';?>">
			<a href="<?php echo site_url('error/backend/error/view');?>"><i class="fa fa-bell"></i><span>Báo lỗi</span> <i class="fa fa-angle-left pull-right"></i></a>
		</li>
	<?php } ?>

	<?php if(in_array('comments/backend/comments/view', $this->fcUser['group']) && in_array('comments', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'comments')?'active':'';?>">
			<a href="<?php echo site_url('comments/backend/comments/view');?>"><i class="fa fa-comments-o"></i><span>Bình luận</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('comments/backend/comments/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('comments/backend/comments/view');?>"><i class="fa fa-caret-right"></i>Danh sách bình luận</a></li>
			<?php } ?>
			<?php if(in_array('comments/backend/icon/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('comments/backend/icon/view');?>"><i class="fa fa-caret-right"></i>Danh sách icons</a></li>
			<?php } ?>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('teachers/backend/teachers/view', $this->fcUser['group']) && in_array('teachers', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'teachers')?'active':'';?>">
			<a href="<?php echo site_url('teachers/backend/teachers/view');?>">
				<i class="fa fa-user-plus"></i><span>Giảng viên</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo site_url('teachers/backend/teachers/view');?>"><i class="fa fa-caret-right"></i>Danh sách giảng viên</a></li>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('customers/backend/groups/view', $this->fcUser['group']) && in_array('customers', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'customers')?'active':'';?>">
			<a href="<?php echo site_url('customers/backend/customers/view');?>"><i class="fa fa-user-plus"></i><span>Thành viên</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<?php if(in_array('customers/backend/groups/view', $this->fcUser['group'])){ ?>
					<li><a href="<?php echo site_url('customers/backend/groups/view');?>"><i class="fa fa-caret-right"></i>Nhóm thành viên</a></li>
				<?php } ?>
				<?php if(in_array('customers/backend/level/view', $this->fcUser['group'])){ ?>
					<li class="hide"><a href="<?php echo site_url('customers/backend/level/view');?>"><i class="fa fa-caret-right"></i>Level thành viên</a></li>
				<?php } ?>
				<li><a href="<?php echo site_url('customers/backend/customers/view');?>"><i class="fa fa-caret-right"></i>Danh sách thành viên</a></li>
				<?php if(in_array('customers/backend/affiliate/view', $this->fcUser['group'])){ ?>
					<li class="hide"><a href="<?php echo site_url('customers/backend/affiliate/view');?>"><i class="fa fa-caret-right"></i>Lịch sử nhận Affiliate</a></li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>

	<?php if((in_array('statistics/backend/statistics/view', $this->fcUser['group']) || in_array('statistics/backend/trafix/view', $this->fcUser['group'])) && in_array('statistics', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'statistics')?'active':'';?>">
			<a href="<?php echo site_url('statistics/backend/statistics/view');?>"><i class="fa fa-bar-chart"></i><span>Thống kê Affiliate</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<?php if(in_array('statistics/backend/statistics/view', $this->fcUser['group'])){ ?>
					<li><a href="<?php echo site_url('statistics/backend/statistics/view');?>"><i class="fa fa-caret-right"></i>Thống kê doanh thu</a></li>
				<?php } ?>
				<?php if(in_array('statistics/backend/trafix/view', $this->fcUser['group'])){ ?>
					<li><a href="<?php echo site_url('statistics/backend/trafix/view');?>"><i class="fa fa-caret-right"></i>Thống kê trafix</a></li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('idea/backend/idea/view', $this->fcUser['group']) && in_array('idea', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'idea')?'active':'';?>">
			<a href="<?php echo site_url('idea/backend/idea/view');?>"><i class="fa fa-comments-o"></i><span>Ý kiến khách hàng</span> <i class="fa fa-angle-left pull-right"></i></a>
		</li>
	<?php } ?>
	<?php if(in_array('idea/backend/team/view', $this->fcUser['group']) && in_array('idea', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'idea')?'active':'';?>">
			<a href="<?php echo site_url('idea/backend/team/view');?>"><i class="fa fa-comments-o"></i><span>Đội ngũ</span> <i class="fa fa-angle-left pull-right"></i></a>
		</li>
	<?php } ?>

	<?php if(in_array('products/backend/products/view', $this->fcUser['group']) && in_array('products', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'products')?'active':'';?>">
			<a href="<?php echo site_url('products/backend/products/view');?>"><i class="fa fa-cube" aria-hidden="true"></i><span>Sản phẩm</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('products/backend/catalogues/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('products/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i>Danh mục</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('products/backend/products/view');?>"><i class="fa fa-caret-right"></i>Danh sách sản phẩm</a></li>

				<li><a href="<?php echo site_url('products/backend/SalesDG/view');?>"><i class="fa fa-caret-right"></i>Sale đồng giá & outlet cho tất cả sản phẩm</a></li>
				<li><a href="<?php echo site_url('products/backend/SalesDG/viewchotungsanpham');?>"><i class="fa fa-caret-right"></i>Sale cho từng sản phẩm</a></li>
				<li><a href="<?php echo site_url('products/backend/SalesDG/viewsalesoluong');?>"><i class="fa fa-caret-right"></i>Sale theo số sản phẩm<br>Giờ vàng mua sắm</a></li>

			</ul>
		</li>
	<?php } ?>
	<?php if(in_array('projects/backend/projects/view', $this->fcUser['group']) && in_array('projects', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'projects')?'active':'';?>">
			<a href="<?php echo site_url('projects/backend/projects/view');?>"><i class="fa fa-building-o" aria-hidden="true"></i> <span>Tin dự án</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('projects/backend/catalogues/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('projects/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i> Danh mục</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('projects/backend/projects/view');?>"><i class="fa fa-caret-right"></i> Tin đăng</a></li>
			</ul>
		</li>
	<?php } ?>
	<?php if(in_array('places/backend/places/view', $this->fcUser['group']) && in_array('places', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'places')?'active':'';?>">
			<a href="<?php echo site_url('places/backend/places/view');?>"><i class="fa fa-building-o" aria-hidden="true"></i> <span>Dự án</span></a>
		</li>
	<?php } ?>
	<?php if(in_array('payments/backend/payments/view', $this->fcUser['group']) && in_array('payments', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'payments')?'active':'';?>">
			<a href="<?php echo site_url('payments/backend/payments/view');?>"><i class="fa fa-cart-plus" aria-hidden="true"></i><span>Đơn hàng</span><i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="<?php echo site_url('payments/backend/payments/view');?>"><i class="fa fa-caret-right"></i>Danh sách đơn hàng</a></li>
				<?php if(in_array('payments/backend/payments/export', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('payments/backend/payments/export');?>"><i class="fa fa-caret-right"></i>Trích xuất</a></li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>
		<?php if(in_array('sanphamtangkem/backend/sanphamtangkem/view', $this->fcUser['group']) && in_array('sanphamtangkem', $dropdown)){ ?>
			<li class="treeview <?php echo ($this->router->module == 'sanphamtangkem')?'active':'';?>">
				<a href="<?php echo site_url('sanphamtangkem/backend/sanphamtangkem/view');?>"><i class="fa fa-gift" aria-hidden="true"></i><span>Sản phẩm tặng kèm</span></a>
			</li>
		<?php } ?>
        <?php if(in_array('combos/backend/combos/view', $this->fcUser['group']) && in_array('combos', $dropdown)){ ?>
                <li><a href="<?php echo site_url('combos/backend/combos/view');?>"><i class="fa fa-creative-commons" aria-hidden="true"></i>Combo sản phẩm<span class="pull-right-container">
				</span></a></li>
        <?php } ?>
	<?php if(in_array('coupon/backend/coupon/view', $this->fcUser['group']) && in_array('coupon', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'coupon')?'active':'';?>">
			<a href="<?php echo site_url('coupon/backend/coupon/view');?>"><i class="fa fa-gift" aria-hidden="true"></i><span>Khuyến mại</span></a>
		</li>
	<?php } ?>

	<?php if(in_array('attributes/backend/attributes/view', $this->fcUser['group']) && in_array('attributes', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'attributes')?'active':'';?>">
			<a href="<?php echo site_url('attributes/backend/attributes/view');?>"><i class="fa fa-expand" aria-hidden="true"></i><span>Thuộc tính</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('attributes/backend/catalogues/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('attributes/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i>Nhóm thuộc tính</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('attributes/backend/attributes/view');?>"><i class="fa fa-caret-right"></i>Thuộc tính</a></li>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('lichhoc/backend/chungchi/view', $this->fcUser['group']) && in_array('lichhoc', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'contacts')?'active':'';?>">
			<a href="<?php echo site_url('lichhoc/backend/chungchi/view');?>"><i class="fa fa-calendar" aria-hidden="true"></i><span>CV-Tuyển dụng</span> <i class="fa fa-angle-left pull-right"></i></a>
		</li>
	<?php } ?>

	<?php if(in_array('articles/backend/articles/view', $this->fcUser['group']) && in_array('articles', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'articles')?'active':'';?>">
			<a href="<?php echo site_url('articles/backend/articles/view');?>"><i class="fa fa-file-text-o"></i><span>Bài viết</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('articles/backend/catalogues/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('articles/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i>Danh mục</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('articles/backend/articles/view');?>"><i class="fa fa-caret-right"></i>Danh sách bài viết</a></li>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('gallerys/backend/gallerys/view', $this->fcUser['group']) && in_array('gallerys', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'gallerys')?'active':'';?>">
			<a href="<?php echo site_url('gallerys/backend/gallerys/view');?>"><i class="fa fa-photo"></i><span>Hình ảnh</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('gallerys/backend/catalogues/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('gallerys/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i>Danh mục</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('gallerys/backend/gallerys/view');?>"><i class="fa fa-caret-right"></i>Danh sách album ảnh</a></li>
			</ul>
		</li>
	<?php } ?>
	<?php if(in_array('videos/backend/videos/view', $this->fcUser['group']) && in_array('videos', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'videos')?'active':'';?>">
			<a href="<?php echo site_url('videos/backend/videos/view');?>"><i class="fa fa-file-video-o"></i><span>Video</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('videos/backend/catalogues/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('videos/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i>Danh mục</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('videos/backend/videos/view');?>"><i class="fa fa-caret-right"></i>Danh sách video</a></li>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('tags/backend/tags/view', $this->fcUser['group']) && in_array('tags', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'tags')?'active':'';?>">
			<a href="<?php echo site_url('tags/backend/tags/view');?>"><i class="fa fa-tags"></i><span>Từ khóa</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="<?php echo site_url('tags/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i>Danh mục</a></li>
				<li><a href="<?php echo site_url('tags/backend/tags/view');?>"><i class="fa fa-caret-right"></i>Từ khóa</a></li>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('contacts/backend/home/view', $this->fcUser['group']) && in_array('contacts', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'contacts')?'active':'';?> <?php echo ($this->router->module == 'mailsubricre')?'active':'';?>">
			<a href="<?php echo site_url('contacts/backend/home/view');?>"><i class="fa fa-calendar" aria-hidden="true"></i><span>Liên hệ</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('contacts/backend/receiver/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('contacts/backend/receiver/view');?>"><i class="fa fa-caret-right"></i>Nhóm Liên hệ</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('contacts/backend/home/view');?>"><i class="fa fa-caret-right"></i>Danh sách liên hệ</a></li>

			</ul>
		</li>
	<?php } ?>
		<?php if(in_array('mailsubricre/backend/mailsubricre/view', $this->fcUser['group']) && in_array('mailsubricre', $dropdown)){ ?>
			<?php if(in_array('mailsubricre/backend/mailsubricre/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('mailsubricre/backend/mailsubricre/view');?>"><i class="fa fa-calendar" aria-hidden="true"></i>Danh sách đăng ký nhận bản tin</a></li>
			<?php } ?>
		<?php } ?>

	<?php if(in_array('address/backend/address/view', $this->fcUser['group']) && in_array('address', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'address')?'active':'';?>">
			<a href="<?php echo site_url('address/backend/address/view');?>">
				<i class="fa fa-download"></i><span>Biểu mẫu</span> <i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<?php if(in_array('address/backend/address/view', $this->fcUser['group'])){ ?>
					<li>
						<a href="<?php echo site_url('address/backend/address/view');?>">
							<i class="fa fa-caret-right"></i>Danh sách Files
						</a>
					</li>
				<?php } ?>
				<?php if(in_array('address/backend/hedaotao/view', $this->fcUser['group'])){ ?>
					<li>
						<a href="<?php echo site_url('address/backend/hedaotao/view');?>">
							<i class="fa fa-caret-right"></i>Danh sách chứng chỉ
						</a>
					</li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('supports/backend/supports/view', $this->fcUser['group']) && in_array('supports', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'supports')?'active':'';?>">
			<a href="<?php echo site_url('supports/backend/supports/view');?>"><i class="fa fa-life-ring" aria-hidden="true"></i><span>Hỗ trợ trực tuyến</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
			<?php if(in_array('supports/backend/catalogues/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('supports/backend/catalogues/view');?>"><i class="fa fa-caret-right"></i>Nhóm Hỗ trợ</a></li>
			<?php } ?>
				<li><a href="<?php echo site_url('supports/backend/supports/view');?>"><i class="fa fa-caret-right"></i>Danh sách hỗ trợ</a></li>
			</ul>
		</li>
	<?php } ?>

	<?php if(in_array('users/backend/users/view', $this->fcUser['group']) && in_array('users', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'users')?'active':'';?>">
			<a href="<?php echo site_url('users/backend/users/view');?>"><i class="fa fa-users"></i><span>Quản trị viên</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<?php if (in_array('users/backend/groups/view', $this->fcUser['group'])): ?>
					<li><a href="<?php echo site_url('users/backend/groups/view');?>"><i class="fa fa-caret-right"></i>Nhóm</a></li>
				<?php endif ?>
				<li><a href="<?php echo site_url('users/backend/users/view');?>"><i class="fa fa-caret-right"></i>Thành viên</a></li>
			</ul>
		</li>
		<?php } ?>
		<?php if(in_array('systems/backend/systems/view', $this->fcUser['group']) && in_array('systems', $dropdown)){ ?>
		<li class="treeview <?php echo ($this->router->module == 'systems')?'active':'';?> <?php echo ($this->router->module == 'slides')?'active':'';?> <?php echo ($this->router->module == 'navigations')?'active':'';?> <?php echo ($this->router->module == 'files')?'active':'';?> <?php echo ($this->router->module == 'functions')?'active':'';?>">
			<a href="<?php echo site_url('systems/backend/systems/view');?>"><i class="fa fa-cog"></i><span>Hệ thống</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<?php if(in_array('slides/backend/groups/view', $this->fcUser['group'])){ ?>
					<li class="treeview <?php echo ($this->router->module == 'slides')?'active':'';?>">
						<a href="<?php echo site_url('slides/backend/groups/view');?>"><i class="fa fa-caret-right"></i><span>Slide</span></a>
					</li>
				<?php } ?>
			<?php if(in_array('systems/backend/systems/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('systems/backend/systems/view');?>"><i class="fa fa-caret-right"></i>Hệ thống</a></li>
			<?php } ?>
			<?php if(in_array('navigations/backend/positions/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('navigations/backend/menus/view');?>"><i class="fa fa-caret-right"></i>Menu</a></li>
			<?php } ?>
			<?php if(in_array('files/backend/files/view', $this->fcUser['group'])){ ?>
				<li><a href="<?php echo site_url('files/backend/files/view');?>"><i class="fa fa-caret-right"></i>Upload Files</a></li>
			<?php } ?>
			<?php if($this->fcUser['id'] == 3){ ?>
				<li><a href="<?php echo site_url('functions/backend/functions/view');?>"><i class="fa fa-caret-right"></i>Modules</a></li>
			<?php } ?>
			</ul>
		</li>
		<?php } ?>
	</ul><!-- /.sidebar-menu -->
</section><!-- /.sidebar -->