<?php
namespace App\Controllers\Admin;

use App\Core\Database;

class ContactController extends BaseAdminController {

    public function index() {
        $stmt = Database::getInstance()->query("SELECT * FROM contacts ORDER BY created_at DESC");
        $contacts = $stmt->fetchAll();
        $this->render('admin.contacts.index', ['pageTitle' => 'Quản lý Liên hệ', 'contacts' => $contacts]);
    }

    public function reply(int $id) {
        $stmt = Database::getInstance()->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $contact = $stmt->fetch();

        if (!$contact) {
            $_SESSION['flash_error'] = 'Không tìm thấy liên hệ.';
            header('Location: /admin/contacts');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = trim($_POST['status'] ?? 'pending');
            $replyMessage = trim($_POST['reply_message'] ?? '');
            
            // In a real app, send email here using $replyMessage

            $stmt = Database::getInstance()->prepare("UPDATE contacts SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            
            $_SESSION['flash_success'] = 'Cập nhật trạng thái liên hệ thành công!';
            header('Location: /admin/contacts');
            exit;
        }

        $this->render('admin.contacts.reply', ['pageTitle' => 'Phản hồi Liên hệ', 'contact' => (object)$contact]);
    }

    public function delete(int $id) {
        $stmt = Database::getInstance()->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['flash_success'] = 'Xóa liên hệ thành công!';
        header('Location: /admin/contacts');
        exit;
    }
}
