<section class="content-header">
	<h1>Bài viết</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('lichhoc/backend/chungchi/view');?>">Bài viết</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<div class="box-tools pull-left">
				<span class="gcheckAction pull-left btn btn-default" data-module="lichhoc"><i class="fa fa-trash"></i></span>
				<form class="pull-left" method="get" action="<?php echo site_url('lichhoc/backend/chungchi/view');?>">
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
		<?php $arr = $this->configbie->data('form') ?>
		<?php $arr1 = $this->configbie->data('publish') ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table" id="diagnosis-list">
				<tr>
					<th class="uk-text-center">STT</th>
					<th>Họ và tên</th>
					<th>Email</th>
					<th>Vị trí ứng tuyển</th>
					<th>Hình thức lviệc</th>
					<th>Ngày gửi</th>
					<th>Trạng thái</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($ListArticles as $key => $item){ ?>
				<?php 
					
					if($item['publish'] == '0'){$class = 'opened';}
					else if($item['publish'] == '1'){$class = 'processing';}
					else if($item['publish'] == '2'){$class = 'success';}
					else if($item['publish'] == '3'){$class = 'cancle';}
					else{ $class = 'opened';}
				?>
				<tr>
					<td class="uk-text-center"><?php echo $item['id']; ?></td>
					<td><?php echo $item['fullname']; ?></td>
					<td><b><?php echo $item['email']; ?></b></td>
					<td><?php echo $item['title']; ?></td>
					<td><?php echo $arr[$item['form']]; ?></td>
					<td><?php echo $item['created']; ?></td>
					<td><span class="<?php echo $class; ?>"><?php echo $arr1[$item['publish']] ?></span></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('lichhoc/backend/chungchi/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('lichhoc/backend/chungchi/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('lichhoc/backend/chungchi/read/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
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
<style>
	.opened {font-weight: bold; font-size: 11px !important; padding: 7px 10px;background: #ed1830;color: #fff;border-radius: 5px;}
	.processing {font-weight: bold;font-size: 11px !important; padding: 7px 10px;background: #f4c58f;color: #815621 !important; border-radius: 5px;}
	.success{font-weight: bold; font-size: 11px !important;padding: 7px 10px; background: #75a630;color: #fff;border-radius: 5px;}
	.cancle{font-weight: bold; font-size: 11px !important;padding: 7px 10px; background: #333;color: #fff;border-radius: 5px;}
	
	.confirm {font-weight: bold; font-size: 11px !important;padding: 7px 10px; border-radius: 5px;}
	.confirm.no {background: #e5f2ce;color: #4b6319 !important;}
	.confirm.yes {background: #f7f7f7;  color: #777 !important;}
</style>