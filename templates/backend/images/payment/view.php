<section class="content-header">
	<h1>Thành viên</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('customers/backend/payment/view');?>">Khách hàng - Thanh toán</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('customers/backend/payment/view');?>">
					<div class="pull-left" style="width: 200px;margin-right:8px;">
					</div>
				</form>
			</div>
		</div><!-- /.box-header -->
		<?php echo show_flashdata();?>
		<?php if(isset($Listpayment) && is_array($Listpayment) && count($Listpayment)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>ID</th>
					<th>Thành viên</th>
					<th>Số tiền</th>
					<th>Chi tiết</th>
					<th>Ngày gửi yêu cầu</th>
					<th>Trang thái</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($Listpayment as $key => $item){ ?>
				<tr>
					<td><?php echo $item['id'];?></td>
					<td style="text-align: center;"><?php echo $item['group_title']; ?></td>
					<td><?php echo str_replace(',', '.', number_format($item['money'])); ?> vnđ</td>
					<td>
						Ngân hàng: <?php echo $item['bank_name']; ?><br>
						Chi nhánh: <?php echo $item['company']; ?><br>
						Số TK: <?php echo $item['bank_number']; ?><br>
						Tên TK: <?php echo $item['bank_code']; ?><br>
					</td>
					<td><?php echo $item['created']; ?></td>
					<td>
						<img src="<?php echo ($item['status'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
					</td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('customers/backend/payment/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-danger <?php echo (($item['status'] == 1) ? 'disabled' : '') ?>"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('customers/backend/payment/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
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