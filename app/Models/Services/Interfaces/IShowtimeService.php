<?php
namespace App\Models\Services\Interfaces;

interface IShowtimeService
{
    public function getAllShowtimesAdmin(): array;
    public function createShowtime(array $data): int;
    public function updateShowtime(int $id, array $data): bool;
    public function deleteShowtime(int $id): bool;
}
