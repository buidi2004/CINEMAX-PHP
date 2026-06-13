# OAuth Integration - Google & Zalo

## 🎯 Tổng quan

Dự án đã được tích hợp đăng nhập/đăng ký qua:
- ✅ **Google OAuth 2.0**
- ✅ **Zalo OAuth**

## 📦 Files đã thêm/cập nhật

### Backend (PHP)
```
app/
├── Models/
│   ├── Domain/
│   │   └── User.php                    [UPDATED] Thêm OAuth fields
│   ├── Repository/
│   │   ├── Interfaces/
│   │   │   └── IUserRepository.php     [UPDATED] Thêm findByOAuth()
│   │   └── Implementations/
│   │       └── UserRepository.php      [UPDATED] Implement OAuth methods
│   └── Services/
│       ├── Interfaces/
│       │   └── IUserService.php        [UPDATED] Thêm authenticateWithOAuth()
│       ├── Implementations/
│       │   └── UserService.php         [UPDATED] Implement OAuth logic
│       └── OAuthService.php            [NEW] OAuth handler
└── Controllers/
    └── AuthController.php              [UPDATED] Thêm OAuth routes

config/
└── routes.php                          [UPDATED] Thêm OAuth routes

database/
└── migrations/
    ├── 009_add_oauth_to_users.sql      [NEW] Migration
    └── 009_rollback_oauth.sql          [NEW] Rollback script
```

### Frontend (Views)
```
views/
├── auth/
│   ├── login.php                       [UPDATED] Thêm OAuth buttons
│   └── register.php                    [UPDATED] Thêm OAuth buttons
└── layouts/
    └── main.php                        [UPDATED] Load OAuth CSS

public/
└── assets/
    └── css/
        └── oauth.css                   [NEW] OAuth styling
```

### Configuration
```
.env.example                            [UPDATED] OAuth credentials
app/helpers.php                         [UPDATED] OAuth helpers
```

### Documentation & Tests
```
OAUTH_SETUP.md                          [NEW] Setup guide
README_OAUTH.md                         [NEW] This file
tests/
└── test_oauth_config.php               [NEW] Config test
```

## 🚀 Quick Start

### 1. Run Migration
```bash
# PostgreSQL
psql -U postgres -d cinema_db -f database/migrations/009_add_oauth_to_users.sql

# MySQL
mysql -u root -p cinema_db < database/migrations/009_add_oauth_to_users.sql
```

### 2. Configure Credentials

Copy `.env.example` to `.env` và thêm:

```env
# Google OAuth
GOOGLE_CLIENT_ID=your-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Zalo OAuth
ZALO_APP_ID=your-app-id
ZALO_APP_SECRET=your-app-secret
ZALO_REDIRECT_URI=http://localhost:8000/auth/zalo/callback
```

### 3. Test Configuration
```bash
php tests/test_oauth_config.php
```

### 4. Start Server
```bash
php -S localhost:8000 -t public
```

Truy cập: `http://localhost:8000/login`

## 🔗 OAuth Flow

### Google OAuth
```
1. User clicks "Đăng nhập với Google"
   ↓
2. Redirect to Google consent screen
   ↓
3. User authorizes
   ↓
4. Google redirects to /auth/google/callback?code=xxx
   ↓
5. Backend exchanges code for access token
   ↓
6. Fetch user info from Google API
   ↓
7. Create/login user in database
   ↓
8. Set session and redirect to homepage
```

### Zalo OAuth
```
1. User clicks "Đăng nhập với Zalo"
   ↓
2. Redirect to Zalo consent screen
   ↓
3. User authorizes
   ↓
4. Zalo redirects to /auth/zalo/callback?code=xxx
   ↓
5. Backend exchanges code for access token
   ↓
6. Fetch user info from Zalo API
   ↓
7. Create/login user in database
   ↓
8. Set session and redirect to homepage
```

## 📊 Database Schema

### users table (updated)
```sql
id              SERIAL PRIMARY KEY
username        VARCHAR(100)
email           VARCHAR(256)
password_hash   VARCHAR(512)      -- NULL for OAuth users
role            VARCHAR(20)
oauth_provider  VARCHAR(20)       -- 'google' | 'zalo' | NULL
oauth_id        VARCHAR(256)      -- ID from provider
avatar_url      VARCHAR(512)      -- Profile picture URL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

## 🎨 Frontend UI

### Login/Register Pages
- Traditional email/password form
- Divider: "hoặc đăng nhập với"
- Google button (white with Google colors)
- Zalo button (blue with Zalo branding)

### CSS Classes
- `.oauth-divider` - Horizontal divider
- `.oauth-buttons` - Button container
- `.btn-google` - Google button style
- `.btn-zalo` - Zalo button style

## 🔧 API Endpoints

```
GET  /auth/google              → Redirect to Google
GET  /auth/google/callback     → Handle Google callback
GET  /auth/zalo                → Redirect to Zalo
GET  /auth/zalo/callback       → Handle Zalo callback
```

## 🛡️ Security Features

- ✅ CSRF protection via state parameter
- ✅ Secure token exchange
- ✅ OAuth provider validation
- ✅ Email uniqueness check
- ✅ Session regeneration after login

## ⚠️ Important Notes

### Zalo Email Issue
Zalo không cung cấp email của user. Hệ thống tạo email placeholder:
```
zalo_{user_id}@placeholder.com
```

**Solution**: Yêu cầu user cập nhật email thật trong profile sau khi đăng ký.

### Password Field
OAuth users có `password_hash = NULL`. Không thể đăng nhập bằng password.

### Duplicate Email
Nếu user đã đăng ký bằng password với email X, không thể dùng OAuth với email X (báo lỗi).

## 🧪 Testing

### Manual Testing Checklist
- [ ] Google login - new user
- [ ] Google login - existing user
- [ ] Zalo login - new user
- [ ] Zalo login - existing user
- [ ] Duplicate email error
- [ ] Session persistence
- [ ] Logout and re-login
- [ ] Profile shows OAuth provider

### Test Accounts
Tạo test accounts trên Google/Zalo để test.

## 📝 Helper Functions

```php
// Check if current user is OAuth user
is_oauth_user(): bool

// Get OAuth provider
get_oauth_provider(): ?string  // 'google', 'zalo', or null

// Format provider name
format_oauth_provider('google')  // returns 'Google'
```

## 🐛 Troubleshooting

### "Redirect URI mismatch"
→ Kiểm tra Redirect URI trong console/settings khớp với `.env`

### "Invalid client credentials"
→ Kiểm tra lại Client ID/Secret trong `.env`

### "cURL error"
→ Enable PHP cURL extension

### "Email đã được sử dụng"
→ User đã tồn tại với phương thức đăng nhập khác

## 📚 Documentation

Xem chi tiết: [OAUTH_SETUP.md](./OAUTH_SETUP.md)

## 🤝 Contributing

Khi thêm OAuth provider mới:
1. Update `OAuthService.php`
2. Add routes in `routes.php`
3. Add methods in `AuthController.php`
4. Update database constraints
5. Add UI buttons
6. Update documentation

## 📄 License

MIT License - Same as main project
