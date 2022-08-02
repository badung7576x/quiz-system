## Project: Hệ thống quản lý đề thi trắc nghiệm cho nhóm chuyên môn

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

* Với Docker: 

```
// Pull code từ github
$ git clone git@github.com:badung7576x/quiz-system.git
// Tạo file môi trường
$ cp .env.example .env
// Build Docker
$ make run
$ make init
```

* Với local environment:

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
