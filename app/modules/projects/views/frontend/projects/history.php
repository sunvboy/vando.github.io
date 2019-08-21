<div id="homepage" class="page-body">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center"> 
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
					<i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a>
				</li>
				<li class="uk-active">
					<a href="javascript: void(0)" title="Lịch sử nạp tiền">
					Lịch sử nạp tiền</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mb20">
			<div class="uk-width-large-2-3">
				<section class="panel-body">
					<div class="line-form mb20 bor_bor">
						<div class="box_title_2">
							<span>Danh sách nạp đã xử lý</span>
						</div>
						<div class="content_content">
							<?php if (isset($list_payment) && is_array($list_payment) && count($list_payment)) { ?>
								<div class="box_list_pay mt10">
									<table class="uk-table uk-table-middle uk-table-striped uk-table-hover uk-table-condensed tabble-border">
										<thead>
											<tr>
												<th>STT</th>
												<th width="100">Thời gian</th>
												<th>Số tiền</th>
												<th>Chi tiết</th>
												<th>Ghi chú</th>
												<th width="100">Trạng thái</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($list_payment as $key => $val) { ?>
												<tr>
													<td><?php echo ($key + 1); ?></td>
													<td><?php echo $val['created']; ?></td>
													<td><?php echo number_format($val['money']); ?> vnđ</td>
													<td align="left">
														Ngân hàng: <?php echo $val['bank_name']; ?><br>
														Chi nhánh: <?php echo $val['company']; ?><br>
														Số TK: <?php echo $val['bank_number']; ?><br>
														Tên TK: <?php echo $val['bank_code']; ?><br>
													</td>
													<td class="active">
														<p><?php echo $val['message']; ?></p>
														<?php echo (($val['note_admin'] != '') ? '<p><span><font color="red">Admin</font>: Update: '.$val['updated'].'<br>'.$val['note_admin'].'</span></p>' : ''); ?>
													</td>
													<td>
														<a href="javascript: void(0)" class="uk-btn <?php echo (($val['status'] == 0) ? 'btn-warnning' : 'btn-succes') ?>">
															<?php echo (($val['status'] == 0) ? 'Chưa xử lý' : 'Đã xử lý') ?>
														</a>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							<?php } ?>
						</div>
					</div>
				</section>
			</div>
			<div class="uk-width-large-1-3">
				<?php $this->load->view('homepage/frontend/common/customers_aside'); ?>
			</div>
		</div>
	</div>
</div>