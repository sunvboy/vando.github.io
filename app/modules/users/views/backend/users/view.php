<section class="content-header">
	<h1>Thành viên</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('users/backend/users/view');?>">Thành viên</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<?php if (in_array('users/backend/dirs/create', $this->fcUser['group'])): ?>
				<h3 class="box-title pull-right">
					<div class="btn-group">
						<a href="<?php echo site_url('users/backend/users/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
					</div>
				</h3>
			<?php endif ?>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('users/backend/users/view');?>">
					<div class="pull-left" style="width: 200px;margin-right:8px;">
					<?php echo form_dropdown('groupsid', $this->BackendUsersGroups_Model->dropdown(), set_value('groupsid', $this->input->get('groupsid')), 'class="form-control"');?>
					</div>
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
		<?php if(isset($ListUsers) && is_array($ListUsers) && count($ListUsers)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>ID</th>
					<th>Email</th>
					<th>Tên đầy đủ</th>
					<th>Nhóm</th>
					<th>Ngày tạo</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($ListUsers as $key => $item){ ?>
				<tr>
					<td><?php echo $item['id'];?></td>
					<td><?php echo $item['email']; ?></td>
					<td><?php echo $item['fullname']; ?></td>
					<td><?php echo $item['group_title']; ?></td>
					<td><?php echo gettime($item['created']);?></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('users/backend/users/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('users/backend/users/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('users/backend/users/read/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
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
			<?php echo isset($ListPagination)?$ListPagination:'';?>
		</div>
	  </div><!-- /.box -->
	</div>
  </div>
</section><!-- /.content -->