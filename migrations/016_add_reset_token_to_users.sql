-- migrations/016_add_reset_token_to_users.sql
ALTER TABLE users 
    ADD COLUMN reset_token VARCHAR(255) NULL,
    ADD COLUMN reset_token_expires_at TIMESTAMP NULL;
