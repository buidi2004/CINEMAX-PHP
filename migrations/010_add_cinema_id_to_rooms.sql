-- Migration: Add cinema_id to rooms table
-- Date: 2024
-- Description: Liên kết phòng chiếu với rạp

ALTER TABLE rooms
    ADD COLUMN cinema_id INT REFERENCES cinemas(id) ON DELETE SET NULL;

-- Index for foreign key
CREATE INDEX ix_rooms_cinema_id ON rooms(cinema_id);

-- Comment
COMMENT ON COLUMN rooms.cinema_id IS 'Foreign key to cinemas table';
