<?php  
	$cart = $this->cart->contents();
	if(isset($cart) && is_array($cart) && count($cart)){
		$temp = NULL;
		foreach($cart as $keyMain => $valMain){
			$temp[] = $valMain['id'];
		}
		if(isset($temp) && is_array($temp) && count($temp)){
			$product = $this->FrontendProducts_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, images, price, saleoff',
				'where' => array('publish' => 1,'trash' => 0,  'alanguage' => $this->fc_lang),
				'table'=> 'products',
				'where_in' => $temp,
				'where_in_field' => 'id',
			), TRUE);
		}
		$temp = NULL;
		foreach($cart as $keyMain => $valMain){
			foreach($product as $keyItem => $valItem){
				if($valItem['id'] == $valMain['id']){
					$valMain['detail'] = $valItem;
				}
			}
			$temp[] = $valMain;
		}
		$cart = $temp;
	}
?>
<div class="cart_block_item mb20">
	<div class="title_cart">
		<i class="fa fa-cart-arrow-down" aria-hidden="true"></i><span>Giỏ hàng</span>
	</div>
	<?php if(isset($cart) && is_array($cart) && count($cart)){ ?>
		<ul class="uk-list listorder">
			<?php $i = 1; foreach($cart as $key => $val){
				$val['detail']['href'] = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products');
				$price = ($val['detail']['saleoff'])?$val['detail']['saleoff']:$val['detail']['price']; ?>
				<li class="item uk-clearfix">
					<input name="quantity" value="<?php echo $val['rowid'] ?>" class="quantity ajax-quantity" type="hidden">
					<div class="title ec-line-3">
						<a href="<?php echo $val['detail']['href']; ?>" title="<?php echo $val['detail']['title']; ?>" target="_blank">
							<?php echo $val['detail']['title'];?>
						</a>
						<span class="delete delete_item"><i class="fa fa-trash"></i></span>
					</div>
					<div class="uk-clearfix box_item_ff">
						<div class="colimg uk-float-left">
							<a href="<?php echo $val['detail']['href'];?>" title="<?php echo $val['detail']['title']; ?>" class="img-scaledown" target="_blank">
								<img src="<?php echo getthumb($val['detail']['images']); ?>" alt="<?php echo $val['detail']['title']; ?>" />
							</a>
						</div>
						<div class="colinfo uk-float-right">
							<div class="uk-flex uk-flex-right uk-flex-middle mb5 price_tt lib-grid-5">
								<div class="tt-price">
									<?php echo number_format($price);?><?php echo $this->lang->line('products_currency') ?>
								</div>
								<div class="b">x</div>
								<div class="quantity">
									<input class="fc-cart-update" data-id="<?php echo $val['rowid'] ?>" type="text" value="<?php echo number_format($val['qty']);?>" name="<?php echo $i ?>[qty]" />
								</div>
							</div>
							<div class="tt-price uk-text-right"><?php echo number_format($price * $val['qty']); ?> ₫</div>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>
		<div class="total">
			<div class="uk-flex uk-flex-middle uk-flex-space-between mb10">
				<div class="title"><?php echo $this->lang->line('total_money') ?></div>
				<div class="price_tt">
					<strong><?php echo number_format($this->cart->total());?><?php echo $this->lang->line('products_currency') ?></strong>
				</div>
			</div>
			<div class="mb10 uk-flex uk-flex-middle uk-flex-space-between">
				<div class="title"><?php echo $this->lang->line('transport') ?></div>
				<div class="price_tt">
					<strong class="ec-uppercase">0<?php echo $this->lang->line('products_currency') ?></strong>
				</div>
			</div>
			<div class="tt-price uk-flex uk-flex-middle uk-flex-space-between">
				<div class="title"><?php echo $this->lang->line('payment_money_after') ?></div>
				<div class="price_tt">
					<strong><?php echo number_format($this->cart->total());?><?php echo $this->lang->line('products_currency') ?></strong>
				</div>
			</div>
			<div class="payment-order">
				<a href="dat-mua.html" title="Thanh toán ngay">Thanh toán ngay</a>
			</div>
		</div>
	<?php }else{ ?>
		<div class="empty-cart uk-text-center">
			<img src="templates/frontend/resources/img/empty_cart.png" alt="empty_cart">
			<span>Giỏ hàng trống</span>
		</div>
	<?php } ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.fc-cart-update').change(function(){
			var qty = $(this).val();
			var rowid = $(this).attr('data-id');
				$.post('<?php echo site_url('products/ajax/cart/updateitemcart')?>', {
					qty: qty, 
					rowid: rowid, 
					}, 
					function(data){
						window.location.reload();
					});
			return false;
		});
	});
	$(document).on('click', '.delete_item', function(){
		var item = $(this);
		var idprd = item.parent().parent().parent().parent().find('.ajax-quantity').val();
		ajax_cart_update1(idprd);
		return false;
	});
	function ajax_cart_update1(idprd){
		$.post('<?php echo site_url('products/ajax/cart/deletecart');?>', {idprd:idprd}, function(data){
			window.location.reload();
		});
	}
</script>
<style>
	.cart_block_item {
	    border: 1px solid #f3f3f3;
	}
	.title_cart {
	    background: #f8f8f8;
	    padding: 10px;
	    font-family: 'Roboto Condensed', sans-serif;
	    font-size: 16px;
	    color: #444;
	}
	.title_cart i{margin-right: 7px;}
	.uk-list.listorder li {
	    padding: 10px;
	    border-bottom: 1px solid #f3f3f3;
	}
	.box_item_ff .colimg {
	    width: 75px;
	    height: 55px;
	}
	.box_item_ff .colinfo  {
		width: -webkit-calc(100% - 85px);
		width: -moz-calc(100% - 85px);
		width: -ms-calc(100% - 85px);
		width: -o-calc(100% - 85px);
		width: calc(100% - 85px);
		font-family: 'Roboto Condensed', sans-serif;
		font-size: 13px;
		color: #555;
	}
	.box_item_ff .colinfo .quantity input {
	    width: 30px;
	    text-align: center;
	}
	.title.ec-line-3 {
	    font-family: 'Roboto Condensed', sans-serif;
	    font-size: 14px;
	    color: #555;
	    margin-bottom: 10px;
	    padding-right: 20px;
		position: relative;
	}
	.title.ec-line-3 a{color: #333;}
	.delete.delete_item {
	    position: absolute;
	    right: 0;
	    top: 5px;
	    width: 20px;
	    height: 20px;
	    text-align: center;
	    cursor: pointer;
	}
	.cart_block_item .total {
	    padding: 10px;
	    background: #f8f8f8;
	    font-family: 'Roboto Condensed', sans-serif;
	    font-size: 14px;
	    color: #555;
	}
	.payment-order a {
	    display: block;
	    background: #67bd50;
	    line-height: 36px;
	    text-align: center;
	    color: #fff;
	    border-radius: 0;
	    margin-top: 10px;
	    font-family: 'Roboto Condensed', sans-serif;
	    font-size: 16px;
	}
	.empty-cart span {
	    display: block;
	    padding: 20px 0;
	    font-family: 'Roboto Condensed', sans-serif;
	    font-size: 16px;
	    color: #444;
	}
	.empty-cart {
	    background: #fcfcfc;
	    padding-top: 20px;
	}
</style>