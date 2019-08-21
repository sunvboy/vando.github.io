<section class="content-header">
	<h1>Chi tiết dự án</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('places/backend/places/view');?>">dự án</a></li>
		<li class="active"><a href="<?php echo site_url('places/backend/places/read/'.$DetailPlaces['id']);?>">Chi tiết dự án</a></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<section class="invoice">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="page-header">
							<i class="fa fa-envelope"></i> 
							<small class="pull-right">Ngày gửi: <?php echo show_time($DetailPlaces['created']);?></small>
						</h2>
					</div><!-- /.col -->
				</div>
				<div class="row invoice-info">
					<?php echo show_flashdata();?>
					<div class="col-sm-4 invoice-col">
						<b>Người gửi</b><br>
						<br>
						<address>
						<strong><?php echo $DetailPlaces['title'];?></strong><br>
						</address>
					</div><!-- /.col -->
					<div class="col-sm-4 invoice-col">
						<b>Thông tin</b><br>
						
						<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailPlaces['publish']);?><br>
					</div><!-- /.col -->
				</div><!-- /.row -->
				
				<div class="row no-print">
					<div class="col-xs-12">
						<a href="<?php echo site_url('places/backend/places/update/'.$DetailPlaces['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> Cập nhật</a>
						<a href="<?php echo site_url('places/backend/places/delete/'.$DetailPlaces['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-credit-trash"></i> Xóa bỏ</a>
					</div>
				</div>
			</section><!-- /.content -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->