<aside class="aside">
    <?php $list = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
        'select' => 'id, title, slug, canonical, parentid, lft, rgt',
        'where' => array('trash' => 0,'publish' => 1, 'alanguage' => ''.$this->fc_lang.''),
        'order_by' => 'order asc, id asc'
    )); ?>
    <?php $list = recursive($list); ?>
    <?php if(isset($list1) && is_array($list1) && count($list1)) { ?>
        <section class="aside-catalogies">
            <header class="panel-head">
                <div class="heading">
                    <span>Danh mục sản phẩm</span>
                </div>
            </header>
            <section class="panel-body">
                <ul class="uk-list uk-list-catagories">
                    <?php foreach ($list as $key => $val) { ?>
                        <?php $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues'); ?>
                        <li class="<?php echo ((isset($val['child']) && is_array($val['child']) && count($val['child'])) ? 'cat_parent' : '') ?>">
                            <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                <?php echo $val['title'] ?>
                            </a>
                            <?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
                                <ul class="uk-list list-catalog-sub">
                                    <?php foreach ($val['child'] as $key => $vals) { ?>
                                        <?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'products_catalogues'); ?>
                                        <li>
                                            <a href="<?php echo $hrefC ?>" title="<?php echo $vals['title'] ?>">
                                                <?php echo $vals['title'] ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php endif ?>
                        </li>
                    <?php } ?>
                </ul>
            </section>
            <script>
                $(document).ready(function() {
                    $('.cat_parent').click(function(){
                        $(this).toggleClass('uk-active');
                        $(this).find('.list-catalog-sub').slideToggle('slow');
                    });
                });
            </script>
        </section>
    <?php } ?>

    <?php 
        $articles_bl = $this->FrontendArticles_Model->_get_where(array(
            'select' => 'id, title, slug, canonical, images, description',
            'table' => 'articles',
            'where' => array('trash' => 0,'publish' => 1, 'alanguage' => ''.$this->fc_lang.''),
            'limit' => 5,
            'order_by' => 'id desc',
        ), TRUE);

        $products_bl = $this->FrontendProducts_Model->_get_where(array(
            'select' => 'id, title, slug, canonical, images, price, saleoff',
            'table' => 'products',
            'where' => array('trash' => 0,'publish' => 1, 'alanguage' => ''.$this->fc_lang.''),
            'limit' => 5,
            'order_by' => 'id desc',
        ), TRUE);
    ?>
    
    <?php if (isset($products_bl1) && is_array($products_bl1) && count($products_bl1)): ?>
        <section class="aside-block aside-panel">
            <div class="block-title"><span>Sản phẩm mới</span></div>
            <section class="panel-body">
                <?php foreach ($products_bl1 as $keyp => $val) { ?>
                    <?php 
                        $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products'); 
                        $image = getthumb($val['images'], TRUE);
                        $price = $val['price'];
                        $saleoff = $val['saleoff'];
                        if ($price > 0) {
                            $pri_old = str_replace(',', '.', number_format($price)).' ₫';
                        }else{
                            $pri_old  = '';
                        }
                        if ($saleoff > 0) {
                            $pri_sale = str_replace(',', '.', number_format($saleoff)).' ₫';
                        }else{
                            $pri_sale  = 'Liên hệ';
                        }
                    ?>
                    <div class="item mb15">
                        <div class="product uk-clearfix">
                            <div class="thumb">  
                                <a href="<?php echo $href ?>" class="img-cover">
                                    <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
                                </a>
                            </div>
                            <div class="infor relative">
                                <h3 class="title">
                                    <a href="<?php echo $href ?>" class="product_title"><?php echo $val['title'] ?></a>
                                </h3>
                                <div class="product_price"> 
                                    <span class="sale"><?php echo $pri_sale ?></span>
                                    <span class="no-sale"><?php echo $pri_old ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </section>
        </section>
    <?php endif ?>


    <?php if (isset($articles_bl) && is_array($articles_bl) && count($articles_bl)): ?>
        <section class="aside-news aside-panel">
            <header class="panel-head">
                <h3 class="heading">
                    <span>Bài viết mới</span>
                </h3>
            </header>
            <section class="body-panel">
                <ul class="uk-list news-list">
                    <?php foreach ($articles_bl as $keyp => $val) { ?>
                        <?php 
                            $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
                            $image = getthumb($val['images'], TRUE);
                            $description = cutnchar(strip_tags($val['description']), 300); 
                        ?>
                        <li>
                            <div class="news mt-clearfix">
                                <div class="thumb">
                                    <a class="mt-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
                                    </a>
                                </div>
                                <div class="infor">
                                    <h4 class="title">
                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                                            <?php echo $val['title'] ?>
                                        </a>
                                    </h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </section>
        </section>
    <?php endif ?>
</aside><!-- aside -->