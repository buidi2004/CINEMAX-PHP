# Hướng dẫn thiết lập OAuth (Google & Zalo)

## 📋 Tổng quan

Hệ thống hỗ trợ đăng nhập/đăng ký qua:
- **Google OAuth 2.0**
- **Zalo OAuth**

---

## 🔧 Bước 1: Chạy Migration Database

```bash
# Chạy migration để thêm các trường OAuth vào bảng users
psql -U postgres -d cinema_db -f database/migrations/009_add_oauth_to_users.sql
```

Hoặc nếu dùng MySQL/MariaDB:
```bash
mysql -u root -p cinema_db < database/migrations/009_add_oauth_to_users.sql
```

---

## 🔑 Bước 2: Thiết lập Google OAuth

### 2.1. Tạo Google OAuth Client

1. Truy cập [Google Cloud Console](https://console.cloud.google.com/)
2. Tạo project mới hoặc chọn project có sẵn
3. Vào **APIs & Services** → **Credentials**
4. Click **Create Credentials** → **OAuth client ID**
5. Chọn **Web application**
6. Cấu hình:
   - **Name**: CinemaX Web App
   - **Authorized JavaScript origins**: `http://localhost:8000`
   - **Authorized redirect URIs**: `http://localhost:8000/auth/google/callback`
7. Click **Create** và lưu lại **Client ID** và **Client Secret**

### 2.2. Cấu hình trong .env

Mở file `.env` và thêm:

```env
GOOGLE_CLIENT_ID=your-google-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## 📱 Bước 3: Thiết lập Zalo OAuth

### 3.1. Đăng ký Zalo App

1. Truy cập [Zalo Developers](https://developers.zalo.me/)
2. Đăng nhập bằng tài khoản Zalo
3. Click **Tạo ứng dụng** → Chọn **Website**
4. Điền thông tin:
   - **Tên ứng dụng**: CinemaX
   - **Mô tả**: Hệ thống đặt vé xem phim
   - **Website URL**: `http://localhost:8000`
5. Sau khi tạo xong, vào **Cài đặt** → **OAuth Settings**
6. Thêm **Callback URL**: `http://localhost:8000/auth/zalo/callback`
7. Lưu lại **App ID** và **App Secret**

### 3.2. Cấu hình trong .env

Mở file `.env` và thêm:

```env
ZALO_APP_ID=your-zalo-app-id
ZALO_APP_SECRET=your-zalo-app-secret
ZALO_REDIRECT_URI=http://localhost:8000/auth/zalo/callback
```

---

## 🚀 Bước 4: Kiểm tra

### 4.1. Khởi động server

```bash
php -S localhost:8000 -t public
```

### 4.2. Thử nghiệm OAuth

1. Truy cập: `http://localhost:8000/login`
2. Click **Đăng nhập với Google** hoặc **Đăng nhập với Zalo**
3. Xác thực và kiểm tra redirect về trang chủ
4. Kiểm tra database xem user đã được tạo với `oauth_provider` và `oauth_id`

---

## 📊 Cấu trúc Database

Bảng `users` sau khi migration:

```sql
CREATE TABLE users (
    id            SERIAL PRIMARY KEY,
    username      VARCHAR(100)  NOT NULL,
    email         VARCHAR(256)  NOT NULL,
    password_hash VARCHAR(512),                     -- NULL cho OAuth users
    role          VARCHAR(20)   NOT NULL DEFAULT 'user',
    oauth_provider VARCHAR(20),                     -- 'google' | 'zalo' | NULL
    oauth_id      VARCHAR(256),                     -- ID từ provider
    avatar_url    VARCHAR(512),                     -- URL ảnh đại diện
    created_at    TIMESTAMP     NOT NULL DEFAULT NOW(),
    updated_at    TIMESTAMP     NOT NULL DEFAULT NOW()
);
```

---

## 🔐 Bảo mật

### CSRF Protection
- Zalo OAuth sử dụng `state` parameter để chống CSRF attacks
- Google OAuth có built-in CSRF protection

### Email từ Zalo
- **Lưu ý**: Zalo không cung cấp email của user
- Hệ thống tạo email placeholder: `zalo_{user_id}@placeholder.com`
- Có thể yêu cầu user cập nhật email thật trong profile sau

---

## 🎨 Frontend

### Login Page
- Thêm 2 nút OAuth dưới form đăng nhập
- Icon Google và Zalo
- Responsive design với Bootstrap 5

### Register Page
- Tương tự login page
- Nút "Đăng ký với Google/Zalo"

---

## 🐛 Xử lý lỗi

### Lỗi thường gặp:

1. **"Redirect URI mismatch"**
   - Kiểm tra lại Redirect URI trong console/settings
   - Đảm bảo khớp chính xác với config trong `.env`

2. **"Invalid client ID/secret"**
   - Kiểm tra lại credentials trong `.env`
   - Đảm bảo không có khoảng trắng thừa

3. **"Email đã được sử dụng"**
   - User đã đăng ký bằng password với email đó
   - Yêu cầu user đăng nhập bằng password

4. **cURL errors**
   - Kiểm tra PHP có enable `curl` extension
   - Kiểm tra firewall/proxy settings

---

## 📝 Testing

### Test Google OAuth:
```php
// Test URL generation
$oauthService = new OAuthService();
echo $oauthService->getGoogleAuthUrl();
```

### Test Zalo OAuth:
```php
// Test URL generation
$oauthService = new OAuthService();
echo $oauthService->getZaloAuthUrl();
```

---

## 🌐 Production Setup

Khi deploy lên production:

1. Cập nhật Authorized URLs trong Google Console:
   - `https://yourdomain.com`
   - `https://yourdomain.com/auth/google/callback`

2. Cập nhật Callback URL trong Zalo Settings:
   - `https://yourdomain.com/auth/zalo/callback`

3. Cập nhật `.env`:
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
ZALO_REDIRECT_URI=https://yourdomain.com/auth/zalo/callback
```

---

## 📚 Tài liệu tham khảo

- [Google OAuth 2.0 Docs](https://developers.google.com/identity/protocols/oauth2)
- [Zalo OAuth Docs](https://developers.zalo.me/docs/api/social-api/tai-lieu)

---

## ✅ Checklist

- [ ] Chạy migration database
- [ ] Tạo Google OAuth Client
- [ ] Cấu hình Google credentials trong .env
- [ ] Đăng ký Zalo App
- [ ] Cấu hình Zalo credentials trong .env
- [ ] Test đăng nhập Google
- [ ] Test đăng nhập Zalo
- [ ] Kiểm tra user được tạo trong database
- [ ] Test trường hợp email trùng lặp
