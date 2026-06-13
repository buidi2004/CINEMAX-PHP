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
            <div class="position-relative" style="height: 500px;">
                <img src="/assets/images/slide1.jpg" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);" alt="Slide 1" onerror="this.src='https://placehold.co/1200x500/1a1a3e/fff?text=AVENGERS:+ENDGAME'">
                <div class="carousel-caption d-none d-md-block text-start bottom-0 pb-5 ps-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.9)); left: 0; right: 0;">
                    <span class="badge bg-danger mb-2 px-3 py-2 fs-6" data-aos="fade-up" data-aos-delay="200">ĐANG CHIẾU</span>
                    <h1 class="display-4 fw-bold text-warning text-shadow" data-aos="fade-up" data-aos-delay="400">AVENGERS: ENDGAME</h1>
                    <p class="fs-5 text-light" data-aos="fade-up" data-aos-delay="600">Trận chiến cuối cùng của các siêu anh hùng. Khởi chiếu 26/04/2026.</p>
                    <div class="mt-3" data-aos="fade-up" data-aos-delay="800">
                        <a href="/movies/1" class="btn btn-warning btn-lg fw-bold px-4 rounded-pill me-2"><i class="bi bi-ticket-perforated me-2"></i>Đặt Vé Ngay</a>
                        <button class="btn btn-outline-light btn-lg rounded-pill px-4"><i class="bi bi-play-circle me-2"></i>Xem Trailer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="position-relative" style="height: 500px;">
                <img src="/assets/images/slide2.jpg" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);" alt="Slide 2" onerror="this.src='https://placehold.co/1200x500/0a0a14/fff?text=DUNE:+PART+TWO'">
                <div class="carousel-caption d-none d-md-block text-start bottom-0 pb-5 ps-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.9)); left: 0; right: 0;">
                    <span class="badge bg-info mb-2 px-3 py-2 fs-6 text-dark">SẮP CHIẾU</span>
                    <h1 class="display-4 fw-bold text-light text-shadow">DUNE: PART TWO</h1>
                    <p class="fs-5 text-secondary">Hành trình vĩ đại trên hành tinh cát. Trải nghiệm định dạng IMAX.</p>
                    <div class="mt-3">
                        <button class="btn btn-outline-info btn-lg rounded-pill px-4"><i class="bi bi-info-circle me-2"></i>Tìm Hiểu Thêm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
            <div class="position-relative" style="height: 500px;">
                <img src="/assets/images/slide3.jpg" class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6);" alt="Slide 3" onerror="this.src='https://placehold.co/1200x500/16213e/fff?text=SPIDER-MAN'">
                <div class="carousel-caption d-none d-md-block text-start bottom-0 pb-5 ps-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.9)); left: 0; right: 0;">
                    <span class="badge bg-danger mb-2 px-3 py-2 fs-6">ĐANG CHIẾU</span>
                    <h1 class="display-4 fw-bold text-warning text-shadow">SPIDER-MAN: NO WAY HOME</h1>
                    <p class="fs-5 text-light">Đa vũ trụ mở ra. Đừng bỏ lỡ siêu phẩm Marvel.</p>
                    <div class="mt-3">
                        <a href="/movies/2" class="btn btn-warning btn-lg fw-bold px-4 rounded-pill me-2"><i class="bi bi-ticket-perforated me-2"></i>Đặt Vé Ngay</a>
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
<div class="card bg-dark border-0 shadow-lg mb-5 rounded-4 overflow-hidden quick-book-bar" data-aos="fade-up" data-aos-delay="200" style="border: 1px solid rgba(255,193,7,0.3) !important; transform: translateY(-30px); position: relative; z-index: 10;">
    <div class="card-body p-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-warning fw-bold small"><i class="bi bi-film me-1"></i>Chọn Phim</label>
                <select class="form-select bg-secondary border-0 text-light rounded-pill">
                    <option>-- Chọn phim --</option>
                    <?php foreach ($nowShowing ?? [] as $m): ?>
                        <option value="<?= $m->id ?>"><?= htmlspecialchars($m->title) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-warning fw-bold small"><i class="bi bi-geo-alt me-1"></i>Chọn Rạp</label>
                <select class="form-select bg-secondary border-0 text-light rounded-pill">
                    <option>-- Chọn rạp --</option>
                    <option>CinemaX Quận 1</option>
                    <option>CinemaX Gò Vấp</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-warning fw-bold small"><i class="bi bi-calendar3 me-1"></i>Ngày chiếu</label>
                <input type="date" class="form-control bg-secondary border-0 text-light rounded-pill" value="<?= date('Y-m-d') ?>">
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
                <div class="card bg-black border-0 shadow-lg movie-card rounded-4 overflow-hidden position-relative" onclick="location.href='/movies/<?= $movie->id ?>'">
                    <img src="<?= htmlspecialchars($movie->posterUrl ?: 'https://placehold.co/400x600/111/fff') ?>" 
                         class="w-100" style="height: 500px; object-fit: cover;" alt="<?= htmlspecialchars($movie->title) ?>">
                    <div class="position-absolute bottom-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.95), transparent);">
                        <h4 class="text-light fw-bold mb-1 text-truncate"><?= htmlspecialchars($movie->title) ?></h4>
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
                        <div class="card bg-black border border-secondary h-100 shadow movie-card"
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
                            <div class="card-body p-3 bg-black">
                                <h6 class="card-title text-light mb-2 text-truncate fw-bold">
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
                        <div class="card bg-black border border-secondary h-100 shadow movie-card"
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
                            <div class="card-body p-3 bg-black">
                                <h6 class="card-title text-light mb-2 text-truncate fw-bold">
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
            <div class="card bg-dark border-0 overflow-hidden rounded-4 h-100 shadow-lg position-relative group-hover">
                <img src="https://placehold.co/800x400/2a1a1a/e5a720?text=Combo+Avatar" class="w-100 h-100 transition-all" style="object-fit: cover;" alt="Combo Avatar">
                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.9));">
                    <h4 class="text-warning fw-bold mb-1">Avatar: The Way of Water Combo</h4>
                    <p class="text-light mb-2">1 Ly nước tạo hình + 1 Bắp khổng lồ + Tặng kèm Postcard</p>
                    <strong class="text-danger fs-5">299.000₫</strong>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-4 h-100">
                <div class="col-12 h-50" data-aos="fade-down">
                    <div class="card bg-dark border-0 overflow-hidden rounded-4 h-100 shadow position-relative group-hover">
                        <img src="https://placehold.co/800x200/1f1f1f/fff?text=Combo+Couple" class="w-100 h-100 transition-all" style="object-fit: cover;" alt="Combo Couple">
                        <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <h5 class="text-light fw-bold mb-0">Combo Couple (2 Nước + 1 Bắp)</h5>
                            <strong class="text-warning">109.000₫</strong>
                        </div>
                    </div>
                </div>
                <div class="col-12 h-50" data-aos="fade-up">
                    <div class="card bg-dark border-0 overflow-hidden rounded-4 h-100 shadow position-relative group-hover">
                        <img src="https://placehold.co/800x200/111/fff?text=Dune+Merchandise" class="w-100 h-100 transition-all" style="object-fit: cover;" alt="Dune Merch">
                        <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <h5 class="text-light fw-bold mb-0">Exclusive Dune Sandworm Bucket</h5>
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
                <div class="card promo-card bg-dark border-0 overflow-hidden h-100" onclick="location.href='/promotions/<?= $promo->id ?>'">
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
            <div class="p-4 rounded-4 bg-dark border border-secondary experience-card h-100 transition-all">
                <span class="experience-icon experience-icon-success"><i class="bi bi-volume-up"></i></span>
                <h5 class="text-light fw-bold">Âm Thanh Dolby Atmos</h5>
                <p class="text-secondary small">Hệ thống âm thanh vòm sống động, chi tiết đến từng nhịp đập, đưa bạn vào thế giới phim.</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="p-4 rounded-4 bg-dark border border-secondary experience-card h-100 transition-all">
                <span class="experience-icon experience-icon-info"><i class="bi bi-aspect-ratio"></i></span>
                <h5 class="text-light fw-bold">Màn Hình IMAX Khổng Lồ</h5>
                <p class="text-secondary small">Hình ảnh sắc nét, độ sáng vượt trội, trường nhìn bao quát toàn bộ tầm mắt.</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="p-4 rounded-4 bg-dark border border-secondary experience-card h-100 transition-all">
                <span class="experience-icon experience-icon-danger"><i class="bi bi-people"></i></span>
                <h5 class="text-light fw-bold">Ghế Đôi Sweetbox</h5>
                <p class="text-secondary small">Không gian riêng tư lý tưởng dành cho các cặp đôi với vách ngăn cao cấp.</p>
            </div>
        </div>
    </div>
</div>

<!-- #10 Tải Ứng Dụng (App Download) - NEW SECTION -->
<div class="mb-5 pt-5 pb-5 mt-5 rounded-5 shadow-lg position-relative overflow-hidden" data-aos="fade-up" style="background: linear-gradient(135deg, #111 0%, #2a1a3e 100%); border: 1px solid #333;">
    <div class="row align-items-center position-relative z-1">
        <div class="col-md-6 p-5 text-center text-md-start">
            <h2 class="display-5 fw-bold text-light mb-3" data-aos="fade-right">CinemaX App</h2>
            <p class="fs-5 text-secondary mb-4" data-aos="fade-right" data-aos-delay="100">Đặt vé nhanh hơn, nhận nhiều ưu đãi độc quyền chỉ có trên ứng dụng điện thoại. Tải ngay!</p>
            <div class="d-flex justify-content-center justify-content-md-start gap-3" data-aos="fade-right" data-aos-delay="200">
                <button class="btn btn-outline-light rounded-pill px-4 py-2 fs-5"><i class="bi bi-apple me-2"></i>App Store</button>
                <button class="btn btn-outline-light rounded-pill px-4 py-2 fs-5"><i class="bi bi-google-play me-2"></i>Google Play</button>
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
                <div class="card bg-dark border-0 h-100 news-card overflow-hidden" onclick="location.href='/news/<?= htmlspecialchars($n->slug) ?>'">
                    <img src="<?= htmlspecialchars($n->image_url ?: 'https://placehold.co/600x300/1a1a3e/fff?text=News') ?>" class="card-img-top transition-all" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($n->title) ?>">
                    <div class="card-body">
                        <span class="badge bg-secondary rounded-pill mb-2"><?= htmlspecialchars($n->category) ?></span>
                        <h6 class="text-light fw-bold mb-2"><?= htmlspecialchars($n->title) ?></h6>
                        <small class="text-secondary"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($n->published_at)) ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- #12 Chương Trình Thành Viên -->
<div class="mb-5 pt-5 pb-5 rounded-4 shadow-lg overflow-hidden position-relative" data-aos="fade-up" style="background: linear-gradient(45deg, #1a1a2e 0%, #16213e 100%);">
    <div class="row align-items-center position-relative z-1 px-4">
        <div class="col-lg-5 text-center text-lg-start mb-4 mb-lg-0">
            <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-bold rounded-pill"><i class="bi bi-star-fill me-1"></i> CINEMAX CLUB</span>
            <h2 class="display-6 fw-bold text-light mb-3">Đặc Quyền Thành Viên</h2>
            <p class="fs-5 text-secondary mb-4">Tích điểm đổi quà, nhân đôi ưu đãi vào ngày lễ, trải nghiệm phòng chờ VIP và nhận vé xem phim miễn phí vào tháng sinh nhật.</p>
            <button class="btn btn-warning btn-lg rounded-pill px-5 fw-bold hover-shadow">ĐĂNG KÝ NGAY</button>
        </div>
        <div class="col-lg-7">
            <div class="row g-3">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card bg-dark border border-secondary rounded-4 h-100 text-center p-3 transition-all group-hover member-card">
                        <div class="text-secondary mb-2 fs-1"><i class="bi bi-award-fill"></i></div>
                        <h5 class="text-light fw-bold">Silver</h5>
                        <p class="small text-secondary mb-0">Tích lũy 5% giá trị. Tặng 1 bắp ngọt tháng sinh nhật.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card bg-dark border border-warning rounded-4 h-100 text-center p-3 transition-all group-hover member-card" style="box-shadow: 0 0 15px rgba(255,193,7,0.2);">
                        <div class="text-warning mb-2 fs-1"><i class="bi bi-award-fill"></i></div>
                        <h5 class="text-warning fw-bold">Gold</h5>
                        <p class="small text-secondary mb-0">Tích lũy 10% giá trị. Tặng 1 vé 2D tháng sinh nhật.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card bg-dark border border-info rounded-4 h-100 text-center p-3 transition-all group-hover member-card">
                        <div class="text-info mb-2 fs-1"><i class="bi bi-award-fill"></i></div>
                        <h5 class="text-info fw-bold">Platinum</h5>
                        <p class="small text-secondary mb-0">Tích lũy 15% giá trị. Sử dụng phòng chờ VIP miễn phí.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #13 Đánh Giá Khách Hàng -->
<div class="mb-5 pt-4" data-aos="fade-up">
    <div class="d-flex justify-content-center align-items-center mb-5 text-center">
        <h2 class="h3 text-light fw-bold mb-0 position-relative d-inline-block">
            Ý KIẾN KHÁCH HÀNG
            <div class="position-absolute w-50 border-bottom border-warning border-3 mt-2" style="left: 25%;"></div>
        </h2>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card bg-dark border-0 rounded-4 p-4 h-100 shadow position-relative group-hover feedback-card">
                <i class="bi bi-quote position-absolute text-warning opacity-25" style="font-size: 5rem; top: -10px; right: 20px;"></i>
                <div class="d-flex align-items-center mb-3">
                    <img src="https://placehold.co/60x60/333/fff?text=T" class="rounded-circle me-3 border border-2 border-warning" alt="User">
                    <div>
                        <h6 class="text-light fw-bold mb-0">Anh Tuấn</h6>
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                </div>
                <p class="text-secondary fst-italic">"Rạp sạch sẽ, nhân viên cực kỳ nhiệt tình. Âm thanh IMAX ở đây là đỉnh nhất tôi từng trải nghiệm tại Việt Nam!"</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card bg-dark border-0 rounded-4 p-4 h-100 shadow position-relative group-hover feedback-card">
                <i class="bi bi-quote position-absolute text-warning opacity-25" style="font-size: 5rem; top: -10px; right: 20px;"></i>
                <div class="d-flex align-items-center mb-3">
                    <img src="https://placehold.co/60x60/333/fff?text=H" class="rounded-circle me-3 border border-2 border-warning" alt="User">
                    <div>
                        <h6 class="text-light fw-bold mb-0">Mai Hương</h6>
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        </div>
                    </div>
                </div>
                <p class="text-secondary fst-italic">"Bắp rang bơ phô mai ngon xuất sắc. Ghế ngồi thoải mái, khoảng cách giữa các hàng ghế rộng rãi không bị gò bó."</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card bg-dark border-0 rounded-4 p-4 h-100 shadow position-relative group-hover feedback-card">
                <i class="bi bi-quote position-absolute text-warning opacity-25" style="font-size: 5rem; top: -10px; right: 20px;"></i>
                <div class="d-flex align-items-center mb-3">
                    <img src="https://placehold.co/60x60/333/fff?text=N" class="rounded-circle me-3 border border-2 border-warning" alt="User">
                    <div>
                        <h6 class="text-light fw-bold mb-0">Hoàng Nam</h6>
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                </div>
                <p class="text-secondary fst-italic">"Tính năng đặt vé trên app cực nhanh và mượt. Ưu đãi thành viên Gold rất hời. Sẽ luôn ủng hộ CinemaX!"</p>
            </div>
        </div>
    </div>
</div>

<!-- #14 Đăng Ký Nhận Bản Tin -->
<div class="mb-5 py-5 rounded-4 text-center position-relative overflow-hidden shadow-lg" data-aos="zoom-in" style="background: url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1200&auto=format&fit=crop') center/cover; border: 1px solid #333;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.85);"></div>
    <div class="position-relative z-1 p-4">
        <h2 class="fw-bold text-warning mb-3"><i class="bi bi-envelope-paper-heart me-2"></i>Đừng Bỏ Lỡ Ưu Đãi!</h2>
        <p class="text-light fs-5 mb-4">Đăng ký nhận email để cập nhật lịch chiếu sớm nhất và mã giảm giá độc quyền.</p>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group input-group-lg border border-secondary rounded-pill overflow-hidden shadow">
                    <span class="input-group-text bg-dark border-0 text-secondary"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control bg-dark border-0 text-light shadow-none" placeholder="Nhập email của bạn..." style="outline: none;">
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
.group-hover:hover img {
    transform: scale(1.05);
}
.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #111;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #333;
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
    border: 1px solid #343a40;
    border-radius: 8px;
    background: #111;
    color: #f8f9fa;
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
