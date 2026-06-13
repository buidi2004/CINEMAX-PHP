<?php
namespace App\Controllers\Admin;

use App\Core\Database;

class ReviewController extends BaseAdminController {

    public function index() {
        $stmt = Database::getInstance()->query("
            SELECT r.*, u.username as user_name, u.email as user_email, m.title as movie_title 
            FROM reviews r
            JOIN users u ON u.id = r.user_id
            JOIN movies m ON m.id = r.movie_id
            ORDER BY r.created_at DESC
        ");
        $reviews = $stmt->fetchAll();
        $this->render('admin.reviews.index', ['pageTitle' => 'Quản lý Đánh giá', 'reviews' => $reviews]);
    }

    public function toggleStatus(int $id) {
        $status = $_POST['status'] ?? 'pending';
        
        $stmt = Database::getInstance()->prepare("UPDATE reviews SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        
        $_SESSION['flash_success'] = 'Cập nhật trạng thái đánh giá thành công!';
        header('Location: /admin/reviews');
        exit;
    }

    public function delete(int $id) {
        $stmt = Database::getInstance()->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['flash_success'] = 'Xóa đánh giá thành công!';
        header('Location: /admin/reviews');
        exit;
    }
}
