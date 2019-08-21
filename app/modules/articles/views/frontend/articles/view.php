<main id="main-site">
    <section class="sec-main-page">
        <div class="wp-content-cttin">
            <div class="container">
                <h1 class="h1-title-ct"><?php echo $DetailArticles['title'] ?></h1>

                <p class="date-time">Ngày đăng: <?php echo $DetailArticles['created'] ?></p>

                <div class="contentimages">
                    <?php echo $DetailArticles['content'] ?>
                    <div style="clear: both;height: 20px"></div>

                    <div class="social-share" style="float: right;text-align: right;">

                        <script type="text/javascript"

                                src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59e812e6b22460be"></script>

                        <div class="addthis_inline_share_toolbox_i92u"></div>

                    </div>

                    <div style="clear: both;height: 20px"></div>

                    <style>

                        .content-job-dt img{

                            max-width: 100% !important;

                            height: auto !important;

                        }

                        .content-job-dt iframe{

                            max-width: 100% !important;

                        }

                        #at4-share, #at4-soc, #at-cv-toaster.at-cv-mask, #at-share-dock {

                            display: none !important;

                        }



                        #fld_8111642_2 {

                            width: auto;

                            float: right;

                            background: #0057af;

                            color: #fff;

                            height: 40px;

                            line-height: 36px;

                            padding: 0 10px 15px;

                        }



                    </style>
                </div>
                <style>
                    .contentimages img{
                        max-width: 100% !important;
                        height: auto !important;
                    }
                    .contentimages iframe{
                        max-width: 100% !important;
                    }
                </style>
                <?php if (is_array($articles_same) && isset($articles_same) && count($articles_same)) { ?>
                <div class="wp-tin-khac">
                    <div class="wp-title-spqt tin-khac">
                        <h2 class="h2-title">Tin tức khác</h2>
                    </div>
                    <div class="wp-list-tinkhac">
                        <div class="row">
                            <?php foreach ($articles_same as $key => $val) { ?>
                            <?php
                             $title = $val['title'];
                            $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
                             $image = getthumb($val['images'], TRUE);
                             $description = cutnchar(strip_tags($val['description']),200);
                             $created = show_time($val['created'], 'd/m/Y');
                             $view = $val['viewed'];
                            ?>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="wp-item-tin-a">
                                    <div class="wp-img-tin-a img-cover">
                                        <a href="<?php echo $href ?>"><img src="<?php echo $val['images'] ?>" alt="<?php echo $val['title'] ?>"></a>
                                    </div>
                                    <div class="wp-text-tin-a">
                                        <h3 class="h3-title"><a href="<?php echo $href ?>"><?php echo $val['title'] ?></a></h3>

                                        <p><?php echo $description?> </p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>