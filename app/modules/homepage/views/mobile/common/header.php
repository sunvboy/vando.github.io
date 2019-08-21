<?php $main_nav = navigations_array('main'); ?>
<?php if (isset($main_nav) && is_array($main_nav) && count($main_nav)) {  ?>
<header id="header">
	<div class="uk-container uk-container-center">
		<div class="top uk-flex uk-flex-middle uk-flex-space-between uk-margin-bottom">
			<a href="#offcanvas" class="uk-navbar-toggle" data-uk-offcanvas=""></a>
				<div id="offcanvas" class="uk-offcanvas">
					<div class="uk-offcanvas-bar">
						<form class="uk-search" data-uk-search="{}">
						    <input class="uk-search-field" type="search" placeholder="Tìm kiếm...">
				        </form>


						<ul class="l1 uk-nav uk-nav-offcanvas uk-nav" data-uk-nav>
						<?php foreach ($main_nav as $key => $value) {
							$title = $value['title'];
							$href = $value['href'];
						?>
							<li class="l1 uk-parent uk-position-relative">
								<a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="l1"><?php echo $title; ?></a>
								<!-- <ul class="cv-l2 uk-nav uk-nav-parent-icon uk-nav-sub" data-uk-nav>
							    	<li class="cv-l2 uk-parent"><a href="#">CLEANSING</a></li>
							    	<li class="cv-l2 uk-parent"><a href="#">CLEANSING</a></li>
								</ul> -->
							</li><!-- cv-l1 -->
						<?php } ?>
					        <li class="l1"><a href="<?php echo $this->fcSystem['common_shortcut']; ?>" title="Dịch vụ và Hỗ trợ của chúng tôi" class="l1">Dịch vụ và Hỗ trợ của chúng tôi</a></li>
						</ul>
					</div>
				</div>
			<div class="uk-text-center-medium">
				<a href="<?php echo base_url(); ?>" class="logo" title="<?php echo $this->fcSystem['seo_meta_title']; ?>" class="uk-navbar-nav">
					<?php echo $this->fcSystem['homepage_brandname']; ?>
				</a>
			</div>
			<div class="cart uk-vertical-align uk-position-relative uk-text-center">
				<a href="cart.html"><img src="templates/mobile/images/upload/icon-cart.png" alt="giỏ hàng"></a>
				<span class="num"><?php echo $this->fcCart; ?></span>
			</div><!-- end .cart -->
		</div>
	</div><!-- end .uk-container -->
</header><!-- end #header -->
<?php } ?>