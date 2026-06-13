<?php // views/search/index.php ?>
<div class="search-hero text-center py-5 mb-5" data-aos="fade-down">
    <h2 class="text-warning fw-bold mb-4"><i class="bi bi-search me-2"></i>Tìm kiếm phim, rạp, suất chiếu</h2>
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="zoom-in" data-aos-delay="200">
            <form method="GET" action="/search">
                <div class="input-group input-group-lg search-bar-glow">
                    <span class="input-group-text bg-dark border-warning border-end-0 text-warning"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control bg-dark border-warning text-light fs-6"
                           placeholder="Nhập tên phim, thể loại..." value="<?= htmlspecialchars($query ?? '') ?>" autocomplete="off">
                    <button type="submit" class="btn btn-warning fw-bold px-4">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center mt-4" data-aos="fade-up" data-aos-delay="300">
        <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <?php
                $genres = ['Hành động','Hài','Kinh dị','Tình cảm','Hoạt hình','Khoa học viễn tưởng'];
                foreach ($genres as $index => $g): ?>
                    <a href="/search?q=<?= urlencode($g) ?>" class="btn btn-sm btn-outline-secondary rounded-pill" data-aos="flip-up" data-aos-delay="<?= 400 + ($index * 50) ?>"><?= $g ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($query) && strlen($query) > 0): ?>
    <h5 class="text-light mb-4" data-aos="fade-right">
        Kết quả cho "<span class="text-warning"><?= htmlspecialchars($query) ?></span>"
        <span class="text-secondary">(<?= count($results ?? []) ?> kết quả)</span>
    </h5>

    <?php if (empty($results)): ?>
        <div class="text-center py-5" data-aos="fade-in">
            <i class="bi bi-search fs-1 text-secondary opacity-50"></i>
            <p class="text-secondary mt-3 fs-5">Không tìm thấy kết quả phù hợp</p>
            <p class="text-secondary">Thử tìm kiếm với từ khóa khác</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
            <?php foreach ($results as $index => $movie): ?>
                <div class="col" data-aos="zoom-in-up" data-aos-delay="<?= ($index % 5) * 100 ?>">
                    <div class="movie-card-3d h-100">
                        <div class="card bg-secondary border-0 h-100 shadow movie-card search-result-card"
                             onclick="location.href='/movies/<?= $movie->id ?>'">
                            <div class="position-relative">
                                <img src="<?= htmlspecialchars($movie->poster_url ?: '/assets/images/no-poster.jpg') ?>"
                                     class="card-img-top img-fluid rounded-top" alt="<?= htmlspecialchars($movie->title) ?>"
                                     style="height: 280px; object-fit: cover;"
                                     onerror="this.src='/assets/images/no-poster.jpg'">
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2"><?= htmlspecialchars($movie->age_rating ?? 'P') ?></span>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title text-light mb-1 text-truncate"><?= htmlspecialchars($movie->title) ?></h6>
                                <small class="text-secondary"><i class="bi bi-tags me-1"></i><?= htmlspecialchars($movie->genre ?? '') ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
