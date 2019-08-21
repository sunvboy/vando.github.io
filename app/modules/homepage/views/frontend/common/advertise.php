<!-- Quản cáo -->
<?php $advhome = $this->FrontendSlides_Model->Read('adversite-2', $this->fc_lang); ?>
<?php if(isset($advhome) && is_array($advhome) && count($advhome)){ ?>
    <?php foreach($advhome as $key => $val){ ?>
        <div class="banner mb10">
            <a href="<?php echo $val['url']; ?>" title="<?php echo $val['title']; ?>" class="img-cover">
            	<img src="<?php echo $val['image']; ?>" alt="<?php echo $val['title']; ?>" />
            </a>
        </div>
    <?php } ?>
<?php } ?>
<!-- END Quảng cáo -->
