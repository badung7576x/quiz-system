# Project: Hệ thống quản lý đề thi trắc nghiệm cho nhóm chuyên môn

Mô tả: Hệ thống hỗ trợ các nhóm giáo viên chuyên môn xây dựng bộ câu hỏi và đề thi trắc nghiệm. 

## Thư viện

| Library | Version |
| --- | --- | 
| PHP | > 8.0 |
| Laravel | 9.2 |
| MySQL | 5.7 |
| Meilisearch | 0.25.2 |
| Docker | 20.10.17 |

## Triển khai 

---
### Với Docker: 

```
// Pull code từ github
$ git clone git@github.com:badung7576x/quiz-system.git
$ npm i && npm run dev

// Tạo file môi trường, chỉnh sửa thông tin DB và Meilisearch key
$ cp .env.example .env

// Build Docker
$ make run
$ make init
```

* Hệ thống chạy ở đường dẫn: http://locahost:8808/admin/dashboard

* Công cụ tìm kiếm Meilisearch: http://localhost:7700  => Nhập key được set trong env để sử dụng hệ thống


Tài khoản mặc định để sử dụng hệ thống:

> Administrator: admin@gmail.com / 123123

> Trưởng nhóm chuyên môn: english.teacher@gmail.com / 123123

> Giáo viên chuyên môn: english.teacher01@gmail.com / 123123

> Giáo viên bộ môn: english.teacher02gmail.com / 123123

> Giáo viên: english.teacher03gmail.com / 123123



Kiểm tra hoạt động của docker

```
$ make docker-view
```

Các service đóng gói trong Docker bao gồm:

| Service | Port |
| --- | --- | 
| PHP | 9000 |
| Nginx | 8808:80 |
| DB | 3356:3306 |
| Meilisearch | 7700:7700 |

Chỉnh sửa file docker-compose.yml và docker-compose.stg.yml để cấu hình lại docker. 


---
### Với local environment:

```
// Pull code từ github
$ git clone git@github.com:badung7576x/quiz-system.git

// Tạo file môi trường và setup thông tin database
$ cp .env.example .env

// Cài đặt thư viện
$ composer install
$ npm install & npm run dev

// Khởi tạo dữ liệu mẫu
$ php artisan migrate --seed 

// Tạo index cho chức năng fulltext-search
$ php artisan scout:import "App\Models\QuestionBank"

```
