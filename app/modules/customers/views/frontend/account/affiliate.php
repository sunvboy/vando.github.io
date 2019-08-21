<section class="page-content" id="customers">
    <div class="top_barr">
        <div class="container">
            <div class="relative">
                <div class="title_name_members">Thành viên: <?php echo $this->fcCustomer['fullname'] ?></div>
                <ul class="nav nav-tabs">
                    <li class="">
                        <a href="<?php echo site_url('my-profile') ?>"><i class="fas fa-user-tie" aria-hidden="true"></i> Hồ sơ cá nhân</a>
                    </li>
                    <li class="d-none d-lg-block active">
                        <a href="<?php echo site_url('my-affiliate') ?>"><i class="fab fa-affiliatetheme" aria-hidden="true"></i> Lịch sử Affiliate</a>
                    </li>
                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('my-order') ?>"> <i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
                    </li>
                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('my-coint') ?>"> <i class="fas fa-coins" aria-hidden="true"></i> Lịch sử xu</a>
                    </li>
                    <li class="d-md-none btn-group">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Xem Thêm </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="<?php echo site_url('my-affiliate') ?>"><i class="fab fa-affiliatetheme" aria-hidden="true"></i> Lịch sử Affiliate</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('my-order') ?>"> <i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('my-coint') ?>"> <i class="fas fa-coins" aria-hidden="true"></i> Lịch sử xu</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="main-inner mt25">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <span style="font-weight: bold;"><i class="fab fa-affiliatetheme" aria-hidden="true"></i> Lịch sử Affiliate </span> 
                    </div>
                    <div class="panel-body">
                        <?php if (isset($ListPayment) && is_array($ListPayment) && count($ListPayment)) { ?>
                            <section class="order-list" style="overflow: auto;">
                                <table class="table table-striped table-table mb25 table-responsive">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                            <th>Hoa hồng</th>
                                            <th>Ngày giao dịch</th>
                                            <th>Tình trạng</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày cập nhật</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0; ?>
                                        <?php foreach ($ListPayment as $key => $val): ?>
                                            <?php 
                                                // Giảm giá theo đơn hàng
                                                $price_gift = checkgiftcode_payment($val['discount_code'], $val['id']); 
                                                // Check người giới thiệu
                                                $affiliate_name = $this->FrontendCustomers_Model->ReadByField('affiliate_id', $val['affiliate_id']);
                                                $_payment_list_ = json_decode($val['data'], TRUE);//print_r($_payment_list_);die;

                                                $total_ship = $price_affiliate = 0;
                                                if (isset($_payment_list_) && is_array($_payment_list_) && count($_payment_list_)){
                                                    foreach($_payment_list_ as $key => $item){ 
                                                        // $total_ship += check_shipping_products($item['detail']['id'], $val['shipcode']); 
                                                        $ship_data = json_decode($item['detail']['shipcode'], TRUE);
                                                        $total_ship += $ship_data[0][$val['shipcode']];
                                                        $productDetail = $this->Autoload_Model->_get_where(array(
                                                            'select' => 'id, quantity, saleoff',
                                                            'table' => 'products',
                                                            'where' => array('publish' => 1, 'trash' => 0, 'id' => $item['id']),
                                                        ));
                                                        if (isset($productDetail) && is_array($productDetail) && count($productDetail)) {
                                                            // Kiểm tra tính hoa hồng cho người giới thiệu
                                                            if (isset($affiliate_name) && is_array($affiliate_name) && count($affiliate_name)) {
                                                                // Giá bán ra cho Affiliate
                                                                // $price_ = price_affiliate($item['detail']['saleoff'], $productDetail['id']);
                                                                $price_ = $item['price'] - ((isset($item['affiliate']) && is_array($item['affiliate']) && count($item['affiliate']) && !empty($item['affiliate']['count'])) ? $item['affiliate']['count'] : $item['price']);
                                                                $price_affiliate += ((!empty($price_)) ? $price_ : 0);
                                                            }
                                                        }
                                                    }
                                                }
                                                // Hoa hồng cho Affiliate = $price_affiliate - $price_gift
                                                $total += ($price_affiliate - $price_gift);
                                            ?>
                                            <tr>
                                                <td><?php echo ($key + 1) ?></td>
                                                <td><?php echo '#VAND'.($val['id'] + 100000) ?></td>
                                                <td><?php echo $val['quantity'] ?></td>
                                                <td><?php echo str_replace(',', '.', number_format($val['total_price'] + $total_ship - $price_gift)) ?> đ</td>
                                                <td><?php echo str_replace(',', '.', number_format($price_affiliate - $price_gift)) ?> đ</td>
                                                <td><?php echo $val['created'] ?></td>
                                                <td>
                                                    <button class="btn btn-white btn-sm btn-<?php echo $val['status'] ?>">
                                                        <?php echo $this->configbie->data('status', $val['status']) ?>    
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-white btn-sm <?php echo ((!empty($val['process'])) ? 'btn-success' : 'btn-danger') ?>">
                                                        <?php echo $this->configbie->data('process', $val['process']) ?>    
                                                    </button>
                                                </td>
                                                <td>
                                                    <?php echo ((!empty($val['process'])) ? show_time($val['updated'], 'd-m-Y') : 'Chưa xác định') ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                        <tr>
                                            <td colspan="4"><strong>Tổng tiền hoa hồng</strong></td>
                                            <td>
                                                <font color="red"><?php echo str_replace(',', '.', number_format($total)) ?> đ</font>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </section>
                        <?php }else{ ?>
                            <div class="empty">Không tìm thấy kết quả nào.</div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>  
</section>
<style>
    .btn-opened, .btn-wait {background: #dd4b39; color:#fff;}
    .btn-processing {background: #f4c58f;color: #815621 !important; }
    .btn-success{background: #75a630; color:#fff}
    .btn-cancle{background: #333; color:#fff}
</style>