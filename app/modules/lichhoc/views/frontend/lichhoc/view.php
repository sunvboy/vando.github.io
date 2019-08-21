
<div id="body" class="body-container">
    <?php $this->load->view('homepage/frontend/common/slider'); ?>
	<div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li><a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>"><i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a></li>
				<li class="uk-active"><a href="lich-hoc.html" title="Lịch học">Lịch học</a></li>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium">
			<div class="uk-width-large-1-4 uk-visible-large">
				<?php $this->load->view('homepage/frontend/common/aside'); ?>
			</div>
			<div class="uk-width-large-3-4">
				<section class="calendardetail-section">
					<section class="panel-body">
						<div class="uk-overflow-container">
							<table class="table">
								<tbody>
									<tr>
										<td colspan="2">
											<div class="uk-flex uk-flex-middle">
												<h1><?php echo $DetailArticles['title'] ?></h1>
												<a href="" title="" onclick="window.history.back();"><i class="fa fa-arrow-left fa-fw"></i> Quay về</a>
											</div>
										</td>
									</tr>
									<tr>
										<td>Ngày</td>
										<td>
											<b><?php echo $DetailCatalogues['title'] ?></b>
											<p style="margin-bottom: 0;"><?php echo $DetailCatalogues['day'] ?></p>
										</td>
									</tr>
									<tr>
										<td>Thời gian</td>
										<td><?php echo $DetailArticles['time'] ?></td>
									</tr>
									<tr>
										<td>Mức độ quan trọng</td>
										<td>Quan trọng</td>
									</tr>
									<tr>
										<td>Diễn giả</td>
										<td><?php echo $DetailArticles['diengia'] ?></td>
									</tr>
									<tr>
										<td>Khách hàng</td>
										<td><?php echo $DetailArticles['customer_name'] ?></td>
									</tr>
									<tr>
										<td>Địa điểm</td>
										<td><?php echo $DetailArticles['address'] ?></td>
									</tr>
									<tr>
										<td>Thời lượng</td>
										<td><?php echo $DetailArticles['number'] ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</section><!-- .panel-body -->
				</section>
			</div>
		</div>
	</div>
</div>