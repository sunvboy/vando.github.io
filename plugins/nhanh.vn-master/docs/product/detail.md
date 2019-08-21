# /api/product/detail 
- Tính năng này dùng để lấy thông tin chi tiết của sản phẩm. Nếu sản phẩm được đồng bộ từ Nhanh.vn sang website của bạn, đôi khi bạn sẽ muốn lấy thêm thông tin chi tiết của sản phẩm đó.

## Request
- See [common request params](/docs/api.md#request)

- The search param: data = array ( [NhanhProductId](https://github.com/nhanhapi/nhanh.vn/blob/master/src/get/product.php) )

## Response

JSON decode the response to get the structure:

Key | Data Type(Max-length) | Description 
---- | ---- | --------
 code | int | 1 = success or 0 = failed
messages | [ ] | is an array of error messages if code = 0
data | [ ] | is an array of the parent and all child products (if the requested has child products)
 
```js
data = [
	{
		// all properties are listed in the table below
	},
	... 
]
```
<table> 
    <tr>
        <th>Key</th>
        <th>Data Type(Max-length)</th>
        <th>Description</th>
    </tr>
     <tr>
        <td>idNhanh</td>
        <td>bigint(20)</td>
        <td>ID sản phẩm trên Nhanh.vn</td>
    </tr>
     <tr>
        <td>merchantCategoryId</td>
        <td>int</td>
        <td>ID danh mục sản phẩm trên các site tích hợp <br> (tính năng này hiện chỉ phục vụ cho các sàn TMĐT)
    </td>
    </tr>
     <tr>
        <td>merchantProductId</td>
        <td>int</td>
        <td>ID sản phẩm phi độc quyền <br>(tính năng này chỉ phục vụ cho các sàn TMĐT)</td>
    </tr>
     <tr>
        <td>categoryId</td>
        <td>int</td>
        <td>ID danh mục sản phẩm trên Nhanh.vn</td>
    </tr>
    <tr>
        <td>parentId</td>
        <td>bigint(20)</td>
        <td>ID sản phẩm cha trên Nhanh.vn</td>
    </tr> <tr>
        <td>code</td>
        <td>string(255)</td>
        <td>Mã sản phẩm</td>
    </tr>
    <tr>
        <td>barcode</td>
        <td>string(255)</td>
        <td>Mã vạch sản phẩm</td>
    </tr>
     <tr>
        <td>name</td>
        <td>string(255)</td>
        <td>Tên sản phẩm</td>
    </tr> 
    <tr>
        <td>otherName</td>
        <td>string(255)</td>
        <td>Tên khác của sản phẩm</td>
    </tr> 
    <tr>
        <td>importPrice</td>
        <td>double</td>
        <td>Giá nhập</td>
    </tr>
     <tr>
        <td>oldPrice</td>
        <td>double</td>
        <td>Giá cũ</td>
    </tr>
     <tr>
        <td>price</td>
        <td>double</td>
        <td>Giá bán lẻ</td>
    </tr>
     <tr>
        <td>wholesalePrice</td>
        <td>double</td>
        <td>Giá bán buôn</td>
    </tr>
     <tr>
        <td>vat</td>
        <td>int</td>
        <td>% thuế giá trị gia tăng (VD: 10)</td>
    </tr>
     <tr>
        <td>image</td>
        <td>string(255)</td>
        <td>Đường dẫn tuyệt đối của ảnh đại diện</td>
    </tr> 
    <tr>
        <td>images</td>
        <td>array</td>
        <td>Đường dẫn tuyệt đối của các ảnh khách của sản phẩm</td>
    </tr> <tr>
        <td>status</td>
        <td>string</td>
        <td>Trạng thái của sản phẩm: Active | Inactive | OutOfStock</td>
    </tr>
    <tr>
        <td>previewLink</td>
        <td>string</td>
        <td>Link chi tiết của sản phẩm trên website (if status is Active)</td>
    </tr>
     <tr>
        <td>description</td>
        <td>string  </td>
        <td>Mô tả ngắn của sản phẩm</td>
    </tr>
     <tr>
        <td>highlight</td>
        <td>array</td>
        <td>Đặc điểm nội bật của sản phẩm</td>
    </tr>
     <tr>
        <td>content</td>
        <td>string</td>
        <td>Bài viết chi tiết của sản phẩm</td>
    </tr>
     <tr>
        <td>showHot</td>
        <td>int</td>
        <td>(Giá trị 0 | 1) Sản phẩm được đánh dấu là sản phẩm hot</td>
    </tr>
     <tr>
        <td>showNew</td>
        <td>int</td>
        <td>(Giá trị 0 | 1) Sản phẩm được đánh dấu là sản phẩm mới</td>
    </tr>
     <tr>
        <td>showHome</td>
        <td>int</td>
        <td>(Giá trị 0 | 1) Sản phẩm được đánh dấu hiển thị ở trang chủ</td>
    </tr>
     <tr>
        <td>width</td>
        <td>int</td>
        <td>in cm</td>
    </tr>
     <tr>
        <td>height</td>
        <td>int</td>
        <td>in cm</td>
    </tr>
     <tr>
        <td>warrantyAddress</td>
        <td>string</td>
        <td>Địa chỉ bảo hành</td>
    </tr>
     <tr>
        <td>warrantyPhone</td>
        <td>string</td>
        <td>Số điện thoại bảo hành </td>
    </tr>
     <tr>
        <td>warranty</td>
        <td>int</td>
        <td>Số tháng bảo hành </td>
    </tr> <tr>
        <td>warrantyContent</td>
        <td>string</td>
        <td>Nội dung bảo hành </td>
    </tr> <tr>
        <td>length</td>
        <td>int</td>
        <td>in cm</td>
    </tr> <tr>
        <td>shippingWeight</td>
        <td>int</td>
        <td>in gram</td>
    </tr> 
    <tr>
        <td>createdDateTime</td>
        <td>datetime</td>
        <td>Định dạng: yyyy-mm-dd hh:mm:ss</td>
    </tr>
    <tr>
        <td>inventory</td>
        <td>array</td>
        <td>Thông tin tồn kho: xem ở bảng Inventory bên dưới</td>
    </tr>
    <tr>
        <td>attributes</td>
        <td>array</td>
        <td>
 <pre lang="php">
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
</pre>
</td>
</tr>
</table>

### Inventory
```js
[
    // Tổng tồn trong tất cả các kho
    "remain": int // số lượng tồn kho
    "shipping": int // số lượng đang giao hàng
    "holding": int // số lượng đang tạm giữ
    "damage": int // số lượng lỗi
    "available": int // số lượng có thể bán (sử dụng để hiển  thị trên website,chặn đặt hàng khi hết số tồn hoặc vượt quá số tồn).
    // Tồn tại từng kho
    "depots": [
        "depotId" => [
        "remain": int // số lượng tồn kho
        "shipping": int //  số lượng đang giao hàng
        "holding": int // số lượng đang tạm giữ
        "damage": int //  số lượng lỗi
        "available": int // số lượng có thể bán (sử dụng để hiển thị trên website, chặn đặt hàng khi hết số tồn hoặc vượt quá số tồn).
        ],
        "depotId" => [
        ...
        ],
    ...
    ]
]
```
