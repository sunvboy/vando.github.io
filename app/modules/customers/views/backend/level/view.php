<section class="content-header">
	<h1>Cấp bậc</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('customers/backend/level/view');?>">Level khách hàng</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group">
					<a href="<?php echo site_url('customers/backend/level/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('customers/backend/level/view');?>">
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
		<?php if(isset($Listcustomers) && is_array($Listcustomers) && count($Listcustomers)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>STT</th>
					<th style="text-align: center;">Tên cấp bậc</th>
					<th style="text-align: center;">Phần trăm giảm giá</th>
					<th>Giới hạn lên cấp</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($Listcustomers as $key => $item){ ?>
				<tr>
					<td><?php echo ($key + 1);?></td>
					<td style="text-align:center;"><?php echo $item['title']; ?></td>
					<td><?php echo $item['discounted']; ?> %</td>
					<td><?php echo str_replace(',', '.', number_format($item['range_price'])).' đ' ?></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('customers/backend/level/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('customers/backend/level/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
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