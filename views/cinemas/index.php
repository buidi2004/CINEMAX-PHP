<?php
// views/cinemas/index.php
use App\Core\Session;
?>

<!-- Hero Section -->
<div class="cinema-hero text-center py-5 mb-5" data-aos="fade-down">
    <h1 class="display-5 fw-bold text-warning mb-3">
        <i class="bi bi-geo-alt-fill me-2"></i>Hệ Thống Rạp CinemaX
    </h1>
    <p class="lead text-dark opacity-75" data-aos="fade-up" data-aos-delay="200">
        Trải nghiệm điện ảnh đỉnh cao tại <strong class="text-warning"><?= count($cinemas) ?></strong> rạp trên toàn quốc
    </p>
</div>

<!-- Bộ lọc tỉnh/thành phố -->
<div class="province-filter mb-5">
    <div class="d-flex flex-wrap gap-2 justify-content-center">
        <a href="/cinemas"
           class="btn btn-sm <?= !$selectedProvince ? 'btn-warning' : 'btn-outline-secondary' ?> rounded-pill px-4 province-btn">
            <i class="bi bi-globe me-1"></i>Tất cả
        </a>
        <?php foreach ($provinces as $prov): ?>
            <a href="/cinemas?province=<?= urlencode($prov) ?>"
               class="btn btn-sm <?= $selectedProvince === $prov ? 'btn-warning' : 'btn-outline-secondary' ?> rounded-pill px-3 province-btn">
                <?= htmlspecialchars($prov) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Danh sách rạp -->
<div class="row g-4">
    <?php foreach ($cinemas as $index => $cinema): ?>
        <div class="col-md-6 col-lg-4" data-aos="zoom-in-up" data-aos-delay="<?= ($index % 3) * 100 ?>">
            <div class="card cinema-card bg-white shadow-sm border-0 h-100 overflow-hidden shadow-lg hover-shadow transition-all"
                 onclick="location.href='/cinemas/<?= htmlspecialchars($cinema->slug) ?>'">

                <!-- Ảnh rạp -->
                <div class="position-relative overflow-hidden" style="height: 200px;">
                    <?php
                    $unsplashImages = [
                        'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=800&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?q=80&w=800&auto=format&fit=crop',
                        'https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop'
                    ];
                    $fallbackImage = $unsplashImages[($cinema->id ?? crc32($cinema->name)) % count($unsplashImages)];
                    ?>
                    <img src="<?= htmlspecialchars($cinema->image_url ?: $fallbackImage) ?>"
                         class="w-100 h-100 cinema-img"
                         alt="<?= htmlspecialchars($cinema->name) ?>"
                         style="object-fit: cover;"
                         onerror="this.onerror=null; this.src='<?= $fallbackImage ?>'">
                    <div class="position-absolute bottom-0 start-0 end-0 p-3"
                         style="background: linear-gradient(transparent, rgba(0,0,0,0.85));">
                        <h5 class="text-warning fw-bold mb-0"><?= htmlspecialchars($cinema->name) ?></h5>
                    </div>
                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2 rounded-pill">
                        <i class="bi bi-pin-map-fill me-1"></i><?= htmlspecialchars($cinema->province) ?>
                    </span>
                </div>

                <div class="card-body">
                    <p class="text-secondary small mb-2">
                        <i class="bi bi-geo-alt me-1 text-danger"></i>
                        <?= htmlspecialchars($cinema->address) ?>
                    </p>
                    <p class="text-secondary small mb-2">
                        <i class="bi bi-building me-1 text-info"></i>
                        <?= htmlspecialchars($cinema->district) ?>, <?= htmlspecialchars($cinema->province) ?>
                    </p>
                    <?php if ($cinema->phone): ?>
                        <p class="text-secondary small mb-2">
                            <i class="bi bi-telephone me-1 text-success"></i>
                            <?= htmlspecialchars($cinema->phone) ?>
                        </p>
                    <?php endif; ?>
                    <p class="text-secondary small mb-3">
                        <i class="bi bi-clock me-1 text-warning"></i>
                        <?= htmlspecialchars($cinema->opening_hours ?? '08:00 - 23:30') ?>
                    </p>

                    <!-- Tiện ích -->
                    <?php
                    $facilities = $cinema->facilities ?? null;
                    if (is_string($facilities)) {
                        $facilities = str_replace(['{','}'], '', $facilities);
                        $facilities = $facilities ? explode(',', $facilities) : [];
                    }
                    ?>
                    <?php if (!empty($facilities)): ?>
                        <div class="d-flex flex-wrap gap-1">
                            <?php foreach ($facilities as $facility): ?>
                                <span class="badge facility-badge rounded-pill">
                                    <?= htmlspecialchars(trim($facility, '" ')) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-footer bg-transparent border-top border-light p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/cinemas/<?= htmlspecialchars($cinema->slug) ?>"
                           class="btn btn-sm btn-outline-warning rounded-pill" onclick="event.stopPropagation();">
                            <i class="bi bi-info-circle me-1"></i>Chi tiết
                        </a>
                        <a href="/cinemas/<?= htmlspecialchars($cinema->slug) ?>"
                           class="btn btn-sm btn-warning rounded-pill" onclick="event.stopPropagation();">
                            <i class="bi bi-calendar-check me-1"></i>Lịch chiếu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (empty($cinemas)): ?>
    <div class="text-center py-5">
        <i class="bi bi-geo-alt fs-1 text-secondary opacity-50"></i>
        <p class="text-secondary mt-3 fs-5">Chưa có rạp nào trong khu vực này</p>
    </div>
<?php endif; ?>


<!-- Bảng Giá Vé Tham Khảo -->
<div class="mt-5 pt-5 border-top border-light" data-aos="fade-up">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark mb-3"><i class="bi bi-ticket-perforated text-warning me-2"></i>Bảng Giá Vé Tham Khảo</h2>
        <p class="text-secondary">Giá vé có thể thay đổi tùy theo rạp, khung giờ và ngày lễ tết.</p>
    </div>
    <div class="row g-4 justify-content-center">
        <!-- 2D Ticket -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-light bg-white shadow-sm h-100 text-center hover-shadow transition-all">
                <div class="card-header bg-light border-light py-4"><h4 class="fw-bold text-dark mb-0">Vé 2D Tiêu Chuẩn</h4></div>
                <div class="card-body py-4">
                    <h2 class="display-5 fw-bold text-warning mb-4">65.000<small class="fs-5 text-secondary">₫</small></h2>
                    <ul class="list-unstyled text-secondary text-start mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Thứ 2 - Thứ 5</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Trước 17:00</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ghế thường/VIP</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 3D Ticket -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-warning bg-white shadow-lg h-100 text-center position-relative" style="transform: scale(1.05); z-index: 2;">
                <div class="position-absolute top-0 start-50 translate-middle"><span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">PHỔ BIẾN NHẤT</span></div>
                <div class="card-header bg-warning py-4 border-warning"><h4 class="fw-bold text-dark mb-0">Vé Cuối Tuần / Lễ</h4></div>
                <div class="card-body py-4">
                    <h2 class="display-5 fw-bold text-dark mb-4">95.000<small class="fs-5 text-secondary">₫</small></h2>
                    <ul class="list-unstyled text-secondary text-start mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Thứ 6 - Chủ Nhật</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ngày Lễ / Tết</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ghế thường/VIP</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quy định rạp chiếu phim -->
<div class="mt-5 pt-5 mb-5 border-top border-light" data-aos="fade-up">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0"><img src="https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg" alt="Cinema Rules"></div>
        <div class="col-lg-6 px-lg-5">
            <h2 class="fw-bold text-dark mb-4">Quy Định Chung Tại Rạp</h2>
            <div class="d-flex mb-4">
                <div class="me-3"><div class="bg-light text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;"><i class="bi bi-camera-video-off fs-4"></i></div></div>
                <div><h5 class="fw-bold text-dark mb-1">Không Quay Phim / Chụp Ảnh</h5><p class="text-secondary mb-0">Nghiêm cấm mọi hành vi ghi âm, ghi hình trong phòng chiếu.</p></div>
            </div>
        </div>
    </div>
</div>