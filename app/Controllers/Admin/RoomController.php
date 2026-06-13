<?php
namespace App\Controllers\Admin;

use App\Core\Container;
use App\Models\Services\Interfaces\IRoomService;
use App\Core\Session;

class RoomController extends BaseAdminController
{
    private IRoomService $roomService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->roomService = $container->make(IRoomService::class);
    }

    public function index(): void
    {
        $rooms = $this->roomService->getAllRooms();
        $this->render('admin.rooms.index', compact('rooms'));
    }

    public function store(): void
    {
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $totalRows = (int)($_POST['total_rows'] ?? 0);
        $seatsPerRow = (int)($_POST['seats_per_row'] ?? 0);

        if (empty($name) || $totalRows <= 0 || $seatsPerRow <= 0) {
            Session::setFlash('error', 'Dữ liệu không hợp lệ.');
            $this->redirect('/admin/rooms');
            return;
        }

        try {
            $this->roomService->createRoom([
                'name' => $name,
                'total_rows' => $totalRows,
                'seats_per_row' => $seatsPerRow
            ]);
            Session::setFlash('success', 'Thêm phòng chiếu thành công!');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi: ' . $e->getMessage());
        }

        $this->redirect('/admin/rooms');
    }

    public function update(): void
    {
        $this->validateCsrf();

        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $totalRows = (int)($_POST['total_rows'] ?? 0);
        $seatsPerRow = (int)($_POST['seats_per_row'] ?? 0);

        if (!$id || empty($name) || $totalRows <= 0 || $seatsPerRow <= 0) {
            Session::setFlash('error', 'Dữ liệu không hợp lệ.');
            $this->redirect('/admin/rooms');
            return;
        }

        try {
            $this->roomService->updateRoom($id, [
                'name' => $name,
                'total_rows' => $totalRows,
                'seats_per_row' => $seatsPerRow
            ]);
            Session::setFlash('success', 'Cập nhật phòng chiếu thành công!');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi: ' . $e->getMessage());
        }

        $this->redirect('/admin/rooms');
    }

    public function delete(): void
    {
        $this->validateCsrf();
        $id = (int)($_POST['id'] ?? 0);

        if (!$id) {
            Session::setFlash('error', 'ID không hợp lệ.');
            $this->redirect('/admin/rooms');
            return;
        }

        try {
            $this->roomService->deleteRoom($id);
            Session::setFlash('success', 'Xóa phòng chiếu thành công!');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Lỗi: ' . $e->getMessage());
        }

        $this->redirect('/admin/rooms');
    }
}
