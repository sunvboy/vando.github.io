<!DOCTYPE html>
<html lang="vi">
<head>
	<base href="<?php echo base_url();?>" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="vi" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

	<!-- for Google -->
	<title><?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?></title>
	<meta name="description" content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />

	<link rel="stylesheet" type="text/css" href="templates/frontend/resources/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="templates/frontend/resources/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="templates/frontend/resources/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=vietnamese" rel="stylesheet"> 
	<link rel="stylesheet" href="templates/frontend/resources/css/learn.css" />
	<script type="text/javascript" src="templates/frontend/resources/js/jquery.min.js"></script>
	<script type="text/javascript" src="templates/frontend/resources/js/resizable.js"></script>

	<link rel="icon" href="<?php echo $this->fcSystem['homepage_favicon']; ?>"  type="image/png" sizes="30x30">
	<script type="text/javascript">
		var BASE_URL = '<?php echo base_url(); ?>';
	</script>
</head>
<body>
	<div class="page-body-11">
		<?php $this->load->view(isset($template) ? $template : ''); ?>
	</div> <!-- div end site -->    
	<script type="text/javascript" src="templates/frontend/resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="templates/frontend/resources/js/learn.js"></script>
</body>
</html>