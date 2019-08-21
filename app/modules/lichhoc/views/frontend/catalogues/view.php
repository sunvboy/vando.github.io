<div id="body" class="body-container">
    <?php $this->load->view('homepage/frontend/common/slider'); ?>
    <div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li><a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>"><i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a></li>
				<li class="uk-active"><a title="Lịch học">Lịch học</a></li>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<section class="calendar-section">
			<form action="" class="uk-form form">
					<header class="panel-head">
						<ul class="uk-list uk-clearfix search-box">
							<li>
								<a class="btn" href=""><i class="fa fa-angle-double-left"></i> Lịch tuần trước</a>
							</li>
							<li>
								<a class="btn" href="">Lịch tuần hiện tại</a>
							</li>
							<li>
								<a class="btn" href="">Lịch tuần sau <i class="fa fa-angle-double-right"></i></a>
							</li>
							<li>
								<div class="form-row">
									<input type="text" name="" class="input-text datetimepicker" />
									<button type="submit" name="" class="btn-submit">Tìm kiếm</button>
								</div>
							</li>
						</ul>
						<h1 class="heading"><span>Lịch hoạt động</span></h1>
						<div class="label">Lịch hoạt động: Từ 22/05/2017 đến 28/05/2017</div>
					</header>
					<section class="panel-body">
						<div class="uk-overflow-container">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width:8%;vertical-align:middle">Ngày</th>
										<th style="width:7%">Thời gian</th>
										<th style="width:20%">Nội dung công việc</th>
										<th style="width:10%">Diễn giả</th>
										<th style="width:13%">Khách hàng</th>
										<th style="width:21%">Địa điểm</th>
										<th style="width:7%;">Thời lượng</th>
										<th style="width:14%;">Chi tiết</th>
									</tr>
								</thead>
								<tbody>
									<?php  
										if (isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)) {
											foreach ($ArticlesList as $key => $val) {
												?>
													<tr>
														<td style="width:8%;vertical-align:middle">
															<b><?php echo $val['title'] ?></b>
															<p><?php echo $val['day'] ?></p>
														</td>
														<td colspan="7" style="width:92%;padding:0">
															<?php  
																if (isset($val['post']) && is_array($val['post']) && count($val['post'])) {
																	?><table class="table table-bordered-inside"><tbody><?php
																	foreach ($val['post'] as $key => $valitem) {
																		$href_tin = rewrite_url($valitem['canonical'], $valitem['slug'], $valitem['id'], 'lichhoc_time'); 
																		?>
																			<tr>
																				<td style="width:7%"><?php echo $valitem['time'] ?></td>
																				<td style="width:20%"><?php echo $valitem['content'] ?></td>
																				<td style="width:10%"><?php echo $valitem['diengia'] ?></td>
																				<td style="width:13%"><?php echo $valitem['customer_name'] ?></td>
																				<td style="width:21%"><?php echo $valitem['address'] ?></td>
																				<td style="width:7%"><?php echo $valitem['number'] ?></td>
																				<td style="width:14%; vertical-align:middle;text-align:center;padding-left:0;padding-right:0; border-right: 0;"><a href="<?php echo $href_tin ?>" title=""><i class="fa fa-hand-o-left fa-fw"></i> Views</a></td>
																			</tr>
																		<?php
																	}
																	?></tbody></table><?php
																}
															?>
														</td>
													</tr>
												<?php
											}
										}
									?>
								</tbody>
							</table>
						</div>
					</section><!-- .panel-body -->
				</form>
		</section>
	</div>
</div> <!-- .mainContent -->