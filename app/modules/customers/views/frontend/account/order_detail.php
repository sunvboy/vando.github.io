<section class="page-content" id="customers">
    <div class="top_barr">
        <div class="container">
            <div class="relative">
                <div class="title_name_members">Thành viên: <?php echo $this->fcCustomer['fullname'] ?></div>
                <ul class="nav nav-tabs">
                    <li class="">
                        <a href="<?php echo site_url('my-profile') ?>"><i class="fas fa-user-tie" aria-hidden="true"></i> Hồ sơ cá nhân</a>
                    </li>
                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('thay-doi-mat-khau') ?>"><i class="fab fa-affiliatetheme" aria-hidden="true"></i> Thay đổi mật khẩu</a>
                    </li>
                    <li class="d-none d-lg-block active">
                        <a href="<?php echo site_url('my-order') ?>"> <i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-12 col-sm-3 mt25">

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin đơn hàng</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p><i class="fas fa-user-tie margin-r-5" style="width: 24px;text-align:center"></i>
                				    <span class="text">
                					   <?php echo $payment['fullname']; ?>
                				    </span>
                            </p>

                            <p>
                                <i class="fas fa-mobile-alt margin-r-5" style="width: 24px;text-align:center"></i>
                					<span class="text">
                						<?php echo $payment['phone']; ?>
                					</span>
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt margin-r-5" style="width: 24px;text-align:center" aria-hidden="true"></i>
                					<span class="text">
                						<?php echo $payment['address']; ?>
                					</span>
                            </p>
                            <?php
                            $this->load->model('province/BackendProvince_Model');

                            $cityid = $this->BackendProvince_Model->readF($payment['cityid']);
                            $districtid = $this->BackendProvince_Model->readF($payment['districtid']);
                            $wardid = $this->BackendProvince_Model->readF($payment['wardid']);
                            ?>
                            <p>
                                <i class="fas fa-map-marker-alt margin-r-5" style="width: 24px;text-align:center" aria-hidden="true"></i>
                					<span class="text">
                						</strong>Tỉnh/Thành phố: <?php echo !empty($cityid)?$cityid:'-'; ?>
                					</span>
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt margin-r-5" style="width: 24px;text-align:center" aria-hidden="true"></i>
                					<span class="text">
                					Quận/Huyện: <?php echo !empty($districtid)?$districtid:'-'; ?>
                					</span>
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt margin-r-5" style="width: 24px;text-align:center" aria-hidden="true"></i>
                					<span class="text">
                						Phường/Xã: <?php echo !empty($wardid)?$wardid:'-'; ?>
                					</span>
                            </p>
                            <p>
                                <i class="fas fa-edit margin-r-5" style="width: 24px;text-align:center" aria-hidden="true"></i>
                					<span class="text">
                						<?php echo $payment['message']; ?>
                					</span>
                            </p>
                            <p>
                                <a href="<?php echo base_url('my-order')?>" class="btn btn-success" style="width: 100%">Quay lại quản đơn hàng</a>
                            </p>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->



                </div><!-- /.col -->
                <div class="col-md-9 col-xs-12 col-sm-9 main-inner mt25">
                    <div class="panel panel-default">
                        <div class="panel-heading"> <span style="font-weight: bold;"><i class="fas fa-history" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo '#VEN'.($payment['id'] + 10) ?></span> </div>

                        <div class="clearfix"></div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover" id="diagnosis-list">
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th></th>
                                    <th>Thông tin đặt hàng</th>
                                    <th>Tổng tiền</th>
                                    <!--											<th>Hoa hồng Affiliate</th>-->
                                </tr>
                                <?php
                                $shipcode = array(
                                    'shop' => 'Mua tại cửa hàng',
                                    'inner' => 'Giao hàng khu vục nội thành Hà Nội',
                                    'outner' => 'Giao hàng các tỉnh',
                                );
                                // Giảm giá theo đơn hàng
                                $price_gift = checkgiftcode_payment($payment['discount_code'], $payment['id']);
                                //
                                $affiliate_name = $this->BackendCustomers_Model->ReadByField('affiliate_id', $payment['affiliate_id']);
                                $affliate_count = 0;
                                $_payment_list_ = json_decode($payment['data'], TRUE);
                                $price_affiliate = $total_ship = 0;
                                if (isset($_payment_list_) && is_array($_payment_list_) && count($_payment_list_)): ?>
                                    <?php foreach($_payment_list_ as $key => $item){ ?>
                                        <?php
                                        $href = site_url('products/backend/products/update/'.$item['id'].'');
                                        if(!empty($item['detail']['shipcode'])){
                                            $ship_data = json_decode($item['detail']['shipcode'], TRUE);
                                            $total_ship += $ship_data[0][$payment['shipcode']];

                                        }
                                        // Phí vận chuyển cho mỗi sản phẩm
                                        // $total_ship += check_shipping_products($item['detail']['id'], $payment['shipcode']);

                                        $productDetail = $this->Autoload_Model->_get_where(array(
                                            'select' => 'id, quantity, saleoff',
                                            'table' => 'products',
                                            'where' => array('publish' => 1, 'trash' => 0, 'id' => $item['id']),
                                        ));
                                        if (isset($productDetail) && is_array($productDetail) && count($productDetail)) {
                                            // Kiểm tra tính hoa hồng cho người giới thiệu
                                            if (isset($affiliate_name) && is_array($affiliate_name) && count($affiliate_name)) {
                                                // Giá bán ra cho Affiliate
                                                // $price_ = price_affiliate_id($productDetail['saleoff'], $productDetail['id'], $affiliate_name['id']);
                                                $price_ = $item['price'] - ((isset($item['affiliate']) && is_array($item['affiliate']) && count($item['affiliate']) && !empty($item['affiliate']['count'])) ? $item['affiliate']['count'] : $item['price']);

                                                $price_affiliate = ((!empty($price_)) ? $price_ : 0);
                                            }
                                        }
                                        $affliate_count += $price_affiliate;
                                        ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td style="width:40px;">
                                                <img src="<?php echo $item['detail']['images']; ?>" alt="" style="width:40px;" />
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="<?php echo $href; ?>" target="_blank" title="" style="color:#333;font-size:12px;font-weight:bold;">
                                                    <?php echo $item['detail']['title']; ?>

                                                </a><br>

                                                <?php if(!empty($item['options']['sanphamtangkem'])) {

                                                    $this->load->model('sanphamtangkem/FrontendSanphamtangkem_Model');
                                                    $sanphamtangkem = $this->FrontendSanphamtangkem_Model->ReadByField('id', $item['options']['sanphamtangkem']);
                                                    echo "Sản phẩm tặng kèm: ".$sanphamtangkem['title'];
                                                }?>

                                                <?php if (isset($item['options']) && is_array($item['options']) && count($item['options'])): ?>
                                                    <div class="uk-flex uk-flex-middle uk-grid-small">
                                                        <?php foreach ($item['options'] as $keyc => $vals): ?>
                                                            <?php if($keyc != 'sanphamtangkem'){?>
                                                                <span class="item_item"><?php echo $keyc.':'.$vals ?></span>
                                                            <?php }?>
                                                        <?php endforeach ?>
                                                    </div>
                                                <?php endif ?>





                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo $item['qty'] ?> x <?php echo str_replace(',','.',number_format($item['price'])); ?> đ
                                            </td>
                                            <td style="text-align:center;">
                                                <strong><?php echo str_replace(',','.',number_format($item['subtotal'])); ?> đ</strong>
                                            </td>
                                            <td style="text-align:center;" class="hide">
                                                <strong><?php echo str_replace(',','.',number_format($price_affiliate)); ?> đ</strong>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php endif ?>
                                <tr>
                                    <td colspan="4" style="text-align: right"><strong>Tổng</strong></td>
                                    <td style="width: 140px; text-align: center">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($payment['total_price'])); ?>đ
												</span>
                                    </td>
                                    <td style="width: 140px;" class="hide">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($affliate_count)); ?>đ
												</span>
                                    </td>
                                </tr>

                                <?php $price_gift = checkgiftcode_payment($payment['discount_code'], $payment['id']); ?>
                                <?php if($payment['total_price_sale']!=0){?>

                                    <tr>
                                        <td colspan="4" style="text-align: right"><strong>Chương trình khuyến mại</strong></td>
                                        <td style="width: 140px; text-align: center">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
												<?php echo '-'.str_replace(',','.',number_format($payment['total_price_sale'])); ?>đ
                                                </span>
                                        </td>
                                        <td class="hide" style="width: 140px;"></td>
                                    </tr>
                                <?php }?>
                                <?php if($payment['total_price_sale_khunggiovang']!=0){?>
                                    <tr>
                                        <td colspan="4" style="text-align: right"><strong>Chương trình khuyến mại khung giờ vàng</strong></td>
                                        <td style="width: 140px; text-align: center">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
												<?php echo '-'.str_replace(',','.',number_format($payment['total_price_sale_khunggiovang'])); ?>đ
                                                </span>
                                        </td>
                                        <td class="hide" style="width: 140px;"></td>
                                    </tr>
                                <?php }?>
                                <?php if($payment['discount_code']!=0){?>

                                    <tr>
                                        <td colspan="4" style="text-align: right"><strong>Giảm giá</strong></td>
                                        <td style="width: 140px; text-align: center">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo '-'.str_replace(',','.',number_format($price_gift)); ?>đ
												</span>
                                        </td>
                                        <td class="hide" style="width: 140px;"><?php echo $payment['discount_code'] ?></td>
                                    </tr>
                                <?php }?>
                                <?php if($payment['coint']!=0){?>

                                    <tr>
                                        <td colspan="4" style="text-align: right"><strong>Vando xu</strong></td>
                                        <td style="width: 140px; text-align: center">
												<span style="font-size:15px;font-weight:bold;">
													<?php echo '-'.str_replace(',','.',number_format($payment['coint'])); ?>đ
												</span>
                                        </td>
                                        <td class="hide" style="width: 140px;"></td>
                                    </tr>
                                <?php }?>

                                <tr>
                                    <td colspan="4" style="text-align: right"><strong>Tổng tiền</strong></td>
                                    <td style="width: 140px; text-align: center">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;color: green;font-weight: bold;font-size: 20px">
													<?php echo str_replace(',','.',number_format($payment['total_price']  - $price_gift - $payment['coint']-$payment['total_price_sale']-$payment['total_price_sale_khunggiovang'])); ?>đ
												</span>
                                    </td>
                                    <td style="width: 140px;" class="hide">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($affliate_count)); ?>đ
												</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right"><strong>Phí vận chuyển</strong></td>
                                    <td style="width: 140px; text-align: center">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													+<?php echo str_replace(',','.',number_format($payment['shipcode_value'])); ?>đ
												</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right"><strong>Tổng tiền cần thanh toán</strong></td>
                                    <td style="width: 140px; text-align: center">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;color: red;font-weight: bold;font-size: 20px">
													<?php echo str_replace(',','.',number_format($payment['total_price'] + $payment['shipcode_value'] - $price_gift - $payment['coint']-$payment['total_price_sale']-$payment['total_price_sale_khunggiovang'])); ?>đ
												</span>
                                    </td>
                                    <td style="width: 140px;" class="hide">
												<span class="<?php echo ($payment['status'] == 'success') ? 'done' : 'not-done'; ?>" style="font-size:15px;font-weight:bold;">
													<?php echo str_replace(',','.',number_format($affliate_count)); ?>đ
												</span>
                                    </td>
                                </tr>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<style>
    table thead{
        background: #dd4b39;
        color: #fff;
        font-weight: normal;
    }
    table th{
        font-weight: normal;
    }
    table tr td:first-child, table tr th:first-child {
        padding-left: 0px;
        text-align: center;
    }

    .btn-opened, .btn-wait {background: #dd4b39; color:#fff;}
    .btn-processing {background: #f4c58f;color: #815621 !important; }
    .btn-success{background: #75a630; color:#fff}
    .btn-cancle{background: #333; color:#fff}
</style>