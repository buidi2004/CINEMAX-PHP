<?php
namespace App\Controllers;

use App\Core\Container;
use App\Core\Database;
use App\Core\Session;

class ReviewController extends BaseController
{
    // POST /reviews
    public function submit(): void
    {
        $this->requireLogin();
        $this->validateCsrf();

        $movieId = (int)($_POST['movie_id'] ?? 0);
        $rating = (int)($_POST['rating'] ?? 5);
        $comment = trim($_POST['comment'] ?? '');

        if ($movieId <= 0 || $rating < 1 || $rating > 5) {
            Session::setFlash('error', 'Dữ liệu không hợp lệ.');
            $this->redirect('back');
            return;
        }

        $userId = $this->getCurrentUserId();

        // Check if user has bought a ticket for this movie
        $checkStmt = Database::getInstance()->prepare("
            SELECT t.id 
            FROM tickets t
            JOIN showtimes s ON t.showtime_id = s.id
            WHERE t.user_id = ? AND s.movie_id = ? AND t.status = 'paid'
            LIMIT 1
        ");
        $checkStmt->execute([$userId, $movieId]);
        if (!$checkStmt->fetch()) {
            Session::setFlash('error', 'Bạn chỉ có thể đánh giá phim sau khi đã mua vé xem phim này.');
            $this->redirect('/movies/' . $movieId);
            return;
        }

        $stmt = Database::getInstance()->prepare("INSERT INTO reviews (user_id, movie_id, rating, comment, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$userId, $movieId, $rating, $comment]);

        Session::setFlash('success', 'Cảm ơn bạn đã gửi đánh giá. Đánh giá của bạn đang chờ kiểm duyệt.');
        $this->redirect('/movies/' . $movieId);
    }
}
