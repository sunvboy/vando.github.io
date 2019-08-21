<section class="conbtent-main">
    <div class="main-top">
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
                            <?php foreach($Breadcrumb as $key => $val){ ?>
                                <?php 
                                    $title = $val['title'];
                                    $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues');
                                ?>
                                <li class="breadcrumb-item active">
                                    <a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo mb_strtolower($title, 'UTF-8'); ?></a>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END MAIN TOP -->
	<section class="art-detail mt25">
		<div class="container">
			<div class="row homepage">
				<div class="col-md-9 col-sm-9 col-xs-12 mb25"><!--  -->
					<section class="article-page">
						<section class="body-panel">
							<article class="article">
								<header class="panel-head">
									<h1 class="title-main"><span><?php echo $DetailArticles['title'] ?></span></h1>
								</header>
								<div class="meta mt-flex-middle mt-flex">
									<span class="meta_date mr10">
										<?php echo $this->lang->line('updated').': '.show_time($DetailArticles['created'], 'd/m/Y'); ?>
									</span>
									<span class="meta_view">
										<?php echo $this->lang->line('viewed').': '.str_replace(',', '.', number_format($DetailArticles['viewed'])) ?>
									</span>
								</div>
								<div class="content mb20 mt-clearfix">
									<?php echo $DetailArticles['content']; ?>
								</div>
							</article>
							<section class="menu_bar_item mb20">
								<div class="mt-flex mt-flex-middle mt-flex-space-between meta">
									<div class="left-meta">
										<a href="javascript: history.back();" class="back-page"><?php echo $this->lang->line('prev-page') ?></a>
										<a class="goTop-page"><?php echo $this->lang->line('go-to-top') ?></a>
									</div>
									<?php links_share(); ?>
								</div>
							</section>
							<script>
								$(document).ready(function() {
	$('#goTop, .goTop-page').click(function(event) {
		event.preventDefault();
		$('html, body').animate({scrollTop: 0},500);
	});
});
							</script>
						</section>
					</section>
					<?php if (is_array($articles_same) && isset($articles_same) && count($articles_same)) { ?>
						<section class="art-same">
							<header class="panel-head">
								<h6 class="heading-1"><span><?php echo $this->lang->line('aticles_otther') ?></span></h6>
							</header>
							<section class="body-panel">
								<ul class="uk-list list-article-otther">
									<?php foreach ($articles_same as $key => $val) { ?> 
										<?php 
											// $title = $val['title'];
											$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
											// $image = getthumb($val['images'], TRUE);
											// $description = cutnchar(strip_tags($val['description']),450);
											// $created = show_time($val['created'], 'd/m/Y');
											// $view = $val['viewed'];
										?>
				                        <li class="">
				                            <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
				                                <?php echo $val['title'] ?>
				                            </a>
				                        </li>
									<?php } ?>
								</ul>
							</section>
						</section><!-- .article-related -->
					<?php } ?>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 mb25"><!--  uk-pull-3-4 -->
	                <?php $this->load->view('homepage/frontend/common/aside') ?>
	            </div>
			</div>
		</div>
	</section>
</section>