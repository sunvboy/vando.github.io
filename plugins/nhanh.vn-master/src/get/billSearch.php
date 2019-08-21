<title>NhanhAPI | Get product detail</title>
<?php
/**
 * Code sample to get the customer information.
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$data = array(
    "page" => 1,
    "customerMobile"=>null,
    "icpp"=>20,"id"=>null,
    "fromDate"=>"2016-05-01",
    "toDate"=>"2016-05-10"
);

$service = new NhanhService();

$response = $service->sendRequest(NhanhService::URI_BILL_SEARCH, $data);

if($response->code) {
	echo "<h1>Success!</h1>";
	$bills = (array)$response->data->bill;
	foreach($bills as $bill) {
        echo '<pre>';
        var_dump($bill);
        echo '</pre>';
	}
} else {
	echo "<h1>Failed!</h1>";
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}