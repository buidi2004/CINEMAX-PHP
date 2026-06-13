-- Migration: Create cinemas table
-- Version: 1.0
-- Date: 2024

CREATE TABLE cinemas (
    id              SERIAL PRIMARY KEY,
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
    facilities      TEXT[],
    is_active       BOOLEAN       NOT NULL DEFAULT TRUE,
    created_at      TIMESTAMP     NOT NULL DEFAULT NOW()
);

-- Indexes
CREATE UNIQUE INDEX ux_cinemas_slug ON cinemas(slug);
CREATE INDEX ix_cinemas_province ON cinemas(province);
CREATE INDEX ix_cinemas_active ON cinemas(is_active) WHERE is_active = TRUE;

-- Comments
COMMENT ON TABLE cinemas IS 'Cinema locations/branches';
COMMENT ON COLUMN cinemas.slug IS 'URL-friendly slug for routing';
COMMENT ON COLUMN cinemas.facilities IS 'Array of facilities: IMAX, 4DX, Dolby Atmos, etc.';
