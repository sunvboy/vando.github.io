<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Tâm phát software</title>
<base href="<?php echo base_url();?>" />
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<link rel="stylesheet" href="templates/backend/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="templates/backend/font-awesome-4.4.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="templates/backend/ionicons-2.0.1/css/ionicons.min.css" />
<link rel="stylesheet" href="templates/backend/plugins/datetimepicker/jquery.datetimepicker.css">
<link rel="stylesheet" href="templates/backend/plugins/select2/select2.min.css" />
<link rel="stylesheet" href="templates/backend/dist/css/AdminLTE.min.css" />
<link rel="stylesheet" href="templates/backend/dist/css/AdminLTE.custom.css" />
<link rel="stylesheet" href="templates/backend/dist/css/skins/skin-blue.min.css" />
<link rel="stylesheet" href="templates/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" />
<script src="templates/backend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>var BASE_URL = '<?php echo BASE_URL;?>';</script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<header class="main-header">
	<?php $this->load->view('dashboard/backend/common/nav', isset($data)?$data:NULL);?>
	</header>

	<aside class="main-sidebar">
		<?php $this->load->view('dashboard/backend/common/sidebar', isset($data)?$data:NULL);?>
	</aside>

	<div class="content-wrapper">
		<?php isset($template)?$this->load->view($template):NULL;?>
	</div><!-- /.content-wrapper -->

	<footer class="main-footer">
		<div class="pull-right hidden-xs">Tâm phát software</div>
		<strong>Copyright &copy; 2017 <a href="http://webvaseo.com.vn/" title="Thiết kế Website Chuyên Nghiệp" target="_blank">Tâm phát software</a> by</strong> All rights reserved.
	</footer>

	<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<script src="templates/backend/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script src="templates/backend/plugins/select2/select2.full.min.js"></script>
<script src="templates/backend/plugins/datetimepicker/jquery.datetimepicker.js"></script>
<script src="templates/backend/plugins/timeago/jquery.timeago.js"></script>
<script src="templates/backend/dist/js/app.min.js"></script>
<script src="templates/backend/plugins/ckeditor/ckeditor.js"></script>
<script src="templates/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- CHART -->
<script src="templates/backend/plugins/fusioncharts-jquery-plugin-master/src/fusioncharts.js"></script>
<script src="templates/backend/plugins/fusioncharts-jquery-plugin-master/src/fusioncharts.theme.fint.js"></script>
<script src="templates/backend/plugins/fusioncharts-jquery-plugin-master/src/fusioncharts.theme.zune.js"></script>
<script src="templates/backend/plugins/fusioncharts-jquery-plugin-master/src/fusioncharts.jqueryplugin.js"></script>
<script src="templates/backend/plugins/fusioncharts-jquery-plugin-master/src/fusioncharts-jquery-plugin.js"></script>
<script src="templates/backend/plugins/jscolor-2.0.4/jscolor.min.js"></script>
<script src="templates/backend/script.js"></script>
<!--- CHART -->
<script type="text/javascript">
$(function(){
	$('.ckeditor-description').each(function(){
		CKEDITOR.replace( this.id);
	});
	$('.textarea').wysihtml5();
	$('.select2').select2();
	$('.datetime').datetimepicker({
		format:'Y-m-d H:i:s',
		timepicker:false,
	});
	$('.datetimepicker').datetimepicker({
		format:'Y-m-d',
	});
	$('.timeago').timeago();
});
function in_array(search, array){
	for (i = 0; i < array.length; i++){
		if(array[i] == search){
			return true;
		}
	}
	return false;
}
function openKCFinder(field, type) {
    window.KCFinder = {
        callBack: function(url) {
            field.value = url;
            window.KCFinder = null;
        }
    };
	if(typeof(type) == 'undefined'){
		type = 'images';
	}
    window.open('<?php echo BASE_URL; ?>plugins/kcfinder-master/browse.php?type='+type+'&dir=images/public', 'kcfinder_image',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=1080, height=800'
    );
}
function openKCFinderAlbum(field, type, result) {
    window.KCFinder = {
        callBack: function(url) {
            field.attr('src', url);
            field.parent().next().val(url);
            window.KCFinder = null;
        }
    };
	if(typeof(type) == 'undefined'){
		type = 'images';
	}
    window.open('<?php echo BASE_URL; ?>plugins/kcfinder-master/browse.php?type='+type+'&dir=images/public', 'kcfinder_image',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=1080, height=800'
    );
	return false;
}

$(document).ready(function() {
	//Tạo liên kết tĩnh
	$('.create-static-links').click(function(event) {
		var canonical = $('.form-static-link').val();
		$.post('<?php echo site_url('articles/ajax/catalogues/createLink'); ?>', {canonical: canonical}, function(data){
		   $('.canonical').val(data);
		});
		event.preventDefault();
	});

	//Sắp xếp bài viết, sản phẩm, hình ảnh ....
	var time;
	$('.sort-order').on('keyup', function(event) {
		var module = $(this).attr('data-module');
		var id = $(this).attr('data-id');
		var number = $(this).val();
		var url = module +'/ajax/'+ module + '/sort_order';
		clearTimeout(time);
		time = setTimeout(function() {
			$('.backend-loader').show();
			$.post(url, {table: module, id: id, number: number}, function(data){
			 $('.backend-loader').hide();
			});
		}, 800);
	});
});
$(document).ready(function() {
	$('.language-header').click(function(event) {
		var lang = $(this).attr('data-lang');
       	$.post('<?php echo site_url('systems/ajax/systems/language'); ?>', {lang: lang}, function(data){
		   window.location.reload();
		});
	});
});
$('.datetimemonthsale').datetimepicker({
	format:'Y-m-d H:i:s',
	minDate: '-1970/01/01',
});

</script>
 <!-- Modal -->
  <div class="modal fade" id="alertModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="message-alert">This is a small modal.</div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>