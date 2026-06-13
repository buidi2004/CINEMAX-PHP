<?php
// views/news/detail.php
?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-transparent p-0">
        <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="/news" class="text-warning text-decoration-none">Tin tức</a></li>
        <li class="breadcrumb-item active text-secondary"><?= htmlspecialchars($article->title) ?></li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="news-detail-container">
            <h1 class="text-light fw-bold mb-3"><?= htmlspecialchars($article->title) ?></h1>
            <div class="d-flex align-items-center text-secondary small mb-4 pb-3 border-bottom border-secondary">
                <i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y', strtotime($article->created_at)) ?>
            </div>

            <?php if (!empty($article->image_url)): ?>
            <div class="mb-5 rounded-4 overflow-hidden shadow-lg">
                <img src="<?= htmlspecialchars($article->image_url) ?>" class="img-fluid w-100" style="object-fit: cover; max-height: 500px;" alt="<?= htmlspecialchars($article->title) ?>">
            </div>
            <?php endif; ?>

            <div class="article-content text-light" style="line-height: 1.8; font-size: 1.1rem;">
                <?= nl2br(htmlspecialchars($article->content)) ?>
            </div>

            <!-- Nút share -->
            <div class="mt-5 pt-4 border-top border-secondary d-flex justify-content-between align-items-center">
                <h6 class="text-secondary mb-0">Chia sẻ bài viết:</h6>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></button>
                    <button class="btn btn-outline-info rounded-circle"><i class="bi bi-twitter-x"></i></button>
                    <button class="btn btn-outline-success rounded-circle" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã copy link!');"><i class="bi bi-link-45deg"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
