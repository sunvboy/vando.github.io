<section class="content-header">
	<h1>Danh sách sale đồng giá & outlet</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('products/backend/SalesDG/view');?>">Danh sách sale</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<h3 class="box-title pull-right">
				<div class="btn-group add-sort">
					<a href="<?php echo site_url('products/backend/SalesDG/create');?>" class="btn btn-add  btn-flat"><i class="fa fa-plus"></i> Thêm</a>
				</div>
			</h3>
			<div class="box-tools pull-left">
				<form class="pull-left" method="get" action="<?php echo site_url('products/backend/SalesDG/view');?>">

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
		<?php if(isset($Listproducts) && is_array($Listproducts) && count($Listproducts)){ ?>
		<div class="box-body table-responsive no-padding">
			<form method="post" action="" id="fcFrom">
			<table class="table" id="diagnosis-list">
				<tr>
					<th>Tiêu đề</th>
					<th>Thời gian</th>
					<th>Vị trí</th>
					<th>Trạng thái</th>
					<th>Kích hoạt chương trình</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($Listproducts as $key => $item){ ?>
				<?php 
					$image = getthumb($item['images']);
					$href = rewrite_url($item['canonical'], $item['slug'], $item['id'], 'products_sale');

				?>
				<tr>

					<td style="width:650px;">
						<article class="article-view-1">
							<div class="col-sm-2 thumb">
								<div class="tp-cover"><img  src="<?php echo $image; ?>" alt="<?php echo $item['title']; ?>"  /></div>
							</div>
							<div class="col-sm-10">
								<a style="color:#333;" href="<?php echo $href; ?>" target="_blank" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
								<a href="<?php echo $href ?>" title="Lấy địa chỉ liên kết" onclick="prompt('Lấy địa chỉ liên kết','<?php echo $href ?>'); return false;"><img border="0" src="templates/backend/images/link.png"></a>
							</div>
						</article>
					</td>
					<td>
						Thời gian bắt đầu: <?php echo $item['time_start']; ?>
						<br>
						Thời gian kết thúc: <?php echo $item['time_end']; ?>
					</td>
					<td><?php echo form_input('order['.$item['id'].']', $item['order'], 'data-id="'.$item['id'].'"  class="form-control sort-order-sale" placeholder="Vị trí" style="width:65px;"');?></td>
					<td>
						<?php
						$time = date('Y-m-d H:i:s');
						?>
						<?php if(($item['time_start'] <= $time) && ($item['time_end'] >= $time) &&  ($item['publish'] ==1) ){?>
							<span style="color: green">Chương trình đang chạy</span>
						<?php }else{?>
							<span style="color: red">Chương trình kết thúc</span>
						<?php }?>
					</td>
					<td>
						<?php if($item['id'] != 4){?>
						<a href="<?php echo site_url('products/backend/SalesDG/set/publish/'.$item['id'].'?saleoff='.$item['saleoff'].'&redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo ($item['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
						<?php }else{?>
							<a href="<?php echo site_url('products/backend/SalesDG/set_50/publish/'.$item['id'].'?saleoff='.$item['saleoff'].'&redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
								<img src="<?php echo ($item['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
							</a>
						<?php }?>
					</td>

					<td >
						<div class="btn-group">
							<?php if($item['id'] != 4){?>
							<a href="<?php echo site_url('products/backend/SalesDG/delete/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><span class="fa fa-trash"></span></a>
							<?php }?>
							<?php if($item['id'] != 4){?>
							<a href="<?php echo site_url('products/backend/SalesDG/update/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<?php }else{?>
							<a href="<?php echo site_url('products/backend/SalesDG/update_50/'.$item['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>

							<?php }?>
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
		$.post('<?php echo site_url('products/ajax/products/sort')?>', $('#fcFrom').serialize(), function(data){
			location.reload();
		})
		return false;
	})
})
$('.sort-order-sale').on('keyup', function(event) {
	var id = $(this).attr('data-id');
	var number = $(this).val();
	var url = 'products/ajax/saleDG/sort_order';
	time = setTimeout(function() {
		$('.backend-loader').show();
		$.post(url, {id: id, number: number}, function(data){
			$('.backend-loader').hide();
		});
	}, 800);
});
</script>