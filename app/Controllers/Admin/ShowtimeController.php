<?php
namespace App\Controllers\Admin;

use App\Core\Container;
use App\Models\Services\Interfaces\IShowtimeService;
use App\Models\Services\Interfaces\IMovieService;
use App\Models\Services\Interfaces\IRoomService;
use App\Core\Session;

class ShowtimeController extends BaseAdminController
{
    private IShowtimeService $showtimeService;
    private IMovieService $movieService;
    private IRoomService $roomService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->showtimeService = $container->make(IShowtimeService::class);
        $this->movieService = $container->make(IMovieService::class);
        $this->roomService = $container->make(IRoomService::class);
    }

    public function index(): void
    {
        $showtimes = $this->showtimeService->getAllShowtimesAdmin();
        $movies = $this->movieService->getAll();
        $rooms = $this->roomService->getAllRooms();
        $this->render('admin.showtimes.index', compact('showtimes', 'movies', 'rooms'));
    }

    public function store(): void
    {
        $this->validateCsrf();

        $movieId = (int)($_POST['movie_id'] ?? 0);
        $roomId = (int)($_POST['room_id'] ?? 0);
        $showDate = trim($_POST['show_date'] ?? '');
        $startTime = trim($_POST['start_time'] ?? '');
        $price = (int)($_POST['price'] ?? 0);

        if (!$movieId || !$roomId || empty($showDate) || empty($startTime) || $price < 0) {
            Session::setFlash('error', 'Dữ liệu không hợp lệ.');
            $this->redirect('/admin/showtimes');
            return;
        }

        try {
            $this->showtimeService->createShowtime([
                'movie_id' => $movieId,
                'room_id' => $roomId,
                'show_date' => $showDate,
                'start_time' => $startTime,
                'price' => $price
            ]);
            Session::setFlash('success', 'Thêm suất chiếu thành công!');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi: ' . $e->getMessage());
        }

        $this->redirect('/admin/showtimes');
    }

    public function update(): void
    {
        $this->validateCsrf();

        $id = (int)($_POST['id'] ?? 0);
        $movieId = (int)($_POST['movie_id'] ?? 0);
        $roomId = (int)($_POST['room_id'] ?? 0);
        $showDate = trim($_POST['show_date'] ?? '');
        $startTime = trim($_POST['start_time'] ?? '');
        $price = (int)($_POST['price'] ?? 0);

        if (!$id || !$movieId || !$roomId || empty($showDate) || empty($startTime) || $price < 0) {
            Session::setFlash('error', 'Dữ liệu không hợp lệ.');
            $this->redirect('/admin/showtimes');
            return;
        }

        try {
            $this->showtimeService->updateShowtime($id, [
                'movie_id' => $movieId,
                'room_id' => $roomId,
                'show_date' => $showDate,
                'start_time' => $startTime,
                'price' => $price
            ]);
            Session::setFlash('success', 'Cập nhật suất chiếu thành công!');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi: ' . $e->getMessage());
        }

        $this->redirect('/admin/showtimes');
    }

    public function delete(): void
    {
        $this->validateCsrf();

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            Session::setFlash('error', 'ID không hợp lệ.');
            $this->redirect('/admin/showtimes');
            return;
        }

        try {
            $this->showtimeService->deleteShowtime($id);
            Session::setFlash('success', 'Xóa suất chiếu thành công!');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi: ' . $e->getMessage());
        }

        $this->redirect('/admin/showtimes');
    }
}
