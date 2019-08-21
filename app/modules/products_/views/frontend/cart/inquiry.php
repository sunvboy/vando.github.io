<div class="main_main">
	<div class="uk-container uk-container-center">
		<div class="banner_site">
			<h2 class="title_module_nam">
				<?php echo $this->lang->line('inquiry') ?>
			</h2>
		</div>
		<div class="uk-grid uk-grid-collapse">
			<div class="col-main-right uk-width-large-3-4">
				<div class="breadcrumb">
					<ul class="uk-breadcrumb">
						<li><a href="<?php echo BASE_URL ?>" title="<?php echo $this->lang->line('home_page') ?>"><i class="fa fa-home"></i> <?php echo $this->lang->line('home_page'); ?></a></li>
						<li class="uk-active"><a title="<?php echo $this->lang->line('inquiry') ?>"><?php echo $this->lang->line('inquiry') ?></a></li>
					</ul>
				</div>
				<div class="main-products">
					<section class="page-content">
						<div class="product_slide_home_title">
							<span><?php echo $this->lang->line('inquiry') ?></span>
						</div>
						<section class="productDetails">
							<section class="panel-body">
								<div class="entry">
									<?php echo $this->fcSystem['common_aboutus'] ?>
								</div>
								<form action="" method="post" class="uk-form form">
								<?php $error = validation_errors(); echo !empty($error)?'<div class="callout callout-danger" style="padding:10px;background:rgb(195, 94, 94);color:#fff;margin-bottom:10px;font-size:12px;">'.$error.'</div>':'';?>
									<div class="box_form_inquiry">
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Name of distributors
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<select name="distributors" id="distributors" class="text-100 uk-width-1-1">
													<option value="0">Chose Distributors</option>
													<?php  
														$distributors = $this->Frontendaddress_Model->ReadByCondition(array('select' => 'id, title, email, phone','where' => array('trash' => 0,'publish' => 1),'limit' => 10,'order_by' => 'id asc'));
														if (isset($distributors) && is_array($distributors) && count($distributors)) {
															foreach ($distributors as $key => $val) {
																?><option value="<?php echo $val['id'] ?>"><?php echo $val['title'] ?></option><?php
															}
														}
													?>
												</select>
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Category name
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<input type="text" name="titlecatelogies" value="<?php echo ((isset($cart[0]['detail']['titlecatelogies'])) ? ''.$cart[0]['detail']['titlecatelogies'].'' : '') ?>" <?php echo ((isset($cart[0]['detail']['titlecatelogies'])) ? 'readonly="readonly"' : '') ?>  class="text-100 uk-width-1-1" />
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Product name
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<input type="text" name="titleprd" value="<?php echo ((isset($cart[0]['detail']['title'])) ? ''.$cart[0]['detail']['title'].'' : '') ?>" <?php echo ((isset($cart[0]['detail']['title'])) ? 'readonly="readonly"' : '') ?> class="text-100 uk-width-1-1" />
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												General name
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<input type="text" name="generalname" value="<?php echo ((isset($cart[0]['detail']['content2'])) ? ''.$cart[0]['detail']['content2'].'' : '') ?>" <?php echo ((isset($cart[0]['detail']['content2'])) ? 'readonly="readonly"' : '') ?> class="text-100 uk-width-1-1" />
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Company name *
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<input type="text" name="companyname" value="" class="text-100 uk-width-1-1" placeholder="Company name *" />
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Name of inquirer *
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<div class="row5">
													<div class="uk-grid uk-grid-collapse">
														<div class="p5 uk-width-1-2">
															<input type="text" name="fullname" value="" class="text-100" placeholder="First name *" />
														</div>
														<div class="p5 uk-width-1-2">
															<input type="text" name="namefamily" value="" class="text-100" placeholder="Family name *" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Mail address *
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<input type="text" name="email" value="" class="text-100 uk-width-1-1" placeholder="Mail address" />
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Name of country *
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<input type="text" name="country" value="" class="text-100 uk-width-1-1" placeholder="Name of country" />
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Telephone No. FAX No. *
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<div class="row5">
													<div class="uk-grid uk-grid-collapse">
														<div class="p5 uk-width-1-2">
															<input type="text" name="phone" value="" class="text-100" placeholder="Telephone No" />
														</div>
														<div class="p5 uk-width-1-2">
															<input type="text" name="fax" value="" class="text-100" placeholder="Fax No." />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="line-inquiry uk-grid uk-grid-collapse">
											<div class="uk-width-3-10 title_inquiry">
												Details of inquiry*
											</div>
											<div class="uk-width-7-10 content_inquiry">
												<textarea name="message" value="" class="text-100 uk-width-7-10" style="height: 175px; width: 100%;" placeholder="Details of inquiry"></textarea>
											</div>
										</div>
									</div><!-- end .uk-grid -->
									<div class="mb15 formBtn" style="margin: 20px 0;">
										<input style="background: #0088cc; color: #fff;" type="submit" name="create" value="<?php echo $this->lang->line('submit_information') ?>" class="btn" />
									</div>
								</form><!-- end .form -->
							</section>
						</section>
					</section>
				</div>
			</div>
			<div class="col-main-left uk-width-large-1-4 pl20 mt40">
				<?php $this->load->view('homepage/frontend/common/aside'); ?>
			</div>
		</div>
	</div>
</div>

	<?php if(isset($products_same1) && is_array($products_same1) && count($products_same1)){ ?>
	<section class="home_products">
		<div class="uk-container uk-container-center">
			<div class="product_slide_home_title">
				<span><?php echo $this->lang->line('products_otther') ?></span>
			</div>
			<section class="panel-body">
				<div class="row">
	          	<ul class="uk-grid lib-grid-0 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-4 listProduct" data-uk-grid-match="{target: '.product-1 .product-title'}">
	          		<?php foreach($products_same as $key => $val) { ?> 
					<?php 
						$title = $val['title'];
						$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
						$image = getthumb($val['images']);
						$description = cutnchar(strip_tags($val['description']), 120);
						$price = $val['price'];
						$saleoff = $val['saleoff'];
						if ($saleoff > 0) {
							$gia = str_replace(',', '.', number_format($saleoff)).' '.$this->lang->line('products_currency');
							if ($price > 0) {
								$giaold = str_replace(',', '.', number_format($price)).' '.$this->lang->line('products_currency');
							}
							else
							{
								$giaold = '';
							}
						}
						else
						{
							$gia = $this->lang->line('contact');
							$giaold = '';
						}
					?>
						<li class="product-item p10 mb45">
                            <div class="product-1 skin-1">
                                <div class="product-thumb img-slide">
                                    <a class="product-image img-scaledown" href="<?php echo $href ?>">
                                        <img src="<?php echo $image ?>" alt="<?php echo $title; ?>">
                                    </a>
                                </div>
                                <div class="prid_item">
                                    <h3 class="product-title">
                                        <a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
                                    </h3>
                                </div>
                                <div class="price_view text-center">
                                    Giá: <span class="product-price"><?php echo $gia ?></span>
                                </div>
                                <div class="name_price_km">
                                    <div class="action">
                                       <a class="view_href" href="<?php echo $href; ?>" title="<?php echo $title; ?>"> Chi tiết </a>
                                    </div>
                                </div>
                            </div>
                        </li>
					<?php } ?>
			    </ul>
			    </div>
			</section><!-- .panel-body -->
		</div>
	</section>
<?php } ?>