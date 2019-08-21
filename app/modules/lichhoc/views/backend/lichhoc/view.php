<section class="content-header">
	<h1>Bài viết</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('lichhoc/backend/lichhoc/view');?>">Bài viết</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group add-sort">
					<a href="<?php echo site_url('lichhoc/backend/lichhoc/create');?>" class="btn btn-add  btn-flat"><i class="fa fa-plus"></i> Thêm bài viết</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<span class="gcheckAction pull-left btn btn-default" data-module="lichhoc"><i class="fa fa-trash"></i></span>
				<form class="pull-left" method="get" action="<?php echo site_url('lichhoc/backend/lichhoc/view');?>">
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
			<table class="table" id="diagnosis-list">
				<tr>
					<th class="uk-text-center">STT</th>
					<th>Tiêu đề bài học</th>
					<th>Danh mục</th>
					<th>Thời gian</th>
					<th>Địa điểm</th>
					<th>Ngày tạo</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($ListArticles as $key => $item){ ?>
				<tr>
					<td class="uk-text-center"><?php echo $item['id']; ?></td>
					<td><?php echo $item['title']; ?></td>
					<td><b><?php echo $item['catalogue']; ?></b></td>
					<td><?php echo $item['time']; ?></td>
					<td><?php echo $item['address']; ?></td>
					<td><?php echo $item['created']; ?></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('lichhoc/backend/lichhoc/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('lichhoc/backend/lichhoc/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
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
<div class="backend-loader"></div>
<script type="text/javascript">
$(document).ready(function(){
	$('#btnsort').click(function(){
		$.post('<?php echo site_url('articles/ajax/articles/sort')?>', $('#fcFrom').serialize(), function(data){
			location.reload();
		})
		return false;
	})
})
</script>