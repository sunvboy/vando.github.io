
## Get API Account

Please contact email **chukhanhvan@gmail.com** or Skype: **chukhanhvan** to get an API account.
    .

The register form will be available soon.

An API account includes:

Param | Data type (Max-length) | Description
------| -----------------------|------------
apiUsername | string(32) | API Username
secretKey | string(32) | used to [create the checksum](#create-checksum)

## Environment

- Testing: https://dev.nhanh.vn
- Production: https://graph.nhanh.vn
 
Testing | Production
---- | ------------
[https://dev.nhanh.vn/api/order/add](/docs/order/add.md)|[https://graph.nhanh.vn/api/order/add](/docs/order/add.md)
[https://dev.nhanh.vn/api/product/add](/docs/product/add.md)|[https://graph.nhanh.vn/api/product/add](/docs/product/add.md)
[https://dev.nhanh.vn/api/product/detail](/docs/product/detail.md)| [https://graph.nhanh.vn/api/product/detail](/docs/product/detail.md)
... | ...

## Request

- RESTful applications use HTTP requests to post data. The POST params include:

Param | Data Type (Max-length) | Mandatory | Description
-------- | ----------- | -------- | ---------
version | string(10) | Yes | The current version is 1.0
storeId | string(20) | No | id gian hàng trên các sàn thương mại điện tử. Param này chỉ bắt buộc với các sàn.
apiUsername | string(32) | Yes | API Username
data | string | Yes | The JSON encoded string of an array (**data structure** will be explained in each request below).
checksum | string(32) | Yes | Each request must have a checksum to validate the data. See [How to create the checksum below](#create-checksum).

Một vài request sẽ có 1 dataString cố định (VD như khi lấy danh mục sản phẩm sẽ là: productcategory, khi lấy danh sách hãng vận chuyển sẽ là: carriers...), bạn chú ý ở từng API sẽ có ghi chú về fixed dataSring ở mục request của API đó.

## Response

- The response is a JSON encoded string, which decodes into the following structure:
```js
{
	"code": 1, // 1 = success, 0 = failed (see errors in messages)
	"messages": { // if the code = 0 the server will return error messages
		"error code": "message 1",
		"error code": "message 2"
	},
	"data": {
		// structure will be explained in detail each request below
	}
}
```

## Create checksum
- dataString  = json_encode(**data array**)

- **checksum** = md5(md5(secretKey + dataString) + dataString)
 
## Code Sample
* PHP SDK: [https://github.com/nhanhapi/nhanh.vn](https://github.com/nhanhapi/nhanh.vn) 
* Simple request: send product information

```php
<?php

	$apiUsername = "_YOUR_API_USERNAME_";
	$secretKey = "_YOUR_SECRET_KEY_";

	$dataArray = array(
		// product 1
		array( 
			'id' => '1741235',
			'parentId' => null,
			'code' => 'SSGS2',
			'barcode' => null,
			'name'  => 'Samsung galaxy S2',
			'image' => 'http://example.com/images/samsung-galaxy-s-2.jpg',
			'images' => array(),
			'shippingWeight' => 370, // gram
			'importPrice' => 12000000,
			'price' => 13500000,
			'vat' => 10, // 10%
			'status' => 'Active',
		)
		// product 2
		// ...
	);

	$dataString = json_encode($dataArray);
	$checksum = md5(md5($secretKey . $dataString) . $dataString);

	$postArray = array(
		"version" => "1.0",
		"apiUsername" => $apiUsername,
		"data" => $dataString,
		"checksum" => $checksum
	);

	$curl = curl_init(“https://dev.nhanh.vn/api/product/add”);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postArray);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$curlResult = curl_exec($curl);

	if(! curl_error($curl)) {
		// success
		$response = json_decode($curlResult);
	} else {
		// failed, cannot connect nhanh.vn
		$response = new stdClass();
		$response->code = 0;
		$response->messages = array(curl_error($curl));
	}
	curl_close($curl);

	if ($response->code == 1) {
		// send product successfully
	} else {
		// failed, show error messages
		if(isset($response->messages) && is_array($response->messages)) {
			foreach($response->messages as $message) {
				echo $message;
			}
		}
	}

```
