<aside class="aside">
	<?php $footer_nav = navigations_array('menu-left', $this->fc_lang); ?>
	<?php if(isset($footer_nav) && is_array($footer_nav) && count($footer_nav)){ ?>
		<section class="aside-box aside-catalog">
			<header class="panel-header">
				<div class="tour-block">ĐIỂM ĐẾN HẤP DẪN</div>
			</header>
			<section class="panel-body">
				<?php foreach($footer_nav as $key => $vals){ ?>
					<div class="catalog_item mb20 mt20">
						<h2 class="title_item">
							<a href="<?php echo $vals['href']; ?>" title="<?php echo $vals['title']; ?>">
								<?php echo $vals['title'] ?>
							</a>
						</h2>
						<?php if(isset($vals['child']) && is_array($vals['child']) && count($vals['child'])){ ?>
							<ul class="left-nav uk-list">
								<?php foreach($vals['child'] as $key => $val){ ?>
									<li>
										<a href="<?php echo $val['href']; ?>" title="<?php echo $val['title']; ?>">
											<?php echo $val['title']; ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				<?php } ?>
			</section>
		</section>
	<?php } ?>
</aside>



