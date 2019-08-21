<style>
	.opened {font-weight: bold; font-size: 10px !important; padding: 3px 10px;background: #ed1830;color: #fff;border-radius: 5px;}
	.processing {font-weight: bold;font-size: 10px !important; padding: 3px 10px;background: #f4c58f;color: #815621 !important; border-radius: 5px;}
	.success{font-weight: bold; font-size: 10px !important;padding: 3px 10px; background: #75a630;color: #fff;border-radius: 5px;}
	.cancle{font-weight: bold; font-size: 10px !important;padding: 3px 10px; background: #333;color: #fff;border-radius: 5px;}
	
	.confirm {font-weight: bold; font-size: 10px !important;padding: 3px 10px; border-radius: 5px;}
	.confirm.no {background: #e5f2ce;color: #4b6319 !important;}
	.confirm.yes {background: #f7f7f7;  color: #777 !important;}
</style>

<section class="content-header">
	<h1>Đơn hàng</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('payments/backend/payments/view');?>">Đơn hàng</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group add-sort">
					<?php /* <button type="button" class="btn btn-sort btn-flat" id="btnsort"><i class="fa fa-sort-alpha-asc"></i> Sắp xếp</button><a href="<?php echo site_url('payments/backend/payments/create');?>" class="btn btn-add  btn-flat"><i class="fa fa-plus"></i> Thêm Đơn hàng</a>*/ ?>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('payments/backend/payments/view');?>">
					<div class="pull-left" style="width: 150px;margin-right:8px;">
					</div>
					<div class="input-group pull-left" style="width: 250px;">
						<input type="text" name="keyword" value="<?php echo htmlspecialchars($this->input->get('keyword'));?>" class="form-control" placeholder="Search">
						
					</div>
					<?php $status[] = '[Chọn trạng thái]'; $action = $this->configbie->data('status')  ?>
					<?php 
						if(isset($action) && is_array($action) && count($action)){
							foreach($action as $key => $val){
								$status[$key] = $val;
							}
						}
					?>
					<div class="input-group filter-box pull-left" style="margin-left:10px;">
						<?php echo form_dropdown('status', $status, $this->input->get('status'), 'class="form-control status"');?>
					</div>
					
					<div class="input-group filter-box pull-left">
						<input type="text" name="day_start" value="<?php echo htmlspecialchars($this->input->get('day_start'));?>" class="form-control datetimepicker" placeholder="Từ ngày">
					</div>
					<div class="input-group filter-box pull-left">
						<input type="text" name="day_end" value="<?php echo htmlspecialchars($this->input->get('day_end'));?>" class="form-control datetimepicker" placeholder="Đến ngày">
					</div>
					
					<div class="input-group-btn">
						<button type="submit" value="action" class="btn btn-default"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</div>
		</div><!-- /.box-header -->
		<?php echo show_flashdata();?>
		<?php if(isset($Listpayments) && is_array($Listpayments) && count($Listpayments)){ ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>Mã</th>
					<th>Hình thức thanh toán</th>
					<th>SLượng</th>
					<th>Ngày đặt</th>
					<th>Khách hàng</th>
					<th>Số ĐT</th>
					<th>Tình trạng</th>
					<th>Giao hàng</th>
					<th>Thao tác</th>
				</tr>
				<?php $alert = $this->configbie->data('status');   ?>
				<?php foreach($Listpayments as $key => $item){ ?>
				<?php 
					
					if($item['status'] == 'opened'){$class = 'opened';}
					else if($item['status'] == 'processing'){$class = 'processing';}
					else if($item['status'] == 'success'){$class = 'success';}
					else if($item['status'] == 'cancle'){$class = 'cancle';}
					else{ $class = 'opened';}
				?>
				<tr>
					<td><a href="<?php echo site_url('payments/backend/payments/update/'.$item['id'].''); ?>" title="" style="font-weight:bold;color:#006dad;"><?php echo '#'.(10000+$item['id']);?></a></td>
					<td style="text-align:center;"><?php echo !empty($item['payments']=='cod')?'<span style="color: red;font-weight: bold">Thanh toán khi nhận hàng</span>':'<span style="color: green;font-weight: bold">Thanh toán online</span>'; ?></td>
					<td style="text-align:center;"><?php echo $item['quantity']; ?></td>
					<td style="text-align:center;font-size:12px;"><?php echo gettime($item['created']); ?></td>
					<td><?php echo $item['fullname']; ?></td>
					<td><?php echo $item['phone']; ?></td>
					<td><span class="<?php echo $class; ?>"><?php echo $alert[$item['status']]; ?></span></td>
					
					<td><span class="confirm <?php echo ($item['send'] == 0) ? 'no': 'yes'; ?>"><?php echo ($item['send'] == 0) ? 'Chưa giao' : 'Đã giao'; ?></span></td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('payments/backend/payments/delete/'.$item['id']).'?redirect='.urlencode(current_url()).'?id='.$this->input->get('id').'';?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<a href="<?php echo site_url('payments/backend/payments/update/'.$item['id']).'?redirect='.urlencode(current_url()).'?id='.$this->input->get('id').'';?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
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
		$.post('<?php echo site_url('payments/ajax/payments/sort')?>', $('#fcFrom').serialize(), function(data){
			location.reload();
		})
		return false;
	})
})
</script>