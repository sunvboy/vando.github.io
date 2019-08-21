# Listen product data

- Mỗi website cần đăng kí 1 URL để nhận cập nhật thông tin sản phẩm từ Nhanh.vn (cập nhật realtime khi sản phẩm được thêm, sửa trong Nhanh.vn). Để sử dụng tính năng này, website của bạn phải thêm 1 trường để lưu **idNhanh** ứng với từng sản phẩm được đồng bộ từ Nhanh.vn sang, mỗi khi nhận được 1 request từ Nhanh, website sử dụng **idNhanh** để kiểm tra xem sản phẩm này đã tồn tại hay chưa để áp dụng việc thêm mới hoặc cập nhật thông tin sản phẩm tương ứng theo key **idNhanh**.

## Request

- Nhanh.vn send a POST request to your listen URL. See [common request params](/docs/api.md#request).
- Decode data string (JSON) to get the data object:



Key | Data Type (Max-length) | Description
-- |----------- |--------
idNhanh | bigint(20) | ID sản phẩm trên Nhanh.vn
merchantCategoryId | int | ID danh mục sản phẩm trên các site tích hợp (tính năng này hiện chỉ phục vụ cho các sàn TMĐT)
merchantProductId | int | ID sản phẩm trên sàn (tính năng này chỉ phục vụ cho các sàn TMĐT)
categoryId | int | ID danh mục sản phẩm trên Nhanh.vn
brandId |int|ID thương hiệu sản phẩm trên Nhanh.vn
parentId|bigint(20)|ID sản phẩm cha trên Nhanh.vn
id|string(20)|ID sản phẩm từ website của bạn gửi sang. (Nếu website của bạn có tích hợp Send product information: [/api/product/add](/docs/product/add.md) Nhanh.vn sẽ lưu ID sản phẩm này được gửi từ website của bạn, khi thông tin sản phẩm được cập nhật trên Nhanh.vn, Nhanh API sẽ gửi dữ liệu tới website của bạn, và đây chính là id sản phẩm được gửi từ website của bạn).
code|string(255)|Mã sản phẩm
name|string(255)|Tên sản phẩm
price|double|<p></p>
vat |int|% thuế giá trị gia tăng (thường là 10)
image|string(255)|Đường dẫn tuyệt đối của ảnh đại diện sản phẩm
images|array|Một mảng các đường dẫn tuyệt đối các ảnh khác của sản phẩm.
status|string|Trạng thái sản phẩm: Active or Inactive
commodityStatus|string|Tình trạng hàng hóa, các giá trị có thể là:<br>New: Hàng mới<br>Old: Hàng cũ
commoditySource | string|Nguồn hàng, các giá trị có thể là:<br>Company: Hàng công ty<br>Genuine: Hàng chính hãng<br>PortableGoods: Hàng xách tay
previewLink|string|Link hiển thị trên website của sản phẩm này (if status is Active)
description|string|Mô tả ngắn của sản phẩm
advantages|string|Đặc điểm nổi bật của sản phẩm
content|string|Bài viết chi tiết của sản phẩm
width|int|in cm
height|int|in cm
length|int|in cm
shippingWeight|int|in gram
createdDateTime|datetime|format yyyy-mm-dd hh:mm:ss
inventory|array| Xem bảng [Inventory](/docs/product/listen.md#inventory) bên dưới
attributes|array | Xem bảng [Attributes](/docs/product/listen.md#attributes) bên dưới
promotionValue | int | Giá trị khuyến mại (Điền ở thông tin sản phẩm)
promotionContent | string | Mô tả khuyến mại (Điền ở thông tin sản phẩm)

## Inventory
Một mảng thông tin tồn kho của sản phẩm:
```js
[
    // Số tổng tồn trên tất cả các kho đang hoạt động
    
    “remain”: int // số lượng tồn
    “shipping”: int // số lượng đang giao hàng
    “holding”: int // số lượng tạm giữ
    “damage”: int // số lượng hàng lỗi
    “available”: int // số lượng có thể bán, sử dụng số này để hiển thị số tồn trên website hoặc chặn việc đặt các sản phẩm hết hàng.
    
    // số tồn chi tiết trong từng kho
    
    “depots”: [
        “depotId” => [
        “remain”: int // số lượng tồn
        “shipping”: int // số đang giao hàng
        “holding”: int // số lượng tạm giữ
        “damage”: int // số lượng lỗi
        “available”: int // số lượng có thể bán, sử dụng số này để hiển thị số tồn trên website hoặc chặn việc đặt các sản phẩm hết hàng.
        
        ],
    
        “depotId” => [
        ...
        ],
        ...
    ]
    
]

```

## Attributes
```js
[
    size => [
        id => int,
        name => string
    ],
    color => [
        id => int,
        name => string,
        parent => [ // parent color
        id => int,
        name => string
        ]
    ]
]
```
