<?php
/**
 * @category NhanhAPI
 * listen/product.php
 */

require_once '../NhanhService.php';

$checksum = $_POST['checksum'];
$data = $_POST['data'];

$service = new NhanhService();

// kiểm tra tính hợp lệ của checksum
if (!$service->isValidChecksum($checksum, $data)) {
    echo 'Invalid checksum';
    return;
}

// decode data
if (is_array($products = json_decode($data, true)))
{
    foreach ($products as $product)
    {
        $id = $product['id']; // id sản phẩm bắn từ website sang nhanh
        $idNhanh = $product['idNhanh']; // id sản phẩm bên nhanh
        $code = $product['code'];
        $name = $product['name'];
        $price = $product['price'];
        $vat = $product['vat'];
        // ...

        // Bảng sản phẩm website của bạn cần thêm 1 trường idNhanh
        // Nếu có $id thì website update sản phẩm theo id này
        // Nếu không có $id thì website check nếu idNhanh chưa tồn tại thì insert, tồn tại rồi thì update
        if ($id) {
            "UPDATE product set name = ... where id = $id";
        } else if ($idNhanh) {
            $isExisted = "SELECT * from product where idNhanh = $idNhanh";
            if ($isExisted) {
                "UPDATE product set name = ... where idNhanh = $idNhanh";
            } else {
                "INSERT product set name = ...";
            }
        }
    }
}