<title>NhanhAPI | Get product detail</title>
<?php
/**
 * Code sample to get the detailed product's information.
 * If the product is synchronized from Nhanh.vn to merchant website, sometimes
 * the merchant want to get more information
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$service = new NhanhService();

// the storeId on e-commerce platforms, individual websites set $storeId = null;
$storeId = null;

// If the product was synchronized from Nhanh.vn, the merchant website must save the idNhanh
// for each product in merchant website and use this id to get more information from Nhanh.vn
$nhanhProductId = 1370523;

$response = $service->sendRequest(NhanhService::URI_GET_PRODUCT, $nhanhProductId, $storeId);

if($response->code) {
	echo "<h1>Success!</h1>";
	$products = (array)$response->data;
	foreach($products as $product) {
	   echo '<pre>';
	   var_dump($product);
	   echo '</pre>';
	   echo '---------------------------------------------------<br>';
	}
} else {
	echo "<h1>Failed!</h1>";
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}