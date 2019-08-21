# /api/bill/imexrequirements

- Tính năng này dùng để lấy danh sách sản phẩm yêu cầu xuất nhập kho của doanh nghiệp.

## Request
- See [common request params](/docs/api.md#request)
 
- The search param - (Data array)

Param | | Mandatory | Description 
-------- | ------- | --------- | -------
page | Int | No | Phân trang (giá trị mặc định là 1)
icpp | Int | No | lượng sản phẩm trên 1 trang. Mặc định là 10. Tối đa không quá 20.
fromDate | string | No | Định dạng: Ngày/Tháng/Năm. Ngày tạo phiếu yêu cầu (hoặc ngày duyệt yêu cầu)
toDate | string | No | Định dạng: Ngày/Tháng/Năm. Ngày tạo phiếu yêu cầu (hoặc ngày duyệt yêu cầu)
id | Int | No | ID phiếu sản phẩm yêu cầu xuất nhập kho
billId | Int |  No | ID phiếu yêu cầu xuất nhập kho
type | Int |No | Loại xuất nhập kho
mode | Int | No | Kiểu xuất nhập kho
fromDepotId | Int | No | Id kho xuất đi
toDepotId | Int | No | Id kho nhận
supplierId | Int | No | Id nhà cung cấp
productStoreId | Int |No | Id sản phẩm yêu cầu xuất nhập kho
productStoreName | string | No | Tên (mã, mã vạch) sản phẩm yêu cầu xuất nhập kho
categoryId | Int | No  | Id danh mục sản phẩm
brandId | Int| No | Id thương hiệu sản phẩm
productStoreTypeId| Int | No | Loại sản phẩm: <br>1: Sản phẩm <br> 2: Voucher <br> 3: Sản phẩm cân đo <br> 4: Sản phẩm theo IMEI <br> 5: Gói sản phẩm <br>6: Dịch vụ
imeiId | Int | No | Imei Id
imei | string | No | Số imei
requiredById | Int | No | Người tạo phiếu yêu cầu
approvedById | Int | No | Người duyệt phiếu yêu cầu
status | Int | No | Trạng thái phiếu: <br>1: Mới<br>2: Hủy<br>3: Đã duyệt<br>4: Đã xác nhận<br>5: Cần đối soát lại<br>6: Đã đối soát

## Response
JSON decode the response to get the structure:

Key | Data Type(Max-length) | Description
--------- | ------------ |----------
code | int | 1 = success or 0 = failed
messages | [ ] | is an array of error messages if code = 0
data | [ ] | Mảng danh sách sản phẩm yêu cầu xuất nhập kho

```js
data = [
    totalPage: Tổng số trang,
	page: Trang hiện tại,
	Imexs: [
		id: ID phiếu sản phẩm yêu cầu xuất nhập kho,
		billId: ID phiếu yêu cầu xuất nhập kho,
		type: Loại xuất nhập kho,
		typeName: Tên loại xuất nhập kho,
		mode: Kiểu xuất nhập kho,
		modeName: Tên kiểu xuất nhập kho,
		fromDepotId: ID kho xuất,
		fromDepotName: Tên kho xuất,
		toDepotId: ID kho nhận,
		toDepotName: Tên kho nhận
		supplierId: ID nhà cung cấp,
		supplierName: Tên nhà cung cấp,
		supplierMobile: Số điện thoại nhà cung cấp,
		productStoreId: ID sản phẩm yêu cầu xuất nhập kho,
		proudctStore: [
			code: Mã sản phẩm,
			barcode: Mã vạch sản phẩm,
			name: tên sản phẩm,
			importPrice: Giá nhập sản phẩm,
			price: Giá bán sản phẩm
		]
		imeiId: Imei Id,
		imei: Số imei sản phẩm,
		requiredQuantity: Số lượng sản phẩm yêu cầu,
		damagedQuantity: Số lượng sản phẩm hỏng,
		requiredImportPrice: Giá nhập sản phẩm yêu cầu,
		requiredPrice: Giá sản phẩm yêu cầu,
		requiredById: ID người lập phiếu yêu cầu,
		requiredByUser: Tên người nhập phiếu yêu cầu,
		requiredDateTime: Thời gian tạo phiếu yêu cầu ,
		approvedQuantity: Số lượng sản phẩm yêu cầu được duyệt,
		approvedImportPrice: Giá nhập sản phẩm yêu cầu được duyệt,
		approvedPrice: Giá sản phẩm yêu cầu được duyệt,
		approvedDescription: Mô tả của người duyệt yêu cầu,
		approvedById: ID người duyệt yêu cầu,
		approvedByUser: Tên người duyệt yêu cầu,
		approvedDateTime: Thời gian duyệt yêu cầu,
		realQuantity: Số lượng sản phẩm yêu cầu được xác nhận,
		realDateTime: Thời gian sản phẩm yêu cầu được xác nhận,
		status: id trạng thái sản phẩm yêu cầu,
		statusName: Tên trạng thái
	],
	….
	[...]
]
```
