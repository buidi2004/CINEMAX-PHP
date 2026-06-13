-- Migration: Add cinema_id to rooms table
-- Version: 1.0
-- Date: 2024

ALTER TABLE rooms
    ADD COLUMN cinema_id INT REFERENCES cinemas(id) ON DELETE SET NULL;

CREATE INDEX ix_rooms_cinema_id ON rooms(cinema_id);

COMMENT ON COLUMN rooms.cinema_id IS 'Links room to a specific cinema branch';
