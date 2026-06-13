<?php
namespace App\Controllers\Admin;

use App\Models\Domain\News;
use App\Core\Database;

class NewsController extends BaseAdminController {

    public function index() {
        $stmt = Database::getInstance()->query("SELECT * FROM news ORDER BY created_at DESC");
        $news = $stmt->fetchAll();
        $this->render('admin.news.index', ['pageTitle' => 'Quản lý Tin tức', 'news' => $news]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $slug = create_slug($title);
            $summary = trim($_POST['summary'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $is_published = isset($_POST['is_published']) ? 1 : 0;
            
            $imageUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageUrl = '/uploads/' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . '/public' . $imageUrl);
            }

            $stmt = Database::getInstance()->prepare("INSERT INTO news (title, slug, summary, content, image_url, is_published) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $summary, $content, $imageUrl, $is_published]);
            
            $_SESSION['flash_success'] = 'Thêm tin tức thành công!';
            header('Location: /admin/news');
            exit;
        }

        $this->render('admin.news.create', ['pageTitle' => 'Thêm Tin Tức']);
    }

    public function edit(int $id) {
        $stmt = Database::getInstance()->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$id]);
        $news = $stmt->fetch();

        if (!$news) {
            $_SESSION['flash_error'] = 'Không tìm thấy tin tức.';
            header('Location: /admin/news');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $slug = create_slug($title);
            $summary = trim($_POST['summary'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $is_published = isset($_POST['is_published']) ? 1 : 0;
            
            $imageUrl = $news['image_url'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageUrl = '/uploads/' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . '/public' . $imageUrl);
            }

            $stmt = Database::getInstance()->prepare("UPDATE news SET title = ?, slug = ?, summary = ?, content = ?, image_url = ?, is_published = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $summary, $content, $imageUrl, $is_published, $id]);
            
            $_SESSION['flash_success'] = 'Cập nhật tin tức thành công!';
            header('Location: /admin/news');
            exit;
        }

        $this->render('admin.news.edit', ['pageTitle' => 'Sửa Tin Tức', 'news' => (object)$news]);
    }

    public function delete(int $id) {
        $stmt = Database::getInstance()->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['flash_success'] = 'Xóa tin tức thành công!';
        header('Location: /admin/news');
        exit;
    }
}
