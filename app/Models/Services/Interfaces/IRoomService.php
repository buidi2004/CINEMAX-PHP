<?php
namespace App\Models\Services\Interfaces;

interface IRoomService
{
    public function getAllRooms(): array;
    public function getRoomById(int $id);
    public function createRoom(array $data): int;
    public function updateRoom(int $id, array $data): bool;
    public function deleteRoom(int $id): bool;
}
