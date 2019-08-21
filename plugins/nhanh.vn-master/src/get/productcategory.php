<title>NhanhAPI | Get product detail</title>
<?php
/**
 * Code sample to get product's categories from nhanh.vn
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$service = new NhanhService();

// the storeId on e-commerce platforms, individual websites set $storeId = null;
$storeId = null;

$response = $service->sendRequest(NhanhService::URI_GET_PRODUCT_CATEGORY, 'productcategory', $storeId);

echo $service->printApiInfo() . '<br>';

if($response->code) {
	echo "<h1>Success!</h1>";
	var_dump((array)$response->data);
} else {
	echo "<h1>Failed!</h1>";
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}