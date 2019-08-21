# Common errors

Một số lỗi thường gặp

## Authentication failed

Nếu bạn nhận được response lỗi: authentication failed, xin vui lòng kiểm tra lại các mục sau:

- Kiểm tra lại các thông số apiUsername, secretKey, environment (dev / production).

- Trong code có set biến storeId, biến này chỉ dùng cho các sàn thương mại điện tử có nhiều gian hàng, các website bình thường cần set biến này về null.

## Invalid checksum

- Khi bạn call API của Nhanh, lỗi này thường do nhầm lẫn giữa 
      Development Secret Key và Production Secret Key
      Development Server (https://dev.nhanh.vn) và Production Server (https://graph.nhanh.vn)
- Khi Nhanh.vn gửi data sang website của bạn, bạn có thể gặp phải lỗi ở đoạn kiểm tra tính hợp lệ của checksum:
```php
if (!$service->isValidChecksum($checksum, $data)) {
	echo 'Invalid checksum';
	return;
}
```
Nếu web server của bạn đang sử dụng magic quote thì các request nhận được từ nhanh sẽ bị tự động thêm các kí tự \\ (đọc thêm về magic quote tại đây http://php.net/manual/en/security.magicquotes.what.php) nên [checksum](/docs/api.md#create-checksum) sẽ luôn bị báo  sai. 

- Cách xử lý: http://docs.php.net/manual/en/security.magicquotes.disabling.php 
```php
if(ini_get("magic_quotes_runtime")) {
    $data = stripslashes($data);
}
```

## SSL certificate problem

**SSL certificate problem: unable to get local issuer certificate**

Bạn có thể thử 1 trong các cách sau:
- Tải file http://curl.haxx.se/ca/cacert.pem mở file php.ini của web server, add setting
```php
    curl.cainfo=<path-to>cacert.pem
```
Restart web server.

- Mở file NhanhService.php
Hàm sendRequest add thêm dòng 
```php
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
```
ngay trước dòng 
```php
$curlResult = curl_exec($curl);
```








