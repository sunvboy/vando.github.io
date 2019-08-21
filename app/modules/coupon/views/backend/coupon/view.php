<section class="content-header">
	<h1>Danh sách mã khuyến mãi</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('coupon/backend/coupon/view');?>">Khuyến mãi</a></li>
	</ol>
</section>
<section class="content">
  	<div class="row">
		<div class="col-xs-12">
		  	<div class="box">
				<div class="box-header">
					<h3 class="box-title pull-right">
						<div class="btn-group">
							<a href="<?php echo site_url('coupon/backend/coupon/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
						</div>
					</h3>
					<div class="box-tools pull-left">
						<form method="get" action="<?php echo site_url('coupon/backend/coupon/view');?>">
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
				<?php if(isset($listCoupon) && is_array($listCoupon) && count($listCoupon)){ ?>
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover table-bordered table-striped">
							<tr>
								<th>STT</th>
								<th>Tiêu đề</th>
								<th class="text-center">Xuất bản</th>
								<th class="text-center">Đã dùng</th>
								<th class="text-center">Trạng thái</th>
								<th>Bắt đầu</th>
								<th>Kết thúc</th>
								<th class="text-center">Thao tác</th>
							</tr>
							<?php foreach($listCoupon as $key => $val){ ?>
								<?php 
									$count  = $this->FrontendProducts_Model->_countTable(array(
										'table' => 'coupon_relationship',
										'where' => array('couponid' => $val['id']),
									)); 
									// Tự động cập nhật các bản ghi có số lần sử dụng hết 
									if (!empty($val['limitTotalUse'])) {
										if ($count >= $val['limitedUseTotal']) {
											$flag = $this->Autoload_Model->_update(array(
												'table' => 'coupon', 
												'data' => array('status' => 1),
												'where' => array('id' => $val['id'])
											));
											if ($flag) {
												header('Location: '.current_url().''); exit;
											}
										}
									}
								?>
								<tr>
									<td><?php echo ($key + 1);?></td>
									<td>
										<div class="coupon_title">
											<span><?php echo $val['couponCode'];?></span>
											<div>Giảm <?php echo str_replace(',', '.', number_format($val['couponTypeValue'])).((!empty($val['couponType'])) ? ' vnđ' : '%') ?> cho <?php echo (($val['appliesTo'] == 'cart') ? 'tất cả các đơn hàng' : (($val['appliesTo'] == 'collections') ? count(explode('-', $val['CollectionId'])).' '.'nhóm danh mục sản phẩm' : count(explode('-', $val['ProductsId'])).' '.'sản phẩm')) ?></div>
										</div>
									</td>
									<td>
										<a href="<?php echo site_url('coupon/backend/coupon/set/publish/'.$val['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
											<img src="<?php echo ($val['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
										</a>
									</td>
									<td class="text-center"><?php echo $count.((!empty($val['limitTotalUse'])) ? '/'.$val['limitedUseTotal'] : '/--') ?></td>
									<td>
										<a href="<?php echo site_url('coupon/backend/coupon/set/status/'.$val['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
											<img src="<?php echo ($val['status'] == 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
										</a>
									</td>
									<td><?php echo $val['date_start'];?></td>
									<td><?php echo $val['date_end'];?></td>
									<td class="text-center">
										<div class="btn-group">
											<a href="<?php echo site_url('coupon/backend/coupon/delete/'.$val['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
											<a href="<?php echo site_url('coupon/backend/coupon/update/'.$val['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
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
.coupon_title span {
    color: #08f;
}
</style>