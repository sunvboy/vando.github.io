<section class="content-header">
	<h1>Upload file lên thư mục gốc</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('files/backend/files/view');?>">Files</a></li>
	</ol>
</section>
<!-- Main content -->
	<section class="content">
	<div class="row">
		 <form action="<?php echo site_url("files/backend/files/upload") ?>" id="form-upload">
			<div class="col-md-3">
				<div class="box box-solid">
					<div class="box-body no-padding" style="border:1px solid #ccc;">
						<ul class="nav nav-pills nav-stacked">
							<li class="active" style="padding:5px;">
								<div class="alert alert-warning alert-dismissible" style="font-size:13px;">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									Hãy chắc chắn rằng bạn muốn upload file này lên hệ thống ( Hệ thống chỉ cho phép bạn upload 4 định dạng file XML|TXT|HTML|ZIP với dung lượng không vượt quá 2MB)
								</div>
								<input type="file"  name="file" class="">
							</li>
							<li>
								<a href="#">
									<div class="progress" style="display:none;">
										<div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
											20%
										</div>
									</div>
								</a><!-- <progress id="progress-bar" max="100" value="0"></progress> -->
							</li>
						</ul>
					</div>
					<!-- /.box-body -->
					<script type="text/javascript">
						$(function(){
							var inputFile = $('input[name=file]');
							var uploadURI = $('#form-upload').attr('action');
							var progressBar = $('#progress-bar');
							
							listFilesOnServer();
							
							$('#upload-btn').on('click',function(event){
								var fileToUpload = inputFile[0].files[0];
								if(fileToUpload != 'undefined'){
									var formData = new FormData();
									formData.append('file',fileToUpload);
									$.ajax({
										url : uploadURI,
										type: 'post',
										data: formData,
										processData: false,
										contentType: false,
										success: function(json){
											listFilesOnServer();
										},
										xhr:function(){
											var xhr = new XMLHttpRequest();
											xhr.upload.addEventListener('progress',function(event) {
												if(event.lengthComputable){
													var percentCompele = Math.round((event.loaded / event.total)*100);
													//console.log(percentCompele);
													$('.progress').show();
													progressBar.css({width:percentCompele + '%'});
													progressBar.text(percentCompele + '%');
												}
											}, false);
											return xhr;
										}
									});
								}
								return false;
							});
							
							$(document).on('click','.remove-file',function(){
								var me = $(this);
								$.ajax({
									url: uploadURI,
									type: 'post',
									data: {file_to_remove: me.attr('data-file')},
									success: function(){
										me.closest('tr').remove();
									}
								});
								return false;
							});
							
							function listFilesOnServer(){
								var items = [];
								$.getJSON(uploadURI,function(data){
									$.each(data,function(index, element){
										items.push('<tr><td class="mailbox-star" style="width:30px;"><a onclick="return false;" href="#" data-file="' + element + '" class="remove-file"><i class="fa fa-trash text-red"></i></a></td><td class="mailbox-name"><a  onclick="return false;" style="color:#333;" href="read-mail.html">' + element  + '</a></td></tr>');
									});
									$('.list-group-file').html('').html(items.join(''));
								});
							}
						});
					</script>
				</div>
				<a href="#" id="upload-btn" onclick="return false;" class="btn btn-success fileinput-exists btn-block margin-bottom"><i class="glyphicon glyphicon-open"></i> Upload</a>
			</div>
		</form>
		<!-- /.col -->
		<div class="col-md-9">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Danh sách file trên thư mục gốc</h3>
				<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
					<div class="table-responsive mailbox-messages">
						<table class="table table-hover table-striped">
							<tbody class="list-group-file">
								
							</tbody>
						</table>
					<!-- /.table -->
					</div>
				<!-- /.mail-box-messages -->
				</div>
			<!-- /.box-body -->
			</div>
		<!-- /. box -->
		</div>
	<!-- /.col -->
	</div>
	<!-- /.row -->
</section>