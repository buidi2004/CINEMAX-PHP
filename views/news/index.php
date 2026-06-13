<?php // views/news/index.php ?>
<h2 class="text-warning fw-bold mb-4 border-start border-warning ps-3"><i class="bi bi-journal-text me-2"></i>Tin tức & Bài viết</h2>

<?php if (isset($featured) && $featured): ?>
    <div class="card bg-dark border-0 shadow-lg mb-5 overflow-hidden featured-news-card"
         onclick="location.href='/news/<?= htmlspecialchars($featured->slug) ?>'">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($featured->image_url ?? '/assets/images/default-news.jpg') ?>"
                     class="w-100 h-100" style="object-fit: cover; min-height: 300px;" alt="<?= htmlspecialchars($featured->title) ?>"
                     onerror="this.src='/assets/images/default-news.jpg'">
            </div>
            <div class="col-md-6 p-4 d-flex flex-column justify-content-center">
                <span class="badge bg-warning text-dark rounded-pill mb-2 align-self-start"><i class="bi bi-bookmark-check me-1"></i>Nổi bật</span>
                <h3 class="text-light fw-bold"><?= htmlspecialchars($featured->title) ?></h3>
                <p class="text-secondary"><?= htmlspecialchars($featured->summary ?? '') ?></p>
                <small class="text-secondary">
                    <i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($featured->created_at)) ?>
                </small>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (empty($articles)): ?>
    <div class="text-center py-5">
        <i class="bi bi-journal-text fs-1 text-secondary opacity-50"></i>
        <p class="text-secondary mt-3 fs-5">Chưa có bài viết nào</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($articles as $article): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card bg-dark border-0 h-100 news-card overflow-hidden"
                     onclick="location.href='/news/<?= htmlspecialchars($article->slug) ?>'">
                    <img src="<?= htmlspecialchars($article->image_url ?? '/assets/images/default-news.jpg') ?>"
                         class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($article->title) ?>"
                         onerror="this.src='/assets/images/default-news.jpg'">
                    <div class="card-body">
                        <h5 class="text-light fw-bold mb-2"><?= htmlspecialchars($article->title) ?></h5>
                        <p class="text-secondary small mb-0"><?= htmlspecialchars(mb_substr($article->summary ?? '', 0, 120)) ?>...</p>
                    </div>
                    <div class="card-footer bg-transparent border-top border-secondary">
                        <small class="text-secondary"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($article->created_at)) ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
