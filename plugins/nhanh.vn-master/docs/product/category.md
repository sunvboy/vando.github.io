# /api/product/category

- Tính năng này được sử dụng để lấy toàn bộ danh mục sản phẩm trên Nhanh.vn.

## Request

- See [common request params](/docs/api.md#request)
- Fixed **dataString** = "productcategory"

## Response

- JSON decode the response to get the structure:

Key | Data Type(Max-length) | Description
-------- | -------------- | -----------
code | int | 1 = success or 0 = failed
messages | array | is an array of error messages if code = 0
data | array | is an array of product category (multi-level)

Mảng đệ quy toàn bộ danh mục của doanh nghiệp
```js
[
	// category 1
	{
		'id': int // id danh mục
		'parentId': int // id danh mục cha
		'code': string // Mã danh mục
		'name': string // Tên danh mục
		'childs': [ // array mảng các danh mục con
			{
				'id': int
				'parentId': int
				'code': string
				'name': string
				'childs': [

				]
			},
		]
	},
	// category 2
	// ...
]
```



