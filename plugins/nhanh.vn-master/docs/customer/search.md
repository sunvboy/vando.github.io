# /api/customer/search
- Tính năng này dùng để tìm kiếm thông tin khách hàng thông qua id hoặc số điện thoại của khách hàng. hoặc lấy danh sách khách hàng. Tối đa ko quá 50 khách hàng / page

## Request
- See [common request params](/docs/api.md#request)

- The search params:

Param |Data Type | Mandatory | Description
------- | ---------- | --------- | -------
page | int | No | Phân trang (giá trị mặc định là 1)
icpp | int | No | Số lượng khách hàng trên 1 trang. Mặc định là 10. Tối đa không quá 50.
id | int | No | Tìm kiếm khách hàng theo id.
mobile | int | | Tìm kiếm khách hàng theo số điện thoại.
fromLastBoughtDate | string | No | Từ ngày mua cuối cùng (yyyy-mm-dd)
toLastBoughtDate | string | No | Đến ngày mua cuối cùng (yyyy-mm-dd)

## Response: 

- JSON decode the response to get the structure:

Key | Data Type (Max-length) | Description
------- | ------- | -------
code | int | 1 = success or 0 = failed
messages | [ ] | is an array of error messages if code = 0
data | [ ] | is an array of customer list

```js
[
	'totalPages': int,
	'customers': [
		// customer 1
		{  
			// see properties in the table below
		},
		// customer 2
		// ...
	]
]
```

Key | Data Type (Max-length) | Description
------ | ------- | ---------
id | int | id của khách hàng
name | string | Tên khách hàng
mobile | int |Số điện thoại của khách hàng
email | string | Email của khách hàng
gender | int | Giới tính khách hàng (1 = Nam, 2 = Nữ, Null: Chưa có thông tin)
address | string | Địa chỉ của khách hàng
birthday | string | Ngày sinh của khách hàng
code | string | Mã code của khách hàng
level | string  | Tên cấp độ khách hàng
group | string | Tên nhóm của khách hàng
totalMoney | double |Tổng số tiền khách mua hàng
points |int| Tổng tích điểm của khách hàng
cityId | int | Id thành phố
districtId | int | Id quận huyện
billList| array |Lịch sử hóa đơn mua hàng, mô  tả chi tiết dưới bảng sau:

- billList: 

Key | Data Type (Max-length) | Description
--------- | ------------ | -----------
id | int | id của hóa đơn
depotName | string| Tên kho hàng
createdDateTime |string | Ngày lập hóa đơn
discount | int | Chiết khấu của hóa đơn
points | int | Điểm tích lũy của đơn hàng
type | int | Loại đơn hàng: <br>Giá trị = 1 (import → trả hàng)<br>Giá trị = 2 (export → bán hàng)
mode | int | Kiểu đơn hàng: <br>giá trị = 2 → bán lẻ<br>giá trị = 6 → bán buôn
saleName | string | nhân viên bán hàng
createdByName | string | nhân viên thu ngân
products | array | Chi tiết sản phẩm hàng. được mô tả chi tiết ở bảng bên dưới.

- Products: 

Key | Data Type (Max-length) | Description
------------ | ------------ | ---------
id | int | id của sản phẩm
code | string | Mã code của sản phẩm
name | string | Tên sản phẩm 
quantity | int | Số lượng sản phẩm
price | int | Giá sản phẩm
imei | int | Imei của sản phẩm. Nếu sản phẩm tồn tại imei sẽ hiện thêm trường này









