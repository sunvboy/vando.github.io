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

$params = ['page' => 1];

for($i = 1; $i <= 3; $i++) {
    $params['page'] = $i;
    $response = $service->sendRequest(NhanhService::URI_GET_PRODUCT_SEARCH, $params, $storeId);

    if($response->code) {
    	echo "<h1>Success!</h1>";
    	var_dump($response);

    	$file = fopen(dirname(__FILE__) .'/data/'. $i .'_'.  date('YmdHis') . '.log', "a");
    	fwrite($file, json_encode($response->data));
    	fclose($file);
    } else {
    	echo "<h1>Failed!</h1>";
    	foreach ($response->messages as $message) {
    		echo "<p>$message</p>";
    	}
    }
}