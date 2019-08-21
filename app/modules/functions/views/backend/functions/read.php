<section class="content-header">
	<h1>Chi tiết modules</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li><a href="<?php echo site_url('supports/backend/supports/view');?>">modules</a></li>
		<li class="active"><a href="<?php echo site_url('supports/backend/supports/read/'.$DetailSupports['id']);?>">Chi tiết modules</a></li>
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
							<small class="pull-right">Ngày gửi: <?php echo show_time($DetailSupports['created']);?></small>
						</h2>
					</div><!-- /.col -->
				</div>
				<div class="row invoice-info">
					<?php echo show_flashdata();?>
					<div class="col-sm-4 invoice-col">
						<b>Người gửi</b><br>
						<br>
						<address>
						<strong><?php echo $DetailSupports['fullname'];?></strong><br>
						Điện thoại: <?php echo $DetailSupports['phone'];?><br>
						Email: <?php echo $DetailSupports['email'];?>
						</address>
					</div><!-- /.col -->
					<div class="col-sm-4 invoice-col">
						<b>Thông tin</b><br>
						
						<b>Xuất bản:</b> <?php echo $this->configbie->data('publish', $DetailSupports['publish']);?><br>
					</div><!-- /.col -->
				</div><!-- /.row -->
				
				<div class="row no-print">
					<div class="col-xs-12">
						<a href="<?php echo site_url('supports/backend/supports/update/'.$DetailSupports['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-primary pull-right"><i class="fa fa-edit"></i> Cập nhật</a>
						<a href="<?php echo site_url('supports/backend/supports/delete/'.$DetailSupports['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-credit-trash"></i> Xóa bỏ</a>
					</div>
				</div>
			</section><!-- /.content -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->