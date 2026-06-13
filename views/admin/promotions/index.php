<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="/admin/promotions/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm Khuyến Mãi</a>
</div>

<?php require_once __DIR__ . '/../../partials/flash_message.php'; ?>

<div class="card bg-dark border-secondary">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Mã Code</th>
                        <th>Thông tin</th>
                        <th>Loại giảm giá</th>
                        <th>Hạn sử dụng</th>
                        <th>Lượt dùng</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($promotions)): ?>
                        <tr><td colspan="7" class="text-center text-secondary py-4">Chưa có khuyến mãi nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($promotions as $item): ?>
                            <tr>
                                <td>
                                    <strong class="text-warning fs-5"><?= htmlspecialchars($item['code']) ?></strong>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($item['title'] ?? 'Chưa có tiêu đề') ?></strong>
                                </td>
                                <td>
                                    <?php if ($item['discount_type'] === 'percent'): ?>
                                        <span class="badge bg-info text-dark">Giảm <?= $item['discount_value'] ?>%</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Giảm <?= number_format($item['discount_value'], 0, ',', '.') ?>₫</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['expires_at']): ?>
                                        <?= date('d/m/Y H:i', strtotime($item['expires_at'])) ?>
                                        <?php if (strtotime($item['expires_at']) < time()): ?>
                                            <br><small class="text-danger">Đã hết hạn</small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">Vô thời hạn</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $item['used_count'] ?> / <?= $item['max_uses'] ?: '&infin;' ?>
                                </td>
                                <td>
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-primary">Đang bật</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Đã tắt</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="/admin/promotions/<?= $item['id'] ?>/edit" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                        <a href="/admin/promotions/<?= $item['id'] ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
