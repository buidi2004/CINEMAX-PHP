-- migrations/010_create_cinemas.sql

CREATE TABLE IF NOT EXISTS cinemas (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(200)  NOT NULL,
    slug            VARCHAR(200)  NOT NULL,
    province        VARCHAR(100)  NOT NULL,
    district        VARCHAR(100)  NOT NULL,
    address         VARCHAR(500)  NOT NULL,
    phone           VARCHAR(20),
    email           VARCHAR(256),
    latitude        DECIMAL(10, 8),
    longitude       DECIMAL(11, 8),
    image_url       VARCHAR(512),
    opening_hours   VARCHAR(100)  DEFAULT '08:00 - 23:30',
    description     TEXT,
    facilities      JSON,
    is_active       BOOLEAN       NOT NULL DEFAULT TRUE,
    created_at      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY ux_cinemas_slug (slug),
    INDEX ix_cinemas_province (province),
    INDEX ix_cinemas_active (is_active)
);
