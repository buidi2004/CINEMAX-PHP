<?php
// views/admin/rooms/index.php
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
    <h1 class="h2 text-warning fw-bold">Quản lý Phòng chiếu</h1>
    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addRoomModal">
        <i class="bi bi-plus-lg"></i> Thêm Phòng
    </button>
</div>

<div class="card bg-black border border-secondary shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="table-dark text-secondary">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Tên Phòng</th>
                        <th>Số Hàng</th>
                        <th>Ghế/Hàng</th>
                        <th>Tổng Ghế</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rooms)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có phòng chiếu nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($rooms as $r): ?>
                        <tr>
                            <td class="ps-4">#<?= $r->id ?></td>
                            <td><span class="text-light fw-medium"><?= htmlspecialchars($r->name) ?></span></td>
                            <td><?= $r->totalRows ?></td>
                            <td><?= $r->seatsPerRow ?></td>
                            <td><span class="badge bg-secondary"><?= $r->getTotalSeats() ?></span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editRoomModal<?= $r->id ?>"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRoomModal<?= $r->id ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>

                        <!-- Modal Edit Room -->
                        <div class="modal fade" id="editRoomModal<?= $r->id ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="/admin/rooms/update" method="POST" class="modal-content bg-dark text-light border-secondary">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $r->id ?>">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-warning">Sửa Phòng #<?= $r->id ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Tên Phòng</label>
                                            <input type="text" name="name" value="<?= htmlspecialchars($r->name) ?>" class="form-control bg-black text-light border-secondary" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Số Hàng Ghế</label>
                                            <input type="number" name="total_rows" value="<?= $r->totalRows ?>" class="form-control bg-black text-light border-secondary" required min="1" max="26">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Số Ghế Mỗi Hàng</label>
                                            <input type="number" name="seats_per_row" value="<?= $r->seatsPerRow ?>" class="form-control bg-black text-light border-secondary" required min="1" max="50">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="deleteRoomModal<?= $r->id ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="/admin/rooms/delete" method="POST" class="modal-content bg-dark text-light border-secondary">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $r->id ?>">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-danger">Xóa Phòng Chiếu</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa phòng <strong><?= htmlspecialchars($r->name) ?></strong> không? Sẽ ảnh hưởng đến tất cả suất chiếu của phòng này.</p>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="/admin/rooms" method="POST" class="modal-content bg-dark text-light border-secondary">
            <?= csrf_field() ?>
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-warning">Thêm Phòng Chiếu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label text-secondary">Tên Phòng</label>
                    <input type="text" name="name" class="form-control bg-black text-light border-secondary" required placeholder="Ví dụ: Rạp 1">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Số Hàng Ghế</label>
                    <input type="number" name="total_rows" class="form-control bg-black text-light border-secondary" required min="1" max="26" value="10">
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Số Ghế Mỗi Hàng</label>
                    <input type="number" name="seats_per_row" class="form-control bg-black text-light border-secondary" required min="1" max="50" value="15">
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-warning">Thêm</button>
            </div>
        </form>
    </div>
</div>
