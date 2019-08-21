<section class="content-header">
	<h1>Danh sách tích điểm</h1>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<?php echo show_flashdata();?>
		<?php $total = 0; ?>
		<?php if(isset($List_Log_affiliate) && is_array($List_Log_affiliate) && count($List_Log_affiliate)){ ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table table-hover" id="diagnosis-list" style="margin-bottom: 0;">
				<tr>
					<th>STT</th>
					<th>Phân loại</th>
					<th>Người mua hàng</th>
					<th>Mã đơn hàng</th>
					<th>Số tiền thụ hưởng</th>
					<th>Ngày thụ hưởng</th>
				</tr>
				<?php foreach($List_Log_affiliate as $key => $item){ ?>
				<?php $total += $item['money']; ?>
				<tr>
					<td><?php echo $key + 1; ?></td>
					<td style="text-align: center"><?php echo (($item['type'] == 0) ? 'Thưởng tích điểm mua hàng' : 'Dùng tích điểm mua hàng') ?></td>
					<td style="text-align: center"><?php echo $item['customer_buy'] ?></td>
					<td style="text-align: center;">#<?php echo $item['id_payment']; ?></td>
					<td><?php echo str_replace(',', '.', number_format($item['money'])) ?> vnđ</td>
					<td><?php echo $item['created']; ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="4" style="text-align:left">Tổng tiền</td>
					<td style="color: red; text-align: center">
						<?php echo str_replace(',', '.', number_format($total)) ?> vnđ
					</td>
					<td></td>
				</tr>
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
