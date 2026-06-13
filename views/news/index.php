<?php // views/news/index.php ?>
<h2 class="text-warning fw-bold mb-4 border-start border-warning ps-3"><i class="bi bi-journal-text me-2"></i>Tin tức & Bài viết</h2>

<?php if (isset($featured) && $featured): ?>
<!-- Sticky Scroll Image Reveal -->
<div class="featured-scroll-sequence mb-5" style="height: 250vh; position: relative; margin-top: -1.5rem; width: 100vw; margin-left: calc(-50vw + 50%); overflow-x: hidden;">
    <!-- Sticky Image Container -->
    <div class="sticky-top w-100 rounded-4 overflow-hidden shadow-lg" style="height: 80vh; position: sticky; top: 10vh;">
        <img src="<?= htmlspecialchars($featured->image_url ?? 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=1920&auto=format&fit=crop') ?>"
             id="news-sticky-img"
             class="w-100 h-100" style="object-fit: cover; filter: brightness(0.6); transform-origin: center; transition: transform 0.1s ease-out;" 
             alt="<?= htmlspecialchars($featured->title) ?>"
             onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=1920&auto=format&fit=crop'">
    </div>
    
    <!-- Scrolling Content over the image -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none;">
        <div style="height: 100vh;"></div>
        <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
            <div class="bg-white p-5 rounded-4 shadow-lg text-center mx-3" style="max-width: 800px; pointer-events: auto;" data-aos="zoom-in-up">
                <span class="badge bg-danger text-white rounded-pill px-3 py-2 mb-3 fs-6 shadow-sm"><i class="bi bi-star-fill me-2"></i>Tiêu Điểm Đặc Biệt</span>
                <h1 class="display-5 fw-bold text-dark mb-4 lh-base"><?= htmlspecialchars($featured->title) ?></h1>
                <p class="lead text-secondary mb-4"><?= htmlspecialchars($featured->summary ?? '') ?></p>
                <div class="d-flex justify-content-center align-items-center gap-4 mb-4">
                    <span class="text-muted"><i class="bi bi-calendar3 me-2"></i><?= date('d/m/Y', strtotime($featured->created_at)) ?></span>
                    <span class="text-muted"><i class="bi bi-eye me-2"></i><?= rand(1000, 5000) ?> lượt xem</span>
                </div>
                <a href="/news/<?= htmlspecialchars($featured->slug) ?>" class="btn btn-warning btn-lg fw-bold px-5 py-3 rounded-pill shadow-sm">
                    Khám Phá Ngay <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('scroll', function() {
    const seq = document.querySelector('.featured-scroll-sequence');
    if(!seq) return;
    const rect = seq.getBoundingClientRect();
    let scrollPercent = 0;
    if (rect.top <= 0) {
        const maxScroll = rect.height - window.innerHeight;
        scrollPercent = Math.abs(rect.top) / maxScroll;
        if (scrollPercent > 1) scrollPercent = 1;
    }
    const scale = 1 + (scrollPercent * 0.4);
    const img = document.getElementById('news-sticky-img');
    if(img) {
        img.style.transform = `scale(${scale})`;
        img.style.filter = `brightness(${0.6 - (scrollPercent * 0.3)})`; 
    }
});
</script>
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
                <div class="card bg-white shadow-sm border-0 h-100 news-card overflow-hidden"
                     onclick="location.href='/news/<?= htmlspecialchars($article->slug) ?>'">
                    <img src="<?= htmlspecialchars($article->image_url ?? '/assets/images/default-news.jpg') ?>"
                         class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($article->title) ?>"
                         onerror="this.src='/assets/images/default-news.jpg'">
                    <div class="card-body">
                        <h5 class="text-dark fw-bold mb-2"><?= htmlspecialchars($article->title) ?></h5>
                        <p class="text-secondary small mb-0"><?= htmlspecialchars(mb_substr($article->summary ?? '', 0, 120)) ?>...</p>
                    </div>
                    <div class="card-footer bg-transparent border-top border-light">
                        <small class="text-secondary"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($article->created_at)) ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

