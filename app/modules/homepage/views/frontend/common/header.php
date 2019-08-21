<header id="header-site">
    <div class="wp-header">

        <?php if($this->fcSystem['homepage_note']!=''){?>
            <div class="wp-top-header">
                <div class="container-fluid">
                    <div class="wp-text-ads text-center">
                        <span class=""><?php echo $this->fcSystem['homepage_note']?></span>
                    </div>
                </div>
            </div>
        <?php }?>

        <div class="wp-main-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1 col-sm-12 col-xs-12">
                        <div class="wp-header-mobile">
                            <div class="wp-logo text-center">
                                <a href="<?php echo base_url()?>"><img src="<?php echo $this->fcSystem['homepage_logo']?>" alt="<?php echo $this->fcSystem['homepage_company']?>"></a>
                            </div>
                            <div class="wp-menu-mobile hidden-lg hidden-md">
                                <div id="trigger-mobile">
                                    <span class="bar"></span>
                                    <span class="bar"></span>
                                    <span class="bar"></span>
                                </div>
                            </div>
                            <div class="box-search-mb hidden-lg hidden-md">
                                <button class="btn btn-default btn-search-mb"><i class="fas fa-search"></i></button>
                                <div class="wp-box-search-mb">
                                    <form action="tim-kiem.html"  method="get">
                                        <input type="text" class="form-control" name="key" value="<?php echo $this->input->get('key')?>" placeholder="Nhập từ khóa cần tìm kiếm">
                                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="wp-cart-mb hidden-lg hidden-md">
                            <div class="cart-mb">
                                <a  class="btn-click-cart"><i class="fas fa-shopping-bag"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php $main_nav = navigations_array('main', $this->fc_lang); ?>
                    <?php if (isset($main_nav) && is_array($main_nav) && count($main_nav)) { ?>
                    <div class="col-md-8 hidden-sm hidden-xs">
                        <div class="wp-main-menu">
                            <nav class="navbar navbar-default" role="navigation">
                                <div class="collapse navbar-collapse navbar-ex1-collapse" style="padding: 0px;">
                                    <ul class="nav navbar-nav navbar-left" id="menu2">
                                        <?php foreach ($main_nav as $key => $vals) { ?>
                                        <li <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])) { ?>class="dropdown"<?php }?>>
                                            <a href="<?php echo(($vals['href'] == '#') ? 'javascript: void(0)' : $vals['href']); ?>"><span><?php echo $vals['title'] ?></span></a>
                                            <?php if (isset($vals['child']) && is_array($vals['child']) && count($vals['child'])) { ?>
                                            <span class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></span>
                                            <ul class="dropdown-menu">
                                                <?php foreach ($vals['child'] as $key => $val) { ?>
                                                    <li>
                                                        <a href="<?php echo(($val['href'] == '#') ? 'javascript: void(0)' : $val['href']); ?>" title="<?php echo $val['title']; ?>">
                                                            <?php echo $val['title']; ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <?php }?>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <?php }?>
                    <div class="col-md-3 hidden-sm hidden-xs">
                        <div class="wp-main-header-right">
                            <div class="wp-search">
                                <form action="tim-kiem.html" method="get">
                                    <button class="btn btn-default btn-search" type="submit"><i class="fas fa-search"></i></button>
                                    <input type="text" placeholder="Bạn cần tìm gì" value="<?php echo $this->input->get('key')?>" name="key" class="form-control">
                                </form>
                            </div>
                            <div class="wp-user">
                                <i class="far fa-user"></i>
                                <div class="wp-sub-menu">
                                    <ul class="ul-b list-login">
                                        <?php $customer = $this->config->item('fcCustomer'); ?>
                                        <?php if(!isset($customer) || !is_array($customer) || count($customer) == 0){ ?>
                                        <li><a href="<?php echo site_url('login') ?>">Đăng nhập</a></li>
                                        <li><a href="<?php echo site_url('register') ?>">Đăng ký</a></li>
                                        <?php }else{ ?>
                                            <li><a href="<?php echo site_url('my-profile'); ?>"><?php echo $customer['fullname'] ?></a></li>
                                            <li><a href="<?php echo site_url('logout') ?>">Đăng xuất</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="wp-cart">
                                    <?php
                                    $cart = $this->cart->contents();
                                    if (isset($cart) && is_array($cart) && count($cart)) {
                                        $temp = NULL;
                                        foreach ($cart as $keyMain => $valMain) {
                                            $temp[] = $valMain['id'];
                                        }
                                        if (isset($temp) && is_array($temp) && count($temp)) {
                                            $product = $this->Autoload_Model->_get_where(array(
                                                'select' => 'id, title, slug, canonical, images, price, saleoff, weight, shipcode',
                                                'where' => array('publish' => 1, 'trash' => 0),
                                                'table' => 'products',
                                                'where_in' => $temp,
                                                'where_in_field' => 'id',
                                            ), TRUE);
                                        }
                                        $temp = NULL;
                                        foreach ($cart as $keyMain => $valMain) {
                                            foreach ($product as $keyItem => $valItem) {
                                                if ($valItem['id'] == $valMain['id']) {
                                                    $valMain['detail'] = $valItem;
                                                    if (!empty($affiliate)) {
                                                        if (isset($customers) && is_array($customers) && count($customers)) {
                                                            $valMain['affiliate'] = $this->Autoload_Model->_get_where(array(
                                                                'select' => 'level, count',
                                                                'table' => 'products_discount_affiliate',
                                                                'where' => array('productsid' => $valMain['id'], 'level' => $customers['level']),
                                                            ), FALSE);
                                                        }
                                                    }
                                                }
                                            }
                                            $temp[] = $valMain;
                                        }
                                        $cart = $temp;
                                    }

                                    ?>
                                    <a  class="btn-click-cart"><i class="fas fa-shopping-cart"></i></a>






                            </div>
                        </div>
                    </div>
                    <div id="site-cart">

                        <div class="site-nav-container-last">
                            <button id="site-close-handle" class="site-close-handle">
                                <img src="templates/frontend/images/iconclose_32c1d6a3da3545278283605bbfca0b0b.png" alt="Đóng">
                            </button>
                            <p class="title">Giỏ hàng</p>
                            <span class="textCartSide">Bạn đang có <span id="qtotalitems"><b><?php echo $this->cart->total_items()?></b></span> sản phẩm trong giỏ hàng.</span>
                            <div class="cart-view clearfix">

                                <table id="cart-view">
                                    <tbody id="ajax-cart-form">
                                    <?php if(isset($cart) && is_array($cart) && count($cart)){ ?>
                                        <?php foreach($cart as $key => $val){ ?>
                                            <?php $val['detail']['href'] = rewrite_url($val['detail']['canonical'], $val['detail']['slug'], $val['detail']['id'], 'products'); ?>
                                            <?php $price = $val['price']; ?>
                                            <tr class="item_2" data-id="1041431100">
                                                <td class="img">
                                                    <a href="<?php echo $val['detail']['href']?>"><img src="<?php echo getthumb($val['detail']['images']);?>" alt="<?php echo $val['name']; ?>"></a>
                                                </td>
                                                <td>
                                                    <input name="quantity" value="<?php echo $val['rowid'] ?>" class="quantity ajax-quantity" type="hidden">
                                                    <a class="pro-title-view" href="<?php echo $val['detail']['href']?>" ><?php echo $val['name']; ?></a>
                                                    <span class="pro-price-view"><?php echo str_replace(',', '.', number_format($price))?>₫</span>
                                                    <span class="pro-price-view">Số lượng: <?php echo $val['qty']?></span>
                                                    <div class="variant">
                                                        <?php if(!empty($val['options']['sanphamtangkem'])) {
                                                            $this->load->model('sanphamtangkem/FrontendSanphamtangkem_Model');
                                                            $sanphamtangkem = $this->FrontendSanphamtangkem_Model->ReadByField('id', $val['options']['sanphamtangkem']);
                                                            echo '<span class="pro-price-view">Sản phẩm tặng kèm: '.$sanphamtangkem['title'].'</span>';
                                                        }?>
                                                        <?php if (isset($val['options']) && is_array($val['options']) && count($val['options'])): ?>

                                                            <?php foreach ($val['options'] as $keyc => $vals): ?>
                                                                <?php if($vals != ''){?>
                                                                    <?php if($keyc != 'sanphamtangkem'){?>
                                                                        <span><?php echo $keyc.' : '.$vals ?></span>&nbsp;&nbsp;&nbsp;
                                                                    <?php }?>
                                                                <?php }?>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                    </div>
                                                    <div class="remove_link remove-cart delete_item" ><a href="javascript:void(0);" class="quantity">Xóa</a></div>
                                                </td>
                                            </tr>
                                        <?php }?>
                                    <?php }?>
                                    </tbody>
                                </table>
                                <span class="line"></span>
                                <table class="table-total">
                                    <tbody><tr>
                                        <td class="text-left"><b>TỔNG TIỀN TẠM TÍNH:</b></td>
                                        <td class="text-right" id="total-view-cart"><?php echo str_replace(',', '.', number_format($this->cart->total())) ?>₫</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><a href="dat-mua.html" class="checkLimitCart linktocheckout button dark">Tiến hành đặt hàng</a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><a href="<?php echo base_url()?>" class="linktocart button dark">Tiếp tục mua hàng <i class="fa fa-arrow-right"></i></a></td>
                                    </tr>
                                    </tbody></table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
<!-- end header -->