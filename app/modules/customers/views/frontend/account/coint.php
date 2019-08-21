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
                        <a href="<?php echo site_url('my-affiliate') ?>"><i class="fab fa-affiliatetheme" aria-hidden="true"></i> Lịch sử Affiliate</a>
                    </li>
                    <li class="d-none d-lg-block">
                        <a href="<?php echo site_url('my-order') ?>"> <i class="fas fa-history" aria-hidden="true"></i> Lịch sử đặt hàng</a>
                    </li>
                    <li class="d-none d-lg-block active">
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
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="main-inner mt25">
                 <div class="panel panel-default">
                    <div class="panel-heading"> <span style="font-weight: bold;"><i class="fas fa-coins" aria-hidden="true"></i> Lịch sử xu </span> </div>
                    <div class="panel-body">
                        <?php if (isset($ListCoint) && is_array($ListCoint) && count($ListCoint)) { ?>
                            <section class="order-list" style="overflow: auto;">
                                <table class="table table-striped table-table mb25 table-responsive">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Số lượng</th>
                                            <th>Ngày giao dịch</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ListCoint as $key => $val): ?>
                                            <tr>
                                                <td><?php echo ($key + 1) ?></td>
                                                <td><?php echo $val['title'] ?></td>
                                                <td><?php echo ((!empty($val['type'])) ? '- ' : '+ ').$val['coint'] ?></td>
                                                <td><?php echo $val['created'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                        <tr>
                                            <td colspan="5" align="center">Tổng: <font color="red"><?php echo total_coin_customers($this->fcCustomer['id']); ?> xu</font></td>
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
    </section><!-- /.content -->
</section>