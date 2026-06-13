<?php
// views/admin/tickets/index.php
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-secondary">
    <h1 class="h2 text-warning fw-bold">Quản lý Đơn hàng & Vé</h1>
</div>

<div class="card bg-black border border-secondary shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="table-dark text-secondary">
                    <tr>
                        <th class="ps-4">Mã Vé</th>
                        <th>Khách hàng</th>
                        <th>Phim</th>
                        <th>Suất chiếu</th>
                        <th>Ghế</th>
                        <th>Trạng thái</th>
                        <th>Giá vé</th>
                        <th class="text-end pe-4">Ngày đặt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tickets)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Chưa có vé nào được đặt.</td></tr>
                    <?php else: ?>
                        <?php foreach ($tickets as $t): ?>
                        <tr>
                            <td class="ps-4 fw-bold">#<?= $t->id ?></td>
                            <td>
                                <div class="text-light"><?= htmlspecialchars($t->userName ?? '') ?></div>
                                <small class="text-muted"><?= htmlspecialchars($t->userEmail ?? '') ?></small>
                            </td>
                            <td><span class="text-light fw-medium"><?= htmlspecialchars($t->movieTitle ?? '') ?></span></td>
                            <td>
                                <div><span class="badge bg-secondary"><?= htmlspecialchars($t->roomName ?? '') ?></span></div>
                                <small class="text-warning"><?= date('H:i', strtotime($t->startTime)) ?> - <?= date('d/m/Y', strtotime($t->showDate)) ?></small>
                            </td>
                            <td><span class="badge bg-info text-dark"><?= $t->seatCode ?></span></td>
                            <td>
                                <?php if ($t->status === 'paid'): ?>
                                    <span class="badge bg-success">Đã thanh toán</span>
                                <?php elseif ($t->status === 'holding'): ?>
                                    <span class="badge bg-warning text-dark">Đang giữ chỗ</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($t->totalPrice ?? 0, 0, ',', '.') ?>đ</td>
                            <td class="text-end pe-4 text-muted"><?= date('H:i d/m/Y', strtotime($t->bookedAt)) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
