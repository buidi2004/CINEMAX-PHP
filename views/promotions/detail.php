<?php
// views/promotions/detail.php
?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="/promotions" class="text-warning text-decoration-none">Khuyến mãi</a></li>
        <li class="breadcrumb-item active text-secondary"><?= htmlspecialchars($promo->code) ?></li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-8" data-aos="fade-up">
        <div class="card bg-dark border-0 shadow-lg promo-detail-card overflow-hidden">
            <!-- Banner Image (using placeholder or abstract color) -->
            <div style="height: 300px; background: linear-gradient(135deg, #1a1a3e, #dc3545); position: relative;">
                <div class="position-absolute bottom-0 start-0 p-4 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                    <h2 class="text-warning fw-bold mb-1">
                        Ưu đãi siêu khủng từ CinemaX
                    </h2>
                </div>
            </div>
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-4 border-bottom border-secondary">
                    <div>
                        <h4 class="text-light fw-bold mb-2">Mã giảm giá</h4>
                        <div class="promo-code-box d-inline-flex align-items-center gap-3 px-4 py-2">
                            <span class="text-warning fs-3 fw-bold font-monospace" id="promo-code"><?= htmlspecialchars($promo->code) ?></span>
                            <button class="btn btn-outline-warning rounded-circle copy-promo-btn" onclick="copyDetailPromoCode()" title="Copy mã">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-danger fs-5 px-3 py-2 rounded-pill">
                            Giảm <?= $promo->discountType === 'percent' ? $promo->discountValue . '%' : number_format($promo->discountValue, 0, ',', '.') . '₫' ?>
                        </span>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <i class="bi bi-calendar-event text-info fs-3"></i>
                            <div>
                                <h6 class="text-secondary mb-1">Ngày hết hạn</h6>
                                <p class="text-light fs-5"><?= date('d/m/Y', strtotime($promo->expiresAt)) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <i class="bi bi-ticket-detailed text-success fs-3"></i>
                            <div>
                                <h6 class="text-secondary mb-1">Điều kiện áp dụng</h6>
                                <p class="text-light fs-5">Áp dụng khi mua tối thiểu <?= number_format($promo->minPurchase ?? 0, 0, ',', '.') ?>₫</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 text-center border-top border-secondary pt-4">
                    <a href="/movies" class="btn btn-warning btn-lg px-5 rounded-pill fw-bold">
                        <i class="bi bi-ticket-perforated me-2"></i>Sử dụng ngay
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyDetailPromoCode() {
    const code = document.getElementById('promo-code').innerText;
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
