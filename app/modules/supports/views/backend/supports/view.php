<section class="content-header">
	<h1>Danh sách hỗ trợ trực tuyến</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('supports/backend/supports/view');?>">hỗ trợ trực tuyến</a></li>
	</ol>
</section>

<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group">
					<a href="<?php echo site_url('supports/backend/supports/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('supports/backend/supports/view');?>">
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
					<th>Tên đầy đủ / Email</th>
					<th>Nhóm</th>
					<th>Phone</th>
					<th>Ngày tạo</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($listSupport as $key => $contact){ ?>
				<?php $idc = $contact['cataloguesid']; ?>
				<?php $_catalogue_list = $this->BackendSupportsCatalogues_Model->readcat($idc); ?>

				<tr>
					<td><?php echo $contact['id'];?></td>
					<td><?php echo $contact['fullname'];?> <br /><?php echo $contact['email'];?></td>
					<td>
						<?php if(isset($_catalogue_list) && is_array($_catalogue_list) && count($_catalogue_list)){ 
							foreach($_catalogue_list as $key => $valCat){
								echo $valCat['title'];	
							} 
						} ?>
					</td>
					<td><?php echo $contact['phone'];?></td>
					<td><?php echo $contact['created'];?></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('supports/backend/supports/delete/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('supports/backend/supports/update/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('supports/backend/supports/read/'.$contact['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
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