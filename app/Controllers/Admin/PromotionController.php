<?php
namespace App\Controllers\Admin;

use App\Core\Database;

class PromotionController extends BaseAdminController {

    public function index() {
        $stmt = Database::getInstance()->query("SELECT * FROM promotions ORDER BY expires_at DESC, id DESC");
        $promotions = $stmt->fetchAll();
        $this->render('admin.promotions.index', ['pageTitle' => 'Quản lý Khuyến Mãi', 'promotions' => $promotions]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = strtoupper(trim($_POST['code'] ?? ''));
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $discountType = $_POST['discount_type'] ?? 'percent';
            $discountValue = (float)($_POST['discount_value'] ?? 0);
            $maxUses = !empty($_POST['max_uses']) ? (int)$_POST['max_uses'] : null;
            $expiresAt = !empty($_POST['expires_at']) ? $_POST['expires_at'] : null;
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            
            // Upload image if provided
            $imageUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageUrl = '/uploads/' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . '/public' . $imageUrl);
            }

            try {
                $stmt = Database::getInstance()->prepare("
                    INSERT INTO promotions (code, title, description, image_url, discount_type, discount_value, max_uses, expires_at, is_active) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$code, $title, $description, $imageUrl, $discountType, $discountValue, $maxUses, $expiresAt, $isActive]);
                $_SESSION['flash_success'] = 'Thêm Khuyến mãi thành công!';
                header('Location: /admin/promotions');
                exit;
            } catch (\PDOException $e) {
                if ($e->getCode() === '23000') {
                    $_SESSION['flash_error'] = 'Mã code này đã tồn tại!';
                } else {
                    $_SESSION['flash_error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
                }
            }
        }

        $this->render('admin.promotions.create', ['pageTitle' => 'Thêm Khuyến Mãi']);
    }

    public function edit(int $id) {
        $stmt = Database::getInstance()->prepare("SELECT * FROM promotions WHERE id = ?");
        $stmt->execute([$id]);
        $promo = $stmt->fetch();

        if (!$promo) {
            $_SESSION['flash_error'] = 'Không tìm thấy khuyến mãi.';
            header('Location: /admin/promotions');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $discountType = $_POST['discount_type'] ?? 'percent';
            $discountValue = (float)($_POST['discount_value'] ?? 0);
            $maxUses = !empty($_POST['max_uses']) ? (int)$_POST['max_uses'] : null;
            $expiresAt = !empty($_POST['expires_at']) ? $_POST['expires_at'] : null;
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            
            $imageUrl = $promo['image_url'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageUrl = '/uploads/' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . '/public' . $imageUrl);
            }

            $stmt = Database::getInstance()->prepare("
                UPDATE promotions 
                SET title = ?, description = ?, image_url = ?, discount_type = ?, discount_value = ?, max_uses = ?, expires_at = ?, is_active = ?
                WHERE id = ?
            ");
            $stmt->execute([$title, $description, $imageUrl, $discountType, $discountValue, $maxUses, $expiresAt, $isActive, $id]);
            
            $_SESSION['flash_success'] = 'Cập nhật Khuyến mãi thành công!';
            header('Location: /admin/promotions');
            exit;
        }

        $this->render('admin.promotions.edit', ['pageTitle' => 'Sửa Khuyến Mãi', 'promo' => (object)$promo]);
    }

    public function delete(int $id) {
        $stmt = Database::getInstance()->prepare("DELETE FROM promotions WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['flash_success'] = 'Xóa khuyến mãi thành công!';
        header('Location: /admin/promotions');
        exit;
    }
}
