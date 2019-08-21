<?php 
	$attribute = json_decode($DetailCatalogues['attributes'], TRUE); 
	if($attribute['attribute_catalogue'] != ''){
		$attributes_catalogues  = $this->Autoload_Model->_get_where(array(
			'select' => 'id, title, keyword',
			'table' => 'attributes_catalogues',
			'order' => 'order desc, id desc',
			'where' => array('publish' => 1,'trash' => 0),
			'where_in' => $attribute['attribute_catalogue'],
			'where_in_field' => 'id'
		), TRUE);
	}
	if(isset($attributes_catalogues) && is_array($attributes_catalogues) && count($attributes_catalogues)){
		foreach($attributes_catalogues as $key => $val){
			$attributes_catalogues[$key]['attributes'] = $this->Autoload_Model->_get_where(array(
				'select' => 'id, title',
				'table' => 'attributes',
				'order' => 'order desc, id desc',
				'where' => array('publish' => 1,'trash' => 0,'cataloguesid' => $val['id']),
			), TRUE);
		}
	}
?>
<?php if(isset($attributes_catalogues) && is_array($attributes_catalogues) && count($attributes_catalogues)){ ?>
<div class="aside-fillter">
	<section class="fillter_bl">
		<div class="content_fillter">
			<div class="group-fillter uk-clearfix">
				<div class="attribute-title">
					<label class="form-label tpInputLabel">Bộ lọc sản phẩm</label>
				</div>
				<div class="attribute-group" style="padding: 15px;line-height: 22px;font-family: TPBaoMoi; color: red">
					<p>Giúp quý khách tìm kiếm sản phẩm phù hợp nhất</p>
				</div>
			</div>
			<?php foreach($attributes_catalogues as $key => $val){ ?>
				<div class="group-fillter uk-clearfix fill-key-<?php echo $key ?>">
					<div class="attribute-title click">
						<label class="form-label tpInputLabel"><?php echo $val['title']; ?><span></span></label>
					</div>
					<?php if(isset($val['attributes']) && is_array($val['attributes']) && count($val['attributes'])){ ?>
						<div class="attribute-group hidden-mobile">
						<?php foreach($val['attributes'] as $keyAttributes => $valAttributes){ ?>
							<?php if(isset($attribute['attribute'][$val['keyword']]) && count($attribute['attribute'][$val['keyword']]) &&  in_array($valAttributes['id'], $attribute['attribute'][$val['keyword']]) == false) continue; ?>
								<label class="fillter-label tpInputLabel fill-line-<?php echo $key ?>" data-line="fill-line-<?php echo $key ?>">
									<input class="filter" type="checkbox" name="attr[<?php echo $val['keyword'] ?>]" value="<?php echo $valAttributes['id']; ?>" id="item-<?php echo $valAttributes['id']; ?>" />
									<label class="<?php echo ((!empty($valAttributes['images'])) ? 'square-check' : 'label-check') ?>" for="item-<?php echo $valAttributes['id']; ?>" style="<?php echo ((!empty($valAttributes['images'])) ? 'background-color: #'.$valAttributes['images'].';' : '') ?>">
										<?php echo $valAttributes['title']; ?>
									</label>
								</label>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</section>
</div>
<?php } ?>
<form class="d-none" id="Formfilter" method="post" action="" >
	<input type="text" value="" name="attr" id="attr" class="confirm-filter" />
	<input type="text" value="1" name="page" id="page" class="" />
	<input type="text" value="<?php echo $DetailCatalogues['id']; ?>" name="cataloguesid" id="cataloguesid" class="" />
	<input type="submit" value="" name="submit" id="filter_submit" class="" />
</form>
<script type="text/javascript">
	$(document).ready(function(){
		var time;
		$('#Formfilter').on('submit',function(e){
			$('.backend-loader').show();
			var attr = $('#attr').val();
			var page = $('#page').val();
			var cataloguesid = $('#cataloguesid').val();
			var postData = $(this).serializeArray();
			var formURL = 'products/ajax/products/filter';
			clearTimeout(time);
			time = setTimeout(function() {
				$.post(formURL, {
				post: attr, page:page,cataloguesid:cataloguesid},
				function(data){
					var json = JSON.parse(data);
					if(json.html.length){
						$('#ajax-product-list').html('').html(json.html);
						$('#ajax-product-pagination').html('').html(json.page);
					}else{
						$('#ajax-product-list').html('<div class="mtb10 col-md-12 text-center">Không có dữ liệu phù hợp</div>');
					}
					$('.backend-loader').hide();
				});
			}, 300);
			return false;
		});
		
		
		$('.filter').change(function(e){
			var str = '';
			$('.filter').each(function(){
				if($(this).val() != 0  && $(this).prop('checked') == true){
					str = str + $(this).val() + '-';
				}
			});
			if(str.length > 0){
				str = str.substr(0, str.length - 1);
				$('#attr').val(str);
			}else{
				$('#attr').val('');
			}
			e.stopImmediatePropagation();
			$('#filter_submit').click();
		});
		
		$('input.filter').click(function() {
			var id = $(this).prop('id');
			var name = $(this).prop('name');
			$('input[name="'+name+'"]:not(#'+id+')').prop('checked',false);
		});

		if ($(window).width() < 767) {
			$('.attribute-title.click').click(function(){
				$(this).next().slideToggle('slow');
				$(this).toggleClass('mt-active');
			});
		}
	});
	$(function(){
		$('.tpInputLabel').on('click', function() {
			// Add text
			var text = $(this).find('.label-check').html();
			$(this).parent().parent().find('span').html('').html(text);

			// Active checkbox
			var line = $(this).attr('data-line');
			$('.'+line+'').removeClass('checked');
			if($(this).find('.filter').is(':checked')) {
				$(this).addClass('checked');
			}else {
				$(this).removeClass('checked');
			}
			if ($(window).width() < 767) {
				$(this).parent().parent().find('.attribute-title.click').removeClass('mt-active');
				$(this).parent().parent().find('.attribute-group').slideUp();
			}
		});
	});
	$(function(){
		$(document).on('click','#ajax-pagination li a',function(e){
			var page = $(this).attr('data-ci-pagination-page');
			$('#page').val(page);
			e.stopImmediatePropagation();
			$('#filter_submit').click();
			return false;
		});
	});
</script>
<style>
	.content_fillter {
	    border: 1px solid #f0f0f0;
	}
	.attribute-title {
	    line-height: 34px;
	    color: #333;
	    border-bottom: solid 1px #e4e4e4;
	    text-shadow: 1px 1px 0 #fff;
	    background: #eee;
	    font-weight: bold;
	    padding: 0 10px;
	    font-family: 'TPBaoMoi', sans-serif;
		font-size: 16px;
		position: relative
	}
	.attribute-group {
	    padding: 5px 0;
	}
	.attribute-group .fillter-label {
	    padding-left: 10px;
	    display: block;
	    line-height: 30px;
	    font-size: 14px;
	    position: relative;
	    height: 30px;
	    overflow: hidden;
	}
	.attribute-group .fillter-label label {
	    padding-left: 20px; font-family: 'TPBaoMoi', sans-serif;
	}
	.attribute-group input[type="checkbox"] {
	    display: none;
	}
	.fillter-label.tpInputLabel label::before {
	    height: 16px;
	    width: 16px;
	    border: 1px solid #ccc;
	    border-radius: 2px;
	    content: '';
	    display: block;
	    position: absolute;
	    left: 10px;
	    top: 8px;
	}
	.fillter-label.tpInputLabel.checked label::before {
	    background: url('/templates/frontend/resources/images/checked.png');
	    border: 0;
	}
	.form-label.tpInputLabel span {
	    color: red;
	    font-weight: normal;
	    font-size: 12px;
	    margin-left: 5px;
	    display: none;
	}
	@media screen and (max-width: 767.5px) {
		.hidden-mobile{display: none;}
		.form-label.tpInputLabel span {display: inline-block;}
		.attribute-title.click:before{
			content: '';
			width: 35px;
			height: 35px;
			background-image: url('/templates/frontend/resources/images/plus.png');
			background-repeat: no-repeat;
			background-position: center center;
			position: absolute;
			top: 0;
			right: 0;
		}
		.attribute-title.click.mt-active:before{
			background-image: url('/templates/frontend/resources/images/minus.png');
		}
	}
</style> 