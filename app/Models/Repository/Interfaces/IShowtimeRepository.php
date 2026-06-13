<?php
namespace App\Models\Repository\Interfaces;

use App\Models\Domain\Showtime;

interface IShowtimeRepository
{
    public function getByMovieAndDate(int $movieId, string $date): array;
    public function findById(int $id): ?Showtime;
    public function getAllAdmin(): array;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function findByRoomsAndDate(array $roomIds, string $date): array;
}
