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

                <div class="col-md-12 col-xs-12 col-sm-12 main-inner mt25">
                    <div class="panel panel-default">
                        <div class="panel-heading"> <span style="font-weight: bold;"><i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng </span> </div>
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
                                            <th>Hình thức thanh toan</th>

                                            <th>Ngày giao dịch</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Tình trạng</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($ListPayment as $key => $val): ?>

                                            <?php $price_gift = checkgiftcode_payment($val['discount_code'], $val['id']); ?>

                                            <?php $_payment_list_ = json_decode($val['data'], TRUE); ?>
                                            <?php $total_ship = 0; ?>
                                            <?php if (isset($_payment_list_) && is_array($_payment_list_) && count($_payment_list_)): ?>
                                                <?php foreach($_payment_list_ as $key => $item){ ?>
                                                    <?php $total_ship += check_shipping_products($item['detail']['id'], $val['shipcode']); ?>
                                                <?php } ?>
                                            <?php endif ?>
                                            <tr>
                                                <td><?php echo ($key + 1) ?></td>
                                                <td><a href="my-order-detail.html?id=<?php echo $val['id']?>" style="color: #337ab7;text-transform: uppercase;text-decoration: underline;"><?php echo '#VEN'.($val['id'] + 10) ?></a></td>
                                                <td><?php echo $val['quantity'] ?></td>
                                                <td><?php echo str_replace(',', '.', number_format($val['total_price'] + $total_ship - $price_gift)) ?> đ</td>

                                                <td>
                                                    <?php if($val['payments']=='cod'){?>
                                                        Thanh toán khi nhận hàng
                                                    <?php }else{?>
                                                        VNPAY
                                                        <?php if($val['payments_status']==1){?>
                                                            <span style="color: green;font-weight: bold">Thành công</span>
                                                        <?php }else{?>
                                                            <span style="color: red;font-weight: bold">Lỗi</span>

                                                        <?php }?>
                                                    <?php }?>

                                                </td>
                                                <td><?php echo $val['created'] ?></td>

                                                <td>
                                                    <?php echo ((!empty($val['process'])) ? show_time($val['updated'], 'd-m-Y') : 'Chưa xác định') ?>
                                                </td>
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
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </section>
                                <div class="phantrang">
                                    <?php echo  !empty($ListPagination)?''.$ListPagination.'':'';?>


                                </div>
                            <?php }else{ ?>
                                <div class="empty">Không tìm thấy kết quả nào.</div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
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