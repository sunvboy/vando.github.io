# /api/product/gift
- Tính năng này dùng để lấy danh sách quà tặng theo sản phẩm. Hỗ trợ tìm kiếm thông qua ID sản phẩm.

## Request

- See [common request params](/docs/api.md#request)

- The search param - (Data array)

Param | | Mandatory | Description 
--------- | ---------- | -------- | ----------
 page | int | No | Phân trang (giá trị mặc định là 1)
icpp | int | No | Số lượng sản phẩm trên 1 trang. Mặc định là 10. Tối đa không quá 20.
ids | array | No | Tìm kiếm theo ID sản phẩm có quà tặng

 ## Response
 JSON decode the response to get the structure:
 
Key | Data Type(Max-length) | Description
--------- | ------ | ---------
code | int | 1 = success or 0 = failed
messages | [ ] | is an array of error messages if code = 0
data | [ ] | Mảng danh sách sản phẩm có quà tặng

```js
data = [
[
	productId: int // id sản phẩm có quà tặng
	productCode: string // mã sản phẩm có quà tặng
	productName: string // tên sản phẩm có quà tặng
	productGiftId: int // id sản phẩm quà tặng
	productGiftCode: string //  mã sản phẩm quà tặng
	productGiftName: string //  tên sản phẩm quà tặng
	quantity: int // số lượng quà tặng
	value: int // giá trị quà tặng (tính theo quantity = 1)
],
[...]
]
```
**Chú ý**: quantity của quà tặng có hệ số là 1. VD mua 1 sản phẩm A được tặng 2 sản phẩm B, thì nếu mua 2 sản phẩm A sẽ được tặng 4 sản phẩm B

