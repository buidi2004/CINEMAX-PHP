<?php
namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IMovieService;
use App\Models\Repository\Interfaces\IMovieRepository;
use App\Models\Repository\Interfaces\IShowtimeRepository;
use App\Models\Repository\Interfaces\ITicketRepository;
use App\Models\Domain\Movie;
use App\ViewModels\SeatMapViewModel;
use App\ViewModels\ShowtimeSummary;
use App\Core\Exceptions\NotFoundException;

class MovieService implements IMovieService
{
    public function __construct(
        private readonly IMovieRepository $movieRepo,
        private readonly IShowtimeRepository $showtimeRepo,
        private readonly ITicketRepository $ticketRepo
    ) {}

    public function getNowShowing(): array
    {
        $movies = $this->movieRepo->getFiltered(null, 'now_showing');
        
        // Fix existing movies that might have no poster (the "black" ones)
        foreach ($movies as $m) {
            if (empty($m->posterUrl)) {
                // Use a realistic cinematic fallback image instead of black box
                $m->posterUrl = 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800&auto=format&fit=crop';
            }
        }
        
        // --- MOCK DATA ---
        $mock1 = new Movie(); $mock1->id = 991; $mock1->title = 'Bố Già'; $mock1->posterUrl = 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=800&auto=format&fit=crop'; $mock1->durationMinutes = 128; $mock1->ageRating = 'C13';
        $mock2 = new Movie(); $mock2->id = 992; $mock2->title = 'Mai'; $mock2->posterUrl = 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800&auto=format&fit=crop'; $mock2->durationMinutes = 131; $mock2->ageRating = 'C18';
        $mock3 = new Movie(); $mock3->id = 993; $mock3->title = 'Ngược Dòng Thời Gian Để Yêu Anh'; $mock3->posterUrl = 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?q=80&w=800&auto=format&fit=crop'; $mock3->durationMinutes = 166; $mock3->ageRating = 'C13';
        
        return array_merge($movies, [$mock1, $mock2, $mock3]);
    }

    public function getComingSoon(): array
    {
        $movies = $this->movieRepo->getFiltered(null, 'coming_soon');
        
        // Fix existing movies
        foreach ($movies as $m) {
            if (empty($m->posterUrl)) {
                $m->posterUrl = 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800&auto=format&fit=crop';
            }
        }
        
        // --- MOCK DATA ---
        $mock1 = new Movie(); $mock1->id = 994; $mock1->title = 'Lật Mặt 7: Một Điều Ước'; $mock1->posterUrl = 'https://images.unsplash.com/photo-1440407876336-62333a6f010f?q=80&w=800&auto=format&fit=crop'; $mock1->durationMinutes = 110; $mock1->ageRating = 'C16';
        $mock2 = new Movie(); $mock2->id = 995; $mock2->title = 'Tình Người Duyên Ma'; $mock2->posterUrl = 'https://images.unsplash.com/photo-1509347528160-9a9e33742cdb?q=80&w=800&auto=format&fit=crop'; $mock2->durationMinutes = 115; $mock2->ageRating = 'C16';
        $mock3 = new Movie(); $mock3->id = 996; $mock3->title = 'Thiên Tài Bất Hảo'; $mock3->posterUrl = 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop'; $mock3->durationMinutes = 130; $mock3->ageRating = 'C13';
        
        return array_merge($movies, [$mock1, $mock2, $mock3]);
    }

    public function getFiltered(?string $genre, string $status): array
    {
        return $this->movieRepo->getFiltered($genre, $status);
    }

    public function getAll(): array
    {
        return $this->movieRepo->getAll();
    }

    public function getDetail(int $movieId): Movie
    {
        $movie = $this->movieRepo->findById($movieId);
        if (!$movie) {
            throw new NotFoundException("Không tìm thấy phim với ID $movieId");
        }
        return $movie;
    }

    public function getShowtimesByDate(int $movieId, string $date): array
    {
        $showtimes = $this->showtimeRepo->getByMovieAndDate($movieId, $date);

        $summaries = [];
        foreach ($showtimes as $showtime) {
            $summary = new ShowtimeSummary();
            $summary->id = $showtime->id;
            $summary->showDate = $showtime->showDate;
            $summary->startTime = $showtime->startTime;
            $summary->formattedPrice = $showtime->getFormattedPrice();
            $summary->roomName = $showtime->room->name;

            $activeTickets = $this->ticketRepo->getActiveTickets($showtime->id);
            $totalSeats = $showtime->room->getTotalSeats();
            $summary->availableSeats = max(0, $totalSeats - count($activeTickets));

            $summaries[] = $summary;
        }
        return $summaries;
    }

    public function getSeatMapViewModel(int $showtimeId): SeatMapViewModel
    {
        $showtime = $this->showtimeRepo->findById($showtimeId);
        if (!$showtime) {
            throw new NotFoundException("Không tìm thấy suất chiếu với ID $showtimeId");
        }

        $vm = new SeatMapViewModel();
        $vm->showtimeId = $showtime->id;
        $vm->movieTitle = $showtime->movie->title;
        $vm->showDate = $showtime->showDate;
        $vm->startTime = $showtime->startTime;
        $vm->roomName = $showtime->room->name;
        $vm->pricePerSeat = $showtime->price;
        $vm->totalRows = $showtime->room->totalRows;
        $vm->seatsPerRow = $showtime->room->seatsPerRow;

        $vm->seatStatuses = $this->ticketRepo->getActiveTickets($showtime->id);

        return $vm;
    }

    public function getDashboardStats(): array
    {
        $pdo = \App\Core\Database::getInstance();
        
        $movieCount = (int)$pdo->query('SELECT COUNT(*) FROM movies')->fetchColumn();
        $userCount = (int)$pdo->query('SELECT COUNT(*) FROM users WHERE role = \'user\'')->fetchColumn();
        $ticketCount = (int)$pdo->query('SELECT COUNT(*) FROM tickets WHERE status = \'paid\'')->fetchColumn();
        $revenue = (float)$pdo->query('SELECT COALESCE(SUM(total_price), 0) FROM tickets WHERE status = \'paid\'')->fetchColumn();

        return [
            'movie_count'  => $movieCount,
            'user_count'   => $userCount,
            'ticket_count' => $ticketCount,
            'revenue'      => $revenue
        ];
    }
}
