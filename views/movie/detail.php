<?php
// views/movie/detail.php
?>
<div class="row g-4 mb-5">
    <!-- Cột trái: Poster với 3D tilt -->
    <div class="col-md-4 col-lg-3 text-center text-md-start">
        <div class="movie-card-3d">
            <img src="<?= htmlspecialchars($movie->posterUrl ?: 'https://placehold.co/400x600/111/fff?text=No+Poster') ?>"
                 class="img-fluid rounded shadow-lg border border-light movie-card"
                 alt="<?= htmlspecialchars($movie->title) ?>"
                 data-tilt
                 style="max-height: 420px; object-fit: cover; width: 100%;">
        </div>
    </div>

    <!-- Cột phải: Thông tin chi tiết -->
    <div class="col-md-8 col-lg-9">
        <h1 class="display-5 fw-bold text-dark mb-3"><?= htmlspecialchars($movie->title) ?></h1>
        
        <div class="d-flex flex-wrap gap-2 mb-4">
            <?php if ($movie->ageRating): ?>
                <span class="badge badge-<?= strtolower($movie->ageRating) ?> fs-6 p-2 rounded">
                    <?= htmlspecialchars($movie->ageRating) ?>
                </span>
            <?php endif; ?>
            <span class="badge bg-secondary fs-6 p-2 rounded">
                <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($movie->formattedDuration) ?>
            </span>
            <?php if ($movie->genre): ?>
                <span class="badge bg-secondary fs-6 p-2 rounded">
                    <i class="bi bi-tag-fill me-1"></i> <?= htmlspecialchars($movie->genre) ?>
                </span>
            <?php endif; ?>
            <span class="badge bg-white shadow-sm border border-light text-warning fs-6 p-2 rounded">
                <?= $movie->status === 'now_showing' ? 'Đang chiếu' : ($movie->status === 'coming_soon' ? 'Sắp chiếu' : 'Đã kết thúc') ?>
            </span>
        </div>

        <h5 class="text-warning border-start border-warning border-3 ps-2 mb-2 fw-bold">Mô tả phim</h5>
        <p class="text-dark-50 lh-lg mb-4" style="text-align: justify; color: #ced4da;">
            <?= nl2br(htmlspecialchars($movie->description ?: 'Chưa có thông tin mô tả chi tiết cho bộ phim này.')) ?>
        </p>
    </div>
</div>

<!-- #7 Lịch chiếu trượt ngang + #8 Thẻ suất chiếu đẹp -->
<div class="card bg-white border border-light rounded p-4 shadow-lg">
    <h3 class="h4 text-warning border-start border-warning border-4 ps-3 fw-bold mb-4">
        <i class="bi bi-calendar3 me-2"></i>LỊCH CHIẾU & SUẤT CHIẾU
    </h3>

    <!-- #7 Date slider — Trượt ngang, scrollbar ẩn -->
    <div class="date-slider mb-4 pb-3 border-bottom border-light">
        <?php
        $daysOfWeek = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
        for ($i = 0; $i < 7; $i++):
            $timestamp = strtotime("+$i days");
            $dateVal = date('Y-m-d', $timestamp);
            $dayLabel = ($i === 0) ? 'Hôm nay' : $daysOfWeek[date('w', $timestamp)];
            $dayNumber = date('d', $timestamp);
            $monthLabel = 'Th' . date('n', $timestamp);
            $activeClass = ($dateVal === $selectedDate) ? 'active' : '';
        ?>
            <a href="/movies/<?= $movie->id ?>?date=<?= $dateVal ?>"
               class="date-item <?= $activeClass ?>">
                <span class="day-name"><?= $dayLabel ?></span>
                <span class="day-number"><?= $dayNumber ?></span>
                <span class="day-name"><?= $monthLabel ?></span>
            </a>
        <?php endfor; ?>
    </div>

    <!-- #8 Showtime cards -->
    <div class="showtimes-container">
        <?php if ($movie->status !== 'now_showing'): ?>
            <div class="text-center py-4 text-secondary">
                <i class="bi bi-calendar-x display-6 mb-2 d-block"></i>
                Phim hiện không ở trạng thái "Đang chiếu" nên không có suất chiếu.
            </div>
        <?php elseif (empty($movie->showtimes)): ?>
            <div class="text-center py-4 text-secondary">
                <i class="bi bi-clock-history display-6 mb-2 d-block"></i>
                Không có suất chiếu nào vào ngày <?= date('d/m/Y', strtotime($selectedDate)) ?>. Vui lòng chọn ngày khác.
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                <?php foreach ($movie->showtimes as $showtime): ?>
                    <div class="col">
                        <div class="showtime-card">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="room-badge">
                                        <?= htmlspecialchars($showtime->roomName) ?>
                                    </span>
                                    <span class="seats-left <?= $showtime->availableSeats <= 20 ? 'low' : '' ?>">
                                        <i class="bi bi-people-fill me-1"></i><?= $showtime->availableSeats ?> ghế trống
                                    </span>
                                </div>
                                <div class="time"><?= date('H:i', strtotime($showtime->startTime)) ?></div>
                                <div class="price"><?= htmlspecialchars($showtime->formattedPrice) ?></div>
                            </div>
                            <a href="/booking/<?= $showtime->id ?>"
                               class="btn btn-warning w-100 fw-bold btn-select-showtime <?= $showtime->availableSeats === 0 ? 'disabled btn-secondary text-muted' : '' ?>">
                                <?= $showtime->availableSeats === 0 ? 'Hết vé' : 'Chọn ghế' ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- #9 Reviews Section -->
<div class="card bg-white border border-light rounded p-4 shadow-lg mt-4">
    <h3 class="h4 text-warning border-start border-warning border-4 ps-3 fw-bold mb-4">
        <i class="bi bi-star-fill me-2"></i>ĐÁNH GIÁ PHIM
    </h3>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST" action="/reviews" class="mb-4 bg-white shadow-sm p-3 rounded border border-light">
            <?= csrf_field() ?>
            <input type="hidden" name="movie_id" value="<?= $movie->id ?>">
            <div class="mb-3">
                <label class="form-label text-dark">Đánh giá của bạn</label>
                <select name="rating" class="form-select bg-white text-warning border-light" style="width: auto;">
                    <option value="5">★★★★★ (5 sao) - Tuyệt vời</option>
                    <option value="4">★★★★☆ (4 sao) - Rất tốt</option>
                    <option value="3">★★★☆☆ (3 sao) - Khá</option>
                    <option value="2">★★☆☆☆ (2 sao) - Trung bình</option>
                    <option value="1">★☆☆☆☆ (1 sao) - Tệ</option>
                </select>
            </div>
            <div class="mb-3">
                <textarea name="comment" class="form-control bg-white text-dark border-light" rows="3" placeholder="Chia sẻ cảm nghĩ của bạn về bộ phim này..." required></textarea>
            </div>
            <button type="submit" class="btn btn-warning"><i class="bi bi-send me-1"></i> Gửi đánh giá</button>
        </form>
    <?php else: ?>
        <div class="alert bg-white shadow-sm text-dark border-light">
            Vui lòng <a href="/login" class="text-warning text-decoration-none fw-bold">đăng nhập</a> để viết đánh giá cho bộ phim này.
        </div>
    <?php endif; ?>

    <div class="reviews-list mt-4">
        <?php if (empty($reviews)): ?>
            <p class="text-secondary text-center py-3"><i class="bi bi-chat-square-text me-2"></i>Chưa có đánh giá nào cho phim này.</p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item border-bottom border-light pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong class="text-dark"><i class="bi bi-person-circle me-2 text-secondary"></i><?= htmlspecialchars($review['user_name']) ?></strong>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></small>
                    </div>
                    <div class="text-warning mb-2">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-dark-50 mb-0" style="color: #adb5bd;"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


