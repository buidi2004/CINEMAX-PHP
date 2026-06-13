-- Rollback Migration: Remove OAuth support from users table
-- Use this if you need to rollback the OAuth changes
-- WARNING: This will drop OAuth-related columns and data

-- Drop constraints
ALTER TABLE users
    DROP CONSTRAINT IF EXISTS chk_users_oauth_provider;

-- Drop indexes
DROP INDEX IF EXISTS ux_users_oauth;

-- Drop columns
ALTER TABLE users
    DROP COLUMN IF EXISTS oauth_provider,
    DROP COLUMN IF EXISTS oauth_id,
    DROP COLUMN IF EXISTS avatar_url;

-- Make password_hash NOT NULL again (optional, only if reverting completely)
-- WARNING: This will fail if there are OAuth users without passwords
-- ALTER TABLE users
--     ALTER COLUMN password_hash SET NOT NULL;

-- Note: OAuth users in the database will remain but will not be able to login
-- You may want to manually delete or migrate these users
