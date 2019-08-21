# /api/product/add

- Tính năng này dùng để gửi thông tin sản phẩm từ website của bạn sang Nhanh.vn.

## Request
- See [common request params](/docs/api.md#request)

- The **data array**:

```js
// each request can send maximum 300 products
[
	[product 1], // see the structure in the table below
	[product 2],
	// ...
]
```

Key | Data type | Mandatory | Description
----------- | -------- | -------- | -----------
id| string(20) | Yes | id của sản phẩm
idNhanh | bigint | No | id sản phẩm trên Nhanh.vn ([idNhanh đồng bộ từ Listen product updated from Nhanh.vn](/docs/product/listen.md))
code | string(255) | No | Mã sản phẩm
barcode | string(20) | No | Mã vạch của sản phẩm
name | string(255) | Yes | Tên sản phẩm
image | string(255) | No | Ảnh đại diện của sản phẩm. Đường dẫn ảnh là đường dẫn tuyệt đối, VD: http://example.com/images/samsung-galaxy-s-2.jpg
images | array | No | Các ảnh khác của sản phẩm, đường dẫn ảnh là địa chỉ tuyệt đối.
shippingWeight | int| No |Cân nặng cả vỏ hộp tính bằng gram, được sử dụng để tính phí vận chuyển khi đặt hàng.
vat |int  | No | % thuế giá trị gia tăng (VD: 10)
price | int | Yes | Giá bán của sản phẩm
importPrice | int | No | Giá nhập của sản phẩm
wholesalePrice | int | No | Giá bán buôn của sản phẩm
status | string | No | Trạng thái của sản phẩm: Active or Inactive

## Response: 
The response: JSON decode the response to get the structure:
```js
[
	"ids" => [
		"id sản phẩm website tích hợp 1" => "id sản phẩm trên Nhanh 1",
		"id sản phẩm website tích hợp 2" => "id sản phẩm trên Nhanh 2",
		...
	]
	"barcodes" => [
		"id sản phẩm website tích hợp 1" => "mã vạch sản phẩm trên Nhanh 1",
		"id sản phẩm website tích hợp 2" => "mã vạch sản phẩm trên Nhanh 2",
		...
	]
]
```
