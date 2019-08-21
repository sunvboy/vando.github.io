<section class="index-navigation margin-bottom-25px">
	<div class="uk-container uk-container-center">
		<div class="fc-breadcrumb uk-margin-bottom uk-margin-top">
			<ul class="uk-breadcrumb uk-margin-remove">
				<li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
				<li><a href="password.html">Đổi mật khẩu</a></li>
			</ul>
		</div><!-- .fc-breadcrumb -->
		
		<div class="uk-grid">
			<?php echo $this->load->view('homepage/frontend/common/user_aside'); ?>
			<div class="uk-width-large-4-5 uk-width-medium-2-3 uk-width-small-1-1 user-content">	
				<div class="uk-panel">
					<div class="uk-panel-title">Thông tin đơn hàng</div>
					<?php if(isset($OrderList) && is_array($OrderList) && count($OrderList)){ ?>
					<div class="uk-panel-body">
						<div class="uk-overflow-container">
							<table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
								<thead>
									<tr>
										<th>Mã đơn hàng</th>
										<th>Đơn hàng</th>
										<th>Số điểm đổi</th>
										<th>Ngày tạo</th>
									</tr>
								</thead>
								<tbody style="font-family:Roboto">
								<?php foreach($OrderList as $key => $val){ ?>
									<tr>
										<td>#<?php echo $val['id']; ?></td>
										<td>
											<?php if(isset($val['item']) && is_array($val['item']) && count($val['item'])){ ?>
											<?php foreach($val['item'] as $keyItems => $valItems){ ?>
												<p>Tên sản phẩm: <strong><?php echo $valItems['title']; ?></strong> | Số lượng:  <strong><?php echo $valItems['quantity']; ?></strong> </p>
											<?php } ?>
											<?php } ?>
										</td>
										<td><?php echo $val['point']; ?></td>
										<td><?php echo $val['created']; ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div><!--.grid -->
	</div><!-- .uk-container -->
</section><!-- .index-navigation -->

