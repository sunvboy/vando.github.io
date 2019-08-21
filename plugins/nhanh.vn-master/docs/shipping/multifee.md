# /api/shipping/multifee 

* Tính năng này dùng để tính phí vận chuyển cho nhiều đơn hàng 1 lần call api. Mỗi khi khách hàng vào trang Giỏ hàng, hoặc ở bước thanh toán, website của bạn có thể call API này để tính phí vận chuyển cho đơn hàng và hiển thị chi tiết tổng tiền của đơn hàng bao gồm cả phí vận chuyển và phí thu tiền hộ (nếu khách hàng chọn hình thức thanh toán khi nhận hàng).

    **Chú ý**: API này dùng cho các sàn thương mại điện tử, giỏ hàng hỗ trợ mua hàng từ nhiều gian hàng, mỗi gian hàng có 1 địa chỉ lấy hàng khác nhau. Nếu website của bạn chỉ hỗ trợ lấy hàng từ 1 địa chỉ, xin vui lòng sử dụng [/api/shipping/fee](/docs/shipping/fee.md). 

## Request

* See [common request params](/docs/api.md#request)

* The structure of data array:
```js
[
    // Đơn hàng 1
    [
        "fromCityName" => "TP. HCM",
        "fromDistrictName" => "Quận 1",
        "toCityName" => "Hà nội",
        "shippingWeight" => 800,
        "toDistrictName" => "Hoàn Kiếm",
        "codMoney" => 1250000
    ],
    // Đơn hàng 2
    [
        "fromCityName" => "TP. HCM",
        "fromDistrictName" => "Quận 3",
        "toCityName" => "Hà nội",
        "shippingWeight" => 2000, // 2000 gr = 2 kg
        "toDistrictName" => "Hoàn Kiếm",
        "codMoney" => 4950000
    ]
]
```

**Chú ý:** Hỗ trợ tối đa tính phí cho 10 đơn hàng cùng lúc.


Param | Data type (Max-length) | Mandatory | Description
--------- | ------------ | ----------- | -----------
fromCityName | string | Yes | Tên thành phố của kho gửi hàng (Lấy từ [/api/shipping/location](/docs/shipping/location.md))  
fromDistrictName| string | Yes | Tên quận huyện của kho gửi hàng (Lấy từ [/api/shipping/location](/docs/shipping/location.md))
toCityName | string | Yes | Tên thành phố của khách nhận hàng (Lấy từ [/api/shipping/location](/docs/shipping/location.md)) 
toDistrictName | string | Yes| Tên quận huyện của khách nhận hàng (Lấy từ [/api/shipping/location](/docs/shipping/location.md))
codMoney | int | No | Giá trị của đơn hàng (Tổng giá nhân số lượng sản phẩm trong đơn hàng) dùng để tính phí thu tiền hộ, set 0 nếu đơn hàng này không cần thu tiền hộ (VD tình huống khách đã chuyển khoản trước)
shippingWeight | int | No | Tổng trọng lượng của đơn hàng tính bằng gram (Tổng toàn bộ shipping weight của các sản phẩm trong đơn hàng). Hiện tại Nhanh.vn hỗ trợ đơn hàng tối đa 100000 gr (100 kg).
productIds | array | No | Danh sách các ID sản phẩm được đồng bộ từ Nhanh.vn sang website của bạn (idNhanh), dùng để tính khối lượng đơn hàng theo giá trị sản phẩm khai báo bên Nhanh.vn.
carrierIds | array | No |Dùng để giới hạn các hãng vận chuyển muốn dùng (Lấy từ [/api/shipping/carrier](/docs/shipping/carrier.md)). VD: [5,7,8,9]
length | int |No | Chiều dài gói hàng tính theo cm (Dùng cho hàng cồng kềnh, có kích thước >= 30cm).
width | int | No | Chiều rộng gói hàng tính theo cm (Dùng cho hàng cồng kềnh, có kích thước >= 30cm).
height | int | No | Chiều cao gói hàng tính theo cm (Dùng cho hàng cồng kềnh, có kích thước >= 30cm).

 **API này có 2 tình huống:**
  - Website của bạn tự tính tổng trọng lượng **shippingWeight**  của đơn hàng này.
  - Nếu các sản phẩm được đồng bộ từ Nhanh.vn sang website của bạn (Nhanh.vn đã có thông tin **shippingWeight** của các sản phẩm này): website của bạn có thể gửi sang 1 mảng **productIds**, Nhanh.vn sẽ tự tính toán tổng trọng lượng của đơn hàng này.
  
  **Chú ý**: nếu bạn có truyền sang các tham số **length**, **width**, **height**: Nhanh.vn sẽ tính toán trọng lượng của đơn hàng theo công thức quy ra kg: A = dài * rộng * cao / 6000 (so sánh số A và **shippingWeight** tham số nào lớn hơn sẽ lấy theo tham số đó để tính toán cước phí) và trả về kết quả đánh dấu nếu gói hàng thuộc loại hàng cồng kềnh.
  
  
Key | Data Type(Max-length) | Description
------ | ------------ | ------------ | ----------
code | int | 1 = success or 0 = failed
messages | array | is an array of error messages if code = 0
data | array | is an array of all supported shipping services

## Response
  - The response: JSON decode the response to get the structure:
```js
[
	// kết quả tính phí cho đơn hàng 1
	[	
		{
			"carrierId": int // id hãng vận chuyển
			"carrierName": string // tên hãng vận chuyển
			"serviceId": int // id dịch vụ vận chuyển
			"serviceName": string // tên dịch vụ vận chuyển
			"serviceDescription": string // mô tả dịch vụ vận chuyển
			"estimatedDeliveryTime": int // Thời gian dự kiến giao hàng
			"shipFee": int // phí vận chuyển
			"codFee": int // phí thu tiền hộ
			"shipFeeDiscount": int // phí vận chuyển được giảm giá
			"codFeeDiscount": int // phí thu tiền hộ được giảm giá
			"isBulkyGoods": 1 | 0 // Biến đánh dấu hàng cồng kềnh
		}
		// ...
	],
	// kết quả tính phí cho đơn hàng 2
	[	
		{
			"carrierId": int // id hãng vận chuyển
			"carrierName": string // tên hãng vận chuyển
			"serviceId": int // id dịch vụ vận chuyển
			"serviceName": string // tên dịch vụ vận chuyển
			"serviceDescription": string // mô tả dịch vụ vận chuyển
			"estimatedDeliveryTime": int // Thời gian dự kiến giao hàng
			"shipFee": int // phí vận chuyển
			"shipFeeDiscount": int // phí vận chuyển được giảm
			"codFee": int // phí thu tiền hộ
			"codFeeDiscount": int // phí thu tiền hộ được giảm
			"isBulkyGoods": 1 | 0 // Biến đánh dấu hàng cồng kềnh
		}
		// ...
	]
	// kết quả tính phí cho các đơn hàng tiếp theo
]
``` 

 **Chú ý**:
   - **shipFeeDiscount** là phí vận chuyển được chiết khấu, VD **shipFee** = 25.000, **shipFeeDiscount** = 7.000 thì **shipFee** thực tế của đơn hàng này sẽ chỉ = 18.000
   - **codFeeDiscount** là phí thu tiền hộ được chiết khấu, VD **codFee** = 15.000, **codFeeDiscount** = 3.000 thì **codFee** thực tế của đơn hàng này sẽ chỉ = 12.000

  




