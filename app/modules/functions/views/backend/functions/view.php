<section class="content-header">
	<h1>Danh sách modules</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('functions/backend/functions/view');?>">modules</a></li>
	</ol>
</section>

<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group">
					<a href="<?php echo site_url('functions/backend/functions/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('functions/backend/functions/view');?>">
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
		<?php if(isset($listSupport) && is_array($listSupport) && count($listSupport)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Tên modules</th>
					<th>Từ khóa</th>
					<th style="text-align:center;">Kích hoạt </th>
					<th class="text-center">Thao tác</th>
				</tr>
				<?php foreach($listSupport as $key => $item){ ?>
				<tr>
					<td><?php echo $item['id'];?></td>
					<td><?php echo $item['title'];?></td>
					<td><?php echo $item['keyword'];?></td>
					<td style="text-align:center;">
						<a href="<?php echo site_url('functions/backend/functions/set/publish/'.$item['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo ($item['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td class="text-center">
						<div class="btn-group">
							<a href="<?php echo site_url('functions/backend/functions/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
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