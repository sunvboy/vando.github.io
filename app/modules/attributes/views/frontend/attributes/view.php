<div class="uk-container uk-container-center">
	<div class="breadcrumb">
		<ul class="uk-breadcrumb uk-margin-remove">
			<li><a href="." title="Trang chủ" class="link">Trang chủ</a></li>
			<li class="uk-active"><a href="" onclick="return false;" title="<?php echo $DetailAttributes['title']; ?>" class="link"><?php echo $DetailAttributes['title']; ?></a></li>
		</ul>
	</div><!-- end .breadcrumb -->
	<div class="panel skin-2 products-catalogue uk-margin-large-bottom">
		<h1 class="catalogue-heading mb25 mt10"><span class="text"><?php echo $DetailAttributes['title']; ?> </span></h1>
		<?php 
			$manufacture = $this->FrontendAttributes_Model->ReadByFieldArr(array('publish' => 1,'cataloguesid' => 2), 7, TRUE);
		?>
	
		<div class="panel-head mb30 uk-flex uk-flex-middle uk-flex-space-between">
			<?php if(isset($manufacture) && is_array($manufacture) && count($manufacture)){ ?>
			<ul class="uk-list uk-margin-remove uk-clearfix list-1 list uk-hidden-small">
			<?php foreach($manufacture as $key => $val){ ?>
			<?php 
				$title = $val['title'];
				$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'attributes');
			?>
				<li class="item"><a href="<?php echo $href; ?>" class="link" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
			<?php } ?>
			</ul>
			<div class="uk-button-dropdown catalogues uk-visible-small" data-uk-dropdown="{mode:'click', pos:'bottom-left'}">
				<a class="uk-button btn"><i class="fa fa-bars"></i></a>
				<div class="uk-dropdown p0">
				<ul class="uk-list uk-margin-remove list">
				<?php foreach($manufacture as $key => $val){ ?>
				<?php 
					$title = $val['title'];
					$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'attributes');
				?>
					<li class="item"><a href="<?php echo $href; ?>" class="link" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
				<?php } ?>
				</ul>	
			</div></div><!-- end .catalogues -->
			<?php } ?>
			<?php 
				$price = $this->FrontendAttributes_Model->ReadByFieldArr(array('publish' => 1,'cataloguesid' => 3), 7, TRUE);
			?>
			<?php if(isset($price) && is_array($price) && count($price)){ ?>
			<form action="" method="" class="uk-form form">
				<select name="price" id="price" class="select">
					<option value="">Mức giá</option>
					<?php foreach($price as $key => $val){ ?>
					<?php 
						$title = $val['title'];
						$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'attributes');
					?>
					<option value="<?php echo $href; ?>"><?php echo $title; ?></option>
					<?php } ?>
				</select>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#price').change(function(){
							var href = $(this).val();
							window.open(href);
						});
					});
				</script>
			</form><!-- end .form -->
			<?php } ?>
		</div><!-- end .panel-head -->
		<?php if(isset($AttributesList) && is_array($AttributesList) && count($AttributesList)){ ?>
		<div class="panel-body">
			<div class="uk-grid uk-grid-medium uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4">
				<?php foreach($AttributesList as $key => $val) { ?>
				<?php 
					$title = $val['title'];
					$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
					$image = getthumb($val['images']);
					$description = $val['description'];
					$created = show_time($val['created'], 'd/m/Y');
					$price = $val['price'];
					$price_sale = $price - ($price*$val['saleoff'])/100;
				?>
					<div class="item mb30">
						<div class="product-2">
							<div class="thumb mb15 img-slide">
								<div class="badge mb15"><?php echo ($val['saleoff'] > 0) ? 'Sale '.$val['saleoff'].'%' : ''; ?></div>
								<a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="link fc-fit"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a>
							</div>
							<h3 class="title mb10"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="link"><?php echo $title; ?></a></h3>
							<div class="price mb10"><span class="price-new"><?php echo number_format($price_sale); ?>đ</span></div>
							<div class="description mb15">
								<?php echo $description; ?>
							</div>
							<div class="detail"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>" class="link">Chi tiết</a></div>
						</div><!-- end .product-2 -->
					</div><!-- end .item -->
				<?php } ?>
			</div><!-- end .uk-grid -->
		</div><!-- end .panel-body -->
		<?php }else{ echo 'Dữ liệu đang được cập nhật ...'; } ?>
		<?php echo isset($PaginationList) ? $PaginationList : ''; ?>
	</div><!-- end .panel -->
</div><!-- end .uk-container -->