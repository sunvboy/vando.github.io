<title>NhanhAPI | Get Orders</title>
<?php
/**
 * Code sample to get order list.
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$service = new NhanhService();

// the storeId on e-commerce platforms, individual websites set $storeId = null;
$storeId = null;

$data = array(
    'page' => 1,
    'fromDate' => '2017-07-01',
    'customerMobile' => '0984532302'
);

var_dump($data);
$response = $service->sendRequest(NhanhService::URI_ORDER_INDEX, $data, $storeId);

echo $service->printApiInfo() . '<br>';

if($response->code) {
	echo "<h1>Success!</h1>";
	echo "Total Pages: ". $response->data->totalPages . '<br>';
	echo "Total Records: ". $response->data->totalRecords . '<br>';
	$orders = (array)$response->data->orders;
	foreach($orders as $order) {
	   echo '<pre>';
	   var_dump($order);
	   echo '</pre>';
	   echo '---------------------------------------------------<br>';
	}
} else {
	echo "<h1>Failed!</h1>";
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}