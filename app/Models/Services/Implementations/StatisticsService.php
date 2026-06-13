<?php

namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IStatisticsService;
use App\Core\Database;
use PDO;

class StatisticsService implements IStatisticsService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getDashboardStats(): array
    {
        // Total revenue (confirmed tickets)
        $revenueStmt = $this->db->query("
            SELECT COALESCE(SUM(price), 0) as total_revenue
            FROM tickets
            WHERE status = 'confirmed'
        ");
        $totalRevenue = $revenueStmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];

        // Today's revenue
        $todayRevenueStmt = $this->db->query("
            SELECT COALESCE(SUM(price), 0) as today_revenue
            FROM tickets
            WHERE status = 'confirmed'
            AND DATE(created_at) = CURRENT_DATE
        ");
        $todayRevenue = $todayRevenueStmt->fetch(PDO::FETCH_ASSOC)['today_revenue'];

        // Total tickets sold
        $ticketsStmt = $this->db->query("
            SELECT COUNT(*) as total_tickets
            FROM tickets
            WHERE status = 'confirmed'
        ");
        $totalTickets = $ticketsStmt->fetch(PDO::FETCH_ASSOC)['total_tickets'];

        // Today's tickets
        $todayTicketsStmt = $this->db->query("
            SELECT COUNT(*) as today_tickets
            FROM tickets
            WHERE status = 'confirmed'
            AND DATE(created_at) = CURRENT_DATE
        ");
        $todayTickets = $todayTicketsStmt->fetch(PDO::FETCH_ASSOC)['today_tickets'];

        // Total users
        $usersStmt = $this->db->query("SELECT COUNT(*) as total_users FROM users");
        $totalUsers = $usersStmt->fetch(PDO::FETCH_ASSOC)['total_users'];

        // Active movies
        $moviesStmt = $this->db->query("
            SELECT COUNT(*) as active_movies
            FROM movies
            WHERE is_active = true
            AND release_date <= CURRENT_DATE
        ");
        $activeMovies = $moviesStmt->fetch(PDO::FETCH_ASSOC)['active_movies'];

        // Upcoming showtimes today
        $showtimesStmt = $this->db->query("
            SELECT COUNT(*) as today_showtimes
            FROM showtimes
            WHERE DATE(show_datetime) = CURRENT_DATE
        ");
        $todayShowtimes = $showtimesStmt->fetch(PDO::FETCH_ASSOC)['today_showtimes'];

        // Average ticket price
        $avgPriceStmt = $this->db->query("
            SELECT COALESCE(AVG(price), 0) as avg_price
            FROM tickets
            WHERE status = 'confirmed'
        ");
        $avgPrice = $avgPriceStmt->fetch(PDO::FETCH_ASSOC)['avg_price'];

        return [
            'total_revenue' => (float)$totalRevenue,
            'today_revenue' => (float)$todayRevenue,
            'total_tickets' => (int)$totalTickets,
            'today_tickets' => (int)$todayTickets,
            'total_users' => (int)$totalUsers,
            'active_movies' => (int)$activeMovies,
            'today_showtimes' => (int)$todayShowtimes,
            'avg_ticket_price' => (float)$avgPrice
        ];
    }

    public function getRevenueByPeriod(string $startDate, string $endDate, string $groupBy = 'day'): array
    {
        $dateFormat = match ($groupBy) {
            'day' => "DATE(created_at)",
            'month' => "DATE_TRUNC('month', created_at)::date",
            'year' => "DATE_TRUNC('year', created_at)::date",
            default => "DATE(created_at)"
        };

        $stmt = $this->db->prepare("
            SELECT 
                {$dateFormat} as period,
                COUNT(*) as tickets_count,
                SUM(price) as revenue
            FROM tickets
            WHERE status = 'confirmed'
            AND created_at BETWEEN :start_date AND :end_date
            GROUP BY period
            ORDER BY period ASC
        ");

        $stmt->execute([
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopMovies(int $limit = 10, ?string $startDate = null, ?string $endDate = null): array
    {
        $dateFilter = '';
        $params = ['limit' => $limit];

        if ($startDate && $endDate) {
            $dateFilter = "AND t.created_at BETWEEN :start_date AND :end_date";
            $params['start_date'] = $startDate;
            $params['end_date'] = $endDate;
        }

        $stmt = $this->db->prepare("
            SELECT 
                m.id,
                m.title,
                m.poster_url,
                COUNT(t.id) as tickets_sold,
                SUM(t.price) as total_revenue,
                AVG(t.price) as avg_price
            FROM movies m
            INNER JOIN showtimes s ON s.movie_id = m.id
            INNER JOIN tickets t ON t.showtime_id = s.id
            WHERE t.status = 'confirmed'
            {$dateFilter}
            GROUP BY m.id, m.title, m.poster_url
            ORDER BY tickets_sold DESC
            LIMIT :limit
        ");

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCinemaPerformance(?string $startDate = null, ?string $endDate = null): array
    {
        $dateFilter = '';
        $params = [];

        if ($startDate && $endDate) {
            $dateFilter = "AND t.created_at BETWEEN :start_date AND :end_date";
            $params['start_date'] = $startDate;
            $params['end_date'] = $endDate;
        }

        $stmt = $this->db->prepare("
            SELECT 
                c.id,
                c.name,
                c.province,
                COUNT(t.id) as tickets_sold,
                SUM(t.price) as total_revenue,
                COUNT(DISTINCT s.id) as total_showtimes
            FROM cinemas c
            INNER JOIN rooms r ON r.cinema_id = c.id
            INNER JOIN showtimes s ON s.room_id = r.id
            INNER JOIN tickets t ON t.showtime_id = s.id
            WHERE t.status = 'confirmed'
            {$dateFilter}
            GROUP BY c.id, c.name, c.province
            ORDER BY total_revenue DESC
        ");

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSeatOccupancy(?string $startDate = null, ?string $endDate = null): array
    {
        $dateFilter = '';
        $params = [];

        if ($startDate && $endDate) {
            $dateFilter = "AND s.show_datetime BETWEEN :start_date AND :end_date";
            $params['start_date'] = $startDate;
            $params['end_date'] = $endDate;
        }

        $stmt = $this->db->prepare("
            SELECT 
                DATE(s.show_datetime) as date,
                COUNT(DISTINCT s.id) as total_showtimes,
                SUM(r.total_seats) as total_capacity,
                COUNT(t.id) as seats_sold,
                ROUND(COUNT(t.id)::numeric / SUM(r.total_seats)::numeric * 100, 2) as occupancy_rate
            FROM showtimes s
            INNER JOIN rooms r ON r.id = s.room_id
            LEFT JOIN tickets t ON t.showtime_id = s.id AND t.status = 'confirmed'
            WHERE s.show_datetime >= CURRENT_DATE - INTERVAL '30 days'
            {$dateFilter}
            GROUP BY DATE(s.show_datetime)
            ORDER BY date DESC
        ");

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserStats(string $period = 'last30days'): array
    {
        $dateFilter = match ($period) {
            'last7days' => "created_at >= CURRENT_DATE - INTERVAL '7 days'",
            'last30days' => "created_at >= CURRENT_DATE - INTERVAL '30 days'",
            'thismonth' => "DATE_TRUNC('month', created_at) = DATE_TRUNC('month', CURRENT_DATE)",
            'thisyear' => "DATE_TRUNC('year', created_at) = DATE_TRUNC('year', CURRENT_DATE)",
            default => "created_at >= CURRENT_DATE - INTERVAL '30 days'"
        };

        $stmt = $this->db->query("
            SELECT 
                DATE(created_at) as date,
                COUNT(*) as new_users
            FROM users
            WHERE {$dateFilter}
            GROUP BY DATE(created_at)
            ORDER BY date ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
