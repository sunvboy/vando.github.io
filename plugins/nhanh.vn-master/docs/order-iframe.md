# Order Iframe

- Khi doanh nghiệp đã có sẵn 1 website trước khi sử dụng phần mềm của Nhanh.vn và không muốn bỏ đi website cũ này, website của bạn có thể nhúng 1 khung đặt hàng của Nhanh trên trang chi tiết sản phẩm để sử dụng toàn bộ các tính năng của Nhanh.vn như:

  - Hiện số tồn ở từng cửa hàng.
  - Hiện phí vận chuyển.
  - Hiện giá sau khi đã áp dụng chương trình khuyến mại được cài đặt trên Nhanh.vn.
  - Hiện ô nhập mã Coupon giảm giá.


- Để sử dụng tính năng này, sản phẩm trên website của bạn phải lưu thêm 1 trường id sản phẩm trên Nhanh (idNhanh), đồng thời tích hợp việc nhận thông tin sản phẩm từ Nhanh.vn ([Listen product updated from Nhanh.vn](/docs/product/add.md)), như vậy khi bạn thêm mới hoặc sửa / xóa sản phẩm trên Nhanh.vn, thông tin trên website của bạn cũng được cập nhật tương ứng.

- Khi khách hàng đặt hàng thông qua Order Iframe này, đơn hàng sẽ được chuyển trực tiếp về Nhanh.vn, nếu dùng cách này, bạn có thể bỏ qua được bước tích hợp Send Order information: [/api/order/add](/docs/order/add.md)

// Chèn mã javascript này vào website
```js
<script>
(function (d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//api.store.nhanh.vn/js/api/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'nhanh-jssdk'));
</script> 
```
// Chèn đoạn sau vào chỗ hiển thị box đặt mua
```php
<div class="nhanh-call-product" data-id="" data-storeid="" data-backgroundbutton="cc334f" data-borderradiusbutton="5" data-font="Arial, Helvetica, sans-serif" data-fontsize="12"></div> 
```
**data-id** là id sản phẩm trên Nhanh.vn (idNhanh)
**data-storeid** là id doanh nghiệp trên Nhanh.vn

- Demo hiển thị trên website
![](pasted image 0.png)







