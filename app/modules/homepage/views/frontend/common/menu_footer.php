<?php $footer_nav = navigations_array('footer', $this->fc_lang); ?>
<?php if (isset($footer_nav) && is_array($footer_nav) && count($footer_nav)) { ?>
    <?php foreach ($footer_nav as $key => $vals) { ?>
        <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])) { ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="wp-ft-main">
                <h3 class="h3-title-ft"><?php echo $vals['title'] ?></h3>
                <ul class="ul-b list-ft-main" style="">
                    <?php foreach ($vals['child'] as $key => $val) { ?>
                        <li>
                            <a href="<?php echo(($val['href'] == '#') ? 'javascript: void(0)' : $val['href']); ?>"
                               title="<?php echo $val['title']; ?>">
                                <?php echo $val['title']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>
