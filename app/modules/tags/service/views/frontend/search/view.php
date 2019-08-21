<div id="body" class="body-container mt20">	
	<div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li><a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>"><i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a></li>
				<li><a href="" title="<?php echo $this->lang->line('search') ?>"><?php echo $this->lang->line('search') ?> </a></li>
				<?php echo ((isset($keys)) ? '<li class="uk-active"><a>'.$keys.'</a></li>' : '') ?>
			</ul>
		</div>
	</div>
	<div class="uk-container uk-container-center">
		<div class="uk-grid uk-grid-medium mt20">
			<div class="uk-width-large-2-3">
				<section class="article-catalogue">	
					<?php if(isset($result) && is_array($result) && count($result)){ ?>
					<section class="panel-body panel-article">
						<ul class="uk-grid uk-list-item-news lib-grid-15  uk-grid-width-1-2 uk-grid-width-small-1-2 uk-grid-width-medium-1-2 uk-grid-width-large-1-3" data-uk-grid-match="{target: '.box_item_art .title-item-new'}">
							<?php foreach($result as $key => $val) { ?> 
							<?php 
								$title = $val['title'];
								$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
								$image = getthumb($val['images']);
								$description = cutnchar(strip_tags($val['description']), 250);
								$created = show_time($val['created'], 'd/m/Y');
								$view = $val['viewed'];
							?>
							<li class="mb20">
                                <div class="box_item_art">
                                    <div class="thunm">
                                        <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                            <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
                                        </a>
                                    </div>
                                    <div class="bong-after mb10"></div>
                                    <div class="infor">
                                        <div class="title-item-new mb5">
                                            <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                                <?php echo $val['title'] ?>
                                            </a>
                                        </div>
                                        <div class="des_thongbao">
                                            <?php echo cutnchar(strip_tags($val['description']), 150) ?></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
							<?php } ?>
						</ul>
					</section> <!-- .panel-body -->
					<?php }else{ echo '<div class="mt10">Dữ liệu đang được cập nhật...</div>';} ?>
					<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
				</section>
			</div>
			<div class="uk-width-large-1-3">
                <aside class="aside">
                    <?php $this->load->view('homepage/frontend/common/aside'); ?>
                </aside>
            </div>
		</div>
	</section>
</div>