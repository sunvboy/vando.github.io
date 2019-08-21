# Listen info when customer add order from Nhanh.vn 
- Website của bạn cần đăng kí một URL để nhận thông tin khi khách hàng đặt đơn hàng từ Nhanh.vn hoặc từ website của bạn. (Cập nhật realtime ngay khi khách hàng đặt đơn hàng từ Nhanh.vn hoặc từ website của bạn)

# Request

- Nhanh.vn send a POST request to your listen URL. See [common request params](/docs/api.md#request).
- Decode data string (JSON) to get the data object:

| Param | Data type (Max-length) | Description| 
| --- | ---- | ---- | 
 |storeId | String (20)| id của gian hàng trên các sàn thương mại điện tử (các website bình thường không cần quan tâm đến tham số này)|
 | data|string |Json encoded string: json_decode chuỗi này được một mảng: xem bên dưới |
 | checksum| String (32)|Sử dụng secretKey và data nhận về để tạo checksum và so sánh với tham số checksum.|

Mảng data 
```
[
    “orderId”: ID đơn hàng,
    “customerMobile”: Số điện thoại khách hàng,
    “type”: addOrder,
    “totalAmount”:  Giá trị đơn hàng,
    “discount”:  Tiền chiết khấu,
    “addPoint”: Số điểm được tặng,
    “subtractPoint”: Số điểm đã sử dụng cho đơn hàng,
    “depotName”: Tên cửa hàng khách hàng mua,
    “billType”: export (mua hàng) hoặc import (trả hàng)       
]
```
