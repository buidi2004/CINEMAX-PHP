<?php
namespace App\Models\Repository\Implementations;

use App\Models\Repository\Interfaces\IShowtimeRepository;
use App\Models\Domain\Showtime;
use App\Models\Domain\Room;
use App\Models\Domain\Movie;
use PDO;

class ShowtimeRepository implements IShowtimeRepository
{
    public function __construct(private readonly PDO $pdo) {}

    public function getByMovieAndDate(int $movieId, string $date): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, r.name AS room_name, r.total_rows, r.seats_per_row
             FROM showtimes s
             JOIN rooms r ON r.id = s.room_id
             WHERE s.movie_id = ?
               AND s.show_date = ?
             ORDER BY s.start_time'
        );
        $stmt->execute([$movieId, $date]);
        $rows = $stmt->fetchAll();

        $showtimes = [];
        foreach ($rows as $row) {
            $showtime = Showtime::fromArray($row);

            $room = new Room();
            $room->id = $row['room_id'];
            $room->name = $row['room_name'];
            $room->totalRows = $row['total_rows'];
            $room->seatsPerRow = $row['seats_per_row'];
            $showtime->room = $room;

            $showtimes[] = $showtime;
        }
        return $showtimes;
    }

    public function findById(int $id): ?Showtime
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, r.name AS room_name, r.total_rows, r.seats_per_row,
                    m.title AS movie_title, m.poster_url, m.genre, m.status AS movie_status,
                    m.duration_minutes, m.description AS movie_description, m.age_rating
             FROM showtimes s
             JOIN rooms r ON r.id = s.room_id
             JOIN movies m ON m.id = s.movie_id
             WHERE s.id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;

        $showtime = Showtime::fromArray($row);

        $room = new Room();
        $room->id = $row['room_id'];
        $room->name = $row['room_name'];
        $room->totalRows = $row['total_rows'];
        $room->seatsPerRow = $row['seats_per_row'];
        $showtime->room = $room;

        $movie = new Movie();
        $movie->id = $row['movie_id'];
        $movie->title = $row['movie_title'];
        $movie->posterUrl = $row['poster_url'];
        $movie->genre = $row['genre'];
        $movie->status = $row['movie_status'];
        $movie->durationMinutes = $row['duration_minutes'];
        $movie->description = $row['movie_description'];
        $movie->ageRating = $row['age_rating'];
        $showtime->movie = $movie;

        return $showtime;
    }

    public function getAllAdmin(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, r.name AS room_name, m.title AS movie_title
             FROM showtimes s
             JOIN rooms r ON r.id = s.room_id
             JOIN movies m ON m.id = s.movie_id
             ORDER BY s.show_date DESC, s.start_time DESC'
        );
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $showtimes = [];
        foreach ($rows as $row) {
            $showtime = Showtime::fromArray($row);
            
            $room = new Room();
            $room->name = $row['room_name'];
            $showtime->room = $room;

            $movie = new Movie();
            $movie->title = $row['movie_title'];
            $showtime->movie = $movie;

            $showtimes[] = $showtime;
        }
        return $showtimes;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO showtimes (movie_id, room_id, show_date, start_time, price) 
             VALUES (:movie_id, :room_id, :show_date, :start_time, :price)'
        );
        $stmt->execute([
            'movie_id' => $data['movie_id'],
            'room_id' => $data['room_id'],
            'show_date' => $data['show_date'],
            'start_time' => $data['start_time'],
            'price' => $data['price']
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE showtimes 
             SET movie_id = :movie_id, room_id = :room_id, show_date = :show_date, start_time = :start_time, price = :price
             WHERE id = :id'
        );
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM showtimes WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
    
    public function findByRoomsAndDate(array $roomIds, string $date): array
    {
        if (empty($roomIds)) {
            return [];
        }
        
        $placeholders = implode(',', array_fill(0, count($roomIds), '?'));
        $stmt = $this->pdo->prepare(
            "SELECT s.*, r.name AS room_name, m.title AS movie_title
             FROM showtimes s
             JOIN rooms r ON r.id = s.room_id
             JOIN movies m ON m.id = s.movie_id
             WHERE s.room_id IN ($placeholders)
               AND s.show_date = ?
             ORDER BY s.start_time"
        );
        $params = array_merge($roomIds, [$date]);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }
}
