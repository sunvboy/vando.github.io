<section class="content-header">
	<h1>Bài viết</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('navigations/backend/menus/view');?>">Bài viết</a></li>
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
					<a href="<?php echo site_url('navigations/backend/menus/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('navigations/backend/menus/view');?>">
					<div class="pull-left" style="width: 200px;margin-right:8px;">
					<?php echo form_dropdown('positionsid', $this->BackendNavigationsPositions_Model->dropdown(), set_value('positionsid', $this->input->get('positionsid')), 'class="form-control"');?>
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
		<?php if(isset($Listnavigations) && is_array($Listnavigations) && count($Listnavigations)){ ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>ID</th>
					<th>Tiêu đề</th>
					<th>Menu</th>
					<th>Vị trí</th>
					<th>Sắp xếp</th>
					<th>Người tạo</th>
					<th>Thời gian</th>
					<th>Xuất bản</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($Listnavigations as $key => $item){ ?>
					<tr>
						<td><?php echo $item['id'];?></td>
						<td><?php echo $item['title']; ?></td>
						<td><?php echo $item['count_menus_items']; ?></td>
						<td><a style="color:#333;" href="<?php echo site_url('navigations/backend/menus/view?positionsid='.$item['positionsid'].'') ?>" title="<?php echo $item['positions']; ?>"><?php echo $item['positions']; ?></a></td>
						<td><?php echo form_input('order['.$item['id'].']', $item['order'], 'class="form-control" placeholder="Vị trí" style="width:50px;"');?></td>
						<td><?php echo $item['fullname']; ?></td>
						
						<td><?php echo gettime($item['created']);?></td>
						<td>
							<a href="<?php echo site_url('navigations/backend/menus/set/publish/'.$item['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
								<img src="<?php echo ($item['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
							</a>
						</td>
						<td class="text-right">
							<div class="btn-group">
								<a href="<?php echo site_url('navigations/backend/menus/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
								<a href="<?php echo site_url('navigations/backend/menus/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
								<a href="<?php echo site_url('navigations/backend/menus/read/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
							</div>
						 </td>
					</tr>
					
					<?php 
						if(isset($item['child']) && is_array($item['child']) && count($item['child'])){
							show_parent_id($item['child']);
						}
					?>
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
			<?php //echo isset($ListPagination)?$ListPagination:'';?>
		</div>
	  </div><!-- /.box -->
	</div>
  </div>
</section><!-- /.content -->
<script type="text/javascript">
$(document).ready(function(){
	$('#btnsort').click(function(){
		$.post('<?php echo site_url('navigations/ajax/menu/sort')?>', $('#fcFrom').serialize(), function(data){
			location.reload();
		})
		return false;
	})
})
</script>

<?php  
	function show_parent_id($item = '', $text = ''){
		if(isset($item) && is_array($item) && count($item)){
			$text = "".$text."|---";
			foreach($item as $key => $items){ ?>
				<tr>
					<td><?php echo $items['id'];?></td>
					<td><?php echo $text ?>  <?php echo $items['title']; ?></td>
					<td><?php echo $items['count_menus_items']; ?></td>
					<td><a style="color:#333;" href="<?php echo site_url('navigations/backend/menus/view?positionsid='.$items['positionsid'].'') ?>" title="<?php echo $items['positions']; ?>"><?php echo $items['positions']; ?></a></td>
					<td><?php echo form_input('order['.$items['id'].']', $items['order'], 'class="form-control" placeholder="Vị trí" style="width:50px;"');?></td>
					<td><?php echo $items['fullname']; ?></td>
					
					<td><?php echo gettime($items['created']);?></td>
					<td>
						<a href="<?php echo site_url('navigations/backend/menus/set/publish/'.$items['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo ($items['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('navigations/backend/menus/delete/'.$items['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('navigations/backend/menus/update/'.$items['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('navigations/backend/menus/read/'.$items['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
						</div>
					</td>
				</tr>
			<?php 
				if(isset($items['child']) && is_array($items['child']) && count($items['child'])){
					show_parent_id($items['child'], $text);
				}
			} 
		} 
	}
?>