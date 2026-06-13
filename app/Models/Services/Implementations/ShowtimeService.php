<?php
namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IShowtimeService;
use App\Models\Repository\Interfaces\IShowtimeRepository;

class ShowtimeService implements IShowtimeService
{
    public function __construct(private readonly IShowtimeRepository $showtimeRepo) {}

    public function getAllShowtimesAdmin(): array
    {
        return $this->showtimeRepo->getAllAdmin();
    }

    public function createShowtime(array $data): int
    {
        return $this->showtimeRepo->create($data);
    }

    public function updateShowtime(int $id, array $data): bool
    {
        return $this->showtimeRepo->update($id, $data);
    }

    public function deleteShowtime(int $id): bool
    {
        return $this->showtimeRepo->delete($id);
    }
}
