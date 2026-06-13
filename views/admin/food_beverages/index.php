<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="/admin/food-beverages/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm Combo Mới</a>
</div>

<?php require_once __DIR__ . '/../../partials/flash_message.php'; ?>

<div class="card bg-dark border-secondary">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px">Ảnh</th>
                        <th>Tên Combo</th>
                        <th>Giá bán</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($food_beverages)): ?>
                        <tr><td colspan="5" class="text-center text-secondary py-4">Chưa có combo bắp nước nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($food_beverages as $item): ?>
                            <tr>
                                <td>
                                    <?php if ($item['image_url']): ?>
                                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Thumbnail" class="img-thumbnail bg-dark border-secondary" style="width: 64px; height: 64px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-secondary text-center rounded d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($item['description']) ?></small>
                                </td>
                                <td>
                                    <strong class="text-warning"><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</strong>
                                </td>
                                <td>
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-success">Đang bán</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tạm ngưng</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="/admin/food-beverages/<?= $item['id'] ?>/edit" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                        <a href="/admin/food-beverages/<?= $item['id'] ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa combo này?')"><i class="bi bi-trash"></i></a>
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
