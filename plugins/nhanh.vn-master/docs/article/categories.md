# /api/article/categories 

- Tính năng này được sử dụng để lấy toàn bộ danh mục tin tức của doanh nghiệp trên Nhanh.vn.

## Request
See [common request params](/docs/api.md#request)

## Response
JSON decode the response to get the structure:

Key | Data Type(Max-length) | Description
------------ | ---------- | ----------
code | int | 1 = success or 0 = failed
messages | [ ] | is an array of error messages if code = 0
data | [ ] | is an array of product category (multi-level)

```js
[
	{
		"id": int
		"name": string
		"status": int
		"parentId": int
		"childs": [ // child categories
			{
				"id": int
				"name": string
				"status": int
				"parentId": int
				"childs": [
					...
				]
			},
			...
		]
	},
	...
]
```


