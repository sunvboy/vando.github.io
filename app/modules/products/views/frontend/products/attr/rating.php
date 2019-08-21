<div class="list-star-dg">
    <ul class="ul1-star">
        <?php $a = count_rating($DetailProducts['id'], 'products', FALSE) ?>
        <?php $b = show_rating_products($DetailProducts['id'], 'products', FALSE) ?>
        <?php $j = ((!empty($a) && !empty($b)) ? round(($a / $b), 1) : 0); ?>
        <li><a href="javascript:;"><span class="span1-star"><?php echo $j; ?></span></a>
        </li>
        <?php
        for ($i = 0; $i < 5; $i++) {
            echo '<li><a href="javascript:;">';
            $v = $j - $i;
            if ($v > 0) {
                if ($v == 0.5) {
                    echo '<i class="fas fa-star-half-alt"></i>';
                } else {
                    echo '<i class="fas fa-star"></i>';
                }
            } else {
                echo '<i class="far fa-star"></i>';
            }
            echo '</a></li>';
        }
        ?>
        <li>
            <a class="csroll-tag" href="#rate-box">
                <span class="span2-star">(<?php echo number_format(show_rating_products($DetailProducts['id'], 'products', TRUE)) ?> đánh giá)</span>
            </a>
        </li>
    </ul>
</div>