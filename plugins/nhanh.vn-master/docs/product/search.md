# /api/product/search

* Tính năng này dùng để lấy danh sách sản phẩm ở trên Nhanh.vn. Dữ liệu sẽ được phân trang, mỗi trang tối đa không quá 100 sản phẩm.

## Request

* See [common request params](/docs/api.md#request)
* Data structure of search params

| Param | Data Type | Mandatory | Description |
| --- | --- | --- | --- |
| page | int | No | Phân trang, giá trị mặc định sẽ là 1. |
| icpp | int | No | Số lượng sản phẩm trên 1 trang. Tối đa không quá 50. Mặc định nếu không set giá trị gì sẽ là 20. |
| sort | array | No | Sắp xếp kết quả, dữ liệu gửi lên là 1 mảng kiểu \[Tiêu chí sắp xếp =&gt; cách sắp xếp \(asc: tăng dần hoặc desc giảm dần\)\]Giá trị mặc định sẽ là \[id =&gt; desc\].Các tiêu chí có thể là: id: id sản phẩm,price: giá sản phẩm,name: tên sản phẩm,inventory: tồn kho có thể bán |
| name | string | No | Tìm sản phẩm theo tên, mã, mã vạch \(hỗ trợ fulltext search\) |
| parentId | int | No | Tìm theo ID sản phẩm cha. set 0 nếu muốn chỉ trả về các sản phẩm cha. |
| categoryId | int | No | Tìm sản phẩm theo id danh mục sản phẩm, nếu danh mục này có các danh mục con, hệ thống sẽ tìm sản phẩm của toàn bộ danh mục con. |
| status | string | No | Tìm theo trạng thái sản phẩm. Giá trị có thể là: Active: Sản phẩm đăng bán trên website, Inactive: Sản phẩm không đăng bán trên website, OutOfstock: Sản phẩm hết hàng |
| priceFrom | double | No | Tìm theo giá &gt;= |
| priceTo | double | No | Tìm theo giá &lt;= |
| brandId | int | No | Tìm theo thương hiệu |
| imei | string | No | Tìm theo IMEI |

## Response

* JSON decode the response to get the structure:

| Key | Data Type\(Max-length\) | Description |
| --- | --- | --- |
| code | int | 1 = success or 0 = failed |
| messages | \[ \] | is an array of error messages if code = 0 |
| data | \[ \] | is an array of product list |

```js
[
    "totalPages": 30, // int
    "products": [
            { }, // each product item, all properties are listed in the table below
            { }
    ]
]
```

| Key | Data Type\(Max-length\) | Description |
| --- | --- | --- |
| idNhanh | bigint\(20\) | ID sản phẩm trên Nhanh.vn |
| merchantCategoryId | int | ID danh mục sản phẩm trên các site tích hợp \(tính năng này hiện chỉ phục vụ cho các sàn TMĐT\) |
| merchantProductId | int | ID sản phẩm phi độc quyền \(tính năng này chỉ phục vụ cho các sàn TMĐT\) |
| categoryId | int | ID danh mục sản phẩm trên Nhanh.vn |
| parentId | bigint\(20\) | ID sản phẩm cha trên Nhanh.vn |
| code | string\(255\) | Mã sản phẩm |
| name | string\(255\) | Tên sản phẩm |
| otherName | string\(255\) | Tên khác của sản phẩm |
| importPrice | doulbe | Giá nhập |
| oldPrice | double | Giá cũ |
| price | double | Giá bán lẻ |
| wholesalePrice | double | Giá bán buôn |
| vat | int | % thuế giá trị gia tăng \(VD: 10\) |
| image | string\(255\) | Đường dẫn tuyệt đối của ảnh đại diện |
| images | array | Đường dẫn tuyệt đối của các ảnh khác của sản phẩm |
| status | string | Trạng thái của sản phẩm: Active, Inactive, OutOfStock |
| previewLink | string | Link chi tiết của sản phẩm trên website \(if status is Active\) |
| description | string | Mô tả ngắn của sản phẩm |
| highlight | array | Đặc điểm nội bật của sản phẩm |
| content | string | Bài viết chi tiết của sản phẩm |
| showHot | int | \(Giá trị 0 or 1\) Sản phẩm được đánh dấu là sản phẩm hot |
| showNew | int | \(Giá trị 0 or 1\) Sản phẩm được đánh dấu là sản phẩm mới |
| showHome | int | \(Giá trị 0 or 1\) Sản phẩm được đánh dấu hiển thị ở trang chủ |
| width | int | in cm |
| height | int | in cm |
| warrantyAddress | string | Địa chỉ bảo hành |
| warrantyPhone | string | Số điện thoại bảo hành |
| warranty | int | Số tháng bảo hành |
| warrantyContent | string | Nội dung bảo hành |
| length | int | in cm |
| shippingWeight | int | in gram |
| createdDateTime | datetime | định dạng yyyy-mm-dd hh:mm:ss|
| brandId | int | ID thương hiệu|
| brandName  | string   | Tên thương hiệu |
| typeId | int | ID loại sản phẩm |
| typeName   |  string  | Loại sản phẩm |
| avgCost   | double | Giá vốn sản phẩm |
| countryName | string | Xuất xứ | 
| unit | string |  Đơn vị tính|
| importType | int | ID Kiểu nhập kho |
| importTypeLabel   | string   | Tên kiểu nhập kho |
| inventory | array | Xem bảng [Inventory](/docs/product/search.md#inventory) bên dưới |
| attributes | array | Xem bảng [Attributes](/docs/product/search.md#attributes) bên dưới |

#### Inventory

* Tồn kho:

```js
[
    // Tổng tồn trong tất cả các kho
    "remain": int // số lượng tồn kho
    "shipping": int // số lượng đang giao hàng
    "holding": int // số lượng đang tạm giữ
    "damage": int // số lượng lỗi
    "available": int // số lượng có thể bán (sử dụng để hiển thị trên website, chặn đặt hàng khi hết số tồn hoặc vượt quá số tồn).
    "depots": [ // Tồn tại từng kho
        "depotId" => [
            "remain": int // số lượng tồn kho
            "shipping": int //  số lượng đang giao hàng
            "holding": int // số lượng đang tạm giữ
            "damage": int //  số lượng lỗi
            "available": int // số lượng có thể bán (sử dụng để hiển thị trên website, chặn đặt hàng khi hết số tồn hoặcvượt quá số tồn).
        ],
        "depotId" => [
            // ...
        ],
    ]
]
```

#### Attributes

* Thuộc tính sản phẩm:

```js
[
    "size" => [
        "id" => int,
        "name" => string
    ],
    "color" => [
        "id" => int,
        "name" => string,
        "parent" => [ // parent color
            "id" => int,
            "name" => string
        ]
    ]
]
```



