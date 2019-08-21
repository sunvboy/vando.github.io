<section class="content-header">
	<h1>Danh mục thuộc tính</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('attributes/backend/catalogues/view');?>">Danh mục thuộc tính</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-flat" id="btnsort"><i class="fa fa-sort"></i> Sắp xếp</button>
					<a href="<?php echo site_url('attributes/backend/catalogues/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('attributes/backend/catalogues/view');?>">
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
		<?php if(isset($ListAttributes) && is_array($ListAttributes) && count($ListAttributes)){ ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>ID</th>
					<th>Tiêu đề</th>
					<th>Modules</th>
					<th>Vị trí</th>
					<th>thuộc tính</th>
					<th>Thông tin</th>
					<th>Thời gian</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($ListAttributes as $key => $item){ ?>
				<tr>
					<td><?php echo $item['id'];?></td>
					<td><?php echo $item['title']; ?></td>
					<td><?php echo $item['modules']; ?></td>
					<td><?php echo form_input('order['.$item['id'].']', $item['order'], 'class="form-control" placeholder="Vị trí" style="width:50px;"');?></td>
					<td><?php echo $item['count_attributes'];?></td>
					<td>
						<b>Trạng thái:</b> <?php echo $this->configbie->data('publish', $item['publish']);?><br />
					</td>
					<td><?php echo gettime($item['created']);?></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('attributes/backend/catalogues/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default "><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('attributes/backend/catalogues/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('attributes/backend/catalogues/read/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
						</div>
					 </td>
				</tr>
				<?php } ?>
			</table>
			</form>
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
<script type="text/javascript">
$(document).ready(function(){
	$('#btnsort').click(function(){
		$.post('<?php echo site_url('attributes/ajax/catalogues/sort')?>', $('#fcFrom').serialize(), function(data){
			location.reload();
		})
		return false;
	})
})
</script>