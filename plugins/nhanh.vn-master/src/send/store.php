<title>NhanhAPI | Send store's information</title>
<?php
header('Content-type: text/html; charset=utf-8');

require_once '../NhanhService.php';

$data = array(
    'id' => 9621587,
    'name' 			=> 'digitalshop',
    'displayName' 	=> 'Digital Technology Company',
    'cityName'		=> 'Hà nội',
    'districtName'	=> 'Quận Hai Bà Trưng',
    'address' 		=> '51 Lê Đại Hành',
    'email' 		=> 'digitalshop@example.com',
    'adminEmail' 	=> 'adminemail@example.com',
    'mobile' 		=> '0984663359',
    'website' 		=> 'http://digitalshop.com'
);

$service = new NhanhService();
$response = $service->sendRequest(NhanhService::URI_STORE_ADD, $data);

if($response->code) {
    echo "<h1>Success!</h1>";
} else {
    echo "<h1>Failed!</h1>";
    foreach ($response->messages as $message) {
        echo "<p>$message</p>";
	}
}