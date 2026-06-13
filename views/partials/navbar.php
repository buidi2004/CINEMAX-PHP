<?php
// views/partials/navbar.php
use App\Core\Session;

$currentUserId = Session::get('user_id');
$currentRole   = Session::get('user_role');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning fs-3" href="/">
            <?php if(!empty($appSettings['site_logo'])): ?>
                <img src="<?= htmlspecialchars($appSettings['site_logo']) ?>" alt="Logo" style="height: 32px; margin-right: 8px;">
            <?php else: ?>
                <i class="bi bi-film"></i>
            <?php endif; ?>
            <?= htmlspecialchars($appSettings['site_name'] ?? 'CinemaX') ?>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/movies">Phim đang chiếu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/movies?status=coming_soon">Phim sắp chiếu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cinemas">
                        <i class="bi bi-geo-alt me-1"></i>Hệ thống rạp
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/promotions">
                        <i class="bi bi-tag me-1"></i>Ưu đãi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/news">
                        <i class="bi bi-newspaper me-1"></i>Tin tức
                    </a>
                </li>
            </ul>

            <!-- Search mini -->
            <form class="d-flex me-3 d-none d-lg-flex" action="/search" method="GET">
                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control bg-light border-light text-dark" placeholder="Tìm phim..." style="width: 160px;">
                    <button type="submit" class="btn btn-outline-warning btn-sm"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <?php if ($currentUserId): ?>
                    <?php if ($currentRole === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-semibold me-2" href="/admin/dashboard">
                                <i class="bi bi-speedometer2"></i> Admin Panel
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= htmlspecialchars(Session::get('user_avatar') ?: '/assets/images/default-avatar.png') ?>"
                                 class="rounded-circle" width="28" height="28" style="object-fit: cover;"
                                 alt="avatar" onerror="this.src='/assets/images/default-avatar.png'">
                            <span class="d-none d-lg-inline"><?= htmlspecialchars(Session::get('user_name') ?: 'Tài khoản') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="/profile">
                                    <i class="bi bi-person me-2"></i>Hồ sơ
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/my-tickets">
                                    <i class="bi bi-ticket-perforated me-2"></i>Vé của tôi
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/profile/transactions">
                                    <i class="bi bi-receipt me-2"></i>Lịch sử giao dịch
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="/logout">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark me-3" href="/login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-warning fw-semibold" href="/register">Đăng ký</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

