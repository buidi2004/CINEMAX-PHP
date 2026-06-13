<?php
namespace App\Controllers\Admin;

use App\Core\Database;

class FoodBeverageController extends BaseAdminController {

    public function index() {
        $stmt = Database::getInstance()->query("SELECT * FROM food_beverages ORDER BY created_at DESC");
        $food_beverages = $stmt->fetchAll();
        $this->render('admin.food_beverages.index', ['pageTitle' => 'Quản lý Dịch vụ Bắp nước', 'food_beverages' => $food_beverages]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            $imageUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageUrl = '/uploads/' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . '/public' . $imageUrl);
            }

            $stmt = Database::getInstance()->prepare("INSERT INTO food_beverages (name, description, price, image_url, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $imageUrl, $is_active]);
            
            $_SESSION['flash_success'] = 'Thêm Combo Bắp Nước thành công!';
            header('Location: /admin/food-beverages');
            exit;
        }

        $this->render('admin.food_beverages.create', ['pageTitle' => 'Thêm Combo']);
    }

    public function edit(int $id) {
        $stmt = Database::getInstance()->prepare("SELECT * FROM food_beverages WHERE id = ?");
        $stmt->execute([$id]);
        $food = $stmt->fetch();

        if (!$food) {
            $_SESSION['flash_error'] = 'Không tìm thấy combo.';
            header('Location: /admin/food-beverages');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            $imageUrl = $food['image_url'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageUrl = '/uploads/' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . '/public' . $imageUrl);
            }

            $stmt = Database::getInstance()->prepare("UPDATE food_beverages SET name = ?, description = ?, price = ?, image_url = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $imageUrl, $is_active, $id]);
            
            $_SESSION['flash_success'] = 'Cập nhật Combo thành công!';
            header('Location: /admin/food-beverages');
            exit;
        }

        $this->render('admin.food_beverages.edit', ['pageTitle' => 'Sửa Combo', 'food' => (object)$food]);
    }

    public function delete(int $id) {
        $stmt = Database::getInstance()->prepare("DELETE FROM food_beverages WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['flash_success'] = 'Xóa Combo thành công!';
        header('Location: /admin/food-beverages');
        exit;
    }
}
