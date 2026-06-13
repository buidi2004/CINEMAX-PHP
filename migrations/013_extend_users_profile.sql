-- migrations/013_extend_users_profile.sql

ALTER TABLE users
    ADD COLUMN full_name     VARCHAR(200),
    ADD COLUMN phone         VARCHAR(20),
    ADD COLUMN avatar_url    VARCHAR(512),
    ADD COLUMN date_of_birth DATE,
    ADD COLUMN gender        VARCHAR(10) DEFAULT 'other',
    ADD COLUMN city          VARCHAR(100),
    ADD COLUMN loyalty_points INT NOT NULL DEFAULT 0,
    ADD COLUMN member_level  VARCHAR(20) NOT NULL DEFAULT 'bronze',
    ADD COLUMN total_spent   DECIMAL(12, 0) NOT NULL DEFAULT 0;

-- Create news table for blog/news section
CREATE TABLE IF NOT EXISTS news (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    title           VARCHAR(300)  NOT NULL,
    slug            VARCHAR(300)  NOT NULL,
    excerpt         TEXT,
    content         TEXT          NOT NULL,
    image_url       VARCHAR(512),
    category        VARCHAR(50)   DEFAULT 'general',
    is_featured     BOOLEAN       NOT NULL DEFAULT FALSE,
    views           INT           NOT NULL DEFAULT 0,
    published_at    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    created_at      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY ux_news_slug (slug),
    INDEX ix_news_published (published_at)
);

-- Create contact_messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(200)  NOT NULL,
    email       VARCHAR(256)  NOT NULL,
    subject     VARCHAR(100),
    message     TEXT          NOT NULL,
    is_read     BOOLEAN       NOT NULL DEFAULT FALSE,
    created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
);
