<main id="main-site">
    <section class="sec-main-page">
        <div class="wp-titlle-tin-page">
            <div class="container">
                <div class="row text-center">
                    <h1><?php echo $DetailCatalogues['title'] ?></h1>
                    <span><?php echo strip_tags($DetailCatalogues['description']) ?></span>
                </div>
            </div>
        </div>
        <div class="wp-list-tin">
            <div class="container">
                <?php if (isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)) { ?>

                    <div class="row">
                        <?php foreach ($ArticlesList as $keyp => $val) { ?>
                            <?php
                            $title = $val['title'];
                            $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
                            $image = getthumb($val['images'], TRUE);
                            $created = show_time($val['created'], 'd/m/Y');
                            $description = cutnchar(strip_tags($val['description']), 200);
                            $catalogues = Load_catagoies(json_decode($val['catalogues'], TRUE), 'articles');
                            ?>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="wp-item-tin-a">
                                    <div class="wp-img-tin-a img-cover">
                                        <a href="<?php echo $href ?>"><img src="<?php echo $image ?>"
                                                                           alt="<?php echo $title ?>"></a>
                                    </div>
                                    <div class="wp-text-tin-a">
                                        <h3 class="h3-title"><a href="<?php echo $href ?>"><?php echo $title ?></a></h3>

                                        <p><?php echo $description; ?> </p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                    </div>
                    <?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>

                <?php } ?>
            </div>
        </div>
    </section>
</main>