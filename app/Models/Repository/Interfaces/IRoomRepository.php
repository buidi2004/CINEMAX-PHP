<?php
namespace App\Models\Repository\Interfaces;

use App\Models\Domain\Room;

interface IRoomRepository
{
    public function getAll(): array;
    public function findById(int $id): ?Room;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
