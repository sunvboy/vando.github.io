<?php
$vnp_TmnCode = "L79LKITR"; //Mã website tại VNPAY
$vnp_HashSecret = "AUHNQSMZLDFBXDKXCHPDDZVGVZBJCXMI"; //Chuỗi bí mật
$vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = BASE_URL."vnpay_return.html";
$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
unset($inputData['vnp_SecureHashType']);
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . '&' . $key . "=" . $value;
    } else {
        $hashData = $hashData . $key . "=" . $value;
        $i = 1;
    }
}

//$secureHash = md5($vnp_HashSecret . $hashData);
$secureHash = hash('sha256',$vnp_HashSecret . $hashData);
?>
<!--Begin display -->
<div class="container">
    <div class="header clearfix">
        <h3 class="text-muted">VNPAY RESPONSE</h3>
    </div>
    <div class="table-responsive">
        <div class="form-group">
            <label >Mã đơn hàng:</label>

            <label><?php echo $_GET['vnp_TxnRef'] ?></label>
        </div>
        <div class="form-group">

            <label >Số tiền:</label>
            <label><?php echo $_GET['vnp_Amount'] ?></label>
        </div>
        <div class="form-group">
            <label >Nội dung thanh toán:</label>
            <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
        </div>
        <div class="form-group">
            <label >Mã phản hồi (vnp_ResponseCode):</label>
            <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
        </div>
        <div class="form-group">
            <label >Mã GD Tại VNPAY:</label>
            <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
        </div>
        <div class="form-group">
            <label >Mã Ngân hàng:</label>
            <label><?php echo $_GET['vnp_BankCode'] ?></label>
        </div>
        <div class="form-group">
            <label >Thời gian thanh toán:</label>
            <label><?php echo $_GET['vnp_PayDate'] ?></label>
        </div>
        <div class="form-group">
            <label >Kết quả:</label>
            <label>
                <?php
                if ($secureHash == $vnp_SecureHash) {
                    if ($_GET['vnp_ResponseCode'] == '00') {
                        echo "GD Thanh cong";
                    } else {
                        echo "GD Khong thanh cong";
                    }
                } else {
                    echo "Chu ky khong hop le";
                }
                ?>

            </label>
        </div>
    </div>
    <p>
        &nbsp;
    </p>
    <footer class="footer">
        <p>&copy; VNPAY 2015</p>
    </footer>
</div>