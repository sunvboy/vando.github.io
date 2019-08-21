# /api/bill/search

* Tính năng này dùng lấy danh sách phiếu XNK (hóa đơn nhập nhà cung cấp, bán lẻ, bán buôn, chuyển kho, kiểm kho) của doanh nghiệp.

## Request

* See [common request params](/docs/api.md#request)

* The search param - \(Data content\)

| Param |  | Mandatory | Description |
| --- | --- | --- | --- |
| page | int | No | Phân trang \(giá trị mặc định là 1\) |
| icpp | int | No | Số lượng đơn hàng trên 1 trang. Mặc định là 10. Tối đa không quá 20. |
| id | int | No | Tìm kiếm theo ID phiếu XNK |
| type | int | No | Tìm kiếm theo [loại XNK](/docs/glossary.md#inventory) |
| mode | int | No | Tìm kiếm theo [kiểu XNK](/docs/glossary.md#inventory) |
| modes | array | No | Tìm kiếm theo [kiểu XNK](/docs/glossary.md#inventory) |
| customerId | int | No | Tìm kiếm theo ID khách hàng |
| customerMobile | string| No | Tìm kiếm theo số điện thoại khách hàng |
| fromDate | date | No | Tìm kiếm ngày XNK &gt;= fromeDate. Format yyyy-mm-dd \(.e.g. 2015-07-16\) |
| toDate | date | No | Tìm kiếm ngày XNK =&lt; toDate Format yyyy-mm-dd \(.e.g. 2015-08-16\) |

## Response

JSON decode the response to get the structure:

| Key | Data Type \(Max-length\) | Description |
| --- | --- | --- |
| code | int | 1 = success or 0 = failed |
| messages | \[ \] | is an array of error messages if code = 0 |
| data | \[ \] | is an array of customer list |

```js
[
    "totalPages": int,
    "bill": [
            {  }, // each bill item, all properties are listed in the table below
            {  }
    ]
]
```

| Key | Data Type (Max-length) | Description |
| --- | --- | --- |
| id | int | ID của hóa đơn |
| date| date | Ngày xuất nhập kho (format: yyyy-mm-dd) |
| createdDateTime | datetime | Ngày giờ tạo hóa đơn (format: yyyy-mm-dd h:i:s) |
| type | int | Xem [Loại XNK](/docs/glossary.md#inventory) |
| mode | int | Xem [Kiểu XNK](/docs/glossary.md#inventory) |
| depotId | int | ID kho doanh nghiệp |
| customerId | int | ID khách hàng mua hàng, có thể sử dụng để đồng bộ với ID khách hàng trong [/api/customer/search](/docs/customer/search.md) |
| customerId | int | ID khách hàng |
| customerName | string | Tên khách hàng |
| customerMobile | string | Số điện thoại khách hàng |
| saleId | int | ID nhân viên bán hàng |
| saleName | string | Nhân viên bán hàng |
| createdById | int | ID nhân viên thu ngân |
| createdByName | string | Nhân viên thu ngân |
| discount | double | Chiết khấu hóa đơn |
| money | double | Tổng tiền hóa đơn |
| saleBonus | double | Hoa hồng bán hàng
| payment | double | Tổng tiền đã thanh toán |
| relatedBillId | int | ID hóa đơn được trả hàng| 
| relatedUserName | string | Người tạo hóa đơn được trả hàng|
| technicalId | int | Id nhân viên kỹ thuật |
| technicalName | string | Tên nhân viên kỹ thuật |
| products | array | Danh sách sản phẩm theo hóa đơn \[Xem bảng bên dưới\] |

* Products: Danh sách sản phẩm XNK trong phiếu

| Key | Data Type (Max-length) | Description |
| --- | --- | --- |
| id | int | ID của sản phẩm |
| code | string | Mã code của sản phẩm |
| name | string | Tên sản phẩm |
| quantity | float | Số lượng sản phẩm |
| price | double | Giá sản phẩm |
| discount | double | Chiết khấu của sản phẩm |
| imei | string | IMEI của sản phẩm. Nếu sản phẩm tồn tại IMEI sẽ hiện thêm trường này. |




