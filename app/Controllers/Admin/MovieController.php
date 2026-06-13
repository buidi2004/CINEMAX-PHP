<?php
namespace App\Controllers\Admin;

use App\Core\Container;
use App\Models\Services\Interfaces\IMovieService;
use App\Models\Repository\Interfaces\IMovieRepository;
use App\Core\Session;

class MovieController extends BaseAdminController
{
    private IMovieService $movieService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->movieService = $container->make(IMovieService::class);
    }

    // GET /admin/movies
    public function index(): void
    {
        $movies = $this->movieService->getAll();
        $this->render('admin.movies.index', compact('movies'));
    }

    // POST /admin/movies
    public function store(): void
    {
        $this->validateCsrf();

        $title = trim($_POST['title'] ?? '');
        $genre = trim($_POST['genre'] ?? '');
        $status = trim($_POST['status'] ?? 'coming_soon');
        $durationMinutes = (int)($_POST['duration_minutes'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $ageRating = trim($_POST['age_rating'] ?? 'P');

        $errors = [];
        if (empty($title)) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }
        if ($durationMinutes <= 0) {
            $errors['duration_minutes'] = 'Thời lượng phải lớn hơn 0.';
        }

        // Handle file upload
        $posterUrl = null;
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['poster']['tmp_name'];
            $name = basename($_FILES['poster']['name']);
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $newName = uniqid() . '.' . $ext;
            $uploadDir = ROOT_PATH . '/public/uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            if (move_uploaded_file($tmpName, $uploadDir . '/' . $newName)) {
                $posterUrl = '/uploads/' . $newName;
            }
        }

        if (!empty($errors)) {
            $movies = $this->movieService->getAll();
            $this->render('admin.movies.index', compact('movies', 'errors'));
            return;
        }

        try {
            $movieRepo = $this->container->make(IMovieRepository::class);
            $movieRepo->create([
                'title'            => $title,
                'poster_url'       => $posterUrl,
                'genre'            => $genre,
                'status'           => $status,
                'duration_minutes' => $durationMinutes,
                'description'      => $description,
                'age_rating'       => $ageRating
            ]);

            Session::setFlash('success', 'Thêm phim mới thành công!');
            $this->redirect('/admin/movies');

        } catch (\Exception $e) {
            $errors['general'] = 'Lỗi hệ thống: ' . $e->getMessage();
            $movies = $this->movieService->getAll();
            $this->render('admin.movies.index', compact('movies', 'errors'));
        }
    }

    // PUT/POST /admin/movies/update
    public function update(): void
    {
        $this->validateCsrf();

        $movieId = (int)($_POST['id'] ?? 0);
        if (!$movieId) {
            Session::setFlash('error', 'ID phim không hợp lệ.');
            $this->redirect('/admin/movies');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $genre = trim($_POST['genre'] ?? '');
        $status = trim($_POST['status'] ?? 'coming_soon');
        $durationMinutes = (int)($_POST['duration_minutes'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $ageRating = trim($_POST['age_rating'] ?? 'P');

        $errors = [];
        if (empty($title)) {
            $errors['title'] = 'Tiêu đề không được để trống.';
        }
        if ($durationMinutes <= 0) {
            $errors['duration_minutes'] = 'Thời lượng phải lớn hơn 0.';
        }

        if (!empty($errors)) {
            Session::setFlash('errors', $errors);
            $this->redirect("/admin/movies?edit=$movieId");
            return;
        }

        try {
            $movieRepo = $this->container->make(IMovieRepository::class);
            $movie = $movieRepo->findById($movieId);
            
            if (!$movie) {
                Session::setFlash('error', 'Phim không tồn tại.');
                $this->redirect('/admin/movies');
                return;
            }

            // Handle file upload for new poster
            $posterUrl = $movie->poster_url;
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['poster']['tmp_name'];
                $name = basename($_FILES['poster']['name']);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid() . '.' . $ext;
                $uploadDir = ROOT_PATH . '/public/uploads';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                if (move_uploaded_file($tmpName, $uploadDir . '/' . $newName)) {
                    // Delete old poster if exists
                    if ($movie->poster_url) {
                        $oldPath = ROOT_PATH . '/public' . $movie->poster_url;
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    $posterUrl = '/uploads/' . $newName;
                }
            }

            $updateData = [
                ':title'            => $title,
                ':genre'            => $genre,
                ':status'           => $status,
                ':duration_minutes' => $durationMinutes,
                ':description'      => $description,
                ':age_rating'       => $ageRating
            ];
            
            if ($posterUrl) {
                $updateData[':poster_url'] = $posterUrl;
            }

            $movieRepo->update($movieId, $updateData);
            Session::setFlash('success', 'Cập nhật phim thành công!');
            $this->redirect('/admin/movies');

        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi hệ thống: ' . $e->getMessage());
            $this->redirect('/admin/movies');
        }
    }

    // POST /admin/movies/delete
    public function delete(): void
    {
        $this->validateCsrf();

        $movieId = (int)($_POST['id'] ?? 0);
        if (!$movieId) {
            Session::setFlash('error', 'ID phim không hợp lệ.');
            $this->redirect('/admin/movies');
            return;
        }

        try {
            $movieRepo = $this->container->make(IMovieRepository::class);
            $movie = $movieRepo->findById($movieId);
            
            if (!$movie) {
                Session::setFlash('error', 'Phim không tồn tại.');
                $this->redirect('/admin/movies');
                return;
            }

            // Delete poster file if exists
            if ($movie->poster_url) {
                $posterPath = ROOT_PATH . '/public' . $movie->poster_url;
                if (file_exists($posterPath)) {
                    unlink($posterPath);
                }
            }

            $movieRepo->delete($movieId);
            Session::setFlash('success', 'Xóa phim thành công!');
            $this->redirect('/admin/movies');

        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi hệ thống: ' . $e->getMessage());
            $this->redirect('/admin/movies');
        }
    }
}
