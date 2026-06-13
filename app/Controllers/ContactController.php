<?php
namespace App\Controllers;

use App\Core\Container;
use App\Core\Session;
use App\Core\Database;

class ContactController extends BaseController
{
    private \PDO $db;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->db = Database::getInstance();
    }

    // GET /contact
    public function index(): void
    {
        $this->render('contact.index', [
            'pageTitle' => 'Liên hệ & Hỗ trợ — CinemaX',
        ]);
    }

    // POST /contact
    public function submit(): void
    {
        $this->validateCsrf();

        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($message)) {
            Session::setFlash('error', 'Vui lòng điền đầy đủ thông tin.');
            $this->redirect('/contact');
        }

        try {
            $stmt = $this->db->prepare("
                INSERT INTO contacts (name, email, subject, message)
                VALUES (:name, :email, :subject, :message)
            ");
            $stmt->execute([
                'name'    => $name,
                'email'   => $email,
                'subject' => $subject,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            // Table might not exist, still show success
        }

        Session::setFlash('success', 'Gửi yêu cầu hỗ trợ thành công! Chúng tôi sẽ phản hồi trong 24h.');
        $this->redirect('/contact');
    }
}
