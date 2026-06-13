<?php // views/promotions/index.php ?>
<div class="promotions-hero text-center py-5 mb-5" data-aos="fade-down" style="background: linear-gradient(135deg, #0a0a14, #1a1a3e, #0f0f1b); border-radius: 16px; border: 1px solid #222244;">
    <h1 class="display-5 fw-bold"><i class="bi bi-percent text-warning me-2"></i>Ưu đãi & Khuyến mãi</h1>
    <p class="lead text-secondary">Đừng bỏ lỡ những deal hot nhất từ CinemaX</p>
</div>

<?php if (empty($promotions)): ?>
    <div class="text-center py-5">
        <i class="bi bi-tag fs-1 text-secondary opacity-50"></i>
        <p class="text-secondary mt-3 fs-5">Chưa có khuyến mãi nào</p>
        <p class="text-secondary">Quay lại sau để xem ưu đãi mới nhất!</p>
    </div>
<?php else: ?>
    <h4 class="text-warning border-start border-warning ps-3 mb-4" data-aos="fade-right"><i class="bi bi-ticket-detailed me-2"></i>Mã giảm giá đang hoạt động</h4>
    <div class="row g-4">
        <?php foreach ($promotions as $index => $promo): ?>
            <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="<?= ($index % 3) * 100 ?>">
                <div class="card promo-card bg-dark border-0 overflow-hidden h-100 hover-shadow transition-all">
                    <img src="<?= htmlspecialchars($promo->image_url ?? 'https://placehold.co/600x300/1a1a3e/fff?text=CinemaX+Promo') ?>" 
                         class="card-img-top transition-all" 
                         style="height: 150px; object-fit: cover;" 
                         alt="<?= htmlspecialchars($promo->code) ?>">
                    <div class="card-body p-4 position-relative">
                        <div class="promo-ribbon">
                            <?= ($promo->discount_type ?? 'percent') === 'percent' ? ($promo->discount_value ?? 0) . '%' : 'DEAL' ?>
                        </div>
                        <h5 class="text-warning fw-bold mb-2"><?= htmlspecialchars($promo->code) ?></h5>
                        <p class="text-secondary small mb-3">
                            <?php if (($promo->discount_type ?? 'percent') === 'percent'): ?>
                                Giảm <?= htmlspecialchars($promo->discount_value) ?>% giá vé
                            <?php else: ?>
                                Giảm <?= number_format($promo->discount_value ?? 0, 0, ',', '.') ?>₫
                            <?php endif; ?>
                        </p>
                        <div class="promo-code-box d-flex align-items-center gap-2 mb-3">
                            <code class="text-warning fs-5 fw-bold"><?= htmlspecialchars($promo->code) ?></code>
                            <button class="btn btn-sm btn-outline-warning rounded-pill" onclick="copyPromoCode('<?= htmlspecialchars($promo->code) ?>')">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <?php if ($promo->expires_at): ?>
                                <small class="text-secondary"><i class="bi bi-calendar me-1"></i>HSD: <?= date('d/m/Y', strtotime($promo->expires_at)) ?></small>
                            <?php endif; ?>
                            <?php if ($promo->max_uses): ?>
                                <small class="text-secondary"><i class="bi bi-people me-1"></i>Còn <?= max(0, $promo->max_uses - ($promo->used_count ?? 0)) ?> lượt</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
function copyPromoCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-success text-white rounded-3 shadow-lg';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<i class="bi bi-check-circle me-1"></i>Đã copy mã: ' + code;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}
</script>
