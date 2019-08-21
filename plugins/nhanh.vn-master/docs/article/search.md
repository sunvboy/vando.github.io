# /api/article/search 

- Tính năng này được sử dụng để lấy danh sach bài viết trên Nhanh, phân trang tối đa 50 tin tức/page, hỗ trợ lấy theo id bài viết > id bài viết truyền lên, hỗ trợ lọc bài viết theo danh mục.

## Request
- See [common request params](/docs/api.md#request)

- Cấu trúc data đẩy lên
```js
data = [
	page: int, //page load
	icpp: int, //số records / page
	lastId: int // lọc bài viết lấy từ bài viết có id >  lastId
	categoryId: int // lọc theo category id
]
```
## Response:

Key | Data Type(Max-length) | Description
------- | ------ | -----------
code | int | 1 = success or 0 = failed
messages | array | is an array of error messages if code = 0
data | array | is an array of articles

```js
[
	{
		'totalPages': int //tổng số page
		'page': int // page hiện tại
		'result': [ // Kết quả trả về
			// article 1
			[
				'id': int //id bài viết
				'categoryId': int // category id
				'status': int // Trạng thái
				'title': string // tiêu đề bài viêt
				'intro': string // giới thiệu ngắn gọn bài viết
				'content': string // Nội dung bài viết
			]
			// article 2
		]
}
```

