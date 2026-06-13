# ⚡ Quick Start - OAuth Integration

## 🎯 5 Phút Setup

### Bước 1: Chạy Migration (1 phút)
```bash
# PostgreSQL
psql -U postgres -d cinema_db -f database/migrations/009_add_oauth_to_users.sql

# MySQL
mysql -u root -p cinema_db < database/migrations/009_add_oauth_to_users.sql
```

### Bước 2: Copy .env (30 giây)
```bash
cp .env.example .env
```

### Bước 3: Lấy Google Credentials (2 phút)
1. Vào: https://console.cloud.google.com/
2. Tạo project hoặc chọn project có sẵn
3. **APIs & Services** → **Credentials** → **Create OAuth Client ID**
4. **Web application**:
   - Authorized origins: `http://localhost:8000`
   - Redirect URIs: `http://localhost:8000/auth/google/callback`
5. Copy **Client ID** và **Client Secret**

### Bước 4: Lấy Zalo Credentials (2 phút)
1. Vào: https://developers.zalo.me/
2. **Tạo ứng dụng** → **Website**
3. Điền thông tin app
4. **OAuth Settings**:
   - Callback URL: `http://localhost:8000/auth/zalo/callback`
5. Copy **App ID** và **Secret Key**

### Bước 5: Cấu hình .env (30 giây)
```env
# Google
GOOGLE_CLIENT_ID=paste-your-client-id-here
GOOGLE_CLIENT_SECRET=paste-your-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Zalo
ZALO_APP_ID=paste-your-app-id-here
ZALO_APP_SECRET=paste-your-secret-here
ZALO_REDIRECT_URI=http://localhost:8000/auth/zalo/callback
```

### Bước 6: Test (1 phút)
```bash
# Test config
php tests/test_oauth_config.php

# Nếu thấy ✅ → OK!
# Nếu thấy ❌ → Check lại credentials
```

### Bước 7: Start Server (10 giây)
```bash
php -S localhost:8000 -t public
```

### Bước 8: Test Login (1 phút)
1. Mở: http://localhost:8000/login
2. Click "Đăng nhập với Google"
3. Authorize → Redirect về homepage
4. ✅ Done!

---

## 🎨 Demo URLs

- Login: http://localhost:8000/login
- Register: http://localhost:8000/register
- Google OAuth: http://localhost:8000/auth/google
- Zalo OAuth: http://localhost:8000/auth/zalo

---

## ✅ Checklist

- [ ] Migration chạy thành công
- [ ] .env có Google credentials
- [ ] .env có Zalo credentials
- [ ] Test script pass
- [ ] Server đang chạy
- [ ] Login page hiển thị nút OAuth
- [ ] Google login works
- [ ] Zalo login works

---

## 🐛 Quick Fix

### Lỗi: "Redirect URI mismatch"
```bash
# Check .env
cat .env | grep REDIRECT_URI

# Phải khớp với console settings!
```

### Lỗi: "Invalid credentials"
```bash
# Check credentials trong .env
cat .env | grep CLIENT_ID
cat .env | grep APP_ID

# Copy lại từ console/developers portal
```

### Lỗi: "cURL error"
```bash
# Check cURL
php -m | grep curl

# Nếu không có → enable trong php.ini
# extension=curl
```

---

## 📖 Full Documentation

Need more details? Check:
- **OAUTH_SETUP.md** - Chi tiết setup
- **README_OAUTH.md** - Overview và API
- **OAUTH_INTEGRATION_SUMMARY.md** - Tổng hợp changes
- **DEPLOYMENT_CHECKLIST.md** - Production deployment

---

## 💡 Tips

- Google cung cấp email → Auto fill
- Zalo không có email → Placeholder email
- OAuth users không có password
- Avatar tự động sync từ provider
- Session lifetime: 2 hours (configurable)

---

## 🚨 Important

**Development**: OK to use http://localhost
**Production**: MUST use https://yourdomain.com

Update .env for production:
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
ZALO_REDIRECT_URI=https://yourdomain.com/auth/zalo/callback
```

---

## 🎉 Done!

Bây giờ bạn đã có OAuth working!

Test thử các scenarios:
- ✅ New user login with Google
- ✅ New user login with Zalo
- ✅ Existing user login
- ✅ Logout and re-login
- ✅ Check database có user mới

Happy coding! 🚀
