<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>FinalCMS - Login</title>
<base href="<?php echo base_url();?>" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="templates/backend/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="templates/backend/font-awesome-4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="templates/backend/ionicons-2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="templates/backend/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="templates/backend/plugins/iCheck/square/blue.css">
<script src="templates/backend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition login-page">
<?php isset($template)?$this->load->view($template):NULL;?>
<script src="templates/backend/bootstrap/js/bootstrap.min.js"></script>
<script src="templates/backend/plugins/iCheck/icheck.min.js"></script>
<script>
$(function(){
	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%'
	});
});
</script>
</body>
</html>