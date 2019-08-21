<?php  
    if ($this->fc_lang == 'vietnamese') {
        $cat_tin = 33;
    }
    else{
        $cat_tin = 34;
    }

    $darticles = $this->FrontendArticles_Model->_get_where_param(array(
        'select' => 'id, title, slug, canonical, images, description, created, viewed',
        'table' => 'articles',
        'where' => array('publish' => 1,'trash' => 0, 'alanguage' => $this->fc_lang, 'cataloguesid' => $cat_tin),
        'type' => 'array',
        'order_by' => 'id desc',
        'limit' => 5,
    ));
?>
<section class="aside-panel home-tab">
    <ul class="uk-list uk-clearfix tabControl" data-uk-switcher="{connect:'#tabContent'}">
        <li class="uk-active"><?php echo $this->lang->line('corner-gratitude') ?></li>
        <li><?php echo $this->lang->line('customers-reviews') ?></li>
    </ul>
    <ul id="tabContent" class="uk-switcher tab-content">
        <li>
            <section class="aside-panel aside-partner">
                <section class="panel-body">
                    <div class="uk-slidenav-position slide-show" data-uk-slideshow="{autoplay: true, autoplayInterval: 7500, animation: 'scroll'}">
                        <ul class="uk-slideshow">
                            <?php if(isset($darticles) && is_array($darticles) && count($darticles)){ ?>
                                <?php foreach ($darticles as $key => $val) { 
                                    $href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
                                    ?> 
                                    <li>
                                        <div class="item">
                                            <div class="thumb">
                                                <h5><?php echo $val['title'] ?></h5>
                                                <div class="descript"><?php echo cutnchar(strip_tags($val['description']), 570);  ?></div>
                                                <a href="<?php echo $href ?>" class="more_detail">Đọc tiếp &raquo;</a>
                                            </div>
                                            <div class="title_gallerys">
                                                <h6><?php echo $val['title'] ?></h6>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <a href="" class="uk-slide-ak uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                        <a href="" class="uk-slide-fk uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
                    </div>
                </section><!-- .panel-body -->
            </section><!-- .panel -->
        </li>
        <li>
            <?php $this->load->view('homepage/frontend/common/subscribe'); ?>
        </li>
    </ul>
</section>





<section class="aside-panel home-video">
<?php 
    $video_block = $this->FrontendVideosCatalogues_Model->ReadByCondition(array('select' => 'id, title, slug, canonical, images, lft, rgt','where' => array('trash' => 0,'publish' => 1,'ishome' => 1, 'alanguage' => ''.$this->fc_lang.''),'limit' => 1,'order_by' => 'order asc, id desc'));
    if(isset($video_block) && is_array($video_block) && count($video_block)){
        foreach($video_block as $key => $val){
            $video_block[$key]['post'] = $this->FrontendVideos_Model->_read_condition(array(
                'modules' => 'videos',
                'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`videos_code`, `pr`.`viewed`',
                'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
                'limit' => 4,
                'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
                'cataloguesid' => $val['id'],
            ));
        }
    }
    if (isset($video_block) && is_array($video_block) && count($video_block)) {
        foreach ($video_block as $key => $val_v) {
            if (isset($val_v['post']) && is_array($val_v['post']) && count($val_v['post'])) {
            ?>
                <header class="panel-head mb20">
                    <h2 class="heading"><span><?php echo $val_v['title'] ?></span></h2>
                </header>
                <section class="panel-body">
                    <?php foreach ($val_v['post'] as $key => $val_video) {
                        if ($val_video['videos_code'] !='') {
                            $video_code = explode('?v=', $val_video['videos_code'])[1];
                        }
                        else{
                            $video_code = '';
                        }
                        if ($key == 0) {
                            ?>
                                <div class="featured">
                                    <a class="image img-cover" href="#modal-video" title="<?php echo $val_video['title'] ?>" data-uk-modal="{target:'#modal-video-<?php echo $key + 1 ?>'}"><img src="<?php echo $val_video['images'] ?>" alt="<?php echo $val_video['title'] ?>" /></a>
                                    <h3 class="entry-title">
                                        <?php echo $val_video['title'] ?>
                                    </h3>
                                </div>
                                <div id="modal-video-<?php echo $key + 1 ?>" class="uk-modal"><!-- MODAL VIDEO -->
                                    <div class="uk-modal-dialog">
                                        <a class="uk-modal-close uk-close"></a>
                                        <div class="video">
                                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $video_code ?>" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                                <ul class="uk-list list-video mt10">
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="" title="<?php echo $val_video['title'] ?>" data-uk-modal="{target:'#modal-video-<?php echo $key + 1 ?>'}"><?php echo $val_video['title'] ?></a></li>
                                <div id="modal-video-<?php echo $key + 1 ?>" class="uk-modal"><!-- MODAL VIDEO -->
                                    <div class="uk-modal-dialog">
                                        <span class="uk-modal-close uk-close"></span>
                                        <div class="video">
                                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $video_code ?>" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                    ?>
                    </ul>
                </section>
            <?php
            }
        }
    } 
?>
</section>