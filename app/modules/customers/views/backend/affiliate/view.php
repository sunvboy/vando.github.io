<section class="content-header">
	<h1>Hoa hồng thành viên</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('customers/backend/affiliate/view');?>">Hoa hồng</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('customers/backend/affiliate/view');?>">
					<div class="pull-left" style="width: 200px;margin-right:8px;">
						<?php echo form_dropdown('customersid', $this->BackendCustomers_Model->DropdownName(), set_value('customersid', $this->input->get('customersid')), 'class="form-control"');?>
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
		<?php if(isset($Listcustomers) && is_array($Listcustomers) && count($Listcustomers)){ ?>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>STT</th>
					<th>Tiêu đề</th>
					<th style="text-align:left;">Affiliate ID</th>
					<th>Đơn hàng</th>
					<th>Số tiền</th>
					<th>Ngày thụ hưởng</th>
				</tr>
				<?php foreach($Listcustomers as $key => $item){ ?>
				<tr>
					<td><?php echo ($key + 1)?></td>
					<td><?php echo $item['title']; ?></td>
					<td style="text-align:left;"><?php echo $item['fullname'].'<br>'.$item['email']; ?></td>
					<td><a href="<?php echo site_url('payments/backend/payments/update/'.$item['paymentsid'].'') ?>" title="Xem đơn hàng" target="_blank"><?php echo '#'.(10000 + $item['paymentsid']); ?></a></td>
					<td><?php echo str_replace(',', '.', number_format($item['money'])); ?> vnđ</td>
					<td><?php echo show_time($item['created'], 'd-m-Y'); ?></td>
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