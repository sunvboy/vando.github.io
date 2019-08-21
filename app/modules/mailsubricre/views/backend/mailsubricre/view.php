<section class="content-header">
	<h1>Danh sách kho hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('mailsubricre/backend/mailsubricre/view');?>">Kho hàng</a></li>
	</ol>
</section>

<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('mailsubricre/backend/mailsubricre/view');?>">

					<div class="input-group pull-left" style="width: 250px;">
						<input type="text" name="keyword" value="<?php echo htmlspecialchars($this->input->get('keyword'));?>" class="form-control" placeholder="Search">
						<div class="input-group-btn">
							<button type="submit" value="action" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.box-header -->
		<?php echo show_flashdata();?>
		<?php if(isset($listemail) && is_array($listemail) && count($listemail)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
				<tr>
					<th>ID</th>

					<th>Email</th>
<!--					<th>Số điện thoại</th>-->
<!--					<th>Ngày đăng ký</th>-->
<!--					<th>Trạng thái</th>-->
					<th class="text-center">Thao tác</th>
				</tr>
				<?php foreach($listemail as $key => $email){ ?>
				<tr>
					<td><?php echo $email['id'];?></td>
					<td><?php echo $email['email'];?></td>


					<td class="hide">
						<a href="<?php echo site_url('mailsubricre/backend/mailsubricre/set/publish/'.$email['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo ($email['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('mailsubricre/backend/mailsubricre/update/'.$email['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default hide"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('mailsubricre/backend/mailsubricre/delete/'.$email['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
						</div>
					 </td>
				</tr>
				<?php } ?>
			</table>
		</div><!-- /.box-body -->
		<?php } else { ?>
		<div class="box-body">
			<div class="callout callout-danger">Không có dữ liệu</div>
		</div><!-- /.box-body -->
		<?php } ?>
		<div class="box-footer clearfix">
			<?php echo isset($listPagination)?$listPagination:'';?>
		</div>
	  </div><!-- /.box -->
	</div>
  </div>
</section><!-- /.content -->