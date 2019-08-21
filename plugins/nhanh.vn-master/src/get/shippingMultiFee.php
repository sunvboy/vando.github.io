<title>NhanhAPI | Get shipping multi fee</title>
<?php
/**
 * Code sample to get the shipping multi fee from Nhanh.vn
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$data = array(
    array(
        "fromCityName" => "TP. HCM",
        "fromDistrictName" => "Quận 1",
        "toCityName" => "Hà nội",
        "shippingWeight" => 800,
        "toDistrictName" => "Hoàn Kiếm",
        "codMoney" => 1250000
    ),
    array(
        "fromCityName" => "TP. HCM",
        "fromDistrictName" => "Quận 3",
        "toCityName" => "Hà nội",
        "shippingWeight" => 2000, // 2000 gr = 2 kg
        "toDistrictName" => "Hoàn Kiếm",
        "codMoney" => 4950000
    )
);
$service = new NhanhService();
$response = $service->sendRequest(NhanhService::URI_SHIPPING_MULTIFEE, $data);

foreach($response as $r) {
    if($r->code) {
    	echo "<h1>Success!</h1>";
    	echo "<table border='1' cellspacing='0' cellpadding='5'>";
    	echo "<tr>";
    	echo "<th>Carrier ID</th>";
    	echo "<th>Carrier</th>";
    	echo "<th>Carrier service ID</th>";
    	echo "<th>Carrier service Name</th>";
    	echo "<th>Service description</th>";
    	echo "<th>Shipping fee</th>";
    	echo "<th>COD fee</th>";
    	echo "<th>Total fee</th>";
    	echo "</tr>";
    	foreach($r->data as $rate) {
    		echo "<tr>";
    		echo "<td>{$rate->carrierId}</td>";
    		echo "<td>{$rate->carrierName}</td>";
    		echo "<td>{$rate->serviceId}</td>";
    		echo "<td>{$rate->serviceName}</td>";
    		echo "<td>{$rate->serviceDescription}</td>";
    		echo "<td>{$rate->shipFee}</td>";
    		echo "<td>{$rate->codFee}</td>";
    		echo "<td>". ($rate->shipFee + $rate->codFee) ."</td>";
    		echo "</tr>";
    	}
    	echo "</table>";
    } else {
    	echo "<h1>Failed!</h1>";
    	foreach ($r->messages as $message) {
    		echo "<p>$message</p>";
    	}
    }
}
