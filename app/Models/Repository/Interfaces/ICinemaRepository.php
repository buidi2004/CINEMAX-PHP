<?php
namespace App\Models\Repository\Interfaces;

use App\Models\Domain\Cinema;

interface ICinemaRepository
{
    /**
     * Get all cinemas, optionally filtered by province
     * @param string|null $province
     * @return Cinema[]
     */
    public function findAll(?string $province = null): array;
    
    /**
     * Find cinema by ID
     * @param int $id
     * @return Cinema|null
     */
    public function findById(int $id): ?Cinema;
    
    /**
     * Find cinema by slug (URL-friendly identifier)
     * @param string $slug
     * @return Cinema|null
     */
    public function findBySlug(string $slug): ?Cinema;
    
    /**
     * Get list of all provinces that have cinemas
     * @return string[]
     */
    public function getAllProvinces(): array;
    
    /**
     * Get all rooms in a specific cinema
     * @param int $cinemaId
     * @return array
     */
    public function getRoomsByCinema(int $cinemaId): array;
    
    /**
     * Create new cinema
     * @param array $data
     * @return int Cinema ID
     */
    public function create(array $data): int;
    
    /**
     * Update cinema
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;
    
    /**
     * Soft delete cinema (set is_active = false)
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool;
    
    /**
     * Hard delete cinema
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
