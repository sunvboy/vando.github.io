<div id="homepage" class="page-body">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center"> 
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
					<i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a>
				</li>
				<li class="uk-active">
					<a href="javascript: void(0)" title="Đăng ký nạp tiền vào ví">
					Đăng ký nạp tiền vào ví</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mb20">
			<div class="uk-width-large-2-3">
				<section class="project-create">
					<header class="panel-head">
						<div class="heading-2 mb0"><span>Nạp tiền vào ví</span></div>
					</header>
					<section class="panel-body project-create">
						<?php $error = validation_errors(); echo !empty($error) ? '<div class="callout callout-danger" style="padding:10px;background:rgb(195, 94, 94);color:#fff;margin-bottom:10px;">'.$error.'</div>' : '';?>
						<form action="" method="post" accept-charset="utf-8">
							<div class="line-form mb20 bor_bor">
								<div class="box_title_2">
									<span>Thông tin chung</span>
								</div>
								<div class="content_content">
									<div class="uk-grid uk-flex-middle lib-grid-0">
										<div class="uk-width-1-2">
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Email của bạn</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<?php echo $DetailUsers['email']; ?>
													</label>
												</div>
											</div>
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Mật khẩu</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<input type="password" name="password" class="input-text uk-width-1-1" value="000000">
													</label>
												</div>
											</div>
											
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Phương thức</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<select name="method" class="input-text uk-width-1-1">
															<option value="Ngân hàng nội địa">Ngân hàng nội địa</option>
														</select>
													</label>
												</div>
											</div>
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Chi nhánh</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<?php echo form_input('company', set_value('company'), 'class="uk-width-1-1"'); ?>
													</label>
												</div>
											</div>
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Chủ tài khoản</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<?php echo form_input('bank_code', set_value('bank_code'), 'class="uk-width-1-1"'); ?>
													</label>
												</div>
											</div>
										</div>
										<div class="uk-width-1-2">
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Số dư</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label red">
														<?php echo number_format($DetailUsers['money']); ?>
													</label>
												</div>
											</div>
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Số tiền cần nạp</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<?php echo form_input('money', set_value('money'), 'class="uk-width-1-1"'); ?>
													</label>
												</div>
											</div>
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Đơn vị tiền tệ</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label blue">VNĐ</label>
												</div>
											</div>
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Ngân hàng</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<select name="bank_name" class="input-text uk-width-1-1">
															<option value="">Chọn ngân hàng</option>
															<option value="ACB">ACB</option>
															<option value="AGB">Agri Bank</option>
															<option value="AWL">Asia Wei Luy</option>
															<option value="BIDV">BIDV</option>
															<option value="DAB">DONG A Bank</option>
															<option value="MRTB">Maritime Bank</option>
															<option value="MTB">MB</option>
															<option value="SCB">Sacombank</option>
															<option value="TCB">Techcombank</option>
															<option value="VCB">Vietcombank</option>
															<option value="VIB">VietinBank</option>
															<option value="VPB">VPBank</option>
														</select>
													</label>
												</div>
											</div>
											<div class="uk-flex item-form uk-flex-middle">
												<div class="label-left bg_bg">
													<label class="label-label">Số tài khoản</label>
												</div>
												<div class="label-right uk-width-1-1 bdl0">
													<label class="label-label">
														<?php echo form_input('bank_number', set_value('bank_number'), 'class="uk-width-1-1"'); ?>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="uk-flex item-form uk-flex-middle" style="border-top: 0;">
										<div class="label-left bg_bg">
											<label class="label-label">Thông tin thêm</label>
										</div>
										<div class="label-right uk-width-1-1 bdl0">
											<label class="label-label" style="line-height: 0;padding: 10px;">
												<?php echo form_textarea('message', set_value('message'), 'cols="40" rows="10" id="txtDescription" class="" placeholder="Mô tả" style="width: 100%; height: 100px; font-size: 13px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"');?>
											</label>
										</div>
									</div>
									<div class="uk-flex item-form uk-flex-middle">
										<div class="label-right uk-width-1-1 uk-text-center" style="width: 100%;">
											<button type="submit" name="create" value="action" class="btn btn-info">Thêm mới</button>
										</div>
									</div>
								</div>
							</div>
						</form>
						<div class="line-form mb20 bor_bor">
							<div class="box_title_2">
								<span>Danh sách nạp mới nhất chờ xử lý</span>
							</div>
							<div class="content_content">
								<?php if (isset($list_payment) && is_array($list_payment) && count($list_payment)) { ?>
									<div class="box_list_pay mt20">
										<div class="delete-error uk-alert"></div>
										<table class="uk-table uk-table-middle uk-table-striped uk-table-hover uk-table-condensed tabble-border">
											<thead>
												<tr>
													<th>STT</th>
													<th width="100">Thời gian</th>
													<th>Số tiền</th>
													<th>Chi tiết</th>
													<th>Ghi chú</th>
													<th width="100">Trạng thái</th>
													<th></th>
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
														<td>
															<?php echo (($val['status'] == 0) ? '<a class="dele-item uk-btn btn-warnning" data-id="'.$val['id'].'" data-trash="'.$val['trash'].'" title="Xóa bỏ yêu cầu">Xóa</a>' : '') ?>
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
				</section>
			</div>
			<div class="uk-width-large-1-3">
				<?php $this->load->view('homepage/frontend/common/customers_aside'); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.delete-error').hide();
		$('.dele-item').on('click',function(){
			$('.dele-item').val('Loading....');
			var id = $(this).attr('data-id');
			var uid = '<?php echo $DetailUsers['id'] ?>';
			var formURL = 'customers/ajax/auth/deletepay';
			$.post(formURL, {id: id,uid:uid},
				function(data){
					$('.delete-error').show();
					var json = JSON.parse(data);
					if(json.flag == false){
						$('.delete-error').addClass('uk-alert-danger');
						$('.delete-error').removeClass('uk-alert-success');
						$('.delete-error').html(json.message);
					}else{
						$('.delete-error').addClass('callout-success');
						$('.delete-error').removeClass('uk-alert-danger');
						$('.delete-error').html(json.message);
						setTimeout(function(){ location.reload(); }, 2000);
					}
				});
			return false;
		});
	})
</script>