<?php
// views/cinemas/detail.php
use App\Core\Session;
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="/cinemas" class="text-warning text-decoration-none">Hệ thống rạp</a></li>
        <li class="breadcrumb-item active text-secondary"><?= htmlspecialchars($cinema->name) ?></li>
    </ol>
</nav>

<div class="row g-4">
    <!-- Cột trái: Thông tin rạp -->
    <div class="col-lg-8">
        <!-- Banner rạp -->
        <div class="cinema-detail-banner position-relative rounded-4 overflow-hidden mb-4" data-aos="fade-in" style="height: 350px;">
            <?php
            $unsplashImages = [
                'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=1200&auto=format&fit=crop'
            ];
            $fallbackImage = $unsplashImages[($cinema->id ?? crc32($cinema->name)) % count($unsplashImages)];
            ?>
            <img src="<?= htmlspecialchars($cinema->image_url ?: $fallbackImage) ?>"
                 class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);"
                 alt="<?= htmlspecialchars($cinema->name) ?>"
                 onerror="this.onerror=null; this.src='<?= $fallbackImage ?>'">
            <div class="position-absolute bottom-0 start-0 p-4 w-100"
                 style="background: linear-gradient(transparent, rgba(0,0,0,0.9));">
                <h1 class="text-warning fw-bold display-6 mb-1" data-aos="fade-right" data-aos-delay="100">
                    <i class="bi bi-camera-reels me-2"></i><?= htmlspecialchars($cinema->name) ?>
                </h1>
                <p class="text-light mb-0" data-aos="fade-right" data-aos-delay="200">
                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                    <?= htmlspecialchars($cinema->address) ?>
                </p>
            </div>
        </div>

        <!-- Thông tin chi tiết -->
        <div class="card bg-dark border-0 shadow-lg mb-4 cinema-info-card" data-aos="fade-up">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-info-circle me-2"></i>Thông tin rạp</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="info-item p-3 rounded-3">
                            <i class="bi bi-geo-alt-fill text-danger fs-4 mb-2 d-block"></i>
                            <small class="text-secondary d-block">Địa chỉ</small>
                            <strong class="text-light"><?= htmlspecialchars($cinema->address) ?></strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item p-3 rounded-3">
                            <i class="bi bi-building text-info fs-4 mb-2 d-block"></i>
                            <small class="text-secondary d-block">Khu vực</small>
                            <strong class="text-light">
                                <?= htmlspecialchars($cinema->district) ?>, <?= htmlspecialchars($cinema->province) ?>
                            </strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item p-3 rounded-3">
                            <i class="bi bi-telephone-fill text-success fs-4 mb-2 d-block"></i>
                            <small class="text-secondary d-block">Hotline</small>
                            <strong class="text-light">
                                <a href="tel:<?= htmlspecialchars($cinema->phone ?? '') ?>" class="text-light text-decoration-none">
                                    <?= htmlspecialchars($cinema->phone ?? 'Chưa cập nhật') ?>
                                </a>
                            </strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item p-3 rounded-3">
                            <i class="bi bi-clock-fill text-warning fs-4 mb-2 d-block"></i>
                            <small class="text-secondary d-block">Giờ hoạt động</small>
                            <strong class="text-light"><?= htmlspecialchars($cinema->opening_hours ?? '08:00 - 23:30') ?></strong>
                        </div>
                    </div>
                    <?php if ($cinema->email): ?>
                    <div class="col-sm-6">
                        <div class="info-item p-3 rounded-3">
                            <i class="bi bi-envelope-fill text-primary fs-4 mb-2 d-block"></i>
                            <small class="text-secondary d-block">Email</small>
                            <strong class="text-light"><?= htmlspecialchars($cinema->email) ?></strong>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Tiện ích -->
                <?php
                $facilities = $cinema->facilities ?? null;
                if (is_string($facilities)) {
                    $facilities = str_replace(['{','}'], '', $facilities);
                    $facilities = $facilities ? explode(',', $facilities) : [];
                }
                ?>
                <?php if (!empty($facilities)): ?>
                    <h6 class="text-warning mt-4 mb-3"><i class="bi bi-ui-checks me-1"></i>Tiện ích & Công nghệ</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($facilities as $facility):
                            $f = trim($facility, '" ');
                            $icon = match($f) {
                                'IMAX'         => 'bi-badge-hd',
                                '4DX'          => 'bi-badge-4k',
                                'Dolby Atmos'  => 'bi-volume-up',
                                'Parking'      => 'bi-p-circle',
                                'F&B'          => 'bi-cup-hot',
                                'Sweetbox'     => 'bi-people',
                                'VIP Lounge'   => 'bi-door-open',
                                'ScreenX'      => 'bi-aspect-ratio',
                                default        => 'bi-check-circle',
                            };
                        ?>
                            <span class="badge facility-badge-lg rounded-pill px-3 py-2">
                                <i class="bi <?= $icon ?> me-1"></i><?= htmlspecialchars($f) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bản đồ Google Maps -->
        <?php if ($cinema->latitude && $cinema->longitude): ?>
        <div class="card bg-dark border-0 shadow-lg mb-4">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-map me-2"></i>Bản đồ</h5>
            </div>
            <div class="card-body p-0">
                <iframe
                    src="https://maps.google.com/maps?q=<?= $cinema->latitude ?>,<?= $cinema->longitude ?>&z=16&output=embed"
                    width="100%" height="350"
                    style="border:0; border-radius: 0 0 12px 12px;"
                    allowfullscreen loading="lazy">
                </iframe>
            </div>
        </div>
        <?php endif; ?>

        <!-- Mô tả rạp -->
        <?php if ($cinema->description): ?>
        <div class="card bg-dark border-0 shadow-lg mb-4">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-text-paragraph me-2"></i>Giới thiệu</h5>
            </div>
            <div class="card-body">
                <p class="text-light lh-lg"><?= nl2br(htmlspecialchars($cinema->description)) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Gallery Hình ảnh -->
        <div class="card bg-dark border-0 shadow-lg mb-4">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-images me-2"></i>Không Gian Rạp</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <img src="https://placehold.co/400x300/1a1a3e/fff?text=Lobby" class="img-fluid rounded-3 w-100" style="object-fit: cover; height: 150px;" alt="Lobby">
                    </div>
                    <div class="col-md-4">
                        <img src="https://placehold.co/400x300/0f0f1b/fff?text=Cinema+Hall" class="img-fluid rounded-3 w-100" style="object-fit: cover; height: 150px;" alt="Cinema Hall">
                    </div>
                    <div class="col-md-4">
                        <img src="https://placehold.co/400x300/2d1f6e/fff?text=Popcorn+Bar" class="img-fluid rounded-3 w-100" style="object-fit: cover; height: 150px;" alt="Popcorn Bar">
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng Giá Vé -->
        <div class="card bg-dark border-0 shadow-lg mb-4" data-aos="fade-up">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-tags me-2"></i>Bảng Giá Vé Tiêu Chuẩn</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 text-center align-middle">
                        <thead class="table-secondary text-dark">
                            <tr>
                                <th>Loại Khách</th>
                                <th>2D (T2 - T5)</th>
                                <th>2D (Cuối tuần, Lễ)</th>
                                <th>3D / IMAX</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-start fw-bold ps-4">Người Lớn</td>
                                <td>75.000₫</td>
                                <td>95.000₫</td>
                                <td>150.000₫</td>
                            </tr>
                            <tr>
                                <td class="text-start fw-bold ps-4">Học Sinh / Sinh Viên</td>
                                <td>55.000₫</td>
                                <td>75.000₫</td>
                                <td>120.000₫</td>
                            </tr>
                            <tr>
                                <td class="text-start fw-bold ps-4">Trẻ Em / Người Cao Tuổi</td>
                                <td>50.000₫</td>
                                <td>60.000₫</td>
                                <td>100.000₫</td>
                            </tr>
                            <tr>
                                <td class="text-start fw-bold ps-4">Ghế Đôi (Sweetbox)</td>
                                <td>+20.000₫ / ghế</td>
                                <td>+25.000₫ / ghế</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột phải -->
    <div class="col-lg-4">
        <!-- Phòng chiếu -->
        <div class="card bg-dark border-0 shadow-lg mb-4 sticky-top" style="top: 20px;" data-aos="fade-left">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-door-open me-2"></i>Phòng chiếu (<?= count($rooms) ?>)</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($rooms)): ?>
                    <div class="text-center py-4">
                        <p class="text-secondary mb-0">Chưa có phòng chiếu</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($rooms as $room): ?>
                            <div class="list-group-item bg-transparent border-secondary text-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($room->name) ?></strong>
                                        <br>
                                        <small class="text-secondary">
                                            <?= $room->total_rows * $room->seats_per_row ?> ghế
                                        </small>
                                    </div>
                                    <span class="badge bg-warning text-dark rounded-pill">Standard</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lịch chiếu hôm nay -->
        <div class="card bg-dark border-0 shadow-lg" data-aos="fade-left" data-aos-delay="200">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-calendar-event me-2"></i>Lịch chiếu hôm nay</h5>
            </div>
            <div class="card-body">
                <?php if (empty($showtimes)): ?>
                    <div class="text-center py-3">
                        <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50 text-secondary"></i>
                        <p class="text-secondary">Chưa có suất chiếu nào hôm nay</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($showtimes as $st): ?>
                        <div class="showtime-card mb-2" onclick="location.href='/booking/<?= $st->id ?>'">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="room-badge"><?= htmlspecialchars($st->room_name) ?></span>
                                <span class="seats-left text-light fw-bold"><?= htmlspecialchars($st->movie_title) ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="time"><?= htmlspecialchars($st->start_time) ?></div>
                                <div class="price">Đặt vé ngay <i class="bi bi-arrow-right ms-1"></i></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
