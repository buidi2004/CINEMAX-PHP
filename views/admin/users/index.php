<?php
// views/admin/users/index.php
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
    <h1 class="h2 text-warning fw-bold">Quản lý Thành viên</h1>
</div>

<div class="card bg-black border border-secondary shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="table-dark text-secondary">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th class="text-end pe-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có thành viên nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="ps-4">#<?= $u->id ?></td>
                            <td><span class="text-light fw-medium"><?= htmlspecialchars($u->username) ?></span></td>
                            <td><?= htmlspecialchars($u->email) ?></td>
                            <td>
                                <?php if ($u->role === 'admin'): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark">User</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($u->createdAt)) ?></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#editRoleModal<?= $u->id ?>"><i class="bi bi-pencil"></i></button>
                                <?php if ($u->role !== 'admin' || $u->id !== (\App\Core\Session::get('user_id') ?? 0)): ?>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?= $u->id ?>"><i class="bi bi-trash"></i></button>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Modal Edit Role -->
                        <div class="modal fade" id="editRoleModal<?= $u->id ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="/admin/users/role" method="POST" class="modal-content bg-dark text-light border-secondary">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $u->id ?>">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-warning">Sửa Quyền Thành Viên</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Người dùng: <strong><?= htmlspecialchars($u->username) ?></strong></p>
                                        <div class="mb-3">
                                            <label class="form-label text-secondary">Vai trò</label>
                                            <select name="role" class="form-select bg-black text-light border-secondary">
                                                <option value="user" <?= $u->role === 'user' ? 'selected' : '' ?>>User</option>
                                                <option value="admin" <?= $u->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                            </select>
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
                        <div class="modal fade" id="deleteUserModal<?= $u->id ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="/admin/users/delete" method="POST" class="modal-content bg-dark text-light border-secondary">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $u->id ?>">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-danger">Xóa Thành Viên</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa thành viên <strong><?= htmlspecialchars($u->username) ?></strong> không? Hành động này không thể hoàn tác.</p>
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
