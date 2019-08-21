<title>NhanhAPI | Get product detail</title>
<?php
/**
 * Code sample to get the customer information.
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$data = array(
	'mobile' => '01627227153'
);

$service = new NhanhService();

$response = $service->sendRequest(NhanhService::URI_CUSTOMER_SEARCH, $data);

if($response->code) {
	echo "<h1>Success!</h1>";
	$customers = (array)$response->data->customers;
	foreach($customers as $customer) {
	   echo '<pre>';
	   var_dump($customer);
	   echo '</pre>';
	   echo '---------------------------------------------------<br>';
	}
} else {
	echo "<h1>Failed!</h1>";
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}