# Listen inventory updated from Nhanh.vn
- Website của bạn cần đăng kí một URL để nhận thông tin tồn kho cập nhật từ Nhanh.vn (Cập nhật realtime ngay khi số tồn bị thay đổi bên trong Nhanh.vn)

## Request

- Nhanh.vn send a POST request to your listen URL. See [common request params](/docs/api.md#request).
- Decode data string (JSON) to get the data object:


Param|Data type (Max-length)|Description
--------- | ------------ | -------------
storeId|string(20)|id của gian hàng trên các sàn thương mại điện tử các website bình thường không cần quan tâm đến tham số này)
data|string| Xem bảng [Inventory](/docs/inventory/listen.md#inventory) bên dưới
checksum|string(32)|use secretKey and received data param to create<br> the checksum and compare with checksum param.</td>
  
## Inventory
the JSON encoded string: decode this string to get an array:
```js
[         
  {
   “id”: //id sản phẩm trên website của bạn (Nếu sản phẩm được  đồng bộ từ website của bạn sang Nhanh.vn,nên sử dụng id này để tìm sản phẩm cần cần  nhập số tồn).
   “idNhanh”: //id sản phẩm trên Nhanh.vn (Nếu sản phẩm  được đồng bộ từ Nhanh.vn sang website của bạn,sử dụng //isNhanh để tìm sản phẩm tương ứng trên website của bạn để cập nhật số tồn, tình huống này thì id có thể sẽ là null).Số tổng tồn  trên tất cả các kho đang hoạt động
  “remain”: int // số lượng tồn
  “shipping”: int // số lượng đang giao hàng
  “holding”: int // số lượng tạm giữ
  “damage”: int // số lượng lỗi
  “available”: int // số lượng có thể bán, sử dụng số này để hiển thị số tồn trên website hoặc chặn việc đặt các sản phẩm hết hàng.
  // Một mảng số tồn ở từng kho
  “depots”: [
    “depotId” => [
      “remain”: int // số lượng tồn
      “shipping”: int // số lượng đang giao hàng
      “holding”: int // số lượng tạm giữ
      “damage”: int // số lượng lỗi
      “available”: int // số lượng có thể bán, sử dụng số này để hiển thị số tồn trên website hoặc chặn việc đặt các sản phẩm hết hàng.
    ],
    “depotId” => [
    ...
    ],
    ...
  ]
  }
]
```
