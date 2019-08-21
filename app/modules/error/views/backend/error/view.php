<section class="content-header">
	<h1>Danh sách báo lỗi</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('error/backend/error/view');?>">Errors</a></li>
	</ol>
</section>

<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<?php echo show_flashdata();
			$array = array(
				'products' => 'Bài giảng',
				'articles' => 'Bài viết',
				'gallerys' => 'Hình Ảnh',
				'videos' => 'Video',
			);
		?>
		<?php if(isset($listError) && is_array($listError) && count($listError)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
				<tr>
					<th>ID</th>
					<th>Họ tên / Email</th>
					<th style="text-align:center;">Link</th>
					<th style="width:460px;">Nội dung</th>
					<th style="text-align:center; width: 100px;">Module</th>
					<th style="text-align:center;">Ngày tạo</th>
					<th style="text-align:center;">Trạng thái</th>
					<th class="text-center">Thao tác</th>
				</tr>
				<?php foreach($listError as $key => $val){ ?>
				<?php 
					$module = $val['module'];
					$moduleid = $val['moduleid'];
					$object = $this->Autoload_Model->_get_where(array(
						'select' => 'id, title, slug, canonical',
						'table' => $module,
						'where' => array('publish' => 1,'trash' => 0,'id' => $moduleid),
						'limit' => 1,
					));
					$title = $object['title'];
					// $href = rewrite_url($object['canonical'], $object['slug'], $object['id'], $module);
					$href = site_url('learning/lecture-'.$val['pageid'].'');

					$customers = $this->Autoload_Model->_get_where(array(
						'select' => 'id, fullname, email',
						'table' => 'customers',
						'where' => array('publish' => 1,'trash' => 0,'id' => $val['customersid']),
						'limit' => 1,
					));
				?>
				<tr>
					<td><?php echo $val['id'];?></td>
					<td class=""><?php echo $customers['fullname']; ?><br/><?php echo $customers['email'];?> </td></td>
					<td style="text-align:center;"><a target="_blank" href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title ?> <i class="fa fa-link"></i></a></td>
					<td><?php echo cutnchar(strip_tags($val['message']), 300);?></td>
					<td style="text-align:center;"><?php echo $array[$val['module']]; ?></td>
					<td style="text-align:center;"><?php echo gettime($val['created'], 'd/m/Y');?></td>
					<td>
						<a href="<?php echo site_url('error/backend/error/set/publish/'.$val['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo ($val['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td class="text-center">
						<div class="btn-group" style="min-width: 80px;">
							<a href="<?php echo site_url('error/backend/error/delete/'.$val['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
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
<style>
	.red{
		color: #ff0000;
	}
</style>