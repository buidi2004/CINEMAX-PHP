<?php
// Lấy URI hiện tại để active menu
$currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<nav class="col-md-3 col-lg-2 bg-black border-end border-secondary py-4 sidebar d-flex flex-column" style="min-height: 100vh;">
    <div class="position-sticky flex-grow-1">
        
        <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted text-uppercase"><span>Tổng quan</span></h6>
        <ul class="nav flex-column mb-3">
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/dashboard') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/dashboard">
                    <i class="bi bi-speedometer2 text-warning"></i> Bảng điều khiển
                </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/reports') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/reports">
                    <i class="bi bi-bar-chart-line text-info"></i> Báo cáo doanh thu
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted text-uppercase"><span>Kinh doanh</span></h6>
        <ul class="nav flex-column mb-3">
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/movies') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/movies">
                    <i class="bi bi-film text-primary"></i> Quản lý Phim
                </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/showtimes') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/showtimes">
                    <i class="bi bi-calendar-event text-danger"></i> Suất chiếu & Vé
                </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/food-beverages') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/food-beverages">
                    <i class="bi bi-cup-straw text-warning"></i> Combo Bắp Nước
                </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/promotions') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/promotions">
                    <i class="bi bi-ticket-perforated text-success"></i> Khuyến mãi
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted text-uppercase"><span>Rạp & Nội dung</span></h6>
        <ul class="nav flex-column mb-3">
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/cinemas') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/cinemas">
                    <i class="bi bi-building text-success"></i> Cụm Rạp & Phòng
                </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/news') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/news">
                    <i class="bi bi-newspaper text-info"></i> Tin tức / Blog
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted text-uppercase"><span>Khách hàng</span></h6>
        <ul class="nav flex-column mb-3">
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/users') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/users">
                    <i class="bi bi-people text-light"></i> Quản lý Users
                </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/reviews') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/reviews">
                    <i class="bi bi-star-half text-warning"></i> Đánh giá Phim
                </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/contacts') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/contacts">
                    <i class="bi bi-envelope text-primary"></i> Hỗ trợ (Feedback)
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted text-uppercase"><span>Hệ thống</span></h6>
        <ul class="nav flex-column mb-3">
            <li class="nav-item px-2">
                <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg <?= str_starts_with($currentUri, '/admin/settings') ? 'bg-secondary bg-opacity-25' : '' ?>" href="/admin/settings">
                    <i class="bi bi-gear text-secondary"></i> Cài đặt chung
                </a>
            </li>
        </ul>

    </div>
    
    <!-- Bottom section -->
    <div class="mt-auto px-3 pb-3">
        <hr class="border-secondary">
        <a class="nav-link text-light p-2 d-flex align-items-center gap-2 rounded hover-bg" href="/">
            <i class="bi bi-box-arrow-left text-secondary"></i>
            Về Trang chủ
        </a>
    </div>
</nav>

<!-- Thêm CSS inline cho hover effect -->
<style>
.hover-bg:hover { background-color: rgba(255,255,255,0.05); }
</style>
