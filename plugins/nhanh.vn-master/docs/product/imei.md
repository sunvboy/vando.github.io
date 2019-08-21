# /api/product/imei 
 - Tính năng này dùng để lấy danh sách imei sản phẩm ở trên Nhanh.vn. Dữ liệu sẽ được phân trang, mỗi trang tối đa không quá 100 sản phẩm.
 
 ## Request
 - See [common request params](/docs/api.md#request)
 
 - The search params:

Param | Data Type | Mandatory | Description
--------- | ---------- | ------------ | ----------
page | int | No | Phân trang, giá trị mặc định sẽ là 1.
icpp | int | No| Số lượng sản phẩm trên 1 trang. Tối đa không quá 50. Mặc định nếu không set giá trị gì sẽ là 20.
productId | int  | No | ID sản phẩm /api/product/search
status | int | No | Tìm theo trạng thái IMEI sản phẩm. Giá trị có thể là:<br>1: Mới<br>2: Đã bán <br>3: Đang vận chuyển <br>5: Lỗi <br>6: Đã trả nhà cung cấp<br>8: Đang chuyển kho<br>9: Đang bảo hành<br>10: Đã trả bảo hành
imeiCode | string | No | Tìm chính xác theo mã IMEI 

## Response
JSON decode the response to get the structure:

Key |Data Type(Max-length) | Description
----------- | ---------- | ------------
code | int | 1 = success or 0 = failed
messages | [ ] | is an array of error messages if code = 0
data | [ ] | is an array of product imei list

```js
data = [
	totalPages: int,
	products: [
		{  }, // each product item, all properties are listed in the table below
		...
	]
]
```

Key | Data Type(Max-length) | Description
------- | --------- | -----------
idNhanh | bigint(20) | ID sản phẩm trên Nhanh.vn
merchantProductId | int | ID sản phẩm phi độc quyền (tính năng này chỉ phục vụ cho các sàn TMĐT)
productName | string | Tên sản phẩm
productCode |string | Mã sản phẩm
productBarcode | string | Mã vạch sản phẩm
depotId | int | ID cửa hàng
depotName | string | Tên cửa hàng
imeiCode | string | Imei sản phẩm
price | int | Giá bán sản phẩm
importPrice | int | Giá nhập sản phẩm
description | string | Mô tả sản phẩm
status | int | Trạng thái sản phẩm
statusName | string | Tên trạng thái sản phẩm
warrantyMonths | int | Số tháng bảo hành
extendedWarrantyId | int | ID gói bảo hành mở rộng
extendedWarrantyName | string | Tên gói bảo hành mở rộng
extendedWarrantyMonths | int | Số tháng bảo hành mở rộng
warrantyExpiredDate | date | Ngày hết hạn bảo hành
createdById | int | Người tạo
createdDateTime | date|Ngày tạo
activatedById| int| Người kích hoạt
activatedByDateTime | date | Ngày kích hoạt





