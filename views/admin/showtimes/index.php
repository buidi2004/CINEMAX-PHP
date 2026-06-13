<?php
// views/admin/showtimes/index.php
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
    <h1 class="h2 text-warning fw-bold">Quản lý Lịch chiếu</h1>
    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addShowtimeModal">
        <i class="bi bi-plus-lg"></i> Thêm Suất chiếu
    </button>
</div>

<div class="card bg-black border border-secondary shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="table-dark text-secondary">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Phim</th>
                        <th>Phòng chiếu</th>
                        <th>Ngày chiếu</th>
                        <th>Giờ chiếu</th>
                        <th>Giá vé</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($showtimes)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">Chưa có suất chiếu nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($showtimes as $s): ?>
                        <tr>
                            <td class="ps-4">#<?= $s->id ?></td>
                            <td><span class="text-light fw-medium"><?= htmlspecialchars($s->movie->title) ?></span></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($s->room->name) ?></span></td>
                            <td><?= date('d/m/Y', strtotime($s->showDate)) ?></td>
                            <td><span class="text-warning"><?= date('H:i', strtotime($s->startTime)) ?></span></td>
                            <td><?= number_format($s->price, 0, ',', '.') ?>đ</td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $s->id ?>"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $s->id ?>"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $s->id ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="/admin/showtimes/update" method="POST" class="modal-content bg-dark text-light border-secondary">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $s->id ?>">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-warning">Sửa Suất Chiếu #<?= $s->id ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Chọn Phim</label>
                                            <select name="movie_id" class="form-select bg-black text-light border-secondary" required>
                                                <?php foreach ($movies as $m): ?>
                                                    <option value="<?= $m->id ?>" <?= $m->id === $s->movieId ? 'selected' : '' ?>><?= htmlspecialchars($m->title) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Phòng chiếu</label>
                                            <select name="room_id" class="form-select bg-black text-light border-secondary" required>
                                                <?php foreach ($rooms as $r): ?>
                                                    <option value="<?= $r->id ?>" <?= $r->id === $s->roomId ? 'selected' : '' ?>><?= htmlspecialchars($r->name) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Ngày chiếu</label>
                                            <input type="date" name="show_date" value="<?= $s->showDate ?>" class="form-control bg-black text-light border-secondary" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Giờ chiếu</label>
                                            <input type="time" name="start_time" value="<?= date('H:i', strtotime($s->startTime)) ?>" class="form-control bg-black text-light border-secondary" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Giá vé (VNĐ)</label>
                                            <input type="number" name="price" value="<?= $s->price ?>" class="form-control bg-black text-light border-secondary" required min="0">
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
                        <div class="modal fade" id="deleteModal<?= $s->id ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="/admin/showtimes/delete" method="POST" class="modal-content bg-dark text-light border-secondary">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $s->id ?>">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-danger">Xóa Suất Chiếu</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa suất chiếu <strong><?= date('H:i d/m', strtotime($s->startTime . ' ' . $s->showDate)) ?></strong> của phim <strong><?= htmlspecialchars($s->movie->title) ?></strong> không?</p>
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
<div class="modal fade" id="addShowtimeModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="/admin/showtimes" method="POST" class="modal-content bg-dark text-light border-secondary">
            <?= csrf_field() ?>
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-warning">Thêm Suất Chiếu Mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label text-secondary">Chọn Phim</label>
                    <select name="movie_id" class="form-select bg-black text-light border-secondary" required>
                        <option value="">-- Chọn phim --</option>
                        <?php foreach ($movies as $m): ?>
                            <option value="<?= $m->id ?>"><?= htmlspecialchars($m->title) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Phòng chiếu</label>
                    <select name="room_id" class="form-select bg-black text-light border-secondary" required>
                        <option value="">-- Chọn phòng --</option>
                        <?php foreach ($rooms as $r): ?>
                            <option value="<?= $r->id ?>"><?= htmlspecialchars($r->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Ngày chiếu</label>
                    <input type="date" name="show_date" class="form-control bg-black text-light border-secondary" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Giờ chiếu</label>
                    <input type="time" name="start_time" class="form-control bg-black text-light border-secondary" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Giá vé (VNĐ)</label>
                    <input type="number" name="price" class="form-control bg-black text-light border-secondary" required min="0" value="80000">
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-warning">Thêm</button>
            </div>
        </form>
    </div>
</div>
