<?php $main_nav = navigations_array('main', $this->fc_lang); ?>
<div id="offcanvas" class="uk-offcanvas offcanvas">
	<div class="uk-offcanvas-bar">
		<form class="uk-search" action="tim-kiem.html" data-uk-search="{}">
		    <input class="uk-search-field" type="search" name="key" placeholder="<?php echo $this->lang->line('input_key_search') ?>">
        </form>
        <?php if(isset($main_nav) && is_array($main_nav) && count($main_nav)) {?> 
		<ul class="l1 uk-nav uk-nav-offcanvas uk-nav uk-nav-parent-icon" data-uk-nav>
			<?php foreach ($main_nav as $key => $val) { ?>
			<li class="l1 <?php echo (isset($val['child']) && is_array($val['child']) && count($val['child']))?'uk-parent uk-position-relative':''; ?>">
				<?php echo (isset($val['child']) && is_array($val['child']) && count($val['child']))?'<a href="#" title="" class="dropicon"></a>':''; ?>
				<a href="<?php echo $val['href']; ?>" title="<?php echo $val['title']; ?>" class="l1"><?php echo $val['title']; ?></a>
				<?php if(isset($val['child']) && is_array($val['child']) && count($val['child'])) { ?>
				<ul class="l2 uk-nav-sub">
					<?php foreach ($val['child'] as $keyItem => $valItem) { ?>
					<li class="l2"><a href="<?php echo $valItem['href']; ?>" title="<?php echo $valItem['title']; ?>" class="l2"><?php echo $valItem['title']; ?></a>
						<?php if(isset($valItem['child']) && is_array($valItem['child']) && count($valItem['child'])){ ?>
							<ul class="l3 uk-nav-sub">
							<?php foreach($valItem['child'] as $key => $vals){ 
								?><li class="l3"><a href="<?php echo $vals['href']; ?>" title="<?php echo $vals['title']; ?>"><?php echo $vals['title']; ?></a>
								<?php if(isset($vals['child']) && is_array($vals['child']) && count($vals['child'])){
									show_item_menu_canvas($vals['child']); 
									} ?>
								</li><?php
								}
							?>
							</ul>
						<?php } ?>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
			</li>
			<?php } ?>
		</ul>
		<?php } ?>
	</div>
</div><!-- #offcanvas -->
<?php  
	function show_item_menu_canvas($value = '')
	{
		if(isset($item) && is_array($item) && count($item)){ ?>
			<ul class="l3 uk-nav-sub">
			<?php foreach($item as $key => $valss){ ?>
				<li class="l3"><a href="<?php echo $valss['href']; ?>" title="<?php echo $valss['title']; ?>"><?php echo $valss['title']; ?></a>
				<?php  
					if(isset($valss['child']) && is_array($valss['child']) && count($valss['child'])){
						show_item_menu($valss['child']); 
					} 
				?>
				</li>
			<?php } ?>
			</ul>
		<?php }
	}
?>