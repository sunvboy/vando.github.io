<title>NhanhAPI | Get tracking frame</title>
<?php
/**
 * Code sample to display tracking frame from Nhanh.vn
 */

header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$service = new NhanhService();

$apiUsername = $service->getApiUsername();
$storeId = 528496;
$orderId = 816706;

$dataString = implode('', [
    'apiUsername' => $apiUsername,
    'storeId' => $storeId, // require for e-commerce platform
    'orderId' => $orderId // order id
]);

$checksum = $service->createChecksum($dataString);

$url = $service->getServer() . "/api/shipping/trackingframe?apiUsername=$apiUsername&storeId=$storeId&orderId=$orderId&checksum=$checksum";
?>
<iframe src="<?php echo $url ?>" width="800" height="600"></iframe>