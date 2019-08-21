<section class="content-header">
	<h1>Danh sách dự án</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('places/backend/places/view');?>">dự án</a></li>
	</ol>
</section>

<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group">
					<a href="<?php echo site_url('places/backend/places/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('places/backend/places/view');?>">
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
		<?php if(isset($listPlaces) && is_array($listPlaces) && count($listPlaces)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Tên dự án</th>
					<th>Thành Phô</th>
					<th>Quận</th>
					<th>Huyện</th>
					<th class="text-center">Kích hoạt</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($listPlaces as $key => $contact){ ?>
				<tr>
					<?php 
						
					?>
					<td><?php echo $contact['id'];?></td>
					<td><?php echo $contact['title'];?></td>
					<td><?php echo $this->BackendProjects_Model->read_location($contact['cityid']);?></td>
					<td><?php echo $this->BackendProjects_Model->read_location($contact['districtid']);?></td>
					<td><?php echo $this->BackendProjects_Model->read_location($contact['wardid']);?></td>
					<td>
						<a href="<?php echo site_url('places/backend/places/set/publish/'.$contact['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo ($contact['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('places/backend/places/delete/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('places/backend/places/update/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
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