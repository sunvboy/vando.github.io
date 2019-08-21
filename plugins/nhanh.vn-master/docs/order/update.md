# /api/order/update
- Tính năng này dùng để cập nhật thông tin đơn hàng khi khách hàng thực hiện việc chuyển khoản online (Khi website của bạn nhận được cập nhật từ cổng thanh toán, website của bạn sẽ gửi thông tin này sang Nhanh.vn) hoặc khi khách hàng hủy đơn hàng. Hoặc dùng trong tình huống website của bạn muốn gửi đơn hàng qua các hãng vận chuyển.

## Request  
- See [common request params](/docs/api.md#request)
- The data structure of an order: 

Key | Data type | Mandatory | Description
---- | ------|------|-----
id | string(20) | Yes | id đơn hàng trên website của bạn
autoSend | int | No | Biến đánh dấu gửi luôn đơn hàng sang hãng vận chuyển (Dùng trong tình huống bạn có hệ thống xác nhận đơn hàng từ trước, chỉ dùng Nhanh để hỗ trợ vận chuyển).<br>Set value = 1 để gửi đơn hàng sang hãng vận chuyển.
moneyTransfer | int | No | Số tiền khách đã chuyển khoản
paymentCode | string(255) | No | Mã giao dịch thanh toán
paymentGateway | string(255) | No | Tên của cổng thanh toán
status | string | No | Trạng thái đơn hàng, có thể là:<br>-  Confirmed // Đã xác nhận<br>- Canceled // Khách huỷ(chỉ đổi được sang trạng thái Khách hủy khi đơn hàng đang ở trạng thái Mới, Đang xác nhận, Đã xác nhận)<br>- Aborted // Hệ thống hủy (chỉ đổi được sang trạng thái Hệ thống hủy khi đơn hàng đang ở trạng thái Mới, Đang xác nhận, Đã xác nhận)
description | string | No | Mô tả lý do hủy đơn hàng 
# Response
```js
{
	"code": 1, // 1 is success, 0 is error
	"messages": [ ], // error messages if code is 0
	"data": [
		"3256" => 5174985, // id đơn hàng trên website của bạn => bigint: order id of Nhanh.vn
		"status": "Shipping", // trạng thái hiện tại của đơn hàng
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




