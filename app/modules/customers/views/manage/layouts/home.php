<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo $this->fcSystem['homepage_company']; ?> software</title>
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
	<?php $this->load->view('customers/manage/common/nav', isset($data)?$data:NULL);?>
	</header>

	<aside class="main-sidebar">
		<?php $this->load->view('customers/manage/common/sidebar', isset($data)?$data:NULL);?>
	</aside>

	<div class="content-wrapper">
		<?php isset($template)?$this->load->view($template):NULL;?>
	</div><!-- /.content-wrapper -->

	<footer class="main-footer">
		<div class="pull-right hidden-xs">Tam Phat software</div>
		<strong>Copyright &copy; 2017 <a href="http://thietkewebtamphat.com/" title="Thiết kế Website Chuyên Nghiệp" target="_blank">Tam Phat</a> by</strong> All rights reserved.
	</footer>

	<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<script src="templates/backend/bootstrap/js/bootstrap.min.js"></script>
<script src="templates/backend/plugins/select2/select2.full.min.js"></script>
<script src="templates/backend/plugins/datetimepicker/jquery.datetimepicker.js"></script>
<script src="templates/backend/plugins/timeago/jquery.timeago.js"></script>
<script src="templates/backend/dist/js/app.min.js"></script>
<script src="templates/backend/plugins/ckeditor-4.4.3/ckeditor.js"></script>
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
		//colorbutton,
		CKEDITOR.replace( this.id, {
			height: 250,
			extraPlugins: 'colorbutton,font,lineutils,justify,lineheight,youtube,',
			removeButtons: '',
			entities: false,
			allowedContent: true,
			toolbarGroups: [
				{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
				{ name: 'links' },
				{ name: 'insert' },
				{ name: 'forms' },
				{ name: 'tools' },
				{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'colors' },
				{ name: 'others' },
				'/',
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
				{ name: 'styles' }
			],
		});
	});
	$('.textarea').wysihtml5();
	$('.select2').select2();
	$('.datetimepicker').datetimepicker({
		format:'H:i - d/m/Y',
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
    window.open('<?php echo BASE_URL;?>plugins/kcfinder-master-frontend/browse.php?type='+type+'&dir=images/public', 'kcfinder_image',
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
    window.open('<?php echo BASE_URL;?>plugins/kcfinder-master-frontend/browse.php?type='+type+'&dir=images/public', 'kcfinder_image',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=1080, height=800'
    );
	return false;
}

$(document).ready(function() {
	

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