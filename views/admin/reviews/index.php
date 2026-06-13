<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
</div>

<?php require_once __DIR__ . '/../../partials/flash_message.php'; ?>

<div class="card bg-dark border-secondary">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Phim</th>
                        <th>Đánh giá</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reviews)): ?>
                        <tr><td colspan="7" class="text-center text-secondary py-4">Chưa có đánh giá nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($reviews as $item): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($item['user_name']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($item['user_email']) ?></small>
                                </td>
                                <td>
                                    <span class="text-warning fw-bold"><?= htmlspecialchars($item['movie_title']) ?></span>
                                </td>
                                <td>
                                    <div class="text-warning">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $item['rating'] ? '-fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-light small" style="max-width: 300px; white-space: normal;"><?= htmlspecialchars($item['comment']) ?></p>
                                </td>
                                <td>
                                    <?php if ($item['status'] === 'approved'): ?>
                                        <span class="badge bg-success">Đã duyệt</span>
                                    <?php elseif ($item['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger">Đã từ chối</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></small>
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="/admin/reviews/<?= $item['id'] ?>/toggle" class="d-inline-block">
                                        <?php if ($item['status'] !== 'approved'): ?>
                                            <button type="submit" name="status" value="approved" class="btn btn-sm btn-outline-success" title="Duyệt"><i class="bi bi-check-circle"></i></button>
                                        <?php endif; ?>
                                        <?php if ($item['status'] !== 'rejected'): ?>
                                            <button type="submit" name="status" value="rejected" class="btn btn-sm btn-outline-warning" title="Từ chối"><i class="bi bi-x-circle"></i></button>
                                        <?php endif; ?>
                                    </form>
                                    <a href="/admin/reviews/<?= $item['id'] ?>/delete" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
