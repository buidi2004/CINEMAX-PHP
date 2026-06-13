<?php
namespace App\Controllers;

use App\Core\Container;
use App\Core\Session;
use App\Core\Database;

class ProfileController extends BaseController
{
    private \PDO $db;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->db = Database::getInstance();
    }

    // GET /profile
    public function index(): void
    {
        $this->requireLogin();
        $userId = $this->getCurrentUserId();

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        // Stats
        $statsStmt = $this->db->prepare("
            SELECT 
                COUNT(*) AS total_tickets,
                COUNT(DISTINCT s.movie_id) AS total_movies
            FROM tickets t
            JOIN showtimes s ON s.id = t.showtime_id
            WHERE t.user_id = :user_id AND t.status = 'paid'
        ");
        $statsStmt->execute(['user_id' => $userId]);
        $stats = $statsStmt->fetch(\PDO::FETCH_OBJ);

        // Recent tickets
        $ticketStmt = $this->db->prepare("
            SELECT t.*, m.title AS movie_title, m.poster_url, s.show_date, s.start_time, r.name AS room_name
            FROM tickets t
            JOIN showtimes s ON s.id = t.showtime_id
            JOIN movies m ON m.id = s.movie_id
            JOIN rooms r ON r.id = s.room_id
            WHERE t.user_id = :user_id
            ORDER BY t.booked_at DESC
            LIMIT 5
        ");
        $ticketStmt->execute(['user_id' => $userId]);
        $recentTickets = $ticketStmt->fetchAll(\PDO::FETCH_OBJ);

        // Member level progress
        $levelThresholds = [
            'bronze' => 0,
            'silver' => 2000000,
            'gold'   => 5000000,
            'diamond' => 10000000,
        ];
        $levels = array_keys($levelThresholds);
        $currentIdx = array_search($user->member_level ?? 'bronze', $levels);
        $nextLevel = $levels[min($currentIdx + 1, count($levels) - 1)] ?? null;
        $nextThreshold = $levelThresholds[$nextLevel] ?? $levelThresholds['diamond'];
        $currentThreshold = $levelThresholds[$user->member_level ?? 'bronze'];
        $spent = (float)($user->total_spent ?? 0);
        $levelProgress = $nextThreshold > $currentThreshold
            ? min(100, (($spent - $currentThreshold) / ($nextThreshold - $currentThreshold)) * 100)
            : 100;
        $pointsToNextLevel = max(0, $nextThreshold - $spent);

        $this->render('profile.index', [
            'user'              => $user,
            'stats'             => $stats,
            'recentTickets'     => $recentTickets,
            'nextLevel'         => $nextLevel,
            'levelProgress'     => $levelProgress,
            'pointsToNextLevel' => $pointsToNextLevel,
            'pageTitle'         => 'Hồ sơ — CinemaX',
        ]);
    }

    // GET /profile/edit
    public function editForm(): void
    {
        $this->requireLogin();
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $this->getCurrentUserId()]);
        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        $this->render('profile.edit', [
            'user'      => $user,
            'pageTitle' => 'Chỉnh sửa hồ sơ — CinemaX',
        ]);
    }

    // POST /profile/edit
    public function update(): void
    {
        $this->requireLogin();
        $this->validateCsrf();

        $userId = $this->getCurrentUserId();

        // Handle avatar upload
        $avatarUrl = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
            $destination = PUBLIC_PATH . '/assets/images/avatars/' . $filename;

            if (!is_dir(dirname($destination))) {
                mkdir(dirname($destination), 0755, true);
            }

            move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);
            $avatarUrl = '/assets/images/avatars/' . $filename;
        }

        $sql = "UPDATE users SET 
                    full_name = :full_name,
                    phone = :phone,
                    date_of_birth = :dob,
                    gender = :gender,
                    city = :city,
                    updated_at = NOW()";

        $params = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone'     => trim($_POST['phone'] ?? ''),
            'dob'       => $_POST['date_of_birth'] ?: null,
            'gender'    => $_POST['gender'] ?? 'other',
            'city'      => $_POST['city'] ?? '',
            'id'        => $userId,
        ];

        if ($avatarUrl) {
            $sql .= ", avatar_url = :avatar_url";
            $params['avatar_url'] = $avatarUrl;
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        Session::setFlash('success', 'Cập nhật hồ sơ thành công!');
        $this->redirect('/profile');
    }

    // GET /profile/transactions
    public function transactions(): void
    {
        $this->requireLogin();
        $userId = $this->getCurrentUserId();
        $filter = $_GET['status'] ?? null;

        $sql = "
            SELECT t.*, m.title AS movie_title, s.show_date, s.start_time, r.name AS room_name
            FROM tickets t
            JOIN showtimes s ON s.id = t.showtime_id
            JOIN movies m ON m.id = s.movie_id
            JOIN rooms r ON r.id = s.room_id
            WHERE t.user_id = :user_id
        ";
        $params = ['user_id' => $userId];

        if ($filter) {
            $sql .= " AND t.status = :status";
            $params['status'] = $filter;
        }

        $sql .= " ORDER BY t.booked_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $transactions = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $totalSpent = array_sum(array_map(fn($t) => $t->status === 'paid' ? (float)$t->total_price : 0, $transactions));

        $this->render('profile.transactions', [
            'transactions' => $transactions,
            'totalSpent'   => $totalSpent,
            'filter'       => $filter,
            'pageTitle'    => 'Lịch sử giao dịch — CinemaX',
        ]);
    }

    // GET /profile/change-password
    public function changePasswordForm(): void
    {
        $this->requireLogin();
        $this->render('profile.change_password', [
            'vm'        => (object)['errors' => []],
            'pageTitle' => 'Đổi mật khẩu — CinemaX',
        ]);
    }

    // POST /profile/change-password
    public function changePassword(): void
    {
        $this->requireLogin();
        $this->validateCsrf();

        $userId          = $this->getCurrentUserId();
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        // Get current user
        $stmt = $this->db->prepare("SELECT password_hash FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        if (!password_verify($currentPassword, $user->password_hash)) {
            $errors['general'] = 'Mật khẩu hiện tại không đúng.';
        }

        if (strlen($newPassword) < 8) {
            $errors['general'] = 'Mật khẩu mới phải có ít nhất 8 ký tự.';
        }

        if ($newPassword !== $confirmPassword) {
            $errors['general'] = 'Mật khẩu xác nhận không khớp.';
        }

        if (!empty($errors)) {
            $this->render('profile.change_password', [
                'vm'        => (object)['errors' => $errors],
                'pageTitle' => 'Đổi mật khẩu — CinemaX',
            ]);
            return;
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $updateStmt = $this->db->prepare("UPDATE users SET password_hash = :hash, updated_at = NOW() WHERE id = :id");
        $updateStmt->execute(['hash' => $hash, 'id' => $userId]);

        Session::setFlash('success', 'Đổi mật khẩu thành công!');
        $this->redirect('/profile');
    }
}
