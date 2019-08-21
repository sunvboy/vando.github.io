<section class="content-header">
	<h1>Chi tiết danh mục Menu</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('navigations/backend/positions/view');?>">Danh mục Menu</a></li>
		<li class="active"><a href="<?php echo site_url('navigations/backend/positions/read/'.$DetailNavigationsPositions['id']);?>">Chi tiết danh mục Menu</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<section class="invoice">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="page-header">
							<i class="fa fa-envelope"></i> #<?php echo $DetailNavigationsPositions['id'];?>
							<small class="pull-right">Ngày tạo: <?php echo gettime($DetailNavigationsPositions['created']);?></small>
						</h2>
					</div><!-- /.col -->
				</div>
				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						<b>Danh mục Menu</b><br>
						<br>
						<address>
						<strong><?php echo $DetailNavigationsPositions['title'];?></strong><br>
						</address>
					</div><!-- /.col -->
					<div class="col-sm-8 invoice-col">
						<b>Thông tin</b><br>
						<br>
						<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailNavigationsPositions['publish']);?><br>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row">
					<div class="col-xs-12">
						<p class="lead">Mô tả:</p>
						<div class="text-muted well well-sm no-shadow">
						<?php echo $DetailNavigationsPositions['description'];?>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row no-print">
					<div class="col-xs-12">
						<a href="<?php echo site_url('navigations/backend/positions/update/'.$DetailNavigationsPositions['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> Cập nhật</a>
						<a href="<?php echo site_url('navigations/backend/positions/delete/'.$DetailNavigationsPositions['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-credit-trash"></i> Xóa bỏ</a>
					</div>
				</div>
			</section><!-- /.content -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->