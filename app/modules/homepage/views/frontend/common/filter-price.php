<style>
	.block-filter {
	    background: #E9EDEE;
	    padding: 5px;
	    margin-bottom: 15px;
	    width: 100%;
	    float: left;
	}
	.block-filter .option_title {
    border: 1px solid #ddd;
    border-bottom: none;
}
.title_block_center_2 {
    background: none repeat scroll 0 0 #F5F5F5;
    height: 38px;
    line-height: 38px;
    padding-left: 10px;
}
.title-bg {
    padding-right: 5px;
    font-size: 14px;
    font-weight: bold;
}
.block-filter-content {
    border: 1px solid #ddd;
    position: relative;
    clear: left;
    background: #fff;
    border-top: none;
    width: 100%;
    float: left;
}
.block-filter div.price-filter, .block-filter div.attr, .block-filter div.color {
    border-top: 1px solid #ddd;
    height: 45px;
    min-height: 45px;
    overflow: hidden;
    padding-left: 150px;
    position: relative;
    padding-right: 30px;
}
.block-filter div span {
    line-height: 45px;
    background: #F5F6F8;
    color: #7292a7;
    height: 100%;
    width: 150px;
    position: absolute;
    top: 0;
    left: 0;
    text-align: center;
}
.block-filter .filter-attr-item {
    float: left;
}
.block-filter div.attr a {
    display: inline-block;
    margin-left: 20px;
    line-height: 46px;
    font-size: 11px;
    color: #333;
}
.block-filter div.attr i, .block-filter div.color i {
    font-size: 11px;
    font-style: normal;
}
.block-filter div input#amount {
    border: 0px;
    color: #7292a7;
    font-weight: bold;
    float: left;
    margin-top: 15px;
    margin-left: 20px;
    width: 250px;
    font-size: 11px;
}
.hidden {
    display: none;
}
.block-filter {
    background: #E9EDEE;
    padding: 5px;
    margin-bottom: 15px;
    width: 100%;
    float: left;
}
.block-filter-title {
    text-transform: uppercase;
    font-size: 12px;
    background: #E9EDEE;
    color: #333;
    padding: 6px 10px;
    float: left;
    font-weight: 700;
    width: 100%;
    float: left;
}
.block-filter-rule {
    list-style: none;
    width: 100%;
    padding: 5px;
    float: left;
}
.block-filter-rule li {
    display: inline;
    float: left;
    margin: 5px;
    font-weight: 700;
    font-size: 11px;
}
.block-filter-rule li b {
    font-weight: normal;
    float: left;
}
.block-filter-rule li a {
    float: left;
    margin-left: 5px;
    padding-right: 15px;
    background: url(http://v1.webbnc.net/themes/web/common/block/filter_close.png) no-repeat right center;
    color: #333;
}
.block-filter-content .clear-filter {
    display: block;
    width: 16px;
    height: 16px;
    background: url(http://v1.webbnc.net/themes/web/common/block/clear-filter.png) no-repeat;
    position: absolute;
    top: 10px;
    right: 10px;
}
</style>

<script type="text/javascript">
$(function() {
	$("#slider-range-filter").slider({
		range: true,
		min: 35000,
		            max: 1200000,
		values: [ 35000, 1200000 ],
		slide: function( event, ui ) {
		$("#amount").val(number_format(ui.values[0], 0, '.', '.') + " <?php echo $this->lang->line('products_currency') ?> - " + number_format(ui.values[1], 0, '.', '.') + " <?php echo $this->lang->line('products_currency') ?>");
		}
	});
});
</script>
<div class="block-filter">
	<div class="option_title">
		<div class="title_block_center_2">
			<div class="title-bg"><?php echo $this->lang->line('filter_price_advanced') ?></div>
		</div>
	</div>
	<div class="block-filter-content">
		<div id="filter-total">
			<?php if(isset($parentid_catt) && is_array($parentid_catt) && count($parentid_catt)){ ?>
				<div class="attr attr_2">
					<span>Danh mục</span>
				
					<?php foreach($parentid_cat as $key => $valid) { ?> 
					<?php $count_id = catalogues_relationship($valid['id'], 'products', array('Frontendproducts','FrontendproductsCatalogues'), 'products_catalogues'); 
					?>
		    			<div class="filter-attr-item">
		    				<a href="javascript:;" class="filter-category" data-id="<?php echo $valid[
		    			'id'] ?>"><?php echo $valid[
		    			'title'] ?></a> <i>(<?php echo (isset($count_id) && is_array($count_id) && count($count_id) ) ? count($count_id) : 0; ?>)</i>
		    			</div>
    				<?php } ?>
				</div>
			<?php } ?>
			<div class="price-filter">			
				<span><?php echo $this->lang->line('product_price_range') ?></span>
				<div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"></div>			
				<input id="amount" readonly="" type="text">		
				<div id="data_cat" data-id="<?php echo $DetailCatalogues['id'] ?>"></div>
				<div id="data_catgoc" data-id="<?php echo $DetailCatalogues['id'] ?>"></div>
			</div>			

			<div class="clr"></div>
		</div> 				
	</div>
</div>
<div class="block-filter hidden" id="filter-rule">
	<div class="block-filter-title"><?php echo $this->lang->line('product_filter_condition'); ?></div>
	<div class="block-filter-content">
		<ul class="block-filter-rule">
			<li id="filter-category"></li>
			<li id="filter-price"></li>
		</ul>
		<div class="clearfix"></div>
		<a href="javascript:;" class="clear-filter" title="<?php echo $this->lang->line('clear_filter') ?>"></a>
	</div>	
</div>
<div class="clr"></div>

<link rel="stylesheet" href="templates/frontend/resources/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php if(isset($maxprice) && is_array($maxprice) && count($maxprice)){ 
	foreach($maxprice as $key => $val) { 
		$maxprice = $val['max'];
	}
}
?> 

<script>
	function number_format (number, decimals, dec_point, thousands_sep) {
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}
  	$( function() {
    	$( "#slider-range" ).slider({
      		range: true,
      		min: 0,
     	 	max: <?php echo $maxprice ?>,
      		values: [ 0, <?php echo $maxprice ?> ],
      		slide: function( event, ui ) {
        		$( "#amount" ).val( "" + number_format(ui.values[ 0 ], 0, '.', '.') + ' <?php echo $this->lang->line('products_currency') ?>' + " - " +  number_format(ui.values[ 1 ], 0, '.','.') + ' <?php echo $this->lang->line('products_currency') ?>' );
      		}
    	});
    	$( "#amount" ).val( "" + number_format($( "#slider-range" ).slider( "values", 0 ), 0, '.', '.')  + ' <?php echo $this->lang->line('products_currency') ?>' + " - " +  number_format($( "#slider-range" ).slider( "values", 1 ), 0, '.', '.') + ' <?php echo $this->lang->line('products_currency') ?>' );
  	});

  	// Tìm kiếm theo khoảng giá
$(document).ready(function(){
	$('#slider-range').mouseup(function(){ 					
		var category   = $("#data_cat").attr("data-id");
		var price      = $("#amount").val();			

		var data = {
			'category'   : category,
			'price'      : price,
		};	

		$.post("products/ajax/catalogues/ajax", data, function(data) {
			var json = JSON.parse(data);
			$('#filter-rule').removeClass('hidden');
			$('#dateajax').html(json.html);
			$('#filter-price').html(json.price);
			// $('#filter-category').html(json.category);
		});
	});
	$('.filter-category').click(function(){ 
		$('.filter-attr-item').css('display', 'none');
		$(this).parent().css('display', 'block');
		var category   = $(this).attr("data-id");
		var price      = $("#amount").val();	
		var data = {
			'category'   : category,
			'price'      : price,
		};	
		$("#data_cat").attr("data-id", category);
		$.post("products/ajax/catalogues/ajax", data, function(data) {
			var json = JSON.parse(data);
			$('#filter-rule').removeClass('hidden');
			$('#dateajax').html(json.html);
			$('#filter-price').html(json.price);
			// $('#filter-category').html(json.category);
		});
	});
	$(document).on('click','#filter-category' ,function(){
		var category   = $('#data_catgoc').attr("data-id");
		var price      = $("#amount").val();	
		var data = {
			'category'   : category,
			'price'      : price,
		};	
		$("#data_cat").attr("data-id", category);
		$('.filter-attr-item').css('display', 'block');
		$.post("products/ajax/catalogues/ajax", data, function(data) {
			var json = JSON.parse(data);
			$('#filter-rule').removeClass('hidden');
			$('#dateajax').html(json.html);
			$('#filter-price').html(json.price);
			// $('#filter-category').html(json.category);
		});
	});
	$(document).on('click','#filter-price' ,function(){
		$( "#slider-range" ).slider({
      		range: true,
      		min: 0,
     	 	max: <?php echo $maxprice ?>,
      		values: [ 0, <?php echo $maxprice ?> ],
      		slide: function( event, ui ) {
        		$( "#amount" ).val( "" + number_format(ui.values[ 0 ], 0, '.', '.') + ' <?php echo $this->lang->line('products_currency') ?>' + " - " +  number_format(ui.values[ 1 ], 0, '.','.') + ' <?php echo $this->lang->line('products_currency') ?>' );
      		}
    	});
    	$( "#amount" ).val( "" + number_format($( "#slider-range" ).slider( "values", 0 ), 0, '.', '.')  + ' <?php echo $this->lang->line('products_currency') ?>' + " - " +  number_format($( "#slider-range" ).slider( "values", 1 ), 0, '.', '.') + ' <?php echo $this->lang->line('products_currency') ?>' );
    	var category   = $("#data_cat").attr("data-id");
		var price      = $("#amount").val();			

		var data = {
			'category'   : category,
			'price'      : price,
		};	

		$.post("products/ajax/catalogues/ajax", data, function(data) {
			var json = JSON.parse(data);
			$('#filter-rule').removeClass('hidden');
			$('#dateajax').html(json.html);
			$('#filter-price').html(json.price);
			// $('#filter-category').html(json.category);
		});
	});
	$(document).on('click','.clear-filter' ,function(){
		$( "#slider-range" ).slider({
      		range: true,
      		min: 0,
     	 	max: <?php echo $maxprice ?>,
      		values: [ 0, <?php echo $maxprice ?> ],
      		slide: function( event, ui ) {
        		$( "#amount" ).val( "" + number_format(ui.values[ 0 ], 0, '.', '.') + ' <?php echo $this->lang->line('products_currency') ?>' + " - " +  number_format(ui.values[ 1 ], 0, '.','.') + ' <?php echo $this->lang->line('products_currency') ?>' );
      		}
    	});
    	$( "#amount" ).val( "" + number_format($( "#slider-range" ).slider( "values", 0 ), 0, '.', '.')  + ' <?php echo $this->lang->line('products_currency') ?>' + " - " +  number_format($( "#slider-range" ).slider( "values", 1 ), 0, '.', '.') + ' <?php echo $this->lang->line('products_currency') ?>' );
    	var category   = $("#data_catgoc").attr("data-id");
		var price      = $("#amount").val();			

		var data = {
			'category'   : category,
			'price'      : price,
		};	

		$.post("products/ajax/catalogues/ajax", data, function(data) {
			var json = JSON.parse(data);
			$('#filter-rule').addClass('hidden');
			$('#dateajax').html(json.html);
			$('.filter-attr-item').css('display', 'block');
		});
	});
});
</script>