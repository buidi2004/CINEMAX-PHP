<?php
// views/experiences/detail.php
?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Trang chủ</a></li>
        <li class="breadcrumb-item active text-secondary">Trải nghiệm điện ảnh</li>
        <li class="breadcrumb-item active text-secondary"><?= htmlspecialchars($item->name) ?></li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10" data-aos="fade-up">
        <div class="card bg-dark border-0 shadow-lg promo-detail-card overflow-hidden rounded-4">
            <!-- Banner Image -->
            <div style="height: 500px; background: url('<?= htmlspecialchars($item->image) ?>') center/cover no-repeat; position: relative;">
                <div class="position-absolute bottom-0 start-0 p-5 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.95));">
                    <h1 class="text-info fw-bold mb-2 display-4" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.8);">
                        <?= htmlspecialchars($item->name) ?>
                    </h1>
                    <h4 class="text-light fw-light fst-italic">
                        "<?= htmlspecialchars($item->slogan) ?>"
                    </h4>
                </div>
            </div>
            
            <?php if (!empty($item->video)): ?>
            <!-- Video Full Width Section -->
            <div class="bg-black py-5 border-top border-bottom border-secondary">
                <div class="container-fluid px-5">
                    <div class="ratio ratio-21x9 shadow-lg rounded-3 overflow-hidden">
                        <iframe src="<?= htmlspecialchars($item->video) ?>" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="card-body p-5">
                <div class="experience-description text-light" style="line-height: 1.8;">
                    <?= $item->description ?>
                </div>
            </div>
        </div>
    </div>
</div>
