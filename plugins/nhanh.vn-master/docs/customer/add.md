# /api/customer/add
- Tính năng này dùng để thêm thông tin khách hàng cho doanh nghiệp key sử dụng là mobile. Tối ta mỗi lần không quá 50 khách hàng.

## Request

- See [common request params](/docs/api.md#request)

- The **data array**:
```js
// each request can send maximum 50 customers
[
	[ // customer 1 ], // see the structure in the table below
	[ // customer  2 ],
	...
]
```

Key | Data type|Mandatory|Description
----------|-------------|---------|----------
fromCustomer|string| |Số điện thoại khách hàng giới thiệu (khách hàng đã tồn tại trên hệ thống Nhanh.vn)
saleName|string| |Nhân viên phụ trách (username của nhân viên thuộc doanh nghiệp đã tồn tại trên hệ thống Nhanh.vn)
name|string|yes|Tên khách hàng
type|int| | 1 - Khách lẻ, 2 - Khách buôn
address|string| |địa chỉ khách hàng
mobile|int|yes|Số điện thoại khách hàng
businessName|string| |Tên công ty
taxCode|string| |Mã số thuế
points|int| |điểm tích lũy của khách hàng
gender|int| |1 - Nam, 2 - Nữ
birthday |date | |Sinh nhật khách hàng
cityName|string| |tên thành phố
districtName |string| |tên quận huyện
email|string| |Email khách hàng
pid|string| |Số CMND
description|string| |Mô tả
facebookLink|string| |Facebook link
groupId|int| |ID nhóm khách hàng trên Nhanh.vn


