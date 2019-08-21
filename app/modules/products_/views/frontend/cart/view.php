<style tyle="text/css">
	.order-1 {margin-top: 20px;font-family: 'TPBaoMoi'}
	.mtb20{margin: 20px 0;}
	.order-1 .box_cart{background: #fff; padding: 0;}
	.order-1 .payment .step .item {float: left;width: 33.33%;}
	.order-1 .payment .step .item:last-child a:before{display: none;}
	.order-1 .payment .step .link {display: block;padding: 8px 35px 8px 30px;font-size: 13px;line-height: 20px;color: #333;font-weight: bold;background: #f0f0f0;position: relative;}
	.order-1 .payment .step .active .link {background: #f4f9fd;}
	.order-1 .payment .step .link:before, 
	.order-1 .payment .step .link:after {content:"";position: absolute;top: 50%;-webkit-transform: translate(0, -50%);-ms-transform: translate(0, -50%);-o-transform: translate(0, -50%);transform: translate(0, -50%);border-top: 20px solid transparent;border-bottom: 20px solid transparent;border-left: 13px solid;right: -13px;}
	.order-1 .payment .step .link:before {border-left-color: #fff;right: -14px;z-index: 1;}
	.order-1 .payment .step .link:after {z-index: 2;border-left-color: #f1f1f1;}
	.order-1 .payment .step .step-3 .link:after, .order-1 .payment .step .step-3 .link:after {display: none;}
	.order-1 .payment .step .active .link:after  {border-left-color: #f4f9fd;}
	.order-1 .payment .step .number {display: inline-block;margin-right: 5px;width: 24px;height: 24px;border-radius: 50%;background: #999;color: #fff;text-align: center;font-size: 12px;line-height: 24px;}
	.uk-clearfix.mb15 {width: 100%;float: left;margin-bottom: 15px;	}
	.item.uk-clearfix{width: 100%;float: left;}
	.order-1 .payment .step .complete .number {text-indent: -999px;background: url(templates/backend/images/icon-checked.png) 0% 0% no-repeat;}
	.order-1 .payment .step .active .number {background: #0492d5;}
	.order-1 .information .uk-panel {border: 1px solid #eee;}
	.order-1 .information .panel-head {padding: 10px 15px;background: #f7f7f7;border-bottom: 1px solid #eee;}
	.order-1 .information .panel-head .title {font-size: 14px;margin: 0;color: #333;}
	.order-1 .information .panel-head .title .number {color: #666;font-size: 13px;}
	.order-1 .information .panel-head .change {color: #0386ca;font-size: 12px;}
	.order-1 .listorder>.item {padding: 15px 15px;overflow: hidden;}
	.order-1 .listorder>.item+.item {border-top: 1px dotted #ccc;}
	.order-1 .listorder .colimg {width: 80px;margin-right: 15px;float: left;}
	.order-1 .listorder .colinfo {width: calc(100% - 95px);-moz-width: calc(100% - 95px);-webkit-width: calc(100% - 95px);-o-width: calc(100% - 95px);-ms-width: calc(100% - 95px);float: left;}
	.order-1 .listorder .colimg .img {width: 100%;display: block;}
	.order-1 .listorder .colimg .img img{height: 100%;width: 100%;object-fit: scale-down;}
	.order-1 .listorder .colinfo .title {font-size: 13px;line-height: 18px;margin-bottom: 0px;width:70%;font-weight: bold;}
	.order-1 .listorder .colinfo .title .link {color: #555;font-size: 13px;display: block}
	.order-1 .listorder .colinfo .title .link:hover {color: #288ad6;}
	.order-1 .listorder .colinfo .price {font-size: 13px;line-height: 18px;text-align: right}
	.order-1 .total {padding: 8px 15px;border-top: 1px solid #ebebeb;}
	.order-1 .total .tt-price {border-top: 1px dashed #ccc;padding-top: 15px;}
	.order-1 .total .tt-price .price {color: #d60c0c;}
	.order-1 .customer .panel-body, .order-1 .payment-methods .panel-body {padding: 20px 0px;}
	.order-1 .customer .col.left  {float: left;width: 135px;}
	.order-1 .customer .col.right  {float: right;width: -moz-calc(100% - 145px);width: -webkit-calc(100% - 145px);width: -o-calc(100% - 145px);width: calc(100% - 145px)}
	.order-1 .customer label.label, .order-1 .customer span.no-required {display: block;font-size: 14px;color: #000;padding: 0;line-height: 34px;text-align: left;font-weight: normal;}
	.order-1 .customer span.no-required {color: #999;}
	.order-1 .customer .panel-body .text, .order-1 .customer .panel-body .select {border: 1px solid #ccc;border-radius: 3px;font-size: 13px;color: #252525;height: 32px}
	.order-1 .customer .sex .item+.item {margin-left: 20px;}
	.order-1 .customer .sex input {margin-right: 5px;}
	.order-1 .giftcode .panel-body {padding: 20px;}
	.order-1 .giftcode .btn {position: absolute;height: 32px;padding: 4px 15px;font-size: 13px;color: #fff;background: #0388cd;border: none;top: 0px;right: 0px;cursor: pointer;border-radius: 0 3px 3px 0;}
	.order-1 .giftcode .note {font-size: 13px;font-style: italic;color: #999;}
	.order-1 .giftcode .note .text-black {color: #252525;}
	.order-1 .giftcode .note .link {color: #0386ca;}
	.order-1 .payment-methods input[type=radio] {display: none;}
	.order-1 .payment-methods input[type=radio]:checked + .label .inner {border-color: #0388cd;}
	.order-1 .payment-methods input[type=radio]:checked + .label:before {border: 4px solid  #0388cd;}
	.order-1 .payment-methods .label {display: block;position: relative;padding-left: 25px;cursor: pointer;}
	.order-1 .payment-methods .label:before {content: "";display: block;position: absolute;width: 14px;height: 14px;left: 0;top: 50%;margin-top: -7px;border: 1px solid #666;border-radius: 50%;}
	.order-1 .payment-methods .inner {border: 1px solid #ccc;border-radius: 4px;}
	.order-1 .payment-methods .thumb {float: left;width: 80px;padding: 4px;height: 76px;border-right: 1px solid #ccc;}
	.order-1 .payment-methods .description {float: left;width: -moz-calc(100% - 80px);width: -webkit-calc(100% - 80px);width: -o-calc(100% - 80px);width: -ms-calc(100% - 80px);width: calc(100% - 80px);font-size: 13px;color: #333;padding: 8px 16px 8px 16px;}
	.order-1 .payment-methods .description .subtitle {color: #999;}
	.order-1 .continue .btn {display: inline-block; position: relative; padding: 8px 50px 8px 40px; background: #d60c0c; color: #fff; border: none; font-size: 13px;line-height: 20px; cursor: pointer; border-radius: 4px; } 
	.order-1 .continue .btn:after {content: ""; display: block; position: absolute; width: 12px;height: 8px; background: url(templates/backend/images/spritesheet.png) -264px -81px no-repeat; top: 14px;right: 15px; } 
	.delete.delete_item {cursor: pointer;display: block;margin-top: 5px;font-size: 13px;font-weight: normal;text-align: left;color: #6f0600;}
	.delete.delete_item i{color: #959595;font-size: 10px;}
	.colinfo .price_tt .quantity {
	    color: red;
	    display: block;
	    margin: 5px 0;
	    text-align: right;
	}
	.colinfo .price_tt .quantity input {
	    width: 30px;
	    text-align: center;
	    margin-left: 10px;
	    height: 24px;
	    border: 1px solid #d1d1d1;
	    border-radius: 3px;
	    font-size: 13px;
	    font-family: TPBaoMoi;
	}
	.mb10 {
	    margin-bottom: 10px !important;
	}
	.mt20{margin-top: 20px;}
	.mb20{margin-bottom: 20px;}
	.tt-price {
	    font-size: 13px;
	    text-align: right;
	}
	.uk-flex-space-between {
	    -ms-flex-pack: justify;
	    -webkit-justify-content: space-between;
	    justify-content: space-between;
	}
	.uk-flex {
	    display: -ms-flexbox;
	    display: -webkit-flex;
	    display: flex;
	}
	.order-1 .total .title {line-height: 20px;}
	#giftcode_value .price_tt {
	    color: red;
	    font-size: 12px;
	}
	#shipcode_value .price_tt {
	    color: green;
	    font-size: 12px;
	}
	.item_item + .item_item {
	    margin-left: 10px;
	}
	.item_item{
	    font-size: 12px;
	}
	.xu-infomation .ml25 {
	    color: #999;
	}
	@media (max-width: 650px) {
		.order-1 .payment .step .item {width: 100% !important;}
		.order-1 .customer .panel-body, .order-1 .payment-methods .panel-body {padding: 10px;}
		.order-1 .payment-methods .description {width: 100%;}
		.order-1 .payment-methods .thumb {float: left;width: 100%;padding: 4px;height: 76px;border-right: 0;text-align: center;}
		.order-1 .giftcode .btn{right: 0;}
		.continue.uk-text-right {margin-bottom: 20px;}
		.order-1 .customer .col.left, .order-1 .customer .col.right {float: left;width: 100% !important;margin: 5px 0;}
	}
</style>
<?php $customer = $this->config->item('fcCustomer'); ?>
<section class="order-1 conbtent-main">
	<div class="main-top mb25">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 push-lg-3 push-md-4">
                    <div class="right-top-right">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <?php $product_sales = navigations_array('main', $this->fc_lang); ?>
                                <?php if(isset($product_sales) && is_array($product_sales) && count($product_sales)){ ?>
                                    <div class="main-navibar-content">
                                        <ul class="main-navibar-link mt-flex mt-flex-middle">
                                            <?php foreach ($product_sales as $key => $val): ?>
                                                <li><a href="<?php echo $val['href'] ?>"><?php echo $val['title'] ?><span><?php echo ((!empty($val['description'])) ? '(-'.$val['description'].'%)' : '') ?></span></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="phone-hotline mt-flex-middle">
                                    <div class="icon-hotline"><i class="fas fa-phone-volume"></i></div>
                                    <div class="text-number">
                                        <p>Tổng đài miển phí</p>
                                        <p><span><?php echo $this->fcSystem['contact_phone'] ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 pull-lg-9 pull-md-4 hover-catalog mb15">
                    <?php 
                        $left_nav = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                            'select' => 'id, title, slug, canonical, icon, lft, rgt',
                            'where' => array('trash' => 0,'publish' => 1, 'highlight' => 1, 'alanguage' => ''.$this->fc_lang.''),
                            'limit' => 6,
                            'order_by' => 'order asc, id desc'
                        )); 
                        if(isset($left_nav) && is_array($left_nav) && count($left_nav)){
                            foreach($left_nav as $key => $val){
                                $left_nav[$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
                                    'select' => 'id, title, slug, canonical, images, lft, rgt',
                                    'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''),
                                    'limit' => 5,
                                    'order_by' => 'order asc, id desc',
                                ));
                            }
                        }
                    ?>
                    <?php if(isset($left_nav) && is_array($left_nav) && count($left_nav)){ ?>
                        <div class="list-left-content">
                            <h3><i class="fas fa-bars"></i> <span>Danh mục sản phẩm</span></h3>
                        </div>
                        <div class="list-icon-left list-icon-left-2">
                            <ul>
                                <?php foreach ($left_nav as $key => $val): ?>
                                    <?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues');  ?>
                                    <li>
                                        <a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>" style="<?php echo ((!empty($val['icon'])) ? 'background-image: url(\''.$val['icon'].'\')' : '') ?>">
                                            <div class="icon-text-left">
                                                <span><?php echo $val['title'] ?></span>
                                            </div>
                                            <div class="icon-right"><i class="fas fa-angle-right"></i></div>
                                        </a>
                                        <?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
                                            <ul class="list-sub-catalog">
                                                <?php foreach ($val['child'] as $key => $valc): ?>
                                                    <?php $href = rewrite_url($valc['canonical'], $valc['slug'], $valc['id'], 'products_catalogues');  ?>
                                                    <li>
                                                        <a href="<?php echo $href ?>" title="<?php echo $valc['title'] ?>"><?php echo $valc['title'] ?></a>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>
                                        <?php endif ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="."><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">
                                <a href="<?php echo site_url('dat-mua') ?>" title="Giỏ hàng">Giỏ hàng</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END MAIN TOP -->
	<div class="container">
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="box_cart mb20">
					<div class="payment mb20">
						<ul class="uk-list uk-clearfix step li-b ul-b">
							<li class="item step-1 complete">
								<a class="link" href="<?php echo base_url(); ?>" title="Mua hàng"><span class="number">1</span> <?php echo $this->lang->line('order_payment') ?></a>
							</li>
							<li class="item step-2 active">
								<a class="link" href="<?php echo site_url('dat-mua'); ?>" title=""><span class="number">2</span> <?php echo $this->lang->line('order_payment_information') ?></a>
							</li>
							<li class="item step-3">
								<a class="link" onclick="return false;" title=""><span class="number">3</span> <?php echo $this->lang->line('order_payment_succesfully') ?></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div><!-- .payment -->
					<form action="" method="post" class="uk-form">
						<div class="row information">
							<div class="col-md-7 col-sm-12 col-xs-12">
								<div class="uk-panel customer mb20">
									<header class="panel-head">
										<h3 class="title"><span class="text"><?php echo $this->lang->line('payment_information') ?></span></h3>
									</header>
									<div class="panel-body">
										<?php $error = validation_errors(); if(isset($error) && !empty($error)){ ?>
										<div class="module-alert">
											<div class="uk-alert uk-alert-danger" data-uk-alert="">
												<a href="" class="uk-alert-close uk-close"></a>
												<div><?php echo $error; ?></div>
											</div>
										</div>
										<?php } ?>
										<div class="uk-clearfix mb15 d-none">
											<div class="col left"><label for="" class="label">&nbsp;</label></div>
											<div class="col right">
												<div class="sex uk-flex uk-flex-middle">
													<div class="item">
														<label class="label"><?php echo form_radio('sex', 0, set_radio('sex', 0, TRUE)); ?> <b><?php echo $this->lang->line('brother') ?></b></label>
													</div>
													<div class="item">
														<label class="label"><?php echo form_radio('sex', 1, set_radio('sex', 1, FALSE)); ?> <b><?php echo $this->lang->line('older_sister') ?></b></label>
													</div>
												</div>
											</div>
										</div>
										<div class="uk-clearfix mb15">
											<div class="col left">
												<label for="" class="label"><?php echo $this->lang->line('fullname_customers') ?> <font color="red">*</font></label>
											</div>
											<div class="col right">
												<input type="text" name="fullname" class="text form-control" placeholder="Ví dụ: Nguyễn Văn A" value="<?php echo set_value('fullname', ((!empty($customer['fullname'])) ? $customer['fullname'] : '') ) ?>" <?php echo set_value('fullname', ((!empty($customer['fullname'])) ? 'readonly=""' : '') ) ?>/>
											</div>
										</div>
										<div class="uk-clearfix mb15">
											<div class="col left">
												<label for="" class="label"><?php echo $this->lang->line('phone_customers') ?> <font color="red">*</font></label>
											</div>
											<div class="col right">
												<input type="text" name="phone" class="text form-control" placeholder="Ví dụ: 0987654321" value="<?php echo set_value('phone', ((!empty($customer['phone'])) ? $customer['phone'] : '') ) ?>" <?php echo set_value('phone', ((!empty($customer['phone'])) ? 'readonly=""' : '') ) ?>/>
											</div>
										</div>
										<div class="uk-clearfix mb15">
											<div class="col left">
												<label for="" class="label">Email</label>
											</div>
											<div class="col right">
												<input type="text" name="email" class="text form-control" placeholder="supportxyz@gmail.com" value="<?php echo set_value('email', ((!empty($customer['email'])) ? $customer['email'] : '') ) ?>" <?php echo set_value('email', ((!empty($customer['email'])) ? 'readonly=""' : '') ) ?>/>
											</div>
										</div>
										<?php  
											$shipcode = array(
												'shop' => 'Mua tại cửa hàng',
												'inner' => 'Giao hàng khu vục nội thành Hà Nội',
												'outner' => 'Giao hàng các tỉnh',
											);
										?>
										<div class="provincial uk-clearfix mb15">
											<div class="col left"><label for="" class="label">Vận chuyển</label></div>
											<div class="col right">
												<div class="relative edit-select">
													<?php echo form_dropdown('shipcode', $shipcode, set_value('shipcode'), 'class="form-control" id="shipcode" style="width: 100%;"');?>
												</div>
											</div>
										</div>
										<?php $response = sendRequestNhanhVN('/api/shipping/location'); ?>
										<div class="provincial uk-clearfix mb15">
											<div class="col left">
												<label for="" class="label"><?php echo $this->lang->line('city') ?><font color="red">*</font></label>
											</div>
											<div class="col right">
												<div class="relative edit-select">
													<select name="city" class="form-control location" id="cityid">
														<option value="0">-- Chọn thành phố --</option>
														<?php  
															if ($response->code) {
										                       	foreach($response->data as $location) {
										                          	echo  '<option value="'.$location->id.'">'.$location->name.'</option>';
										                        }
										                    }
														?>
													</select>
													<input type="hidden" name="cityid" value="">
												</div>
											</div>
										</div>
										<div class="provincial uk-clearfix mb15">
											<div class="col left"><label for="" class="label"><?php echo $this->lang->line('districts') ?><font color="red">*</font></label></div>
											<div class="col right">
												<div class="relative edit-select">
													<?php echo form_dropdown('district', array('--Chọn Quận/Huyện--'), set_value('district'), 'class="form-control location"  style="width: 100%;" id="districtid"');?>
													<input type="hidden" name="districtid" value="">
												</div>
											</div>
										</div>
										
										<div class="uk-clearfix">
											<div class="col left"><label for="" class="label"><?php echo $this->lang->line('address_detail') ?></label></div>
											<div class="col right"><input type="text" name="address" class="text form-control" placeholder="Ví dụ: Số 10, Ngõ 50, Đường ABC" /></div>
										</div>
										<div class="d-none uk-clearfix">
											<div class="col left"><label for="" class="label"><?php echo $this->lang->line('order_payment_note') ?></div>
											<div class="col right"><textarea name="message" class="text form-control" placeholder="<?php echo $this->lang->line('note_message') ?>"></textarea></div>
										</div>
										<input type="hidden" name="userid" value="<?php echo ((!empty($customer['id'])) ? $customer['id'] : '') ?>">
										<div class="clearfix"></div>
										
									</div>
								</div><!-- .uk-panel -->
								<!-- .consignee -->
								<div class="uk-panel customer giftcode mb20">
									<div class="panel-head"><h3 class="title"><span class="text">Sử dụng mã giảm giá</span></h3></div>
									<div class="panel-body">
										<div class="error uk-alert"></div>
										<div class="relative mb15">
											<input type="text" name="discount_code" value="" class="text form-control" placeholder="Nhập mã giảm giá" />
											<input type="submit" class="btn" value="Áp dụng" id="apply_gift_code" />
										</div>
										<div class="note">Sau khi áp dụng, Mã giảm giá có thể không dùng được ngay hoặc trong vòng <span class="text-black">15 phút</span>.</div>
									</div>
								</div><!-- .giftcode -->
								<div class="continue text-right mb20 mt20">
									<button type="submit" name="create" value="create" class="uk-button btn"><?php echo $this->lang->line('continue') ?></button>
								</div>
							</div><!-- .uk-width -->

							<div class="col-md-5 col-sm-12 col-xs-12">
								<div class="uk-panel mb20">
									<header class="panel-head uk-flex uk-flex-middle uk-flex-space-between">
										<h3 class="title">
											<span class="text"><?php echo $this->lang->line('order') ?>
												<span class="number">(<?php echo number_format($this->cart->total_items());?> 	<?php echo $this->lang->line('products') ?>)</span>
											</span>
										</h3>
									</header>
									<div class="panel-body" style="padding: 0">
										<?php $discounted = $total_weight = $total_ship = 0; $id_list = ''; ?>
										<?php if(isset($cart) && is_array($cart) && count($cart)){ ?>
											<ul class="uk-list listorder">
												<?php $i = 1; foreach($cart as $key => $val){ ?>
													<?php $val['detail']['href'] = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products'); ?>
													<?php $price = ($val['detail']['saleoff'])?$val['detail']['saleoff']:$val['detail']['saleoff']; ?>
													<?php $total_ship += check_shipping_products($val['detail']['id'], 'shop'); ?>
													<?php $total_weight = (float)($total_weight + $val['detail']['weight']*$val['qty']); ?>
													<?php $id_list .= (($key == 0) ? '' : '-').$val['detail']['id'] ?>
													<li class="item uk-clearfix">
														<input name="quantity" value="<?php echo $val['rowid'] ?>" class="quantity ajax-quantity" type="hidden">
														<div class="colimg uk-float-left">
															<a href="javascript: void(0)" class="img img-scaledown" target="_blank">
																<img src="<?php echo getthumb($val['detail']['images']);?>" alt="<?php echo $val['detail']['title']; ?>" />
															</a>
														</div>
														<div class="colinfo uk-float-right">
															<div class=" uk-flex uk-flex-space-between">
																<div class="title ec-line-3">
																	<a href="javascript: void(0)" class="link" target="_blank"><?php echo $val['detail']['title']; ?></a>
																	<?php if (isset($val['options']) && is_array($val['options']) && count($val['options'])): ?>
																		<div class="uk-flex uk-flex-middle uk-grid-small">
																			<?php foreach ($val['options'] as $keyc => $vals): ?>
																				<div class="item_item"><?php echo $keyc.':'.$vals ?></div>
																			<?php endforeach ?>
																		</div>
																	<?php endif ?>
																	<span class="delete delete_item"><i class="fa fa-trash"></i> Bỏ sản phẩm</span>
																</div>
																<div class="price_tt">
																	<div class="tt-price"><?php echo str_replace(',', '.', number_format($price))?><?php echo $this->lang->line('products_currency') ?></div>
																	<div class="quantity">x<input class="fc-cart-update" data-id="<?php echo $val['rowid'] ?>" type="text" value="<?php echo number_format($val['qty']);?>" name="<?php echo $i ?>[qty]" /></div>
																	<div class="tt-price"><strong><?php echo str_replace(',', '.', number_format($price * $val['qty'])) ?><?php echo $this->lang->line('products_currency') ?></strong></div>
																</div>
															</div>
														</div>
													</li>
												<?php } ?>
											</ul>
											<input type="hidden" id="id_list" value="<?php echo $id_list ?>">
											<div class="clearfix"></div>
										<?php } ?>
										<div class="total">
											<div class=" uk-flex uk-flex-middle uk-flex-space-between mb10" id="total_value" data-price="<?php echo $this->cart->total() ?>">
												<div class="title"><?php echo $this->lang->line('total_money') ?></div>
												<div class="price_tt"><strong><?php echo str_replace(',', '.', number_format($this->cart->total())) ?><?php echo $this->lang->line('products_currency') ?></strong></div>
											</div>
											<?php if (!empty($total_weight)): ?>
												<div class="uk-flex uk-flex-middle uk-flex-space-between mb10">
													<div class="title">Tổng trọng lượng</div>
													<div class="price_tt"><font color="gray"><?php echo $total_weight ?> kg</font></div>
												</div>
											<?php endif ?>
											<div class="mb10 uk-flex uk-flex-middle uk-flex-space-between" id="shipcode_value" data-price="<?php echo $total_ship ?>">
												<input type="hidden" name="shipcode_value" value="0">
												<div class="title"><?php echo $this->lang->line('transport') ?></div>
												<div class="price_tt"><strong class="ec-uppercase"><?php echo str_replace(',', '.', number_format($total_ship)) ?><?php echo $this->lang->line('products_currency') ?></strong></div>
											</div>
											<div class="mb10 d-none uk-flex uk-flex-middle uk-flex-space-between" id="giftcode_value" data-price="0">
												<input type="hidden" name="giftcode_value" value="0">
												<div class="title">Giảm giá</div>
												<div class="price_tt"></div>
											</div>
											<div class="tt-price uk-flex uk-flex-middle uk-flex-space-between" id="total_total">
												<input type="hidden" name="total_cart_money" value="<?php echo $this->cart->total() ?>">
												<div class="title"><?php echo $this->lang->line('payment_money_after') ?></div>
												<div class="price_tt"><strong style="font-size: 17px;"><?php echo str_replace(',', '.', number_format($this->cart->total())) ?><?php echo $this->lang->line('products_currency') ?></strong></div>
											</div>
										</div>
									</div>
								</div><!-- .uk-panel -->
								<?php $total_coint = total_coin_customers($customer['id']); ?>
								<input class="stardust-input-value d-none" type="input" value="0" name="stardust_coint">
								<?php if (!empty($customer['id']) && !empty($total_coint)): ?>
									<div class="uk-panel customer giftcode mb20 d-none">
										<div class="panel-head"><h3 class="title"><span class="text">Sử dụng Vando xu</span></h3></div>
										<div class="panel-body">
											<input class="stardust-checkbox d-none" type="checkbox" <?php echo ((isset($stardust) && !empty($stardust)) ? 'checked' : '') ?> value="1" id="stardust" name="stardust">
											<label class="mt-flex mt-flex-middle mt-flex-space-between mb10 label-checkbox relative" for="stardust">
			                                    <div class="mt-flex mt-flex-middle xu-infomation">
			                                        <img src="templates/frontend/resources/images/img-xu.png" alt="img-xu">
			                                        <span>Vando Xu</span>
			                                        <span class="ml25">Dùng <?php echo $total_coint; ?> xu</span>
			                                    </div>
			                                    <div class="cart-page-footer">-0₫</div>
			                                </label>
											<div class="note">Số lượng xu tối đa bạn có thể sử dụng cho đơn hàng này.</div>
										</div>
									</div><!-- .giftcode -->

								<?php endif ?>
							</div><!-- .uk-width -->
						</div><!-- .uk-grid -->
					</form>
				</div>
			</div>
        </div>
	</div>
</section><!-- .order-1 -->
<!-- </html> -->
<script type="text/javascript">
	$(document).ready(function(){
		load_total_price_cart();
		load_location();
		$('.error').hide();
		$('#cityid').change(function(){
			var city_id = $('#cityid').val();
			$.post('<?php echo site_url('products/ajax/cart/ajax_location')?>', {
				cityid: city_id, 
			},function(data){
				var json = JSON.parse(data);
				$('#districtid').html(json.option);
				load_location();
			});
			return false;
		});
		function load_location(){
			$('.location option:selected').each(function(){
				var name_location = $(this).text();
				var value_location = $(this).val();
				if (value_location != 0) {
					$(this).parent().next().attr('value', name_location);
				}
			})
		}
		$('.location').change(function(){load_location()});
		$('#shipcode').change(function(){
			var shipcode = $(this).val();
			var id_list = $('#id_list').val();
			$.post('<?php echo site_url('products/ajax/cart/ajax_shipcode')?>', {
				shipcode: shipcode, id_list: id_list 
			},function(data){
				var json = JSON.parse(data);
				$('#shipcode_value').attr('data-price', json.price);
				$('#shipcode_value').find('input').attr('value', json.price);
				$('#shipcode_value .ec-uppercase').html(number_format(json.price, 0, '.', '.')+' ₫');
				load_total_price_cart();
			});
			return false;
		});
		$('#apply_gift_code').click(function(){
			var giftcode = $('input[name="discount_code"]').val();
			$.post('<?php echo site_url('products/ajax/cart/apply_gift_code')?>', {
				giftcode: giftcode
			},function(data){
				var json = JSON.parse(data);
				$('.error').show();
                if(json.error.length){
                	$('#giftcode_value').addClass('d-none').attr('data-type', json.typeoff).attr('data-value', json.result).attr('data-price', json.price);
                    $('.error').removeClass('uk-alert-success').addClass('uk-alert-danger');
                    $('.error').html('').html(json.error);
                }else{
                	$('#giftcode_value').removeClass('d-none').attr('data-type', json.typeoff).attr('data-value', json.result).attr('data-price', json.price);
                	$('#giftcode_value .price_tt').html('-' + number_format(json.price, 0, '.', '.')+ ' ₫');
                	$('#giftcode_value').find('input').attr('value', json.price);
                    $('.error').removeClass('uk-alert-danger').addClass('uk-alert-success');
                    $('.error').html('').html(json.message);
                }
                load_total_price_cart();
			});
			return false;
		});

		function load_total_price_cart(){
			var shipcode = parseInt($('#shipcode_value').attr('data-price'));
			var giftcode = parseInt($('#giftcode_value').attr('data-price'));
			var total = parseInt($('#total_value').attr('data-price'));
			$('#total_total .price_tt strong').html('').html(number_format((shipcode + total - giftcode), 0, '.', '.')+' ₫');
			$('#total_total').attr('data-price', (shipcode + total - giftcode));
			$('#total_total').find('input').attr('value', (shipcode + total - giftcode));
			load_coint_cart();
		}

		$('.stardust-checkbox').click(function(){
			load_coint_cart()
			load_total_price_cart_coint();
		})
		function load_coint_cart(){
			var checkbox = $('.stardust-checkbox:checked').val();
			var coint = '<?php echo $total_coint ?>';
			var total_cart = parseInt($('#total_total').attr('data-price'));
			if (checkbox == 1) {
				if (coint >= total_cart) {
					var coint_pay = total_cart;
				}else{
					var coint_pay = coint;
				}
				$('.stardust-input-value').attr('value', coint_pay);
				$('.cart-page-footer').html('').html('-' + number_format(coint_pay, 0, '.', '.')+'₫');
			}else{
				$('.stardust-input-value').attr('value', 0);
				$('.cart-page-footer').html('').html('-0₫');
			}
			load_total_price_cart_coint();
		}
		function load_total_price_cart_coint(){
			var total_cart = $('#total_total').attr('data-price');
			var coint = $('.stardust-input-value').val();
			$('#total_total .price_tt strong').html('').html(number_format((total_cart - coint), 0, '.', '.')+' ₫');
		}

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
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.fc-cart-update').change(function(){
			var qty = $(this).val();
			var rowid = $(this).attr('data-id');
			$.post('<?php echo site_url('products/ajax/cart/updateitemcart')?>', {
				qty: qty, 
				rowid: rowid, 
			},function(data){
				window.location.href = 'dat-mua.html';
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
			window.location.href = 'dat-mua.html';
		});
	}
</script>