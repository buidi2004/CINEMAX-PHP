<?php

namespace App\Models\Services\Interfaces;

use App\Models\Domain\Cinema;

interface ICinemaService
{
    /**
     * Get all cinemas with optional province filter
     */
    public function getAll(?string $province = null): array;

    /**
     * Find nearest cinemas based on location
     */
    public function findNearest(float $lat, float $lng, int $limit = 3): array;

    /**
     * Get cinema by slug
     * @throws \App\Core\Exceptions\NotFoundException
     */
    public function getBySlug(string $slug): Cinema;

    /**
     * Get cinema by ID
     * @throws \App\Core\Exceptions\NotFoundException
     */
    public function getById(int $id): Cinema;

    /**
     * Get all provinces
     */
    public function getAllProvinces(): array;

    /**
     * Get rooms by cinema
     */
    public function getRoomsByCinema(int $cinemaId): array;

    /**
     * Get today's showtimes for cinema
     */
    public function getTodayShowtimes(int $cinemaId): array;

    /**
     * Get showtimes by date for cinema
     */
    public function getShowtimesByDate(int $cinemaId, string $date): array;
}
