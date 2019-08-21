<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends FC_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fc_lang = $this->config->item('fc_lang');
        $this->load->model('Autoload_Model');
        /* KIỂM TRA TÌNH TRẠNG WEBSITE */
        if ($this->fcSystem['homepage_website'] == 1) {
            echo '<img src="' . base_url() . 'templates/backend/images/close.jpg' . '" style="width:100%;" />';
            die();
        }
        /* -------------------------- */
    }

    public function Inquiry()
    {
        $cart = $this->cart->contents();
        if (isset($cart) && is_array($cart) && count($cart)) {
            $temp = NULL;
            foreach ($cart as $keyMain => $valMain) {
                $temp[] = $valMain['id'];
            }
            if (isset($temp) && is_array($temp) && count($temp)) {
                $product = $this->Autoload_Model->_get_where(array(
                    'select' => 'id, title, slug, canonical, images, price, saleoff, content2, (SELECT title FROM products_catalogues WHERE products.cataloguesid = products_catalogues.id) as titlecatelogies,',
                    'where' => array('publish' => 1, 'trash' => 0, 'alanguage' => $this->fc_lang),
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
                    }
                }
                $temp[] = $valMain;
            }
            $cart = $temp;
        }

        if ($this->input->post('create')) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', ' / ');
            $this->form_validation->set_rules('companyname', 'Tên công ty', 'trim|required');
            $this->form_validation->set_rules('fullname', 'Tên riêng', 'trim|required');
            $this->form_validation->set_rules('namefamily', 'Tên ở gia đình', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('country', 'Thành phố phố', 'trim|required');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
            $this->form_validation->set_rules('fax', 'Fax', 'trim|required');
            $this->form_validation->set_rules('message', 'Nội dung yêu cầu', 'trim|required');
            if ($this->form_validation->run($this)) {
                $_paymentid = $this->Autoload_Model->_create(array(
                    'table' => 'payments',
                    'data' => array(
                        'type' => 'cart',
                        'fullname' => $this->input->post('fullname'),
                        'namefamily' => $this->input->post('namefamily'),
                        'companyname' => $this->input->post('companyname'),
                        'email' => $this->input->post('email'),
                        'phone' => $this->input->post('phone'),
                        'fax' => $this->input->post('fax'),
                        'address' => $this->input->post('country'),
                        'message' => $this->input->post('message'),
                        'data' => json_encode($cart),
                        'quantity' => $this->cart->total_items(),
                        'total_price' => $this->cart->total(),
                        'publish' => 1,
                        'status' => 'wait',
                        'send' => 0,
                        'distributors ' => $this->input->post('distributors '),
                        'created' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                    ),
                ));
                if ($_paymentid > 0) {
                    if (isset($cart) && is_array($cart) && count($cart)) {
                        $_insert_ = '';
                        $_product_ = '';
                        foreach ($cart as $key => $val) {
                            $_insert_[] = array(
                                'paymentsid' => $_paymentid,
                                'productsid' => $val['id'],
                                'quantity' => $val['qty'],
                                'price' => $val['price'],
                                'publish' => 1,
                                'created' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                            );

                        }
                        if (isset($_insert_) && is_array($_insert_) && count($_insert_)) {
                            $flag = $this->Autoload_Model->create_batch(array('table' => 'payments_items', 'data' => $_insert_));
                        }
                        $this->cart->destroy();
                        $this->session->set_flashdata('message-success', 'Bạn gửi yêu cầu thành công!. Chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất.');
                        redirect(base_url());
                    }
                }

            }
        }

        $data['cart'] = $cart;
        $data['meta_title'] = $this->lang->line('inquiry');
        $data['meta_keyword'] = '';
        $data['meta_description'] = '';
        $data['template'] = 'products/frontend/cart/inquiry';
        $this->load->view('homepage/frontend/layouts/home', isset($data) ? $data : NULL);
    }

    public function cartsale()
    {

        //echo json_encode($this->input->post('productDetails'));die;
        $alert = array(
            'error' => '',
            'message' => '',
            'result' => ''
        );

        $affiliate = (isset($_COOKIE['affiliate'])) ? $_COOKIE['affiliate'] : '';
        $customer = $this->config->item('fcCustomer');

        $array = [];
        $data = $this->input->post('productDetails');
        array_push($array, json_decode($data));

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '&nbsp/&nbsp');
        $this->form_validation->set_rules('fullname', 'Họ và tên', 'trim|required');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required');

        if ($this->form_validation->run($this)) {
            $_paymentid = $this->Autoload_Model->_create(array(
                'table' => 'payments',
                'data' => array(
                    'type' => 'cart',
                    'affiliate_id' => $affiliate,
                    'customersid' => ((!empty($customer['id'])) ? $customer['id'] : ''),
                    'fullname' => $this->input->post('fullname'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'total_price' => $this->input->post('price'),
                    'data' => json_encode($array),
                    'publish' => 1,
                    'status' => 'wait',
                    'send' => 0,
                    'created' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                ),
            ));
            if ($_paymentid > 0) {

                $flag = $this->Autoload_Model->_create(array(
                    'table' => 'payments_items',
                    'data' => array(
                        'paymentsid' => $_paymentid,
                        'publish' => 1,
                        'created' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                    ),
                ));
            }

        } else {
            $alert['error'] = validation_errors();
        }
        echo json_encode($alert);
        die();

    }

    public function Payment()
    {
//        $this->cart->destroy();
        $cart = $this->cart->contents();

        if(empty($cart)){
            $this->session->set_flashdata('message-danger',  'Không tồn tại sản phẩm trong giỏ hàng');
            redirect(base_url());
        }
        $this->load->model('FrontendSaleDG_Model');
        //lấy sale theo số lượng
        $totalsale = 0;
        $SaleTheoSoLuongDonHang = $this->FrontendSaleDG_Model->ReadByFieldSoLuong('1');
        if(!empty($SaleTheoSoLuongDonHang)){
            if($this->cart->total_items() >= $SaleTheoSoLuongDonHang['qty']){
                $totalsale = ($this->cart->total()/100)*$SaleTheoSoLuongDonHang['saleoff'];

            }
        }
        //end
        //lấy sale theo khung giờ vàng giảm theo %
        $totalKGVPT = 0;
        $SaleTheoKGVPT = $this->FrontendSaleDG_Model->ReadByFieldSoLuong('2');
        if(!empty($SaleTheoKGVPT)){
            $totalKGVPT = ($this->cart->total()/100)*$SaleTheoKGVPT['saleoff'];

        }
        //end lấy sale theo khung giờ vàng giảm theo %
        $affiliate = (isset($_COOKIE['affiliate'])) ? $_COOKIE['affiliate'] : '';
        $customers = $this->FrontendCustomers_Model->ReadByField('affiliate_id', $affiliate);
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

        if ($this->input->post('create')) {
            $customersid = $this->input->post('userid');
            $data['stardust'] = $this->input->post('stardust');
            $method = $this->input->post('shipcode');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', ' / ');
            $this->form_validation->set_rules('fullname', 'Tên đầy đủ', 'trim|required');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');
            $this->form_validation->set_rules('cityid', 'Tỉnh/Thành Phố', 'trim|required|callback__province');
            $this->form_validation->set_rules('districtid', 'Quận/Huyện', 'trim|required|callback__district');
            $this->form_validation->set_rules('wardid', 'Phường/Xã', 'trim|required|callback__ward');
            // $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run($this)) {
                $discount_code = $this->input->post('discount_code');
                $_paymentid = $this->Autoload_Model->_create(array(
                    'table' => 'payments',
                    'data' => array(
                        'type' => 'cart',
                        'affiliate_id' => $affiliate,
                        'customersid' => $customersid,
                        'fullname' => $this->input->post('fullname'),
                        'email' => $this->input->post('email'),
                        'phone' => $this->input->post('phone'),
                        'cityid' => $this->input->post('cityid'),
                        'districtid' => $this->input->post('districtid'),
                        'wardid' => $this->input->post('wardid'),
                        'address' => $this->input->post('address'),
                        'message' => $this->input->post('message'),
                        'shipcode' => $this->input->post('pt-tt'),
                        'payments' => $this->input->post('pt-tt2'),
                        'shipcode_value' => $this->input->post('shipcode_value'),
                        'discount_code' => $discount_code,
                        'data' => json_encode($cart),
                        'quantity' => $this->cart->total_items(),
                        'total_price' => $this->cart->total(),
                        'total_price_sale' => $totalsale,
                        'total_price_sale_khunggiovang' => $totalKGVPT,
                        'publish' => 1,
                        'status' => 'wait',
                        'send' => 0,
                        'created' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                        'coint' => ((!empty($data['stardust'])) ? $this->input->post('stardust_coint') : 0),
                    ),
                ));
                if ($_paymentid > 0) {

                    if (!empty($discount_code)) {
                        // Nếu có sử dụng Gift code
                        // Check sự tồn tại của Giftcode
                        $check_gift = $this->Autoload_Model->_read(array(
                            'select' => '*',
                            'table' => 'coupon',
                            'where' => array('publish' => 1, 'trash' => 0, 'couponCode' => $discount_code),
                        ));
                        $check = 1;
                        if (isset($check_gift) && is_array($check_gift) && count($check_gift)) {
                            if (!empty($check_gift['limitTotalUse'])) {
                                // Nếu có giới hạn số lần sử dụng mã
                                $limit = $this->Autoload_Model->_countTable(array(
                                    'table' => 'coupon_relationship',
                                    'where' => array('couponid' => $check_gift['id']),
                                ));
                                // Kiểm tra bảng relationship số lần mã này đã được sử dụng
                                if ($limit >= $check_gift['limitedUseTotal']) {
                                    // Nếu số lần sử dụng đã hết
                                    $check = 0; // Xảy ra lỗi
                                }
                            }
                            if (!empty($check)) {
                                $Insert_gift_code = $this->Autoload_Model->_create(array(
                                    'table' => 'coupon_relationship',
                                    'data' => array(
                                        'couponid' => $check_gift['id'],
                                        'paymentsid' => $_paymentid,
                                        'created' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                                    ),
                                ));
                            }
                        }
                    }


                    if (isset($cart) && is_array($cart) && count($cart)) {
                        $_insert_ = '';
                        $_product_ = '';
                        foreach ($cart as $key => $val) {
                            $_insert_[] = array(
                                'paymentsid' => $_paymentid,
                                'productsid' => $val['id'],
                                'quantity' => $val['qty'],
                                'price' => $val['price'],
                                'publish' => 1,
                                'created' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                            );
                        }
                        if (isset($_insert_) && is_array($_insert_) && count($_insert_)) {
                            $flag = $this->Autoload_Model->create_batch(array('table' => 'payments_items', 'data' => $_insert_));
                        }

                        setcookie('payment' . FC_ENCRYPTION, json_encode(array('id' => $_paymentid,)), time() + (86400 * 30), '/');
                        $total_vnpay = $this->cart->total() + $this->input->post('shipcode_value') - $this->input->post('giftcode_value') - $totalsale - $totalKGVPT;
                        setcookie('payment_vnpay' . FC_ENCRYPTION, json_encode(array('id' => $_paymentid,'amount'=>$total_vnpay,'message' => $this->input->post('message'))), time() + (86400 * 30), '/');
                        $this->cart->destroy();
                        if($this->input->post('pt-tt2')=='cod'){
                            redirect('dat-mua-thanh-cong');
                        }else if($this->input->post('pt-tt2')=='online'){
                            //thay tên miền web
                            header('Location: http://vando.local/vnpay');

                        }
                    }
                }

            }
        }

        $data['cart'] = $cart;
        $data['meta_title'] = $this->lang->line('order_payment_receiving');
        $data['meta_keyword'] = '';
        $data['meta_description'] = '';
        $data['template'] = 'products/frontend/cart/view';
        $this->load->view('homepage/frontend/layouts/home', isset($data) ? $data : NULL);
    }

    public function vnpay_return(){
        if (isset($_COOKIE['payment_vnpay' . FC_ENCRYPTION])) {
            unset($_COOKIE['payment_vnpay' . FC_ENCRYPTION]);
            setcookie('payment_vnpay' . FC_ENCRYPTION, null, -1, '/');
        }
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

        $secureHash = hash('sha256',$vnp_HashSecret . $hashData);
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $this->Autoload_Model->_update(array(
                    'table' => 'payments',
                    'where' => array('id' => $_GET['vnp_TxnRef']),
                    'data' => array('payments_status' => 1,'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600)),
                ));
                $this->Autoload_Model->_create(array(
                    'table' => 'payments_status',
                    'data' => array(
                        'vnp_TxnRef' => $_GET['vnp_TxnRef'],
                        'vnp_Amount' => $_GET['vnp_Amount']/100,
                        'vnp_OrderInfo' => $_GET['vnp_OrderInfo'],
                        'vnp_ResponseCode' => $_GET['vnp_ResponseCode'],
                        'vnp_TransactionNo' => $_GET['vnp_TransactionNo'],
                        'vnp_BankCode' => $_GET['vnp_BankCode'],
                        'vnp_PayDate' => $_GET['vnp_PayDate'],
                        'create' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                    )));
                redirect('dat-mua-thanh-cong');
            } else {
                redirect('dat-mua-thanh-cong');
            }
        } else {
            redirect('dat-mua-thanh-cong');
        }
        $data['template'] = 'products/frontend/cart/vnpay_return';
        $this->load->view('homepage/frontend/layouts/homevnpay', isset($data) ? $data : NULL);
    }
    public function success()
    {
        $this->load->model('province/BackendProvince_Model');

        $payment = isset($_COOKIE['payment' . FC_ENCRYPTION]) ? $_COOKIE['payment' . FC_ENCRYPTION] : NULL;
        if (!isset($payment) || empty($payment)) {
            redirect(base_url());
            show_error($this->lang->line('error_payment_item'));
        }
        $_paymentid = json_decode($payment, TRUE);
        $_payment = $this->Autoload_Model->_read(array(
            'table' => 'payments',
            'where' => array(
                'id' => $_paymentid['id'],
            ),
        ));
        if (!isset($_payment) || !is_array($_payment) || count($_payment) == 0) {
            redirect(base_url());
            show_error($this->lang->line('error_payment_item'));
        }
        $productlist = json_decode($_payment['data'], TRUE);
        $_product_ = '';

        if ($this->input->post('confirm')) {
            $discounted = $total_ship = 0;
            $price_gift = checkgiftcode_payment($_payment['discount_code'], $_payment['id']);
            if($_payment['payments']=='online'){
                $phuongthucthanhtoan = 'Thanh toán online';

            }else{
                $phuongthucthanhtoan = 'Thanh toán khi nhận hàng';

            }
            if($_payment['shipcode']=='shop'){
                $shipcode = 'Giao hàng tận nơi(COD)';

            }else{
                $shipcode = 'Giao hàng tận nơi(CK trước)';

            }
            $cityid = $this->BackendProvince_Model->readF($_payment['cityid']);
            $districtid = $this->BackendProvince_Model->readF($_payment['districtid']);
            $wardid = $this->BackendProvince_Model->readF($_payment['wardid']);

            if (isset($productlist) && is_array($productlist) && count($productlist)) {
                foreach ($productlist as $key => $val) {
//                    $price = ($val['detail']['saleoff']) ? $val['detail']['saleoff'] : $val['detail']['saleoff'];
                    $price = $val['price'];
                    $discounted += check_price_affiliate($price, FALSE);
                    $total_ship += check_shipping_products($val['detail']['id'], $_payment['shipcode']);
                    $_product_ = $_product_ . '<li style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;margin-bottom: 10px;padding-bottom: 10px;border-bottom: 1px solid #ebebeb;display: flex;">
                    <div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;width: 80px; margin-right: 15px">
                    <a href="" title="" style="display: block;width: 100%;height: 75px;-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;">
                    <img src="' . BASE_URL . $val['detail']['images'] . '" alt="" style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;display: block;width: 100%;height: 100%;object-fit: scale-down;"></a>
                    </div>
                    <div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;padding-left: 15px;>
                    <div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-size: 13px;line-height: 18px;overflow: hidden;-ms-text-overflow: ellipsis;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;margin-bottom: 5px"><a href="" title="" style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;color: #333;font-weight: bold;text-decoration: none;">' . $val['detail']['title'] . '</a>
                    <div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-size:13px;font-weight: bold;margin-bottom: 5px;">Giá: <span style="color: #c10017;">' . (str_replace(',', '.', number_format($price))) . '₫</span></div><div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;color: #999;font-size:13px;">Số lượng: <span style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;color: #333;font-weight: bold;">' . $val['qty'] . '</span></div></div><br>(';
                    if(!empty($val['options']['sanphamtangkem'])) {
                        $this->load->model('sanphamtangkem/FrontendSanphamtangkem_Model');
                        $sanphamtangkem = $this->FrontendSanphamtangkem_Model->ReadByField('id', $val['options']['sanphamtangkem']);
                        $_product_ = $_product_ . '<div style = "-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-size:13px;font-weight: bold;margin-bottom: 5px;" >Sản phẩm tặng kèm:'.$sanphamtangkem.'</div >';
                    }
                    if (isset($val['options']) && is_array($val['options']) && count($val['options'])):
                    foreach ($val['options'] as $keyc => $vals):
                        if($vals != '') {
                            if ($keyc != 'sanphamtangkem') {
                                $_product_ = $_product_ . '<div style = "-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-size:13px;font-weight: bold;margin-bottom: 5px;" >'.$keyc.':'.$vals.'</div >';
                            }
                        }
                    endforeach;
                    endif;
                    $_product_ = $_product_ . ')</div>
                    <div style="-o-box-sizing: border-box;-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;"></div></div></li>';
                }
            }
            if (isset($_product_) && !empty($_product_)) {
                $this->load->library(array('mailbie'));
                $this->mailbie->sent(array(
                    'to' => 'nguyenquyen571995@gmail.com',
                    'cc' => '',
                    'subject' => 'Bạn nhận được email từ hệ thống website: ' . $this->fcSystem['contact_web'],
                    'message' => mail_html(array(
                        'header' => 'Thông tin đặt hàng',
                        'fullname' => $_payment['fullname'],
                        'message' => $_payment['message'],
                        'payments' => $phuongthucthanhtoan,
                        'shipcode' => $shipcode,
                        'address' => $_payment['address'],
                        'total_price' => $_payment['total_price'],
                        'total_price_1' => ($_payment['total_price'] + $_payment['shipcode_value'] - $price_gift - $_payment['coint']-$_payment['total_price_sale']),
                        'discounted' => $discounted,
                        'shipcode_value' => $_payment['shipcode_value'],
                        'product' => $_product_,
                        'web' => $this->fcSystem['contact_web'],
                        'HOTLINE_goimuahang_phone' => $this->fcSystem['HOTLINE_goimuahang_phone'],
                        'HOTLINE_khieunai_phone' => $this->fcSystem['HOTLINE_khieunai_phone'],
                        'phone' => $_payment['phone'],
                        'tinhthanhpho' => $cityid,
                        'quanhuyen' => $districtid,
                        'phuongxa' => $wardid,
                    ))
                ));
            }
            if (isset($_COOKIE['payment' . FC_ENCRYPTION])) {
                unset($_COOKIE['payment' . FC_ENCRYPTION]);
                setcookie('payment' . FC_ENCRYPTION, null, -1, '/');
            }
            $this->session->set_flashdata('message-success', 'Gửi Email thành công, vui lòng kiểm tra hòm thư của bạn');
            redirect(base_url());
        }
        $data['payment'] = $_payment;
        $data['meta_title'] = 'Đặt hàng thành công';
        $data['meta_keyword'] = '';
        $data['meta_description'] = '';
        $data['template'] = 'products/frontend/cart/success';
        $this->load->view('homepage/frontend/layouts/home', isset($data) ? $data : NULL);
    }
    public function _province(){

        if($this->input->post('cityid') == 0){
            $this->form_validation->set_message('_province', 'Tỉnh/Thành Phố là trường bắt buộc');
            return FALSE;
        }
        return TRUE;
    }
    public function _district(){

        if($this->input->post('districtid') == 0){
            $this->form_validation->set_message('_district', 'Quận/Huyện là trường bắt buộc');
            return FALSE;
        }
        return TRUE;
    }
    public function _ward(){

        if($this->input->post('wardid') == 0){
            $this->form_validation->set_message('_ward', 'Phường/Xã là trường bắt buộc');
            return FALSE;
        }
        return TRUE;
    }
    public function vnpay_create_payment(){
        $this->load->model('province/BackendProvince_Model');

        $payment = isset($_COOKIE['payment' . FC_ENCRYPTION]) ? $_COOKIE['payment' . FC_ENCRYPTION] : NULL;
        if (!isset($payment) || empty($payment)) {
            redirect(base_url());
            show_error($this->lang->line('error_payment_item'));
        }
        $_paymentid = json_decode($payment, TRUE);
        $_payment = $this->Autoload_Model->_read(array(
            'table' => 'payments',
            'where' => array(
                'id' => $_paymentid['id'],
            ),
        ));
        if (!isset($_payment) || !is_array($_payment) || count($_payment) == 0) {
            redirect(base_url());
            show_error($this->lang->line('error_payment_item'));
        }
        $price_gift = checkgiftcode_payment($_payment['discount_code'], $_payment['id']);
        $vnp_TmnCode = "L79LKITR"; //Mã website tại VNPAY
        $vnp_HashSecret = "AUHNQSMZLDFBXDKXCHPDDZVGVZBJCXMI"; //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = BASE_URL . "vnpay_return.html";
        //thanh toán vnpay
        if($this->input->post('update')) {


            $vnp_TxnRef = $_payment['id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = $this->input->post('order_desc');
            $vnp_OrderType = $this->input->post('order_type');
            $vnp_Amount = $_payment['total_price'] + $_payment['shipcode_value'] - $price_gift;
            $vnp_Locale = $this->input->post('language');
            $vnp_BankCode = $this->input->post('bank_code');
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.0.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
                $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
                $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
            }
            $data['returnData'] = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
        }
        //end
        $data['template'] = 'products/frontend/cart/vnpay_create_payment';
        $this->load->view('homepage/frontend/layouts/homevnpay', isset($data) ? $data : NULL);
    }
}
