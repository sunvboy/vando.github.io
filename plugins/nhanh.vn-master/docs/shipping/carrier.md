# /api/shipping/carrier

- Tính năng này dùng để lấy danh sách các hãng vận chuyển đang được tích hợp với Nhanh.vn. Nhanh.vn đang kết nối với Viettel Post, Vietnam Post, Giaohangnhanh, Giaohangtietkiem, EcoTrans... để hỗ trợ dịch vụ vận chuyển và giao hàng thu tiền tận nhà. Tình huống chủ doanh nghiệp chỉ muốn dùng một vài hãng vận chuyển nào đó, thì website của bạn có thể sử dụng tính năng này để lọc các **carrierId** (id của các hãng vận chuyển) được trả về từ API “Get shipping fee”.

## Request
- See [common request params](/docs/api.md#request)
- Fixed dataString = "carriers"

## Response

```js
[
	// carrier 1
	{
		"id": 2, // int: id hãng vận chuyển trên Nhanh.vn
		"name": "Vietnam Post", // string: tên hãng vận chuyển trên Nhanh.vn,
		"logo": "absolute path of carrier’s logo",
		"businessName": "Tổng công ty Bưu Điện Việt Nam",	
		"services": [ // các dịch vụ vận chuyển
			{
				"id": 2, // int: id dịch vụ
				"name": "Giao nhanh liên tỉnh" // Tên dịch vụ vận chuyển
			},
			{
				"id": 3, // int: id dịch vụ
				"name": "Bưu kiện" // Tên dịch vụ vận chuyển
 			}
 			// ...
		]
	}
	// carrier 2
	// ...
]
```




