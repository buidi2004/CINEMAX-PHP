<?php
// views/concessions/detail.php
?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Trang chủ</a></li>
        <li class="breadcrumb-item active text-secondary">Quà tặng & Bắp nước</li>
        <li class="breadcrumb-item active text-secondary"><?= htmlspecialchars($item->name) ?></li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10" data-aos="fade-up">
        <div class="card bg-dark border-0 shadow-lg promo-detail-card overflow-hidden rounded-4">
            <!-- Banner Image -->
            <div style="height: 500px; background: url('<?= htmlspecialchars($item->image) ?>') center/cover no-repeat; position: relative;">
                <div class="position-absolute bottom-0 start-0 p-5 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.95));">
                    <h1 class="text-warning fw-bold mb-2 display-5">
                        <?= htmlspecialchars($item->name) ?>
                    </h1>
                    <span class="badge bg-danger fs-4 px-4 py-2 rounded-pill mt-2">
                        Giá chỉ: <?= htmlspecialchars($item->price) ?>
                    </span>
                </div>
            </div>
            <div class="card-body p-5">
                <div class="row g-5">
                    <div class="col-md-7">
                        <div class="concession-description text-light" style="line-height: 1.8;">
                            <?= $item->description ?>
                        </div>
                        <div class="mt-5 text-center text-md-start">
                            <a href="/movies" class="btn btn-warning btn-lg px-5 rounded-pill fw-bold">
                                <i class="bi bi-cart-plus me-2"></i>MUA KÈM VÉ NGAY
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <?php if (!empty($item->video)): ?>
                        <h5 class="text-warning mb-3 border-bottom border-secondary pb-2"><i class="bi bi-youtube me-2 text-danger"></i>Video Review</h5>
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm">
                            <iframe src="<?= htmlspecialchars($item->video) ?>" allowfullscreen></iframe>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
