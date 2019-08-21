# /api/bill/imexs

* Tính năng này dùng để lấy danh sách phiếu XNK của doanh nghiệp.

## Request

See [common request params](/docs/api.md#request)

The search param - \(Data array\)

| Param |  | Mandatory | Description |
| --- | --- | --- | --- |
| page | Int | No | Phân trang \(giá trị mặc định là 1\) |
| icpp | Int | No | Số lượng sản phẩm trên 1 trang. Mặc định là 10. Tối đa không quá 20. |
| fromDate | string | No | Định dạng yyyy-mm-dd. Ngày XNK. |
| toDate | string | No | Định dạng: yyyy-mm-dd. Ngày XNK. |
|id	|Int	|No	|ID sản phẩm xuất nhập kho|
|billId	|Int	|No	|ID phiếu xuất nhập kho|
|type	|Int	|No	|Tìm kiếm theo [loại XNK](/docs/glossary.md#inventory)|
|mode	|Int	|No	|Tìm kiếm theo [kiểu XNK](/docs/glossary.md#inventory)|
|depotId	|Int	|No	|ID kho|
|relatedDepotId	|Int	|No	|ID kho liên quan|
|supplierId	|Int	|No	|ID nhà cung cấp|
|productStoreId	|Int	|No	|ID sản phẩm xuất nhập kho|
|productStoreName	|string	|No	|Tên (mã, mã vạch) sản phẩm xuất nhập kho|
|relatedProductStoreId	|Int	|No	|ID sản phẩm XNK liên quan|
|categoryId	|Int	|No	|ID danh mục sản phẩm|
|internalCategoryId	|Int	|No	|ID danh mục nội bộ sản phẩm|
|brandId	|Int	|No	|ID thương hiệu sản phẩm|
|productStoreTypeId	|Int	|No	|Loại sản phẩm: <br>1: Sản phẩm<br>2: Voucher<br>3: Sản phẩm cân đo<br>4: Sản phẩm theo IMEI<br>5: Gói sản phẩm<br>6: Dịch vụ |
|imeiId	|Int	|No	|Imei Id
|imei	|string	|No	|Số imei
|warrantyBillId	|Int	|No	|ID phiếu bảo hành

## Response

JSON decode the response to get the structure:

| Key | Data Type\(Max-length\) | Description |
| --- | --- | --- |
| code | int | 1 = success or 0 = failed |
| messages | \[ \] | is an array of error messages if code = 0 |
| data | \[ \] | Mảng danh sách sản phẩm yêu cầu xuất nhập kho |

```js
data = [
    totalPage: Tổng số trang,
    page: Trang hiện tại,
    Imexs: [
        id: ID phiếu sản phẩm xuất nhập kho,
        billId: ID phiếu xuất nhập kho,
        type: Loại xuất nhập kho,
        typeName: Tên loại xuất nhập kho,
        mode: Kiểu xuất nhập kho,
        modeName: Tên kiểu xuất nhập kho,
        date: Ngày xuất nhập kho,
        depotId: ID kho,
        depotName: Tên kho,
        relatedDepotId: ID kho liên quan,
        relatedDepotName: Tên kho liên quan
        supplierId: ID nhà cung cấp,
        supplierName: Tên nhà cung cấp,
        supplierMobile: Số điện thoại nhà cung cấp,
        productStoreId: ID sản phẩm xuất nhập kho,
        relatedProductStoreId: ID sản phẩm xuất nhập kho,
        proudctStore: [
            code: Mã sản phẩm,
            barcode: Mã vạch sản phẩm,
            name: tên sản phẩm,
            importPrice: Giá nhập sản phẩm,
            price: Giá bán sản phẩm,
            avgCost: Giá vốn sản phẩm
        ]
        imeiId: Imei Id,
        imei: Số imei sản phẩm,
        avgCost: Giá vốn sản phẩm trong lần xuất nhập kho,
        productPrice: Giá sản phẩm trong lần xuất nhập kho,
        remain: Số tồn còn lại tính tới lần xuất nhập kho,
        description: Mô tả trong lần xuất nhập kho,
        discount: Chiết khấu trong lần xuất nhập kho,
        points: Số point được tặng trong lần xuất nhập kho của sản phẩm ,
        usedPoints: Số point đã tiêu trong lần xuất nhập kho của sản phẩm,
        createdDateTime: Thời gian tạo phiếu xuât nhập kho,
        saleBonus: Tiền hoa hồng nhân viên bán hàng được hưởng với sản phẩm,
        extendedWarrantyId: Id bảo hành mở rộng,
        extendedWarrantyMoney: Tiền bảo hành mở rộng,
        extendedWarrantyMonths: Số tháng bảo hành mở rộng,
        warrantyReasonId: Id lý do bảo hành
    ],
    ….
    [...]
]
```



