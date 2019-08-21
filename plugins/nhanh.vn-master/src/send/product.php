<title>NhanhAPI | Get product detail</title>
<?php
/**
 * Code sample to send the detailed product's information.
 * Nhanh.vn will check if the $product->getId() is existed or not
 * to insert or update the record in Nhanh.vn
 *
 * Mỗi lần đẩy dữ liệu qua nhanh chấp nhận tối đa 300 sp / lần
 */
header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$data = array(
    array(
        "id" => 1541245,
        "code" => "SSGS2",
        "name" => "Samsung Galaxy S2",
        "importPrice" => 12000000,
        "price" => 13500000,
    ),
    array(
        "id" => 1541247,
        "code" => "SSGS3",
        "name" => "Samsung Galaxy S3",
        "importPrice" => 12000000,
        "price" => 13500000,
    ),
);

// the storeId in e-commerce platforms, individual websites set $storeId = null;
$storeId = null;

$service = new NhanhService();
$response = $service->sendRequest(NhanhService::URI_ADD_PRODUCT, $data, $storeId);

if($response->code) {
	echo "<h1>Success!</h1>";
} else {
	echo "<h1>Failed!</h1>";
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}