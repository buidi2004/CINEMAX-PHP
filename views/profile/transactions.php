<?php // views/profile/transactions.php ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="/profile" class="text-warning text-decoration-none">Hồ sơ</a></li>
        <li class="breadcrumb-item active text-secondary">Lịch sử giao dịch</li>
    </ol>
</nav>

<div class="card bg-dark border-0 shadow-lg" data-aos="fade-up">
    <div class="card-header bg-black border-bottom border-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h4 class="mb-0 text-warning"><i class="bi bi-receipt-cutoff me-2"></i>Lịch sử giao dịch</h4>
        <select class="form-select form-select-sm bg-secondary border-0 text-light" style="width: auto;"
                onchange="location.href='?status='+this.value">
            <option value="">Tất cả</option>
            <option value="paid" <?= ($filter ?? '') === 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
            <option value="cancelled" <?= ($filter ?? '') === 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
        </select>
    </div>
    <div class="card-body p-0">
        <?php if (empty($transactions)): ?>
            <div class="text-center py-5">
                <i class="bi bi-receipt fs-1 text-secondary opacity-50"></i>
                <p class="text-secondary mt-2">Chưa có giao dịch nào</p>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0">
                <thead class="bg-black">
                    <tr>
                        <th class="text-secondary small">Phim</th>
                        <th class="text-secondary small">Ghế</th>
                        <th class="text-secondary small">Ngày chiếu</th>
                        <th class="text-secondary small">Số tiền</th>
                        <th class="text-secondary small">Trạng thái</th>
                        <th class="text-secondary small">Ngày mua</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $index => $txn): ?>
                        <tr class="cursor-pointer" onclick="location.href='/my-tickets/<?= $txn->id ?>'" data-aos="fade-up" data-aos-delay="<?= ($index % 10) * 50 ?>">
                            <td><strong class="text-light"><?= htmlspecialchars($txn->movie_title) ?></strong></td>
                            <td><span class="badge bg-success"><?= htmlspecialchars($txn->seat_code) ?></span></td>
                            <td class="text-secondary small"><?= htmlspecialchars($txn->show_date) ?> <?= htmlspecialchars($txn->start_time) ?></td>
                            <td class="text-warning fw-bold"><?= number_format($txn->total_price, 0, ',', '.') ?>₫</td>
                            <td>
                                <span class="badge <?= match($txn->status) { 'paid' => 'bg-success', 'cancelled' => 'bg-danger', 'holding' => 'bg-warning text-dark', default => 'bg-secondary' } ?> rounded-pill">
                                    <?= match($txn->status) { 'paid' => 'Thành công', 'cancelled' => 'Đã hủy', 'holding' => 'Đang giữ', default => $txn->status } ?>
                                </span>
                            </td>
                            <td class="text-secondary small"><?= date('d/m/Y H:i', strtotime($txn->booked_at)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="p-3 bg-black d-flex justify-content-between align-items-center">
            <span class="text-secondary">Tổng: <strong class="text-light"><?= count($transactions) ?></strong> giao dịch</span>
            <span class="text-warning fw-bold">Tổng chi: <?= number_format($totalSpent, 0, ',', '.') ?>₫</span>
        </div>
        <?php endif; ?>
    </div>
</div>
