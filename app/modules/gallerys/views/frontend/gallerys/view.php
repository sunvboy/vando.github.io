<div id="album-page" class="page-body bg-gray">
	<div class="banner-page">
        <?php if ($this->fcSystem['banner_banner1'] != ''): ?>
            <img src="<?php echo $this->fcSystem['banner_banner1'] ?>" alt="Banner-page">
        <?php endif ?>
    </div>
	<div class="breadcrumb">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li><a href="" title=""><i class="fa fa-home"></i> Trang chủ</a></li>
				<?php foreach($Breadcrumb as $key => $val){ ?>
					<?php 
						$title = $val['title'];
						$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'gallerys_catalogues');
					?>
					<li class="uk-active">
						<a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<section class="photos-detail mt20">
		<div class="uk-container uk-container-center">
			<?php $albums = json_decode($DetailGallerys['albums'], TRUE); ?>
			<section class="panel-body bg_white padding20px mb20">
				<header class="panel-head uk-text-center">
					<h1 class="title"><span><?php echo $DetailGallerys['title'] ?></span></h1>
				</header>
				<?php if(isset($albums) && is_array($albums) && count($albums)){ ?>
					<script type="text/javascript">
						$(document).ready(function() {
							$('a[rel^=\'prettyPhoto\']').prettyPhoto({theme: 'facebook',slideshow:5000, autoplay_slideshow:true});
						})
					</script>
					<ul class="uk-grid lib-grid-20 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-5 gallerys-list" data-uk-grid>
						<?php foreach($albums as $key => $val){ ?>
							<li class="mb20">
								<div class="thumb">
									<a class="image img-scaledown" rel="prettyPhoto[pp_gal]" href="<?php echo $val['images'] ?>" title="<?php echo $DetailGallerys['title'] ?>">
										<img src="<?php echo $val['images'] ?>" alt="<?php echo $DetailGallerys['title'] ?>" />
									</a>
								</div>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			
				<footer class="panel-foot">
					<div class="uk-container uk-container-center">
						<article class="article">
							<?php echo $DetailGallerys['content'] ?>
						</article>
					</div>
				</footer>
			</section>
		</div><!-- .uk-container -->
	</section>
</div>