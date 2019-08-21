<section class="content-header">
	<h1>Danh sách nơi nhận liên hệ</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('contacts/backend/receiver/view');?>">Nơi nhận liên hệ</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group">
					<a href="<?php echo site_url('contacts/backend/receiver/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('contacts/backend/receiver/view');?>">
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
		<?php if(isset($listContacts) && is_array($listContacts) && count($listContacts)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Nơi nhận</th>
					<th>Liên hệ</th>
					<th>Mô tả</th>
					<th>Thông tin</th>
					<th>Thời gian</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($listContacts as $key => $contact){ ?>
				<tr>
					<td><?php echo $contact['id'];?></td>
					<td><?php echo $contact['name'];?></td>
					<td><?php echo $contact['count_contacts'];?></td>
					<td style="max-width:268px;"><?php echo cutnchar(strip_tags($contact['description']), 168);?></td>
					<td><b>Trạng thái:</b> <?php echo $this->configbie->data('publish', $contact['publish']);?></td>
					<td><?php echo show_time($contact['created']);?></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('contacts/backend/receiver/delete/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('contacts/backend/receiver/update/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('contacts/backend/receiver/read/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
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