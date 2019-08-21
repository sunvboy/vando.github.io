<div id="documents-page" class="page-body">
	<div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo BASE_URL ?>" title="<?php echo $this->lang->line('home_page') ?>">
						<?php echo $this->lang->line('home_page'); ?>
					</a>
				</li>
				<li class="uk-active">
					<a href="documents.html" title="Documents">Documents</a>
				</li>
			</ul>
		</div>
	</div>
	<section class="documents-page mt30">
		<div class="uk-container uk-container-center">
			<header class="heading">
				<h1 class="heading-heading">
					<span><?php echo $DetailAddress['title'] ?></span>
				</h1>
			</header>
			<section class="panel-body">
				<div class="readtl">
                    <a class="media" href="<?php echo $DetailAddress['attachs'] ?>"></a>
                </div>
                <script type="text/javascript" src="http://malsup.github.com/jquery.media.js"></script>
                <script type="text/javascript">
                    $(function() {
                        $('a.media').media({width:630, height:630});
                    });
                </script>
			</section>
		</div>
	</section>
</div>