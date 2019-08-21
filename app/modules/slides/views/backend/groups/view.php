<section class="content-header">
	<h1>Nhóm slide</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
		<li class="active"><a href="<?php echo site_url('slides/backend/groups/view');?>">Nhóm slide</a></li>
	</ol>
</section>
<section class="content">
  <div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-header">
			<!-- <h3 class="box-title pull-right">
				<div class="btn-group">
					<a href="<?php echo site_url('slides/backend/groups/create');?>" class="btn btn-default btn-flat"><i class="fa fa-plus"></i> Thêm mới</a>
				</div>
			</h3> -->
			<div class="box-tools pull-left">
				<form method="get" action="<?php echo site_url('slides/backend/groups/view');?>">
					<div class="input-group pull-left" style="width: 250px;">
						<input type="text" name="keyword" value="<?php echo htmlspecialchars($this->input->get('keyword'));?>" class="form-control" placeholder="Search">
						<div class="input-group-btn">
							<button type="submit" value="action" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div><!-- /.box-header -->
		<?php echo show_flashdata();?>
		<?php if(isset($listSlides) && is_array($listSlides) && count($listSlides)){ ?>
		<div class="box-body table-responsive no-padding">
		<form method="post" action="">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<table class="table table-hover" id="diagnosis-list">
				<tr>
					<th>ID</th>
					<th>Tiêu đề</th>
					<th>Slide(s)</th>
					<th>Người tạo</th>
					<th>Người sửa</th>
					<th>Trạng thái</th>
					<th>Thời gian</th>
					<th class="text-right">Thao tác</th>
				</tr>
				<?php foreach($listSlides as $key => $group){ ?>
				<tr>
					<td><?php echo $group['id'];?></td>
					<td><?php echo $group['title']; ?></td>
					<td><?php echo $group['count_slides'];?></td>
					<td><?php echo $group['user_created'];?></td>
					<td><?php echo $group['user_updated'];?></td>
					<td>
						<a href="<?php echo site_url('slides/backend/groups/set/publish/'.$group['id'].'?redirect='.urlencode(current_url())); ?>" title="" class="status-publish">
							<img src="<?php echo ($group['publish'] > 0)? 'templates/backend/images/publish-check.png':'templates/backend/images/publish-deny.png'; ?>" alt="" />
						</a>
					</td>
					<td><?php echo show_time($group['created']);?></td>
					<td class="text-right">
						<div class="hidden"><?php echo form_input('order_'.$group['id'], $group['order'], ' class="priority"');?></div>
						<div class="btn-group">
							<a href="<?php echo site_url('slides/backend/groups/update/'.$group['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="<?php echo site_url('slides/backend/groups/read/'.$group['id']).'?redirect='.urlencode(current_url());?>" class="btn btn-default"><i class="fa fa-eye"></i></a>
						</div>
					 </td>
				</tr>
				<?php } ?>
			</table>
		</form>
		</div><!-- /.box-body -->
		<?php } else { ?>
		<div class="box-body">
			<div class="callout callout-danger">Không có dữ liệu</div>
		</div><!-- /.box-body -->
		<?php } ?>
		<div class="box-footer clearfix">
			<?php echo isset($listPagination)?$listPagination:'';?>
		</div>
	  </div><!-- /.box -->
	</div>
  </div>
</section><!-- /.content -->
<script src="templates/backend/plugins/jQueryUI/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(window).load(function(){
		var fixHelperModified = function(e, tr){
			var $originals = tr.children();
			var $helper = tr.clone();
			$helper.children().each(function(index){
				$(this).width($originals.eq(index).width())
			});
			return $helper;
		};
		$('#diagnosis-list tbody').sortable({
	    	helper: fixHelperModified,
			update: function(event, ui){
				renumberTable('#diagnosis-list');
			},
			stop: function(event, ui){
				updateTable();
			}
		}).disableSelection();
	});
	function renumberTable(tableID){
		$(tableID + ' tr').each(function(){
			count = $(this).parent().children().index($(this)) + 1;
			$(this).find('.priority').val(count);
		});
	}
	function updateTable(){
		$.post('<?php echo site_url('slides/ajax/groups/sort');?>', {
			priority: $('.priority').serializeArray(),
		}, function(data){});
	}
</script>