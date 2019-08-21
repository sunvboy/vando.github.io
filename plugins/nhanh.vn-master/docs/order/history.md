# /api/order/history 
- Tính năng này dùng để lấy lịch sử thao tác với đơn hàng.

## Request 

- See [common request params](/docs/api.md#request)

- The search param - (Data array)

Param | Data Type |  Mandatory | Description
------- | ---------- | ----------- | --------------
orderId | Int | Yes | ID đơn hàng trên Nhanh.vn
 
 ## Response
 
- JSON decode the response to get the structure:
 
Key | Data Type (Max-length) | Description
----------- | -------------- | -----------
code | int | 1 = success or 0 = failed
messages | array | is an array of error messages if code = 0
data | array | Mảng danh sách lịch sử thao tác của đơn hàng
```js
[
	// history 1
	[
		"step": Hành động,
		"createdBy": Được thao tác bởi ai,
		"createdDateTime": Thời gian thao tác, định dạng yyyy-mm-dd hh:mm:ii
		"oldStatus": Trạng thái trước khi thao tác,
		"newStatus": Trạng thái sau khi thao tác
	]
	// history 2
	// ...
]
```


