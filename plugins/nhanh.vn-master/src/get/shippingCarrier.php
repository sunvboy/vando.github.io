<title>NhanhAPI | Get shipping fee</title>
<?php
/**
 * Code sample to get the shipping carriers from Nhanh.vn
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$service = new NhanhService();
$response = $service->sendRequest(NhanhService::URI_SHIPPING_CARRIER, "carriers");

echo $service->printApiInfo() . '<br>';

if($response->code) {
	echo "<h1>Success!</h1>";
	echo "<table border='1' cellspacing='0' cellpadding='0'>";
	echo "<tr>";
	echo "<td>ID Hãng vận chuyển</td>";
	echo "<td>Logo</td>";
	echo "<td>Tên hãng</td>";
	echo "<td>Tên đầy đủ</td>";
	echo "<td>Các dịch vụ của hãng</td>";
	echo "</tr>";
	foreach($response->data as $carrier) {
		echo "<tr>";
		echo "<td>{$carrier->id}</td>";
		echo "<td><img width='150px' src='{$carrier->logo}' /></td>";
		echo "<td>{$carrier->name}</td>";
		echo "<td>{$carrier->businessName}</td>";
		echo "<td>";
			if(isset($carrier->services) && count($carrier->services)) {
				echo "<ul>";
				foreach($carrier->services as $cs) {
					// $cs->id, $cs->name, $cs->description
					echo "<li>". $cs->name .' ('. $cs->description .')</li>';
				}
				echo "</ul>";
			}
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
} else {
	echo "<h1>Failed!</h1>";
	// error messages
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}