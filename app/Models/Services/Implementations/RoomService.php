<?php
namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IRoomService;
use App\Models\Repository\Interfaces\IRoomRepository;

class RoomService implements IRoomService
{
    public function __construct(private readonly IRoomRepository $roomRepo) {}

    public function getAllRooms(): array
    {
        return $this->roomRepo->getAll();
    }

    public function getRoomById(int $id)
    {
        return $this->roomRepo->findById($id);
    }

    public function createRoom(array $data): int
    {
        return $this->roomRepo->create($data);
    }

    public function updateRoom(int $id, array $data): bool
    {
        return $this->roomRepo->update($id, $data);
    }

    public function deleteRoom(int $id): bool
    {
        return $this->roomRepo->delete($id);
    }
}
