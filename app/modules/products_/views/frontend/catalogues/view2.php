<div id="products-page" class="page-body">
    <div class="breadcrumb uk-hidden">
        <div class="uk-container uk-container-center">
            <ul class="uk-breadcrumb">
                <li>
                    <a href="<?php echo BASE_URL ?>" title="<?php echo $this->lang->line('home_page') ?>">
                        <?php echo $this->lang->line('home_page') ?>
                    </a>
                </li>
                <?php foreach($Breadcrumb as $key => $val){ ?>
                    <?php 
                        $title = $val['title'];
                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues');
                    ?>
                    <li class="uk-active">
                        <a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="relative">
        <span class="img-cover"><img src="<?php echo $this->fcSystem['banner_banner1'] ?>" alt="banner header" style="filter: brightness(0.6);"></span>
        <h1 class="heading-posiontion uk-text-center"><span class="title"><?php echo $DetailCatalogues['title'] ?></span></h1>
    </div>
    <div class="uk-container uk-container-center">
    	<section class="design-catalogue mt30">
            <section class="product-catalog">
                <header class="panel-head uk-text-center mb30">
                    <h2 class="heading-2"><span><?php echo $this->lang->line('register-course') ?></span></h2>
                </header>
                <?php if(isset($list_cat) && is_array($list_cat) && count($list_cat)){ ?>
                    <ul class="uk-grid lib-grid-20 uk-grid-width-1-1 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 list-product-catalog" data-uk-grid-match="{target: '.product .title'}">
                        <?php foreach ($list_cat as $keyp => $val) { ?>
                            <?php 
                                $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues'); 
                                $image = getthumb($val['images'], TRUE);
                            ?>
                            <li class="mb25">
                                <div class="product mt5 uk-text-center">
                                    <div class="thumb relative">
                                        <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                            <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
                                        </a>
                                    </div>
                                    <div class="infor uk-text-center">
                                        <h3 class="title mb0">
                                            <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                                <?php echo $val['title'] ?>
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
                <?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>';} ?>
            </section>
            <!-- Tin tức -->
            <?php if (isset($tintuc_home) && is_array($tintuc_home) && count($tintuc_home)): ?>
                <?php foreach ($tintuc_home as $key => $vals) { ?>
                    <?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles_catalogues');  ?>
                    <?php if (isset($vals['post']) && is_array($vals['post']) && count($vals['post'])): ?>
                        <section class="homepage-news">
                            <header class="panel-head uk-text-center mb30">
                                <h2 class="heading-2">
                                    <a class="title" title="<?php echo $vals['title'] ?>" href="<?php echo $hrefC ?>"><?php echo $vals['title'] ?></a>
                                </h2>
                            </header>
                            <section class="panel-body">
                                <ul class="uk-grid lib-grid-30 uk-grid-width-1-1 uk-grid-width-small-1-2 uk-grid-width-medium-1-3">
                                    <?php foreach ($vals['post'] as $key => $val) { ?>
                                        <?php 
                                            $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles'); 
                                            $image = getthumb($val['images'], TRUE);
                                        ?>
                                        <li class="mb30">
                                            <div class="thumb relative">
                                                <a class="img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                                    <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
                                                </a>
                                            </div>
                                            <div class="infor">
                                                <div class="title">
                                                    <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </section>
                            <div class="uk-text-center mb30">
                                <a class="more_catalog" title="<?php echo $vals['title'] ?>" href="<?php echo $hrefC ?>"><?php echo $this->lang->line('see-more') ?></a>
                            </div>
                        </section>
                    <?php endif ?>
                <?php } ?>
            <?php endif ?>
            <!-- END Tin tức -->
	   </section>
    </div>
</div>