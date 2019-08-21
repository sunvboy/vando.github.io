<div class="breadcrumb">
	<div class="uk-container uk-container-center">
		<ul class="uk-breadcrumb">
			<li><a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>"><i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?></a></li>
			<li><a href="" title="<?php echo $this->lang->line('home_page') ?>"><?php echo $this->lang->line('home_page') ?> </a></li>
			<li class="uk-active"><?php if (isset($keys)) {
				echo $keys;
			} ?></li>
		</ul>
	</div>
</div>
<section class="main-content">
	<div class="uk-container uk-container-center">
		<div class="p10px bgwhite">	
			<div class="uk-grid uk-grid-medium">
				<div class="uk-width-large-1-4 uk-visible-large">
					<?php $this->load->view('homepage/frontend/common/aside'); ?>
				</div>
				<div class="uk-width-large-3-4">
					<section class="panel-article article-catalogue">	
						<?php if(isset($result) && is_array($result) && count($result)){ ?>
						<section class="panel-body">
							<ul class="uk-list list-article">
								<?php foreach($result as $key => $val) { ?> 
								<?php 
									$title = $val['title'];
									$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
									$image = getthumb($val['images']);
									$description = cutnchar(strip_tags($val['description']), 250);
									$created = show_time($val['created'], 'd/m/Y');
									$view = $val['viewed'];
								
								
								?>
								<li>
									<article class="article-1 uk-clearfix">
										<div class="thumb img-flash">
											<a class="cover ec-cover" href="<?php echo $href; ?>" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $image; ?>"></a>
										</div>
										<div class="info">
											<h2 class="title"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h2>
											<div class="meta uk-flex uk-flex-middle">
												<div class="time"><?php echo $this->lang->line('created') ?>: <?php echo $created; ?></div>
											</div>
											<div class="description lib-line-4">
												<?php echo $description; ?>
											</div>
										</div>
									</article><!-- .article-1 -->
								</li>
								<?php } ?>
							</ul>
						</section> <!-- .panel-body -->
						<?php }else{ echo '<div class="mt10">Dữ liệu đang được cập nhật...</div>';} ?>
					</section>
					<?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
				</div><!-- .uk-width -->
			</div>
		</div>
	</div>
</section>
<div class="clr"></div>