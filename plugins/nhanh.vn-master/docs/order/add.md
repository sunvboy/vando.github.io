# /api/order/add

- Tính năng này dùng để gửi thông tin đơn hàng từ website của bạn sang Nhanh.vn. Khi khách hàng đặt hàng trên website của bạn, sau khi lưu thông tin đơn hàng vào cơ sở dữ liệu, website của bạn gửi thông tin đơn hàng sang Nhanh.vn, sau đó chủ gian hàng có thể xử lý toàn bộ các bước từ việc xác nhận đơn hàng, nhặt hàng và đóng gói, gửi đơn hàng sang hãng vận chuyển, đối soát tình trạng thanh toán (tiền thu hộ) các đơn hàng với hãng vận chuyển bên trong hệ thống Nhanh.vn. 
- Mỗi khi trạng thái đơn hàng có sự thay đổi, website của bạn sẽ nhận được 1 request cập nhật trạng thái đơn hàng từ Nhanh.vn (Xem mục [Listen order’s status updated from Nhanh.vn](/docs/order/listen.md)).

**Chú ý**: Các sàn thương mại điện tử nên có cài đặt riêng cho từng gian hàng (vì không phải toàn bộ gian hàng muốn sử dụng tính năng này). Nhanh.vn cũng có cài đặt này, vì vậy request gửi sang Nhanh có thể nhận được thông báo lỗi là: “This store disabled this feature”.

## Request
- See [common request params](/docs/api.md#request)
- The data structure of an order: 
```js
[
	"id" => 3256, 
	"type" => "Shipping", 
	// more detail in the table below... 
]
```

Key | Data type | Mandatory |Description
--|----------|-----------|----------
id|string(36)|Yes|id đơn hàng trên website của bạn
depotId | int | No | id kho doanh nghiệp trên Nhanh.vn
type|string|No|Loại đơn hàng, giá trị có thể là: “Shipping” (Chuyển hàng) hoặc “Shopping” (Khách tới mua tại cửa hàng)<br>“PreOrder”(Khách đặt hàng trước).<br>Giá trị mặc định là Shipping.
autoSend | int | No | Biến đánh dấu gửi luôn đơn hàng sang hãng vận chuyển (Dùng trong tình huống bạn có hệ thống xác nhận đơn hàng từ trước, chỉ dùng Nhanh để hỗ trợ vận chuyển).<br>Set value = 1: Gửi luôn đơn hàng sang hãng vận chuyển.
customerCityName | string(255) | Yes | Tên thành phố của người nhận hàng (Lấy từ [/api/shipping/location](/docs/shipping/location.md))
customerDistrictName | string(255) | Yes | Tên quận huyện của người nhận hàng (Lấy từ [/api/shipping/location](/docs/shipping/location.md))
customerAddress | string(255) | Yes |Địa chỉ người nhận hàng
customerName | string(255) | Yes | Tên người nhận hàng
customerMobile | string(255) | Yes | Mobile của người nhận hàng
customerEmail | string(255) | No | Địa chỉ email đặt hàng
moneyDiscount | int | No | Tiền chiết khấu
moneyTransfer | int | No | Số tiền khách chuyển khoản
moneyDeposit | int | No | Số tiền khách đặt cọc
paymentMethod | string | No | Các giá trị có thể là: <br>COD //Thanh toán tại nhà<br>Store // Thanh toán tại cửa hàng<br> Gateway // Thanh toán qua cổng thanh toán<br>Online // thanh toán Online
paymentCode | string(255) | No | Mã giao dịch thanh toán
paymentGateway | string(255) | No | Tên cổng thanh toán
carrierId | int | No | id hãng vận chuyển (Lấy từ [/api/shipping/fee](/docs/shipping/fee.md))
carrierServiceId | int | No | dịch vụ vận chuyển([/api/shipping/fee](/docs/shipping/fee.md))
customerShipFee | int | No | Phí thu của khách
codFee | int | No | Phí thu tiền hộ (Lấy từ [/api/shipping/fee](/docs/shipping/fee.md))
shipFee | int | No | Phí vận chuyển (Lấy từ [/api/shipping/fee](/docs/shipping/fee.md))
deliveryDate | date | No | Ngày giao hàng của đơn hàng này, định dạng yyyy-mm-dd
status | string | No | Trạng thái của đơn hàng: New (Mới) hoặc Confirmed (Đã xác nhận).
description | string | No | Ghi chú của khách hàng về đơn hàng này
weight | int | No | Tổng khối lượng của đơn hàng tính theo gram. Hiện tại Nhanh.vn hỗ trợ đơn hàng tối đa 50000 gr (50 kg).
trafficSource | string |No| Nguồn truy cập đơn hàng, bạn có thể đánh dấu xem đơn hàng đến từ nguồn nào qua referrer hoặc marketing campaign (utm_source, utm_medium, utm_campaign) và gửi kèm thông tin này theo đơn hàng để xem báo cáo thống kê theo nguồn truy cập ở bên Nhanh.vn
createdDateTime | datetime | No | Thời gian khách đặt hàng, định dạng là yyyy-mm-dd hh:mm:ss (VD: 2017-12-31 12:40:56)
productList | array | Yes|Danh sách sản phẩm của đơn hàng: xem bảng dữ liệu bên dưới.
couponCode | string | No | Mã coupon
allowTest | int | No | 1 - Cho xem hàng, không cho thử<br>2 - Cho phép thử<br>3 - Không cho xem  hàng



 
- Các thuộc tính của 1 sản phẩm trong **productList** bao gồm:

Key | Data type | Mandatory | Description
------- | ----------- | --------- | ----------
id | string(20) | Yes | id sản phẩm bên website của bạn
idNhanh | bigint(20) | No | id sản phẩm bên Nhanh.vn (tham số này là bắt buộc nếu sản phẩm được đồng bộ từ Nhanh.vn sang website của bạn)
quantity | int | Yes | số lượng đặt hàng
name | string(255) | Yes | Bắt buộc để thêm sản phẩm mới trong tình huống sản phẩm chưa tồn tại (giúp cho việc đồng bộ đơn hàng không bị gián đoạn nếu sản phẩm chưa được đồng bộ trước đó)
code | string(255) | No | Mã sản phẩm
imei | string(255) | No | Số IMEI sản phẩm
type | string(255) | No | Loại sản phẩm (Product, Voucher, IMEI)
price | int | Yes | Giá của sản phẩm. Bắt buộc để thêm sản phẩm mới trong tình huống sản phẩm chưa tồn tại
weight | int | No | Khối lượng sản phẩm
importPrice | int | No | Giá nhập của sản phẩm
description | string | No |Mô tả riêng của từng sản phẩm trong đơn hàng
gifts | Array | No | Quà tặng của sản phẩm trong đơn hàng <br> [<br>&nbsp;&nbsp;&nbsp;0 => [<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Id => id sản phẩm trên website ,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;productStoreId => id sản phẩm trên Nhanh , <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;quantity => Số lượng, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;value => Giá sản phẩm quà tặng<br>&nbsp;&nbsp;&nbsp;],<br>&nbsp;&nbsp;&nbsp;1 => [<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Id => id sản phẩm trên website,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;productStoreId => id sản phẩm trên Nhanh,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;quantity => Số lượng, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;value => Giá sản phẩm quà tặng<br>&nbsp;&nbsp;&nbsp;]<br>...<br>]

## Response
```js
{
	"code": 1, // 1 is success, 0 is error
	"messages": [ ], // error messages if code is 0
	"data": [
		"3256" => 5174985, // id đơn hàng trên website của bạn => bigint: order id of Nhanh.vn
		"shipFee" => 30000, // int: Phí vận chuyển
		"codFee" => 13000, // int: Phí thu tiền hộ
		"shipFeeDiscount" => 0, // int: Phí vận chuyển được giảm giá
		"codFeeDiscount" => 0 // int: Phí thu tiền hộ được giảm giá
	]
}
```
**Chú ý**: 
- **shipFee **và **codFee **dùng trong tình huống đơn hàng có sử dụng dịch vụ vận chuyển, thông tin đơn hàng gửi sang có kèm theo carrierId, carrierServiceId và weight.
- **shipFeeDiscount **là phí vận chuyển được chiết khấu, VD **shipFee **= 25.000, **shipFeeDiscount **= 7.000 thì **shipFee **thực tế của đơn hàng này sẽ chỉ = 18.000
- **codFeeDiscount **là phí thu tiền hộ được chiết khấu, VD **codFee **= 15.000, **codFeeDiscount **= 3.000 thì **codFee **thực tế của đơn hàng này sẽ chỉ = 12.000








