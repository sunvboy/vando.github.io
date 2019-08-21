# Integrated with Elastix

- Chú ý: Tính năng này không yêu cầu API account.

- Tổng đài Elastix có thể lấy thông tin tên khách hàng từ cơ sở dữ liệu trên Nhanh.vn bằng cách call url:
https://graph.nhanh.vn/api/elastix/cidlookup?storeId=&customerMobile=
Nếu tìm thấy thông tin khách hàng, Nhanh.vn sẽ hiển thị tên khách hàng, nếu không tìm thấy sẽ hiện “customerMobile Unknown” (customerMobile từ request param).
Xem cách cài đặt tổng đài Elastix để hiển thị tên khách hàng gọi đến tại đây: http://wiki.freepbx.org/display/FPG/CallerID+Lookup+Sources+Module


Param|Type|Mandatory|Description
-| -----|----------|-------
storeId|int|Yes|ID của doanh nghiệp trên Nhanh.vn
customerMobile|string|Yes|Số điện thoại của khách hàng gọi đến
