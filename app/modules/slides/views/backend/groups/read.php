<section class="content-header">
	<h1>Chi tiết Danh mục bài viết</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('slides/backend/groups/view');?>">Danh mục bài viết</a></li>
		<li class="active"><a href="<?php echo site_url('slides/backend/groups/read/'.$detailSlidesGroups['id']);?>">Chi tiết Danh mục bài viết</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<section class="invoice">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="page-header">
							<i class="fa fa-envelope"></i> #<?php echo $detailSlidesGroups['id'];?>
							<small class="pull-right">Ngày tạo: <?php echo show_time($detailSlidesGroups['created']);?></small>
						</h2>
					</div><!-- /.col -->
				</div>
				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						<b>Danh mục bài viết</b><br>
						<br>
						<address>
						<strong><?php echo $detailSlidesGroups['title'];?></strong><br>
						</address>
					</div><!-- /.col -->
					<div class="col-sm-8 invoice-col">
						<b>Thông tin</b><br>
						<br>
						<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $detailSlidesGroups['publish']);?><br>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row">
					<div class="col-xs-12">
						<p class="lead">Mô tả:</p>
						<div class="text-muted well well-sm no-shadow">
						<?php echo $detailSlidesGroups['description'];?>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
				<div class="row no-print">
					<div class="col-xs-12">
						<a href="<?php echo site_url('slides/backend/groups/update/'.$detailSlidesGroups['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> Cập nhật</a>
						<a href="<?php echo site_url('slides/backend/groups/delete/'.$detailSlidesGroups['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-credit-trash"></i> Xóa bỏ</a>
					</div>
				</div>
			</section><!-- /.content -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->