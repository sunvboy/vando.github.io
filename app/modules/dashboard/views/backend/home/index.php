<section class="content-header">
	<h1>Bảng điều khiển</h1>
	<ol class="breadcrumb">
		<li class="active"><a href="<?php echo site_url('admin');?>"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
	</ol>
</section>
 <?php 
	$_payments = $this->Autoload_Model->_get_where(array('select' => 'fullname, phone, created, id, total_price','table' => 'payments','where' => array('trash' => 0,'status' => 'wait'),'limit' => 10,), TRUE);
	$_count_new_payment = $this->Autoload_Model->_get_where(array('select' => 'fullname, phone, created, id, total_price','table' => 'payments','where' => array('trash' => 0,'status' => 'wait'),), TRUE);
	$_count_new_payment = count($_count_new_payment);
	$_count_all_product = $this->db->select('id')->from('products')->where(array('trash' => 0))->count_all_results();
	$row = $this->db->select('*')->from('counter_values')->get()->row_array();
	$_count_all_visitor = $row['all_value'];
	$_count_all_contact = $this->db->select('id')->from('contacts')->where('trash', 0)->count_all_results();
?>

<?php echo show_flashdata(); ?>
<?php $this->fcUser = $this->config->item('fcUser');  ?>
<?php if(in_array('users/backend/groups/dashboard', $this->fcUser['group'])){ ?>
<section class="content">
		<!-- Small boxes (Stat box) -->
	<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
				  <h3><?php echo $_count_new_payment; ?></h3>
				  <p>Đơn hàng mới</p>
				</div>
				<div class="icon">
				  <i class="ion ion-bag"></i>
				</div>
				<a href="<?php echo site_url('payments/backend/payments/view').'?status=wait'; ?>" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
			<!-- small box -->
			 <div class="small-box bg-green">
				<div class="inner">
				  <h3><?php echo $_count_all_product; ?><sup style="font-size: 20px"></sup></h3>
				  <p>Tổng số sản phẩm</p>
				</div>
				<div class="icon">
				  <i class="ion ion-stats-bars"></i>
				</div>
				<a href="<?php echo site_url('products/backend/products/view'); ?>" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			 </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
				  <h3><?php echo $_count_all_visitor; ?></h3>
				  <p>Tổng số lượt truy cập</p>
				</div>
				<div class="icon">
				  <i class="ion ion-person-add"></i>
				</div>
				<a href="#" onclick="return false;" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
				  <h3><?php echo $_count_all_contact; ?></h3>

				  <p>Tổng số liên hệ</p>
				</div>
				<div class="icon">
					<i class="ion ion-ios-albums-outline"></i>
				</div>
				<a href="<?php echo site_url('contacts/backend/home/view'); ?>" target="_blank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
    </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable ui-sortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom" style="cursor: move;">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right ui-sortable-handle">
              <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Thống kê truy cập</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
				
				<div class="item item-2">
					<!--<div id="chart-top-user-container">
					  
					 </div>-->
					 <div id="chart-top-product-container">
								  
					</div>
				</div>
			  </div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->

		 
		   <!-- TO DO List -->
         
          <!-- /.box -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable ui-sortable">
  
				<div class="item item-1">
				</div>
          <!-- /.box -->

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Thống kê kết quả kinh doanh từng năm</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
			<?php $year = $this->input->get('year'); ?>
				<div class="item item-3">
					 <div id="chart-container">
								  
					</div>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
       <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Danh sách đơn hàng mới</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list ui-sortable">
			  <?php foreach($_payments as $key => $val){ ?>
                <li>
                  <!-- drag handle -->
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                 
                  <!-- todo text -->
                  <span class="text"><a style="color:#333;" href="<?php echo site_url('payments/backend/items/view/'.$val['id'].''); ?>" title=""><?php echo $val['fullname']; ?></a> - Đơn giá : <span style="color:#dd4b39;text-align:right;"><?php echo str_replace(',','.',number_format($val['total_price'])); ?> đ</span></span>
                  <!-- Emphasis label -->
                  <small class="label label-danger"><i class="fa fa-clock-o"></i> <time class="timeago" datetime="<?php echo $val['created'];?>"></time></small>
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
					<a style="color:#dd4b39;" href="<?php echo site_url('payments/backend/items/view/'.$val['id'].''); ?>" title=""> <i class="fa fa-edit"></i></a>
                  </div>
                </li>
			  <?php } ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
<script type="text/javascript">

  
</script>
<script>
	$(window).load(function(){
		var width = $('.item-1').width();
		var width_2 = $('.item-2').width();
		
		var param_condition_product_per_year = {
			"caption": "Thống kê kết quả kinh doanh năm <?php echo $year; ?>","subCaption": "<?php echo $this->fcSystem['contact_web']; ?>","xAxisName": "Tháng","yAxisName": "Loại tiền (In VNĐ)",
			"numberPrefix": "","numberSuffix": " VNĐ","paletteColors": "#0075c2",
			"bgColor": "#caf7c0","bgAlpha": "","showCanvasBg": "0","showCanvasBase":"0","borderAlpha": "20","canvasBgAlpha" : "0, 0, 0, 0.25",
			"canvasBorderAlpha": "0","usePlotGradientColor": "0","plotBorderAlpha": "10","placevaluesInside": "1","rotatevalues": "1","valueFontColor": "#ffffff","showXAxisLine": "1","xAxisLineColor": "#999999","divlineColor": "#999999","divLineIsDashed": "1","showAlternateHGridColor": "0","subcaptionFontBold": "0","subcaptionFontSize": "14","thousandSeparator": ".","decimalSeparator": ",","formatNumberScale": "0","logoAlpha": "40", "logoScale": "110", "logoPosition": "TR",};
		
		var param_condition_product_most_viewed = {
			"caption": "Top 05 sản phẩm xem nhiều nhất","subCaption": "<?php echo $this->fcSystem['contact_web']; ?>","xAxisName": "","yAxisName": "Số lượt xem",
			"numberPrefix": "","numberSuffix": " ","paletteColors": "#0075c2",
			"bgColor": "#caf7c0","bgAlpha": "","showCanvasBg": "0","showCanvasBase":"0","borderAlpha": "20","canvasBgAlpha" : "0, 0, 0, 0.25",
			"canvasBorderAlpha": "0","usePlotGradientColor": "0","plotBorderAlpha": "10","placevaluesInside": "1","rotatevalues": "1","valueFontColor": "#ffffff","showXAxisLine": "1","xAxisLineColor": "#999999","divlineColor": "#999999","divLineIsDashed": "1","showAlternateHGridColor": "0","subcaptionFontBold": "0","subcaptionFontSize": "14","theme": "fint", "slantLabels": "1","rotateValues": "0","logoAlpha": "40", "logoScale": "110", "logoPosition": "TR","thousandSeparator": ".","decimalSeparator": ","};
	
		(function () {
			$("#chart-container").insertFusionCharts({type: "column2d",width: width-7,height: "300",dataFormat: "json",dataSource: {"chart": param_condition_product_per_year,"data": <?php echo json_encode($result); ?>}});
			$("#chart-top-product-container").insertFusionCharts({type: "bar2d",width: width_2-4,height: "300",dataFormat: "json",dataSource: {"chart": param_condition_product_most_viewed,"data": <?php echo json_encode($top_p); ?>}});
			}());
	});
</script>
</section>
<?php }else{ ?>
	<section class="content"></sections>
<?php } ?>