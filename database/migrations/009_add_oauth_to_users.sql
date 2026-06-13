-- Migration: Add OAuth support to users table
-- Date: 2024-01-XX

-- Add OAuth columns to users table
ALTER TABLE users
    ADD COLUMN oauth_provider VARCHAR(20) DEFAULT NULL,
    ADD COLUMN oauth_id VARCHAR(256) DEFAULT NULL,
    ADD COLUMN avatar_url VARCHAR(512) DEFAULT NULL;

-- Make password_hash nullable (OAuth users don't have password)
ALTER TABLE users
    ALTER COLUMN password_hash DROP NOT NULL;

-- Create composite unique index for OAuth lookup
CREATE UNIQUE INDEX ux_users_oauth ON users(oauth_provider, oauth_id)
    WHERE oauth_provider IS NOT NULL;

-- Add constraint to check oauth_provider value
ALTER TABLE users
    ADD CONSTRAINT chk_users_oauth_provider 
    CHECK (oauth_provider IS NULL OR oauth_provider IN ('google', 'zalo'));

-- Add comments for documentation
COMMENT ON COLUMN users.oauth_provider IS 'OAuth provider: google, zalo, or NULL for password auth';
COMMENT ON COLUMN users.oauth_id IS 'User ID from OAuth provider';
COMMENT ON COLUMN users.avatar_url IS 'User avatar/profile picture URL';
