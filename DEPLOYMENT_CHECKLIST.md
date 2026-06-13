# 📋 Deployment Checklist - OAuth Integration

## Pre-Deployment

### 1. Database Migration
- [ ] Backup current database
- [ ] Run migration script
  ```bash
  psql -U postgres -d cinema_db -f database/migrations/009_add_oauth_to_users.sql
  ```
- [ ] Verify new columns exist
  ```sql
  SELECT column_name, data_type 
  FROM information_schema.columns 
  WHERE table_name = 'users' 
  AND column_name IN ('oauth_provider', 'oauth_id', 'avatar_url');
  ```

### 2. Google OAuth Setup
- [ ] Go to [Google Cloud Console](https://console.cloud.google.com/)
- [ ] Create/select project
- [ ] Enable Google+ API
- [ ] Create OAuth 2.0 Client ID
- [ ] Add authorized JavaScript origins
  - Development: `http://localhost:8000`
  - Production: `https://yourdomain.com`
- [ ] Add authorized redirect URIs
  - Development: `http://localhost:8000/auth/google/callback`
  - Production: `https://yourdomain.com/auth/google/callback`
- [ ] Copy Client ID and Secret

### 3. Zalo OAuth Setup
- [ ] Go to [Zalo Developers](https://developers.zalo.me/)
- [ ] Create new application
- [ ] Add website URL
  - Development: `http://localhost:8000`
  - Production: `https://yourdomain.com`
- [ ] Add OAuth callback URL
  - Development: `http://localhost:8000/auth/zalo/callback`
  - Production: `https://yourdomain.com/auth/zalo/callback`
- [ ] Copy App ID and Secret

### 4. Environment Configuration
- [ ] Copy `.env.example` to `.env`
- [ ] Add Google credentials
  ```env
  GOOGLE_CLIENT_ID=...
  GOOGLE_CLIENT_SECRET=...
  GOOGLE_REDIRECT_URI=...
  ```
- [ ] Add Zalo credentials
  ```env
  ZALO_APP_ID=...
  ZALO_APP_SECRET=...
  ZALO_REDIRECT_URI=...
  ```
- [ ] Verify `.env` is in `.gitignore`

### 5. Test Configuration
- [ ] Run test script
  ```bash
  php tests/test_oauth_config.php
  ```
- [ ] Check all credentials are loaded
- [ ] Check cURL extension is enabled
- [ ] Verify OAuth URLs are generated correctly

## Testing

### 6. Local Testing
- [ ] Start development server
  ```bash
  php -S localhost:8000 -t public
  ```
- [ ] Test Google login flow
  - [ ] Click "Đăng nhập với Google"
  - [ ] Authorize in Google
  - [ ] Verify redirect to homepage
  - [ ] Check user created in database
  - [ ] Verify `oauth_provider = 'google'`
  - [ ] Check avatar_url is saved
  
- [ ] Test Zalo login flow
  - [ ] Click "Đăng nhập với Zalo"
  - [ ] Authorize in Zalo
  - [ ] Verify redirect to homepage
  - [ ] Check user created in database
  - [ ] Verify `oauth_provider = 'zalo'`
  - [ ] Note: Email will be placeholder

- [ ] Test existing user scenarios
  - [ ] Login with existing Google user
  - [ ] Login with existing Zalo user
  - [ ] Try to login with email already used by password user

- [ ] Test logout
  - [ ] Logout OAuth user
  - [ ] Verify session cleared
  - [ ] Re-login with OAuth

### 7. UI/UX Testing
- [ ] Login page displays OAuth buttons correctly
- [ ] Register page displays OAuth buttons correctly
- [ ] Buttons have proper styling (Google white, Zalo blue)
- [ ] Icons display correctly
- [ ] Loading states work
- [ ] Error messages display properly
- [ ] Mobile responsive design works

### 8. Security Testing
- [ ] CSRF protection works
- [ ] Can't access OAuth callbacks without code
- [ ] Session regeneration after login
- [ ] OAuth tokens not exposed
- [ ] Database queries use prepared statements

## Production Deployment

### 9. Code Deployment
- [ ] Merge OAuth branch to main
- [ ] Tag release version
  ```bash
  git tag -a v1.1.0 -m "Add OAuth support"
  git push origin v1.1.0
  ```
- [ ] Deploy to production server

### 10. Production OAuth Setup
- [ ] Update Google OAuth settings
  - [ ] Add production domain to authorized origins
  - [ ] Add production callback URL
- [ ] Update Zalo OAuth settings
  - [ ] Add production domain
  - [ ] Add production callback URL
- [ ] Update production `.env`
  ```env
  GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
  ZALO_REDIRECT_URI=https://yourdomain.com/auth/zalo/callback
  APP_ENV=production
  APP_DEBUG=false
  SESSION_SECURE=true
  ```

### 11. Production Database
- [ ] Backup production database
- [ ] Run migration on production
- [ ] Verify migration successful
- [ ] Test database constraints

### 12. Production Testing
- [ ] Test Google OAuth on production
- [ ] Test Zalo OAuth on production
- [ ] Test all edge cases
- [ ] Monitor error logs
- [ ] Check performance

### 13. Monitoring
- [ ] Set up error logging for OAuth failures
- [ ] Monitor OAuth conversion rates
- [ ] Track which provider is used more
- [ ] Monitor database growth

## Post-Deployment

### 14. Documentation
- [ ] Update user documentation
- [ ] Update API documentation
- [ ] Document OAuth flow
- [ ] Create troubleshooting guide

### 15. User Communication
- [ ] Announce new OAuth login option
- [ ] Create help articles
- [ ] Update FAQ
- [ ] Send email to existing users

### 16. Analytics
- [ ] Track OAuth usage
  - Google vs Zalo vs Password
- [ ] Monitor conversion rates
- [ ] Track registration sources
- [ ] Analyze user preferences

## Rollback Plan

### If Issues Occur
- [ ] Have rollback script ready
  ```bash
  psql -U postgres -d cinema_db -f database/migrations/009_rollback_oauth.sql
  ```
- [ ] Keep previous version tagged
- [ ] Document rollback procedure
- [ ] Test rollback in staging first

## Success Criteria

### Must Have
- ✅ Google OAuth works end-to-end
- ✅ Zalo OAuth works end-to-end
- ✅ Database stores OAuth data correctly
- ✅ No security vulnerabilities
- ✅ Mobile responsive

### Nice to Have
- ✅ Fast OAuth flow (< 3 seconds)
- ✅ Beautiful UI
- ✅ Error messages are helpful
- ✅ Analytics tracking

## Support

### Common Issues

**Issue**: Redirect URI mismatch
**Solution**: Check redirect URI in console matches .env exactly

**Issue**: Invalid client credentials
**Solution**: Verify credentials in .env are correct

**Issue**: cURL error
**Solution**: Enable PHP cURL extension

**Issue**: Email already exists
**Solution**: Expected - user registered with password first

### Contact
- Dev Team: [your-team@email.com]
- Documentation: README_OAUTH.md
- Setup Guide: OAUTH_SETUP.md

---

## Sign-off

- [ ] Developer tested: ________________ Date: ________
- [ ] QA approved: ________________ Date: ________
- [ ] Product owner approved: ________________ Date: ________
- [ ] Deployed to production: ________________ Date: ________
