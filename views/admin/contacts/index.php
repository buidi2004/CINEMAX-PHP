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
                        <th>Chủ đề</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($contacts)): ?>
                        <tr><td colspan="5" class="text-center text-secondary py-4">Chưa có liên hệ nào.</td></tr>
                    <?php else: ?>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($contact['name']) ?></strong><br>
                                    <small class="text-muted"><a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-info text-decoration-none"><?= htmlspecialchars($contact['email']) ?></a></small>
                                </td>
                                <td>
                                    <?= htmlspecialchars(mb_strimwidth($contact['subject'], 0, 40, '...')) ?>
                                </td>
                                <td>
                                    <?php if ($contact['status'] === 'resolved'): ?>
                                        <span class="badge bg-success">Đã xử lý</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                    <?php endif; ?>
                                </td>
                                <td><small class="text-secondary"><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></small></td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="/admin/contacts/<?= $contact['id'] ?>/reply" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i> Phản hồi</a>
                                        <a href="/admin/contacts/<?= $contact['id'] ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa liên hệ này?')"><i class="bi bi-trash"></i></a>
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
