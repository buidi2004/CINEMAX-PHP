<?php
namespace App\Controllers;

use App\Core\Container;
use App\Core\Session;
use App\Core\Database;

class TicketController extends BaseController
{
    private \PDO $db;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->db = Database::getInstance();
    }

    // GET /my-tickets/{id}
    public function ticketDetail(int $id): void
    {
        $this->requireLogin();
        $userId = $this->getCurrentUserId();

        $stmt = $this->db->prepare("
            SELECT t.*, 
                   m.title AS movie_title, m.poster_url, m.age_rating, m.duration_minutes,
                   s.show_date, s.start_time, s.price,
                   r.name AS room_name
            FROM tickets t
            JOIN showtimes s ON s.id = t.showtime_id
            JOIN movies m ON m.id = s.movie_id
            JOIN rooms r ON r.id = s.room_id
            WHERE t.id = :id AND t.user_id = :user_id
        ");
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        $ticket = $stmt->fetch(\PDO::FETCH_OBJ);

        if (!$ticket) {
            http_response_code(404);
            $this->render('errors.404', ['pageTitle' => 'Không tìm thấy vé']);
            return;
        }

        // Generate ticket code if not exists
        if (!isset($ticket->ticket_code) || empty($ticket->ticket_code)) {
            $ticket->ticket_code = 'CX-' . strtoupper(substr(md5($ticket->id . $ticket->showtime_id), 0, 8));
        }

        // Try to get cinema name
        $cinemaName = 'CinemaX';
        try {
            $cinemaStmt = $this->db->prepare("
                SELECT c.name FROM cinemas c
                JOIN rooms r ON r.cinema_id = c.id
                WHERE r.id = (SELECT room_id FROM showtimes WHERE id = :showtime_id)
            ");
            $cinemaStmt->execute(['showtime_id' => $ticket->showtime_id]);
            $cinema = $cinemaStmt->fetch(\PDO::FETCH_OBJ);
            if ($cinema) {
                $cinemaName = $cinema->name;
            }
        } catch (\Exception $e) {
            // Table might not exist yet, ignore
        }

        $ticket->cinema_name = $cinemaName;

        $this->render('movie.ticket_detail', [
            'ticket'    => $ticket,
            'pageTitle' => 'Chi tiết vé — CinemaX',
        ]);
    }
}
