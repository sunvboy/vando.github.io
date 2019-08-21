<div id="products-page" class="page-body">

    <div class="u-bread">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="unica-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="."><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">
                                Từ khóa: <?php echo $DetailTags['title'] ?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <section class="sec-cac-khoa-hoc bg_white">
        <div class="container">
            <div class="wp-list-cac-khoahoc mt20">
                <?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)){ ?>
                    <div class="list-khoahoc-item">
                        <div class="row row-edit-7">
                            <?php foreach ($ArticlesList as $keyp => $val) { ?>
                                <?php 
                                    $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products'); 
                                    $price = $val['price'];
                                    $saleoff = $val['saleoff'];
                                    if ($price > 0) {
                                        $pri_old = str_replace(',', '.', number_format($price)).'<sup>đ</sup>';
                                    }else{
                                        $pri_old  = 'Liên hệ';
                                    }
                                    if ($saleoff > 0) {
                                        $pri_sale = str_replace(',', '.', number_format($saleoff)).'<sup>đ</sup>';
                                    }else{
                                        $pri_sale  = '';
                                    }
                                    $sale_value = ceil((($price - $saleoff)/$price)*100);
                                    $info_teacher = $this->FrontendTeachers_Model->ReadByField('id', $val['teachersid']);
                                ?>
                                <div class="col-md-3 col-lg-3 col-sm-6 col-edit-7 item_course">
                                    <div class="col">
                                        <div class="images img-cover">
                                            <a title="<?php echo $val['title'] ?>" href="<?php echo $href ?>" class="h_05">
                                                <img class="image" alt="<?php echo $val['title'] ?>" src="<?php echo $val['images'] ?>">
                                            </a>
                                            <div class="middle">
                                                <a title="<?php echo $val['title'] ?>" href="<?php echo $href ?>"></a>
                                                <center>
                                                    <a title="<?php echo $val['title'] ?>" href="<?php echo $href ?>"></a>
                                                    <a href="<?php echo $href ?>" class="btn btn-primary">Xem chi tiết</a>
                                                </center>
                                            </div>
                                        </div>
                                        <div class="title">
                                            <a title="<?php echo $val['title'] ?>" href="<?php echo $href ?>"><b><?php echo $val['title'] ?></b></a>
                                        </div>
                                        <?php if (isset($info_teacher) && is_array($info_teacher) && count($info_teacher)): ?>
                                            <?php $href_t = rewrite_url($info_teacher['canonical'], $info_teacher['slug'], $info_teacher['id'], 'teachers') ?>
                                            <div class="star">
                                                <div class="number">Diễn giả: <a href="<?php echo $href_t ?>"><?php echo $info_teacher['title'] ?></a></div>
                                            </div>
                                        <?php endif ?>
                                        <div class="price">
                                            <?php if (!empty($saleoff) && !empty($price) && $saleoff < $price){ ?>
                                                <span class="sell-price"><?php echo $pri_sale ?></span>
                                                <span class="old-price"><?php echo $pri_old ?></span>

                                                <span class="discount person">- <?php echo $sale_value ?>%</span>
                                            <?php }else{ ?>
                                                <span class="sell-price"><?php echo $pri_old ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php echo (isset($PaginationList)) ? $PaginationList : ''; ?>
                <?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>';} ?>
            </div>
        </div>  
    </section>
</div>