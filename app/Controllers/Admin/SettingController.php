<?php
namespace App\Controllers\Admin;

use App\Core\Database;

class SettingController extends BaseAdminController {

    public function index() {
        $stmt = Database::getInstance()->query("SELECT * FROM settings");
        $rows = $stmt->fetchAll();
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $keys = ['site_name', 'site_description', 'contact_email', 'contact_phone', 'address', 'facebook_url', 'youtube_url', 'instagram_url', 'footer_text'];
            
            $pdo = Database::getInstance();
            $pdo->beginTransaction();
            try {
                $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
                foreach ($keys as $key) {
                    $val = trim($_POST[$key] ?? '');
                    $stmt->execute([$key, $val, $val]);
                    $settings[$key] = $val;
                }
                
                // Handle Logo Upload
                if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION);
                    $logoUrl = '/assets/images/logo_' . uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['site_logo']['tmp_name'], ROOT_PATH . '/public' . $logoUrl);
                    
                    $stmt->execute(['site_logo', $logoUrl, $logoUrl]);
                    $settings['site_logo'] = $logoUrl;
                }

                $pdo->commit();
                $_SESSION['flash_success'] = 'Cập nhật cấu hình thành công!';
            } catch (\Exception $e) {
                $pdo->rollBack();
                $_SESSION['flash_error'] = 'Lỗi cập nhật cấu hình: ' . $e->getMessage();
            }
            
            header('Location: /admin/settings');
            exit;
        }

        $this->render('admin.settings.index', ['pageTitle' => 'Cấu hình Hệ Thống', 'settings' => $settings]);
    }
}
