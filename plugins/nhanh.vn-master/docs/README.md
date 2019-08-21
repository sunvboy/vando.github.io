# <a href='https://nhanh.vn' target='_blank'><img src='https://nhanh.vn/images/logo/nhanh_black2.png'></a>

[Nhanh.vn](https://nhanh.vn) là giải pháp quản lý bán hàng trên nền tảng điện toán đám mây, đồng bộ dữ liệu với website, dịch vụ vận chuyển, giúp doanh nghiệp quản lý toàn bộ quy trình bán hàng, chăm sóc khách hàng, tăng doanh thu, giảm chi phí, phát triển kinh doanh hiệu quả hơn.

* [Phần mềm quản lý bán hàng](https://nhanh.vn)
* [Dịch vụ vận chuyển](https://nhanh.vn/dich-vu-van-chuyen)
* [Thiết kế website bán hàng](https://nhanh.vn/gioi-thieu-tinh-nang-website)
* [Phần mềm quản lý Facebook Fanpage](https://vpage.nhanh.vn)

<img src="https://nhanh.vn/images/v4/banner/bannerRight1.png">

## Nhanh API là gì?

* API cung cấp các giải pháp để đồng bộ dữ liệu sản phẩm, đơn hàng, khách hàng, tồn kho giữa Nhanh.vn và các hệ thống website khác. Các giải pháp này phù hợp cho cả các website bình thường \(website của 1 cá nhân, công ty\) và cả các sàn thương mại điện tử có nhiều gian hàng.

* Nhanh API sử dụng RESTful và JSON format.
* PHP SDK: [https://github.com/nhanhapi/nhanh.vn](https://github.com/nhanhapi/nhanh.vn) 

* [Khởi tạo API Account](/docs/api.md#get-api-account),  [Environment](/docs/api.md#environment),  [Request](/docs/api.md#request),  [Response](/docs/api.md#response),  [Checksum](/docs/api.md#create-checksum),  [Code Sample](/docs/api.md#code-sample)

## Get data from Nhanh.vn

Dữ liệu về vận chuyển:

* [/api/shipping/carrier](/docs/shipping/carrier.md): Lấy danh sách các hãng vận chuyển đang tích hợp trên Nhanh.vn 
* [/api/shipping/location](/docs/shipping/location.md): Lấy danh sách thành phố, quận huyện ở Nhanh.vn
* [/api/shipping/multifee](/docs/shipping/multifee.md): Tính phí vận chuyển cho nhiều đơn hàng cùng lúc.
* [/api/shipping/fee](/docs/shipping/fee.md): Tính phí vận chuyển cho một đơn hàng.
* [/api/shipping/trackingframe](/docs/shipping/trackingframe.md): Tạo link url hiển thị lịch trình của đơn hàng

Dữ liệu về đơn hàng
* [/api/order/index](/docs/order/list.md): Lấy danh sách đơn hàng
* [/api/order/history](/docs/order/history.md): Lấy lịch sử thao tác đơn hàng

Dữ liệu về sản phẩm:

* [/api/product/category](/docs/product/category.md): Lấy danh mục sản phẩm
* [/api/product/search](/docs/product/search.md): Lấy danh sách sản phẩm
* [/api/product/detail](/docs/product/detail.md): Lấy thông tin chi tiết sản phẩm 
* [/api/product/gift](/docs/product/gift.md): Lấy danh sách quà tặng theo sản phẩm
* [/api/product/imei](/docs/product/imei.md): Lấy danh sách imei sản phẩm

Dữ liệu về khách hàng
* [/api/customer/search](/docs/customer/search.md): Lấy danh sách khách hàng
* [/api/integrated-elastix](/docs/integrated-elastix.md): Lấy tên khách hàng để hiển thị ở phần mềm Call Center (Tổng đài) khi có khách gọi đến.

Dữ liệu về tin tức
* [/api/article/categories](/docs/article/categories.md): Lấy danh mục tin tức
* [/api/article/search](/docs/article/search.md): Lấy danh sách tin tức

Dữ liệu về hoá đơn:
* [/api/bill/search](/docs/bill/search.md): Lấy danh sách hóa đơn bán hàng
* [/api/bill/imexs](/docs/bill/imexs.md): Lấy danh sách sản phẩm xuất nhập kho
* [/api/bill/imexrequirements](/docs/bill/imexrequirements.md): Lấy danh sách sản phẩm yêu cầu xuất nhập kho

## Send data to Nhanh.vn
* [/api/store/add](/docs/store/add.md): Gửi thông tin doanh nghiệp
* [/api/product/add](/docs/product/add.md): Đồng bộ sản phẩm từ các website khác về Nhanh.vn
* [/api/order/add](/docs/order/add.md): Đồng bộ đơn hàng từ các website khác về Nhanh.vn
* [/api/order/update](/docs/order/update.md): Gửi cập nhật thông tin đơn hàng    
* [/api/order/addcomplain](/docs/order/addComplain.md): Gửi khiếu nại từ website về Nhanh.vn
* [/api/customer/add](/docs/customer/add.md): Gửi thông tin khách hàng
* [/api/store/configwebhooks](/docs/order/link.md): Link webhooks config cho shop

## Listen webhooks from Nhanh.vn

* [Listen order status](/docs/order/listen.md): Nhận cập nhật trạng thái đơn hàng từ Nhanh.vn
* [Listen product data](/docs/product/listen.md): Nhận thông tin sản phẩm cập nhật từ Nhanh.vn
* [Listen inventory](/docs/product/inventory.md): Nhận cập nhật thay đổi tồn kho từ Nhanh.vn
* [Listen change level, add point, subtract](/docs/bill/listenchange): Nhận thông tin thay đổi cấp độ, tặng điểm, trừ điểm khách hàng cập nhật từ Nhanh.vn 
* [Listen info when customer add order from](/docs/order/listen-info.md): Nhận thông tin khi khách hàng thêm hóa đơn mới từ Nhanh.vn hoặc từ website.    
* [Listen complain](/docs/order/listen-complain.md): Nhận thông tin về khiếu nại đơn hàng từ Nhanh.vn

