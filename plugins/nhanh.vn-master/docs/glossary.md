# Các thuật ngữ của hệ thống

## Order

Các thuật ngữ của đơn hàng online

* **shippingWeight**: bao gồm cân nặng thực tế của sản phẩm và toàn bộ cân nặng của các phụ kiện và vỏ hộp đóng gói đi kèm. Shipping weight được sử dụng để tính phí vận chuyển của đơn hàng.
VD: Sản phẩm “Samsung Galaxy S2” nặng 300gr, Sản phẩm fullbox còn bao gồm 1 sạc (30gr), 1 tai nghe (10gr) and vỏ hộp đóng gói (30gr), vậy thì shippingWeight để tính phí vận chuyển sẽ là: 300 + 30 + 10 + 30 = 370 gr.

* **COD**: Cash on delivery (Collect on delivery) là 1 loại giao dịch mà người mua hàng sẽ trả tiền khi nhận được hàng. Nếu người mua không đồng ý thanh toán khi nhận hàng, đơn hàng sẽ được chuyển trả lại cho người bán. Phí thu tiền hộ **codFee ** tùy thuộc vào số tiền cần thu của đơn hàng.

* **shipFee**: Phí vận chuyển, được tính dựa vào trọng lượng đơn hàng, địa chỉ gửi hàng và địa chỉ nhận hàng.

* **customerShipFee**: Phí thu của khách, là mức phí mà website thông báo cho khách đặt hàng, thường sẽ lấy bằng shipFee + codFee. Tình huống website có chương trình miễn phí vận chuyển cho khách thì set customerShipFee = 0.

* ##### Order Status: 
Trạng thái đơn hàng

|Status | Description|
|--- | --- |
|New | Đơn mới|
|Confirming | Đang xác nhận|
|CustomerConfirming | Chờ khách xác nhận|
|Confirmed | Đã xác nhận|
|Packing | Đang đóng gói|
|ChangeDepot | Đổi kho xuất hàng|
|Pickup | Chờ đi lấy hàng|
|Pickingup | Đang đi lấy hàng|
|Pickedup | Đã lấy hàng từ kho|
|Shipping | Đang giao hàng|
|Success | Thành công|
|Failed | Thất bại|
|Canceled | Khách hủy|
|Aborted | Hệ thống hủy|
|CarrierCanceled | Hãng vận chuyển hủy đơn|
|SoldOut | Hết hàng|
|Returning | Đang chuyển hoàn|
|Returned | Đã chuyển hoàn|

* ##### Order Reason
Lý do theo trạng thái đơn hàng

Reason | Description
------ | ------- 
WrongProduct | Đặt nhầm sản phẩm
HighShipFee | Phí vận chuyển cao
NotTransfer | Không muốn chuyển khoản
Duplicated | Đơn trùng
CannotCall | Không gọi được khách
SoldOut | Hết hàng
WaitingTransfer | Chờ chuyển khoản
NotLikeProduct | Khách không thích sản phẩm
NotPleasureDeliverer | Khách không hài lòng về nhân viên vận chuyển
SlowShipping | Giao hàng chậm
Bought | Đã mua sản phẩm tại cửa hàng
CustomerNotAtHome | Khách đi vắng (sẽ giao hàng vào hôm khác)
WrongAddress | Sai địa chỉ người nhận
NotBuy | Khách không muốn mua nữa
CannotCallSender | Không liên hệ được với người gửi
SellerNotSellOnline | Người gửi không bán hàng Online / Ngoại tỉnh
SellerNotHandoverCarrier | Người gửi không bàn giao hàng cho hãng vận chuyển
SellerNotProcessOrder | Người gửi không xử lý đơn hàng
WrongPickupAddress | Sai địa chỉ kho lấy hàng
WrongPrice | Sai giá sản phẩm
SelfShipping | Người gửi tự vận chuyển
CarrierPickupLate | Hãng vận chuyển lấy hàng muộn
CarrierLostProduct | Hãng vận chuyển làm mất hàng
Other | Lý do khác

### Inventory

Các thuật ngữ về kho hàng

* Phiếu XNK, Sản phẩm XNK có 2 loại (type) là phiếu nhập, phiếu xuất và nhiều kiểu (mode) XNK khác nhau:

* Loại XNK:

| Type (int) | Description |
| --- | --- |
| 1 | Loại nhập kho |
| 2 | Loại xuất kho |

* Kiểu XNK:

| Mode (int) | Description |
| --- | --- |
| 1 | Kiểu giao hàng |
| 2 | Kiểu bán lẻ |
| 3 | Kiểu chuyển kho |
| 4 | Kiểu quà tặng |
| 5 | Kiểu nhà cung cấp |
| 6 | Kiểu bán buôn |
| 8 | Kiểu kiểm kho |
| 10 | Kiểu khác |




