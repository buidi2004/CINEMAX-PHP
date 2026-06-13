<?php
// views/home/index.php
?>
<!-- #1 Hero Carousel -->
<div id="heroCarousel" class="carousel slide mb-4 shadow-lg" data-bs-ride="carousel" data-aos="fade-in" data-aos-duration="1500">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner rounded-4 overflow-hidden" style="border: 1px solid #222244;">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="position-relative hero-slide">
                <img src="https://images.unsplash.com/photo-1534809027769-b00d750a6bac?q=80&w=1200&auto=format&fit=crop" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);" alt="Slide 1">
                <div class="carousel-caption text-start bottom-0 pb-4 pb-md-5 ps-3 ps-md-4 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.95)); left: 0; right: 0;">
                    <span class="badge bg-danger mb-2 px-2 px-md-3 py-1 py-md-2 fs-7 fs-md-6" data-aos="fade-up" data-aos-delay="200">ĐANG CHIẾU</span>
                    <h1 class="display-6 display-md-4 fw-bold text-warning text-shadow mb-1" data-aos="fade-up" data-aos-delay="400">AVENGERS: ENDGAME</h1>
                    <p class="fs-6 fs-md-5 text-light d-none d-sm-block" data-aos="fade-up" data-aos-delay="600">Trận chiến cuối cùng của các siêu anh hùng. Khởi chiếu 26/04/2026.</p>
                    <div class="mt-2 mt-md-3" data-aos="fade-up" data-aos-delay="800">
                        <a href="/movies/1" class="btn btn-warning btn-sm btn-md-lg fw-bold px-3 px-md-4 rounded-pill me-2"><i class="bi bi-ticket-perforated me-1 me-md-2"></i>Đặt Vé Ngay</a>
                        <button class="btn btn-outline-dark btn-sm btn-md-lg rounded-pill px-3 px-md-4"><i class="bi bi-play-circle me-1 me-md-2"></i>Xem Trailer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="position-relative hero-slide">
                <img src="https://images.unsplash.com/photo-1473580044384-7ba9967e16a0?q=80&w=1200&auto=format&fit=crop" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);" alt="Slide 2">
                <div class="carousel-caption text-start bottom-0 pb-4 pb-md-5 ps-3 ps-md-4 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.95)); left: 0; right: 0;">
                    <span class="badge bg-info mb-2 px-2 px-md-3 py-1 py-md-2 fs-7 fs-md-6 text-dark">SẮP CHIẾU</span>
                    <h1 class="display-6 display-md-4 fw-bold text-light text-shadow mb-1">DUNE: PART TWO</h1>
                    <p class="fs-6 fs-md-5 text-secondary d-none d-sm-block">Hành trình vĩ đại trên hành tinh cát. Trải nghiệm định dạng IMAX.</p>
                    <div class="mt-2 mt-md-3">
                        <button class="btn btn-outline-info btn-sm btn-md-lg rounded-pill px-3 px-md-4"><i class="bi bi-info-circle me-1 me-md-2"></i>Tìm Hiểu Thêm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
            <div class="position-relative hero-slide">
                <img src="https://images.unsplash.com/photo-1605806616949-1e87b487cb2a?q=80&w=1200&auto=format&fit=crop" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);" alt="Slide 3">
                <div class="carousel-caption text-start bottom-0 pb-4 pb-md-5 ps-3 ps-md-4 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.95)); left: 0; right: 0;">
                    <span class="badge bg-danger mb-2 px-2 px-md-3 py-1 py-md-2 fs-7 fs-md-6">ĐANG CHIẾU</span>
                    <h1 class="display-6 display-md-4 fw-bold text-warning text-shadow mb-1">SPIDER-MAN: NO WAY HOME</h1>
                    <p class="fs-6 fs-md-5 text-light d-none d-sm-block">Đa vũ trụ mở ra. Đừng bỏ lỡ siêu phẩm Marvel.</p>
                    <div class="mt-2 mt-md-3">
                        <a href="/movies/2" class="btn btn-warning btn-sm btn-md-lg fw-bold px-3 px-md-4 rounded-pill me-2"><i class="bi bi-ticket-perforated me-1 me-md-2"></i>Đặt Vé Ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- #2 Quick Booking Bar -->
<div class="card bg-white border-0 shadow-lg mb-5 rounded-4 overflow-hidden quick-book-bar" data-aos="fade-up" data-aos-delay="200" style="border: 1px solid rgba(255,193,7,0.3) !important; margin-top: 2rem; position: relative; z-index: 10;">
    <div class="card-body p-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-warning fw-bold small"><i class="bi bi-film me-1"></i>Chọn Phim</label>
                <select class="form-select bg-light border-0 text-dark rounded-pill">
                    <option>-- Chọn phim --</option>
                    <?php foreach ($nowShowing ?? [] as $m): ?>
                        <option value="<?= $m->id ?>"><?= htmlspecialchars($m->title) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-warning fw-bold small"><i class="bi bi-geo-alt me-1"></i>Chọn Rạp</label>
                <select class="form-select bg-light border-0 text-dark rounded-pill">
                    <option>-- Chọn rạp --</option>
                    <option>CinemaX Quận 1</option>
                    <option>CinemaX Gò Vấp</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-warning fw-bold small"><i class="bi bi-calendar3 me-1"></i>Ngày chiếu</label>
                <input type="date" class="form-control bg-light border-0 text-dark rounded-pill" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
                <button class="btn btn-warning w-100 rounded-pill fw-bold" onclick="location.href='/search'"><i class="bi bi-search me-1"></i>Tìm Suất</button>
            </div>
        </div>
    </div>
</div>

<!-- #8 Phim Thịnh Hành (Trending Now) - NEW SECTION -->
<div class="mb-5 pt-2" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-warning border-start border-warning border-5 ps-3 fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">
            <span class="section-icon section-icon-warning"><i class="bi bi-graph-up-arrow"></i></span>Phim Thịnh Hành
        </h2>
    </div>
    <div class="d-flex gap-4 overflow-x-auto pb-4 custom-scrollbar" style="scroll-snap-type: x mandatory;">
        <?php 
        $trendingCount = 0;
        foreach ($nowShowing ?? [] as $movie): 
            if($trendingCount++ > 4) break;
        ?>
        <div class="flex-shrink-0" style="width: 350px; scroll-snap-align: start;" data-aos="fade-left" data-aos-delay="<?= $trendingCount * 100 ?>">
            <div class="movie-card-3d h-100">
                <div class="card bg-white border-0 shadow-lg movie-card rounded-4 overflow-hidden position-relative" onclick="location.href='/movies/<?= $movie->id ?>'">
                    <img src="<?= htmlspecialchars($movie->posterUrl ?: 'https://placehold.co/400x600/111/fff') ?>" 
                         class="w-100" style="height: 500px; object-fit: cover;" alt="<?= htmlspecialchars($movie->title) ?>">
                    <div class="position-absolute bottom-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.95), transparent);">
                        <h4 class="text-dark fw-bold mb-1 text-truncate"><?= htmlspecialchars($movie->title) ?></h4>
                        <div class="d-flex align-items-center mb-2">
                            <span class="rating-chip"><i class="bi bi-star me-1"></i>4.8/5</span>
                        </div>
                        <button class="btn btn-warning btn-sm rounded-pill fw-bold w-100 mt-2">ĐẶT VÉ</button>
                    </div>
                    <div class="position-absolute top-0 start-0 m-3 fs-3 fw-bold text-shadow" style="color: rgba(255,255,255,0.8); font-family: Impact, sans-serif;">
                        #<?= $trendingCount ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- #3 Phim đang chiếu -->
<div class="mb-5 mt-4" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-warning border-start border-warning border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-warning"><i class="bi bi-camera-reels"></i></span>PHIM ĐANG CHIẾU
        </h2>
        <a href="/movies" class="text-warning text-decoration-none small fw-bold hover-shadow">Xem tất cả <i class="bi bi-chevron-right"></i></a>
    </div>

    <?php if (empty($nowShowing)): ?>
        <p class="text-secondary fst-italic">Hiện tại không có phim nào đang chiếu.</p>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($nowShowing as $index => $movie): ?>
                <div class="col" data-aos="zoom-in" data-aos-delay="<?= ($index % 5) * 100 ?>">
                    <div class="movie-card-3d h-100">
                        <div class="card bg-white border border-light h-100 shadow movie-card"
                             onclick="location.href='/movies/<?= $movie->id ?>'">
                            <div class="position-relative">
                                <img src="<?= htmlspecialchars($movie->posterUrl ?: 'https://placehold.co/400x600/111/fff?text=No+Poster') ?>"
                                     class="card-img-top img-fluid rounded-top"
                                     alt="<?= htmlspecialchars($movie->title) ?>"
                                     style="height: 300px; object-fit: cover;">
                                <?php if ($movie->ageRating): ?>
                                    <span class="badge position-absolute top-0 end-0 m-2 badge-<?= strtolower($movie->ageRating) ?>">
                                        <?= htmlspecialchars($movie->ageRating) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-3 bg-white">
                                <h6 class="card-title text-dark mb-2 text-truncate fw-bold">
                                    <?= htmlspecialchars($movie->title) ?>
                                </h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-secondary">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= htmlspecialchars($movie->getFormattedDuration()) ?>
                                    </small>
                                    <span class="badge bg-warning text-dark font-monospace" style="font-size: 0.75rem;">ĐẶT VÉ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- #4 Phim sắp chiếu -->
<div class="mb-5" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-info border-start border-info border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-info"><i class="bi bi-calendar-week"></i></span>PHIM SẮP CHIẾU
        </h2>
    </div>

    <?php if (empty($comingSoon)): ?>
        <p class="text-secondary fst-italic">Không có phim sắp chiếu trong danh sách.</p>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($comingSoon as $index => $movie): ?>
                <div class="col" data-aos="flip-left" data-aos-delay="<?= ($index % 5) * 100 ?>">
                    <div class="movie-card-3d h-100">
                        <div class="card bg-white border border-light h-100 shadow movie-card"
                             onclick="location.href='/movies/<?= $movie->id ?>'">
                            <div class="position-relative">
                                <img src="<?= htmlspecialchars($movie->posterUrl ?: 'https://placehold.co/400x600/111/fff?text=No+Poster') ?>"
                                     class="card-img-top img-fluid rounded-top"
                                     alt="<?= htmlspecialchars($movie->title) ?>"
                                     style="height: 300px; object-fit: cover;">
                                <?php if ($movie->ageRating): ?>
                                    <span class="badge position-absolute top-0 end-0 m-2 badge-<?= strtolower($movie->ageRating) ?>">
                                        <?= htmlspecialchars($movie->ageRating) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-3 bg-white">
                                <h6 class="card-title text-dark mb-2 text-truncate fw-bold">
                                    <?= htmlspecialchars($movie->title) ?>
                                </h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-secondary">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= htmlspecialchars($movie->getFormattedDuration()) ?>
                                    </small>
                                    <span class="badge bg-info text-dark font-monospace" style="font-size: 0.75rem;">SẮP CHIẾU</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- #9 Bắp Nước & Quà Tặng (Concessions & Merch) - NEW SECTION -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-success border-start border-success border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-success"><i class="bi bi-cup-hot"></i></span>QUÀ TẶNG & BẮP NƯỚC
        </h2>
    </div>
    <div class="row g-4">
        <div class="col-md-6" data-aos="fade-right">
            <div class="card bg-white border-0 overflow-hidden rounded-4 h-100 shadow-lg position-relative group-hover">
                <img src="https://placehold.co/800x400/2a1a1a/e5a720?text=Combo+Avatar" class="w-100 h-100 transition-all" style="object-fit: cover;" alt="Combo Avatar">
                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(255,255,255,0.95));">
                    <h4 class="text-warning fw-bold mb-1">Avatar: The Way of Water Combo</h4>
                    <p class="text-dark mb-2">1 Ly nước tạo hình + 1 Bắp khổng lồ + Tặng kèm Postcard</p>
                    <strong class="text-danger fs-5">299.000₫</strong>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-4 h-100">
                <div class="col-12 h-50" data-aos="fade-down">
                    <div class="card bg-white border-0 overflow-hidden rounded-4 h-100 shadow position-relative group-hover">
                        <img src="https://placehold.co/800x200/1f1f1f/fff?text=Combo+Couple" class="w-100 h-100 transition-all" style="object-fit: cover;" alt="Combo Couple">
                        <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(transparent, rgba(255,255,255,0.9));">
                            <h5 class="text-dark fw-bold mb-0">Combo Couple (2 Nước + 1 Bắp)</h5>
                            <strong class="text-warning">109.000₫</strong>
                        </div>
                    </div>
                </div>
                <div class="col-12 h-50" data-aos="fade-up">
                    <div class="card bg-white border-0 overflow-hidden rounded-4 h-100 shadow position-relative group-hover">
                        <img src="https://placehold.co/800x200/111/fff?text=Dune+Merchandise" class="w-100 h-100 transition-all" style="object-fit: cover;" alt="Dune Merch">
                        <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(transparent, rgba(255,255,255,0.9));">
                            <h5 class="text-dark fw-bold mb-0">Exclusive Dune Sandworm Bucket</h5>
                            <strong class="text-warning">399.000₫</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #5 Section Ưu Đãi Nổi Bật -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-danger border-start border-danger border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-danger"><i class="bi bi-percent"></i></span>ƯU ĐÃI NỔI BẬT
        </h2>
        <a href="/promotions" class="text-danger text-decoration-none small fw-bold">Tất cả ưu đãi <i class="bi bi-chevron-right"></i></a>
    </div>

    <div class="row g-4">
        <?php foreach ($promotions ?? [] as $index => $promo): ?>
            <div class="col-md-4" data-aos="zoom-in-up" data-aos-delay="<?= $index * 150 ?>">
                <div class="card promo-card bg-white shadow-sm border border-light border-0 overflow-hidden h-100" onclick="location.href='/promotions/<?= $promo->id ?>'">
                    <div class="card-body p-4 position-relative">
                        <div class="promo-ribbon"><?= $promo->discount_type === 'percent' ? $promo->discount_value . '%' : 'DEAL' ?></div>
                        <h5 class="text-warning fw-bold mb-2"><?= htmlspecialchars($promo->code) ?></h5>
                        <p class="text-secondary small mb-3">Ưu đãi giảm giá trực tiếp vào đơn hàng</p>
                        <div class="d-flex flex-wrap gap-2">
                            <small class="text-secondary"><i class="bi bi-calendar me-1"></i> HSD: <?= date('d/m/Y', strtotime($promo->expires_at)) ?></small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- #6 Trải Nghiệm Điện Ảnh -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <h2 class="h4 text-success border-start border-success border-4 ps-3 fw-bold mb-4 text-center border-0" data-aos="fade-down">
        TRẢI NGHIỆM ĐIỆN ẢNH ĐỈNH CAO TẠI CINEMAX
    </h2>
    <div class="row g-4 text-center mt-3">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="p-4 rounded-4 bg-white shadow-sm border border-light experience-card h-100 transition-all">
                <span class="experience-icon experience-icon-success"><i class="bi bi-volume-up"></i></span>
                <h5 class="text-dark fw-bold">Âm Thanh Dolby Atmos</h5>
                <p class="text-secondary small">Hệ thống âm thanh vòm sống động, chi tiết đến từng nhịp đập, đưa bạn vào thế giới phim.</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="p-4 rounded-4 bg-white shadow-sm border border-light experience-card h-100 transition-all">
                <span class="experience-icon experience-icon-info"><i class="bi bi-aspect-ratio"></i></span>
                <h5 class="text-dark fw-bold">Màn Hình IMAX Khổng Lồ</h5>
                <p class="text-secondary small">Hình ảnh sắc nét, độ sáng vượt trội, trường nhìn bao quát toàn bộ tầm mắt.</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="p-4 rounded-4 bg-white shadow-sm border border-light experience-card h-100 transition-all">
                <span class="experience-icon experience-icon-danger"><i class="bi bi-people"></i></span>
                <h5 class="text-dark fw-bold">Ghế Đôi Sweetbox</h5>
                <p class="text-secondary small">Không gian riêng tư lý tưởng dành cho các cặp đôi với vách ngăn cao cấp.</p>
            </div>
        </div>
    </div>
</div>

<!-- #10 Tải Ứng Dụng (App Download) - NEW SECTION -->
<div class="mb-5 pt-5 pb-5 mt-5 rounded-5 shadow-lg position-relative overflow-hidden" data-aos="fade-up" style="background: linear-gradient(135deg, #f8f9fa 0%, #e2e8f0 100%); border: 1px solid #333;">
    <div class="row align-items-center position-relative z-1">
        <div class="col-md-6 p-5 text-center text-md-start">
            <h2 class="display-5 fw-bold text-dark mb-3" data-aos="fade-right">CinemaX App</h2>
            <p class="fs-5 text-secondary mb-4" data-aos="fade-right" data-aos-delay="100">Đặt vé nhanh hơn, nhận nhiều ưu đãi độc quyền chỉ có trên ứng dụng điện thoại. Tải ngay!</p>
            <div class="d-flex justify-content-center justify-content-md-start gap-3" data-aos="fade-right" data-aos-delay="200">
                <button class="btn btn-outline-dark rounded-pill px-4 py-2 fs-5"><i class="bi bi-apple me-2"></i>App Store</button>
                <button class="btn btn-outline-dark rounded-pill px-4 py-2 fs-5"><i class="bi bi-google-play me-2"></i>Google Play</button>
            </div>
        </div>
        <div class="col-md-6 text-center" data-aos="fade-left" data-aos-delay="300">
            <!-- Mockup Smartphone Image Placeholder -->
            <img src="https://placehold.co/300x500/000/fff?text=CinemaX+App+UI" class="img-fluid rounded-4 shadow-lg border border-secondary" style="transform: rotate(-10deg); max-height: 400px;" alt="App Mockup">
        </div>
    </div>
    <!-- Background Decor -->
    <div class="position-absolute top-0 end-0 w-50 h-100 bg-warning rounded-circle opacity-10" style="filter: blur(100px); transform: translate(30%, -30%);"></div>
</div>

<!-- #7 Tin Tức Mới Nhất -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-warning border-start border-warning border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-warning"><i class="bi bi-journal-text"></i></span>TIN TỨC ĐIỆN ẢNH
        </h2>
        <a href="/news" class="text-warning text-decoration-none small fw-bold">Tất cả tin tức <i class="bi bi-chevron-right"></i></a>
    </div>

    <div class="row g-4">
        <?php foreach ($news ?? [] as $index => $n): ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $index * 150 ?>">
                <div class="card bg-white shadow-sm border border-light h-100 news-card overflow-hidden" onclick="location.href='/news/<?= htmlspecialchars($n->slug) ?>'">
                    <img src="<?= htmlspecialchars($n->image_url ?: 'https://placehold.co/600x300/1a1a3e/fff?text=News') ?>" class="card-img-top transition-all" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($n->title) ?>">
                    <div class="card-body">
                        <span class="badge bg-secondary rounded-pill mb-2"><?= htmlspecialchars($n->category) ?></span>
                        <h6 class="text-dark fw-bold mb-2"><?= htmlspecialchars($n->title) ?></h6>
                        <small class="text-secondary"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($n->published_at)) ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- #12 Chương Trình Thành Viên -->
<div class="mb-5 pt-5 pb-5 rounded-4 shadow-lg overflow-hidden position-relative" data-aos="fade-up" style="background: linear-gradient(45deg, #f8f9fa 0%, #e2e8f0 100%);">
    <div class="row align-items-center position-relative z-1 px-4">
        <div class="col-lg-5 text-center text-lg-start mb-4 mb-lg-0">
            <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-bold rounded-pill"><i class="bi bi-star-fill me-1"></i> CINEMAX CLUB</span>
            <h2 class="display-6 fw-bold text-dark mb-3">Đặc Quyền Thành Viên</h2>
            <p class="fs-5 text-secondary mb-4">Tích điểm đổi quà, nhân đôi ưu đãi vào ngày lễ, trải nghiệm phòng chờ VIP và nhận vé xem phim miễn phí vào tháng sinh nhật.</p>
            <button class="btn btn-warning btn-lg rounded-pill px-5 fw-bold hover-shadow">ĐĂNG KÝ NGAY</button>
        </div>
        <div class="col-lg-7">
            <div class="row g-3">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card bg-white border border-light shadow-sm rounded-4 h-100 text-center p-3 transition-all group-hover member-card">
                        <div class="text-secondary mb-2 fs-1"><i class="bi bi-award-fill"></i></div>
                        <h5 class="text-dark fw-bold">Silver</h5>
                        <p class="small text-secondary mb-0">Tích lũy 5% giá trị. Tặng 1 bắp ngọt tháng sinh nhật.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card bg-white border border-warning shadow rounded-4 h-100 text-center p-3 transition-all group-hover member-card" style="box-shadow: 0 0 15px rgba(255,193,7,0.2);">
                        <div class="text-warning mb-2 fs-1"><i class="bi bi-award-fill"></i></div>
                        <h5 class="text-warning fw-bold">Gold</h5>
                        <p class="small text-secondary mb-0">Tích lũy 10% giá trị. Tặng 1 vé 2D tháng sinh nhật.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card bg-white border border-info shadow-sm rounded-4 h-100 text-center p-3 transition-all group-hover member-card">
                        <div class="text-info mb-2 fs-1"><i class="bi bi-award-fill"></i></div>
                        <h5 class="text-info fw-bold">Platinum</h5>
                        <p class="small text-secondary mb-0">Tích lũy 15% giá trị. Sử dụng phòng chờ VIP miễn phí.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #15 Định Dạng Chiếu Đặc Biệt -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-info border-start border-info border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-info"><i class="bi bi-projector"></i></span>ĐỊNH DẠNG ĐẶC BIỆT
        </h2>
    </div>
    <div class="row g-4">
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="card bg-white border-0 rounded-4 overflow-hidden h-100 shadow-lg group-hover position-relative" style="min-height: 250px;">
                <img src="https://images.unsplash.com/photo-1594909122845-11baa439b7bf?q=80&w=800&auto=format&fit=crop" class="w-100 h-100 transition-all position-absolute" style="object-fit: cover;" alt="IMAX">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: linear-gradient(to top, rgba(255,255,255,0.95) 10%, transparent);"></div>
                <div class="position-absolute bottom-0 p-4">
                    <h3 class="fw-bold text-info" style="letter-spacing: 2px;">IMAX</h3>
                    <p class="text-dark mb-0 small">Trải nghiệm điện ảnh tối thượng với màn hình cong khổng lồ và hệ thống âm thanh laser đa chiều.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="card bg-white border-0 rounded-4 overflow-hidden h-100 shadow-lg group-hover position-relative" style="min-height: 250px;">
                <img src="https://images.unsplash.com/photo-1606335543042-57c525922933?q=80&w=800&auto=format&fit=crop" class="w-100 h-100 transition-all position-absolute" style="object-fit: cover;" alt="4DX">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: linear-gradient(to top, rgba(255,255,255,0.95) 10%, transparent);"></div>
                <div class="position-absolute bottom-0 p-4">
                    <h3 class="fw-bold text-danger" style="letter-spacing: 2px;">4DX</h3>
                    <p class="text-dark mb-0 small">Đánh thức mọi giác quan với ghế chuyển động đa chiều, gió, sương, mùi hương và hiệu ứng nước.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="card bg-white border-0 rounded-4 overflow-hidden h-100 shadow-lg group-hover position-relative" style="min-height: 250px;">
                <img src="https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=800&auto=format&fit=crop" class="w-100 h-100 transition-all position-absolute" style="object-fit: cover;" alt="GOLD CLASS">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: linear-gradient(to top, rgba(255,255,255,0.95) 10%, transparent);"></div>
                <div class="position-absolute bottom-0 p-4">
                    <h3 class="fw-bold text-warning" style="letter-spacing: 2px;">GOLD CLASS</h3>
                    <p class="text-dark mb-0 small">Ghế bành da cao cấp ngả lưng 180 độ, phục vụ ẩm thực tại chỗ cùng không gian chờ thượng lưu.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #16 Khám Phá Thể Loại (Explore Genres) -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-warning border-start border-warning border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-warning"><i class="bi bi-grid-3x3-gap"></i></span>KHÁM PHÁ THỂ LOẠI
        </h2>
    </div>
    <div class="row g-3">
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card bg-white border-0 rounded-4 overflow-hidden h-100 text-center py-5 group-hover position-relative" style="background: url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=400') center/cover;">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: rgba(0,0,0,0.6);"></div>
                <h4 class="text-light fw-bold mb-0 position-relative z-1">HÀNH ĐỘNG</h4>
            </div>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card bg-white border-0 rounded-4 overflow-hidden h-100 text-center py-5 group-hover position-relative" style="background: url('https://images.unsplash.com/photo-1509281373149-e957c6296406?q=80&w=400') center/cover;">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: rgba(0,0,0,0.6);"></div>
                <h4 class="text-light fw-bold mb-0 position-relative z-1">KHOA HỌC</h4>
            </div>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card bg-white border-0 rounded-4 overflow-hidden h-100 text-center py-5 group-hover position-relative" style="background: url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=400') center/cover;">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: rgba(0,0,0,0.6);"></div>
                <h4 class="text-light fw-bold mb-0 position-relative z-1">TÌNH CẢM</h4>
            </div>
        </div>
        <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="card bg-white border-0 rounded-4 overflow-hidden h-100 text-center py-5 group-hover position-relative" style="background: url('https://images.unsplash.com/photo-1509347528160-9a9e33742cdb?q=80&w=400') center/cover;">
                <div class="position-absolute w-100 h-100 top-0 start-0" style="background: rgba(0,0,0,0.6);"></div>
                <h4 class="text-light fw-bold mb-0 position-relative z-1">KINH DỊ</h4>
            </div>
        </div>
    </div>
</div>

<!-- #17 Cụm Rạp Gần Bạn (Nearby Cinemas) -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="h4 text-success border-start border-success border-4 ps-3 fw-bold mb-0">
            <span class="section-icon section-icon-success"><i class="bi bi-geo-alt"></i></span>HỆ THỐNG RẠP CINEMAX
        </h2>
        <div>
            <button id="btnFindNearestCinema" class="btn btn-outline-success fw-bold rounded-pill me-2">
                <i class="bi bi-geo-fill me-1"></i> Tìm rạp gần tôi
            </button>
            <a href="/cinemas" class="text-success text-decoration-none small fw-bold">Xem toàn bộ <i class="bi bi-chevron-right"></i></a>
        </div>
    </div>
    
    <div id="nearbyCinemasContainer" class="row g-4">
        <!-- Rạp sẽ được load qua AJAX, tạm hiển thị tĩnh -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card bg-white border border-light rounded-4 p-4 h-100 hover-shadow transition-all group-hover">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light rounded-circle p-3 me-3"><i class="bi bi-building text-warning fs-3"></i></div>
                    <div>
                        <h5 class="text-dark fw-bold mb-1">CinemaX Landmark</h5>
                        <span class="badge bg-secondary text-light">TP. Hồ Chí Minh</span>
                    </div>
                </div>
                <p class="text-secondary small mb-4"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Tầng 8, Vincom Landmark 81, 720A Điện Biên Phủ, Quận Bình Thạnh.</p>
                <a href="/cinemas/cinemax-landmark" class="btn btn-outline-warning w-100 rounded-pill mt-auto">Xem lịch chiếu</a>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card bg-white border border-light rounded-4 p-4 h-100 hover-shadow transition-all group-hover">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light rounded-circle p-3 me-3"><i class="bi bi-building text-warning fs-3"></i></div>
                    <div>
                        <h5 class="text-dark fw-bold mb-1">CinemaX Lotte</h5>
                        <span class="badge bg-secondary text-light">Hà Nội</span>
                    </div>
                </div>
                <p class="text-secondary small mb-4"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Tầng 5, Lotte Center, 54 Liễu Giai, Quận Ba Đình.</p>
                <a href="/cinemas/cinemax-lotte" class="btn btn-outline-warning w-100 rounded-pill mt-auto">Xem lịch chiếu</a>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card bg-white border border-light rounded-4 p-4 h-100 hover-shadow transition-all group-hover">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light rounded-circle p-3 me-3"><i class="bi bi-building text-warning fs-3"></i></div>
                    <div>
                        <h5 class="text-dark fw-bold mb-1">CinemaX Vincom</h5>
                        <span class="badge bg-secondary text-light">Đà Nẵng</span>
                    </div>
                </div>
                <p class="text-secondary small mb-4"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Tầng 4, Vincom Center, 910A Ngô Quyền, Sơn Trà.</p>
                <a href="/cinemas/cinemax-vincom" class="btn btn-outline-warning w-100 rounded-pill mt-auto">Xem lịch chiếu</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnFindNearest = document.getElementById('btnFindNearestCinema');
    const container = document.getElementById('nearbyCinemasContainer');

    if (btnFindNearest) {
        btnFindNearest.addEventListener('click', function() {
            if (!navigator.geolocation) {
                alert('Trình duyệt của bạn không hỗ trợ định vị.');
                return;
            }

            // Đổi text thành loading
            const originalText = btnFindNearest.innerHTML;
            btnFindNearest.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang tìm...';
            btnFindNearest.disabled = true;

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    fetch(`/api/cinemas/nearest?lat=${lat}&lng=${lng}`)
                        .then(response => response.json())
                        .then(res => {
                            if (res.success && res.data.length > 0) {
                                container.innerHTML = '';
                                res.data.forEach((cinema, index) => {
                                    let distanceHtml = cinema.distance 
                                        ? `<span class="badge bg-danger ms-2"><i class="bi bi-geo-alt"></i> Cách ${cinema.distance} km</span>` 
                                        : '';
                                        
                                    const delay = (index + 1) * 100;
                                    
                                    const html = `
                                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="${delay}">
                                            <div class="card bg-white border border-light rounded-4 p-4 h-100 hover-shadow transition-all group-hover border-success shadow-sm">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="bg-success text-white rounded-circle p-3 me-3"><i class="bi bi-building fs-3"></i></div>
                                                    <div>
                                                        <h5 class="text-dark fw-bold mb-1">${cinema.name}</h5>
                                                        <span class="badge bg-secondary text-light">${cinema.province}</span>
                                                        ${distanceHtml}
                                                    </div>
                                                </div>
                                                <p class="text-secondary small mb-4"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>${cinema.address}</p>
                                                <a href="/cinemas/${cinema.slug}" class="btn btn-outline-warning w-100 rounded-pill mt-auto fw-bold">Xem lịch chiếu</a>
                                            </div>
                                        </div>
                                    `;
                                    container.insertAdjacentHTML('beforeend', html);
                                });
                            } else {
                                alert('Không tìm thấy rạp nào gần bạn.');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Có lỗi xảy ra khi tìm rạp gần nhất.');
                        })
                        .finally(() => {
                            btnFindNearest.innerHTML = originalText;
                            btnFindNearest.disabled = false;
                        });
                },
                function(error) {
                    btnFindNearest.innerHTML = originalText;
                    btnFindNearest.disabled = false;
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            alert("Bạn đã từ chối cấp quyền truy cập vị trí. Vui lòng cho phép quyền vị trí để sử dụng tính năng này.");
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert("Thông tin vị trí không khả dụng.");
                            break;
                        case error.TIMEOUT:
                            alert("Yêu cầu lấy vị trí quá thời gian.");
                            break;
                        default:
                            alert("Có lỗi không xác định xảy ra.");
                            break;
                    }
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        });
    }
});
</script>

<!-- #14 Đăng Ký Nhận Bản Tin -->
<div class="mb-5 py-5 rounded-4 text-center position-relative overflow-hidden shadow-lg" data-aos="zoom-in" style="background: url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1200&auto=format&fit=crop') center/cover; border: 1px solid #333;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.85);"></div>
    <div class="position-relative z-1 p-4">
        <h2 class="fw-bold text-warning mb-3"><i class="bi bi-envelope-paper-heart me-2"></i>Đừng Bỏ Lỡ Ưu Đãi!</h2>
        <p class="text-light fs-5 mb-4">Đăng ký nhận email để cập nhật lịch chiếu sớm nhất và mã giảm giá độc quyền.</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group input-group-lg border border-secondary rounded-pill overflow-hidden shadow">
                    <span class="input-group-text bg-white border-0 text-dark"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control bg-white border-0 text-dark shadow-none" placeholder="Nhập email của bạn..." style="outline: none;">
                    <button class="btn btn-warning fw-bold px-4">ĐĂNG KÝ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #11 Đối Tác Thanh Toán (Partners) -->
<div class="mb-5 py-4 border-top border-bottom border-secondary text-center" data-aos="fade-in">
    <h6 class="text-secondary text-uppercase mb-4 fw-bold">Đối Tác Đồng Hành</h6>
    <div class="d-flex justify-content-center gap-3 flex-wrap align-items-center opacity-75">
        <div class="payment-logo" data-aos="zoom-in" data-aos-delay="100">VISA</div>
        <div class="payment-logo payment-logo-momo" data-aos="zoom-in" data-aos-delay="200">MoMo</div>
        <div class="payment-logo payment-logo-zalo" data-aos="zoom-in" data-aos-delay="300">ZaloPay</div>
        <div class="payment-logo payment-logo-vnpay" data-aos="zoom-in" data-aos-delay="400">VNPay</div>
        <div class="payment-logo payment-logo-shopee" data-aos="zoom-in" data-aos-delay="500">ShopeePay</div>
    </div>
</div>

<style>
/* Custom local styles for the new elements */
.hero-slide {
    height: 500px;
}
@media (max-width: 768px) {
    .hero-slide {
        height: 350px;
    }
}
.group-hover:hover img {
    transform: scale(1.05);
}
.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #ffc107;
}
.section-icon {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.6rem;
    border-radius: 8px;
    vertical-align: middle;
    font-size: 1rem;
    line-height: 1;
    border: 1px solid currentColor;
    background: rgba(255, 255, 255, 0.04);
}
.section-icon-warning {
    color: #ffc107;
    background: rgba(255, 193, 7, 0.08);
}
.section-icon-info {
    color: #0dcaf0;
    background: rgba(13, 202, 240, 0.08);
}
.section-icon-success {
    color: #75b798;
    background: rgba(25, 135, 84, 0.08);
}
.section-icon-danger {
    color: #ea868f;
    background: rgba(220, 53, 69, 0.08);
}
.experience-icon {
    width: 52px;
    height: 52px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    border-radius: 12px;
    font-size: 1.45rem;
    border: 1px solid currentColor;
    background: rgba(255, 255, 255, 0.04);
}
.experience-icon-success {
    color: #75b798;
    background: rgba(25, 135, 84, 0.08);
}
.experience-icon-info {
    color: #6edff6;
    background: rgba(13, 202, 240, 0.08);
}
.experience-icon-danger {
    color: #ea868f;
    background: rgba(220, 53, 69, 0.08);
}
.payment-logo {
    min-width: 104px;
    padding: 0.65rem 0.9rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: #f1f1f1;
    color: #212529;
    font-weight: 800;
    letter-spacing: 0.04em;
    line-height: 1;
}
.payment-logo-momo { color: #e83e8c; }
.payment-logo-zalo { color: #6edff6; }
.payment-logo-vnpay { color: #79a7ff; }
.payment-logo-shopee { color: #ffc107; }
.rating-chip {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.55rem;
    border-radius: 999px;
    border: 1px solid rgba(255, 193, 7, 0.45);
    color: #ffc107;
    background: rgba(0, 0, 0, 0.55);
    font-size: 0.82rem;
    font-weight: 700;
}
</style>



