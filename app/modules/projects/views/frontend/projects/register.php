<div id="homepage" class="page-body">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center"> 
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
					<i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a>
				</li>
				<li class="uk-active">
					<a href="javascript: void(0)" title="Đăng ký dịch vụ đăng tin không giới hạn">
					Đăng ký dịch vụ đăng tin không giới hạn</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mb20">
			<div class="uk-width-large-2-3">
				<section class="project-create">
					<header class="panel-head">
						<div class="heading-2 mb0"><span>Đăng tin</span></div>
					</header>
					<section class="panel-body">
						<?php $error = validation_errors(); echo !empty($error) ? '<div class="callout callout-danger" style="padding:10px;background:rgb(195, 94, 94);color:#fff;margin-bottom:10px;">'.$error.'</div>' : '';?>
						<form action="" method="post" accept-charset="utf-8">
							<div class="Khung1">
							    <div style="text-align: center; padding-top: 10px; height: 40px; font-size: 14px; font-weight: bold;">
							        CÁC GÓI ĐĂNG TIN TRỌN GÓI
							    </div>
							    <div style="text-align: center;">
							        <a href="http://nhadat24h.net/images/2014/banggiadangtin.png" title="Bảng giá đăng tin trọn gói" class="swipebox">
							            <img class="imageThumb" src="http://nhadat24h.net/images/2014/banggiadangtin.png" style="width: 100%" alt="Bảng giá dịch vụ đăng tin">
							        </a>
							    </div>
							    <div class="uk-flex uk-flex-center mt10 mb10">
							        <select name="package" class="text package">
										<option selected="selected" value="0">------Xin hãy chọn gói đăng tin để tiếp tục------</option>
										<option value="199000">Gói 199.000 đ</option>
										<option value="520000">Gói 520.000 đ</option>
										<option value="990000">Gói 990.000 đ</option>
										<option value="1900000">Gói 1.990.000 đ</option>
									</select>
							    </div>
							    <div id="load_goi">
									
								</div>
							</div>
						</form>
					</section>
				</section>
			</div>
			<div class="uk-width-large-1-3">
				<?php $this->load->view('homepage/frontend/common/customers_aside'); ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('.package').on('change', function() {
			var package = $(this).val();
			var uri = '<?php echo site_url('projects/ajax/projects/check_package'); ?>';
			$.post(uri, {package: package},
			function(data){
				var json = JSON.parse(data);
				$('#load_goi').html('').html(json.html);
			});
			return false;
		});
	});
</script>
