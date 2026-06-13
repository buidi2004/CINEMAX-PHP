# Implementation Plan: Xây dựng Hệ sinh thái Admin toàn diện cho CinemaX

Bản thiết kế này giải quyết triệt để 3 nhóm tính năng cốt lõi còn thiếu trong hệ thống Quản trị (Admin) dựa trên yêu cầu của bạn, nhằm biến CinemaX thành một hệ thống vận hành rạp chiếu phim thực thụ.

> [!WARNING]
> **User Review Required**
> Vui lòng xem xét các bảng cơ sở dữ liệu mới và cơ chế phân quyền bên dưới. Nếu bạn đồng ý với cấu trúc này, hãy duyệt để tôi bắt đầu viết code và migrations!

## 1. Mở rộng Database (Migrations mới)

Để hỗ trợ các module mới, hệ thống cần thêm các bảng và cột sau:

### [NEW] Bảng `news` (Quản lý Tin tức / Blog)
- `id` (PK, INT)
- `title` (VARCHAR)
- `slug` (VARCHAR, UNIQUE)
- `summary` (TEXT)
- `content` (LONGTEXT)
- `image` (VARCHAR)
- `is_published` (BOOLEAN)
- `created_at`, `updated_at`

### [NEW] Bảng `contacts` (Quản lý Liên hệ / Feedback)
- `id` (PK, INT)
- `name`, `email`, `subject` (VARCHAR)
- `message` (TEXT)
- `status` (ENUM: 'pending', 'resolved')
- `created_at`

### [NEW] Bảng `food_beverages` (Combo Bắp Nước)
- `id` (PK, INT)
- `name` (VARCHAR)
- `description` (TEXT)
- `price` (DECIMAL)
- `image_url` (VARCHAR)
- `is_active` (BOOLEAN)

### [NEW] Bảng `reviews` (Quản lý Đánh giá)
- `id` (PK, INT)
- `user_id` (FK -> users)
- `movie_id` (FK -> movies)
- `rating` (INT 1-5)
- `comment` (TEXT)
- `status` (ENUM: 'pending', 'approved', 'rejected')
- `created_at`

### [NEW] Bảng `settings` (Cài đặt hệ thống)
- `setting_key` (PK, VARCHAR)
- `setting_value` (TEXT)
- `setting_group` (VARCHAR) // vd: 'general', 'payment', 'footer'

### [MODIFY] Bảng `users` (Phân quyền & Vai trò)
- Sửa đổi cột `role`: Thay vì chỉ có `user`, `admin`, mở rộng thành ENUM: `'user', 'staff', 'manager', 'admin'`.
- Thêm cột `cinema_id` (INT, NULLABLE, FK -> cinemas): Dành cho cấp `staff` hoặc `manager` để giới hạn quyền quản lý chỉ trong rạp của họ.

---

## 2. Proposed Changes: Các Module Admin Mới

Hệ thống sẽ được bổ sung các Controllers và Views tương ứng cho từng tính năng.

### 2.1. Quản lý Khuyến mãi / Voucher
- Controller: Đã có sẵn `Admin\PromotionController`.
- Action: Thêm link vào `views/partials/admin_sidebar.php`.

### 2.2. Quản lý Tin tức / Blog
- **[NEW]** `app/Controllers/Admin/NewsController.php` (CRUD)
- **[NEW]** `app/Models/Domain/News.php` & Repositories/Services
- **[NEW]** `views/admin/news/index.php`, `create.php`, `edit.php` (Có tích hợp trình soạn thảo cơ bản hoặc textarea lớn).

### 2.3. Quản lý Liên hệ / Feedback
- **[NEW]** `app/Controllers/Admin/ContactController.php` (Xem danh sách, Xem chi tiết, Đánh dấu đã xử lý).
- **[NEW]** `views/admin/contacts/index.php`, `view.php`

### 2.4. Quản lý Bắp Nước (F&B)
- **[NEW]** `app/Controllers/Admin/FoodBeverageController.php` (CRUD)
- **[NEW]** `views/admin/food_beverages/index.php`, `create.php`, `edit.php`

### 2.5. Quản lý Đánh giá (Reviews)
- **[NEW]** `app/Controllers/Admin/ReviewController.php` (Duyệt/Từ chối hiển thị bình luận).
- **[NEW]** `views/admin/reviews/index.php`

### 2.6. Phân Quyền Quản Trị (Roles & Permissions)
- **[MODIFY]** `app/Controllers/Admin/UserController.php`
- Bổ sung UI để gắn `role` mới và chọn `cinema_id` cho nhân viên trong màn hình quản lý người dùng.
- **[MODIFY]** `app/Controllers/Admin/BaseAdminController.php` (Cập nhật logic chặn quyền truy cập tùy theo Role).

### 2.7. Báo Cáo Thống Kê Chi Tiết
- **[NEW]** `app/Controllers/Admin/ReportController.php`
- **[NEW]** `views/admin/reports/index.php` (Chứa các biểu đồ doanh thu theo rạp, theo phim, bảng dữ liệu chi tiết).

### 2.8. Cài đặt Hệ thống (Settings)
- **[NEW]** `app/Controllers/Admin/SettingController.php`
- **[NEW]** `views/admin/settings/index.php` (Form lưu cấu hình chung, thông tin chân trang, link MXH).

### 2.9. Cập nhật Sidebar Menu
- **[MODIFY]** `views/partials/admin_sidebar.php`: Gắn toàn bộ các menu mới vào thanh điều hướng bên trái một cách có cấu trúc (Nhóm: Kinh doanh, Nội dung, Khách hàng, Hệ thống).

---

## 3. Verification Plan

1. **Khởi chạy Migrations:** Chạy script tạo bảng mới, đảm bảo DB được cập nhật hoàn chỉnh.
2. **Kiểm tra Sidebar:** Đảm bảo Admin Sidebar hiển thị đầy đủ và có logic collapse/mở rộng hợp lý.
3. **Chạy thử CRUD:** Test thử tạo 1 Tin tức, 1 Bắp nước, 1 Cài đặt để đảm bảo dữ liệu ghi vào DB thành công.
4. **Kiểm tra Phân quyền:** Đăng nhập bằng tài khoản `manager` và kiểm tra xem có bị giới hạn quyền so với `admin` hay không.

> [!TIP]
> Do khối lượng công việc rất lớn (tạo hơn 20 file và 5 bảng DB), tôi sẽ tiến hành triển khai theo từng giai đoạn (Phase) sau khi bạn phê duyệt kế hoạch này để đảm bảo độ chính xác tuyệt đối.
