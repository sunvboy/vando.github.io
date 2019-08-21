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
<div class="boloc-a">
	<button class="btn-click-boloc">Bộ lọc</button>
	<button class="btn btn-danger close-fil"><i class="fas fa-times"></i></button>
	<div class="wp-bo-loc-1">
		<h2 class="h2-title">Bộ lọc nâng cao</h2>

		<?php foreach($attributes_catalogues as $key => $val){ ?>
		<div class="bl00 box-loc1">
			<h4 class="p-mon"><?php echo $val['title']; ?></h4>

			<?php if(isset($val['attributes']) && is_array($val['attributes']) && count($val['attributes'])){ ?>
			<ul class="ul-b list-boloc boloc1">
				<?php foreach($val['attributes'] as $keyAttributes => $valAttributes){ ?>
				<?php if(isset($attribute['attribute'][$val['keyword']]) && count($attribute['attribute'][$val['keyword']]) &&  in_array($valAttributes['id'], $attribute['attribute'][$val['keyword']]) == false) continue; ?>
				<li>
					<label class="checkbox-edit fillter-label tpInputLabel fill-line-<?php echo $key ?>" data-line="fill-line-<?php echo $key ?>"> <?php echo $valAttributes['title']; ?>
						<input type="checkbox" class="filter" name="attr[<?php echo $val['keyword'] ?>]" value="<?php echo $valAttributes['id']; ?>" id="item-<?php echo $valAttributes['id']; ?>">
						<span class="checkmark"></span>
					</label>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
</div>
<?php } ?>
<form class="d-none hidden" id="Formfilter" method="post" action="" >
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