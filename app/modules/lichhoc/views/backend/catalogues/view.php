<section class="content-header">
	<h1>Danh mục bài viết</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('lichhoc/backend/catalogues/view');?>">Danh mục bài viết</a></li>
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
					<a href="<?php echo site_url('lichhoc/backend/catalogues/create');?>" class="btn btn-add btn-flat"><i class="fa fa-plus"></i> Thêm danh mục</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('lichhoc/backend/catalogues/view');?>">
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
		<?php if(isset($ListArticles) && is_array($ListArticles) && count($ListArticles)){ ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>ID</th>
					<th>Tiêu đề</th>
					<th>Người tạo</th>
					<th>Người cập nhật</th>
					<th>Ngày đăng</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($ListArticles as $key => $item){ ?>
				<tr>
					<td><?php echo $item['id'];?></td>
					<td>
						<a class="maintitle" title=""><?php echo $item['title']; ?></a>
					</td>
					<td><?php echo $item['user_created']; ?></td>
					<td><?php echo $item['user_updated']; ?></td>
					<td><?php echo gettime($item['created']);?></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('lichhoc/backend/catalogues/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('lichhoc/backend/catalogues/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
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
		$.post('<?php echo site_url('lichhoc/ajax/catalogues/sort')?>', $('#fcFrom').serialize(), function(data){
			location.reload();
		})
		return false;
	})
})
</script>