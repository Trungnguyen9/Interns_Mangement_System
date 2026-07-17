# Interns Management System (IMS)

Interns Management System (IMS) là hệ thống hỗ trợ quản lý thực tập sinh, mentor và quản trị viên trong quá trình thực tập. Hệ thống giúp theo dõi tiến độ công việc, quản lý báo cáo, đánh giá thực tập sinh và hỗ trợ giao tiếp giữa mentor với intern.

---

## Công nghệ sử dụng

- Laravel 12
- PHP 8.2+
- MySQL
- Blade Template
- Bootstrap 5
- Vite
- JavaScript

---

## Yêu cầu hệ thống

Trước khi chạy dự án, hãy đảm bảo máy tính đã cài đặt:

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL
- Git

Có thể sử dụng:

- XAMPP
- Laragon

---

## Hướng dẫn cài đặt

### 1. Clone repository

```bash
git clone <repository-url>
cd Interns-Management-System
```

---

### 2. Cài đặt thư viện PHP

```bash
composer install
```

---

### 3. Cài đặt thư viện Frontend

```bash
npm install
```

---

### 4. Cấu hình Database

Mở file `.env`

Ví dụ:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ims
DB_USERNAME=root
DB_PASSWORD=
```

Sau đó tạo database tên:

```
ims
```

---

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

### 6. Chạy Migration

```bash
php artisan migrate
```

Nếu có Seeder:

```bash
php artisan db:seed
```

Hoặc:

```bash
php artisan migrate --seed
```

---

### 7. Build Frontend

Development

```bash
npm run dev
```

Production

```bash
npm run build
```

---

### 8. Khởi động Server

```bash
php artisan serve
```

Mặc định:

```
http://127.0.0.1:8000
```

---

## Chức năng chính

### Administrator

- Quản lý tài khoản
- Quản lý Mentor
- Quản lý Intern
- Quản lý Task
- Theo dõi Dashboard thống kê
- Phân công Mentor cho Intern

### Mentor

- Quản lý danh sách Intern
- Tạo và giao Task
- Theo dõi tiến độ
- Đánh giá báo cáo
- Nhận xét thực tập sinh

### Intern

- Xem Task
- Cập nhật tiến độ
- Nộp báo cáo
- Theo dõi deadline
- Nhận đánh giá từ Mentor

---

## Cấu trúc thư mục

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

---

## Tài khoản mẫu

Nếu sử dụng Seeder:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Mentor | mentor@example.com | password |
| Intern | intern@example.com | password |

---

## Các lệnh thường dùng

Chạy server

```bash
php artisan serve
```

Migration

```bash
php artisan migrate
```

Rollback

```bash
php artisan migrate:rollback
```

Clear cache

```bash
php artisan optimize:clear
```

Build assets

```bash
npm run build
```

Development

```bash
npm run dev
```

---

## Giấy phép

Dự án được phát triển phục vụ mục đích học tập và nghiên cứu.