<section class="content-header">
	<h1>Danh mục Audio</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('audio/backend/catalogues/view');?>">Danh mục Audio</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group add-sort">
					<button type="button" class="btn btn-sort btn-flat" id="btnsort"><i class="fa fa-sort-alpha-asc"></i> Sắp xếp</button>
					<a href="<?php echo site_url('audio/backend/catalogues/create');?>" class="btn btn-add btn-flat"><i class="fa fa-plus"></i> Thêm danh mục mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('audio/backend/catalogues/view');?>">
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
		<?php if(isset($ListAudio) && is_array($ListAudio) && count($ListAudio)){ ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>ID</th>
					<th>Tiêu đề</th>
					<th>Audio</th>
					<th>Vị trí</th>
					<th>Người tạo</th>
					<th>Người sửa</th>
					<th>Thời gian</th>
					<th>Xuất bản</th>
					<th>Trang chủ</th>
					<th>Nổi bật</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($ListAudio as $key => $item){ ?>
				<tr>
					<td><?php echo $item['id'];?></td>
					<td><a class="maintitle" href="<?php echo site_url('audio/backend/audio/view?cataloguesid='.$item['id'].''); ?>" title=""><?php echo str_repeat('|----------', (($item['level'] > 0)?($item['level'] - 1):0)).$item['title']; ?></a></td>
					<?php 
						$count_id = catalogues_relationship($item['id'], 'audio', array('Backendaudio','BackendaudioCatalogues'), 'audio_catalogues');
					?>
					<td><?php echo (isset($count_id) && is_array($count_id) && count($count_id) ) ? count($count_id) : 0; ?></td>
					<td><?php echo form_input('order['.$item['id'].']', $item['order'], 'class="form-control" placeholder="Vị trí" style="width:50px;"');?></td>
					<td><?php echo $item['user_created']; ?></td>
					<td><?php echo $item['user_updated']; ?></td>
					<td><?php echo gettime($item['created']);?></td>
					<td>
						<a href="<?php echo site_url('audio/backend/catalogues/set/publish/'.$item['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo (!empty($item['publish']))? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td>
						<a href="<?php echo site_url('audio/backend/catalogues/set/ishome/'.$item['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo (!empty($item['ishome']))? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td>
						<a href="<?php echo site_url('audio/backend/catalogues/set/highlight/'.$item['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo (!empty($item['highlight']))? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('audio/backend/catalogues/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default <?php echo ($item['rgt'] - $item['lft'] > 1)?'disabled':'';?>"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('audio/backend/catalogues/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('audio/backend/catalogues/read/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
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
		$.post('<?php echo site_url('audio/ajax/catalogues/sort')?>', $('#fcFrom').serialize(), function(data){
			location.reload();
		})
		return false;
	})
})
</script>