# Listen order status

- Website của bạn cần đăng kí một URL để nhận trạng thái đơn hàng cập nhật từ Nhanh.vn (cập nhật realtime khi trạng thái đơn hàng thay đổi bên trong Nhanh.vn).
- Nhanh.vn chỉ gửi trạng thái các đơn hàng từ hệ thống khác bắn sang Nhanh.vn, các đơn hàng tạo trực tiếp ở Nhanh.vn sẽ không phát sinh việc cập nhật trạng thái này.
 
## Request

- Nhanh.vn send a POST request to your listen URL. See [common request params](/docs/api.md#request).
- Decode data string (JSON) to get the data object: The properties of each order if **updateType** is **Status** or **CheckPayment**:
  
Param | Data type (Max-length) | Description
----------- | ---------------- | --------
id | string(20) | id của đơn hàng được đồng bộ từ website của bạn sang Nhanh.vn
status | string | Trạng thái đơn hàng xem [tại đây](/docs/glossary.md#order-status)
reason | string | Lí do theo trạng thái xem [tại đây](/docs/glossary.md#order-reason)
carrierId | int / null | id của hãng vận chuyển 
carrierServiceId | int / null | id của dịch vụ vận chuyển
sendCarrierDateTime | string / null | Thời gian gửi đơn hàng sang hãng vận chuyển. Định dạng: yyyy-mm-dd hh-mm-ss (nếu đơn chưa gửi sang hãng vận chuyển thì giá trị sẽ là null)
weight | int | trọng lượng của đơn hàng (tính bằng gram) do doanh nghiệp khai báo.
carrierWeight | int | trọng lượng của đơn hàng (tính bằng gram) do hãng vận chuyển trả kết quả.
customerShipFee | double | Phí thu của khách
shipFee | double | Phí vận chuyển
overWeightShipFee | double | Phí vượt cân
returnFee | double | Phí chuyển hoàn (các đơn hàng không phát được, chuyển trả lại người gửi)
codFee | double | Phí thu tiền hộ (nếu đơn hàng cần thu tiền, các đơn chỉ giao hàng mà không cần thu tiền sẽ không có khoản phí này).
totalProductMoney | double | Tổng giá trị các sản phẩm trong đơn: (Số lượng * Giá) + VAT
discount | double | Chiết khấu
moneyTransfer | double | Tiền đã chuyển khoản
moneyDeposit  | double | Tiền đặt cọc
paymentForSender | double | Số tiền thanh toán cho người gửi hàng (đã trừ đi các loại phí phải trả cho hãng vận chuyển)
deliveryDate | date | Ngày giao hàng (yyyy-mm-dd)

 Sau khi nhận được kết quả từ Nhanh gửi sang, bạn cần trả lại response cho Nhanh đánh dấu trạng thái của lần đồng bộ này: 
 ```js
{
  "code": 1,
  // Nếu tình huống updateType = CheckPayment, trả thêm kết quả cho từng đơn
  "data": [
      "id": 1 // id là id đơn hàng từ website của bạn gửi sang Nhanh, 1 là check thanh toán thành công, 0 là check thanh toán không thành công
  ]
}
 ```
  - The properties if **updateType** is **Payment**:
  
Param | Data type(Max-length) | Description
----------- | ---------------- | --------
updateType | string | fixed value: Payment
paymentCode | string | Mã giao dịch chuyển tiền (Nhanh.vn thanh toán tiền trả doanh nghiệp khi đã giao hàng thành công)
paymentMoney | double | Số tiền đã chuyển
totalOrders | int | Tổng số đơn trong lần thanh toán này

  Sau khi bạn nhận được kết quả và xử lý thành công cần trả response dạng json: **{code: 1}** để Nhanh.vn đánh dấu trạng thái thanh toán đã được gửi thành công.
  
  
