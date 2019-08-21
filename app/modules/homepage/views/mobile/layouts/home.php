<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo base_url();?>" />
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="vi" />
	<link rel="alternate" href="<?php echo base_url();?>" hreflang="vi-vn" />
	<meta name="robots" content="index,follow" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="author" content="<?php echo getSystem('homepage_brandname');?>" />
	<meta name="copyright" content="<?php echo getSystem('homepage_brandname');?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
	<meta http-equiv="refresh" content="1800" />

	<!-- for Google -->
	<title><?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?></title>
	<meta name="keywords" content="<?php echo isset($meta_keywords)?htmlspecialchars($meta_keywords):'';?>" />
	<meta name="description" content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />
	<?php echo isset($canonical)?'<link rel="canonical" href="'.$canonical.'" />':'';?>
	
	<!-- for Facebook -->
	<meta property="og:title" content="<?php echo (isset($meta_title) && !empty($meta_title))?htmlspecialchars($meta_title):'';?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo (isset($meta_images) && !empty($meta_images))?$meta_images:base_url(getSystem('seo_meta_image'));?>" />
	<?php echo isset($canonical)?'<meta property="og:url" content="'.$canonical.'" />':'';?>
	<meta property="og:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
	<meta property="og:site_name" content="<?php echo getSystem('homepage_brandname');?>" />
	<meta property="fb:admins" content="<?php echo getSystem('system_fbadmins');?>"/>
	<meta property="fb:app_id" content="<?php echo getSystem('system_fbappid');?>" />
	
	<!-- for Twitter -->          
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="<?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?>" />
	<meta name="twitter:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
	<meta name="twitter:image" content="<?php echo (isset($meta_images) && !empty($meta_images))?$meta_images:base_url(getSystem('seo_meta_image'));?>" />
	
	<link href="<?php echo getSystem('homepage_favicon');?>" rel="icon" type="image/x-icon" />
	<?php echo $this->load->view('homepage/mobile/common/head'); ?>
	<?php echo getSystem('script_header');?>
</head>
<body>
	<?php $this->load->view('homepage/mobile/common/header'); ?>
	<section id="body">
		<?php $this->load->view((isset($template)) ? $template : ''); ?>
		<?php $this->load->view('homepage/mobile/common/slide-partner');  ?>
	</section><!-- #body -->
	
	<?php $this->load->view('homepage/mobile/common/footer'); ?>
	<?php $this->load->view('homepage/mobile/common/offcanvas'); ?>
	<?php $this->load->view('homepage/mobile/common/script');  ?>
	<?php echo getSystem('script_body');?>
	<script>
	$(document).ready(function(){
		$('#fc-cart-notification').load('<?php echo site_url('products/ajax/cart/notification')?>', function(data){});
	});
	</script>
<script>
$(document).ready(function(){
	$('.fc-product-addtocart').click(function(){
		var product = $(this);
		$.post('<?php echo site_url('products/ajax/cart/addtocart')?>', {id: product.attr('data-cart-id'), name: product.attr('title'), quantity: product.attr('data-cart-quantity'), price: product.attr('data-cart-price')}, function(data){
			$('#fc-cart-notification').load('<?php echo site_url('products/ajax/cart/notification')?>', function(data){});
			$('#notification p').html('Thêm sản phẩm <b>'+product.attr('title')+'</b> vào giỏ hàng thành công!');
			UIkit.modal('#notification', {center:true}).show();
		});
		return false;
	});
});
</script>
<div id="notification" class="uk-modal">
	<div class="uk-modal-dialog">
		<button type="button" class="uk-modal-close uk-close"></button>
		<h4>Thông báo</h4>
		<p></p>
	</div>
</div>
</body>
</html>