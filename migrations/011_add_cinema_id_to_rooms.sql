-- migrations/011_add_cinema_id_to_rooms.sql

ALTER TABLE rooms
    ADD COLUMN cinema_id INT,
    ADD CONSTRAINT fk_rooms_cinema FOREIGN KEY (cinema_id) REFERENCES cinemas(id) ON DELETE SET NULL;

CREATE INDEX ix_rooms_cinema_id ON rooms(cinema_id);
