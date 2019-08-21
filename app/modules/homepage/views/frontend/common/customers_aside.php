<aside class="aside height100">
	<?php if (isset($DetailUsers) && is_array($DetailUsers) && count($DetailUsers)) { ?>
		<section class="member_box height100">
			<header class="panel-head">
				<div class="heading-2">Chào bạn: <span><?php echo $DetailUsers['fullname'] ?></span></div>
			</header>
			<section class="panel-body project-create">
				<div class="infomation_members">
					<div class="members_item uk-text-left mb10 bor_bg" style="padding: 0;">
						<ul class="uk-list list-item-bar">
							<li><a href="members/loguot.html" class="item_icon logout">Thoát</a></li>
						</ul>
					</div>
				</div>
			</section>
		</section>

	<?php } ?>
</aside>