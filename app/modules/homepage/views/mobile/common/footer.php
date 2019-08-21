<footer id="footer" class="">
	<div class="uk-container uk-container-center">
		<section class="top">
			<div class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-medium-1-1">
				<div class="uk-panel">
					<div class="uk-panel-title"><h3 class="heading"><span class="fc-text-uppercase uk-text-bold">Thông tin liên hệ</span></h3></div>
					<div class="fc-panel-body">
						<p>CÔNG TY CỔ PHẦN thực phẩm chức năng nhật</p>
						<p>Địa chỉ: <?php echo $this->fcSystem['contact_address']; ?></p>
						<p>Điện thoại: <?php echo $this->fcSystem['contact_phone']; ?></p>
						<p>Email: <?php echo $this->fcSystem['contact_email'] ?></p>
						<p>Website: <?php echo $this->fcSystem['contact_web']; ?></p>
					</div><!-- .fc-panel-body -->
				</div><!-- .uk-panel -->
			<?php if (isset($footer_catalogues) && is_array($footer_catalogues) && count($footer_catalogues)) {  ?>
			<?php foreach ($footer_catalogues as $key => $value) {
				# code...
				$title  =  $value['title'];
				$href = rewrite_url($value['canonical'], $value['slug'], $value['id'], 'articles');
			 ?>
				<div class="uk-panel">
					<div class="uk-panel-title"><h3 class="heading"><span class="fc-text-uppercase uk-text-bold"><?php echo $title ?></span></h3></div>
					<div class="fc-panel-body">
						<ul class="uk-list uk-list-space">
						
						<?php foreach ($value['post'] as $key => $value) {
							$title_post = $value['title'];
							$href_post = rewrite_url($value['canonical'], $value['slug'], $value['id'], 'articles'); ?>
							<li><a href="<?php echo $href_post; ?>" title=""><?php echo $title_post; ?></a></li>
						<?php }  ?>
						</ul>
					</div><!-- .fc-panel-body -->
				</div><!-- .uk-panel -->
			<?php } } ?>
				<div class="uk-panel">
					<div class="uk-panel-title"><h3 class="heading"><span class="fc-text-uppercase uk-text-bold">đăng ký nhân tin khuyến mãi</span></h3></div>
					<div class="fc-panel-body">
						<form action="" class="uk-form email-register">
							<p>Nhận ngay phiếu giảm giá 100.000 VND khi đăng ký</p>
							<div class="uk-form-row">
								<input type="text" name="" id="email" required="" class="uk-width-1-1" placeholder="Email">
								<input type="submit" name="" id="submit" class="uk-button" value="Gửi">
							</div>
						</form>
						<hr>
						<div class="uk-text-bold margin-bottom-10">KẾT NỐI VỚI CHÚNG TÔI</div>
						<div class="social-link">
							<a href="<?php echo $this->fcSystem['social_facebook'] ?>" title="facebook" class="facebook uk-margin-right"><i class="uk-icon-facebook"></i></a>
							<a href="<?php echo $this->fcSystem['social_twitter'] ?>" title="twitter" class="twitter uk-margin-right"><i class="uk-icon-twitter"></i></a>
							<a href="<?php echo $this->fcSystem['social_google'] ?>" title="google" class="google uk-margin-right"><i class="uk-icon-google-plus"></i></a>
							<a href="<?php echo $this->fcSystem['social_youtube'] ?>" title="youtube" class="youtube"><i class="uk-icon-youtube-play"></i></a>
						</div>
					</div><!-- .fc-panel-body -->
				</div><!-- .uk-panel -->
			</div><!-- end .uk-grid -->
		</section><!-- end .top -->
		<section class="copyright">
			<p class="uk-margin-remove">&copy; Copyright 2015 by ITQ.vn. All rights reserved. <span class="uk-text-bold">CÔNG TY CỔ PHẦN thực phẩm chức năng nhật</span></p>
		</section>
	</div><!-- end .uk-container -->
</footer><!-- end #footer -->