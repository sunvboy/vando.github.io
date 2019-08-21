<!DOCTYPE html>
<html lang="vi">
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
	<meta name="keywords" content="<?php echo isset($meta_keyword)?htmlspecialchars($meta_keyword):'';?>" />
	<meta name="description" content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />
	<meta name="revisit-after" content="1 days">
	<meta name="rating" content="general">
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
	<link rel="icon" href="<?php echo $this->fcSystem['homepage_favicon']; ?>"  type="image/png" sizes="30x30">
	<?php $this->load->view('homepage/frontend/common/head'); ?>
	<?php echo $this->fcSystem['script_header']; ?>
	<script type="text/javascript">
		var BASE_URL = '<?php echo base_url(); ?>';
	</script>
</head>
<body class="page-child">
	<?php echo $this->fcSystem['script_body']; ?>
	<?php $this->load->view('homepage/frontend/common/header'); ?>
	<main>
		<?php echo show_flashdata_frontend(); ?>
		<?php $this->load->view(isset($template) ? $template : ''); ?>
		<div id="modal-cart" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" style="max-width:768px;">
		      	<div class="modal-content">
			        <div class="modal-body">
			        	<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="cart-content"></div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php $this->load->view('homepage/frontend/common/footer'); ?>
	<?php $this->load->view('homepage/frontend/common/script'); ?>
<!--	<style type="text/css">-->
<!--		.buynow-2 {max-width:740px;margin:0 auto;background:#fff;font-family:'TPBaoMoi',sans-serif!important;}-->
<!--		.buynow-2 .panel-head.mb15 {padding-right: 15px;}-->
<!--		.buynow-2 .heading{position:relative;cursor:pointer;padding-left:40px}-->
<!--		.buynow-2 .heading:before{content:"";position:absolute;width:22px;height:20px;left:10px;top:0;background-image:url(templates/backend/images/spritesheet.png);background-repeat:no-repeat;background-position:-459px -360px}-->
<!--		.buynow-2 .heading .text{display:inline-block;font-size:14px;line-height:20px;font-weight:600;color:#555}-->
<!--		.buynow-2 .heading .text:hover{color:#0388cd}-->
<!--		.buynow-2 .list-cart-heading{width:100%;background:#f7f7f7;font-size:12px;color:#333;padding: 0}-->
<!--		.buynow-2 .list-cart-heading .item{float:left;padding: 10px 15px;text-transform:none;font-weight: bold}-->
<!--		.buynow-2 .list-cart-heading .item+.item{border-left:1px solid #fff}-->
<!--		.buynow-2 .list-cart-heading .product,-->
<!--		.buynow-2 .list-order .product{width:330px}-->
<!--		.buynow-2 .list-cart-heading .price,-->
<!--		.buynow-2 .list-order .price{width:130px}-->
<!--		.buynow-2 .list-cart-heading .count,-->
<!--		.buynow-2 .list-order .count{width:114px}-->
<!--		.buynow-2 .list-cart-heading .prices,-->
<!--		.buynow-2 .list-order .prices{width:130px}-->
<!--		.buynow-2 .list-order>.item{padding:15px 0}-->
<!--		.buynow-2 .list-order>.item+.item{border-top:1px dotted #ccc}-->
<!--		.buynow-2 .list-order .product .thumb{width:80px;border:1px solid #d8d8d8}-->
<!--		.buynow-2 .list-order .price,.buynow-2 .list-order .prices{padding-right:15px;font-size:12px;font-weight:700}-->
<!--		.buynow-2 .list-order .prices span{font-size: 12px;margin-bottom: 5px;display:block}-->
<!--		.buynow-2 .list-order .prices span.old {text-decoration: line-through;font-weight: normal;color: #777;font-style: italic;}-->
<!--		.buynow-2 .list-order .prices span.saleoff {color: #fff;padding: 5px;display: inline-block;background-color: #c80000;border-radius: 5px;font-size: 11px;}-->
<!--		.buynow-2 .list-order .list-item-cart>*{float:left}-->
<!--		.buynow-2 .list-order .product .info{width:250px;padding:0 15px}-->
<!--		.buynow-2 .list-order .product .info .title{font-size:13px;line-height:18px;font-weight:700}-->
<!--		.buynow-2 .list-order .product .info .title .link{color:#333;font-size:12px}-->
<!--		.buynow-2 .list-order .product .info .title .link:hover{color:#0388cd}-->
<!--		.buynow-2 .list-order .product .delete{border:none;background:#fff;font-size:11px;color:#6f0600;cursor:pointer}-->
<!--		.buynow-2 .list-order .product .delete i{color:#959595;margin-right:5px}-->
<!--		.buynow-2 .list-order .price .old{text-decoration:line-through;color:#959595;font-weight:400}-->
<!--		.buynow-2 .list-order .price .saleoff{color:#d60c0c;font-weight:400}-->
<!--		.buynow-2 .list-order .count{text-align:center}-->
<!--		.buynow-2 .list-order .count>*{display:inline-block;position: relative;}-->
<!--		.buynow-2 .list-order .count .btns{position:absolute;width:30px;height:30px;border:1px solid #dfdfdf;top:0;cursor:pointer}-->
<!--		.buynow-2 .list-order .count .abate:before,-->
<!--		.buynow-2 .list-order .count .augment:before{width:12px;height:2px;margin:14px auto;content:"";display:block}-->
<!--		.buynow-2 .list-order .count .abate{left:-30px;border-right:none}-->
<!--		.buynow-2 .list-order .count .abate:before{background:#ccc}-->
<!--		.buynow-2 .list-order .count .augment{right:-30px;border-left:none}-->
<!--		.buynow-2 .list-order .count .augment:before{background:#288ad6}-->
<!--		.buynow-2 .list-order .count .augment:after{content:"";width:2px;height:12px;background:#288ad6;display:block;margin:0 auto;position:absolute;top:9px;left:0;right:0}-->
<!--		.buynow-2 .list-order .count .quantity{width:30px;height:30px;text-align:center;font-size: 12px;border:1px solid #dfdfdf}-->
<!--		.buynow-2 .panel-foot{padding:15px 15px 0;font-size:14px;line-height:20px;color:#333;border-top:1px solid #eee}-->
<!--		.buynow-2 .panel-foot .total .price strong{color:#d60c0c}-->
<!--		.buynow-2 .panel-foot .total p{font-size:13px}-->
<!--		.buynow-2 .panel-foot .action .continue {font-size: 13px;color: #0388cd;background-color: #f8f8f8;border: 1px solid #e8e8e8;line-height: 30px;padding: 0 10px;border-radius: 2px;cursor: pointer;}-->
<!--		.buynow-2 .panel-foot .action .purchase{display:block;position:relative;padding:8px 40px 8px 20px;background:#d60c0c;color:#fff;border:none;font-size:13px;line-height:20px;font-weight:700;cursor:pointer;border-radius:4px}-->
<!--		.buynow-2 .panel-foot .action .purchase:after{content:"";display:block;position:absolute;width:12px;height:8px;background:url(templates/backend/images/spritesheet.png) -264px -81px no-repeat;top:14px;right:15px}-->
<!--		#scrrolbar{max-height:320px}-->
<!--		#scrrolbar::-webkit-scrollbar{height:100%;width:6px}-->
<!--		#scrrolbar::-webkit-scrollbar-thumb{background:#ccc;height:10px;width:7px;border-radius:3px}-->
<!--		#modal-cart .uk-modal-dialog{width:740px!important;padding:20px 0 10px!important}-->
<!--		#modal-cart .uk-modal-dialog>.uk-close:first-child{margin:-16px -15px 0 0}-->
<!--		.action.uk-flex.uk-flex-middle.uk-flex-space-between {width: 100%;}-->
<!--		.cart-scrrolbar {max-height: 320px;overflow: auto;}-->
<!--		.cart-scrrolbar::-webkit-scrollbar {height: 100%; width: 6px;}-->
<!--		.cart-scrrolbar::-webkit-scrollbar-thumb { background: #ccc; height: 10px; width: 7px; border-radius: 3px; }-->
<!--		.mt-scaledown, .mt-scaledown img{width: 100%; height: 100%;display: block;}-->
<!--		.mt-scaledown img{object-fit: scale-down}-->
<!--		#modal-cart .modal-dialog {width: 100%;margin: 0;position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%, -50%);-moz-transform: translate(-50%, -50%);-ms-transform: translate(-50%, -50%);-o-transform: translate(-50%, -50%);transform: translate(-50%, -50%);}-->
<!--		@media screen and (max-width: 767px) {-->
<!--			.buynow-2 .list-cart-heading .product,-->
<!--			.buynow-2 .list-order .product{width: 50%}-->
<!--			.buynow-2 .list-cart-heading .prices, .buynow-2 .list-order .prices,-->
<!--			.buynow-2 .list-cart-heading .count, .buynow-2 .list-order .count{width: 25%}-->
<!--			.buynow-2 .list-order .product .thumb,-->
<!--			.none-768{display: none !important;}-->
<!--		}-->
<!--	</style>-->
</body>
</html>