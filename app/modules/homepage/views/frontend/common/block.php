<?php  
    $videoblock = $this->FrontendVideos_Model->ReadByCondition(array(
        'select' => 'id, title, slug, canonical, images, videos_code',
        'table' => 'videos',
        'where' => array('publish' => 1, 'trash' => 0, 'highlight' => 1, 'alanguage' => $this->fc_lang),
        'limit' => 1,
        'order_by' => 'id desc',
    ));
?>
<?php if (isset($videoblock) && is_array($videoblock) && count($videoblock)): ?>
    <section class="aside-panel panel-videos">
        <section class="panel-body">
            <?php foreach ($videoblock as $key => $val) { ?>
                <?php $video_code = explode('?v=', $val['videos_code']); ?>
                <div class="box-video-block playvideo" data-video="<?php echo $video_code[1] ?>">
                    <a href="javascript: void(0);" class="img-cover relative">
                        <img src="<?php echo $val['images'] ?>" alt="<?php echo $val['title'] ?>">
                        <span class="player"></span>
                    </a>
                </div>
            <?php } ?>
        </section>
    </section>
<?php endif ?>

    <sections class="aside-panel aside-thongke">
        <header class="panel-head">
            <h3 class="heading"><span>Thống kê truy cập</span></h3>
        </header>
        <section class="panel-body">
            <?php  
                $this->db->select('*')->from('counter_values');
                $row = $this->db->get()->row_array();
                $this->db->select('*')->from('counter_ips');
                $online = $this->db->count_all_results();
            ?>
            <ul class="uk-list list-static">
                <li class="online">Đang online: <b><?php echo str_replace(',', '.', number_format($online)) ?></b></li>
                <li class="today">Hôm nay: <b><?php echo str_replace(',', '.', number_format($row['day_value'])) ?></b></li>
                <li class="total">Tổng truy cập: <b><?php echo str_replace(',', '.', number_format($row['all_value'])) ?></b></li>
            </ul>
        </section>
    </sections>
    <section class="aside-support">
        <header class="panel-head">
            <div class="hotline">
                <div class="cover">
                    <img src="templates/frontend/resources/img/bg-support.png" alt="">
                </div>
                <span class="label">Liên hệ tư vấn</span>
                <a class="value" href="tel: <?php echo $this->fcSystem['contact_hotline'] ?>" title="Hotline">
                    <?php echo $this->fcSystem['contact_hotline'] ?>
                </a>
            </div>
        </header>
        <section class="panel-body">
            <?php if (isset($support_bl) && is_array($support_bl) && count($support_bl)): ?>
                <ul class="uk-list support-list">
                    <?php foreach ($support_bl as $key => $val) { ?>
                        <li>
                            <div class="box uk-clearfix">
                                <div class="item-sp">
                                    <div class="name"><span><?php echo $val['fullname'] ?></span></div>
                                    <div class="phone">
                                        <a class="value" href="tel: <?php echo $val['phone'] ?>" title="Gọi ngay">
                                            <?php echo $val['phone'] ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <a class="btn yahoo" href="" title="Yahoo">Yahoo</a>
                                    <a class="btn skype" href="skype:<?php echo $val['skype'] ?>?chat" title="Skype">Skype</a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            <?php endif ?>
        </section>
    </section>


<?php $list = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
    'select' => 'id, title, slug, canonical, parentid, lft, rgt',
    'where' => array('trash' => 0,'publish' => 1, 'alanguage' => ''.$this->fc_lang.''),
    'order_by' => 'order asc, id asc'
)); ?>
<?php $list = recursive($list); ?>
<?php if(isset($list) && is_array($list) && count($list)) { ?>
    <section class="aside-catalogies aside-panel">
        <header class="panel-head">
            <div class="heading">
                <span>Danh mục sản phẩm</span>
            </div>
        </header>
        <section class="panel-body">
            <ul class="uk-list uk-list-catagories <?php echo ((isset($home)) ? '' : 'hide') ?>">
                <?php foreach ($list as $key => $val) { ?>
                    <?php $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products_catalogues'); ?>
                    <li>
                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
                            <?php echo $val['title'] ?>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </section>
    </section>
<?php } ?>


    <div id="divAdRight" class="banner-fixed uk-visible-large">
        <?php echo $this->fcSystem['banner_banner1']; ?>
    </div>
    <div id="divAdLeft" class="banner-fixed uk-visible-large">
        <?php echo $this->fcSystem['banner_banner2']; ?>
    </div>


    <script type="text/javascript">
            function FloatTopDiv() {     
                startLX = ((document.body.clientWidth -MainContentW)/2)-LeftBannerW-LeftAdjust , startLY = TopAdjust+80;     
                startRX = ((document.body.clientWidth -MainContentW)/2)+MainContentW+RightAdjust , startRY = TopAdjust+80;     
                var d = document;     
                function ml(id) {     
                    var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];    
                    el.sP=function(x,y){this.style.left=x-1+ 'px';this.style.top=10+y + 'px';};     
                    el.x = startRX;     
                    el.y = startRY;     
                    return el;     
                }     
                function m2(id) {     
                    var e2=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];     
                    e2.sP=function(x,y){this.style.left=x-10 + 'px';this.style.top=10+y + 'px';};     
                    e2.x = startLX;     
                    e2.y = startLY;     
                    return e2;     
                }     
                window.stayTopLeft = function()  {     
                    if (document.documentElement && document.documentElement.scrollTop)     
                        var pY =  document.documentElement.scrollTop;     
                    else if (document.body)     
                        var pY =  document.body.scrollTop;     
                    if (document.body.scrollTop > 30){startLY = 3;startRY = 3;} else  {startLY = TopAdjust;startRY = TopAdjust;};     
                    ftlObj.y += (pY+startRY-ftlObj.y)/16;     
                    ftlObj.sP(ftlObj.x, ftlObj.y);     
                    ftlObj2.y += (pY+startLY-ftlObj2.y)/16;     
                    ftlObj2.sP(ftlObj2.x, ftlObj2.y);     
                    setTimeout("stayTopLeft()", 1);     
                }     
                ftlObj = ml("divAdRight");     
                //stayTopLeft();     
                ftlObj2 = m2("divAdLeft");     
                stayTopLeft();     
            }     
            function ShowAdDiv() {     
                var objAdDivRight = document.getElementById("divAdRight");     
                var objAdDivLeft = document.getElementById("divAdLeft");       
                if (document.body.clientWidth < 1000) {     
                    objAdDivRight.style.display = "none";     
                    objAdDivLeft.style.display = "none";     
                } else {     
                    objAdDivRight.style.display = "block";     
                    objAdDivLeft.style.display = "block";     
                    FloatTopDiv();     
                }     
            } 
        </script>
        <script type="text/javascript">     
            MainContentW = 1170;
            LeftBannerW = 150;
            RightBannerW = 150;
            LeftAdjust = 0;
            RightAdjust = 10;
            TopAdjust = 0;
            ShowAdDiv();
            window.onresize=ShowAdDiv;
        </script>