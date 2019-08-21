<title>NhanhAPI | Get shipping fee</title>
<?php
/**
 * Code sample to get the shipping location from Nhanh.vn
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$data = array(
    "type" => "DISTRICT", // CITY | DISTRICT
    "parentId" => "2",
);
$service = new NhanhService();
$response = $service->sendRequest(NhanhService::URI_SHIPPING_LOCATION, $data);

if($response->code) {
	echo "<h1>Success!</h1>";
	echo 'type: ' . $data['type'] . '. parentId: ' . (isset($data['parentId']) ? $data['parentId'] : '') .'<br><br>';
	echo "<table border='1' cellspacing='0' cellpadding='5'>";
	echo "<tr>";
	echo "<th>ID</th>";
	echo "<th>Name</th>";
	echo "</tr>";
	foreach($response->data as $location) {
		echo "<tr>";
		echo "<td>{$location->id}</td>";
		echo "<td>{$location->name}</td>";
		echo "</tr>";
	}
	echo "</table>";
} else {
	echo "<h1>Failed!</h1>";
	foreach ($response->messages as $message) {
		echo "<p>$message</p>";
	}
}