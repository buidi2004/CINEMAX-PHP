<?php

namespace App\Models\Services\Interfaces;

interface IStatisticsService
{
    /**
     * Get dashboard overview statistics
     */
    public function getDashboardStats(): array;

    /**
     * Get revenue by period
     * 
     * @param string $startDate
     * @param string $endDate
     * @param string $groupBy day|month|year
     * @return array
     */
    public function getRevenueByPeriod(string $startDate, string $endDate, string $groupBy = 'day'): array;

    /**
     * Get top selling movies
     * 
     * @param int $limit
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function getTopMovies(int $limit = 10, ?string $startDate = null, ?string $endDate = null): array;

    /**
     * Get cinema performance
     * 
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function getCinemaPerformance(?string $startDate = null, ?string $endDate = null): array;

    /**
     * Get seat occupancy rate
     * 
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function getSeatOccupancy(?string $startDate = null, ?string $endDate = null): array;

    /**
     * Get user registration statistics
     * 
     * @param string $period last7days|last30days|thismonth|thisyear
     * @return array
     */
    public function getUserStats(string $period = 'last30days'): array;
}
