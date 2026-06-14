# Changelog

All notable changes to CinemaX project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2024-XX-XX

### 🎉 Added - OAuth Integration

#### Authentication
- **Google OAuth 2.0 Login/Register** - Users can now sign in with their Google account
- **Zalo OAuth Login/Register** - Users can now sign in with their Zalo account
- OAuth session management with provider tracking
- Automatic avatar sync from OAuth providers
- OAuth user detection helpers

#### Backend
- `OAuthService` class for handling Google and Zalo OAuth flows
- `authenticateWithOAuth()` method in UserService
- `findByOAuth()` method in UserRepository
- OAuth-related properties in User model (`oauthProvider`, `oauthId`, `avatarUrl`)
- Helper functions: `is_oauth_user()`, `get_oauth_provider()`, `format_oauth_provider()`

#### Database
- `oauth_provider` column in users table (varchar 20)
- `oauth_id` column in users table (varchar 256)
- `avatar_url` column in users table (varchar 512)
- Unique composite index on (oauth_provider, oauth_id)
- Constraint for valid OAuth providers
- Migration script: `009_add_oauth_to_users.sql`
- Rollback script: `009_rollback_oauth.sql`

#### Routes
- `GET /auth/google` - Redirect to Google OAuth
- `GET /auth/google/callback` - Handle Google callback
- `GET /auth/zalo` - Redirect to Zalo OAuth
- `GET /auth/zalo/callback` - Handle Zalo callback

#### Frontend
- OAuth buttons on login page
- OAuth buttons on register page
- Custom OAuth CSS styling (`oauth.css`)
- OAuth JavaScript handlers (`oauth.js`)
- User avatar component with OAuth badge
- Loading states for OAuth buttons
- Error handling for OAuth failures

#### Documentation
- `OAUTH_SETUP.md` - Comprehensive setup guide
- `README_OAUTH.md` - Overview and quick reference
- `OAUTH_INTEGRATION_SUMMARY.md` - Complete integration summary
- `DEPLOYMENT_CHECKLIST.md` - Production deployment guide
- `QUICK_START_OAUTH.md` - 5-minute quick start
- `.env.oauth.example` - Detailed environment example

#### Testing
- `test_oauth_config.php` - OAuth configuration test script
- Test coverage for OAuth flows
- Validation for OAuth credentials

### 🔧 Changed

#### User Model
- `password_hash` is now nullable (OAuth users don't have passwords)
- Added `isOAuthUser()` method
- Added `getAvatarUrl()` method with fallback

#### UserRepository
- `create()` method now supports dynamic fields
- Enhanced to handle OAuth user creation

#### Layout
- Main layout now includes `oauth.css` and `oauth.js`

#### Environment
- `.env.example` updated with OAuth credentials template

### 🔐 Security
- CSRF protection for OAuth flows using state parameter
- Secure token exchange with OAuth providers
- Session regeneration after OAuth login
- Input validation for OAuth data
- SQL injection protection via prepared statements

### 🎨 UI/UX
- Beautiful Google button with official branding
- Custom Zalo button with brand colors
- Smooth loading animations
- Mobile-responsive OAuth buttons
- Dark theme compatible styling
- OAuth provider badges on user avatars

### 📝 Notes
- Zalo does not provide user email - system creates placeholder email
- OAuth users cannot reset password (no password set)
- Email uniqueness is enforced across all authentication methods

### ⚠️ Known Issues
- Zalo users receive placeholder email: `zalo_{user_id}@placeholder.com`
- Account linking (multiple OAuth providers per account) not yet supported

---

## [1.0.0] - 2024-XX-XX

### Added
- Initial release
- Movie ticket booking system
- User authentication (email/password)
- Seat selection
- Payment processing
- Admin dashboard
- Movie management
- Showtime management
- Room management
- Promotion codes
- User profile
- Ticket history
- Responsive UI with Bootstrap 5
- PostgreSQL database
- Session management
- CSRF protection

### Features
- Browse movies (now showing / coming soon)
- View movie details
- Select showtimes
- Interactive seat map
- Real-time seat availability
- Booking hold system (15-minute timer)
- Apply promotion codes
- Payment confirmation
- Ticket QR code generation
- Transaction history
- Admin user management

---

## Version History

- **v1.1.0** - OAuth Integration (Google & Zalo)
- **v1.0.0** - Initial Release

---

## Upgrade Guide

### From v1.0.0 to v1.1.0

1. **Backup database**:
   ```bash
   pg_dump cinema_db > backup_v1.0.0.sql
   ```

2. **Run migration**:
   ```bash
   psql -U postgres -d cinema_db -f database/migrations/009_add_oauth_to_users.sql
   ```

3. **Update .env**:
   ```env
   GOOGLE_CLIENT_ID=...
   GOOGLE_CLIENT_SECRET=...
   GOOGLE_REDIRECT_URI=...
   ZALO_APP_ID=...
   ZALO_APP_SECRET=...
   ZALO_REDIRECT_URI=...
   ```

4. **Test**:
   ```bash
   php tests/test_oauth_config.php
   ```

5. **Deploy**:
   - Update code
   - Clear cache (if any)
   - Restart server
   - Test OAuth flows

---

## Rollback Guide

### From v1.1.0 to v1.0.0

1. **Backup database**:
   ```bash
   pg_dump cinema_db > backup_v1.1.0.sql
   ```

2. **Run rollback script**:
   ```bash
   psql -U postgres -d cinema_db -f database/migrations/009_rollback_oauth.sql
   ```

3. **Revert code**:
   ```bash
   git checkout v1.0.0
   ```

4. **Remove OAuth configs from .env**

5. **Restart server**

**⚠️ Warning**: OAuth users will not be able to login after rollback!

---

## Contributing

When adding new features:
1. Update this CHANGELOG.md
2. Follow [Semantic Versioning](https://semver.org/)
3. Use [Conventional Commits](https://www.conventionalcommits.org/)
4. Add tests for new features
5. Update documentation

---

## Links

- **Repository**: [GitHub Repository URL]
- **Documentation**: See `/docs` folder
- **Issues**: [GitHub Issues URL]
- **Discussions**: [GitHub Discussions URL]

---

**Note**: This changelog is maintained by the CinemaX development team.
