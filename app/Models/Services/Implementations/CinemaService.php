<?php

namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\ICinemaService;
use App\Models\Repository\Interfaces\ICinemaRepository;
use App\Models\Repository\Interfaces\IShowtimeRepository;
use App\Models\Domain\Cinema;
use App\Core\Exceptions\NotFoundException;

class CinemaService implements ICinemaService
{
    private ICinemaRepository $cinemaRepo;
    private IShowtimeRepository $showtimeRepo;

    public function __construct(
        ICinemaRepository $cinemaRepo,
        IShowtimeRepository $showtimeRepo
    ) {
        $this->cinemaRepo = $cinemaRepo;
        $this->showtimeRepo = $showtimeRepo;
    }

    public function getAll(?string $province = null): array
    {
        return $this->cinemaRepo->findAll($province);
    }

    public function findNearest(float $lat, float $lng, int $limit = 3): array
    {
        return $this->cinemaRepo->findNearest($lat, $lng, $limit);
    }

    public function getBySlug(string $slug): Cinema
    {
        $cinema = $this->cinemaRepo->findBySlug($slug);
        
        if (!$cinema) {
            throw new NotFoundException("Cinema not found: {$slug}");
        }
        
        return $cinema;
    }

    public function getById(int $id): Cinema
    {
        $cinema = $this->cinemaRepo->findById($id);
        
        if (!$cinema) {
            throw new NotFoundException("Cinema not found with ID: {$id}");
        }
        
        return $cinema;
    }

    public function getAllProvinces(): array
    {
        return $this->cinemaRepo->getAllProvinces();
    }

    public function getRoomsByCinema(int $cinemaId): array
    {
        return $this->cinemaRepo->getRoomsByCinema($cinemaId);
    }

    public function getTodayShowtimes(int $cinemaId): array
    {
        $rooms = $this->getRoomsByCinema($cinemaId);
        
        if (empty($rooms)) {
            return [];
        }
        
        $roomIds = array_column($rooms, 'id');
        $today = date('Y-m-d');
        
        return $this->showtimeRepo->findByRoomsAndDate($roomIds, $today);
    }

    public function getShowtimesByDate(int $cinemaId, string $date): array
    {
        $rooms = $this->getRoomsByCinema($cinemaId);
        
        if (empty($rooms)) {
            return [];
        }
        
        $roomIds = array_column($rooms, 'id');
        
        return $this->showtimeRepo->findByRoomsAndDate($roomIds, $date);
    }
}
