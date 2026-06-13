<?php
namespace App\Controllers\Admin;

use App\Core\Container;
use App\Models\Services\Interfaces\IUserService;
use App\Core\Session;

class UserController extends BaseAdminController
{
    private IUserService $userService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->userService = $container->make(IUserService::class);
    }

    public function index(): void
    {
        $users = $this->userService->getAllUsers();
        $this->render('admin.users.index', compact('users'));
    }

    public function updateRole(): void
    {
        $this->validateCsrf();
        $id = (int)($_POST['id'] ?? 0);
        $role = trim($_POST['role'] ?? '');

        if (!$id || empty($role)) {
            Session::setFlash('error', 'Dữ liệu không hợp lệ.');
        } else {
            try {
                $this->userService->updateUserRole($id, $role);
                Session::setFlash('success', 'Cập nhật vai trò thành công!');
            } catch (\Exception $e) {
                Session::setFlash('error', $e->getMessage());
            }
        }
        $this->redirect('/admin/users');
    }

    public function delete(): void
    {
        $this->validateCsrf();
        $id = (int)($_POST['id'] ?? 0);

        if (!$id) {
            Session::setFlash('error', 'ID không hợp lệ.');
        } else {
            try {
                $this->userService->deleteUser($id);
                Session::setFlash('success', 'Xóa thành viên thành công!');
            } catch (\Exception $e) {
                Session::setFlash('error', 'Lỗi: ' . $e->getMessage());
            }
        }
        $this->redirect('/admin/users');
    }
}
