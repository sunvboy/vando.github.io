<div class="main_main">
	<div class="uk-container uk-container-center">
		<div class="box_right_content">
			<div class="breadcrumb" style="margin: 0;">
				<ul class="uk-breadcrumb">
					<li><a href="" title=""><i class="fa fa-home"></i> Trang chủ</a></li>
					<li class="uk-active">Advanced Search</li>
				</ul>
			</div>
			<div class="uk-grid uk-grid-collapse uk-flex-middle" style="display: inline;">
				<div class="uk-width-large-7-10">
					<form action="tim-kiem.html" action="get">
						<div class="box_form">
							<div class="uk-grid lib-grid-0 uk-grid-width-small-1-2 uk-grid-width-large-1-1">
								<div class="box_search_c">
									<div class="bg_form">
										<div class="line_input">
						                    <input type="text" required="" name="key" class="uk-width-1-1 input-text" />
						                </div>
					                	<div class="line_inputs">
					                    	<input name="search_in_description" value="1" type="checkbox"> Tìm kiếm trong mô tả sản phẩm
					                    </div>
				                    </div>
				                </div>
								
								<div class="box_submit_form">
									<input type="submit" value="Tìm kiếm">
									<input type="hidden" value="1" name="type">
								</div>
								<?php 
									$catcat = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
										'select' => 'id, title, slug, canonical',
										'where' => array('publish' => 1,'trash'=>0),
										'limit' => 150,
										'order_by' => 'order asc, id desc',
									));
									if(isset($catcat) && is_array($catcat) && count($catcat)){
										foreach($catcat as $key => $val){
											$catcat[$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
												'select' => 'id, title, slug, canonical',
												'where' => array('publish' => 1,'trash'=>0,'parentid' => $val['id']),
												'limit' => 6,
												'order_by' => 'order asc, id desc',
											));
										}
									}
								?>
				                <div class="box_search_c">
									<div class="bg_form">
										<div class="line_input line2">
											<div class="uk-grid lib-grid-0 uk-grid-width-small-1-2 uk-grid-width-large-1-2">
						                    	<div class="col_item">
						                    		<span>Danh mục</span>
						                    	</div>
						                    	<div class="col_item">
						                    		<?php if(isset($catcat) && is_array($catcat) && count($catcat)){ ?>
							                    		<select name="categories" id="" class="form-control">
							                    			<option value="">Chọn danh mục sản phẩm</option>
							                    			<?php foreach($catcat as $key => $valcat){ ?>
									                    		<option value="<?php echo $valcat['id']; ?>"><?php echo $valcat['title']; ?></option>
									                    		<?php if(isset($valcat['child']) && is_array($valcat['child']) && count($valcat['child'])){ ?>
																	<?php foreach($valcat['child'] as $key => $valdd){ ?>
																		<option value="<?php echo $valdd['id']; ?>">|-- <?php echo $valdd['title']; ?></option>
																	<?php } ?>
									                    		<?php } ?>
									                    	<?php } ?>
							                    		</select>
						                    		<?php } ?>
						                    	</div>
						                    </div>
						                </div>
					                	<div class="line_input line2">
											<div class="uk-grid lib-grid-0 uk-grid-width-small-1-2 uk-grid-width-large-1-2">
						                    	<div class="col_item">
						                    		<span>Giá từ</span>
						                    	</div>
						                    	<div class="col_item">
						                    		<input type="text" name="pricefrom">
						                    	</div>
						                    </div>
						                </div>
						                <div class="line_input line2">
											<div class="uk-grid lib-grid-0 uk-grid-width-small-1-2 uk-grid-width-large-1-2">
						                    	<div class="col_item">
						                    		<span>Giá đến</span>
						                    	</div>
						                    	<div class="col_item">
						                    		<input type="text" name="priceto">
						                    	</div>
						                    </div>
						                </div>
				                    </div>
				                </div>

							</div>
						</div>
					</form>
				</div>
				<div class="uk-width-large-3-10">
					<?php $this->load->view('homepage/frontend/common/aside'); ?>
				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
</div>

