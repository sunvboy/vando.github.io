<section class="content-header">
	<h1>Thống kê doanh thu Afiliate</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('statistics/backend/statistics/view');?>">Doanh thu affiliate</a></li>
	</ol>
</section>
<section class="content">
  	<div class="row">
		<div class="col-xs-12">
		  	<div class="box">
				<div class="box-header">
					<div class="box-tools pull-left">
						<form method="get" action="<?php echo site_url('statistics/backend/statistics/view');?>">
							<div class="pull-left" style="width: 200px;margin-right:8px;">
								<?php echo form_dropdown('customersid', $this->BackendCustomers_Model->DropdownName(), set_value('customersid', $this->input->get('customersid')), 'class="form-control select2"');?>
							</div>
							<div class="pull-left" style="width: 250px;">
								<?php echo form_dropdown('process', $this->configbie->data('process'), set_value('process', $this->input->get('process')), 'class="form-control select2"');?>
							</div>
							<div class="pull-left">
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
								<th style="text-align:left;">Affiliate ID</th>
								<th>Đơn hàng</th>
								<th>Số lượng</th>
								<th>Số tiền</th>
								<th>Ngày đặt hàng</th>
								<th>Trạng thái</th>
							</tr>
							<?php $total = 0; ?>
							<?php foreach($Listcustomers as $key => $item){ ?>
								<?php $total += ((!empty($item['process'])) ? $item['total_price'] : 0); ?>
								<tr>
									<td><?php echo ($key + 1)?></td>
									<td style="text-align:left;"><?php echo $item['fullname'].'<br>'.$item['email']; ?></td>
									<td><?php echo '#'.(10000 + $item['id']); ?></td>
									<td><?php echo $item['quantity'] ?></td>
									<td><?php echo str_replace(',', '.', number_format($item['total_price'])); ?></td>
									<td><?php echo show_time($item['created'], 'd-m-Y'); ?></td>
									<td>
										<span class="btn <?php echo ((!empty($item['process'])) ? 'btn-success' : 'btn-danger') ?>">
											<?php echo $this->configbie->data('process', $item['process']) ?>
										</span>
									</td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="4">Tổng tiền</td>
								<td style="text-align: center;color: red"><?php echo str_replace(',', '.', number_format($total)); ?> đ</td>
								<td></td>
								<td></td>
							</tr>
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