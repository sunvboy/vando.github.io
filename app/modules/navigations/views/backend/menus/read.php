<section class="content-header">
	<h1>Chi tiết bài viết</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('navigations/backend/menus/view');?>">bài viết</a></li>
		<li class="active"><a href="<?php echo site_url('navigations/backend/menus/read/'.$DetailNavigationsMenus['id']);?>">Chi tiết bài viết</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<section class="invoice">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="page-header">
							<i class="fa fa-envelope"></i> #<?php echo $DetailNavigationsMenus['id'];?>
							<small class="pull-right">Ngày tạo: <?php echo gettime($DetailNavigationsMenus['created']);?></small>
						</h2>
					</div><!-- /.col -->
				</div>
				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						<b>Menu</b><br>
						<br>
						<address>
						<strong><?php echo $DetailNavigationsMenus['title'];?></strong><br>
						</address>
					</div><!-- /.col -->
					<div class="col-sm-8 invoice-col">
						<b>Thông tin</b><br>
						<br>
						<b>Href:</b> <?php echo $DetailNavigationsMenus['href'];?><br>
						<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailNavigationsMenus['publish']);?><br>
						<br>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<?php if(isset($MenusItems) && is_array($MenusItems) && count($MenusItems)){ foreach($MenusItems as $key => $val){ ?>
				<div class="row invoice-info">
					<label class="col-xs-1 control-label">(<?php echo ($key+1);?>)</label>
					<div class="col-xs-3"><?php echo $val['title'];?></div>
					<div class="col-xs-7"><?php echo $val['href'];?></div>
					<div class="col-xs-1"><?php echo $val['order'];?></div>
				</div><!-- /.row -->
				<?php } } ?>
				<div class="row no-print">
					<div class="col-xs-12"><br><br>
						<a href="<?php echo site_url('navigations/backend/menus/update/'.$DetailNavigationsMenus['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> Cập nhật</a>
						<a href="<?php echo site_url('navigations/backend/menus/delete/'.$DetailNavigationsMenus['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-credit-trash"></i> Xóa bỏ</a>
					</div>
				</div>
			</section><!-- /.content -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->