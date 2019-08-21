# /api/store/depots

- Tính năng này dùng để lấy danh sách kho của doanh nghiệp. Hỗ trợ tìm kiếm thông qua ID kho.

## Request
- See [common request params](/docs/api.md#request)
 
- The search param - (Data array)

Param | | Mandatory | Description
---- | ----- | ------ | ---------
id | Int | No | Tìm kiếm theo ID kho

## Response
JSON decode the response to get the structure:

Key |Data Type(Max-length) | Description 
-------- | ------- | --------
code | int | 1 = success or 0 = failed
messages | [ ] | is an array of error messages if code = 0
data | [ ] | Mảng danh sách kho của doanh nghiệp

```js
data = [
   id1: Tên kho 1,
   id2: Tên kho 2,
   [...]
]
```
