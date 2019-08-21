
<?php
    $tintuc = $this->FrontendArticles_Model->ReadByCondition(array(
        'select' => 'id, title, slug, canonical, images, created',
        'table' => 'products',
        'where' => array('publish' => 1,'trash' => 0, 'alanguage' => $this->fc_lang),
        'where_not_in' => array(0 => 46, 1 => 14),
        'where_not_in_field' => 'cataloguesid',
        'limit' => 8,
        'order_by' => 'id desc',
    ));
?>
<?php if (isset($tintuc) && is_array($tintuc) && count($tintuc)) { ?>
    <section class="aside-panel news-box-01">
        <header class="panel-head">
            <div class="heading">
                <span>Bài viết tham khảo</span>
            </div>
        </header>
        <section class="panel-body">
            <ul class="list-tin-tuc uk-list">
                <?php foreach ($tintuc as $key => $val) { ?> 
                    <?php  
                        $href_a = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
                        // $description = cutnchar(strip_tags($val['description']), 80); 
                        $created = show_time($val['created'], 'd-m-Y');
                    ?>
                    <li class="mb15">
                        <div class="box-list uk-clearfix">
                            <div class="thumb">
                                <a class="image img-scaledown" href="<?php echo $href_a ?>" title="<?php echo $val['title'] ?>">
                                    <img src="<?php echo $val['images'] ?>" alt="<?php echo $val['title']; ?>">
                                </a>
                            </div>
                            <div class="info">
                                <h3>
                                    <a href="<?php echo $href_a ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
                                </h3>
                                <div class="ic_time">Ngày đăng: <?php echo $created ?></div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </section>
    </section>
<?php } ?>
